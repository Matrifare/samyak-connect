<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/24/2018
 * Time: 12:55 AM
 */

require_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
include_once '../auth.php';

$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

// Validate session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode(array('result' => 'failed', 'msg' => 'Unauthorized access'));
    exit;
}

$userId = $_SESSION['user_id'];

// Validate and sanitize inputs
$photoVisibility = isset($_POST['photo_visibility']) ? (int)$_POST['photo_visibility'] : -1;
$photoPass = isset($_POST['photo_pass']) ? trim($_POST['photo_pass']) : '';
$remove = isset($_POST['remove']) ? trim($_POST['remove']) : '';

// Validate photoVisibility is within expected range
if (!in_array($photoVisibility, [0, 1, 2])) {
    echo json_encode(array('result' => 'failed', 'msg' => 'Invalid photo visibility option'));
    exit;
}

// Sanitize photo password (limit length and remove dangerous characters)
$photoPass = substr($photoPass, 0, 50);
$photoPass = htmlspecialchars($photoPass, ENT_QUOTES, 'UTF-8');

if ($photoVisibility == 1) {
    // Visible to all - clear password protection
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE register SET photo_view_status = ?, photo_pswd = '', photo_protect = 'No' WHERE matri_id = ?");
    $stmt->bind_param("is", $photoVisibility, $userId);
    
    if ($stmt->execute()) {
        $stmt->close();
        echo json_encode(array('result' => 'success', 'msg' => 'Photo Visibility successfully set to visible.'));
    } else {
        $stmt->close();
        echo json_encode(array('result' => 'failed', 'msg' => 'Photo Visibility failed to set.'));
    }
} else if ($photoVisibility == 2 || $photoVisibility == 0) {
    // Protected visibility
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE register SET photo_view_status = ?, photo_pswd = ?, photo_protect = 'Yes' WHERE matri_id = ?");
    $stmt->bind_param("iss", $photoVisibility, $photoPass, $userId);
    
    if ($stmt->execute()) {
        $stmt->close();
        $msg = "";
        if ($photoVisibility == 2) {
            $msg = "Paid Members Only.";
        } else if ($photoVisibility == 0) {
            $msg = "Hidden from all members.";
        }
        echo json_encode(array('result' => 'success', 'msg' => 'Photo Visibility successfully set to ' . $msg));
    } else {
        $stmt->close();
        echo json_encode(array('result' => 'failed', 'msg' => 'Photo Visibility failed to set.'));
    }
}
