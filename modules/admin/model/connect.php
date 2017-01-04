<?php

function getAdmin()
{
    global $bdd;
    $req = $bdd->query('SELECT login, email, password FROM admin WHERE id= 1');

    $donnees = $req->fetch();

    return $donnees;
}
// Fonction pour définir un admin
/*  function setAdmin($user, $pass)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO admin(login, password)
                        VALUES(:login, :password)');
    $req->bindParam(':login', $user, PDO::PARAM_STR);
    $req->bindParam(':password', $pass, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
}
*/