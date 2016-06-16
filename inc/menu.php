<?php

  $activePage = basename($_SERVER['PHP_SELF'], ".php");

?>


<div id='cssmenu'>
    <ul>
        <li class="<?= ($activePage == 'account') ? 'active':''; ?>"><a href='account.php'><span>Mon compte</span></a></li>
        <li class="<?= ($activePage == 'membres') ? 'active':''; ?>"><a href='membres.php'><span>Les membres</span></a></li>
        <li class="<?= ($activePage == 'invitation') ? 'active':''; ?>"><a href='#'><span>Invitation</span></a></li>
        <li class="<?= ($activePage == 'message') ? 'active':''; ?>"><a href='#'>Message</a></span></li>
        <li class="<?= ($activePage == 'forum') ? 'active':''; ?>"><a href='forum.php'>Le forum</a></span></li>
        <li class="<?= ($activePage == 'tchat') ? 'active':''; ?>"><a href='tchat.php'>Le t'chat</a></span></li>
        <?php if (isset($_SESSION['auth'])): ?>
            <li class='last'><a href="logout.php">Se déconnecter</a></span></li>
        <?php else: ?>
            <li><a href="register.php">S'inscrire</a></span></li>
            <li class='last'><a href="login.php">Se connecter</a></span></li>
        <?php endif; ?>
    </ul>
</div>