<?php

include_once('include/connexion_sql.php');

if(isset($_GET['section']))
{
    if ($_GET['section'] == 'commentaires')
    {
        include ('modules/commentaires/controller/index.php');
    }

}
else// (!isset($_GET['section']) OR $_GET['section'] == 'index')
{
    include_once('modules/blog/controller/index.php');
}