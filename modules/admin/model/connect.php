<?php

function getAdmin()
{
    global $bdd;
    $req = $bdd->prepare('SELECT login, email, password FROM admin WHERE id = 1');
    $req->execute();
    $donnees = $req->fetch();
    return $donnees;
}
