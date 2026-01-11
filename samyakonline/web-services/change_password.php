<?php
/**
 * Secure Password Change Web Service
 * Uses prepared statements and Argon2ID password hashing
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
include_once '../lib/Security.php';

$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/xssClean.php';
$xssClean = new xssClean();
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';

if (isset($_POST['change_password'])) {
    $uname = $_SESSION['user_id'] ?? '';
    $oldPassword = trim($_POST['old_pass'] ?? '');
    $newPassword = trim($_POST['new_pass'] ?? '');
    $confirmPassword = trim($_POST['cnfm_pass'] ?? '');
    
    // Validate inputs
    if (empty($uname)) {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'Session expired. Please login again.')));
    }
    
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'All password fields are required')));
    }
    
    if ($newPassword != $confirmPassword) {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'New Password and Confirm Password not matched')));
    }
    
    if (strlen($newPassword) < 8) {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'Password must be at least 8 characters')));
    }
    
    // Get user data with prepared statement
    $stmt = $DatabaseCo->dbLink->prepare(
        "SELECT index_id, password, password_hash, email, username, mobile 
         FROM register WHERE matri_id = ?"
    );
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows != 1) {
        $stmt->close();
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'User not found')));
    }
    
    $user = $result->fetch_object();
    $stmt->close();
    
    // Verify old password
    $passwordValid = false;
    
    // Check modern password hash first (Argon2ID or bcrypt)
    if (!empty($user->password_hash)) {
        $passwordValid = password_verify($oldPassword, $user->password_hash);
    }
    // Fallback: Check legacy MD5 hash
    elseif (!empty($user->password) && $user->password === md5($oldPassword)) {
        $passwordValid = true;
    }
    
    if (!$passwordValid) {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'Old Password is incorrect')));
    }
    
    // Hash new password with Argon2ID
    $newPasswordHash = password_hash($newPassword, PASSWORD_ARGON2ID, [
        'memory_cost' => 65536,
        'time_cost' => 4,
        'threads' => 3
    ]);
    
    // Update password with prepared statement (clear legacy MD5, set new hash)
    $stmt = $DatabaseCo->dbLink->prepare(
        "UPDATE register SET password = '', password_hash = ? WHERE matri_id = ?"
    );
    $stmt->bind_param("ss", $newPasswordHash, $uname);
    $stmt->execute();
    $stmt->close();
    
    // Get site config for email
    $result3 = $DatabaseCo->dbLink->query("SELECT * FROM site_config LIMIT 1");
    $siteConfig = mysqli_fetch_array($result3);
    
    $name = $user->username;
    $matriid = $uname;
    $website = $siteConfig['web_name'] ?? '';
    $webfriendlyname = $siteConfig['web_frienly_name'] ?? '';
    $from = $siteConfig['from_email'] ?? '';
    $to = $user->email;
    $mno = $user->mobile;
    
    // Get email template
    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM email_templates WHERE EMAIL_TEMPLATE_NAME = 'Change Password'");
    $rowcs5 = mysqli_fetch_array($result45);

    $subject = $rowcs5['EMAIL_SUBJECT'] ?? 'Password Changed';
    $message = $rowcs5['EMAIL_CONTENT'] ?? '';
    $email_template = htmlspecialchars_decode($message, ENT_QUOTES);

    // Note: We're not sending the actual password in the email for security
    $trans = array("../images" => $website . "images", "matriid" => $matriid, "xxxxx" => "********");
    $email_template = strtr($email_template, $trans);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:' . $from . "\r\n";

    send_email_from_samyak($to, $subject, $email_template, $headers);

    // SMS notification
    $sql = "SELECT * FROM sms_api WHERE status='APPROVED'";
    $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
    $num_sms = mysqli_num_rows($rr);
    $sms = mysqli_fetch_object($rr);

    if ($num_sms > 0) {
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete WHERE temp_name = 'Change Password'");
        $rowcs5 = mysqli_fetch_array($result45);
        $message = $rowcs5['temp_value'] ?? '';
        $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
        // Note: Not sending actual password in SMS for security
        $trans = array("web_frienly_name" => $webfriendlyname, "*password*" => "********");
        $sms_template = strtr($sms_template, $trans);

        $mobile = substr($mno, 0, 3);
        if ($mobile == '+91') {
            $mno = substr($mno, 3, 15);
        }
        send_to_curl($mno, $sms_template);
    }
    
    return print_r(json_encode(array('result' => 'success', 'msg' => 'Password successfully changed')));
}
