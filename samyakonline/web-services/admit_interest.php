<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/10/2018
 * Time: 1:17 AM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
include_once '../lib/Config.php';
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';

$DatabaseCo = new DatabaseConnection();
$ExmatriId = !empty($_REQUEST['ExmatriId']) ? $_REQUEST['ExmatriId'] : $_REQUEST['ExmatriId'];
$Msg = !empty($_REQUEST['exp_interest']) ? htmlspecialchars($_REQUEST['exp_interest'], ENT_QUOTES) : "";
$mid = $_SESSION['user_id'];

//Checking if Free Plan then check the express interest
if (!empty($_SESSION['membership']) && $_SESSION['membership'] == 'Free') {
    $result3 = $DatabaseCo->dbLink->query("SELECT *, 'Free' as `p_plan` FROM register_view,site_config,membership_plan where matri_id = '$mid' and plan_name='Free'");
} else {
    $result3 = $DatabaseCo->dbLink->query("SELECT *, 'Paid' as `p_plan` FROM register_view,site_config where matri_id = '$mid'");
}
$rowcc = mysqli_fetch_array($result3);


$sel = $DatabaseCo->dbLink->query("select * from  expressinterest where ei_sender='$mid' and ei_receiver='$ExmatriId' and receiver_response='Inactive'");
$num_block = mysqli_num_rows($sel);

if (!empty($_SESSION['membership']) && $_SESSION['membership'] == 'Free') {
    $interestPerDay = $rowcc['interest_per_day'];
    $sqlInterest = $DatabaseCo->dbLink->query("select count(DISTINCT ei_receiver) as expressedToday from expressinterest where ei_sender='$mid' and ei_sent_date LIKE '" . date('Y-m-d') . "%'");
    $rowInterestCount = mysqli_fetch_object($sqlInterest);

    //Count of Total Express Interest Till Date
    $sqlInterestTotal = $DatabaseCo->dbLink->query("select count(DISTINCT ei_receiver) as expressedTillDate from expressinterest where ei_sender='$mid'");
    $rowInterestCountTotal = mysqli_fetch_object($sqlInterestTotal);

    if (!empty($rowInterestCount) && $rowInterestCount->expressedToday >= $interestPerDay) {
        $subject = "$mid has sent " . $rowInterestCount->expressedToday . " express interests";
        $emailTemplate = '<p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                                            </span>
                                            <span> ' . $_SESSION['user_id'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                                            </span>
                                            <span>
                                                ' . $_SESSION['uname'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Plan Name:
                                            </span>
                                            <span>
                                             ' . $_SESSION['membership'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Total Express Interest Sent as on ' . date('d M, Y H:i:s') . ':
                                            </span>
                                            <span>
                                             ' . $rowInterestCountTotal->expressedTillDate . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                                            </span>
                                            <span>
                                               ' . $_SESSION['mobile'] . '
                                            </span>
                                        </p>';
        $from = $rowcc['from_email'];
        $to = $rowcc['to_email'];
        send_email_from_samyak($from, $to, $subject, $emailTemplate);
        echo "<p style='margin-top:-10px; color:#ff0000;'><b>Please upgrade your profile to continue sending interests.<br/>You have exceeded the limit for today.</b></p>";
        exit;
    }
}

$result4 = $DatabaseCo->dbLink->query("SELECT * FROM register_view,site_config where matri_id = '$ExmatriId'"); //Receiver Details
$rowcc1 = mysqli_fetch_array($result4);


$paymentDetails = $DatabaseCo->dbLink->query("SELECT * FROM payment_view where pmatri_id = '$ExmatriId'"); //Receiver Membership Details
$membership = mysqli_fetch_array($paymentDetails);

$rowcc1 = array_merge($rowcc1, $membership);

$senderAge = floor((time() - strtotime($rowcc['birthdate'])) / 31556926);
if ($num_block > 0) {
    $sql = "update expressinterest set receiver_response = 'Pending', ei_sent_date='" . date('Y-m-d H:i:s') . "' 
        WHERE ei_sender='$mid' AND ei_receiver='$ExmatriId' and receiver_response='Inactive'";
    $result = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
} else {
    $isInterestPresent = $DatabaseCo->dbLink->query("select * from expressinterest where ei_sender='$mid' and ei_receiver='$ExmatriId'");
    $resultIsInterestPresent = mysqli_num_rows($isInterestPresent);
    if ($resultIsInterestPresent) {
        echo "<p style='margin-top:10px 0px; color:#035F00;' class='text-center'><b>You had already sent an express interest to this member.</b></p>
        <div class='text-center'><button type=\"button\" class=\"btn btn-sm btn-default\"
                                            data-dismiss=\"modal\">
                                        Close
                                    </button> </div>";
        exit;
    }

    /**
     * Express Interest Privacy
     */
    $sqlData = "select * from express_interest_privacy_details where matri_id='" . $ExmatriId . "' AND status=1 LIMIT 1";
    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlData);
    $dataResult = mysqli_fetch_array($DatabaseCo->dbResult);
    if (!empty($dataResult) && count($dataResult)) {
        $isPrivacyMatched = isPrivacyMatch($rowcc, $dataResult);
        if(!empty($isPrivacyMatched)) {
            echo "<p style='margin-top:10px 0px; color:red;' class='text-center'><b>This person only allows interests 
                from people with his/her privacy match.</b></p>
        <div class='text-center'><button type=\"button\" class=\"btn btn-sm btn-default\"
                                            data-dismiss=\"modal\">
                                        Close
                                    </button> </div>";
            exit;
        }
    }

    $sql = "INSERT INTO expressinterest (ei_sender,ei_receiver,receiver_response,ei_message,ei_sent_date,status)
 values('$mid','$ExmatriId','Pending','$Msg',now(),'APPROVED')";
    $result = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
}


