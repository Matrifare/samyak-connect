<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/25/2018
 * Time: 1:11 AM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/xssClean.php';
$xssClean = new xssClean();
include_once '../lib/curl.php';
include_once '../lib/Voicecall.php';
include_once '../lib/sendmail.php';
$matid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$sel = $DatabaseCo->dbLink->query("select r.index_id, r.matri_id, r.username, r.birthdate, r.height, r.edu_name,
 r.ocp_name, r.city_name, r.family_city,
 r.mobile, r.phone, p.p_msg, p.r_sms, p.exp_date from register_view r INNER JOIN payment_view p
  on r.matri_id=p.pmatri_id where pmatri_id='$matid'");
$fet = mysqli_fetch_array($sel);
$tot_contacts = $fet['p_msg'];
$use_contacts = $fet['r_sms'];
$use_contacts = $use_contacts + 1;

$exp_date = date('Y-m-d', strtotime($fet['exp_date']));
$today = date('Y-m-d');

if ($tot_contacts >= $use_contacts && $exp_date > $today) {
    if (isset($_POST['toId'])) {
        if (!empty($_POST['toId']) && $val = $_POST['toId']) {
            $from_id = $_SESSION['user_id'];
            $get_to_id = mysqli_fetch_object($DatabaseCo->dbLink->query("select matri_id,email from register where matri_id='" . $val . "'"));
            $to_id = $get_to_id->matri_id;
            $sel = $DatabaseCo->dbLink->query("select * from  block_profile where block_by='$to_id' and block_to='$from_id'");

            $num = mysqli_num_rows($sel);
            if (isset($num) && $num > 0) {
                return print_r(json_encode(array('result' => 'blocked', 'toId' => $to_id)));
            } else {
                $from_email = $_SESSION['email'];
                $to_email = $get_to_id->email;

                //$subject = htmlspecialchars($xssClean->clean_input($_POST['subject']), ENT_QUOTES);
                $subject = "Send Message from " . $_SESSION['user_id'] . " to " . $val;
                $msg_content = htmlspecialchars($xssClean->clean_input($_POST['msg_text']), ENT_QUOTES);

                if (!empty($_POST['type']) && $_POST['type'] == 'sms') {
                    $ao3 = $fet['height'];
                    $ft3 = (int)($ao3 / 12);
                    $inch3 = $ao3 % 12;
                    $height = $ft3 . "ft" . " " . $inch3 . "in";
                    $age = floor((time() - strtotime($fet['birthdate'])) / 31556926);

                    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'SendSMS'");
                    $rowcs5 = mysqli_fetch_array($result45);
                    $message = $rowcs5['temp_value'];
                    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                    $trans = array('*profile*'=>$matid, '*username*'=>$fet['username'], '*age*'=>$age, '*height*'=>$height,
                        '*edu_name*'=>$fet['edu_name'], '*ocp_name*'=>$fet['ocp_name'], '*city*'=>$fet['city_name'], '*phone*'=>$fet['phone'],
                        '*family_origin*'=>$fet['family_city'], '*mobile*'=>$fet['mobile'], '*profileLink*'=>dechex($fet['index_id']*726925));

                    $msg_content = strtr($sms_template, $trans);
                }

                $DatabaseCo->dbLink->query("insert into message(msg_id,msg_to,msg_from,msg_subject,msg_content,msg_status,msg_important_status,msg_date) values(NULL,'$to_email','$from_email','" . $subject . "','" . $msg_content . "','sent','No','" . date('Y-m-d H:i:s') . "')");

                $sel = $DatabaseCo->dbLink->query("SELECT * FROM payments where pmatri_id='$matid'");
                $fet = mysqli_fetch_array($sel);
                $tot_sms = $fet['p_msg'];
                $use_sms = $fet['r_sms'];
                $use_sms = $use_sms + 1;
                if ($tot_sms >= $use_sms) {
                    $update = "UPDATE payments SET r_sms='$use_sms' WHERE pmatri_id='$matid' ";
                    $d = $DatabaseCo->dbLink->query($update);
                }

                $result3 = $DatabaseCo->dbLink->query("SELECT * FROM register r INNER JOIN payments p 
                    ON r.matri_id=p.pmatri_id where r.matri_id = '$to_id'");
                $rowcc = mysqli_fetch_array($result3);
                $name = $rowcc['firstname'] . " " . $rowcc['lastname'];
                $matriid = $rowcc['matri_id'];
                $to = $rowcc['email'];
                $name = $rowcc['username'];
                $mno = $rowcc['mobile'];

                $result21 = $DatabaseCo->dbLink->query("SELECT * FROM register where matri_id = '$from_id'");
                $rowcc1 = mysqli_fetch_array($result21);

                $frm_email = $from_email;  //$configObj->getConfigFrom();
                $tempData = array(
                    'myData' => (Object) $rowcc1,
                    'viewedData' => (Object) $rowcc
                );
                $subject = 'New Message Received on Samyakmatrimony';
                $template = get_email_template($DatabaseCo, $tempData, '../email-templates/new_message_email_template.php');
                $messageStatus = send_email_from_samyak($frm_email, $to, $subject, $template);

                if ($messageStatus == true) {
                    $success = true;
                } else {
                    $error = true;
                }

                // Getting SMS API, if yes proceed furthur //
                $sql = "select * from sms_api where status='APPROVED'";
                $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
                $num_sms = mysqli_num_rows($rr);
                $sms = mysqli_fetch_object($rr);
                if ($num_sms > 0) {
                    // Getting predefined SMS Template //
                    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Message Received'");
                    $rowcs5 = mysqli_fetch_array($result45);
                    $message = $rowcs5['temp_value'];
                    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                    $trans = array("web_frienly_name" => 'Samyakmatrimony', 'XXXnameXXX' => $_SESSION['user_id']);
                    if (!empty($_POST['type']) && $_POST['type'] == 'sms') {
                        $sms_template = $msg_content;
                    } else {
                        $sms_template = strtr($sms_template, $trans);
                    }
                    // Final action to send sms //
                    $mobile = substr($mno, 0, 3);
                    if ($mobile == '+91') {
                        $mno = substr($mno, 3, 15);
                    } else {
                        $mno = $mno;
                    }

                    send_to_curl($mno, $sms_template);
                }


                //Make Voice Call
                $resultVoiceCall = $DatabaseCo->dbLink->query("SELECT * FROM voice_template where name = 'MessageReceived' and status = 'Y'");
                if($resultVoiceCall->num_rows > 0) {
                    $rowcs5 = mysqli_fetch_array($resultVoiceCall);
                    $fileName = $rowcs5['file_name'];
                    $fileName = htmlspecialchars_decode($fileName, ENT_QUOTES);
                    make_voice_call($fileName, $mno);
                }
                //End of Making Voice Call
            }
        }
        return print_r(json_encode(array('result' => 'success', 'toId' => $_POST['toId'])));
    }
} else {
    return print_r(json_encode(array('result' => 'expired')));
}