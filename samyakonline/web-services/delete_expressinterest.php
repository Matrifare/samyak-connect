<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/13/2018
 * Time: 12:01 AM
 */
require_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();

if (isset($_POST['exp_id']) && !isset($_POST['exp_status']) && isset($_REQUEST['del_status']) && $_REQUEST['del_status'] == 'sent') {
    $DatabaseCo->dbLink->query("update expressinterest set trash_sender='Yes' where ei_id='" . $_POST['exp_id'] . "'");
} else if (isset($_POST['exp_id']) && !isset($_POST['exp_status']) && isset($_REQUEST['del_status']) && $_REQUEST['del_status'] == 'received') {
    $DatabaseCo->dbLink->query("update expressinterest set trash_receiver='Yes' where ei_id='" . $_POST['exp_id'] . "'");
}

if (isset($_POST['exp_status']) && $_POST['exp_status'] == 'trash_all' && isset($_REQUEST['del_status']) && $_REQUEST['del_status'] == 'received') {
    $DatabaseCo->dbLink->query("update expressinterest set trash_receiver='Yes' where ei_id in (" . $_POST['exp_id'] . ")");
} else if (isset($_POST['exp_status']) && $_POST['exp_status'] == 'trash_all' && isset($_REQUEST['del_status']) && $_REQUEST['del_status'] == 'sent') {
    $DatabaseCo->dbLink->query("update expressinterest set trash_sender='Yes' where ei_id in (" . $_POST['exp_id'] . ")");
}

if(!empty($_POST['matri_id']) && !empty($_POST['matri_ids'])) {
    $matri_ids = str_replace(",", "','", $_POST['matri_ids']);
    $DatabaseCo->dbLink->query("delete expressinterest where ei_sender='".$_POST['matri_id']."' AND ei_receiver IN ('" . $matri_ids . "')");
}