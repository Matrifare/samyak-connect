<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/30/2018
 * Time: 11:51 PM
 */
include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();

if(isset($_REQUEST['to']))
{
    $from=$_REQUEST['to'];
    $to=$_REQUEST['from'];

    //echo "select `id` from chat where `to`='$to' and `from`='$from'";
    $sql=$DatabaseCo->dbLink->query("select `id` from chat where `to`='$to' and `from`='$from'");
    $count=mysqli_num_rows($sql);
    echo $count;
}
?>