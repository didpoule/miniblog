<?php
if ($_SESSION['admin']) {
    include('modules/admin/model/admin.php');
    if (isset($_GET['menu'])) {
        switch ($_GET['menu']):
            // Ecriture d'un nouveau billet
            case 'nouveauBillet':
                if (isset($_POST['titre']) && isset($_POST['contenu']))
                {
                    newBillet($_POST['titre'], $_POST['contenu'], $_SESSION['userID']);
                    header('Location: ../..?section=admin&menu=modifierBillet');
                }
                include('modules/admin/view/nouveau_billet.php');
                break;

            // Modification d'un billet
            case 'modifierBillet':
                include('modules/blog/model/billets.php');
                $offset = 0;
                $nbBilletsPage = 10;
                $nbBillets = get_nbBillets();
                $nbPages = calc_nbPages($nbBillets, $nbBilletsPage);
                $page = 0;
                if (isset($_GET['page']))
                {
                    $page = htmlspecialchars($_GET['page']);
                    $offset = donnees_page($page, $nbPages, $nbBilletsPage);
                }
                // Récupération de la liste des billets
                if (!isset($_GET['action']))
                {
                    $billets = get_billets($offset, $nbBilletsPage);
                    if ($billets)
                    {
                        foreach ($billets as $cle => $billet)
                        {
                            $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
                            $billets[$cle]['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                            $billets[$cle]['auteur'] = htmlspecialchars($billet['auteur']);
                            $billets[$cle]['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
                        }
                    }
                }
                // si on a cliqué sur un billet
                else
                {
                    if ($_GET['action'] == 'afficher')
                    {
                        if (isset($_POST['modifier']))
                        {
                            editBillet($_POST['id_billet'], $_POST['titre'], $_POST['contenu']);
                        }
                        if (isset($_POST['supprimer']))
                        {
                            deleteBillet($_POST['id_billet']);
                            header('Location: ../..?section=admin&menu=modifierBillet');
                        }
                        $billet = get_billet($_GET['billet']);
                        if ($billet)
                        {
                            $billet['titre'] = htmlspecialchars($billet['titre']);
                            $billet['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                            $billet['auteur'] = htmlspecialchars($billet['auteur']);
                            $billet['contenu'] = htmlspecialchars($billet['contenu']);
                            $billet['id'] = (int)($billet['id']);
                        }
                    }
                }
                include('modules/admin/view/billets.php');
                break;

            // Activation/désactivation de la validation des commentaires par administrateur
            case 'paramCommentaire':
                if(!isset($_POST['modifier']))
                {
                    header('Location ../..?section=admin&menu=paramCommentaire');
                }
                else
                {
                    $param = 'modeValidationCommentaires';
                    $valeur = 1;
                    if(isset($_POST['validation']))
                    {
                        $valeur = 0;
                    }
                    changeParam($param, $valeur);
                }
            // Affichage des commentaires en attente pour validation ou suppression
            case 'validerCommentaire':
                if(!isset($_POST['valider']) && !isset($_POST['supprimer']))
                {
                    $commentaires = getComAttente();
                    if($commentaires)
                    {
                        foreach ($commentaires as $cle => $commentaire)
                        {
                            $commentaires[$cle]['id_billet'] = $commentaire['id_billet'];
                            $commentaires[$cle]['pseudo'] = htmlspecialchars($commentaire['pseudo'], ENT_QUOTES);
                            $commentaires[$cle]['date'] = dateFr(htmlspecialchars($commentaire['date_creation']));
                            $commentaires[$cle]['contenu'] = nl2br(htmlspecialchars($commentaire['contenu'], ENT_QUOTES));
                        }
                    }
                }
                elseif(isset($_POST['valider']) && !isset($_POST['supprimer']))
                {
                    validerCommentaire($_GET['commentaire']);
                    header('Location: ../..?section=admin&menu=validerCommentaire');
                }
                else
                {
                    deleteCommentaire($_GET['commentaire']);
                    header('Location: ../..?section=admin&menu=validerCommentaire');
                }
                include('modules/admin/view/commentaires.php');
                break;
            // Affichage des commentaires affichés pour suppression
            case 'supprimerCommentaire':
                include('modules/blog/model/commentaires.php');
                $offset = 0;
                $nbCommentairesPage = 20;
                $nbCommentaires = get_nbCommentaires();
                $nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
                $page = 0;
                if (isset($_GET['page']))
                {
                    $page = htmlspecialchars($_GET['page']);
                    $offset = donnees_page($page, $nbPages, $nbCommentairesPage);
                }
                if(!isset($_POST['supprimer']))
                {
                    $commentaires = get_commentairesAll($offset, $nbCommentairesPage);
                    if ($commentaires)
                    {
                        foreach ($commentaires as $cle => $commentaire)
                        {
                            $commentaires[$cle]['id_billet'] = $commentaire['id_billet'];
                            $commentaires[$cle]['pseudo'] = htmlspecialchars($commentaire['pseudo'], ENT_QUOTES);
                            $commentaires[$cle]['date'] = dateFr(htmlspecialchars($commentaire['date_creation']));
                            $commentaires[$cle]['contenu'] = nl2br(htmlspecialchars($commentaire['contenu'], ENT_QUOTES));
                        }
                    }
                }
                else
                {
                    deleteCommentaire($_GET['commentaire']);
                    header('Location: ../..?section=admin&menu=supprimerCommentaire');
                }
                include('modules/admin/view/commentaires.php');
                break;

            // Affichage du menu par défaut si une valeur inconnue est renseignée
            default:
                include('modules/admin/view/admin.php');

        endswitch;
    }
    elseif (!isset($_GET['page']))
    {
        include('modules/admin/view/admin.php');
    }
}
else
{
    header('Location: ?section=admin');
}