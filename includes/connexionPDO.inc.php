<?php

// Adresse du serveur de base de données
define('DB_SERVEUR', 'localhost');
// Nom de la base de données
define('DB_NOM','cinema');
// Data Source Name : driver + adresse serveur + nom bdd + charset à utiliser
define('DB_DSN','mysql:host='. DB_SERVEUR .';dbname='. DB_NOM.';charset=utf8');
// Login
define('DB_LOGIN','root');
// Mot de passe
define('DB_PASSWORD','root');

// Variable globale pour utilisation dans des méthodes
global $oPDO;

$options = [
  PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,  // Gestion des erreurs par des exceptions de la classe PDOException
  PDO::ATTR_EMULATE_PREPARES  => true                     // Préparation des requêtes émulée
];
$oPDO = new PDO(DB_DSN, DB_LOGIN, DB_PASSWORD, $options); // Instanciation de la connexion 