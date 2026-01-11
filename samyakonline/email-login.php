<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 02/25/2021
 * Time: 08:05 PM
 */
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
define('SAMYAK_LOGIN_ACTION', 'login-in-samyak');

//Get the required parameters
$authenticatorId = $_GET['authenticator-id'];
$authenticatorToken = $_GET['authenticator-token'];
$authenticatorAction = $_GET['authenticator-action'];

$profile = hexdec($authenticatorId) / 726925;
$sqlApprove = "select matri_id from register_view WHERE index_id=" . $profile;
$fetch = mysqli_fetch_array($DatabaseCo->getSelectQueryResult($sqlApprove));
$matriId = $fetch['matri_id'] ?? "";
if (!empty($matriId)) {
    $select = $DatabaseCo->dbLink->query("select email,matri_id,mobile,phone,r.username,m_status,birthdate,r.gender,
                                                    r.index_id,status,mobile_verify_status,photo1,part_frm_age,msg_id,
                                                    adminrole_view_status,reg_date
                                                    from register_view r 
                                                    INNER JOIN payment_view p ON r.matri_id=p.pmatri_id
                                                    LEFT JOIN delete_request ON r.matri_id = delete_request.msg_from
                                                 where r.matri_id ='" . $matriId . "'");

    $DatabaseCo->dbRow = mysqli_fetch_object($select);

    //Get the required data to make hash
    $indexId = $DatabaseCo->dbRow->index_id;
    $matriId = $DatabaseCo->dbRow->matri_id;
    $regDate = $DatabaseCo->dbRow->reg_date;
    $generatedAuthenticatorToken = hash("sha512", $indexId . $matriId . $regDate);
    $generatedAuthenticatorAction = hash("sha512", SAMYAK_LOGIN_ACTION);

    //Check Token and Action for Authorization
    if ($authenticatorToken === $generatedAuthenticatorToken &&
        $authenticatorAction === $generatedAuthenticatorAction) {
        //Change Session ID after Login
        session_regenerate_id(true);
        @require_once 'login_services.php';
        exit;
    } else {
        echo "<h1 style='text-align: center; color: red;'>401 : Unauthorized Access Token.</h1>";
        exit;
    }
} else {
    echo "<h1 style='text-align: center; color: red;'>401 : Unauthorized URL.</h1>";
    exit;
}