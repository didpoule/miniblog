<?php

// Ecriture d'un nouveau billet
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

// modification d'un billet
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

// suppression d'un billet
function deleteBillet($id)
{
    global $bdd;
    $req = $bdd->prepare('DELETE FROM billets WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}

// suppression d'un commentaire
function deleteCommentaire($id)
{
    global $bdd;
    $req = $bdd->prepare('DELETE FROM commentaires WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}

// validation d'un commentaire
function validerCommentaire($id)
{
    global $bdd;
    $req = $bdd->prepare('UPDATE commentaires SET afficher = 1 WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}

function getnbComAttente()
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE afficher = 0');
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['nbCommentaires'];
}
// Récupération des commentaires en attente de validation
function getComAttente($offset, $nbCommentairesPage)
{
    global $bdd;
    $req = $bdd->prepare('SELECT id, id_billet, id_auteur, pseudo, contenu, date_creation 
                                    FROM commentaires WHERE afficher = 0
                                    ORDER BY date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbCommentairesPage, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}

// Modification d'un paramètre
function changeParam($param, $valeur)
{
    global $bdd;
    $req = $bdd->prepare('UPDATE parametres SET valeur = :valeur WHERE nom = :param');
    $req->bindParam(':param', $param);
    $req->bindParam(':valeur', $valeur, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}
