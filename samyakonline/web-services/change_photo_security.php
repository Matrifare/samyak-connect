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

if (isset($_POST['change_photo_security'])) {
    $matriId = $_SESSION['user_id'];
    $photoSecurity = $_POST['photo_security'] ?? "Visible";
    if($photoSecurity == "NotVisible") {
        $photoSecurity = "0";
    } else if($photoSecurity == "OnlyPaidMember"){
        $photoSecurity = "2";
    } else {
        $photoSecurity = "1";
    }
    $result = mysqli_query($DatabaseCo->dbLink, "update register set photo_view_status='$photoSecurity' where matri_id='" . $matriId . "'");
    if($result) {
        return print_r(json_encode(['result'=>'success', 'msg' => 'Photo Security Updated.']));
    } else {
        return print_r(json_encode(['result'=>'failed', 'msg' => 'Photo Security failed to Update.']));
    }
}
