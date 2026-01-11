<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/24/2018
 * Time: 11:38 PM
 */

include_once('../DatabaseConnection.php');
include_once '../auth.php';
include_once '../lib/sendmail.php';
include_once '../lib/Config.php';

$configObj = new Config();
$from = $configObj->getConfigFrom();
$to = $configObj->getConfigTo();
$mid = isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8') : 0;

// Sanitize and validate mobile number
$mobile_no = isset($_POST['mobile_no_query']) ? trim($_POST['mobile_no_query']) : '';
$mobile_no = preg_replace('/[^0-9+\-\s]/', '', $mobile_no); // Allow only digits, +, -, and spaces

if (empty($mobile_no)) {
    echo json_encode(array('result' => 'error', 'msg' => 'Invalid mobile number'));
    exit;
}

$subject = "Membership Enquiry on Samyakmatrimony : " . htmlspecialchars($mid, ENT_QUOTES, 'UTF-8');
$message = "Mobile : " . htmlspecialchars($mobile_no, ENT_QUOTES, 'UTF-8') . "<br/>";

send_email_from_samyak($from, $to, $subject, $message);
echo json_encode(array('result' => 'success'));
