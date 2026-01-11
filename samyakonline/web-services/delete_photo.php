<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/6/2018
 * Time: 1:40 AM
 */

require_once '../DatabaseConnection.php';
require_once '../lib/resize_image.php';
include_once '../lib/Config.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

$matriId = $_SESSION['user_id'];
$photo = $_POST['photo'] ?? "";
$photoNo = substr(strrev($photo), 0, 1);
$Row = mysqli_fetch_object($DatabaseCo->dbLink->query("select matri_id,$photo,gender from register_view where matri_id='" . $matriId . "'"));

$matriIdImage = $Row->$photo;
if ($Row->gender == 'Groom') {
    $new_image = "img/default-photo/male-200.png";
} else {
    $new_image = "img/default-photo/female-200.png";
}
if (file_exists('../photos/' . $matriIdImage)) {
    unlink('../photos/' . $matriIdImage);
}
if (file_exists('../photos_big/' . $matriIdImage)) {
    unlink('../photos_big/' . $matriIdImage);
}
$deletePhoto = $DatabaseCo->dbLink->query("update register set " . $photo . "='', " . $photo . "_approve='UNAPPROVED' where matri_id='" . $matriId . "'");

if (!file_exists('../photos/' . $matriIdImage) && !file_exists('../photos_big/' . $matriIdImage) && $deletePhoto) {
    return print_r(json_encode(array('result' => 'success', 'flag' => 1, 'photoNo' => $photo, 'new_image' => $new_image . "?v=" . uniqid(rand(99, 9999)))));
} else {
    return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'photoNo' => $photoNo,)));
}
