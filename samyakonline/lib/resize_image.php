<?php
ini_set('memory_limit', -1);
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/4/2018
 * Time: 7:36 PM
 */
// $picname = resizepics('pics', 'new widthmax', 'new heightmax');
// Demo  $picname = resizepics('stihche.jpg', '180', '140');
//$picname = resizepics('photo0406.jpg', '180', '240');
//echo $picname;
//Error
//die( "<font color=\"#FF0066\"><center><b>File not exists :(<b></center></FONT>");
//Funcion resizepics
function resizepics($pics, $imagePath = null, $newwidth, $newheight){
    try {
        list($width, $height) = getimagesize($pics);
        if($width > $height && $newheight < $height){
            $newheight = $height / ($width / $newwidth);
        } else if ($width < $height && $newwidth < $width) {
            $newwidth = $width / ($height / $newheight);
        } else {
            $newwidth = $width;
            $newheight = $height;
        }

        if(preg_match("/.jpg/i", "$pics")){
            $source = imagecreatefromjpeg($pics);
        }
        if(preg_match("/.jpeg/i", "$pics")){
            $source = imagecreatefromjpeg($pics);
        }
        if(preg_match("/.jpeg/i", "$pics")){
            $source = Imagecreatefromjpeg($pics);
        }
        if(preg_match("/.png/i", "$pics")){
            $source = imagecreatefrompng($pics);
        }
        if(preg_match("/.gif/i", "$pics")){
            $source = imagecreatefromgif($pics);
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($thumb, $imagePath, 80);
        imagedestroy($thumb);
        imagedestroy($source);
        return true;
    } catch (Exception $ex) {
        print_r("Something went wrong");
        exit;
    }


    /*if(preg_match("/.jpg/i", "$pics")){
        return imagejpeg($thumb);
    }
    if(preg_match("/.jpeg/i", "$pics")){
        return imagejpeg($thumb);
    }
    if(preg_match("/.jpeg/i", "$pics")){
        return imagejpeg($thumb);
    }
    if(preg_match("/.png/i", "$pics")){
        return imagepng($thumb);
    }
    if(preg_match("/.gif/i", "$pics")){
        return imagegif($thumb);
    }*/
}
?>