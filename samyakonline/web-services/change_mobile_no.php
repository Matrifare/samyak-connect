<?php
/**
 * Created by PhpStorm.
 * User: USER1
 * Date: 8/17/2017
 * Time: 1:53 PM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();

$matriId = $_POST['matriId'];
$mobileNo = "+91".$_POST['mobileNo'];
$result = mysqli_query($DatabaseCo->dbLink, "update register set mobile='$mobileNo' where matri_id='" . $matriId . "'");
return print_r(json_encode(array("result"=>$result, 'mobileNo'=>$mobileNo)));