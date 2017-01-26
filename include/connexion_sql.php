<?php
$DBHOST = 'localhost';
$DBNAME = 'miniblog';
$DBUSER = 'admin';
$DBPASS = 'admin';
try {
    $bdd = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
