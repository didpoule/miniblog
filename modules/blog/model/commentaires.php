<?php
function get_nbCommentaires($billet)
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE id_billet = ?');
    $req->execute(array($billet));
    $donnees = $req->fetch();
    $nbCommentaires = $donnees['nbCommentaires'];

    return $nbCommentaires;
}
function get_commentaires($billet, $offset, $nbCommentairesPage)
{
    global $bdd;
    $billet = (int)$billet;
    $req = $bdd->prepare('SELECT id, pseudo, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr 
                          FROM commentaires WHERE id_billet = :billet ORDER BY date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbCommentairesPage, PDO::PARAM_INT);
    $req->execute();
    $commentaires = $req->fetchAll();


    return $commentaires;
}
// Todo: Modifier requète pour ajouter l'email si renseigné
// Todo: Utiliser "invité" comme pseudo si champ vide

function new_commentaire($billet, $pseudo, $contenu)
{
    global $bdd;
    $billet = (int)$billet;
    $req = $bdd->prepare ('INSERT INTO commentaires(id_billet, pseudo, contenu, date_creation)
                                      VALUES(:id_billet, :pseudo, :contenu, NOW())');

    $req->bindParam(':id_billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':pseudo', $pseudo);
    $req->bindParam(':contenu', $contenu);
    $req->execute();
}