<?php
if ($_SESSION['admin'] || $_SESSION['adminTemp'])
{
    include('modules/admin/model/admin.php');
    if (isset($_GET['menu'])) {
        $_COOKIE['url'] .= '&menu=' . $_GET['menu'];
        switch ($_GET['menu']):
            default:
                include('modules/admin/view/admin.php');
            case 'paramAdmin':
                if(!isset($_POST['changeAdmin']))
                {
                    $token = generer_token('paramAdmin');
                }
                else
                {
                    if(isset($_POST['login']) && isset($_POST['email']) &&
                    isset($_POST['password']) && isset($_POST['checkPassword']))
                    {

                        $login = htmlspecialchars($_POST['login']);
                        $email = verifEmail($_POST['email']);
                        $password = htmlspecialchars($_POST['password']);
                        $checkPassword = htmlspecialchars($_POST['checkPassword']);
                        if($email && $checkPassword === $password &&
                        verifier_token(600, $serUrl . '/?section=admin&menu=paramAdmin', 'paramAdmin'))
                        {
                            $key = keyGenerator($login, '0123456789');
                            $encryptedPassword = encrypt($password, $key);
                            setAdmin($login, $encryptedPassword, $email);
                            echo 'TEST';
                            $_SESSION['admin'] = false;
                            if(isset($_SESSION['adminTemp']))
                            {
                                $_SESSION['adminTemp'] = false;
                            }
                            header('Location: ' . $serUrl . '/?section=admin');

                        }
                    }
                }
                include('modules/admin/view/set_admin.php');
                break;

            // Ecriture d'un nouveau billet
            case 'nouveauBillet':
                if(!$_SESSION['adminTemp'])
                {
                    if (!isset($_POST['envoyer']))
                    {
                        $token = generer_token('newBillet');
                    }
                    else
                        {
                        if (isset($_POST['titre']) && isset($_POST['contenu']))
                        {
                            if (verifier_token(600, $serUrl . '/?section=admin&menu=nouveauBillet', 'newBillet'))
                            {
                                newBillet($_POST['titre'], $_POST['contenu'], $_SESSION['userID']);
                                header('Location: ../..?section=admin&menu=modifierBillet');
                            }
                        }
                    }
                    include('modules/admin/view/nouveau_billet.php');
                }
                break;

            // Modification d'un billet
            case 'modifierBillet':
                if(!$_SESSION['adminTemp'])
                {
                    include('modules/blog/model/billets.php');
                    $offset = 0;
                    $nbBilletsPage = 5;
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
                        if ($billets) {
                            foreach ($billets as $cle => $billet)
                            {
                                $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
                                $billets[$cle]['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                                $billets[$cle]['auteur'] = htmlspecialchars($billet['auteur']);
                                $billets[$cle]['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
                            }
                        }
                    } // si on a cliqué sur un billet
                    else
                        {
                        if ($_GET['action'] == 'afficher')
                        {
                            if (!isset($_POST['modifier']) && !isset($_POST['supprimer']))
                            {
                                $token = generer_token('modifBillet');
                            }
                            if (isset($_POST['modifier']) || isset($_POST['supprimer']))
                            {
                                if (verifier_token(600,
                                    $serUrl . '/?section=admin&menu=modifierBillet&action=afficher&billet=' . $_POST['id_billet'],
                                    'modifBillet'))
                                {
                                    if (isset($_POST['modifier'])) editBillet($_POST['id_billet'], $_POST['titre'], $_POST['contenu']);
                                    if (isset($_POST['supprimer'])) deleteBillet($_POST['id_billet']);
                                    header('Location: ../..?section=admin&menu=modifierBillet');
                                }


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
                }
                break;

            // Activation/désactivation de la validation des commentaires par administrateur
            case 'paramCommentaire':
                if(!$_SESSION['adminTemp'])
                {
                    if (!isset($_POST['modifier']))
                    {
                        $token = generer_token('adminCom');
                    }
                    else
                    {
                        if (verifier_token(600, $serUrl . '/?section=admin&menu=paramCommentaire', 'adminCom'))
                        {
                            $param = 'modeValidationCommentaires';
                            $valeur = 1;
                            if (isset($_POST['validation']))
                            {
                                $valeur = 0;
                            }
                            changeParam($param, $valeur);
                        }
                        header('Location: ' . $serUrl . '/?section=admin&menu=paramCommentaire');
                    }
                    include('modules/admin/view/commentaires.php');
                }
                break;
            // Affichage des commentaires en attente pour validation ou suppression
            case 'validerCommentaire':
                if(!$_SESSION['adminTemp'])
                {
                    $offset = 0;
                    $nbCommentairesPage = 10;
                    $nbCommentaires = getnbComAttente();
                    $nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
                    $page = 0;
                    if (isset($_GET['page']))
                    {
                        $page = htmlspecialchars($_GET['page']);
                        $offset = donnees_page($page, $nbPages, $nbCommentairesPage);
                    }
                    else
                        {
                        header('Location: ' . $serUrl . '/?section=admin&menu=validerCommentaire&page=0');
                    }
                    if (!isset($_POST['valider']) && !isset($_POST['supprimer']))
                    {
                        $token = generer_token('adminCom');
                        $commentaires = getComAttente($offset, $nbCommentairesPage);
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
                    if (isset($_POST['valider']) || isset($_POST['supprimer']))
                    {
                        if (verifier_token(600,
                            $serUrl . '/?section=admin&menu=validerCommentaire&page=' . $page,
                            'adminCom'))
                        {

                            if (isset($_POST['valider']))
                            {
                                validerCommentaire($_POST['commentaire']);
                                header('Location: ' . $serUrl . '/?section=admin&menu=validerCommentaire');
                            }
                            if (isset($_POST['supprimer']))
                            {
                                deleteCommentaire($_GET['commentaire']);
                                header('Location: ' . $serUrl . '/?section=admin&menu=validerCommentaire');
                            }
                        }
                    }
                    include('modules/admin/view/commentaires.php');
                }
                break;
            // Affichage des commentaires affichés pour suppression
            case 'supprimerCommentaire':
                if(!$_SESSION['adminTemp'])
                {
                    include('modules/blog/model/commentaires.php');
                    $offset = 0;
                    $nbCommentairesPage = 10;
                    $nbCommentaires = get_nbCommentaires();
                    $nbPages = calc_nbPages($nbCommentaires, $nbCommentairesPage);
                    $page = 0;
                    if (isset($_GET['page']))
                    {
                        $page = htmlspecialchars($_GET['page']);
                        $offset = donnees_page($page, $nbPages, $nbCommentairesPage);
                    }
                    else
                        {
                        header('Location: ' . $serUrl . '/?section=admin&menu=supprimerCommentaire&page=0');
                    }
                    if (!isset($_POST['supprimer']))
                    {
                        $token = generer_token('adminCom');
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
                    } else
                        {
                        if (verifier_token(600, $serUrl . '/?section=admin&menu=supprimerCommentaire&page=' . $page, 'adminCom'))
                        {
                            deleteCommentaire($_GET['commentaire']);
                            header('Location: ' . $serUrl . '/?section=admin&menu=supprimerCommentaire');
                        }
                    }
                    include('modules/admin/view/commentaires.php');
                }
                break;

            // Affichage du menu par défaut si une valeur inconnue est renseignée


        endswitch;
    }
    elseif (!isset($_GET['page']))
    {
        include('modules/admin/view/admin.php');
    }
}
else
{
    header('Location: ' . $serUrl .  '/section=admin');
}