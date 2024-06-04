<?php
// Connexion à la BDD
$pdo = require_once './database.php';
// Initialisation variable erreur
$error = '';
// Vérification de la méthode (doit être égal à POST)
// Si POST alors filtrage et assainissement des donnés du formulaire 
// (échappement caractères spéciaux et assainit email)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
    'email' => FILTER_SANITIZE_EMAIL,
]);
    $password = $_POST['password'] ?? '';
    $email = $input['email'] ?? '';
// Si une des valeurs ci-dessous vide = erreur signalée
    if (!$password || !$email) {
    $error = 'ERROR';
} else {
// Sinon préparer requête SQL pour sélectionner l'utilisateur avec son email et exécuter la requête
// Récupérer le résultar et le stocker dans la variable user
    $statementUser = $pdo->prepare('SELECT * FROM user WHERE email = ?');
    $statementUser->execute([$email]);
    $user = $statementUser->fetch();
// Vérification de comparaison du mot de passe fourni avec celui hashé dans la BDD
    if (password_verify($password, $user['password'])) {
// Si mot de passe ok alors requête SQL pour insérer une nouvelle session 
// Liaison de la valeur au paramètre pour protéger injection SQL (bindValue) + exécuter
// Définir un cookie de session avec id de session + durée (ici 14 jours)
        $statementSession = $pdo->prepare('INSERT INTO session VALUES(DEFAULT, :userid)');
        $statementSession->bindValue(':userid', $user['id']);
        $statementSession->execute();
        $sessionId = $pdo->lastInsertId();
      setcookie('session', $sessionId, time() + 60 * 60 * 24 * 14, "", "", false, true);
// Si ok alors redirectio vers page de profil
// Sinon erreur
        header('Location: /profile.php');
    } else {
        $error = 'Identifiants invalides';
    }
}
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

<h1>Connexion</h1>

<form action="/login.php" method="post">
    <input type="text" name="email" placeholder="email"><br><br>
    <input type="text" name="password" placeholder="password"><br><br>
    <?php if ($error) : ?>
        <h1 style="color:red;"><?= $error ?></h1>
    <?php endif; ?>
    <button type="submit">Connexion</button>
</form>
</body>