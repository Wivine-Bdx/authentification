<?php
// Connexion à la BDD
$pdo = require_once './database.php';
// Récupération de l'id de la session aux cookies
$sessionId = $_COOKIE['session'] ?? '';
// Si id présent, requête pour récupérer la session
if ($sessionId) {
    $sessionsStatement = $pdo->prepare('SELECT * FROM session WHERE id=?');
    $sessionsStatement->execute([$sessionId]);
    $session = $sessionsStatement->fetch();
// Récupération des informations du user selon l'id de session 
if ($session) {
    $userStatement = $pdo->prepare('SELECT * FROM user WHERE id=?');
    $userStatement->execute([$session['userid']]);
    $user = $userStatement->fetch();
}
}
// Redirection vers page de login si l'user n'est pas trouvé
if (!$user) {
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
    <a href="/login.php">Connexion</a>
    <a href="/logout.php">Déconnexion</a>
    <a href="/profile.php">Profil</a>
    <a href="/register.php">Inscription</a>
</nav>

<h1>Profil</h1>
    <h2>Hello <?= $user['username'] ?></h2>
</body>