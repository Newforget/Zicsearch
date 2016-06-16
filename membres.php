<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();

require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

	<div id='content'>

	<?php require 'inc/menu.php' ?>

		<p>Il y a actuellement <?php require 'script/user_live.php'; echo $user_nbr; ?> utilisateur<?php if($user_nbr > 1) { echo "s"; } ?> en ligne.</p><br />

	</div>

<?php require 'inc/footer.php'; ?>