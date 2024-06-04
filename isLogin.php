<?php
// Création d'une fonction d'autorisation
function isLogin()
{
// Connexion à la BDD
    $pdo = require_once './database.php';
// Récupération de l'id de la session aux cookies
    $sessionId = $_COOKIE['session'] ?? '';
// Si id présent, requête pour récupérer la session (id session et id user)
    if ($sessionId) {
            $sessionUserStatement = $pdo->prepare('SELECT * FROM session JOIN user on user.id=session.userid WHERE session.id=?');
            $sessionUserStatement->execute([$sessionId]);
            $user = $sessionUserStatement->fetch();
}
// Si user n'est pas null ni false alors on retourne le user sinon false
if ($user !== null && $user !== false) {
    return $user;
} else {
    return false;
}
}