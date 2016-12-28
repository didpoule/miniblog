<?php

/* Connexion à la base de donnée, modifier ce fichier pour vos essais */
try {
    $bdd = new PDO('mysql:host=localhost;dbname=miniblog', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
