<?php
// Include des fonctions SQL et Définition des variables
include_once('modules/blog/model/commentaires.php');
$nbCommentairesPage = 10;
$offset = 0;
$gravatar = NULL;
$idAuteur = 0;
// Vérification de la validité de l'adresse email & si déjà inscrit dans BDD
if(!empty($_POST['email']))
{
    $nom =  htmlspecialchars($_POST['pseudo']);
    $email = verifEmail($_POST['email']);
    if($email != NULL)
    {
        $idAuteur = getIduser($email);
        if($idAuteur == 0)
        {
            createUser($email, $nom);
            $idAuteur = getIduser($email);
        }
    }
}

// Contrôle des informations envoyées par le formulaire
if(isset($_GET['billet']))
{
    if(!empty($_POST['contenu'])) {
        $billet = htmlspecialchars($_GET['billet']);
        $pseudo =  $_POST['pseudo'];
        $contenu =  $_POST['contenu'];
        new_commentaire($billet,$pseudo,$contenu, $idAuteur);
    }
}




// Gestion de la pagination
$nbCommentaires = get_nbCommentaires($_GET['billet']);

$nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
if(isset($_GET['pageCom']))
{
    $pageCom = htmlspecialchars($_GET['pageCom']);
    $offset = donnees_page($pageCom, $nbPages, $nbCommentairesPage);
}

// Récupération des commentaires
$commentaires = get_commentaires(htmlspecialchars($_GET['billet']), $offset, $nbCommentairesPage);
foreach ($commentaires as $cle => $commentaire) {
    $commentaires[$cle]['pseudo'] = htmlspecialchars($commentaire['pseudo'], ENT_QUOTES);
    $commentaires[$cle]['contenu'] = nl2br(htmlspecialchars($commentaire['contenu'], ENT_QUOTES));
    $commentaires[$cle]['email'] = nl2br($commentaire['email']);
    $commentaires[$cle]['gravatar'] = nl2br(get_gravatar($commentaire['email']));
}
// Récupération du billet à afficher pour les commentaires

include_once('modules/blog/model/billets.php');
$billet = get_billet($_GET['billet']);

$billet['titre'] = htmlspecialchars($billet['titre']);
$billet['contenu'] = htmlspecialchars($billet['contenu']);
$billet['id'] = (int)($billet['id']);

// Affichage
include_once('modules/blog/view/commentaires.php');