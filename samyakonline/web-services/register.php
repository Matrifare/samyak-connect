<?php

/**
 * Secure Registration Web Service
 * Uses prepared statements and Argon2ID password hashing
 */
require_once '../DatabaseConnection.php';
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';
include_once '../lib/RequestHandler.php';
include_once '../lib/Config.php';
include_once '../lib/Security.php';

$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
if (!empty($email)) {
    // Check if email already exists using prepared statement
    $stmt = $DatabaseCo->dbLink->prepare("SELECT email FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        return print_r(json_encode(array('result' => 'failed', 'flag' => 2, 'msg' => 'Email already exist')));
    }
    $stmt->close();
    
    // Sanitize phone number
    $phone = Security::sanitizePhone($_POST['mobile_no'] ?? '');
    $mobile = substr($phone, 0, 3);
    if ($mobile == '+91') {
        $phone = substr($phone, 3, 15);
    }
    
    // Check if user is blocked using prepared statement
    $stmt = $DatabaseCo->dbLink->prepare("SELECT id FROM blocked_registrations WHERE email = ? OR phone = ? OR phone = ?");
    $phoneWithPrefix = '+91' . $phone;
    $stmt->bind_param("sss", $email, $phone, $phoneWithPrefix);
    $stmt->execute();
    $blockedResult = $stmt->get_result();
    
    if ($blockedResult->num_rows > 0) {
        $stmt->close();
        return print_r(json_encode(array('result' => 'failed', 'flag' => 2, 'msg' => 'User Blocked for abnormal activity.')));
    }
    $stmt->close();
    
    // Sanitize all inputs
    $fullName = Security::escape(trim($_POST['full_name'] ?? ''));
    $extractNames = explode(" ", $fullName);

    $first_name = !empty($extractNames[0]) ? Security::escape($extractNames[0]) : "";
    $last_name = !empty($extractNames[1]) ? Security::escape($extractNames[1]) : "";
    
    if (empty($first_name)) {
        return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'First Name is required.')));
    }
    
    $mobile_no = Security::sanitizePhone($_POST['mobile_no'] ?? '');
    $phoneNo = Security::sanitizePhone($_POST['phone'] ?? '');
    
    if (empty($mobile_no)) {
        return print_r(json_encode(array('result' => 'failed', 'flag' => 0, 'msg' => 'Mobile No should not be empty')));
    }

    // Get prefix
    $sqlPrefix = "SELECT prefix FROM register ORDER BY index_id DESC LIMIT 1";
    $rowEx = $DatabaseCo->dbLink->query($sqlPrefix);
    $prefix = 'NX';
    while ($prefixResult = mysqli_fetch_array($rowEx)) {
        $prefix = $prefixResult['prefix'] ?? 'NX';
    }

    // Hash password with Argon2ID instead of MD5
    $password = trim($_POST['password'] ?? '');
    $passwordHash = password_hash($password, PASSWORD_ARGON2ID, [
        'memory_cost' => 65536,
        'time_cost' => 4,
        'threads' => 3
    ]);
    
    // Sanitize all form inputs
    $day = Security::sanitizeInt($_POST['day'] ?? '');
    $month = Security::sanitizeInt($_POST['month'] ?? '');
    $year = Security::sanitizeInt($_POST['year'] ?? '');
    $dateOfBirth = sprintf('%04d-%02d-%02d', $year, $month, $day);
    
    $height = Security::sanitizeInt($_POST['height'] ?? '');
    $weight = Security::sanitizeInt($_POST['weight'] ?? 0);
    $gender = Security::validateAllowed($_POST['gender'] ?? '', ['Groom', 'Bride'], 'Bride');
    $complexion = Security::escape($_POST['complexion'] ?? '');
    $profile_for = Security::escape($_POST['profile_for'] ?? '');
    $referred_by = Security::escape($_POST['referred_by'] ?? '');

    $religion_id = Security::sanitizeInt($_POST['religion'] ?? '');
    $my_caste = Security::sanitizeInt($_POST['caste'] ?? '');
    $mothertongue = Security::sanitizeInt($_POST['mother_tongue'] ?? '');
    $marital_status = Security::escape($_POST['marital_status'] ?? '');
    
    $status_children = "No";
    if ($marital_status != 'Unmarried') {
        $status_children = Security::escape($_POST['child'] ?? 'No');
    }
    
    $education_level = Security::sanitizeInt($_POST['education_level'] ?? '');
    $edu_field = Security::sanitizeInt($_POST['education_field'] ?? '');
    $edu_id = Security::sanitizeInt($_POST['qualification'] ?? '');
    $employed_in = Security::escape($_POST['employed_in'] ?? '');
    $occupation = Security::sanitizeInt($_POST['occupation'] ?? '');
    $monthly_salary = Security::escape($_POST['monthly_salary'] ?? '');
    $annual_income = Security::escape($_POST['annual_income'] ?? '');

    $father_occupation = Security::escape($_POST['father_status'] ?? '');
    $mother_occupation = Security::escape($_POST['mother_status'] ?? '');
    $no_of_brothers = Security::sanitizeInt($_POST['no_of_brothers'] ?? '');
    $no_of_sisters = Security::sanitizeInt($_POST['no_of_sisters'] ?? '');
    $living_status = Security::escape($_POST['living_status'] ?? '');
    $house_ownership = Security::escape($_POST['house_ownership'] ?? '');
    $body_type = Security::escape($_POST['body_type'] ?? '');
    $disability = Security::escape($_POST['disability'] ?? '');
    $bloodGroup = Security::escape($_POST['blood_group'] ?? '');
    $family_origin = Security::sanitizeInt($_POST['family_origin'] ?? '');
    $country_id = Security::sanitizeInt($_POST['country_id'] ?? '');
    $city = Security::sanitizeInt($_POST['city'] ?? '');
    $profileText = Security::escape($_POST['profile_description'] ?? '');

    date_default_timezone_set('Asia/Kolkata');
    $reg_date = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Use prepared statement for INSERT
    $stmt = $DatabaseCo->dbLink->prepare(
        "INSERT INTO `register`(
            `index_id`, `prefix`, `terms`, `email`, `password`, `password_hash`, `m_status`, `profileby`,
            `username`, `firstname`, `lastname`, `gender`, `birthdate`, `reference`,
            `status_children`, `education_level`, `education_field`, `edu_detail`, `monthly_sal`, `income`, `occupation`,
            `emp_in`, `religion`, `caste`, `m_tongue`, `height`, `weight`, `disability`, `b_group`,
            `complexion`, `bodytype`, `family_origin`,
            `languages_known`, `country_id`, `city`, `mobile`, `phone`, `contact_view_security`,
            `no_of_brothers`, `no_of_sisters`,
            `living_status`, `house_ownership`, `father_occupation`, `mother_occupation`, `profile_text`,
            `reg_date`, `ip`, `last_login`, `status`,
            `adminrole_id`, `adminrole_view_status`, `mobile_verify_status`, `agent`
        ) VALUES (
            NULL, ?, 'Yes', ?, '', ?, ?, ?,
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?, ?, '1',
            ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, '1999-12-31 23:23:23', 'Inactive',
            '1', 'Yes', 'No', ''
        )"
    );
    
    $username = $first_name . ' ' . $last_name;
    
    $stmt->bind_param(
        "ssssssssssssiiiissiiiiiissiiiisiiiissssss",
        $prefix, $email, $passwordHash, $marital_status, $profile_for,
        $username, $first_name, $last_name, $gender, $dateOfBirth, $referred_by,
        $status_children, $education_level, $edu_field, $edu_id, $monthly_salary, $annual_income, $occupation,
        $employed_in, $religion_id, $my_caste, $mothertongue, $height, $weight, $disability, $bloodGroup,
        $complexion, $body_type, $family_origin,
        $mothertongue, $country_id, $city, $mobile_no, $phoneNo,
        $no_of_brothers, $no_of_sisters,
        $living_status, $house_ownership, $father_occupation, $mother_occupation, $profileText,
        $reg_date, $ip_address
    );
    
    $stmt->execute();
    $stmt->close();

    $get_reg_id = mysqli_insert_id($DatabaseCo->dbLink);

    $matriRegisterId = $get_reg_id;
    if ($get_reg_id > 28013) {
        $prefix = 'AR';
        $matriRegisterId = $get_reg_id + 2001;
    } else {
        $prefix = 'NX';
        $matriRegisterId = $get_reg_id + 1000;
    }
    $matriRegisterId = substr($matriRegisterId, -4);

    $matriId = $prefix . $matriRegisterId;
    
    // Update matri_id using prepared statement
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE register SET matri_id = ? WHERE index_id = ?");
    $stmt->bind_param("si", $matriId, $get_reg_id);
    $stmt->execute();
    $stmt->close();

    if (!isset($_SESSION['gender123']) && empty($_SESSION['gender123'])) {
        // Get user data with prepared statement
        $stmt = $DatabaseCo->dbLink->prepare(
            "SELECT email, matri_id, mobile, username, m_status, birthdate, gender, index_id, status,
                    mobile_verify_status, email_verify_status, photo1, part_edu_level, adminrole_view_status 
             FROM register WHERE matri_id = ?"
        );
        $stmt->bind_param("s", $matriId);
        $stmt->execute();
        $SQL_STATEMENT = $stmt->get_result();
        
        if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {

            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION['user_name'] = $DatabaseCo->dbRow->email;
            $_SESSION['user_id'] = $DatabaseCo->dbRow->matri_id;
            $_SESSION['uname'] = $DatabaseCo->dbRow->username;
            $_SESSION['gender123'] = $DatabaseCo->dbRow->gender;
            $_SESSION['uid'] = $DatabaseCo->dbRow->index_id;
            $_SESSION['email'] = $DatabaseCo->dbRow->email;
            $_SESSION['mobile'] = $DatabaseCo->dbRow->mobile;
            $_SESSION['mem_status'] = $DatabaseCo->dbRow->status;
            $_SESSION['adminrole_view_status'] = $DatabaseCo->dbRow->adminrole_view_status;
            $_SESSION['marital_status'] = $DatabaseCo->dbRow->m_status;
            $_SESSION['birthdate'] = $DatabaseCo->dbRow->birthdate;
            $_SESSION['photo1'] = !empty($DatabaseCo->dbRow->photo1) ? $DatabaseCo->dbRow->photo1 : '';
            $email = $_SESSION['email'];
            $browser = $_SERVER['HTTP_USER_AGENT'] ?? '';
            $url = $_SERVER['HTTP_HOST'] ?? '';
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $tm = mktime(date('h'), date('i'), date('s'));
            $login_dt = date('Y-m-d h:i:s', $tm);
            
            // Insert login backup with prepared statement
            $stmt2 = $DatabaseCo->dbLink->prepare("INSERT INTO login_backup(matri_id, logged_in_at, ip_address) VALUES (?, ?, ?)");
            $stmt2->bind_param("sss", $matriId, $login_dt, $ip);
            $stmt2->execute();
            $stmt2->close();
            
            $date2 = date("d F ,Y", (strtotime($login_dt)));

            if ($DatabaseCo->dbRow->mobile_verify_status == 'No') {
                $_SESSION['last_login'] = 'first_time';
            }

            if ($DatabaseCo->dbRow->part_edu_level == '' || $DatabaseCo->dbRow->part_edu_level == NULL) {
                $_SESSION['partner_profile'] = 'fill_profile';
            }

            // Update last login with prepared statement
            $stmt2 = $DatabaseCo->dbLink->prepare("UPDATE register SET last_login = ? WHERE index_id = ?");
            $stmt2->bind_param("si", $login_dt, $DatabaseCo->dbRow->index_id);
            $stmt2->execute();
            $stmt2->close();

            // Insert login log with prepared statement
            $session_id = session_id();
            $stmt2 = $DatabaseCo->dbLink->prepare(
                "INSERT INTO `login_logs`(`matri_id`, `server_ip`, `client_ip`, `url`, `browser`, `user_session`) 
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt2->bind_param("ssssss", $_SESSION['user_id'], $ip, $ip, $url, $browser, $session_id);
            $stmt2->execute();
            $stmt2->close();

            // Approval Entry of Profile Details
            if (!empty($profileText)) {
                $stmt2 = $DatabaseCo->dbLink->prepare(
                    "INSERT INTO description_approvals(matri_id, profile_text, updated_data) VALUES (?, ?, '1')"
                );
                $stmt2->bind_param("ss", $matriId, $profileText);
                $stmt2->execute();
                $stmt2->close();
            }

            // Get registration details for email
            $stmt2 = $DatabaseCo->dbLink->prepare("SELECT * FROM register_view WHERE matri_id = ?");
            $stmt2->bind_param("s", $matriId);
            $stmt2->execute();
            $result3 = $stmt2->get_result();
            $rowcc = mysqli_fetch_array($result3);
            $stmt2->close();
            
            $rowcc['pass'] = $password;
            $subject = "Thank You for registering on Samyakmatrimony";
            $template = get_email_template($DatabaseCo, (object) $rowcc, '../email-templates/new_registration_email_template.php');
            send_email_from_samyak($configObj->getConfigFrom(), $rowcc['email'], $subject, $template);
            $subject = 'Your profile is under approval on Samyakmatrimony';
            $template = get_email_template($DatabaseCo, $rowcc, '../email-templates/email_verification_email_template.php');
            send_email_from_samyak($configObj->getConfigFrom(), $rowcc['email'], $subject, $template);
            $name = $rowcc['firstname'] . " " . $rowcc['lastname'];
            $_SESSION['user_id'] = $rowcc['matri_id'];
            $mno = $rowcc['mobile'];
            
            // Admin notification
            $subject = "Registration on samyakmatrimony : $matriId";
            $message = "Name : " . $name . "<br/>"
                . "\r\n ------------------------------------" . "<br/>"
                . "\r\n Profile ID : " . $matriId . "<br/>"
                . "\r\n Email ID : " . $email . "<br/>"
                . "\r\n Mobile : " . $mobile_no . "<br/>"
                . "\r\n Alternate Mobile No : " . $phoneNo . "<br/>"
                . "\r\n Referred By : " . $referred_by . "<br/>"
                . "\r\n IP Address : " . $ip;
            send_email_from_samyak($configObj->getConfigFrom(), $configObj->getConfigTo(), $subject, $message);
            
            // SMS sending
            $sql = "SELECT * FROM sms_api WHERE status='APPROVED'";
            $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
            $num_sms = mysqli_num_rows($rr);
            $sms = mysqli_fetch_object($rr);

            if ($num_sms > 0) {
                $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete WHERE temp_name = 'FrontEnd_Registration'");
                $rowcs5 = mysqli_fetch_array($result45);
                $message = $rowcs5['temp_value'];
                $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                $sms_template = str_replace(array('*profileId*', '*password*'), array($matriId, $_POST['password']), $sms_template);
                
                $mno = $mobile_no;
                $mobile = substr($mno, 0, 3);
                if ($mobile == '+91') {
                    $mno = substr($mno, 3, 15);
                }
                send_to_curl($mno, $sms_template);
            }

            $_SESSION['order_id'] = $get_reg_id;
        }
        $stmt->close();
    }
    return print_r(json_encode(array('result' => 'success', 'flag' => 1, 'msg' => 'Registration Successful')));
}
