<?php

include_once 'DatabaseConnection.php';

include_once 'lib/RequestHandler.php';

include_once 'lib/Config.php';

$configObj = new Config();

$DatabaseCo = new DatabaseConnection();


$is_logout = isset($_GET['action']) ? $_GET['action'] : "";

mysqli_query($DatabaseCo->dbLink, "DELETE FROM online_users WHERE matri_id='" . $_SESSION['user_id'] . "'");


session_destroy();

$statusObj = new Status();

$statusObj->setActionSuccess(true);

$STATUS_MESSAGE = "You are successfully logout.";


$username = "";

$password = "";

echo "<script language='javascript'>window.location.href='index?action=logout';</script>";
