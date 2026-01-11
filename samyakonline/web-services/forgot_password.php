<?php
/**
 * Secure Forgot Password Web Service
 * Uses prepared statements and Argon2ID password hashing
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../lib/Security.php';

$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/xssClean.php';
$xssClean = new xssClean();
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';

$lostEmail = $_POST['lost_email'] ?? "";
$email = Security::sanitizeEmail($lostEmail);
$from = $configObj->getConfigFrom();
$date = date('d M, Y');

if (empty($email) || !Security::isValidEmail($email)) {
    return print_r(json_encode(array('result' => 'failed', 'msg' => 'Please enter a valid email address')));
}

// Use prepared statement to get user
$stmt = $DatabaseCo->dbLink->prepare(
    "SELECT r.*, p.p_plan 
     FROM register_view r 
     INNER JOIN payment_view p ON r.matri_id = p.pmatri_id 
     WHERE r.email = ? AND r.status != 'Suspended'"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$SQL_STATEMENT = $stmt->get_result();

if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
    $matri_id = $DatabaseCo->dbRow->matri_id;
    $username = $DatabaseCo->dbRow->username;
    
    // Generate secure random password
    $pswd = bin2hex(random_bytes(4)); // 8 character random password
    
    // Hash password with Argon2ID instead of MD5
    $passwordHash = password_hash($pswd, PASSWORD_ARGON2ID, [
        'memory_cost' => 65536,
        'time_cost' => 4,
        'threads' => 3
    ]);
    
    $DatabaseCo->dbRow->pass = $pswd;
    
    // Update password with prepared statement (clear legacy MD5, set new hash)
    $stmt2 = $DatabaseCo->dbLink->prepare(
        "UPDATE register SET password = '', password_hash = ? WHERE email = ?"
    );
    $stmt2->bind_param("ss", $passwordHash, $email);
    $result = $stmt2->execute();
    $stmt2->close();
    
    if (!$result) {
        $stmt->close();
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'Failed to reset password. Please try again.')));
    }

    $subject = "Your new password for Samyakmatrimony";
    $template = get_email_template($DatabaseCo, $DatabaseCo->dbRow, '../email-templates/reset_password_email_template.php');
    send_email_from_samyak($from, $email, $subject, $template);
    
    $stmt->close();
    return print_r(json_encode(array('result' => 'success', 'msg' => 'Password successfully changed and sent to your Registered Email Id.')));
} else {
    $stmt->close();
    return print_r(json_encode(array('result' => 'failed', 'msg' => 'Invalid Email Id Entered')));
}
