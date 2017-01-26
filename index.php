<?php
session_start();
if (!isset($_SESSION['adminTemp']))
{
    $_SESSION['adminTemp'] = false;
}
if (!isset($_SESSION['admin']))
{
    $_SESSION['admin'] = false;
}
require('include/connexion_sql.php');
require('include/functions.php');
    if (isset($_GET['section']))
    {
        $_COOKIE['url'] = '?section=' . $_GET['section'];

        switch ($_GET['section'])
        {
            case 'commentaires':
                include('modules/blog/controller/commentaires.php');
                break;
            case 'admin':
                include('modules/admin/index.php');
                break;
            default:
                include('error.php');
                break;
        }
    }
    else
    {
        include_once('modules/blog/controller/index.php');
    }