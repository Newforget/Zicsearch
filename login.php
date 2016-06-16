<?php
require_once 'inc/functions.php';
reconnect_from_cookie();
if(isset($_SESSION['auth'])){
    header('Location: account.php');
    exit();
}
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once 'inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    //var_dump($user);die;
    if(password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
    if($_POST['remember']){
        $remember_token = str_random(250);
        $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
        setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
}
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}
?>

<head>  
    <link href="css/style_log.css" rel="stylesheet">
</head>

<?php require 'inc/header.php'; ?>

    <div class="bloc_login">
    <h1>Se connecter<img src="source/logo_login.png"></h1><br>

      <form action="" method="POST">
        <input type="text" name="username" placeholder="Pseudo ou email">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="submit" name="login" class="login login-submit" value="login">
      </form>  
      <div class="login-help">
        <a href="register.php">S'enregistrer</a> • <a href="forget.php">Mot de passe perdu</a>
      </div>
  </div>

<?php require 'inc/footer.php'; ?>