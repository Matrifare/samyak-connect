<?php
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
include_once '../auth.php';
$configObj = new Config();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$matriId = !empty($_GET['matri_id']) ? htmlspecialchars($_GET['matri_id']) : "";
if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes') {
    $sqlIndex = "select index_id from register_view where matri_id='$matriId' LIMIT 1";
    $dataIndex = mysqli_fetch_object($DatabaseCo->dbLink->query($sqlIndex));
    $indexId = $dataIndex->index_id;

    $name = !empty($_GET['name']) ? htmlspecialchars($_GET['name']) : "";
    $mobile = !empty($_GET['mobile']) ? htmlspecialchars($_GET['mobile']) : "";
}

if (empty($matriId)) {
    echo "<h1>Unauthorized 401</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $matriId ?> - Pending Interest</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!--<link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" type="text/css" href="plugins/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/libs/nifty-component.css"/>    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins          folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/all_check.css"/>
    <script type="text/javascript" src="js/util/redirection.js"></script>
    <link rel="stylesheet" href="css/libs/select2.css"/>
    <script type="text/javascript" src="js/util/location.js"></script>
    <script src="../js/swfobject.js" type="text/javascript"></script>
    <style type="text/css">
        body, td, th {
            font-family: "Open Sans", sans-serif;
        }

        .default {
            width: 200px !important;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e4e4e4;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .mt-5 {
            margin-top: 5px !important;
        }

        .users-list-name {
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
        }

        .normal-font {
            font-size: 11px !important;
            font-weight: normal !important;
        }
    </style>
</head>
<body class="skin-blue">        <!-- Content Header (Page header) -->
<section class="content">
    <?php

    // Received Pending Interests
    $sql = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_sender and e.ei_receiver='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Pending' and r.status <> 'Suspended' ORDER BY ei_sent_date DESC ";

    $data = $DatabaseCo->dbLink->query($sql);

    //For Getting Received Accepted Interests
    $sqlreceivedAccepted = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_sender and e.ei_receiver='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Accept' and r.status <> 'Suspended' ORDER BY ei_sent_date DESC ";

    $receivedAccepted = $DatabaseCo->dbLink->query($sqlreceivedAccepted);


    //For Getting Received OnHold Interests
    $sqlreceivedHold = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_sender and e.ei_receiver='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Hold' and r.status <> 'Suspended' ORDER BY ei_sent_date DESC ";

    $receivedHold = $DatabaseCo->dbLink->query($sqlreceivedHold);


    //For Getting Sent Accepted Interests
    $sqlreceivedRejected = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_sender and e.ei_receiver='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Reject' and r.status <> 'Suspended' ORDER BY ei_sent_date DESC ";

    $receivedRejecetd = $DatabaseCo->dbLink->query($sqlreceivedRejected);


    //For Getting Sent Accepted Interests
    $sqlAccepted = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_receiver and e.ei_sender='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Accept' and r.status <> 'Suspended' ORDER BY ei_sent_date DESC ";

    $dataAccepted = $DatabaseCo->dbLink->query($sqlAccepted);


    //For Getting Sent Rejected Interests
    $sqlRejected = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_receiver and e.ei_sender='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Reject' and r.status <> 'Suspended' order by ei_sent_date DESC ";

    $dataRejected = $DatabaseCo->dbLink->query($sqlRejected);

    //For Getting Sent Hold Interests
    $sqlHold = "select DISTINCT r.index_id,r.firstname,r.username,r.m_status, r.last_login,r.photo1,r.photo1_approve,r.photo_protect,e.ei_sent_date,
r.photo_view_status,r.matri_id,r.samyak_id,r.photo_pswd,r.gender,r.email,r.status,r.profile_text,r.birthdate,r.height,r.religion_name,
r.caste_name,r.mtongue_name,r.edu_name,r.city_name,r.country_name,r.state_name,r.family_city,r.ocp_name,r.logged_in,r.index_id 
FROM expressinterest e,register_view r WHERE r.matri_id=e.ei_receiver and e.ei_sender='$matriId'
 and e.trash_receiver='No' and e.receiver_response='Hold' and r.status <> 'Suspended' order by ei_sent_date DESC ";

    $dataHold = $DatabaseCo->dbLink->query($sqlHold);

    if ($data->num_rows > 0) {
        //        pagination($limit, $adjacent, $rows, $page);
        ?>
        <div class="box no-border">
            <?php
            $count = 1;
            $pageNo = 1;
            if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes') {

                if (!isset($_GET['received_pending_count']) || !isset($_GET['received_accepted_count']) ||
                    !isset($_GET['sent_pending_count']) || !isset($_GET['sent_rejected_count'])
                ) {
                    $sql = "SELECT DISTINCT r.matri_id, s.sent_pending_count, rs.received_pending_count,rsa.received_accepted_count,sa.sent_accepted_count,rsr.sent_rejected_count,rrr.received_rejected_count,rsh.sent_hold_count,rrh.receiver_hold_count FROM register r 
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Pending') AS sent_pending_count FROM expressinterest WHERE receiver_response ='Pending' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender) s ON r.matri_id = s.ei_sender 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Pending' ) AS received_pending_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Pending' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver ) rs ON r.matri_id = rs.ei_receiver 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Accept' ) AS received_accepted_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Accept' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver )rsa ON r.matri_id = rsa.ei_receiver
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Accept' ) AS sent_accepted_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Accept' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender )sa ON r.matri_id = sa.ei_sender 
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Reject' ) AS sent_rejected_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Reject' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender )rsr ON r.matri_id = rsr.ei_sender 
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Hold' ) AS sent_hold_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Hold' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender )rsh ON r.matri_id = rsh.ei_sender 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Reject' ) AS received_rejected_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Reject' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver )rrr ON r.matri_id = rrr.ei_receiver
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Hold' ) AS receiver_hold_count, ei_sent_date FROM expressinterest WHERE receiver_response ='Hold' AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver )rrh ON r.matri_id = rrh.ei_receiver
where matri_id='$matriId'";
                    $data1 = $DatabaseCo->dbLink->query($sql);
                    if ($data1->num_rows > 0) {
                        while ($row = mysqli_fetch_object($data1)) {
                            $received_pending_count = $row->received_pending_count ?? 0;
                            $received_accepted_count = $row->received_accepted_count ?? 0;
                            $sent_accepted_count = $row->sent_accepted_count ?? 0;
                            $sent_pending_count = $row->sent_pending_count ?? 0;
                            $sent_rejected_count = $row->sent_rejected_count ?? 0;
                            $received_rejected_count = $row->received_rejected_count ?? 0;
                            $sent_hold_count = $row->sent_hold_count ?? 0;
                            $received_hold_count = $row->receiver_hold_count ?? 0;
                        }
                    } else {
                        $received_pending_count = 0;
                        $received_accepted_count = 0;
                        $sent_accepted_count = 0;
                        $sent_pending_count = 0;
                        $sent_rejected_count = 0;
                        $received_rejected_count = 0;
                        $sent_hold_count = 0;
                        $received_hold_count = 0;
                    }
                } else {
                    $received_pending_count = $_GET['received_pending_count'] ?? 0;
                    $received_accepted_count = $_GET['received_accepted_count'] ?? 0;
                    $sent_accepted_count = $_GET['sent_accepted_count'] ?? 0;
                    $sent_pending_count = $_GET['sent_pending_count'] ?? 0;
                    $sent_rejected_count = $_GET['sent_rejected_count'] ?? 0;
                    $received_rejected_count = $_GET['received_rejected_count'] ?? 0;
                    $sent_hold_count = $_GET['sent_hold_count'] ?? 0;
                    $received_hold_count = $_GET['received_hold_count'] ?? 0;
                }

                $text = "Hello *{$name} - [{$matriId}],*%0A%0A" .
                    "View my Profile: " . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($indexId * 726925)) .
                    "%0A%0AYour *Express Interest Statistics*%0A.............................................%0AReceived Pending Interest - [ *{$received_pending_count}* ]%0ASent Accepted Interest - [ *{$sent_accepted_count}* ]%0AReceived Accepted Interest - [ *{$received_accepted_count}* ]%0A" .
                    "Sent Interest Rejected - [ *{$sent_rejected_count}* ]%0AReceived Interest Rejected - [ *{$received_rejected_count}* ]%0ASent Interest On Hold - [ *{$sent_hold_count}* ]%0AReceived Interest On Hold - [ *{$received_hold_count}* ]%0ASent Interest Pending - [ *{$sent_pending_count}* ]%0A.............................................%0A*Interest Received Pending List*%0A%0AKindly login to Accept or Decline your Pending Interest List%0A" .
                    "*Note:* If you are unable to see the profile links, kindly save this no.%0A%0A";
            }
            while ($fetch = mysqli_fetch_object($data)) {
                if ($count == 1) { ?>
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Pending Interest For Profile ID <?= $matriId ?> on
                            Samyakmatrimony.com</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-danger"><?= $data->num_rows ?> Profiles</span>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                <?php }
                include "match-view.php";
                if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes') {
                    $ao3 = $fetch->height;
                    $ft3 = (int)($ao3 / 12);
                    $inch3 = $ao3 % 12;
                    $text .= "*Interest Received on: " . trim(date('d M, Y', strtotime($fetch->ei_sent_date))) . "*%0A";
                    $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                        $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                        " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                        "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)."&approve=".dechex($indexId * 726925)) . "%0A%0A";
                }
                if ($count == 24) {
                    $count = 0;
                    ?>
                    </ul><!-- /.users-list -->
                    </div><!-- /.box-body -->
                    <br/>
                    <?php include "match-view-footer.php";
                    $pageNo++; ?>
                    <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                <?php } else if ($data->num_rows < 24 && $data->num_rows == $count) { ?>
                    </ul></div>
                    <?php include "match-view-footer.php";
                }
                $count++;
            }
            if (!($data->num_rows < 24 && $data->num_rows == $count)) {
            ?>
            </ul><!-- /.users-list -->
        </div><!-- /.box-body -->
    <?php } ?>
        </div>
    <?php
    //Adding Accepted Sent Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $dataAccepted->num_rows > 0) {
        $text .= ".............................................%0A*Sent Accepted Interest List*%0A%0A";
        while ($fetch = mysqli_fetch_object($dataAccepted)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }

    //Adding Rejected Sent Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $dataRejected->num_rows > 0) {
        $text .= ".............................................%0A*Sent Interest Rejected List*%0A%0A";
        while ($fetch = mysqli_fetch_object($dataRejected)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }

    //Adding Hold Sent Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $dataHold->num_rows > 0) {
        $text .= ".............................................%0A*Sent On Hold Interest List*%0A%0A";
        while ($fetch = mysqli_fetch_object($dataHold)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }


    //Adding Accepted Received Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $receivedAccepted->num_rows > 0) {
        $text .= ".............................................%0A*Received Accepted Interest List*%0A%0A";
        while ($fetch = mysqli_fetch_object($receivedAccepted)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }

    /*//Adding Rejected Received Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $receivedRejecetd->num_rows > 0) {
        $text .= ".............................................%0A*Received Rejected Interest List*%0A%0A";
        while ($fetch = mysqli_fetch_object($receivedRejecetd)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }*/

    //Adding On Hold Received Express Interests
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes' && $receivedHold->num_rows > 0) {
        $text .= ".............................................%0A*Received Hold Interest List*%0A%0A";
        while ($fetch = mysqli_fetch_object($receivedHold)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . "-" . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    }

    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes') {
    $text .= ".............................................%0A%0A";
    $smsTemplate = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'PendingInterestWhatsapp'");
    $rowcs5 = mysqli_fetch_array($smsTemplate);
    $message = trim($rowcs5['temp_value']);
    $text .= $message ?>
        <a id="clickLink"
           href="<?= "https://api.whatsapp.com/send?phone=91" . (strlen($mobile) == 13 ? substr($mobile, 3, 10) : $mobile) . "&text={$text}" ?>"
           title="Whatsapp"><i class="fa fa-whatsapp"></i> Send</a>
        <script>document.getElementById("clickLink").click();</script>
    <?php }
    } else {
    if (isset($_GET['pending_send']) && $_GET['pending_send'] == 'yes') { ?>
        <h1 class="text-center text-danger">No Data Found to send.</h1>
    <?php }
    }
    ?>
