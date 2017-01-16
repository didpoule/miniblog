<?php

// Récupération du nombre de billets
function get_nbBillets()
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbBillets FROM billets');
    $req->execute();
    $donnees = $req->fetch();
    $nbBillets = $donnees['nbBillets'];
    $req->closeCursor();
    return $nbBillets;
}

// Récupération des billets dans un tableau
function get_billets($offset, $nbBilletsPage)
{
    global $bdd;
    $offset = (int)$offset;
    $nbBilletsPage = (int)$nbBilletsPage;
    $req = $bdd->prepare('SELECT b.id, b.titre, u.nom AS auteur, b.date_creation, b.contenu
                          FROM billets b LEFT JOIN utilisateurs u ON u.id = b.id_auteur
                          ORDER BY date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbBilletsPage, PDO::PARAM_INT);
    $req->execute();
    $billets = $req->fetchAll();
    $req->closeCursor();
    return $billets;
}

// Récuparation d'un seul billet grâce à son ID
function get_billet($id_billet)
{
    global $bdd;
    $id_billet = (int)$id_billet;
    $req = $bdd->prepare('SELECT b.id, b.titre, b.contenu, u.nom AS auteur, b.date_creation 
                                    FROM billets b LEFT JOIN utilisateurs u ON u.id = b.id_auteur
                                    WHERE b.id = ?');
    $req->execute(array($id_billet));
    $billet = $req->fetch();
    $req->closeCursor();
    return $billet;
}