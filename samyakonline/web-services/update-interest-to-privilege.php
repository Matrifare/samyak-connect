<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 11/19/2019
 * Time: 11:40 PM
 * Desc: To Show the Interest and Send the Express Interest to the User
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

$matri_id = !empty($_POST['matri_id']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['matri_id']) : "";
$match_ids = !empty($_POST['match_ids']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['match_ids']) : "";

$match_ids = str_replace(",", "','", $match_ids);

$changedBy = 1; //As it will be always Customer

$sql = "select * from sms_api where status='APPROVED'";
$rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
$num_sms = mysqli_num_rows($rr);
$sms = mysqli_fetch_object($rr);

$result_mbl1 = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $matri_id . "' LIMIT 1");
$rowcc = mysqli_fetch_array($result_mbl1);

$result_mbl = $DatabaseCo->dbLink->query("select * from register_view r JOIN payment_view p ON r.matri_id = p.pmatri_id
                                                      where r.matri_id IN ('" . $match_ids . "')");

while($rowcc1 = mysqli_fetch_array($result_mbl)) {
    $result_personal_match = $DatabaseCo->dbLink->query("select * from personal_matches where matri_id_by = '".$matri_id."'
                                 and matri_id_to = '".$rowcc1['matri_id']."' and status='1'");

    if($result_personal_match->num_rows >= 1) {
        return print_r(json_encode(["result" => "success", "status" => 'rejected']));
    }

    $sqlPersonalMatch = "insert into personal_matches(matri_id_by, matri_id_to,status,changed_by,responded_by)
              values ('$matri_id', '".$rowcc1['matri_id']."', '1', '1','0')";
    $personalMatch = $DatabaseCo->dbLink->query($sqlPersonalMatch);

    $checkMessage = $DatabaseCo->dbLink->query("select * from message where msg_from='" . $rowcc['email'] . "' and
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
                '*age*' => trim(floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926)),
                '*height*' => $ft3 . "ft" . " " . $inch3 . "in",
                '*edu_name*' => $known_education['my_education'], '*ocp_name*' => $rowcc['ocp_name'],
                '*city*' => $rowcc['city_name'], '*phone*' => $rowcc['phone'],
                '*family_origin*' => $rowcc['family_city'], '*mobile*' => $rowcc['mobile']);

            $sms_template = strtr($sms_template, $trans);

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
}
return print_r(json_encode(["result" => "success", "status" => 'accepted']));
