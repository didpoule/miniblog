<?php
if ($_SESSION['admin']) {
    include('modules/admin/model/admin.php');
    if (isset($_GET['page'])) {
        switch ($_GET['page']):
            case 'nouveauBillet':
                if (isset($_POST['titre']) && isset($_POST['contenu'])) {
                    newBillet($_POST['titre'], $_POST['contenu'], $_SESSION['userID']);
                }
                include('modules/admin/view/nouveau_billet.php');
                break;

            case 'modifierBillet':
                include('modules/blog/model/billets.php');
                $offset = 0;
                $nbBilletsPage = 10;
                $nbBillets = get_nbBillets();
                $nbPages = calc_nbPages($nbBillets, $nbBilletsPage);
                $page = 0;
                if (isset($_GET['page'])) {
                    $page = htmlspecialchars($_GET['page']);
                    $offset = donnees_page($page, $nbPages, $nbBilletsPage);
                }
                // Récupération de la liste des billets
                if (!isset($_GET['action'])) {
                    $billets = get_billets($offset, $nbBilletsPage);
                    foreach ($billets as $cle => $billet) {
                        $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
                        $billets[$cle]['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                        $billets[$cle]['auteur'] = htmlspecialchars($billet['auteur']);
                        $billets[$cle]['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
                    }
                } else {
                    if ($_GET['action'] == 'afficher') {
                        if(isset($_POST['modifier']))
                        {
                            editBillet($_POST['id_billet'], $_POST['titre'], $_POST['contenu']);
                        }
                        if(isset($_POST['supprimer']))
                        {
                            deleteBillet($_POST['id_billet']);
                            header('Location: ../..');
                        }
                        $billet = get_billet($_GET['billet']);
                        $billet['titre'] = htmlspecialchars($billet['titre']);
                        $billet['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                        $billet['auteur'] = htmlspecialchars($billet['auteur']);
                        $billet['contenu'] = htmlspecialchars($billet['contenu']);
                        $billet['id'] = (int)($billet['id']);
                    }

                }
                include('modules/admin/view/billets.php');
                break;

            case 'supprimerCommentaire':
                break;

            case 'parametresCommentaires':
                break;

            default:
                include('modules/admin/view/admin.php');
        endswitch;
    } elseif (!isset($_GET['page'])) {
        include('modules/admin/view/admin.php');
    } else {
        include('modules/admin/view/connect.php');
    }


} else {
    header('Location: ?section=admin');
}