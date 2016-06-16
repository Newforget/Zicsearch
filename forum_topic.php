<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();

   if(isset($_GET['categorie']) AND !empty($_GET['categorie'])) {
      $get_categorie = htmlspecialchars($_GET['categorie']);
      $categories = array();
      $req_categories = $pdo->query('SELECT * FROM f_categories');
      while($c = $req_categories->fetch()) {
         array_push($categories, array($c->id,url_custom_encode($c->nom)));
      }
      foreach($categories as $cat) {
         if(in_array($get_categorie, $cat)) {
            $id_categorie = intval($cat[0]);
         }
      }
      if(@$id_categorie) {
         if(isset($_GET['souscategorie']) AND !empty($_GET['souscategorie'])) {

            $get_souscategorie = htmlspecialchars($_GET['souscategorie']);

            $souscategories = array();
            $req_souscategories = $pdo->prepare('SELECT * FROM f_souscategories WHERE id_categorie = ?');
            $req_souscategories->execute(array($id_categorie));
            while($c = $req_souscategories->fetch()) {
               array_push($souscategories, array($c->id,url_custom_encode($c->nom)));
            }
            foreach($souscategories as $cat) {
               if(in_array($get_souscategorie, $cat)) {
                  $id_souscategorie = intval($cat[0]);
               }
            }
         }
         $req = "SELECT * FROM f_topics
               LEFT JOIN f_topics_categories ON f_topics.id = f_topics_categories.id_topic 
               LEFT JOIN f_categories ON f_topics_categories.id_categorie = f_categories.id
               LEFT JOIN f_souscategories ON f_topics_categories.id_souscategorie = f_souscategories.id
               LEFT JOIN users ON f_topics.id_createur = users.id
               WHERE f_categories.id = ?";

         if(@$id_souscategorie) {
            $req .= " AND f_souscategories.id = ?";
            $exec_array = array($id_categorie,$id_souscategorie);
         } else {
            $exec_array = array($id_categorie);
         }

         $req .= " ORDER BY f_topics.id DESC";
         
         $topics = $pdo->prepare($req);
         $topics->execute($exec_array);
      } else {
         die('Erreur: Catégorie introuvable...');
      }
   } else {
      die('Erreur: Aucune catégorie sélectionnée...');
   }

require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

   <div id='content'>

      <?php require 'inc/menu.php' ?>
      <?php require 'views/forum_topics.view.php' ?>

   </div>

<?php require 'inc/footer.php'; ?>