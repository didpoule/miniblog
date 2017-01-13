<?php
if($_SESSION['admin'] || $_SESSION['adminTemp'])
    {
    include('modules/admin/controller/admin.php');
}
else
    {
    include('modules/admin/controller/connect.php');

}