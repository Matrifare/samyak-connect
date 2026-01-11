<?php
/**
 * @author : Manish Gupta
 * @date : 30/01/2021 05:20 PM
 * @desc : To confirm the email after registration
 */

require_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
include_once 'lib/sendmail.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();



if (!empty($_GET['profile']) && !empty($_GET['confirm_key'])) {
    $input = $_GET['profile'] ?? "";
    $profile = sanitize($input);
    $reverseProfile = hexdec($profile);
    $key = 726925;
    $reverseProfile = $reverseProfile / $key;

    $sql = "select * from register_view WHERE index_id=" . $reverseProfile;
    $fetch = mysqli_fetch_object($DatabaseCo->getSelectQueryResult($sql));
    if (!empty($fetch)) {
        if ($fetch->email_verify_status == 'No') {
            if (md5('726925' . $fetch->email . $fetch->index_id) === $_GET['confirm_key']) {
                $DatabaseCo->dbLink->query("update register set email_verify_status='Yes'
                                                    where index_id=" . $fetch->index_id);
                $subject = 'Email verified successfully on Samyakmatrimony';
                $template = get_email_template($DatabaseCo, $fetch, 'email-templates/email_verification_complete_email_template.php');
                send_email_from_samyak($configObj->getConfigFrom(), $fetch['email'], $subject, $template);
                echo "<h2>Your email id is verified on https://www.samyakmatrimony.com</h2>";
                echo "<h4>We are redirecting you to login page in 5 seconds.</h4>";
                echo "<script>setTimeout(function(){window.location.href='login'}, 5000);</script>";
                return true;
            } else {
                return print_r("<h1>Unauthenticated URL</h1>");
            }
        } else {
            echo "<h2>Your email id was already verified on https://www.samyakmatrimony.com</h2>";
            echo "<h4>We are redirecting you to login page in 5 seconds.</h4>";
            echo "<script>setTimeout(function(){window.location.href='login'}, 5000);</script>";
            return true;
        }
    } else {
        return print_r("<h1>Unauthorized URL</h1>");
    }
} else {
    return print_r("<h1>Invalid URL.</h1>");
}