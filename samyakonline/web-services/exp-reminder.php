<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 12/12/2020
 * Time: 11:20 AM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/curl.php';
require_once '../lib/sendmail.php';
$from = $configObj->getConfigFrom();
$expressInterestId = mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['exp_id']) ?? "";
if (isset($_POST['exp_status']) && mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['exp_status']) == 'reminder') {
    $get_exp_id = $DatabaseCo->dbLink->query("select ei_sender,ei_receiver from expressinterest where ei_id='" . $_POST['exp_id'] . "'
     AND trash_sender='No' and trash_receiver='No' LIMIT 1");
    $sel_exp_id = mysqli_fetch_object($get_exp_id);
    if (!empty($sel_exp_id)) {
        $sel_reminder_id = $DatabaseCo->dbLink->query("select sender_id,receiver_id,remind_count from reminder where sender_id='" . $sel_exp_id->ei_sender . "'
         and receiver_id='" . $sel_exp_id->ei_receiver . "' LIMIT 1");
        $get_reminder_id = mysqli_fetch_object($sel_reminder_id);
        if (!empty($get_reminder_id->sender_id) > 0) {
            $DatabaseCo->dbLink->query("update reminder set reminder_view_status='Yes', remind_count=" . ($get_reminder_id->remind_count + 1) . " where
             sender_id='" . $sel_exp_id->ei_sender . "' and receiver_id='" . $sel_exp_id->ei_receiver . "'");
            sendReminderEmail($DatabaseCo, $sel_exp_id->ei_sender, $sel_exp_id->ei_receiver, $configObj->getConfigFrom());
            return print_r(json_encode(['status' => 'success', 'msg' => 'You have successfully sent the express interest reminder.']));
        } else {
            $DatabaseCo->dbLink->query("insert into reminder(rem_id,sender_id,receiver_id,reminder_mes_type,reminder_msg,reminder_view_status,
        remind_count,status) values(NULL,'" . $sel_exp_id->ei_sender . "','" . $sel_exp_id->ei_receiver . "','exp_interest','Pending','No',1,'Yes')");
            sendReminderEmail($DatabaseCo, $sel_exp_id->ei_sender, $sel_exp_id->ei_receiver, $configObj->getConfigFrom());
            return print_r(json_encode(['status' => 'success', 'msg' => 'You have successfully sent the express interest reminder.']));
        }
    } else {
        return print_r(json_encode(['status' => 'failed', 'msg' => 'Invalid Request']));
    }
} else {
    return print_r(json_encode(['status' => 'failed', 'msg' => 'Invalid Request']));
}

function sendReminderEmail($DatabaseCo, $senderId, $receiverId, $fromEmail)
{
    $senderData = $DatabaseCo->dbLink->query("select r.*, p.p_plan from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id
                WHERE r.matri_id='" . $senderId . "' LIMIT 1");
    $senderDetails = mysqli_fetch_array($senderData);

    $receiverData = $DatabaseCo->dbLink->query("select r.*, p.p_plan from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id
                WHERE r.matri_id='" . $receiverId . "' LIMIT 1");
    $receiverDetails = mysqli_fetch_array($receiverData);

    $subject = 'Express Interest Reminder Received on Samyakmatrimony';
    $tempData = array(
        'matri_data' => $senderDetails,
        'ex_matri_data' => $receiverDetails
    );

    $template = get_email_template($DatabaseCo, $tempData, '../email-templates/express_interest_reminder_email_template.php');
    send_email_from_samyak($fromEmail, $receiverDetails['email'], $subject, $template);
}