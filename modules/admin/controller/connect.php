<?php
$login = NULL;
$password = NULL;
include('modules/admin/model/connect.php');
$admin = getAdmin();
// Contrôle du login et du mot de passe
if($admin)
{
    if (isset($_POST['login']) && isset($_POST['password']))
    {
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $_SESSION['admin'] = controleLogin($admin, $login, $password);
        if ($_SESSION['admin'])
        {
            $_SESSION['userID'] = getIduser($admin['email']);
        }
    }
    include('modules/admin/view/connect.php');
}
else
{
    $_SESSION['adminTemp'] = true;
    header('Location: ' . $serUrl  . '/?section=admin&menu=paramAdmin');
}

