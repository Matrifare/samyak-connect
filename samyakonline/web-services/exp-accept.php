<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/13/2018
 * Time: 12:21 AM
 */
include_once '../DatabaseConnection.php';
//include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/curl.php';
require_once '../lib/sendmail.php';
$webfriendlyname = $configObj->getConfigFname();
$website = $configObj->getConfigName();
$from = $configObj->getConfigFrom();
if (isset($_POST['exp_status']) && $_POST['exp_status'] == 'accept') {
    $DatabaseCo->dbLink->query("update expressinterest set receiver_response='Accept' where ei_id='" . $_POST['exp_id'] . "' ");
    $get_exp_id = $DatabaseCo->dbLink->query("select ei_sender,ei_receiver from expressinterest where ei_id='" . $_POST['exp_id'] . "'");
    $sel_exp_id = mysqli_fetch_object($get_exp_id);
    /**
     * Update Privilege Match along with Accepting Interest
     */
    $DatabaseCo->dbLink->query("update personal_matches set status='2', responded_by='1' where matri_id_to= '" . $sel_exp_id->ei_receiver . "' and 
                                                    matri_id_by='" . $sel_exp_id->ei_sender . "' and status='1'");
    /**
     * End of Updating Privilege Match along with Accepting Interest
     */
    $sql = "select * from sms_api where status='APPROVED'";
    $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
    $num_sms = mysqli_num_rows($rr);
    $sms = mysqli_fetch_object($rr);
    $result_mbl = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $sel_exp_id->ei_receiver . "'");
    $rowcc = mysqli_fetch_array($result_mbl);
    $result_mbl1 = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $sel_exp_id->ei_sender . "'");
    $rowcc1 = mysqli_fetch_array($result_mbl1);
    if ($num_sms > 0) {
        // Getting predefined SMS Template //
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Interest Accepted'");
        $rowcs5 = mysqli_fetch_array($result45);
        $message = $rowcs5['temp_value'];
        $ao3 = $rowcc['height'];
        $ft3 = (int)($ao3 / 12);
        $inch3 = $ao3 % 12;
        $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $rowcc['matri_id'] . "'  GROUP BY a.edu_detail"));
        $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
        $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*'),
            array($rowcc['matri_id'], $rowcc['firstname'], floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $inch3 . "in", $known_education['my_education'] . ",", $rowcc['ocp_name'], $rowcc['city_name'], $rowcc['family_city']), $sms_template);
        // Final action to send sms //
        $mno = $rowcc1['mobile'];
        $mobile = substr($mno, 0, 3);
        if ($mobile == '+91') {
            $mno = substr($mno, 3, 15);
        }

        send_to_curl($mno, $sms_template);
    }
    $subject = "Your express interest has been accepted.";
    $message = '<table style="margin: auto; border: 5px solid #43609c; font-family: Arial,Helvetica,sans-serif; font-size: 12px; padding: 0px; width: 710px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="float: left; min-height: auto; border-bottom: 5px solid #43609c;">
