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

if (isset($_POST['msg_id']) && isset($_REQUEST['msg_status']) && $_REQUEST['msg_status'] == 'sent') {
    $DatabaseCo->dbLink->query("update message set trash_sender='Yes' where msg_id='" . $_POST['msg_id'] . "'");
} else if (isset($_POST['msg_id']) && isset($_REQUEST['msg_status']) && $_REQUEST['msg_status'] == 'received') {
    $DatabaseCo->dbLink->query("update message set trash_receiver='Yes' where msg_id='" . $_POST['msg_id'] . "'");
}
