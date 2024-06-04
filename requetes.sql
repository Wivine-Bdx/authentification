CREATE DATABASE test

DROP DATABASE test

CREATE DATABASE test


CREATE TABLE test . user (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
email VARCHAR(255) NOT NULL,
username VARCHAR(45) NOT NULL,
password VARCHAR(255) NOT NULL,
UNIQUE INDEX email_UNIQUE (email ASC)
);
-- Création d'un index unique permettant d'empêcher les doublons = chaque valeur de la colonne email est unique dans la table user
-- Donc pas 2 utilisateurs possibles ayant le même mail

CREATE TABLE test . session (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userid INT NOT NULL
)