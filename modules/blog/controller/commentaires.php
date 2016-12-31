<?php
/* Todo: Créer fonction pour récupérer gravatar à partir de l'adresse mail saisie
   Todo: Enregistrer adresse mail et pseudo de l'utilisateur */
include_once('modules/blog/model/commentaires.php');
$nbCommentairesPage = 10;
$offset = 0;
if(isset($_GET['billet']) && isset($_POST['pseudo']) && isset($_POST['contenu']))
{
    if(!empty($_POST['pseudo']) && !empty($_POST['contenu'])) {
        $billet = htmlspecialchars($_GET['billet']);
        $pseudo =  htmlspecialchars($_POST['pseudo']);
        $contenu =  htmlspecialchars($_POST['contenu']);
        new_commentaire($billet,$pseudo,$contenu);
    }
}

// On demande les commentaires (modèle)


$nbCommentaires = get_nbCommentaires($_GET['billet']);

$nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
if(isset($_GET['pageCom']))
{
    $pageCom = htmlspecialchars($_GET['pageCom']);
    $offset = donnees_page($pageCom, $nbPages, $nbCommentairesPage);
}
$commentaires = get_commentaires(htmlspecialchars($_GET['billet']), $offset, $nbCommentairesPage);
// On effectue du traitement sur les données (contrôleur)
// Ici, on doit surtout sécuriser l'affichage
foreach ($commentaires as $cle => $commentaire) {
    $commentaires[$cle]['pseudo'] = htmlspecialchars($commentaire['pseudo']);
    $commentaires[$cle]['contenu'] = nl2br(htmlspecialchars($commentaire['contenu']));
}

// On demande le billet (modèle)
include_once('modules/blog/model/billets.php');
$billet = get_billet($_GET['billet']);

$billet['titre'] = htmlspecialchars($billet['titre']);
$billet['contenu'] = htmlspecialchars($billet['contenu']);
$billet['id'] = (int)($billet['id']);

// On affiche la page (vue)
include_once('modules/blog/view/commentaires.php');