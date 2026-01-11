<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10-01-2019
 * Time: 10:10 PM
 */

include_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$matriId = !empty($_POST['matri_id']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['matri_id']) : "";
$SQL_STATEMENT = "SELECT video, video_url, video_view_status from register_view WHERE matri_id='$matriId' and video_approval='APPROVED'";
$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);
if (mysqli_num_rows($DatabaseCo->dbResult) > 0) {
    $Row = mysqli_fetch_object($DatabaseCo->dbResult);
    return print_r(json_encode(['result'=>'success', 'message'=> 'Video Viewed','url'=>"https://www.youtube.com/embed/".$Row->video_url]));
} else {
    return print_r(json_encode(['result'=>'failed', 'message'=> 'Oops! Something went wrong.']));
}