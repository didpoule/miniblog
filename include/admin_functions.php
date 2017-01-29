<?php
function paramAdmin($errmsg)
{
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
                if (verifier_token(600, $_SERVER['HTTP_REFERER'], 'paramAdmin'))
                {
                    $key = keyGenerator($login, '0123456789');
                    $encryptedPassword = encrypt($password, $key);
                    setAdmin($login, $encryptedPassword, $email);
                    $_SESSION['admin'] = false;
                    if (($_SESSION['adminTemp']))
                    {
                        $_SESSION['adminTemp'] = false;
                    }
                    header('Location: ?section=admin');
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
}

function nouveauBillet($errmsg)
{
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
                if (verifier_token(600, $_SERVER['HTTP_REFERER'], 'newBillet'))
                {
                    newBillet($_POST['titre'], $_POST['contenu'], $_SESSION['userID']);
                    header('Location: ?section=admin&menu=modifierBillet');
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
}

function modifierBillet($errmsg, $baseUrl)
{
    if (!$_SESSION['adminTemp']) {
        include('modules/blog/model/billets.php');
        $offset = 0;
        $nbBilletsPage = 5;
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
            if ($billets) {
                foreach ($billets as $cle => $billet) {
                    $billets[$cle]['titre'] = htmlspecialchars($billet['titre']);
                    $billets[$cle]['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                    $billets[$cle]['auteur'] = htmlspecialchars($billet['auteur']);
                    $billets[$cle]['contenu'] = nl2br(htmlspecialchars($billet['contenu']));
                }
            } else {
                $errmsg = 9;
            }
        } // si on a cliqué sur un billet
        else {
            if ($_GET['action'] == 'afficher') {
                if (!isset($_POST['modifier']) && !isset($_POST['supprimer'])) {
                    $token = generer_token('modifBillet');
                }
                if (isset($_POST['modifier']) || isset($_POST['supprimer'])) {
                    // $_SERVER['HTTP_REFERER']
                    if (verifier_token(600,
                        $_SERVER['HTTP_REFERER'],
                        'modifBillet')) {
                        if (isset($_POST['modifier'])) editBillet($_POST['id_billet'], $_POST['titre'], $_POST['contenu']);
                        if (isset($_POST['supprimer'])) deleteBillet($_POST['id_billet']);
                        header('Location: ?section=admin&menu=modifierBillet');
                    } else {
                        $errmsg = 8;
                    }
                }
                $billet = get_billet($_GET['billet']);
                if ($billet) {
                    $billet['titre'] = htmlspecialchars($billet['titre']);
                    $billet['date'] = dateFr(htmlspecialchars($billet['date_creation']));
                    $billet['auteur'] = htmlspecialchars($billet['auteur']);
                    $billet['contenu'] = htmlspecialchars($billet['contenu']);
                    $billet['id'] = (int)($billet['id']);
                } else {
                    $errmsg = 1;
                }
            }
        }
        include('modules/admin/view/billets.php');
    }
}

function paramCommentaire($errmsg)
{
    if(!$_SESSION['adminTemp'])
    {
        if (!isset($_POST['modifier']))
        {
            $token = generer_token('adminCom');
        }
        else
        {
            if (verifier_token(600,  $_SERVER['HTTP_REFERER'], 'adminCom'))
            {
                $param = 'modeValidationCommentaires';
                $valeur = 0;
                if (isset($_POST['validation']))
                {
                    $valeur = 1;
                }
                changeParam($param, $valeur);
            }
            else
            {
                $errmsg = 8;
            }
            header('Location: ?section=admin');
        }
        include('modules/admin/view/commentaires.php');
    }
}

function validationCommentaires($errmsg, $baseUrl)
{
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
                $_SERVER['HTTP_REFERER'],
                'adminCom'))
            {

                if (isset($_POST['valider']))
                {
                    validerCommentaire($_POST['commentaire']);
                    header('Location: ?section=admin&menu=validerCommentaire');
                }
                if (isset($_POST['supprimer']))
                {
                    deleteCommentaire($_GET['commentaire']);
                    header('Location: ?section=admin&menu=validerCommentaire');
                }
            }
            else
            {
                $errmsg = 8;
            }
        }
        include('modules/admin/view/commentaires.php');
    }
}

function supressionCommentaires($errmsg, $baseUrl)
{
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
            if (verifier_token(600, $_SERVER['HTTP_REFERER'], 'adminCom'))
            {
                deleteCommentaire($_GET['commentaire']);
                header('Location: ?section=admin&menu=supprimerCommentaire');
            }
            else
            {
                $errmsg = 8;
            }
        }
        include('modules/admin/view/commentaires.php');
    }
}