<table style="margin: 0px; padding: 0px; width: 710px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="background: #f9f9f9;">
<td style="float: left; margin-top: 5px; color: #048c2e; font-size: 26px; padding-left: 15px;">webfriendlyname</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="float: left; width: 710px; min-height: auto;">
<h6 style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px;">Hello, Dear Member</h6>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px; color: #494949;">Your interest sent  to receiver (mid), has been accepted. Please Log on to <a href="website">webfriendlyname</a> now.</p>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px; color: #494949;">Thank you for helping us reach you better,</p>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 5px 15px; color: #494949;">Thanks &amp; Regards ,<br />Team webfriendlyname</p>
</td>
</tr>
</tbody>
</table>';
    $email_template = htmlspecialchars_decode($message, ENT_QUOTES);
    $trans = array("webfriendlyname" => $webfriendlyname, "website" => $website, "receiver" => $sel_exp_id->ei_receiver, "mid" => $sel_exp_id->ei_sender);
    $email_template = strtr($email_template, $trans);
    //send_email_from_samyak($from, $mbl['email'], $subject, $email_template);
}
if (isset($_POST['exp_status']) && $_POST['exp_status'] == 'reject') {
    $DatabaseCo->dbLink->query("update expressinterest set receiver_response='Reject' where ei_id='" . $_POST['exp_id'] . "' ");
    $get_exp_id = $DatabaseCo->dbLink->query("select ei_sender,ei_receiver from expressinterest where ei_id='" . $_POST['exp_id'] . "'");
    $sel_exp_id = mysqli_fetch_object($get_exp_id);
    /**
     * Update Privilege Match along with Rejecting Interest
     */
    $DatabaseCo->dbLink->query("update personal_matches set status='3', responded_by='1' where matri_id_to= '" . $sel_exp_id->ei_receiver . "' and 
                                                    matri_id_by='" . $sel_exp_id->ei_sender . "' and status='1'");
    /**
     * End of Updating Privilege Match along with Rejecting Interest
     */
    $sql = "select * from sms_api where status='APPROVED'";
    $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
    $num_sms = mysqli_num_rows($rr);
    $sms = mysqli_fetch_object($rr);
    $result_mbl = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $sel_exp_id->ei_receiver . "'");
    $rowcc = mysqli_fetch_array($result_mbl);
    $result_mbl1 = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $sel_exp_id->ei_sender . "'");
    $rowcc1 = mysqli_fetch_array($result_mbl1);
    if ($num_sms > 0) {
        // Getting predefined SMS Template //
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Interest Rejected'");
        $rowcs5 = mysqli_fetch_array($result45);
        $message = $rowcs5['temp_value'];
        $ao3 = $rowcc['height'];
        $ft3 = (int)($ao3 / 12);
        $inch3 = $ao3 % 12;
        $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', edu_name, ''SEPARATOR ',' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $rowcc['matri_id'] . "'  GROUP BY a.edu_detail"));
        $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
        $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*'),
            array($rowcc['matri_id'], trim($rowcc['firstname']), trim(floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926)), trim($ft3 . "ft" . " " . $inch3 . "in"),
                trim($known_education['my_education']), trim($rowcc['ocp_name']), trim($rowcc['city_name'])), $sms_template);
        // Final action to send sms //
        $mno = $rowcc1['mobile'];
        $mobile = substr($mno, 0, 3);
        if ($mobile == '+91') {
            $mno = substr($mno, 3, 15);
        } else {
            $mno = $mno;
        }

        send_to_curl($mno, $sms_template);
    }
    $subject = "Your express interest has been rejected.";
    $message = '<table style="margin: auto; border: 5px solid #43609c; font-family: Arial,Helvetica,sans-serif; font-size: 12px; padding: 0px; width: 710px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="float: left; min-height: auto; border-bottom: 5px solid #43609c;">
<table style="margin: 0px; padding: 0px; width: 710px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="background: #f9f9f9;">
<td style="float: left; margin-top: 5px; color: #048c2e; font-size: 26px; padding-left: 15px;">webfriendlyname</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="float: left; width: 710px; min-height: auto;">
<h6 style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px;">Hello, Dear Member</h6>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px; color: #494949;">Your interest sent  to receiver (mid), has been rejected. Please Log on to <a href="website">webfriendlyname</a> now.</p>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 0 15px; color: #494949;">Thank you for helping us reach you better,</p>
<p style="float: left; clear: both; width: 500px; font-size: 13px; margin: 10px 0 5px 15px; color: #494949;">Thanks &amp; Regards ,<br />Team webfriendlyname</p>
</td>
</tr>
</tbody>
</table>';
    $email_template = htmlspecialchars_decode($message, ENT_QUOTES);
    $trans = array("webfriendlyname" => $webfriendlyname, "website" => $website, "receiver" => $_SESSION['uname'], "mid" => $_SESSION['user_id']);
    $email_template = strtr($email_template, $trans);
    //send_email_from_samyak($from, $mbl['email'], $subject, $email_template);
}
if (!empty($_POST['exp_status']) && $_POST['exp_status'] == 'hold') {
    if (!empty($_POST['exp_id'])) {
        $updateToHold = $DatabaseCo->dbLink->query("update expressinterest set `receiver_response`='Hold', `receiver_response_date`='".date('Y-m-d H:i:s')."' 
        WHERE ei_id='".$_POST['exp_id']."'");
    }
}