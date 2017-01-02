<?php
$login = NULL;
$password = NULL;
include('modules/admin/model/connect.php');

if(isset($_POST['login']) && isset($_POST['password']))
{
    $admin = getAdmin();
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $_SESSION['admin'] = controleLogin($admin, $login, $password);

}
include('modules/admin/view/connect.php');
