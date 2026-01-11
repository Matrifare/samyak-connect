<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 09/20/2019
 * Time: 12:04 AM
 * Desc: To Show the Interest and Send the Express Interest to the User
 */
include_once '../DatabaseConnection.php';
//include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/curl.php';
$webfriendlyname = $configObj->getConfigFname();
$website = $configObj->getConfigName();
$from = $configObj->getConfigFrom();
$_POST['match_id'] = !empty($_POST['match_id']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['match_id']) : "";
$_POST['match_status'] = !empty($_POST['match_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['match_status']) : "";
$changedBy = 1;

if (isset($_POST['match_status']) && $_POST['match_status'] == 'accept') {

    $get_match_id = $DatabaseCo->dbLink->query("select matri_id_by, matri_id_to from personal_matches where id='" . $_POST['match_id'] . "' LIMIT 1");
    $sel_match_id = mysqli_fetch_object($get_match_id);

    $DatabaseCo->dbLink->query("update personal_matches set status='1', changed_by='$changedBy' where id='" . $_POST['match_id'] . "'");

    $sql = "select * from sms_api where status='APPROVED'";
    $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
    $num_sms = mysqli_num_rows($rr);
    $sms = mysqli_fetch_object($rr);

    $result_mbl = $DatabaseCo->dbLink->query("select * from register_view r JOIN payment_view p ON r.matri_id = p.pmatri_id
                                                      where r.matri_id='" . $sel_match_id->matri_id_to . "' LIMIT 1");
    $rowcc1 = mysqli_fetch_array($result_mbl);

    $result_mbl1 = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $sel_match_id->matri_id_by . "' LIMIT 1");
    $rowcc = mysqli_fetch_array($result_mbl1);

    //Check if express interest already sent
    $checkExpressInterest = $DatabaseCo->dbLink->query("select * from expressinterest where
                              ei_sender='" . $sel_match_id->matri_id_by . "' AND ei_receiver='$sel_match_id->matri_id_to'");

    if ($checkExpressInterest->num_rows < 1) {
        $sql = "INSERT INTO expressinterest (ei_sender,ei_receiver,receiver_response,ei_message,ei_sent_date,status)
                         values('" . $rowcc['matri_id'] . "','" . $rowcc1['matri_id'] . "','Pending','You seem to be the kind of person who suits our family. Please accept if you are interested.',now(),'APPROVED')";
        $expressInterest = $DatabaseCo->dbLink->query($sql);
    }

    $checkMessage = $DatabaseCo->dbLink->query("select * from message where msg_from='".$rowcc['email']."' and
                              msg_to='" . $rowcc1['email'] . "' AND msg_subject='Express Interest' and trash_sender='No' and trash_receiver='No'");

    if ($checkMessage->num_rows < 1) {
        $sql = "INSERT INTO message (msg_from,msg_to,msg_subject,msg_content,msg_status,msg_date)
                         values('" . $rowcc['email'] . "','" . $rowcc1['email'] . "','Express Interest',
                         'You seem to be the kind of person who suits our family. Please accept if you are interested.','sent',now())";
        $expressInterest = $DatabaseCo->dbLink->query($sql);
    }

    $ao3 = $rowcc['height'];
    $ft3 = (int)($ao3 / 12);
    $inch3 = $ao3 % 12;
    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $rowcc['matri_id'] . "'  GROUP BY a.edu_detail"));
    if ($num_sms > 0) {
        if ($rowcc1['p_plan'] != 'Free') {
            // Getting predefined SMS Template //
            $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'SendInterestSMS'");
            $rowcs5 = mysqli_fetch_array($result45);
            $message = $rowcs5['temp_value'];
            $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
            $trans = array('*profile*' => $rowcc['matri_id'], '*username*' => $rowcc['username'],
                '*age*' => floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926),
                '*height*' => $ft3 . "ft" . " " . $inch3 . "in", '*edu_name*' => $known_education['my_education'],
                '*ocp_name*' => $rowcc['ocp_name'], '*city*' => $rowcc['city_name'], '*phone*' => $rowcc['phone'],
                '*family_origin*' => $rowcc['family_city'], '*mobile*' => $rowcc['mobile']);

            $sms_template = strtr($sms_template, $trans);

            /*$sms_template = str_replace(array('*profile*', '*username*', '*age*', '*height*', '*edu_name*', '*ocp_name*', '*city*'),
                array($rowcc['matri_id'], $rowcc['firstname'], floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $inch3 . "in", $known_education['my_education'] . ",", $rowcc['ocp_name'], $rowcc['city_name'], $rowcc['family_city']), $sms_template);*/
        } else {
            // Getting predefined SMS Template //
            $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Interest Received'");
            $rowcs5 = mysqli_fetch_array($result45);
            $message = $rowcs5['temp_value'];
            $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
            $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*family_city*'),
                array($rowcc['matri_id'], $rowcc['firstname'], floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926), $ft3 . "ft" . " " . $inch3 . "in",
                    $known_education['my_education'], $rowcc['ocp_name'], $rowcc['city_name'], ($rowcc['family_city'] ?? "-")), $sms_template);
        }
        $mno = $rowcc1['mobile'];
        $mobile = substr($mno, 0, 3);
        if ($mobile == '+91') {
            $mno = substr($mno, 3, 15);
        }
        send_to_curl($mno, $sms_template);
    }
    return print_r(json_encode(["result" => "success", "status" => 'accepted']));
}
if (isset($_POST['match_status']) && $_POST['match_status'] == 'reject') {
    $DatabaseCo->dbLink->query("update personal_matches set status='5', changed_by='$changedBy' where id='" . $_POST['match_id'] . "' ");
    return print_r(json_encode(["result" => "success", "status" => 'rejected']));
}