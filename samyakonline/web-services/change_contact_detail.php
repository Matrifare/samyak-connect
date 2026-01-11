<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 01/25/2020
 * Time: 07:22 PM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/curl.php';
if (isset($_POST['change_contact_detail'])) {
    $matri_id = $_SESSION['user_id'];
    $sql = "select email, mobile, phone from register_view where matri_id='" . $matri_id . "'";
    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
    $Row = mysqli_fetch_object($DatabaseCo->dbResult);

    $mes = "";
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['email']) : "";
    $primaryMobile = !empty($_POST['p_mobile_no']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['p_mobile_no']) : "";
    $secondaryMobile = !empty($_POST['s_mobile_no']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['s_mobile_no']) : "";
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $primaryMobile = filter_var($_POST['p_mobile_no'], FILTER_SANITIZE_NUMBER_INT);
    $secondaryMobile = filter_var($_POST['s_mobile_no'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "select email from register where email='" . $email . "'";
    $count = $DatabaseCo->dbLink->query($sql);
    $isEmailAvailable = mysqli_num_rows($count);
    if ($isEmailAvailable > 1) {
        return print_r(json_encode(array('result' => 'failed', 'action' => 'show_message', 'msg' => 'Email already exists, please use a different email id.')));
    } else {

        if ($Row->mobile !== $primaryMobile) {
            $mobile = substr($primaryMobile, 0, 3);
            if ($mobile == '+91') {
                $mobile = substr($primaryMobile, 3, 15);
            } else {
                $mobile = $primaryMobile;
            }
            $phone = substr($secondaryMobile, 0, 3);
            if ($phone == '+91') {
                $phone = substr($secondaryMobile, 3, 15);
            } else {
                $phone = $secondaryMobile;
            }
            if (!empty($email) && !empty($mobile)) {
                $result = mysqli_query($DatabaseCo->dbLink, "update register set mobile='$mobile',mobile_verify_status='No', phone='$phone', email='$email'
                      where matri_id='" . $matri_id . "'");
                if ($result) {
                    $_SESSION['last_login'] = 'first_time';
                    return print_r(json_encode(array('result' => 'success', 'action' => 'redirect', 'msg' => 'Contact Details updated successfully, please verify your mobile number.')));
                } else {
                    return print_r(json_encode(array('result' => 'failed', 'action' => 'show_message', 'msg' => 'Failed to update contact details')));
                }
            } else {
                return print_r(json_encode(array('result' => 'failed', 'action' => 'show_message', 'msg' => 'Email and Primary Mobile Number is mandatory')));
            }
        } else {
            $phone = substr($secondaryMobile, 0, 3);
            if ($phone == '+91') {
                $phone = substr($secondaryMobile, 3, 15);
            } else {
                $phone = $secondaryMobile;
            }
            if (!empty($email)) {
                $result = mysqli_query($DatabaseCo->dbLink, "update register set phone='$phone', email='$email'
                      where matri_id='" . $matri_id . "'");
                if ($result) {
                    return print_r(json_encode(array('result' => 'success', 'action' => 'show_message', 'msg' => 'Contact Details updated successfully.')));
                } else {
                    return print_r(json_encode(array('result' => 'failed', 'action' => 'show_message', 'msg' => 'Failed to update contact details')));
                }
            } else {
                return print_r(json_encode(array('result' => 'failed', 'action' => 'show_message', 'msg' => 'Email and Primary Mobile Number is mandatory')));
            }
        }
    }
}