<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 06/10/2017
 * Time: 11:47 PM
 */
//require_once '../DatabaseConnection.php';
if($_SERVER['REMOTE_ADDR'] != '103.139.220.31') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
ini_set("include_path", '/opt/cpanel/ea-php74/root/usr/share/pear');
ini_set('max_execution_time', 0);
include_once "Mail.php";
include_once('Mail/mime.php');
date_default_timezone_set('Asia/Kolkata');

function get_email_template($DatabaseCo, $tempData, $include)
{
    ob_start();
    include $include;
    return ob_get_clean();
}

function send_email_from_samyak($from, $to, $subject, $messsage){
//    if($_SERVER['HTTP_CF_CONNECTING_IP'] != '103.139.220.31') {
//        return true;
//    }
    $DatabaseCo = new DatabaseConnection();

    $siteDetails = mysqli_fetch_array($DatabaseCo->dbLink->query("select id, from_email, email_pwd from site_config where id='1'"));
    $from = $siteDetails['from_email'];
    $password = $siteDetails['email_pwd'];

//    $to = array('manish011994@gmail.com', 'matrifare@gmail.com');
//    if(is_array($to)){
//        $to = implode(",", $to);
//    }

    $host = "mail.samyakmatrimony.com";
    $port = "587";
    $username = "info@samyakmatrimony.com";

    //Adding BCC
    $bcc = 'reply@samyakmatrimony.com';

    $headers = array ('From' => $from,
        'To' => $to,
        'Subject' => $subject);
    $crlf = "\n";
    // Creating the Mime message
    $mime = new Mail_mime($crlf);

    // Setting the body of the email
    $mime->setTXTBody($messsage);
    $mime->setHTMLBody($messsage);

    $body = $mime->get();
    $headers = $mime->headers($headers);

    // Sending the email
    $mail =Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            //'auth' => true,
            'username' => $username,
            'password' => $password));
    $mail = $mail->send($to.",".$bcc, $headers, $body);
    return true;
//    if (PEAR::isError($mail)) {
//        echo("<p>" . $mail->getMessage() . "</p>");exit;
//    } else {
//        echo("<p>Message successfully sent!</p>");
//    }
}