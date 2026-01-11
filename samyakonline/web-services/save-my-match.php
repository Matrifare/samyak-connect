<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 9/11/2018
 * Time: 8:39 PM
 */

require_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();
$mid = $_SESSION['user_id'] ?? "";

$part_m_status = !empty($_POST['m_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['m_status'])) : "";
$part_from_age = !empty($_POST['t3']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['t3']) : "";
$part_to_age = !empty($_POST['t4']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['t4']) : "";
$part_from_height = !empty($_POST['fromheight']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['fromheight']) : "";
$part_to_height = !empty($_POST['toheight']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['toheight']) : "";
$part_religion = !empty($_POST['religion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['religion'])) : "";
$part_caste = !empty($_POST['caste']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['caste'])) : "";
$part_complexion = !empty($_POST['complexion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['complexion'])) : "";
$part_edu_field = !empty($_POST['education_field']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['education_field'])) : "";
$part_occupation = !empty($_POST['occupation']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['occupation'])) : "";
$part_country = !empty($_POST['country']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['country'])) : "";
$part_city = !empty($_POST['city']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['city'])) : "";
$part_native_place = !empty($_POST['family_origin']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['family_origin'])) : "";
$part_edu_level = !empty($_POST['education_level']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['education_level'])) : "";

//Update Register
$update = $DatabaseCo->dbLink->query("UPDATE register set looking_for='$part_m_status', part_frm_age='$part_from_age',
part_to_age='$part_to_age',part_height='$part_from_height',part_height_to='$part_to_height', part_religion='$part_religion',
part_caste='$part_caste', part_complexion='$part_complexion', part_native_place='$part_native_place', part_occupation='$part_occupation', 
part_edu_field='$part_edu_field', part_country_living='$part_country', part_city='$part_city', part_edu_level='$part_edu_level' WHERE matri_id='$mid'");

unset($_SESSION['religion']);
unset($_SESSION['caste']);
unset($_SESSION['other_caste']);
unset($_SESSION['special_case']);
unset($_SESSION['m_tongue']);
unset($_SESSION['fromage']);
unset($_SESSION['toage']);
unset($_SESSION['fromheight']);
unset($_SESSION['toheight']);
unset($_SESSION['m_status']);
unset($_SESSION['education_level']);
unset($_SESSION['education_field']);
unset($_SESSION['family_origin']);
unset($_SESSION['occupation']);
unset($_SESSION['country']);
unset($_SESSION['state']);
unset($_SESSION['city']);
unset($_SESSION['manglik']);
unset($_SESSION['keyword']);
unset($_SESSION['photo_search']);
unset($_SESSION['gender']);
unset($_SESSION['tot_children']);
unset($_SESSION['annual_income']);
unset($_SESSION['diet']);
unset($_SESSION['drink']);
unset($_SESSION['complexion']);
unset($_SESSION['bodytype']);
unset($_SESSION['star']);
unset($_SESSION['id_search']);
unset($_SESSION['smoking']);
unset($_SESSION['samyak_id']);
unset($_SESSION['samyak_id_search']);
unset($_SESSION['samyak_search']);
unset($_SESSION['search_by_profile_id']);

if ($update) {
    return print_r(json_encode(array('result' => 'success')));
} else {
    return print_r(json_encode(array('result' => 'failed')));
}