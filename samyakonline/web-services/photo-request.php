<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10-01-2019
 * Time: 10:10 PM
 */

include_once '../DatabaseConnection.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';

// Validate session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode(['result' => 'error', 'msg' => 'Unauthorized access']);
    exit;
}

$matriId = isset($_POST['matri_id']) ? trim($_POST['matri_id']) : '';

// Validate matriId format (alphanumeric only)
if (empty($matriId) || !preg_match('/^[a-zA-Z0-9]+$/', $matriId)) {
    echo json_encode(['result' => 'error', 'msg' => 'Invalid profile ID']);
    exit;
}

// Get SMS template using prepared statement
$stmtTemplate = $DatabaseCo->dbLink->prepare("SELECT temp_value FROM sms_templete WHERE temp_name = ?");
$templateName = 'PhotoRequest';
$stmtTemplate->bind_param("s", $templateName);
$stmtTemplate->execute();
$templateResult = $stmtTemplate->get_result();
$rowcs5 = $templateResult->fetch_assoc();
$stmtTemplate->close();

if (!$rowcs5) {
    echo json_encode(['result' => 'error', 'msg' => 'Template not found']);
    exit;
}

$message = $rowcs5['temp_value'];
$sms_template = htmlspecialchars_decode($message, ENT_QUOTES);

// Get user details using prepared statement
$stmtUser = $DatabaseCo->dbLink->prepare("SELECT r.*, p.p_plan FROM register_view r 
    INNER JOIN payment_view p ON r.matri_id = p.pmatri_id WHERE r.matri_id = ?");
$stmtUser->bind_param("s", $matriId);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$row = $userResult->fetch_assoc();
$stmtUser->close();

if (!$row) {
    echo json_encode(['result' => 'error', 'msg' => 'Profile not found']);
    exit;
}

$email = $row['email'];
$subject = 'Received Photo Upload Request on Samyakmatrimony';
$template = get_email_template($DatabaseCo, $row, '../email-templates/photo_request_email_template.php');
send_email_from_samyak($configObj->getConfigFrom(), $email, $subject, $template);

$sessionUserId = htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8');
$trans = array(
    "*profileId*" => strtoupper(htmlspecialchars($matriId, ENT_QUOTES, 'UTF-8')), 
    "*otherProfileId" => strtoupper($sessionUserId)
);
$sms_template1 = strtr($sms_template, $trans);

$mno = $row['mobile'];
$mobile = substr($mno, 0, 3);
if ($mobile == '+91') {
    $mno = substr($mno, 3, 15);
}

// Validate mobile number before sending
$mno = preg_replace('/[^0-9]/', '', $mno);
if (!empty($mno) && strlen($mno) >= 10) {
    send_to_curl($mno, $sms_template1);
}

echo json_encode(['result' => 'success', 'msg' => 'Photo Request sent successfully.']);
