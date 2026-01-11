<?php

if (!empty($DatabaseCo->dbRow->msg_id) && $DatabaseCo->dbRow->msg_id > 0) {
    $_SESSION['profile_delete_id'] = $DatabaseCo->dbRow->msg_id;
    return header('location: profile_deleted');
}

$sql = "select id,matri_id from blocked_registrations where 
            (mobile='" . trim($DatabaseCo->dbRow->mobile) . "' OR mobile='+91" . trim($DatabaseCo->dbRow->mobile) . "')";
$count = $DatabaseCo->dbLink->query($sql);
$isIdBlocked = mysqli_num_rows($count);
if ($isIdBlocked > 0) {
    $_SESSION['profile_suspended_id'] = mysqli_fetch_object($count)->matri_id;
    return header('location: profile_blocked');
}

if ($DatabaseCo->dbRow->status == 'Suspended') {
    $_SESSION['profile_suspended_id'] = $DatabaseCo->dbRow->matri_id;
    header('location: profile_suspended');
    exit;
}

if ($DatabaseCo->dbRow->request_photo_id == 1) {
    $_SESSION['profile_photo_id_requested'] = $DatabaseCo->dbRow->matri_id;
    header('location: profile_photo_id_requested');
    exit;
}

$query = "select DISTINCT mp.plan_id, pv.p_plan, pv.exp_date, pv.p_no_contacts, pv.r_cnt from 
                      payment_view  pv INNER JOIN membership_plan mp ON pv.p_plan = mp.plan_name
                      where pmatri_id = '" . $DatabaseCo->dbRow->matri_id . "'";
$SQL_STATEMENT = $DatabaseCo->dbLink->query($query);
if ($DatabaseCo->dbRow1 = mysqli_fetch_object($SQL_STATEMENT)) {
    $_SESSION['plan_id'] = $DatabaseCo->dbRow1->plan_id;
    $_SESSION['membership'] = $DatabaseCo->dbRow1->p_plan;
    $_SESSION['exp_date'] = $DatabaseCo->dbRow1->exp_date;
    $_SESSION['p_no_contact'] = $DatabaseCo->dbRow1->p_no_contacts;
    $_SESSION['r_cnt'] = $DatabaseCo->dbRow1->r_cnt;
}
$_SESSION['user_name'] = $DatabaseCo->dbRow->email;
$_SESSION['user_id'] = $DatabaseCo->dbRow->matri_id;
$_SESSION['uname'] = $DatabaseCo->dbRow->username;
$_SESSION['gender123'] = $DatabaseCo->dbRow->gender;
$_SESSION['uid'] = $DatabaseCo->dbRow->index_id;
$_SESSION['email'] = $DatabaseCo->dbRow->email;
$_SESSION['mobile'] = $DatabaseCo->dbRow->mobile;
$_SESSION['mem_status'] = $DatabaseCo->dbRow->status;
$_SESSION['adminrole_view_status'] = $DatabaseCo->dbRow->adminrole_view_status;
$_SESSION['marital_status'] = $DatabaseCo->dbRow->m_status;
$_SESSION['birthdate'] = $DatabaseCo->dbRow->birthdate;
$_SESSION['photo1'] = !empty($DatabaseCo->dbRow->photo1) ? $DatabaseCo->dbRow->photo1 : '';
$_SESSION['request_photo_id'] = $DatabaseCo->dbRow->request_photo_id;

