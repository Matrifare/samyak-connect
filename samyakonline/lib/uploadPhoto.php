<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/3/2018
 * Time: 12:44 AM
 */
include('smart_resize_image.php');
$path = "photos_big/";
$flag = 0;
$valid_formats = array("jpg", "png", "gif", "bmp", "JPG", "JPEG", "jpeg");
$name = $_FILES[0]['name'];
$size = $_FILES[0]['size'];
$result = array();
try {
    if (strlen($name)) {
        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {
            if ($size < (2 * 1048576)) {
                $actual_image_name = str_replace(' ', '_', $_FILES[0]['name']);
                $file = $_FILES[0]['tmp_name'];
                //indicate the path and name for the new resized file
                $resizedFile = $path . $actual_image_name;
                if (smart_resize_image($file, null, 720, 450, true, $resizedFile, false, false, 100)) {
                    //echo "<img src='photos_big/".$actual_image_name."'  class='resize-image'>";
                    $result['flag'] = 1;
                    $result['imageName'] = $actual_image_name;
                } else {
                    $result['flag'] = 2;
                    $result['msg'] = "Some Serious Issue Occurred in uploading image.";
                }
            } else {
                $result['flag'] = 2;
                $result['msg'] = "Maximum Image Size should be 2 MB";
            }
        } else {
            $result['flag'] = 2;
            $result['msg'] = 'Invalid file format..';
        }
    } else {
        $result['flag'] = 2;
        $result['msg'] = 'Profile picture is not selected.';
    }
} catch (Exception $ex) {
    $result['flag'] = 2;
    $result['msg'] = "Some Serious Issue Occurred in uploading image.";
}
return $result;