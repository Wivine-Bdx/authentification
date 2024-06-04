<?php

// Etablir la connexion avec la BDD avec PDO

// Essai de se connecter à la BDD test
// Envoi résultat de la requête sous forme de tableaux associatifs pour rendre 'accès aux données plus facile
// Si pas réussi affichage du message d'erreur
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        '',
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
}
// Renvoyer l'objet PDO pour être réutiliser 
return $pdo;