$email = $_SESSION['email'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$url = $_SERVER['HTTP_HOST'];
$ip = $_SERVER['SERVER_ADDR'];
$tm = mktime(date('H'), date('i'), date('s'));
date_default_timezone_set('Asia/Kolkata');
$login_dt = date('Y-m-d H:i:s', $tm);
$date2 = date("d F ,Y", (strtotime($login_dt)));

if ($DatabaseCo->dbRow->mobile_verify_status == 'No') {
    $_SESSION['last_login'] = 'first_time';
}

if ($DatabaseCo->dbRow->part_frm_age == '' || $DatabaseCo->dbRow->part_frm_age == NULL ||
    $DatabaseCo->dbRow->part_frm_age <= 19 || $DatabaseCo->dbRow->part_height == '48') {
    $_SESSION['partner_profile'] = 'fill_profile';
}

if (empty($_SESSION['last_login']) && empty($_SESSION['partner_profile']) && empty($_SESSION['no_photo'])) {
    $sql = "select * from advertisement where adv_level='pending-order' and status='APPROVED' order by adv_date DESC LIMIT 1";
    $count = $DatabaseCo->dbLink->query($sql);
    $isAdPresent = mysqli_num_rows($count);
    if ($isAdPresent > 0) {
        $query = "select matri_id,plan_name, status from pending_orders where matri_id = '" . $DatabaseCo->dbRow->matri_id . "'";
        $resultPendingOrder = $DatabaseCo->dbLink->query($query);
        if ($resultPendingOrder->num_rows > 0) {
            $_SESSION['pending_order'] = true;
        }
    }
}

if (empty($_SESSION['last_login']) && empty($_SESSION['partner_profile']) && empty($_SESSION['no_photo']) && empty($_SESSION['pending_order'])) {
    $query = "select adv_name,adv_link,adv_level,adv_img from advertisement where adv_level='custom' AND status='APPROVED' order by adv_id DESC LIMIT 1";
    $resultCustomAd = $DatabaseCo->dbLink->query($query);
    if ($resultCustom = mysqli_fetch_object($resultCustomAd)) {
        $_SESSION['custom_ad'] = true;
        $_SESSION['custom_adv_link'] = trim($resultCustom->adv_link);
        $_SESSION['custom_adv_image'] = trim($resultCustom->adv_img);
        $_SESSION['custom_adv_name'] = trim($resultCustom->adv_name);
    }
}

$sql = "UPDATE register set last_login='$login_dt' WHERE index_id='" . $DatabaseCo->dbRow->index_id . "'";
$DatabaseCo->dbLink->query($sql);

//Login Backup
$DatabaseCo->dbLink->query("update login_backup set logged_in_at = '" . $login_dt . "', ip_address='" . $_SERVER['REMOTE_ADDR'] . "' where matri_id='" . $DatabaseCo->dbRow->matri_id . "'");

//Login Log
$sql = "INSERT INTO `login_logs`(`matri_id`, `login_time`, `server_ip`,`client_ip`, `url`, `browser`, `user_session`) VALUES
 ('" . $_SESSION['user_id'] . "','" . date('Y-m-d H:i:s') . "','$ip', '" . $_SERVER['REMOTE_ADDR'] . "','$url','$browser','" . session_id() . "')";

$DatabaseCo->dbLink->query($sql);

//Checking Family Origin, Income, and Profile Descriptions
/*$outdatedIncome = ['Rs 50,000 - 1,00,000', 'Rs 1,00,000 - 2,00,000', 'Rs 2,00,000 - 5,00,000', 'Rs 5,00,000 - 10,00,000',
    'Rs 10,00,000 - 20,00,000', 'Rs 20,00,000 - 30,00,000', 'Rs 30,00,000 - 50,00,000', 'Rs 50,00,000 - 1,00,00,000',
    'Above Rs 1,00,00,000', 'Does not matter'];
if (empty($DatabaseCo->dbRow->family_origin) || empty($DatabaseCo->dbRow->profile_text)
    || (empty($DatabaseCo->dbRow->income) || in_array($DatabaseCo->dbRow->income, $outdatedIncome))
    || (empty($DatabaseCo->dbRow->part_income) || in_array($DatabaseCo->dbRow->part_income, $outdatedIncome))) {
    header('location: update-descriptions');
    exit;
}*/

if (isset($getdata) && $getdata != '') {
    header('location: premium_member');
} else {
    header('location: homepage');
}