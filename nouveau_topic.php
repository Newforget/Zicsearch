<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();

	/* Traitement du formulaire de création de Topic */

	   if(isset($_SESSION['auth']->id)) {
		   if(isset($_POST['tsubmit'])) {
		      if(isset($_POST['tsujet'],$_POST['tcontenu'])) {
		         $sujet = htmlspecialchars($_POST['tsujet']);
		         $contenu = htmlspecialchars($_POST['tcontenu']);
		         if(!empty($sujet) AND !empty($contenu)) {
		            if(strlen($sujet) <= 70) {
		               if(isset($_POST['tmail'])) {
		                  $notif_mail = 1;
		               } else {
		                  $notif_mail = 0;
		               }
		               $ins = $pdo->prepare('INSERT INTO f_topics (id_createur, sujet, contenu, notif_createur, date_heure_creation) VALUES(?,?,?,?,NOW())');
		               $ins->execute(array($_SESSION['auth']->id,$sujet,$contenu,$notif_mail));
		            } else {
		               $_SESSION['flash']['danger'] = "Votre sujet ne peut pas dépasser 70 caractères";
		            }
		         } else {
		            $_SESSION['flash']['danger'] = "Veuillez compléter tous les champs";
		         }
		      }
		   }
		} else {
		   $_SESSION['flash']['danger'] = "Veuillez vous connecter pour poster un nouveau topic";
		}

require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

	<div id='content'>

		<?php require 'inc/menu.php' ?>
		<?php require 'views/nouveau_topic.view.php' ?>

	</div>

<?php require 'inc/footer.php'; ?>