<?php
/* Connexion à la base de données, modifier ce fichier pour vos essais */
$DBHOST = 'localhost';
$DBNAME = 'miniblog';
$DBUSER= 'root';
$DBPASS = '';

try {
    $bdd = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
