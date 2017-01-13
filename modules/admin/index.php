<?php

if (!$_SESSION['admin']) {
    include('modules/admin/controller/connect.php');
} else {
    include('modules/admin/controller/admin.php');
}