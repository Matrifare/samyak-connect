<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/14/2018
 * Time: 1:49 PM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
include_once '../lib/Voicecall.php';
$configObj = new Config();
$webfriendlyname = $configObj->getConfigFname();
$website = $configObj->getConfigName();

$mid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
if (!empty($_POST['otp_send']) && $_POST['otp_send'] == 'true') {
    $select = mysqli_query($DatabaseCo->dbLink, "select email,matri_id,mobile from register where matri_id='" . $mid . "'");


    while ($row1 = mysqli_fetch_array($select)) {
        $order_id = rand(1111, 9999);
        $_SESSION['order_id'] = $order_id;

        // Getting SMS API, if yes proceed furthur //
        $sql = "select * from sms_api where status='APPROVED'";
        $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
        $num_sms = mysqli_num_rows($rr);
        $sms = mysqli_fetch_object($rr);


        if ($num_sms > 0) {
            // Getting predefined SMS Template //

            $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Mobile Verification'");
            $rowcs5 = mysqli_fetch_array($result45);
            $message = $rowcs5['temp_value'];
            $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
            $trans = array("web_frienly_name" => $webfriendlyname, '****' => $order_id);
            $sms_template = strtr($sms_template, $trans);

            // Final action to send sms //
            $mno = $row1['mobile'];
            $mobile = substr($mno, 0, 3);
            if ($mobile == '+91') {
                $mno = substr($mno, 3, 15);
            }
            include_once '../lib/curl.php';
            send_to_curl($mno, $sms_template);
            return print_r(json_encode(array('result' => 'success')));
        }
        return print_r(json_encode(array('result' => 'failed')));
    }
    return print_r(json_encode(array('result' => 'failed')));
} else {
    if (!empty($_POST['verify_otp']) && $_POST['verify_otp'] == 'true') {
        if (!empty($_SESSION['order_id']) && $_POST['otp_code'] == $_SESSION['order_id']) {
            unset($_SESSION['order_id']);
            unset($_SESSION['last_login']);
            mysqli_query($DatabaseCo->dbLink, "update register set mobile_verify_status='Yes' where matri_id='" . $mid . "'");

            //Make Voice Call
            $select = mysqli_query($DatabaseCo->dbLink, "select email,matri_id,mobile,status from register where matri_id='" . $mid . "'");

            while ($row1 = mysqli_fetch_array($select)) {
                $mno = $row1['mobile'];
                $memberStatus = $row1['status'];
            }
            if($memberStatus == 'Inactive') {
                $resultVoiceCall = $DatabaseCo->dbLink->query("SELECT * FROM voice_template where name = 'Registration' and status = 'Y'");

                if ($resultVoiceCall->num_rows > 0) {
                    $rowcs5 = mysqli_fetch_array($resultVoiceCall);
                    $fileName = $rowcs5['file_name'];
                    $fileName = htmlspecialchars_decode($fileName, ENT_QUOTES);
//                    make_voice_call($fileName, $mno);
                }
                //End of Making Voice Call
            }
            if (!isset($_SESSION['gender123']) && empty($_SESSION['gender123'])) {
                $query = "select email,matri_id,username,gender,index_id,status,mobile_verify_status,photo1 from register where matri_id='" . $mid . "'";

                $SQL_STATEMENT = $DatabaseCo->dbLink->query($query);

                //$statusObj = handle_post_request("LOGIN",$SQL_STATEMENT,$DatabaseCo);

                if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                    $_SESSION['user_name'] = $DatabaseCo->dbRow->email;
                    $_SESSION['user_id'] = $DatabaseCo->dbRow->matri_id;
                    $_SESSION['uname'] = $DatabaseCo->dbRow->username;
                    $_SESSION['gender123'] = $DatabaseCo->dbRow->gender;
                    $_SESSION['uid'] = $DatabaseCo->dbRow->index_id;
                    $_SESSION['email'] = $DatabaseCo->dbRow->email;
                    $_SESSION['mem_status'] = $DatabaseCo->dbRow->status;
                    $_SESSION['photo1'] = isset($DatabaseCo->dbRow->photo1) ? $DatabaseCo->dbRow->photo1 : '';
                    $email = $_SESSION['email'];
                    $browser = $_SERVER['HTTP_USER_AGENT'];
                    $url = $_SERVER['HTTP_HOST'];
                    $ip = $_SERVER['SERVER_ADDR'];
                    $tm = mktime(date('h'), date('i'), date('s'));
                    $login_dt = date('Y-m-d h:i:s', $tm);
                    $date2 = date("d F ,Y", (strtotime($login_dt)));

                    if ($DatabaseCo->dbRow->mobile_verify_status == 'No') {
                        $_SESSION['last_login'] = 'first_time';
                    }

                    $sql = "UPDATE register set last_login='$login_dt' WHERE matri_id='" . $mid . "'";

                    $DatabaseCo->dbLink->query($sql);
                    if (isset($getdata) && $getdata != '') {
                        header('location: premium_member_view_cart');
                    } else {
                        return print_r(json_encode(array('result' => 'success')));
                    }
                }
            } else {
                return print_r(json_encode(array('result' => 'success')));
            }
            return print_r(json_encode(array('result' => 'success')));
        } else {
            return print_r(json_encode(array('result' => 'password')));
        }
    }
}