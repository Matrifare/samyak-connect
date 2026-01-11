<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 14-12-2018
 * Time: 09:44 PM
 */

include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/xssClean.php';
$xssClean = new xssClean();
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';
$lostPhone = $_POST['forgot_mobile_no'] ?? "";
$phone = $xssClean->clean_input($lostPhone);
$from = $configObj->getConfigFrom();
$webfriendlyname = $configObj->getConfigFname();
$date = date('d M, Y');


function RandomPassword()
{
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime() * 1000000);
    $i = 0;
    $pass = '';
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

if (!empty($_POST['forgot_mobile_no']) && empty($_POST['otp'])) {
    $SQL_STATEMENT = $DatabaseCo->dbLink->query("select matri_id, username from register where (mobile='" . $phone . "' OR phone='" . $phone . "')
      AND status!='Suspended' LIMIT 1");
    if ($SQL_STATEMENT->num_rows > 0) {
        $result = mysqli_fetch_object($SQL_STATEMENT);

        $order_id = rand(1111, 9999);
        $_SESSION['otp'] = $order_id;
        $_SESSION['forgot_mobile'] = $phone;
        // Getting SMS API, if yes proceed furthur //
        $sql = "select * from sms_api where status='APPROVED'";
        $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
        $num_sms = mysqli_num_rows($rr);
        $sms = mysqli_fetch_object($rr);

        if ($num_sms > 0) {
            // Getting predefined SMS Template //
            $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'OTPPassword'");
            $rowcs5 = mysqli_fetch_array($result45);
            $message = $rowcs5['temp_value'];
            $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
            $trans = array("web_frienly_name" => $webfriendlyname, '****' => $_SESSION['otp']);
            $sms_template = strtr($sms_template, $trans);

            // Final action to send sms //
            $mno = $phone;
            $mobile = substr($mno, 0, 3);
            if ($mobile == '+91') {
                $mno = substr($mno, 3, 15);
            }
            send_to_curl($mno, $sms_template);
            return print_r(json_encode(array('result' => 'success', 'msg' => 'OTP Successfully sent to your mobile number')));
        }
    } else {
        return print_r(json_encode(array('result' => 'failed', 'msg' => 'Invalid Mobile Number Entered.')));
    }
} elseif (!empty($_POST['forgot_mobile_no']) && isset($_SESSION['forgot_mobile']) && $_SESSION['forgot_mobile'] == $_POST['forgot_mobile_no'] && !empty($_POST['otp'])) {

    if (trim($_POST['otp']) == $_SESSION['otp']) {
        $SQL_STATEMENT = $DatabaseCo->dbLink->query("select * from register_view r INNER JOIN payment_view p 
            ON r.matri_id=p.pmatri_id where (r.mobile='" . $phone . "' OR r.phone='" . $phone . "')
      AND r.status!='Suspended'");
        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
            $matri_id = $DatabaseCo->dbRow->matri_id;
            $username = $DatabaseCo->dbRow->username;
            $email = $DatabaseCo->dbRow->email;

            $pswd = rand(111111, 999999);
            $DatabaseCo->dbRow->pass = $pswd;
            $upasswd = md5($pswd);
            $sql = "update register set password='$upasswd' where matri_id='$matri_id'";
            $DatabaseCo->dbLink->query($sql) or mysqli_error();
            $subject = "Your new password for Samyakmatrimony";
            $template = get_email_template($DatabaseCo, $DatabaseCo->dbRow, '../email-templates/reset_password_email_template.php');
            send_email_from_samyak($configObj->getConfigFrom(), $email, $subject, $template);

            /*
                 * Message For Admin
                 */
            $subject = "Password Reset on samyakmatrimony : $matri_id";
            $message = "Name : " . $username . "<br/>"
                . "\r\n ------------------------------------" . "<br/>"
                . "\r\n Profile ID : " . $matri_id . "<br/>"
                . "\r\n Email ID : " . $email . "<br/>"
                . "\r\n Mobile : " . $_SESSION['forgot_mobile'] . "<br/>"
                . "\r\n IP Address : " . $_SERVER['REMOTE_ADDR'];
            $to = $configObj->getConfigTo();
            send_email_from_samyak($from, $to, $subject, $message);
            /*
             * End of Message for Admin
             */

            // Getting predefined SMS Template //
            $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'forgot_password_frontend'");
            $rowcs5 = mysqli_fetch_array($result45);
            $message = $rowcs5['temp_value'];
            $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
            $trans = array("web_frienly_name" => $webfriendlyname, '*password*' => $pswd, '*profileId*'=>$matri_id);
            $sms_template = strtr($sms_template, $trans);

            // Final action to send sms //
            $mno = $phone;
            $mobile = substr($mno, 0, 3);
            if ($mobile == '+91') {
                $mno = substr($mno, 3, 15);
            }
            send_to_curl($mno, $sms_template);
        }
        unset($_SESSION['forgot_mobile']);
        unset($_SESSION['otp']);
        return print_r(json_encode(array('result' => 'success','result1'=>'success_otp', 'msg' => 'Password successfully changed and sent to your Registered Email Id as well as on your mobile number.')));
    } else {
        return print_r(json_encode(['result' => 'failed', 'msg' => 'Invalid OTP']));
    }
} else {
    return print_r(json_encode(array('result' => 'failed', 'msg' => 'Some Error Occurred')));
}
