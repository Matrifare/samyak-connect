<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/19/2018
 * Time: 1:48 AM
 */
error_reporting(0);
ini_set('display_errors', 0);
include_once '../DatabaseConnection.php';

$DatabaseCo = new DatabaseConnection();
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
include_once '../lib/Config.php';
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';
$configObj = new Config();
if (!empty($_SESSION['planDetails']) && !empty($_SESSION['user_id'])) {
    $plan = $_SESSION['planDetails'];
    $sql = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $_SESSION['user_id'] . "'");
    $res = mysqli_fetch_array($sql);
    $sql = $DatabaseCo->dbLink->query("INSERT INTO `pending_orders`(`matri_id`, `username`, `email`, `mobile`, `plan_name`, `plan_amount`, `status`) VALUES
('" . $_SESSION['user_id'] . "', '" . $_SESSION['uname'] . "', '" . $_SESSION['email'] . "', '" . $_SESSION['mobile'] . "', '" . $_SESSION['planDetails']['plan_name'] . "', '" . $_SESSION['planDetails']['plan_amount'] . "', 'Pending')");


    //Sending mail to Admin
    $from = $configObj->getConfigFrom();
    $to = $configObj->getConfigTo();
    $subject = "Pending Payment Order of - ".$_SESSION['user_id'];
    $message = "
        <table width=50% style='border: none;'>
    <tr>
        <th colspan='2' style='text-align: left;'>Profile Expressed Payment Order on Samyakmatrimony.com</th>
    </tr>
    <tr>
        <th colspan='2' style='text-align: left;'>----------------------------------------------------------------------------------</th>
    </tr>
    <tr>
        <td width='20%'>Profile Id : </td>
        <td width='50%'>" . $_SESSION['user_id'] . "</td>
    </tr>
    <tr>
        <td>Name : </td>
        <td>" . $_SESSION['uname'] . "</td>
    </tr>
    <tr>
        <td>Email : </td>
        <td>" . $_SESSION['email'] . "</td>
    </tr>
    <tr>
        <td>Mobile No : </td>
        <td>" . $_SESSION['mobile'] . "</td>
    </tr>
    <tr>
        <td>Plan :</td>
        <td>" . $_SESSION['planDetails']['plan_name'] . "</td>
    </tr>
    <tr>
        <td>Plan Amount :</td>
        <td>" . $_SESSION['planDetails']['plan_amount'] . "</td>
    </tr>
    <tr>
        <td>Date :</td>
        <td>" . date('d M, Y H:i:s') . "</td>
    </tr>
</table>
        ";
    @send_email_from_samyak($from, $to, $subject,$message);

    //Sending SMS to the User
    if($plan['plan_id'] == '20'){
        $link = "https://bit.ly/2RICczB";
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'PremiumMembership'");
    } else if($plan['plan_id'] == '19') {
        $link = "https://bit.ly/2GcOy1s";
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'GoldMembership'");
    } else if($plan['plan_id'] == '18') {
        $link = "https://bit.ly/2MRl3D4";
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'SilverMembership'");
    } else {
        $link = "https://www.instamojo.com/samyakonline/";
        $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'OrderPending'");
    }
    $rowcs5 = mysqli_fetch_array($result45);
    $message = $rowcs5['temp_value'];
    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
    $mno = $res['mobile'];
    $mobile = substr($mno, 0, 3);
    if ($mobile == '+91') {
        $mno = substr($mno, 3, 15);
    }
    send_to_curl($mno, $sms_template);

    $sql = "select DISTINCT o.*, r.photo1, r.gender, r.firstname, r.index_id,
                    r.birthdate, r.m_status, r.ocp_name, r.city_name
                    from pending_orders o LEFT JOIN register_view r ON r.matri_id = o.matri_id
                    where o.matri_id='".$_SESSION['user_id']."' ORDER BY o.created_at DESC LIMIT 1";

    $result = $DatabaseCo->getSelectQueryResult($sql);
    if($result->num_rows > 0) {
        while ($tempData = mysqli_fetch_object($result)) {
            $dataArr['tempData'] = $tempData;
            $dataArr['fromPage'] = "upgrade";
            $dataArr['title']    = "Processing Membership Upgrade";
            $dataArr['subTitle'] = "You have tried upgrading your membership on Samyakmatrimony";
            $dataArr['button']   = "Upgrade Membership";
            if(!empty($tempData)) {
                $subject = "Processing Membership Upgrade on Samyakmatrimony";
                $template = get_email_template($DatabaseCo, $dataArr, '../email-templates/pending_membership_email_template.php');
                send_email_from_samyak($from, trim($tempData->email), $subject, $template);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $configObj->getConfigTitle(); ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
</head>
<body>
<!--<form method="post" name="customerData1" id="submit_form" action="<?php /*echo $configObj->getConfigname(); */?>ccavRequestHandler" enctype="multipart/form-data">-->
<form method="post" name="customerData1" id="submit_form" action="../ccavRequestHandler" enctype="multipart/form-data">
    <input type="hidden" name="merchant_id" value="2046"/>
    <input type="hidden" name="order_id" value="<?php echo ($_SESSION['user_id'] . '-' . $plan['plan_id']) ?? ""; ?>"/>
    <input type="hidden" name="currency" value="INR"/>
    <input type="hidden" name="redirect_url" value="https://www.samyakmatrimony.com/payment_success"/>
    <input type="hidden" name="cancel_url" value="https://www.samyakmatrimony.com/payment_cancelled"/>
    <input type="hidden" name="language" value="EN"/>
    <input type="hidden" name="billing_name" value="<?php echo $res['username'] ?? ""; ?>"/>
    <input type="hidden" name="billing_address" value="<?php echo $res['address'] ?? ""; ?>"/>
    <input type="hidden" name="billing_state" value="<?= $res['state_name']; ?>"/>
    <input type="hidden" name="billing_city" value="<?= $res['city_name']; ?>"/>
    <input type="hidden" name="billing_zip" value="<?= '400604' ?>"/>
    <input type="hidden" name="billing_country" value="<?= $res['country_name'] ?>"/>
    <input type="hidden" name="billing_tel" value="<?php echo $res['mobile'] ?? ""; ?>"/>
    <input type="hidden" name="billing_email" value="<?php echo $res['email'] ?? ""; ?>"/>
    <input type="hidden" name="udf1" value="<?php echo $plan['plan_name']; ?>"/>
    <input type="hidden" name="udf2" value="<?php echo $plan['plan_id']; ?>"/>
    <input TYPE="hidden" class="button-green-border-big xxl-16 xl-16 xs-16 m-16 l-16" value="Paynow" name="submit_payu">
</form>
<script>
    document.getElementById("submit_form").submit();// Form submission
</script>
</body>
</html>
