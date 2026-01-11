<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 01/25/2020
 * Time: 09:47 PM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();

if (isset($_POST['change_contact_security'])) {
    $matriId = $_SESSION['user_id'];
    $contactSecurity = $_POST['contact_security'] ?? "Visible";
    if($contactSecurity == "NotVisible") {
        $contactSecurity = "2";
    } else if($contactSecurity == "VisibleToSome") {
        $contactSecurity = "0";
    } else {
        $contactSecurity = "1";
    }
    $result = mysqli_query($DatabaseCo->dbLink, "update register set contact_view_security='$contactSecurity' where matri_id='" . $matriId . "'");
    if($result) {
        return print_r(json_encode(['result'=>'success', 'msg' => 'Contact Security Updated.']));
    } else {
        return print_r(json_encode(['result'=>'failed', 'msg' => 'Contact Security failed to Update.']));
    }
}
