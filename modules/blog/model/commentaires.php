<?php

// Récupération nombre de commentaires
function get_nbCommentaires($billet)
{
    global $bdd;
    $req = $bdd->prepare('SELECT COUNT(*) AS nbCommentaires FROM commentaires WHERE id_billet = ?');
    $req->execute(array($billet));
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
                          WHERE c.id_billet = :billet ORDER BY c.date_creation DESC LIMIT :offset, :limit');
    $req->bindParam(':billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $nbCommentairesPage, PDO::PARAM_INT);
    $req->execute();
    $commentaires = $req->fetchAll();
    $req->closeCursor();
    return $commentaires;
}

// Ecriture d'un commentaire dans BDD
function new_commentaire($billet, $pseudo, $contenu, $idAuteur)
{
    global $bdd;
    $billet = (int)$billet;
    if($pseudo == NULL) $pseudo = 'invité';
    $req = $bdd->prepare ('INSERT INTO commentaires(id_billet, id_auteur, pseudo, contenu, date_creation)
                                      VALUES(:id_billet, :idAuteur, :pseudo, :contenu, NOW())');

    $req->bindParam(':id_billet', $billet, PDO::PARAM_INT);
    $req->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);
    $req->bindParam(':pseudo', $pseudo);
    $req->bindParam(':contenu', $contenu);
    $req->execute();
    $req->closeCursor();
}
// Récupération de l'id de l'auteur du commentaire si son adresse mail est renseignée
function getIduser($email)
{
    global $bdd;
    $req = $bdd->prepare('SELECT id FROM utilisateurs WHERE email = :email');
    $req->bindParam(':email', $email, PDO::PARAM_STR);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['id'];
}
// Récupération de l'email de l'utilisateur grâce à son id
function getEmailuser($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT email FROM utilisateurs WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['email'];
}
// Création d'un utilisateur si adresse mail valide pour utilisation gravatar
function createUser($email, $nom = NULL)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO utilisateurs(nom, email)
                                     VALUES(:nom, :email)');
    $req->bindParam(':nom', $nom, PDO::PARAM_STR);
    $req->bindParam(':email', $email, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
}