<?php

include_once('include/sql.php');
include_once('include/functions.php');

if(isset($_GET['section']))
{
    if ($_GET['section'] == 'commentaires')
    {
        include ('modules/blog/controller/commentaires.php');
    }

}
else// (!isset($_GET['section']) OR $_GET['section'] == 'index')
{
    include_once('modules/blog/controller/index.php');
}