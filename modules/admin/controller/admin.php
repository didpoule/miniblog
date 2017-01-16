<?php
if ($_SESSION['admin'] || $_SESSION['adminTemp'])
{
    $errmsg = 0;
    /* Affichage d'un message pour prévenir l'utilisateur qu'il faut créer un admin
    On a accès à aucun autre menu si on  pas défini d'admin */
    if($_SESSION['adminTemp'])
    {
        $errmsg = 6;
    }
    include('modules/admin/model/admin.php');
    if (isset($_GET['menu'])) {
        $_COOKIE['url'] .= '&menu=' . $_GET['menu'];
        switch ($_GET['menu']):

            // Affichage du menu par défaut si une valeur inconnue est renseignée
            default:
                $errmsg = 1;
                include('error.php');
                break;
            case 'deconnexion':
                $_SESSION['admin'] = false;
                header('Location: ' . $serUrl);
                break;
            case 'paramAdmin':
                if((!isset($_POST['changeAdmin'])))
                {
                    $token = generer_token('paramAdmin');
                }
                else
                {
                    if(($_POST['login']) && ($_POST['email']) &&
                    ($_POST['password']) && ($_POST['checkPassword']))
                    {
                        $login = htmlspecialchars($_POST['login']);
                        $email = verifEmail($_POST['email']);
                        $password = htmlspecialchars($_POST['password']);
                        $checkPassword = htmlspecialchars($_POST['checkPassword']);
                        if($email && $checkPassword === $password)
                        {
                            if (verifier_token(600, $serUrl . '/?section=admin&menu=paramAdmin', 'paramAdmin'))
                            {
                                $key = keyGenerator($login, '0123456789');
                                $encryptedPassword = encrypt($password, $key);
                                setAdmin($login, $encryptedPassword, $email);
                                $_SESSION['admin'] = false;
                                if (($_SESSION['adminTemp']))
                                {
                                    $_SESSION['adminTemp'] = false;
                                }
                                header('Location: ' . $serUrl . '/?section=admin');
                            }
                            else
                            {
                                $errmsg = 8;
                                header('Refresh:0');
                            }
                        }
                        else
                        {
                            $errmsg = 4;
                        }
                    }
                    else
                    {
                        $errmsg = 7;
                    }
                }
                if($errmsg == 4 || $errmsg == 7 || $errmsg == 8)
                {
                    $token = generer_token('paramAdmin');
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
                            else
                            {
                                $errmsg = 8;
                            }
                        }
                        else
                        {
                            $errmsg = 5;
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
                        else
                        {
                            $errmsg = 9;
                        }
                    }
                    // si on a cliqué sur un billet
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
                                    header('Location: ' . $serUrl . '?section=admin&menu=modifierBillet');
                                }
                                else
                                {
                                    $errmsg = 8;
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
                            else
                            {
                                $errmsg = 1;
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
                        else
                        {
                            $errmsg = 8;
                        }
                        header('Location: ' . $serUrl . '/?section=admin');
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
                        else
                        {
                            $errmsg = 10;
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
                        else
                        {
                            $errmsg = 8;
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
                        else
                        {
                            $errmsg = 10;
                        }
                    }
                    else
                    {
                        if (verifier_token(600, $serUrl . '/?section=admin&menu=supprimerCommentaire&page=' . $page, 'adminCom'))
                        {
                            deleteCommentaire($_GET['commentaire']);
                            header('Location: ' . $serUrl . '/?section=admin&menu=supprimerCommentaire');
                        }
                        else
                        {
                            $errmsg = 8;
                        }
                    }
                    include('modules/admin/view/commentaires.php');
                }
                break;
        endswitch;
    }
    elseif (!isset($_GET['menu']))
    {
        include('modules/admin/view/admin.php');
    }
}
else
{
    header('Location: ' . $serUrl .  '/section=admin');
}