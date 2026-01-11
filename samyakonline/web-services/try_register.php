<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10/29/2018
 * Time: 8:40 PM
 */

require_once '../DatabaseConnection.php';
include_once '../lib/sendmail.php';

// Don't suppress errors in development, but log them
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$DatabaseCo = new DatabaseConnection();

// Sanitize and validate inputs
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : false;
$first_name = isset($_POST['first_name']) ? htmlspecialchars(trim($_POST['first_name']), ENT_QUOTES, 'UTF-8') : '';
$last_name = isset($_POST['last_name']) ? htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8') : '';
$mobile_no = isset($_POST['mobile_no']) ? preg_replace('/[^0-9+\-\s]/', '', trim($_POST['mobile_no'])) : '';
$phoneNo = isset($_POST['alternate_no']) ? preg_replace('/[^0-9+\-\s]/', '', trim($_POST['alternate_no'])) : '';
$referred_by = isset($_POST['referred_by']) ? htmlspecialchars(trim($_POST['referred_by']), ENT_QUOTES, 'UTF-8') : '';

// Validate email
if (!$email) {
    echo json_encode(array('result' => 'failed', 'flag' => 3, 'msg' => 'Invalid email address'));
    exit;
}

// Validate required fields
if (empty($first_name) || empty($mobile_no)) {
    echo json_encode(array('result' => 'failed', 'flag' => 4, 'msg' => 'Required fields are missing'));
    exit;
}

// Limit field lengths
$first_name = substr($first_name, 0, 50);
$last_name = substr($last_name, 0, 50);
$mobile_no = substr($mobile_no, 0, 20);
$phoneNo = substr($phoneNo, 0, 20);
$referred_by = substr($referred_by, 0, 100);

$ip = $_SERVER['REMOTE_ADDR'];
$name = $first_name . " " . $last_name;

// Get config using prepared statement or direct query (assuming site_config is admin-only table)
$result3 = $DatabaseCo->dbLink->query("SELECT from_email, to_email FROM site_config LIMIT 1");
$rowcc = mysqli_fetch_array($result3);

if (!$rowcc) {
    echo json_encode(array('result' => 'failed', 'flag' => 5, 'msg' => 'Configuration error'));
    exit;
}

$from = $rowcc['from_email'];
$to = $rowcc['to_email'];

// Check if email exists using prepared statement
$stmt = $DatabaseCo->dbLink->prepare("SELECT email FROM register WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$isEmailAvailable = $result->num_rows;
$stmt->close();

if ($isEmailAvailable > 0) {
    echo json_encode(array('result' => 'failed', 'flag' => 2, 'msg' => 'Email already exists'));
    exit;
}

/*
 * Message For Admin - Sanitized for email
 */
$subject = "Tried Registration on samyakmatrimony : " . $name;
$message = "Name : " . $name . "<br/>"
    . "\r\n ------------------------------------" . "<br/>"
    . "\r\n Email ID : " . $email . "<br/>"
    . "\r\n Mobile : " . $mobile_no . "<br/>"
    . "\r\n Alternate Mobile : " . $phoneNo . "<br/>"
    . "\r\n Referred By : " . $referred_by . "<br/>"
    . "\r\n IP Address : " . htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');

send_email_from_samyak($from, $to, $subject, $message);

echo json_encode(array('result' => 'success', 'msg' => 'Registration attempt recorded'));
