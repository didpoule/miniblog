<?php
// Include des fonctions SQL et Définition des variables
include_once('modules/blog/model/commentaires.php');
$errmsg = 0;
$modCommentaires = !getParam('modeValidationCommentaires');
$nbCommentairesPage = 10;
$offset = 0;
$gravatar = NULL;
$idAuteur = 0;
$enAttente = false;

if(isset($_POST['ok']))
{
    header('Refresh:0');
}
$baseUrl = setUrl();

// Gestion de la pagination
$nbCommentaires = get_nbCommentaires($_GET['billet']);

$nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
if (isset($_GET['page']))
{
    $page = htmlspecialchars($_GET['page']);
    $offset = donnees_page($page, $nbPages, $nbCommentairesPage);
}
// Récupération des commentaires
$commentaires = get_commentaires(htmlspecialchars($_GET['billet']), $offset, $nbCommentairesPage);
if($commentaires)
{
    foreach ($commentaires as $cle => $commentaire)
    {
        $commentaires[$cle]['pseudo'] = htmlspecialchars($commentaire['pseudo'], ENT_QUOTES);
        $commentaires[$cle]['date'] = dateFr(htmlspecialchars($commentaire['date_creation']));
        $commentaires[$cle]['contenu'] = nl2br(htmlspecialchars($commentaire['contenu'], ENT_QUOTES));
        $commentaires[$cle]['email'] = nl2br($commentaire['email']);
        $commentaires[$cle]['gravatar'] = nl2br(get_gravatar($commentaire['email']));
    }
}
else
{
    $errmsg = 10;
}
// Contrôle des informations envoyées par le formulaire
if (isset($_GET['billet']) && isset($_POST['envoyer']))
{
    if (!empty($_POST['email']))
    {
        $nom = htmlspecialchars($_POST['pseudo']);
        $email = verifEmail($_POST['email']);
        if ($email)
        {
            $idAuteur = getIduser($email);
            if (!$idAuteur)
            {
                createUser($email, $nom);
                $idAuteur = getIduser($email);
            }
        }
    }
    if (empty($_POST['contenu']))
    {
        $errmsg = 3;
    }
    else
    {
        $billet = htmlspecialchars($_GET['billet']);
        $pseudo = $_POST['pseudo'];
        $contenu = $_POST['contenu'];
        new_commentaire($billet, $pseudo, $contenu, $idAuteur, $modCommentaires);
        if(getParam('modeValidationCommentaires'))
        {
            $errmsg = 11;
            $enAttente = true;

        }
    }
}

// Récupération du billet à afficher pour les commentaires
include_once('modules/blog/model/billets.php');
$billet = get_billet($_GET['billet']);
if($billet)
{
    $billet['titre'] = htmlspecialchars($billet['titre']);
    $billet['date'] = dateFr(htmlspecialchars($billet['date_creation']));
    $billet['auteur'] = htmlspecialchars($billet['auteur']);
    $billet['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
    $billet['id'] = (int)($billet['id']);
}
else
{
    $errmsg = 1;
}

// Affichage
 include_once('modules/blog/view/commentaires.php');