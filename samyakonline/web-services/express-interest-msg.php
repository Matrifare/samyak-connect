<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10/14/2018
 * Time: 8:05 PM
 */

include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();

$matriId = mysqli_real_escape_string($DatabaseCo->dbLink, $_GET['matri_id']);

$sql = "SELECT DISTINCT r.index_id, r.matri_id, r.birthdate, r.samyak_id, r.username, r.email, r.mobile, r.last_login,
(select count(msg_id) from message where msg_to=r.email and trash_receiver = 'No') as received_messages,
(select count(msg_id) from message where msg_from=r.email and trash_sender = 'No') as sent_messages,
(select count(who_id) from who_viewed_my_profile where viewed_member_id = r.matri_id) as visitor_list,
(select count(who_id) from who_viewed_my_profile where my_id = r.matri_id) as profile_visited_by_me,
(select count(id) from contact_checker where  viewed_id=r.matri_id) as my_contacts_seen,
(select count(id) from contact_checker where  my_id=r.matri_id) as contacts_seen_by_me, 
 s.sent_pending_count, rs.received_pending_count,rsa.received_accepted_count,rsr.sent_rejected_count,rrr.received_rejected_count, rs.ei_sent_date, p.p_plan,
p.p_plan,p.p_no_contacts,p.r_cnt,p.p_msg,p.r_sms,p.exp_date FROM register r 
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Pending') AS sent_pending_count FROM expressinterest WHERE receiver_response IN ('Pending') AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender) s ON r.matri_id = s.ei_sender 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Pending' ) AS received_pending_count, ei_sent_date FROM expressinterest WHERE receiver_response IN ('Pending') AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver ) rs ON r.matri_id = rs.ei_receiver 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Accept' ) AS received_accepted_count, ei_sent_date FROM expressinterest WHERE receiver_response IN ('Accept') AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver )rsa ON r.matri_id = rsa.ei_receiver 
LEFT JOIN ( SELECT ei_sender, SUM( receiver_response = 'Reject' ) AS sent_rejected_count, ei_sent_date FROM expressinterest WHERE receiver_response IN ('Reject') AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_sender )rsr ON r.matri_id = rsr.ei_sender 
LEFT JOIN ( SELECT ei_receiver, SUM( receiver_response = 'Reject' ) AS received_rejected_count, ei_sent_date FROM expressinterest WHERE receiver_response IN ('Reject') AND trash_sender='No' AND trash_receiver='No' GROUP BY ei_receiver )rrr ON r.matri_id = rrr.ei_receiver
LEFT JOIN ( SELECT pmatri_id, p_plan,p_no_contacts,r_cnt,p_msg,r_sms,exp_date FROM payment_view) p ON r.matri_id = p.pmatri_id
WHERE r.status NOT IN ('Inactive', 'Suspended') and r.matri_id='" . $matriId . "' ORDER BY r.last_login DESC";

$data = $DatabaseCo->dbLink->query($sql);
if ($data->num_rows > 0) {
    while ($row = mysqli_fetch_object($data)) {
        $indexId = $row->index_id;
        $profileKey = dechex($indexId * 726925);
        $contactViewBalance = $row->p_no_contacts - $row->r_cnt;
        $messageBalance = $row->p_msg - $row->r_sms;
        $expDate = date('d M, Y', strtotime($row->exp_date));
        if ($row->p_plan != 'Free') {
            $paidSms = "*--------------- My Plan -------------*%0A%0A" .
                "Contact View Balance - *[" . $contactViewBalance . "]*%0A" .
                "Send SMS/Messages Balance - *[" . $messageBalance . "]*%0A" .
                "Plan Expiry Date - *[" . $expDate . "]*%0A%0A";
        } else {
            $paidSms = "";
        }
        ?>
        <a id="clickLink"
           href="<?= "https://api.whatsapp.com/send?phone=91" . (strlen($row->mobile) == 13 ? substr($row->mobile, 3, 10) : $row->mobile) . "&text=Hello *{$row->username} [{$row->matri_id}]*,%0A%0ASamyakmatrimony.com%0A%0A" .
           "*---- My Profile ----*%0A%0A" .
           "Link - ".urlencode("https://www.samyakmatrimony.com/view-profile?profile=$profileKey") . "%0A%0A" .
           "*---- Profile Statistics ----*%0A%0A" .
           "Pending Interest List - *[" . ($row->received_pending_count ?? 0) . "]*%0AAccepted Interest List - " .
           "*[" . ($row->received_accepted_count ?? 0) . "]*%0ASent Interest List - *[" . ($row->sent_pending_count ?? 0) . "]*%0A" .
           "Sent Rejected Interest - *[" . ($row->sent_rejected_count ?? 0) . "]*%0A" .
           "Received Rejected Interest - *[" . ($row->received_rejected_count ?? 0) . "]*%0A" .
           "Received Messages - *[" . ($row->received_messages ?? 0) . "]*%0A" .
           "Sent Messages - *[" . ($row->sent_messages ?? 0) . "]*%0A" .
           "Visitor List - *[" . ($row->visitor_list ?? 0) . "]*%0A" .
           "Who viewed my Contact - *[" . ($row->my_contacts_seen ?? 0) . "]*%0A" .
           "Contacts seen by me - *[" . ($row->contacts_seen_by_me ?? 0) . "]*%0A" .
           "Profiles visited by me - *[" . ($row->profile_visited_by_me ?? 0) . "]*%0A%0A" .
           "$paidSms" .
           "%0A%0A*Thanks,*%0A*Samyakmatrimony Team*" ?>"
           title="Whatsapp">
            Send
        </a>
    <?php } ?>
    <script>document.getElementById("clickLink").click();</script>
<?php } else {
    echo "<h2 style='color:red; text-align:center;'>No Data to Display</h2>";
}
?>