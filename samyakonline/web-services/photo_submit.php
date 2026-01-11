<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/4/2018
 * Time: 11:35 PM
 */

require_once '../DatabaseConnection.php';
require_once '../lib/resize_image.php';
include_once '../lib/Config.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

ini_set('memory_limit', -1);
ini_set('post_max_size', '32M');
ini_set('upload_max_filesize', '32M');

$matriId = $_SESSION['user_id'];
$photo = $_POST['photoNo'] ?? "";
$photoNo = substr(strrev($photo), 0, 1);

if (!empty($photo) && !empty($_FILES[$photo]['name'])) {
    $validextensions = array("jpeg", "jpg");
    $temporary = explode(".", $_FILES[$photo]["name"]);
    $file_extension = strtolower(end($temporary));

    if ((($_FILES[$photo]["type"] == "image/jpg") || ($_FILES[$photo]["type"] == "image/jpeg")
        ) && ($_FILES[$photo]["size"] < 5000000)//Approx. 5MB files can be uploaded.
        && in_array($file_extension, $validextensions)
    ) {
        if ($_FILES[$photo]["error"] > 0) {
            return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'Error in File.')));
        } else {
            if ($photoNo != 1) {
                $matriIdImage = trim($matriId . "_" . $photoNo . "." . $file_extension);
            } else {
                $matriIdImage = trim($matriId . "." . $file_extension);
            }
            $photo1 = str_replace(" ", "_", $_FILES[$photo]["name"]);
            //Saving Original Image
            if (!file_exists("../temp-images")) {
                mkdir('../temp-images', 0777, true);
            }
            move_uploaded_file($_FILES[$photo]["tmp_name"], "../temp-images/" . $matriIdImage);

            //Saving Big Image
            if (!file_exists("../photos_big")) {
                mkdir('../photos_big', 0777, true);
            }
            $bigImage = resizepics("../temp-images/" . $matriIdImage, "../photos_big/" . $matriIdImage, 360, 550);

            //Saving small Image
            if (!file_exists("../photos")) {
                mkdir('../photos', 0777, true);
            }
            $smallImage = resizepics("../photos_big/$matriIdImage", "../photos/$matriIdImage", 175, 300);
            if ($bigImage && $smallImage) {
                $photoDate = "";
                if($photo == 'photo1') {
                    $photoDate = ", photo1_update_date='".date('Y-m-d H:i:s')."'";
                }
                $DatabaseCo->dbLink->query("update register set " . $photo . "='" . $matriIdImage . "',
                 " . $photo . "_approve='UNAPPROVED' $photoDate where matri_id='" . $matriId . "'");
                unlink("../temp-images/" . $matriIdImage);
            } else {
                return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'File Upload Failed.')));
            }
            return print_r(json_encode(array('result' => 'success', 'flag' => 1, 'photoNo' => $photo, 'new_image' => "photos/$matriIdImage?v=" . uniqid(rand(99, 9999)))));
        }
    } else {
        return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'Invalid file Size or Type')));
    }
} else {
    return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'Photo not selected..')));
}