</section>
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>    <!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>   <!--jquery for left menu active class-->
<script type="text/javascript" src="dist/js/general.js"></script>
<script type="text/javascript" src="dist/js/cookieapi.js"></script>
<script type="text/javascript">        setPageContext("members", "express-interest-reminder");    </script>
<!--jquery for left menu active class end-->    <!-- DATA TABES SCRIPT -->
<!--<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->    <!-- SlimScroll -->
<script type="text/javascript" src="plugins/datatables/datatables.min.js"></script>
<!--<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->    <!-- FastClick -->
<!--<script src='plugins/fastclick/fastclick.min.js'></script>-->    <!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">
    var win = null;

    function newWindow(mypage, myname, w, h, features) {
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        if (winl < 0) winl = 0;
        if (wint < 0) wint = 0;
        var settings = 'height=' + h + ',';
        settings += 'width=' + w + ',';
        settings += 'top=' + wint + ',';
        settings += 'left=' + winl + ',';
        settings += features;
        win = window.open(mypage, myname, settings);
        win.window.focus();
    }
</script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        var refreshRequired = false;
        $("input[name=action_id]").click(function () {
            $("#selectall").prop("checked", false);
        });
        //     js for Check/Uncheck all CheckBoxes by Checkbox     //
        $("#selectall").click(function () {
            $(".second").prop("checked", $("#selectall").prop("checked"))
        })
        // add details //
        var t = $('#example123').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [[1, 'asc']],
            "pageLength": 100,
            "lengthMenu": [[100, 250, 500, 1000, 2000, -1], [100, 250, 500, 1000, 2000, "All"]],
        });
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
</body>
</html>