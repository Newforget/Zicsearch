<?php
require 'inc/functions.php';
logged_only();

    // Ajout avatar

if($_POST['avatar']){

    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
      $tailleMax = 2097152; // limite de 2M octets
      $extensionValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES['avatar']['size'] <= $tailleMax) {
        $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
        if(in_array($extensionUpload, $extensionValides)) {
          $_SESSION['id'] = $_SESSION['auth']->id;
          $chemin = "membres/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
          $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
          if($resultat) {
            $_SESSION['id'] = $_SESSION['auth']->id;
            require_once 'inc/db.php';
            $updateAvatar = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
            $updateAvatar->execute(array(
              'avatar' => $_SESSION['id'] . "." . $extensionUpload,
              'id' => $_SESSION['id']
              ));
            $_SESSION['flash']['success'] = "Votre photo a bien été modifiée";
          } else {
            $_SESSION['flash']['danger'] = "Il y a eu une erreur pendant l'importation de la photo profil";
          }
        } else {
          $_SESSION['flash']['danger'] = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
        }
      } else {
        $_SESSION['flash']['danger'] = "Votre photo de profil ne doit pas dépasser 2Mo";
      }
    }
}

if(!empty($_POST['refresh'])){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
    }else{
        $_SESSION['id'] = $_SESSION['id']->id;
        $password= password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $_SESSION['id']]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    } 

}
require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

  <div id='content'>

  <?php require 'inc/menu.php' ?>

    <h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>

      <!-- Ajout avatar -->

      <form action="" method="post" enctype="multipart/form-data">
      <label>Ajouter une photo profil</label><br />
        <br />
          <?php
            $_SESSION['id'] = $_SESSION['id']->id;
            if(!empty($_SESSION['auth']->avatar)) {

          ?>
            <img src="membres/avatars/<?php echo $_SESSION['auth']->avatar; ?>" width="150" />
          <?php    
            }
          ?>
        <br />

        <input type="file" name="avatar" /><br /><br />
        <input type="submit" name="avatar" class="login login-submit" value="Ajouter la photo">
        <br /><br />
        </form>

      <!-- Fin ajout avatar -->

    <form action="" method="post">
      
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Changer de mot de passe"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du mot de passe"/>
        </div>

        <input type="submit" name="refresh" class="login login-submit" value="Mettre à jour mon profil">

    </form>
  </div>

<?php require 'inc/footer.php'; ?>