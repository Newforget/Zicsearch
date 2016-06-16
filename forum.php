<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();

	$categories = $pdo->query('SELECT * FROM f_categories ORDER BY nom');
	$subcat = $pdo->prepare('SELECT * FROM f_souscategories WHERE id_categorie = ? ORDER BY nom');

require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

	<div id='content'>

		<?php require 'inc/menu.php' ?>
		<?php require 'views/forum.view.php' ?>


	</div>

<?php require 'inc/footer.php'; ?>