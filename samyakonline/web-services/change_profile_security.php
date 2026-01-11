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

if (isset($_POST['change_profile_security'])) {
    $matriId = $_SESSION['user_id'];
    $profileSecurity = $_POST['profile_security'] ?? "Visible";
    if($profileSecurity == "NotVisible") {
        $profileSecurity = "2";
    } else {
        $profileSecurity = "1";
    }
    $result = mysqli_query($DatabaseCo->dbLink, "update register set fb_id='$profileSecurity' where matri_id='" . $matriId . "'");
    if($result) {
        return print_r(json_encode(['result'=>'success', 'msg' => 'Profile Security Updated.']));
    } else {
        return print_r(json_encode(['result'=>'failed', 'msg' => 'Profile Security failed to Update.']));
    }
}
