<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Site communautaire pour tout les fans de musique">
    <meta name="author" content="Maxime Gitton">
    <link rel="icon" href="../../favicon.ico">

    <title>Zicsearch</title>

</head>

<body>

<div class="container">

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?= $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

