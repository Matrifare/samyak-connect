<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 29/12/2021
 * Time: 08:38 PM
 */
require_once 'DatabaseConnection.php';

if (isset($_SESSION['user_name'])) {
    header('location: homepage');
}

include_once './lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once './lib/Config.php';
$configObj = new Config();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Find Your Perfect Match: Trusted Buddhist Matrimonial Services</title>
    <meta name="keyword" content="Buddhist Matrimonial, Buddhist Marriage, Buddhist Matchmaking, Buddhist Bride, Buddhist Groom, Buddhist Matrimony Site, Buddhist Wedding, Find Buddhist Partner, Buddhist Marriage Bureau, Online Buddhist Matrimony."/>
    <meta name="description" content="Looking for a compatible Buddhist life partner? Join our trusted Buddhist matrimonial platform to connect with genuine brides and grooms. Safe, secure, and reliable matchmaking. Register today!"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
    <meta name="author" content="Manish Gupta <contact@manishdesigner.com>">

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="new-design/css/bootstrap.min.css" rel="stylesheet">
    <link href="new-design/css/style.css" rel="stylesheet">
    <link href="new-design/css/vendors.css" rel="stylesheet">

    <!-- CUSTOM CSS -->
    <link href="new-design/css/custom.css" rel="stylesheet">
</head>
<body>


<?php
require_once 'layouts/new-header.php';
?>

