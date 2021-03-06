<?php
$errmsg = 0;
// Include et Définitions des variables
include_once('modules/blog/model/billets.php');
$offset = 0;
$nbBilletsPage = 5;
$nbBillets = get_nbBillets();
$nbPages = calc_nbPages($nbBillets, $nbBilletsPage);
$page = 0;
$longueurMax = 100;

// Gestion de la pagination
if (isset($_GET['page']))
{
    $page = htmlspecialchars($_GET['page']);
    $offset = donnees_page($page, $nbPages, $nbBilletsPage);
}
// Récupération de la liste des billets
$billets = get_billets($offset, $nbBilletsPage);
if($billets)
{
    foreach ($billets as $cle => $billet)
    {
        $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
        $billets[$cle]['date'] = dateFr(htmlspecialchars($billet['date_creation']));
        $billets[$cle]['auteur'] = htmlspecialchars($billet['auteur']);
        $billets[$cle]['contenu'] = nl2br(tronquerChaine(htmlspecialchars($billet['contenu']), $longueurMax));
    }
}
else
{
    $errmsg = 9;
}

// Affichage
include_once('modules/blog/view/index.php');