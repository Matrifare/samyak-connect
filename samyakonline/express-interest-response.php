<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/13/2018
 * Time: 8:48 PM
 */
include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
// to Sanitize database inputs for security purpose  starts //


$input = $_GET['response'] ?? "";
$encryptedData = sanitize($input);

$password = "Samyak####726925";
$decryptedString = openssl_decrypt($encryptedData,"AES-128-ECB",$password);

if(empty($decryptedString)) {
    echo "<h1 style='color:#ff0000;text-align:center'>Unauthorized URL</h1>";
    exit;
}
$data = explode('####', $decryptedString);
echo "<pre>";print_r($data);exit;