<main>
    <section id="hero" class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
                    <div id="login">
                        <form id="register_form" name="register_form" method="post">
                            <!--<div class="text-center"><img src="img/logo_sticky.png" alt="Image" width="160" height="34">
                            </div>-->

                            <h4 class="font-weight-bold text-center">Create your Profile for Free</h4>
                            <hr/>
                            <h4 class="content-title">Account Details</h4>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="full_name">Name & Surname Only*</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control"
                                           placeholder="Please Enter name with surname only" title="Please name with surname" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="mobile_no">Mobile No*</label>
                                    <input id="mobile_no" type="text" name="mobile_no" minlength="10" maxlength="10"
                                           required
                                           pattern="[0-9]{10}" class="form-control"
                                           title="Please enter valid 10 digit Mobile no."
                                           placeholder="Your Mobile No">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">Email*</label>
                                    <input id="email" type="email" name="email" class="form-control"
                                           required placeholder="Your Email">
                                </div>
                                <div class="form-group col-6">
                                    <label for="password">Password*</label>
                                    <input id="password" type="password" name="password" class="form-control"
                                           required placeholder="Your Password">
                                </div>
                            </div>
                            <hr/>
                            <h4 class="content-title mt-3">Profile Details</h4>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="">Gender*</label><br/>
                                    <label class="container_radio container_radio_inline">
                                        Male
                                        <input type="radio" name="gender" value="Groom">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container_radio container_radio_inline">
                                        Female
                                        <input type="radio" name="gender" value="Bride" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="birth_date">Birth Date*</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <select id="day" name="day" class="form-control" title="Please select" required>
                                                <option value="" selected disabled>Day</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select title="Please select" id="month" name="month" class="form-control" required>
                                                <option value="" selected disabled>Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select title="Please select" id="year" name="year" class="form-control" required>
                                                <option value="" selected disabled>Year</option>
                                                <?php for ($x = 2003; $x >= 1960; $x--) { ?>
                                                    <option value="<?php echo $x; ?>"
                                                        <?php if ($x == 1990) {
                                                            echo "selected";
                                                        } ?> ><?= $x; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="height">Height*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="height" name="height" class="form-control" required>
                                            <option value="" selected disabled>Select Height</option>
                                            <option value="48">4ft</option>
                                            <option value="49">4ft 01in</option>
                                            <option value="50">4ft 02in</option>
                                            <option value="51">4ft 03in</option>
                                            <option value="52">4ft 04in</option>
                                            <option value="53">4ft 05in</option>
                                            <option value="54">4ft 06in</option>
                                            <option value="55">4ft 07in</option>
                                            <option value="56">4ft 08in</option>
                                            <option value="57">4ft 09in</option>
                                            <option value="58">4ft 10in</option>
                                            <option value="59">4ft 11in</option>
                                            <option value="60">5ft</option>
                                            <option value="61">5ft 01in</option>
                                            <option value="62">5ft 02in</option>
                                            <option value="63">5ft 03in</option>
                                            <option value="64">5ft 04in</option>
                                            <option value="65">5ft 05in</option>
                                            <option value="66">5ft 06in</option>
                                            <option value="67">5ft 07in</option>
                                            <option value="68">5ft 08in</option>
                                            <option value="69">5ft 09in</option>
                                            <option value="70">5ft 10in</option>
                                            <option value="71">5ft 11in</option>
                                            <option value="72">6ft</option>
                                            <option value="73">6ft 01in</option>
                                            <option value="74">6ft 02in</option>
                                            <option value="75">6ft 03in</option>
                                            <option value="76">6ft 04in</option>
                                            <option value="77">6ft 05in</option>
                                            <option value="78">6ft 06in</option>
                                            <option value="79">6ft 07in</option>
                                            <option value="80">6ft 08in</option>
                                            <option value="81">6ft 09in</option>
                                            <option value="82">6ft 10in</option>
                                            <option value="83">6ft 11in</option>
                                            <option value="84">7ft</option>
                                            <option value="85">Above 7ft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="complexion">Complexion*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="complexion" name="complexion" class="form-control" required>
                                            <option value="" selected disabled>Select Complexion</option>
                                            <option value="Wheatish Brown">Wheatish Brown</option>
                                            <option value="Wheatish">Wheatish</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Very Fair">Very Fair</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="religion">Religion*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select  title="Please select" id="religion" name="religion" class="form-control" required
                                                onchange="GetCaste(this);">
                                            <option value="" selected disabled>Select Religion</option>
                                            <?php
                                            $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>" <?php if (isset($religion_id) && $DatabaseCo->dbRow->religion_id == $religion_id) {
                                                    echo "selected";
                                                } else if (isset($_REQUEST['religion_id']) && $_REQUEST['religion_id'] == $DatabaseCo->dbRow->religion_id) {
                                                    echo "selected";
                                                } else if (!isset($_REQUEST['religion_id']) && $DatabaseCo->dbRow->religion_id == 7) {
                                                    echo "selected";
                                                } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="caste">Caste*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select  title="Please select" id="caste" name="caste" class="form-control" id="caste" required>
                                            <option value="" selected disabled>Caste</option>
                                            <option value="227" selected>SC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="mother_tongue">Mother tongue*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="mother_tongue" name="mother_tongue" class="form-control" required>
                                            <option value="" selected disabled>Select Mother tongue</option>
                                            <?php
                                            $SQL_STATEMENT_Mtongu = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_Mtongu)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?php if (isset($_REQUEST['mothertongue']) && $_REQUEST['mothertongue'] == $DatabaseCo->dbRow->mtongue_id) {
                                                    echo "selected";
                                                } else if ($DatabaseCo->dbRow->mtongue_id == 7) {
                                                    echo "selected";
                                                } ?>><?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="marital_status">Marital Status*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="marital_status" name="marital_status" class="form-control"
                                                required>
                                            <option value="" selected disabled>Marital Status</option>
                                            <option value="Unmarried" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Unmarried') {
                                                echo "selected";
                                            } else if (!isset($_REQUEST['marital_status'])) {
                                                echo "selected";
                                            } ?>>Unmarried
                                            </option>
                                            <option value="Widow/Widower" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Widow/Widower') {
                                                echo "selected";
                                            } ?>>Widow/Widower
                                            </option>
                                            <option value="Divorcee" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Divorcee') {
                                                echo "selected";
                                            } ?>>Divorcee
                                            </option>
                                            <option value="Separated" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Separated') {
                                                echo "selected";
                                            } ?>>Separated
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="divorcee_section" style="display: none;">
                                <div class="form-group">
                                    <label for="child">Have any Child?*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" name="child" id="child" class="form-control">
                                            <option value="No">No</option>
                                            <option value="Yes. Living together">Yes. Living together</option>
                                            <option value="Yes. Not living together">Yes. Not living together
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="body_type">Body Type*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="body_type" name="body_type" class="form-control" required>
                                            <option value="" selected disabled>Body Type</option>
                                            <option value="Slim">Slim</option>
                                            <option value="Average">Average</option>
                                            <option value="Athletic">Athletic</option>
                                            <option value="Heavy">Heavy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="weight">Weight</label>
                                    <div class="s-input nice-select-wraper">
                                        <select name="weight" class="form-control">
                                            <option value="" selected disabled>Select
                                                Weight
                                            </option>
                                            <?php for ($x = 40; $x <= 140; $x++) { ?>
                                                <option value="<?= $x ?>"><?= $x; ?> Kg</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="blood_group">Blood Group*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="blood_group" name="blood_group" class="form-control" required>
                                            <option value="" disabled selected>Select Blood Group</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="disability">Disability*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="disability" name="disability" class="form-control" required>
                                            <option value="" selected disabled>Any Disability</option>
                                            <option value="None">None</option>
                                            <option value="HIV Positive">HIV Positive</option>
                                            <option value="Mentally Challenged">Mentally Challenged</option>
                                            <option value="Physically Challenged">Physically Challenged</option>
                                            <option value="Physically and Mentally Challenged">Physically and Mentally
                                                Challenged
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <h4 class="content-title mt-3">Education and Profession Details</h4>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="education_level">Education Level*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="education_level" name="education_level" class="form-control"
                                                required>
                                            <option value="" selected disabled>Select Education Level</option>
                                            <?php
                                            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_level_id, e_level_name FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>">
                                                    <?= $DatabaseCo->dbRow->e_level_name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="education_field">Education Field*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="education_field" name="education_field" class="form-control"
                                                required>
                                            <option value="" selected disabled>Select Education Field</option>
                                            <?php
                                            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_field_id, e_field_name FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                ?>
                                                <option value="<?= $DatabaseCo->dbRow->e_field_id ?>">
                                                    <?= $DatabaseCo->dbRow->e_field_name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="qualification">Qualification*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="qualification" name="qualification" class="form-control" required>
                                            <option value="" selected disabled>Select Qualification</option>
                                            <?php
                                            $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT edu_id, edu_name FROM education_detail WHERE status='APPROVED' ORDER BY edu_name ASC");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                                                ?>
                                                <option value="<?= $DatabaseCo->dbRow->edu_id; ?>">
                                                    <?= $DatabaseCo->dbRow->edu_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="employed_in">Employed in*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="employed_in" name="employed_in" class="form-control" required>
                                            <option value="" selected disabled>Select Employed In</option>
                                            <option value="Private" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Private') {
                                                echo "selected";
                                            } ?>>Private
                                            </option>
                                            <option value="Government" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Government') {
                                                echo "selected";
                                            } ?>>Government
                                            </option>
                                            <option value="Business" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Business') {
                                                echo "selected";
                                            } ?>>Business
                                            </option>
                                            <option value="Defence" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Defence') {
                                                echo "selected";
                                            } ?>>Defence
                                            </option>
                                            <option value="Not Employed in" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Not Employed in') {
                                                echo "selected";
                                            } ?>>Not Employed in
                                            </option>
                                            <option value="Others" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Others') {
                                                echo "selected";
                                            } ?>>Others
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="occupation">Occupation*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="occupation" name="occupation" class="form-control" required>
                                            <option value="" selected disabled> Select Occupation</option>
                                            <?php
                                            $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>" <?php if (isset($occupation) && $DatabaseCo->dbRow->ocp_id == $occupation) {
                                                    echo "selected";
                                                } else if (isset($_REQUEST['occupation']) && $_REQUEST['occupation'] == $DatabaseCo->dbRow->ocp_id) {
                                                    echo "selected";
                                                } ?>><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="annual_income">Annual Income</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" name="annual_income" class="form-control">
                                            <option value="" selected disabled>Select Annual Income</option>
                                            <?php
                                            $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) {
                                                ?>
                                                <option value="<?= $DatabaseCo->dbRow->title; ?>"><?= $DatabaseCo->dbRow->title ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <h4 class="content-title mt-3">Family Details</h4>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="father_occupation">Father Status*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="father_occupation" name="father_status" class="form-control"
                                                required>
                                            <option value="" selected disabled>Select Father Status</option>
                                            <option value="Retired">Retired</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Business">Business</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Not Employed">Not Employed</option>
                                            <option value="No More">No More</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="mother_occupation">Mother Status*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="mother_occupation" name="mother_status" class="form-control"
                                                required>
                                            <option value="" selected disabled>Select Mother Status</option>
                                            <option value="Housewife">Housewife</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Business">Business</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Not Employed">Not Employed</option>
                                            <option value="No More">No More</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="no_of_brothers">No. of Brothers*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="no_of_brothers" name="no_of_brothers" class="form-control" required>
                                            <option value="" selected disabled>No of Brothers</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="4 +">4 +</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="no_of_sisters">No of Sisters*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="no_of_sisters" name="no_of_sisters" class="form-control" required>
                                            <option value="" selected disabled>No of Sisters</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="4 +">4 +</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="family_origin">Family Origin*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="family_origin" name="family_origin" class="form-control" required>
                                            <option selected value="" disabled>Select Native Place
                                            </option>
                                            <?php
                                            $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="phone">Family Phone No</label>
                                    <input type="text" name="phone" class="form-control" minlength="10"
                                           maxlength="10" pattern="[0-9]{10}" placeholder="Family Phone No">
                                </div>
                            </div>
                            <hr/>
                            <h4 class="content-title mt-3">Residence Details</h4>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="country_id">Country*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="country_id" name="country_id" class="form-control" required>
                                            <option value="" selected disabled>Select Your Country</option>
                                            <?php
                                            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT country_id,country_name FROM country WHERE status='APPROVED' order by country_name ASC");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>"
                                                    <?php if (isset($_REQUEST['country_id']) && $_REQUEST['country_id'] == $DatabaseCo->dbRow->country_id) {
                                                        echo "selected";
                                                    } else if ($DatabaseCo->dbRow->country_id == 95) {
                                                        echo "selected";
                                                    } ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="city">City*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="city" name="city" class="form-control" required>
                                            <option selected value="" disabled>Select Residence City</option>
                                            <?php
                                            $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="living_status">Living Status*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="living_status" name="living_status" class="form-control" required>
                                            <option value="" selected disabled>Living Status</option>
                                            <option value="With Parents">With Parents</option>
                                            <option value="As Room Mate">As Room Mate</option>
                                            <option value="Myself">Myself</option>
                                            <option value="Paying Guest">Paying Guest</option>
                                            <option value="In Hostel">In Hostel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="house_ownership">House Status*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="house_ownership" name="house_ownership" class="form-control"
                                                required>
                                            <option value="" selected disabled>House Ownership</option>
                                            <option value="Own Flat">Own Flat/Bungalow</option>
                                            <option value="Parent Flat">Parent Flat/Bungalow</option>
                                            <option value="Renting in Flat">Renting in Flat/Bungalow</option>
                                            <option value="Stay With Relative">Stay With Relative</option>
                                            <option value="Don't have House">Don't have House</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <h4 class="content-title mt-3">Profile Description</h4>
                            <div class="row">
                                <div class="form-group col-12">
                                    <textarea id="profile_text" class="form-control" rows="5"
                                              name="profile_description"
                                              placeholder="Write about your personality, family background and what you are looking for in your partner."></textarea>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="profile_for">Profile posted by*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="profile_for" name="profile_for" class="form-control" required>
                                            <option value="" selected disabled>Posted By</option>
                                            <option value="Parents">Parents</option>
                                            <option value="Self">Self</option>
                                            <option value="Friend">Friend</option>
                                            <option value="Sibling">Sibling</option>
                                            <option value="Relatives">Relatives</option>
                                            <option value="Marriage Bureau">Marriage Bureau</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="referred_by">Referred By*</label>
                                    <div class="s-input nice-select-wraper">
                                        <select title="Please select" id="referred_by" name="referred_by" class="form-control" required>
                                            <option value="" selected disabled>Referred by</option>
                                            <option value="Google">Google</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Samrat Paper">Samrat Paper</option>
                                            <option value="Lokmat Newspaper">Lokmat Newspaper</option>
                                            <option value="Other Newspaper">Other Newspaper</option>
                                            <option value="Relative">Relative</option>
                                            <option value="Friend">Friend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="text-center" style="font-size: 11px;">
                                        By signing up, you agree to our <a href="terms"> Terms</a>.
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" id="submitBtn" class="btn btn-info btn-danger">Create an account</button>
                                </div>
                                <div class="col-12 mt-10">
                                    <div class="text-center">
                                        If you need any help whatsapp us - <a href="https://api.whatsapp.com/send?phone=917977993616&text=Hello,%0A%0AI am facing issues in registering myself, please help." title="Help in Register"><i class="fa fa-whatsapp"></i> Click Here</a>
                                    </div>
                                    <div class="text-center">
                                        Already have account?
                                        <a href="login" id="register_login_btn" type="button" class="btn btn-link" style="font-weight: bold;">Login</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End main -->

<?php
require_once 'layouts/new-footer.php';
?>

<!-- Common scripts -->
<script src="new-design/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script src="new-design/js/common_scripts_min.js"></script>
<script src="new-design/js/functions.js"></script>

<!-- Specific scripts -->
<script src="new-design/js/pw_strenght.js"></script>

<script type="text/javascript">
    function GetCaste(context) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'web-services/caste_search',
            data: {'religionId': $(context).val()},
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#caste").html(data);
                // Nice Select
                // $('#caste').niceSelect('update');
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

    $(function () {
        $("#marital_status").change(function () {
            if ($("#marital_status").val() != 'Unmarried') {
                $("#divorcee_section").slideDown(300);
                $("#child").attr("required", "true");
            } else {
                $("#divorcee_section").slideUp(300);
                $("#child").removeAttr("required");
            }
        });

        $("#submitBtn").click(function (e) {
            e.preventDefault();
            if ($("#register_form").valid()) {
                submitRegistrationForm();
            } else {
                return false;
            }
        });
    });

    function submitRegistrationForm() {
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "web-services/register", //Where to make Ajax calls
            cache: false,
            dataType: 'json',
            data: $("#register_form").serialize(),
            success: function (response) {
                if (response.flag == 1) {
                    window.location.href = 'homepage';
                    return false;
                } else if (response.flag == 2) {
                    alert(response.msg);
                    return false;
                }
                if (response.result == 'failed') {
                    alert(response.msg);
                }
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }
</script>
</body>
</html>