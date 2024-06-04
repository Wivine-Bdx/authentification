<?php
// Inclure la fonction logique isLogin
require_once './isLogin.php';

$currentUser = isLogin();

if (!$currentUser) {
    header('Location: /login.php');
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav>
        <a href="/">Accueil</a>
        <a href="/profile.php">Profil</a>
        <a href="/logout.php">Déconnexion</a>
    </nav>

    <h1>Profil</h1>
    <h2>Hello <?= $currentUser['username'] ?></h2>
</body>