<?php

function newBillet($titre, $contenu, $auteur)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO billets(titre, contenu, date_creation, id_auteur)
                                    VALUES(:titre, :contenu, NOW(), :id_auteur )');

    $req->bindParam(':titre', $titre, PDO::PARAM_STR);
    $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $req->bindParam(':id_auteur', $auteur, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}

function editBillet($id, $titre, $contenu)
{
    global $bdd;
    $req = $bdd->prepare('UPDATE billets SET titre = :titre, contenu = :contenu WHERE id = :id ');
    $req->bindParam(':titre', $titre, PDO::PARAM_STR);
    $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}

function deleteBillet($id)
{
    global $bdd;
    $req = $bdd->prepare('DELETE FROM billets WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}