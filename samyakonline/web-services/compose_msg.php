<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/18/2018
 * Time: 1:07 AM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';
//include_once 'auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
include_once '../lib/XssClean.php';
$xssClean = new xssClean();
include_once '../lib/curl.php';
include_once '../lib/sendmail.php';
$matid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$sel = $DatabaseCo->dbLink->query("SELECT * FROM payments where pmatri_id='$matid'");
$fet = mysqli_fetch_array($sel);
$tot_contacts = $fet['p_msg'];
$use_contacts = $fet['r_sms'];
$use_contacts = $use_contacts + 1;

$exp_date = date('Y-m-d', strtotime($fet['exp_date']));
$today = date('Y-m-d');

if ($tot_contacts >= $use_contacts && $exp_date > $today) {

} else {
    ?>
    <script>alert('Your membership is expired or you are not a paid member, please upgrade your membership now.');</script>
    <?php
    echo "<script>window.location='premium_member'</script>";
}

if (isset($_POST['user_id'])) {
    $get_arr_username_email = $DatabaseCo->dbLink->query("select matri_id,username,email from register where status!='Suspended' and status!='Inactive' and matri_id='" . $_GET['user_id'] . "'");
} else {
    $get_arr_username_email = $DatabaseCo->dbLink->query("select matri_id,username,email from register where status!='Suspended' and status!='Inactive' and matri_id!='" . $_SESSION['user_id'] . "' and gender!='" . $_SESSION['gender123'] . "'");
}
?>
<html>
<head>
    <title>Send Message</title>
</head>
<body>
<form class="" method="post" action="" style="padding-top: 10px;">
    <div class="inner" style="padding: 0px 5px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="margin-bottom: 0px;">
            <tr style="">
                <td style="padding: 4px;">
                    <textarea name="msg" class="form-control"></textarea>
                </td>
                <td style="padding: 4px;">
                    <input type="submit" name="search" value="Search"
                           class="btn btn-danger btn-sm btn-shrink"
                           style="cursor:pointer;"/>
                </td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>