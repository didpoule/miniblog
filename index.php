<?php
session_start();
if (!isset($_SESSION['admin'])) $_SESSION['admin'] = false;
include_once('include/sql.php');
include_once('include/functions.php');

if (isset($_GET['section'])) {
    switch ($_GET['section']) {
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
} else {
    include_once('modules/blog/controller/index.php');
}