$name = $rowcc['username'];
$matriid = $rowcc['matri_id'];
$cpass = $rowcc['cpassword'];
$website = $rowcc['web_name'];
$webfriendlyname = $rowcc['web_frienly_name'];
$from = $rowcc['from_email'];
$to = $rowcc1['email'];
$mno = $rowcc1['mobile'];

$subject = 'New Express Interest Received on Samyakmatrimony';

$tempData = array(
    'matri_data' => $rowcc,
    'ex_matri_data' => $rowcc1
);

$template = get_email_template($DatabaseCo, $tempData, '../email-templates/new_express_interest_email_template.php');
send_email_from_samyak($from, $to, $subject, $template);

$sql = "select * from sms_api where status='APPROVED'";
$rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
$num_sms = mysqli_num_rows($rr);
$sms = mysqli_fetch_object($rr);


if ($num_sms > 0) {
    // Getting predefined SMS Template //

    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Interest Received'");
    $rowcs5 = mysqli_fetch_array($result45);
    $message = $rowcs5['temp_value'];
    $ao3 = $rowcc['height'];
    $ft3 = (int)($ao3 / 12);
    $inch3 = $ao3 % 12;
    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $rowcc['matri_id'] . "'  GROUP BY a.edu_detail"));
    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
    $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*family_city*'),
        array($rowcc['matri_id'], $rowcc['firstname'], floor((time() - strtotime(trim($rowcc['birthdate']))) / 31556926), $ft3 . "ft" . " " . $inch3 . "in",
            $known_education['my_education'], $rowcc['ocp_name'], $rowcc['city_name'], ($rowcc['family_city'] ?? "-")), $sms_template);

    // Final action to send sms //

    $mobile = substr($mno, 0, 3);
    if ($mobile == '+91') {
        $mno = substr($mno, 3, 15);
    }

    send_to_curl($mno, $sms_template);
}


echo "<p style='margin-top:10px 0px; color:#035F00;' class='text-center'><b>Express interest sent successfully.</b></p>
        <div class='text-center'><button type=\"button\" class=\"btn btn-sm btn-default\"
                                            data-dismiss=\"modal\">
                                        Close
                                    </button> </div>";
exit;

function isPrivacyMatch($userDetails, $privacyDetails)
{
    $result = [];
    if (!empty($privacyDetails['looking_for']) &&
        !in_array($userDetails['m_status'], explode(",", $privacyDetails['looking_for']))) {
        $result['error'][] = "Marital Status not matched.";
    }
    if (!empty($privacyDetails['religion']) &&
        !in_array($userDetails['religion'], explode(",", $privacyDetails['religion']))) {
        $result['error'][] = "Religion not matched.";
    }
    if (!empty($privacyDetails['age_from']) && !empty($privacyDetails['age_to']) &&
        !(floor((time() - strtotime($userDetails['birthdate'])) / 31556926) >= $privacyDetails['age_from'] &&
            floor((time() - strtotime($userDetails['birthdate'])) / 31556926) <= $privacyDetails['age_to'])) {
        $result['error'][] = "Age not matched.";
    }
    if (!empty($privacyDetails['height_from']) && !empty($privacyDetails['height_to']) &&
        !($userDetails['height'] >= $privacyDetails['height_from'] && $userDetails['height'] <= $privacyDetails['height_to'])) {
        $result['error'][] = "Height not matched.";
    }
    if (!empty($privacyDetails['edu_level']) &&
        !in_array($userDetails['e_level'], explode(",", $privacyDetails['edu_level']))) {
        $result['error'][] = "Education level not matched.";
    }
    if (!empty($privacyDetails['edu_field']) &&
        !in_array($userDetails['e_field'], explode(",", $privacyDetails['edu_field']))) {
        $result['error'][] = "Education field not matched.";
    }
    if (!empty($privacyDetails['with_photo']) && $privacyDetails['with_photo'] == 1 &&
        !((!empty($userDetails['photo1']) && $userDetails['photo1_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo2']) && $userDetails['photo2_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo3']) && $userDetails['photo3_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo4']) && $userDetails['photo4_approve'] == 'APPROVED'))) {
        $result['error'][] = "Photo is required.";
    }

    return $result;
}

?>
