<?php
// Inclusions et définitions des variables
include_once('include/functions.php');
include_once('modules/blog/model/get_billets.php');
$offset = 0;
$nbBilletsPage = 5;
$nbBillets = get_nbBillets();
$nbPages = calc_nbPages($nbBillets, $nbBilletsPage);
$page = 0;

if(isset($_GET['page']))
{
    $page = htmlspecialchars($_GET['page']);
    $offset = donnees_page($page, $nbPages, $nbBilletsPage);
}

$billets = get_billets($offset, $nbBilletsPage);

// On effectue du traitement sur les données (contrôleur)
// Ici, on doit surtout sécuriser l'affichage
foreach ($billets as $cle => $billet) {
    $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
    $billets[$cle]['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
}

// On affiche la page (vue)
include_once('modules/blog/view/index.php');