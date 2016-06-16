<?php
if(!empty($_POST) && !empty($_POST['email'])){
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par emails';
        mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost:8888/zicsearch/reset.php?id={$user->id}&token=$reset_token");
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
    }
}
?>
<?php require 'inc/header.php'; ?>

<head>  
    <link href="css/style_log.css" rel="stylesheet">
</head>

    <div class="bloc_login">
    <h1>Mot de passe oublié</h1><br>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Entrer votre email">
        <input type="submit" class="login login-submit" value="Récupérer">
    </form>
    <div class="login-help">
        <a href="login.php">Se connecter</a>
    </div>

<?php require 'inc/footer.php'; ?>