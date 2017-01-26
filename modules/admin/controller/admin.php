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
    include('include/admin_functions.php');
    include('modules/admin/model/admin.php');
    $baseUrl = setUrl();
    if (isset($_GET['menu'])) {
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
                paramAdmin($errmsg);
                break;

            // Ecriture d'un nouveau billet
            case 'nouveauBillet':
                nouveauBillet($errmsg);
                break;

            // Modification d'un billet
            case 'modifierBillet':
                modifierBillet($errmsg, $baseUrl);
                break;

            // Activation/désactivation de la validation des commentaires par administrateur
            case 'paramCommentaire':
                paramCommentaire($errmsg);
                break;
            // Affichage des commentaires en attente pour validation ou suppression
            case 'validerCommentaire':
                validationCommentaires($errmsg, $baseUrl);
                break;
            // Affichage des commentaires affichés pour suppression
            case 'supprimerCommentaire':
                supressionCommentaires($errmsg, $baseUrl);
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
    header('Location: ?section=admin');
}