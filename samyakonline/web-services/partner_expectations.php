<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 11/15/2018
 * Time: 2:03 AM
 */

require_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
if (!empty($_SESSION['user_id'])) {

    $looking = filter_var(trim(implode(',', $_POST['looking'])), FILTER_SANITIZE_STRING) ?? "";
    $casteNoBar = filter_var(trim($_POST['caste_bar']), FILTER_SANITIZE_STRING) ?? "";
    if ($casteNoBar == 'Yes') {
        $otherCaste = 1;
    } else {
        $otherCaste = 0;
    }
    $part_religion_id = filter_var(trim(implode(',', $_POST['part_religion_id'])), FILTER_SANITIZE_STRING) ?? "";
    $part_caste_id = filter_var(trim(implode(',', $_POST['part_caste_id'])), FILTER_SANITIZE_STRING) ?? "";
    $pfrom_age = filter_var(trim($_POST['pfrom_age']), FILTER_SANITIZE_STRING) ?? "";
    $pto_age = filter_var(trim($_POST['pto_age']), FILTER_SANITIZE_STRING) ?? "";
    if (!empty($_POST['part_height'])) {
        $part_height = filter_var(trim($_POST['part_height']), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_height = "";
    }
    if (!empty($_POST['part_height_to'])) {
        $part_height_to = filter_var(trim($_POST['part_height_to']), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_height_to = "";
    }

    if (!empty($_POST['part_edu_level'])) {
        $part_edu_level = filter_var(trim(implode(',', $_POST['part_edu_level'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_edu_level = "";
    }
    if (!empty($_POST['part_edu_field'])) {
        $part_edu_field = filter_var(trim(implode(',', $_POST['part_edu_field'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_edu_field = "";
    }
    if (!empty($_POST['part_occupation'])) {
        $part_occupation = filter_var(trim(implode(',', $_POST['part_occupation'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_occupation = "";
    }
    if (!empty($_POST['part_country_id'])) {
        $part_country_id = filter_var(trim(implode(',', $_POST['part_country_id'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_country_id = "";
    }
    if (!empty($_POST['part_complexion'])) {
        $part_complexion = filter_var(trim(implode(',', $_POST['part_complexion'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_complexion = "";
    }
    if (!empty($_POST['part_city'])) {
        $part_city = filter_var(trim(implode(',', $_POST['part_city'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_city = "";
    }
    if (!empty($_POST['part_native_city'])) {
        $part_native_city = filter_var(trim(implode(',', $_POST['part_native_city'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_native_city = "";
    }
    if (!empty($_POST['part_emp_in'])) {
        $part_emp_in = filter_var(trim(implode(',', $_POST['part_emp_in'])), FILTER_SANITIZE_STRING) ?? "";
    } else {
        $part_emp_in = "";
    }

    $isPartnerUpdated = $DatabaseCo->dbLink->query("UPDATE `register` SET `looking_for`='$looking',`other_caste`='$otherCaste',
    `part_frm_age`='$pfrom_age', `part_to_age`='$pto_age', `part_emp_in`='$part_emp_in', `part_occupation`='$part_occupation',
     `part_height`='$part_height', `part_height_to`='$part_height_to', `part_complexion` = '$part_complexion',
        `part_religion` = '$part_religion_id', `part_caste` = '$part_caste_id', `part_edu_level` = '$part_edu_level',
         `part_edu_field` = '$part_edu_field', `part_country_living`='$part_country_id', `part_city`='$part_city',
          `part_native_place`='$part_native_city' where matri_id='" . $_SESSION['user_id'] . "'");
    if ($isPartnerUpdated) {
        unset($_SESSION['partner_profile']);
        return print_r(json_encode(['result' => 'success', 'msg' => 'Successfully updated the partner Expectations.']));
    } else {
        return print_r(json_encode(['result' => 'failed', 'msg' => "Failed to update the partner expectations."]));
    }
} else {
    return print_r(json_encode(['result' => 'failed', 'msg' => "Failed to update the partner expectations."]));
}