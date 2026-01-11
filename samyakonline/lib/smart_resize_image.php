<?php
/**
 * Secure Image Resize Function
 * Fixes: Command injection vulnerability, uses safe file deletion
 * 
 * @param  string|null $file - file path to resize
 * @param  string|null $string - The image data, as a string
 * @param  int $width - new image width
 * @param  int $height - new image height
 * @param  bool $proportional - keep image proportional, default is true
 * @param  string $output - name of the new file (include path if needed) or 'browser', 'return'
 * @param  bool $delete_original - if true the original image will be deleted
 * @param  bool $use_linux_commands - DEPRECATED: ignored for security, always uses unlink()
 * @param  int $quality - enter 1-100 (100 is best quality) default is 100
 * @return bool|resource
 */
function smart_resize_image(
    $file,
    $string = null,
    $width = 0,
    $height = 0,
    $proportional = true,
    $output = 'file',
    $delete_original = true,
    $use_linux_commands = false,  // DEPRECATED: ignored for security
    $quality = 100
) {
    // Validate dimensions
    if ($height <= 0 && $width <= 0) {
        return false;
    }
    
    if ($file === null && $string === null) {
        return false;
    }
    
    // Validate file exists and is readable
    if ($file !== null) {
        // Prevent path traversal attacks
        $file = realpath($file);
        if ($file === false || !is_file($file) || !is_readable($file)) {
            error_log("smart_resize_image: Invalid or unreadable file");
            return false;
        }
    }

    // Get image info and validate it's actually an image
    $info = $file !== null ? @getimagesize($file) : @getimagesizefromstring($string);
    
    if ($info === false) {
        error_log("smart_resize_image: Not a valid image file");
        return false;
    }
    
    // Only allow common image types
    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
    if (!in_array($info[2], $allowedTypes)) {
        error_log("smart_resize_image: Unsupported image type");
        return false;
    }

    $image = null;
    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
    $cropHeight = $cropWidth = 0;

    // Calculate proportional dimensions
    if ($proportional) {
        if ($width == 0) {
            $factor = $height / $height_old;
        } elseif ($height == 0) {
            $factor = $width / $width_old;
        } else {
            $factor = min($width / $width_old, $height / $height_old);
        }

        $final_width = round($width_old * $factor);
        $final_height = round($height_old * $factor);
    } else {
        $final_width = ($width <= 0) ? $width_old : $width;
        $final_height = ($height <= 0) ? $height_old : $height;
        $widthX = $width_old / $width;
        $heightX = $height_old / $height;

        $x = min($widthX, $heightX);
        $cropWidth = ($width_old - $width * $x) / 2;
        $cropHeight = ($height_old - $height * $x) / 2;
    }

    // Load image into memory according to type
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $image = $file !== null ? @imagecreatefromjpeg($file) : @imagecreatefromstring($string);
            break;
        case IMAGETYPE_GIF:
            $image = $file !== null ? @imagecreatefromgif($file) : @imagecreatefromstring($string);
            break;
        case IMAGETYPE_PNG:
            $image = $file !== null ? @imagecreatefrompng($file) : @imagecreatefromstring($string);
            break;
        default:
            return false;
    }
    
    if (!$image) {
        error_log("smart_resize_image: Failed to load image");
        return false;
    }

    // Create resized image with transparency support
    $image_resized = imagecreatetruecolor($final_width, $final_height);
    
    if (!$image_resized) {
        imagedestroy($image);
        return false;
    }
    
    // Preserve transparency for GIF and PNG
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $transparency = imagecolortransparent($image);
        $palletsize = imagecolorstotal($image);

        if ($transparency >= 0 && $transparency < $palletsize) {
            $transparent_color = imagecolorsforindex($image, $transparency);
            $transparency = imagecolorallocate(
                $image_resized,
                $transparent_color['red'],
                $transparent_color['green'],
                $transparent_color['blue']
            );
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
        } elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    }
    
    // Perform the resize
    imagecopyresampled(
        $image_resized,
        $image,
        0, 0,
        $cropWidth, $cropHeight,
        $final_width, $final_height,
        $width_old - 2 * $cropWidth,
        $height_old - 2 * $cropHeight
    );

    // SECURITY FIX: Delete original using unlink() only (never exec())
    if ($delete_original && $file !== null && is_file($file)) {
        // Use unlink() - NEVER use exec() with user-controlled paths
        @unlink($file);
    }

    // Prepare output destination
    $outputPath = null;
    switch (strtolower($output)) {
        case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $outputPath = null;
            break;
        case 'file':
            $outputPath = $file;
            break;
        case 'return':
            imagedestroy($image);
            return $image_resized;
        default:
            $outputPath = $output;
            break;
    }

    // Write image according to type
    $success = false;
    switch ($info[2]) {
        case IMAGETYPE_GIF:
            $success = imagegif($image_resized, $outputPath);
            break;
        case IMAGETYPE_JPEG:
            $success = imagejpeg($image_resized, $outputPath, $quality);
            break;
        case IMAGETYPE_PNG:
            $pngQuality = 9 - (int)((0.9 * $quality) / 10.0);
            $success = imagepng($image_resized, $outputPath, $pngQuality);
            break;
        default:
            $success = false;
    }
    
    // Clean up
    imagedestroy($image);
    imagedestroy($image_resized);

    return $success;
}
