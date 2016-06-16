<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();

	if(isset($_POST['message']) AND !empty($_POST['message'])) {

		$username = $_SESSION['auth']->username;
		$message = htmlspecialchars($_POST['message']); // éviter les injections

		$insertmsg = $pdo->prepare('INSERT INTO chat(username, message) VALUES(?, ?)');
		$insertmsg->execute(array($username, $message));

		header('Location: tchat.php');

	}

require 'inc/header.php';
?>

<head>  
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_menu.css" rel="stylesheet">
</head>

	<div id='content'>

	<?php require 'inc/menu.php' ?>

		<h1>Chat</h1>

		<hr />
		<?php

			// Récupération des 10 derniers messages
			$reponse = $pdo->query('SELECT username, message FROM chat ORDER BY ID DESC LIMIT 0, 10');

			// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
			while ($donnees = $reponse->fetch())
			{

				echo '<p><strong>' . htmlspecialchars($donnees->username) . '</strong> : ' . htmlspecialchars($donnees->message) . '</p>';
			}

			$reponse->closeCursor();

		?>
		<hr />

		<form method="post" action="">
			<div class="tchat">
				<input type="text" name="username" value="<?php echo $_SESSION['auth']->username; ?>" disabled/><br/>
				<textarea type="text" name="message" placeholder="Votre message"></textarea><br/>
				<input type="submit" class="login login-submit" value="Envoyer">
			</div>
		</form>

	</div>

<?php require 'inc/footer.php'; ?>