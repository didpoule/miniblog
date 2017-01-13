<?php

// Récupération nombre de commentaires
function get_modCommentaires()
{
    global $bdd;
    $param = 'modeValidationCommentaires';
    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = :param');
    $req->bindParam(':param', $param);
    $req->execute();
    $donnees = $req->fetch();
    return $donnees['valeur'];
}

// Récupération nombre de commentaires pour un billet
function get_nbCommentaires()
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE afficher = 1');
    $req->execute();
    $donnees = $req->fetch();
    $nbCommentaires = $donnees['nbCommentaires'];
    $req->closeCursor();
    return $nbCommentaires;
}

// Récupération de la liste des commentaires dans un tableau
function get_commentaires($billet, $offset, $nbCommentairesPage)
{
    global $bdd;
    $billet = (int)$billet;
    $req = $bdd->prepare('SELECT c.id, c.id_auteur, c.pseudo, u.email AS email, c.contenu, c.date_creation
                          FROM commentaires c LEFT JOIN utilisateurs u ON u.id = c.id_auteur
                          WHERE c.id_billet = :billet AND c.afficher = 1 ORDER BY c.date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbCommentairesPage, PDO::PARAM_INT);
    $req->execute();
    $commentaires = $req->fetchAll();
    $req->closeCursor();
    return $commentaires;
}

// Récupération de tous les commentaires
function get_commentairesAll($offset, $nbCommentairesPage)
{
    global $bdd;
    $req = $bdd->prepare('SELECT id_billet, id, pseudo, pseudo, date_creation, contenu FROM commentaires WHERE afficher = 1 
                                    ORDER BY date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbCommentairesPage, PDO::PARAM_INT);
    $req->execute();
    $commentaires = $req->fetchAll();
    $req->closeCursor();
    return $commentaires;
}

// Ecriture d'un commentaire dans BDD
function new_commentaire($billet, $pseudo, $contenu, $idAuteur, $modCommentaire)
{
    global $bdd;
    $billet = (int)$billet;
    if ($pseudo == NULL) $pseudo = 'invité';
    $req = $bdd->prepare('INSERT INTO commentaires(id_billet, id_auteur, afficher, pseudo, contenu, date_creation)
                                      VALUES(:id_billet, :idAuteur, :modCommentaire, :pseudo, :contenu, NOW())');
    $req->bindParam(':id_billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);
    $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $req->bindParam(':modCommentaire', $modCommentaire, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
}
