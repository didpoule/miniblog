<?php
/**
 * @param $nbBilletsPage
 * @return mixed
 */
function get_nbBillets()
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbBillets FROM billets');
    $req->execute();
    $donnees = $req->fetch();
    $nbBillets = $donnees['nbBillets'];

    return $nbBillets;
}
function get_billets($offset, $nbBilletsPage)
{
    global $bdd;
    $offset = (int)$offset;
    $nbBilletsPage = (int)$nbBilletsPage;

    $req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr 
                          FROM billets ORDER BY date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbBilletsPage, PDO::PARAM_INT);
    $req->execute();
    $billets = $req->fetchAll();


    return $billets;
}

function get_billet($id_billet)
{
    global $bdd;
    $id_billet = (int)$id_billet;
    $req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
    $req->execute(array($id_billet));
    $billet = $req->fetch();

    return $billet;
}