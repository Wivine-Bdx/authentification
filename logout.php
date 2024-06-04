<?php
// Connexion à la BDD
$pdo = require_once './database.php';

// Récupération de l'id de la session aux cookies
// Si ok -> suppression du cookie de session
$sessionId = $_COOKIE['session'] ?? '';
if ($sessionId) {
    $statement = $pdo->prepare('DELETE FROM session where id=?');
    $statement->execute([$sessionId]);
    setcookie('session', '', time() - 1);
}
// Redirection vers la page login
header('Location: /login.php');