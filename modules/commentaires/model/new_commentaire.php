<?php
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