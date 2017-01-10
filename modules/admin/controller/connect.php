<?php
$login = NULL;
$password = NULL;
include('modules/admin/model/connect.php');
// Contr$ole du login et du mot de passe
if (isset($_POST['login']) && isset($_POST['password']))
{
    $admin = getAdmin();
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $_SESSION['admin'] = controleLogin($admin, $login, $password);
    if ($_SESSION['admin']) $_SESSION['userID'] = getIduser($admin['email']);


}
include('modules/admin/view/connect.php');
