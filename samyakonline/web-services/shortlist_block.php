<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/28/2018
 * Time: 11:41 PM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';
include_once '../lib/sendmail.php';
$DatabaseCo = new DatabaseConnection();
$result = [];
if (!empty($_POST['id']) && !empty($_POST['type']) && $_POST['type'] == 'add') {
    $from_id = $_SESSION['user_id'];
    $to_id = $_POST['id'];
    $SQL_STATEMENT = "insert into shortlist (from_id,to_id,add_date) values ('$from_id','$to_id','".date('Y-m-d H:i:s')."')";
    $exe = $DatabaseCo->dbLink->query($SQL_STATEMENT) or die(mysqli_error($DatabaseCo->dbLink));
    if ($exe) {
        $result['result'] = 'success';
        $result['text'] = 'Remove Bookmark';
        $result['addClass'] = 'fa-star';
        $result['removeClass'] = 'fa-star-o';
    } else {
        $result['result'] = 'failed';
    }
}


if (!empty($_POST['id']) && !empty($_POST['type']) && $_POST['type'] == 'remove') {
    $from_id = $_SESSION['user_id'];
    $to_id = $_POST['id'];
    $SQL_STATEMENT = "DELETE FROM shortlist WHERE from_id='$from_id' and to_id='$to_id'";
    $exe = $DatabaseCo->dbLink->query($SQL_STATEMENT) or die(mysqli_error($DatabaseCo->dbLink));
    if ($exe) {
        $result['result'] = 'success';
        $result['text'] = 'Bookmark Profile';
        $result['addClass'] = 'fa-star-o';
        $result['removeClass'] = 'fa-star';
    } else {
        $result['result'] = 'failed';
    }
}


if (!empty($_POST['id']) && !empty($_POST['type']) && $_POST['type'] == 'block') {
    $block_by = $_SESSION['user_id'];
    $block_to = $_POST['id'];
    $SQL_STATEMENT = "insert into block_profile (block_by,block_to,block_date) values ('$block_by','$block_to','".date('Y-m-d H:i:s')."')";
    $exe = $DatabaseCo->dbLink->query($SQL_STATEMENT) or die(mysqli_error($DatabaseCo->dbLink));
    if ($exe) {
        $result['result'] = 'success';
        $result['text'] = 'Unblock';
        $result['addClass'] = 'fa-check text-success';
        $result['removeClass'] = 'fa-ban text-danger';
    } else {
        $result['result'] = 'failed';
    }
}


if (!empty($_POST['id']) && !empty($_POST['type']) && $_POST['type'] == 'unblock') {
    $block_by = $_SESSION['user_id'];
    $block_to = $_POST['id'];
    $SQL_STATEMENT = "DELETE FROM  block_profile WHERE block_by='$block_by' and block_to='$block_to'";
    $exe = $DatabaseCo->dbLink->query($SQL_STATEMENT) or die(mysqli_error($DatabaseCo->dbLink));
    if ($exe) {
        $result['result'] = 'success';
        $result['text'] = 'Block Profile';
        $result['addClass'] = 'fa-ban text-danger';
        $result['removeClass'] = 'fa-check text-success';
    } else {
        $result['result'] = 'failed';
    }
}
return print_r(json_encode($result));