<?php

include_once('include/connexion_sql.php');
include_once('include/functions.php');

if(!$_SESSION['admin'])
{
if (!$_SESSION['admin']) {
    include('modules/admin/controller/connect.php');
}
else
{
    include('modules/admin/controller/admin.php');
}