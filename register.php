<?php

// Connexion à la BDD
$pdo = require_once './database.php';

// Vérification de la méthode (doit être égal à POST)
// Si POST alors filtrage et assainissement des donnés du formulaire 
// (échappement caractères spéciaux et assainit email)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
    'username' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'email' => FILTER_SANITIZE_EMAIL,
]);
// Initialisation des variables et validation avec les valeurs du formulaire
    $error = '';
    $username = $input['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $input['email'] ?? '';
// Si une des valeurs ci-dessous vide = erreur signalée
    if (!$username || !$password || !$email) {
    $error = 'ERROR';
} else {
// Sinon insertion des données dans BDD en hashant les mots de passe par sécurité
// Valeurs liées aux paramètres nommés pour éviter injection SQL
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
    $statement = $pdo->prepare('INSERT INTO user VALUES (
        DEFAULT,
        :email,
        :username,
        :password
    )');
    $statement->bindValue(':email', $email);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $hashedPassword);
    $statement->execute();
// Redirection vers page de connexion
    header('Location: /login.php');
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

    <h1>Inscription</h1>

<form action="/register.php" method="post">
    <input type="text" name="username" placeholder="username"><br><br>
    <input type="text" name="email" placeholder="email"><br><br>
    <input type="text" name="password" placeholder="password"><br><br>
    <?php if ($error) : ?>
        <h1 style="color:red;"><?= $error ?></h1>
    <?php endif; ?>
    <button type="submit">Valider</button>
</form>
</body>