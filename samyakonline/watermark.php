<?php
$watermark = !empty($_GET['watermark']) ? htmlspecialchars($_GET['watermark']) : "";
$image = !empty($_GET['image']) ? htmlspecialchars($_GET['image']) : "";

header('content-type: image/jpeg');
$watermark = imagecreatefrompng($watermark);
$watermark_width = imagesx($watermark);
$watermark_height = imagesy($watermark);
$image = imagecreatetruecolor($watermark_width, $watermark_height);
$image = imagecreatefromjpeg($image);
$size = getimagesize($image);
$dest_x = $size[0] - $watermark_width - 5;
$dest_y = $size[1] - $watermark_height - 5;
imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 100);
imagejpeg($image);
imagedestroy($image);
imagedestroy($watermark);