<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 12/02/2020
 * Time: 08:15 PM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();

$matri_id = $_SESSION['user_id'] ?? "";
$sqlData = "select id from express_interest_privacy_details where matri_id='" . $matri_id . "' LIMIT 1";
$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlData);
$isDataPresent = $DatabaseCo->dbResult->num_rows ? true : false;

$privacyType = $_POST['privacy_type'] ?? 'anyone';
$privacyType = (mysqli_real_escape_string($DatabaseCo->dbLink, $privacyType) == 'anyone' ? 0 : 1);
$maritalStatus = !empty($_POST['m_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['m_status'])) : "";
$religion = !empty($_POST['religion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['religion'])) : "";
$fromAge = !empty($_POST['frm_age']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['frm_age']) : "";
$toAge = !empty($_POST['to_age']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['to_age']) : "";
$fromHeight = !empty($_POST['from_height']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['from_height']) : "";
$toHeight = !empty($_POST['height_to']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['height_to']) : "";
$educationLevel = !empty($_POST['education_level']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['education_level'])) : "";
$educationField = !empty($_POST['education_field']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['education_field'])) : "";
$income = !empty($_POST['income']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['income']) : "";
$photoSearch = !empty($_POST['photo_search']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['photo_search']) : 0;
if (!empty($photoSearch) && $photoSearch == "Yes") {
    $photoSearch = 1;
}

if ($isDataPresent) {
    $dataResult = mysqli_fetch_object($DatabaseCo->dbResult);
    if ($privacyType) {
        $sql = "update express_interest_privacy_details set looking_for='$maritalStatus', religion='$religion', age_from=$fromAge,
 age_to=$toAge, height_from=$fromHeight, height_to=$toHeight, edu_level='$educationLevel', edu_field='$educationField',
  annual_income='$income', with_photo=$photoSearch, status=1 where id='$dataResult->id' AND matri_id='$matri_id'";
    } else {
        $sql = "update express_interest_privacy_details set status=0 where id='$dataResult->id' AND matri_id='$matri_id'";
    }
} else {
    if ($privacyType) {
        $sql = "insert into express_interest_privacy_details(matri_id, looking_for, religion, age_from, age_to,
height_from, height_to, edu_level, edu_field, annual_income, with_photo) values
('$matri_id', '$maritalStatus', '$religion', $fromAge, $toAge,
$fromHeight, $toHeight, '$educationLevel', '$educationField', '$income', $photoSearch)";
    }
}

if (!empty($sql)) {
    $result = mysqli_query($DatabaseCo->dbLink, $sql);
} else {
    return print_r(json_encode(['result' => 'success', 'msg' => 'Nothing to update.']));
}
if ($result) {
    return print_r(json_encode(['result' => 'success', 'msg' => 'Your Privacy Updated.']));
} else {
    return print_r(json_encode(['result' => 'failed', 'msg' => 'Failed to update your privacy.']));
}