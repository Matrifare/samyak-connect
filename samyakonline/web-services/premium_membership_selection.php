<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/18/2018
 * Time: 11:58 PM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();

if (empty($_SESSION['user_id'])) {
    // Validate and sanitize planId before storing in cookie
    $planId = isset($_POST['planId']) ? (int)$_POST['planId'] : 0;
    if ($planId > 0) {
        setcookie("planId", $planId, time() + (60 * 1), "/", "", true, true); // Secure and HttpOnly
    }
    echo json_encode(array('result' => 'login', 'view' => '<script>window.location.href=\'login\';</script>'));
    exit;
} else {
    $mid = $_SESSION['user_id'];
}

// Get planId from cookie or POST, validate as integer
if (isset($_COOKIE['planId'])) {
    $planId = (int)$_COOKIE['planId'];
} else {
    $planId = isset($_POST['planId']) ? (int)$_POST['planId'] : 0;
}

if ($planId > 0) {
    // Use prepared statement
    $stmt = $DatabaseCo->dbLink->prepare("SELECT plan_id, plan_name, plan_amount, plan_amount_type, plan_duration, plan_contacts, plan_msg FROM membership_plan WHERE plan_id = ?");
    $stmt->bind_param("i", $planId);
    $stmt->execute();
    $result = $stmt->get_result();
    $get_data = $result->fetch_object();
    $stmt->close();
    
    if (!empty($get_data)) {
        $data = array();
        $data['plan_name'] = htmlspecialchars($get_data->plan_name, ENT_QUOTES, 'UTF-8');
        $data['plan_amount'] = (float)$get_data->plan_amount;
        $data['plan_amount_type'] = htmlspecialchars($get_data->plan_amount_type, ENT_QUOTES, 'UTF-8');
        $data['plan_duration'] = (int)$get_data->plan_duration;
        $data['plan_contacts'] = (int)$get_data->plan_contacts;
        $data['plan_msg'] = htmlspecialchars($get_data->plan_msg, ENT_QUOTES, 'UTF-8');
        $arr['plan_id'] = (int)$get_data->plan_id;
        $_SESSION['planDetails'] = array_merge($data, $arr);
        echo json_encode(array('result' => 'success', 'plan' => $data));
    } else {
        echo json_encode(array('result' => 'error', 'message' => 'No data found for the membership plan.'));
    }
} else {
    echo json_encode(array('result' => 'error', 'message' => 'No Membership Plan defined.'));
}
