<?php
require_once 'inc/functions.php';
session_start();
if(!empty($_POST)){

    $errors = array();
    require_once 'inc/db.php';

    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumérique)";
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = 'Ce pseudo est déjà pris';
        }
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }

if(empty($errors)){

    $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $token = str_random(60);
    $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
    $user_id = $pdo->lastInsertId();
    mail($_POST['email'], "Confirmation de votre compte", "Cliquer sur ce lien pour confirmer votre compte\n\nhttp://localhost:8888/zicsearch/confirm.php?id=$user_id&token=$token");
    $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
    header('Location: login.php');
    exit();
}


}
?>

<?php require 'inc/header.php'; ?>

<head>  
    <link href="css/style_log.css" rel="stylesheet">
</head>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach($errors as $error): ?>
           <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="bloc_login" style="top: 40%;">
    <h1>S'inscrire<img src="source/logo_login.png"></h1><br>
    <div class ="erreur">
    </div>

      <form action="" method="POST">
        <input type="text" name="username" placeholder="Choisissez un pseudo">
        <input type="text" name="email" placeholder="Entrez un email valide">
        <input type="password" name="password" placeholder="Choisissez un mot de passe">
        <input type="password" name="password_confirm" placeholder="Confirmez votre mot de passe">
        <input type="submit" name="login" class="login login-submit" value="login">
      </form>  
      <div class="login-help">
        <a href="index.php">J'ai déjà un compte</a>
      </div>
  </div>

<?php require 'inc/footer.php'; ?>
