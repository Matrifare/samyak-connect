<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/2/2018
 * Time: 10:30 PM
 */

require_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
if (empty($_SESSION['profile_suspended_id']))
    include_once '../auth.php';
include_once '../lib/sendmail.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$mid = $_SESSION['user_id'] ?? "";

$updateType = $_POST['update_type'] ?? "";
if ($updateType == 'profile') {
    $firstName = !empty($_POST['first_name']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['first_name']) : "";
    $lastName = !empty($_POST['last_name']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['last_name']) : "";
    $day = !empty($_POST['day']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['day']) : "";
    $month = !empty($_POST['month']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['month']) : "";
    $year = !empty($_POST['year']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['year']) : "";
    $dob = $year . "-" . $month . "-" . $day;
//    $maritalStatus = !empty($_POST['marital_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['marital_status']) : "";
    $childStatus = !empty($_POST['children_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['children_status']) : "";
    $height = !empty($_POST['height']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['height']) : "";
    $weight = !empty($_POST['weight']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['weight']) : "";
    $montherTongue = !empty($_POST['mothertongue']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['mothertongue']) : "";
    $disability = !empty($_POST['disability']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['disability']) : "";
    $complexion = !empty($_POST['complexion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['complexion']) : "";
    $bodyType = !empty($_POST['body_type']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['body_type']) : "";
    $diet = !empty($_POST['diet']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['diet']) : "";
    $drink = !empty($_POST['drink']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['drink']) : "No";
    $bloodGroup = !empty($_POST['b_group']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['b_group']) : "";
    $smoke = !empty($_POST['smoke']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['smoke']) : "No";
    $religion = !empty($_POST['religion_id']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['religion_id']) : "";
    $caste = !empty($_POST['my_caste']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['my_caste']) : "";
    $profileFor = !empty($_POST['profile_for']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['profile_for']) : "";

    //Update in Register
    $update = $DatabaseCo->dbLink->query("UPDATE register set username='$firstName $lastName',firstname='$firstName',religion='$religion',
                lastname='$lastName',status_children='$childStatus',m_tongue='$montherTongue',height='$height',weight='$weight',diet='$diet',drink='$drink',caste='$caste',
                smoke='$smoke',bodytype='$bodyType',complexion='$complexion',birthdate='$dob',profileby='$profileFor',b_group='$bloodGroup',
                disability='$disability' where matri_id='$mid'");

    if ($update) {
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }

} else if ($updateType == 'education') {
    $eduDetail = !empty($_POST['qualification']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['qualification'])) : "";
    $eduLevel = !empty($_POST['education_level']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['education_level']) : "";
    $eduField = !empty($_POST['education_field']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['education_field']) : "";
    $occupation = !empty($_POST['occupation']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['occupation']) : "";
    $empIn = !empty($_POST['emp_in']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['emp_in']) : "";
    $income = !empty($_POST['income']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['income']) : "";
    $monthly_sal = !empty($_POST['monthly_income']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['monthly_income']) : "";

    $update = $DatabaseCo->dbLink->query("UPDATE register set education_level='$eduLevel',education_field='$eduField',
edu_detail='$eduDetail',occupation='$occupation',emp_in='$empIn',income='$income',monthly_sal='$monthly_sal' WHERE matri_id='$mid'");

    if ($update) {
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }
} else if ($updateType == 'contact') {
    $livingStatus = !empty($_POST['living_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['living_status']) : "";
    $houseOwnership = !empty($_POST['house_ownership']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['house_ownership']) : "";
    $residence = !empty($_POST['residence']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['residence']) : "";
    $country = !empty($_POST['country']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['country']) : "";
    $state = !empty($_POST['state']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['state']) : "";
    $city = !empty($_POST['city']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['city']) : "";
    $timeToCall = !empty($_POST['time_to_call']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['time_to_call']) : "";

    $update = $DatabaseCo->dbLink->query("UPDATE register set living_status='$livingStatus',house_ownership='$houseOwnership',
residence='$residence',country_id='$country',state_id='$state',city='$city',
 time_to_call='$timeToCall' WHERE matri_id='$mid'");

    if ($update) {
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }
} else if ($updateType == 'family') {
    $family_origin = !empty($_POST['family_origin']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['family_origin']) : "";
    $family_type = !empty($_POST['family_type']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['family_type']) : "";
    $family_status = !empty($_POST['family_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['family_status']) : "";
    $family_value = !empty($_POST['family_value']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['family_value']) : "";
    $father_ocp = !empty($_POST['father_ocp']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['father_ocp']) : "";
    $mother_ocp = !empty($_POST['mother_ocp']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['mother_ocp']) : "";
    $no_of_brother = !empty($_POST['no_of_brother']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['no_of_brother']) : "";
    $no_of_sister = !empty($_POST['no_of_sister']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['no_of_sister']) : "";
    $nmb = !empty($_POST['nmb']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['nmb']) : "";
    $nms = !empty($_POST['nms']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['nms']) : "";


    //Update Register
    $update = $DatabaseCo->dbLink->query("UPDATE register set family_origin='$family_origin',family_type='$family_type',
family_status='$family_status',family_value='$family_value',father_occupation='$father_ocp',mother_occupation='$mother_ocp',
 no_of_brothers='$no_of_brother', no_of_sisters='$no_of_sister', no_marri_brother='$nmb', no_marri_sister='$nms'
 WHERE matri_id='$mid'");

    if ($update) {
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }
} else if ($updateType == 'partner') {
    $part_m_status = !empty($_POST['part_m_status']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_m_status'])) : "";
    $part_mtongue = !empty($_POST['part_m_tongue']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_m_tongue'])) : "";
    $part_from_age = !empty($_POST['part_from_age']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_from_age']) : "";
    $part_to_age = !empty($_POST['part_to_age']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_to_age']) : "";
    $part_from_height = !empty($_POST['part_from_height']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_from_height']) : "";
    $part_to_height = !empty($_POST['part_to_height']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_to_height']) : "";
    $part_bodytype = !empty($_POST['part_bodytype']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(", ", $_POST['part_bodytype'])) : "";
    $part_diet = !empty($_POST['part_diet']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(", ", $_POST['part_diet'])) : "";
//    $part_smoke = !empty($_POST['part_smoke']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(", ", $_POST['part_smoke'])) : "";
    $part_drink = !empty($_POST['part_drink']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(", ", $_POST['part_drink'])) : "";
    $part_other_caste = !empty($_POST['part_other_caste']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_other_caste']) : "0";
    $part_religion = !empty($_POST['part_religion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_religion'])) : "";
    $part_caste = !empty($_POST['part_caste']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_caste'])) : "";
    $part_manglik = !empty($_POST['part_manglik']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_manglik']) : "";
    $part_complexion = !empty($_POST['part_complexion']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(", ", $_POST['part_complexion'])) : "";
    $part_education = !empty($_POST['part_education']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_education'])) : "";
    $part_edu_field = !empty($_POST['part_edu_field']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_edu_field'])) : "";
    $part_emp_in = !empty($_POST['part_emp_in']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_emp_in'])) : "";
    $part_occupation = !empty($_POST['part_occupation']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_occupation'])) : "";
    $part_income = !empty($_POST['part_income']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['part_income']) : "";
    $part_country = !empty($_POST['part_country']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_country'])) : "";
    $part_state = !empty($_POST['part_state']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_state'])) : "";
    $part_city = !empty($_POST['part_city']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_city'])) : "";
    $part_native_place = !empty($_POST['part_native_place']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_native_place'])) : "";
    $part_residence = !empty($_POST['part_residence']) ? mysqli_real_escape_string($DatabaseCo->dbLink, implode(",", $_POST['part_residence'])) : "";

    //Update Register
    $update = $DatabaseCo->dbLink->query("UPDATE register set looking_for='$part_m_status',part_mtongue='$part_mtongue',
part_frm_age='$part_from_age', part_to_age='$part_to_age',part_height='$part_from_height',part_height_to='$part_to_height',
part_bodytype='$part_bodytype', part_diet='$part_diet',other_caste='$part_other_caste',part_drink='$part_drink',part_religion='$part_religion',
part_caste='$part_caste', part_manglik='$part_manglik', part_complexion='$part_complexion', part_native_place='$part_native_place',
 part_edu='$part_education', part_emp_in='$part_emp_in', part_occupation='$part_occupation', part_income='$part_income', part_edu_field='$part_edu_field',
 part_country_living='$part_country', part_state='$part_state', part_city='$part_city', part_resi_status='$part_residence' WHERE matri_id='$mid'");

    if ($update) {
        unset($_SESSION['partner_profile']);
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }
} else if ($updateType == 'suspended' || $updateType == 'description_page') {
    $mid = !empty($_SESSION['profile_suspended_id']) ? $_SESSION['profile_suspended_id'] : ($_SESSION['user_id'] ?? "");

    if (empty($mid)) {
        return print_r(json_encode(array('result' => 'failed')));
    }

    //Update Family Origin if description update page and not empty family_origin
    if ($updateType == 'description_page' &&
        (!empty($_POST['family_origin']) || !empty($_POST['income']))) {
        $updateData = "";
        if(!empty($_POST['family_origin'])) {
            $updateData .= "family_origin ='" . $_POST['family_origin'] . "'";
        }
        if(!empty($_POST['income'])) {
            $updateData = !empty($updateData) ? $updateData."," : "";
            $updateData .= "income ='" . $_POST['income'] . "'";
        }
        if(!empty($updateData)) {
            $insert = $DatabaseCo->dbLink->query("update register set $updateData WHERE matri_id='$mid'");
        }
    }

    $profileText = !empty($_POST['profile_text']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['profile_text']) : "";
    //Approval Entry of Profile Details
    if (!empty($profileText)) {
        $sql = "select r.profile_text, da.profile_text as `approval_text` from register_view r
                    LEFT JOIN description_approvals da ON r.matri_id=da.matri_id
                     where r.matri_id='" . $mid . "' AND da.updated_data='1' AND da.status='0'
                     ORDER BY da.id DESC LIMIT 1";
        $SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);

        if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
            if ($DatabaseCo->dbRow->profile_text != $profileText &&
                (empty($DatabaseCo->dbRow->approval_text) || $DatabaseCo->dbRow->approval_text != $profileText)) {
                //Approval Entry
                $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,profile_text, updated_data)
                            VALUES ('$mid', '$profileText', '1')");
            }
        } else {
            //Approval Entry
            $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,profile_text, updated_data)
                            VALUES ('$mid', '$profileText', '1')");
        }
    }

    $aboutFamily = !empty($_POST['about_my_family']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['about_my_family']) : "";
    //Approval Entry of Family Details
    if (!empty($aboutFamily)) {
        $sql = "select r.family_details, da.family_details as `family_approval_text` from register_view r
                    LEFT JOIN description_approvals da ON r.matri_id=da.matri_id
                     where r.matri_id='" . $mid . "' AND da.updated_data='2' AND da.status='0'
                     ORDER BY da.id DESC LIMIT 1";
        $SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);

        if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
            if ($DatabaseCo->dbRow->family_details != $aboutFamily &&
                (empty($DatabaseCo->dbRow->family_approval_text) || $DatabaseCo->dbRow->family_approval_text != $aboutFamily)) {
                //Approval Entry
                $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,family_details,
                                updated_data) VALUES ('$mid', '$aboutFamily', '2')");
            }
        } else {
            //Approval Entry
            $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,family_details,
                        updated_data) VALUES ('$mid', '$aboutFamily', '2')");
        }
    }

    $expectation = !empty($_POST['expectation']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['expectation']) : "";
    //Approval Entry of Partner Details
    if (!empty($expectation)) {
        $sql = "select r.part_expect, da.part_expect as `part_expect_approval_text` from register_view r
                    LEFT JOIN description_approvals da ON r.matri_id=da.matri_id
                     where r.matri_id='" . $mid . "' AND da.updated_data='3' AND da.status='0'
                     ORDER BY da.id DESC LIMIT 1";
        $SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);

        if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
            if ($DatabaseCo->dbRow->part_expect != $expectation &&
                (empty($DatabaseCo->dbRow->part_expect_approval_text) || $DatabaseCo->dbRow->part_expect_approval_text != $expectation)) {
                //Approval Entry
                $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,part_expect, updated_data)
                            VALUES ('$mid', '$expectation', '3')");
            }
        } else {
            //Approval Entry
            $insert = $DatabaseCo->dbLink->query("insert into description_approvals(matri_id,part_expect, updated_data)
                            VALUES ('$mid', '$expectation', '3')");
        }
    }

    if ($insert) {
        if ($updateType == 'suspended') {
            $sql = "select email, mobile, username from register_view where matri_id='" . $mid . "'";
            $SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);
            if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                $email = $DatabaseCo->dbRow->email;
                $mobile_no = $DatabaseCo->dbRow->mobile;
                $name = $DatabaseCo->dbRow->username;
            }
            // Message For Admin
            $subject = "Profile Suspension approval request on samyakmatrimony : $mid";
            $message = "Name : " . $name . "<br/>"
                . "\r\n ------------------------------------" . "<br/>"
                . "\r\n Profile ID : " . $mid . "<br/>"
                . "\r\n Email ID : " . $email . "<br/>"
                . "\r\n Mobile : " . $mobile_no . "<br/>"
                . "\r\n IP Address : " . $_SERVER['REMOTE_ADDR'];
            $from = $configObj->getConfigFrom();
            $to = $configObj->getConfigTo();

            send_email_from_samyak($from, $to, $subject, $message);
            // End of Message for Admin
        }
        return print_r(json_encode(array('result' => 'success')));
    } else {
        return print_r(json_encode(array('result' => 'failed')));
    }
}