<?php

	$temps_session = 15;
	$temps_actuel = date("U");
	$ip_user = $_SERVER['REMOTE_ADDR'];
	
	$req_ip_exist = $pdo->prepare('SELECT * FROM online WHERE user_ip = ?');
	$req_ip_exist->execute(array($ip_user));
	$ip_existe = $req_ip_exist->rowCount();

	if($ip_existe == 0){

		$add_ip = $pdo->prepare('INSERT INTO online(user_ip,time) VALUES (?,?)');
		$add_ip->execute(array($ip_user,$temps_actuel));

	} else {

		$update_ip = $pdo->prepare('UPDATE online SET time = ? WHERE user_ip = ?');
		$update_ip->execute(array($temps_actuel,$user_ip));

	}

	$session_delete_time = $temps_actuel - $temps_session;

	$del_ip = $pdo->prepare('DELETE FROM online WHERE time < ?');
	$del_ip->execute(array($session_delete_time));

	$show_user_nbr = $pdo->query('SELECT * FROM online');
	$user_nbr = $show_user_nbr->rowCount();