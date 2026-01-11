<?php

/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 28-03-2019
 * Time: 10:40 PM
 */
include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
$sql = $DatabaseCo->dbLink->query("select * from register where matri_id='" . $_SESSION["user_id"] . "'");
$get_basic_data = mysqli_fetch_array($sql);

?>
<div class="col-xs-12">

    <div class="tab-style-01-wrapper">

        <ul id="detailTab" class="tab-nav clearfix">
            <li class="active"><a href="#tab_1-01" data-toggle="tab">Profile <span class="hidden-xs hidden-xss"> Details</span></a>
            </li>
            <li><a href="#tab_1-02" data-toggle="tab">Family Details</a>
            </li>
            <li><a href="#tab_1-03" data-toggle="tab">Partner Expectations</a>
            </li>
            <li><a href="update-descriptions">Update Descriptions</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="tab_1-01" style="padding: 10px;">
                <form method="post" id="profile_update_form" action="#">
                    <!--<div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Describe yourself
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 mb-5">
                            <div class="form-group">
                                <label for="profile_text"><span class="text-danger">*</span>Describe about yourself</label>
                                <textarea name="profile_text" class="form-control mb-5"
                                          id="profile_text"><?/*= $get_basic_data['profile_text'] */ ?></textarea>
                                <p class="mb-5">*Note: Please don't write any type of contact details.*</p>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input id="first_name" name="first_name" class="form-control mb-5"
                                    type="text" value="<?= $get_basic_data['firstname'] ?>" required
                                    placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" class="form-control mb-5"
                                    type="text" value="<?= $get_basic_data['lastname'] ?>" required
                                    placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2 col-xss-4 mb-5">
                            <div class="form-group">
                                <label for="day">Birth Date</label>
                                <select id="day" name="day" class="form-control mb-5" required
                                    onchange="setDays(month,this,year)">
                                    <option value="" disabled selected>
                                        Day
                                    </option>
                                    <?php
                                    $birthDate = $get_basic_data['birthdate'];
                                    $dateOfBirth = explode("-", $birthDate);
                                    for ($i = 01; $i <= 31; $i++) {
                                        $isSelected = $dateOfBirth[2] == $i ? "selected" : ""; ?>
                                        <option value='<?= $i ?>' <?= $isSelected ?>><?= $i ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2 col-xss-4 pl-0 mb-5">
                            <div class="form-group">
                                <label for="month">Birth Month</label>
                                <select id="month" name="month" class="form-control mb-5" required
                                    onchange="setDays(this,day,year)">
                                    <option value="" selected disabled>
                                        Month
                                    </option>
                                    <option value="01" <?= ($dateOfBirth[1] == '01') ? "selected" : "" ?>>
                                        Jan
                                    </option>
                                    <option value="02" <?= ($dateOfBirth[1] == '02') ? "selected" : "" ?>>
                                        Feb
                                    </option>
                                    <option value="03" <?= ($dateOfBirth[1] == '03') ? "selected" : "" ?>>
                                        Mar
                                    </option>
                                    <option value="04" <?= ($dateOfBirth[1] == '04') ? "selected" : "" ?>>
                                        Apr
                                    </option>
                                    <option value="05" <?= ($dateOfBirth[1] == '05') ? "selected" : "" ?>>
                                        May
                                    </option>
                                    <option value="06" <?= ($dateOfBirth[1] == '06') ? "selected" : "" ?>>
                                        Jun
                                    </option>
                                    <option value="07" <?= ($dateOfBirth[1] == '07') ? "selected" : "" ?>>
                                        Jul
                                    </option>
                                    <option value="08" <?= ($dateOfBirth[1] == '08') ? "selected" : "" ?>>
                                        Aug
                                    </option>
                                    <option value="09" <?= ($dateOfBirth[1] == '09') ? "selected" : "" ?>>
                                        Sep
                                    </option>
                                    <option value="10" <?= ($dateOfBirth[1] == '10') ? "selected" : "" ?>>
                                        Oct
                                    </option>
                                    <option value="11" <?= ($dateOfBirth[1] == '11') ? "selected" : "" ?>>
                                        Nov
                                    </option>
                                    <option value="12" <?= ($dateOfBirth[1] == '12') ? "selected" : "" ?>>
                                        Dec
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2 col-xss-4 pl-0 mb-5">
                            <div class="form-group pl-0">
                                <label>Birth Year</label>
                                <select id="year" name="year" class="form-control mb-5" required
                                    onchange="setDays(month,day,this)">
                                    <option value="" selected disabled>Year</option>
                                    <option value="" selected disabled>
                                        Year
                                    </option>
                                    <?php
                                    for ($x = 1997; $x >= 1960; $x--) {
                                    ?>
                                        <option value="<?php echo $x; ?>" <?= ($dateOfBirth[0] == $x) ? "selected" : "" ?>><?php echo $x; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5" id="edit_marital_status">
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select class="form-control mb-5" name="marital_status" id="marital_status" disabled>
                                    <option value="" selected disabled>Marital
                                        Status
                                    </option>
                                    <option value="Unmarried" <?= ($get_basic_data['m_status'] == 'Unmarried') ? "selected" : "" ?>>
                                        Unmarried
                                    </option>
                                    <option value="Widow/Widower" <?= ($get_basic_data['m_status'] == 'Widow/Widower') ? "selected" : "" ?>>
                                        Widow/Widower
                                    </option>
                                    <option value="Divorcee" <?= ($get_basic_data['m_status'] == 'Divorcee') ? "selected" : "" ?>>
                                        Divorcee
                                    </option>
                                    <option value="Separated" <?= ($get_basic_data['m_status'] == 'Separated') ? "selected" : "" ?>>
                                        Separated
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5" id="edit_children_status"
                            style="display: <?= ($get_basic_data['m_status'] != 'Unmarried') ? "block" : "none" ?>;">
                            <div class="form-group">
                                <label for="children_status">Children?<span class="text-danger">*</span> </label>
                                <select class="form-control mb-5"
                                    name="children_status"
                                    id="children_status">
                                    <option value="" selected disabled>Have any
                                        Children ?
                                    </option>
                                    <option value="No" <?= ($get_basic_data['status_children'] == 'No') ? "selected" : "" ?>>
                                        No
                                    </option>
                                    <option value="Yes. Living together" <?= ($get_basic_data['status_children'] == 'Yes. Living together') ? "selected" : "" ?>>
                                        Yes. Living together
                                    </option>
                                    <option value="Yes. Not living together" <?= ($get_basic_data['status_children'] == 'Yes. Not living together') ? "selected" : "" ?>>
                                        Yes. Not living together
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group mb-0">
                                <label for="height">Height</label>
                                <select id="height" class="form-control mb-5" name="height" required>
                                    <option value="" selected disabled>Select
                                        Height
                                    </option>
                                    <option value="48" <?= ($get_basic_data['height'] == 48) ? "selected" : "" ?>>
                                        4ft
                                    </option>
                                    <option value="49" <?= ($get_basic_data['height'] == 49) ? "selected" : "" ?>>
                                        4ft 01in
                                    </option>
                                    <option value="50" <?= ($get_basic_data['height'] == 50) ? "selected" : "" ?>>
                                        4ft 02in
                                    </option>
                                    <option value="51" <?= ($get_basic_data['height'] == 51) ? "selected" : "" ?>>
                                        4ft 03in
                                    </option>
                                    <option value="52" <?= ($get_basic_data['height'] == 52) ? "selected" : "" ?>>
                                        4ft 04in
                                    </option>
                                    <option value="53" <?= ($get_basic_data['height'] == 53) ? "selected" : "" ?>>
                                        4ft 05in
                                    </option>
                                    <option value="54" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
                                        4ft 06in
                                    </option>
                                    <option value="55" <?= ($get_basic_data['height'] == 55) ? "selected" : "" ?>>
                                        4ft 07in
                                    </option>
                                    <option value="56" <?= ($get_basic_data['height'] == 56) ? "selected" : "" ?>>
                                        4ft 08in
                                    </option>
                                    <option value="57" <?= ($get_basic_data['height'] == 57) ? "selected" : "" ?>>
                                        4ft 09in
                                    </option>
                                    <option value="58" <?= ($get_basic_data['height'] == 58) ? "selected" : "" ?>>
                                        4ft 10in
                                    </option>
                                    <option value="59" <?= ($get_basic_data['height'] == 59) ? "selected" : "" ?>>
                                        4ft 11in
                                    </option>
                                    <option value="60" <?= ($get_basic_data['height'] == 60) ? "selected" : "" ?>>
                                        5ft
                                    </option>
                                    <option value="61" <?= ($get_basic_data['height'] == 61) ? "selected" : "" ?>>
                                        5ft 01in
                                    </option>
                                    <option value="62" <?= ($get_basic_data['height'] == 62) ? "selected" : "" ?>>
                                        5ft 02in
                                    </option>
                                    <option value="63" <?= ($get_basic_data['height'] == 63) ? "selected" : "" ?>>
                                        5ft 03in
                                    </option>
                                    <option value="64" <?= ($get_basic_data['height'] == 64) ? "selected" : "" ?>>
                                        5ft 04in
                                    </option>
                                    <option value="65" <?= ($get_basic_data['height'] == 65) ? "selected" : "" ?>>
                                        5ft 05in
                                    </option>
                                    <option value="66" <?= ($get_basic_data['height'] == 66) ? "selected" : "" ?>>
                                        5ft 06in
                                    </option>
                                    <option value="67" <?= ($get_basic_data['height'] == 67) ? "selected" : "" ?>>
                                        5ft 07in
                                    </option>
                                    <option value="68" <?= ($get_basic_data['height'] == 68) ? "selected" : "" ?>>
                                        5ft 08in
                                    </option>
                                    <option value="69" <?= ($get_basic_data['height'] == 69) ? "selected" : "" ?>>
                                        5ft 09in
                                    </option>
                                    <option value="70" <?= ($get_basic_data['height'] == 70) ? "selected" : "" ?>>
                                        5ft 10in
                                    </option>
                                    <option value="71" <?= ($get_basic_data['height'] == 71) ? "selected" : "" ?>>
                                        5ft 11in
                                    </option>
                                    <option value="72" <?= ($get_basic_data['height'] == 72) ? "selected" : "" ?>>
                                        6ft
                                    </option>
                                    <option value="73" <?= ($get_basic_data['height'] == 73) ? "selected" : "" ?>>
                                        6ft 01in
                                    </option>
                                    <option value="74" <?= ($get_basic_data['height'] == 74) ? "selected" : "" ?>>
                                        6ft 02in
                                    </option>
                                    <option value="75" <?= ($get_basic_data['height'] == 75) ? "selected" : "" ?>>
                                        6ft 03in
                                    </option>
                                    <option value="76" <?= ($get_basic_data['height'] == 76) ? "selected" : "" ?>>
                                        6ft 04in
                                    </option>
                                    <option value="77" <?= ($get_basic_data['height'] == 77) ? "selected" : "" ?>>
                                        6ft 05in
                                    </option>
                                    <option value="78" <?= ($get_basic_data['height'] == 78) ? "selected" : "" ?>>
                                        6ft 06in
                                    </option>
                                    <option value="79" <?= ($get_basic_data['height'] == 79) ? "selected" : "" ?>>
                                        6ft 07in
                                    </option>
                                    <option value="80" <?= ($get_basic_data['height'] == 80) ? "selected" : "" ?>>
                                        6ft 08in
                                    </option>
                                    <option value="81" <?= ($get_basic_data['height'] == 81) ? "selected" : "" ?>>
                                        6ft 09in
                                    </option>
                                    <option value="82" <?= ($get_basic_data['height'] == 82) ? "selected" : "" ?>>
                                        6ft 10in
                                    </option>
                                    <option value="83" <?= ($get_basic_data['height'] == 83) ? "selected" : "" ?>>
                                        6ft 11in
                                    </option>
                                    <option value="84" <?= ($get_basic_data['height'] == 84) ? "selected" : "" ?>>
                                        7ft
                                    </option>
                                    <option value="85" <?= ($get_basic_data['height'] == 85) ? "selected" : "" ?>>
                                        Above 7ft
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <select id="weight" class="form-control mb-5" name="weight" required>
                                    <option value="" selected disabled>Select
                                        Weight
                                    </option>
                                    <?php
                                    for ($x = 40; $x <= 140; $x++) {
                                    ?>
                                        <option value="<?php echo $x; ?>" <?= ($get_basic_data['weight'] == $x) ? "selected" : "" ?>><?php echo $x; ?>
                                            Kg
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="mothertongue">Mothertongue</label>
                                <select id="mothertongue"
                                    name="mothertongue"
                                    class="form-control mb-5" required>
                                    <option value="" selected disabled>Select
                                        Mothertongue
                                    </option>
                                    <?php
                                    $SQL_STATEMENT_Mtongu = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_Mtongu)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?= ($DatabaseCo->dbRow->mtongue_id == $get_basic_data['m_tongue']) ? "selected" : (($DatabaseCo->dbRow->mtongue_id == 7) ? "selected" : "") ?>>
                                            <?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="disability">Physically Challenged</label>
                                <select id="disability" class="form-control mb-5" name="disability">
                                    <option value="None" <?php if ($get_basic_data['disability'] == 'None') {
                                                                echo "selected";
                                                            } ?>>None
                                    </option>
                                    <option value="HIV Positive" <?php if ($get_basic_data['disability'] == 'HIV Positive') {
                                                                        echo "selected";
                                                                    } ?>>HIV Positive
                                    </option>
                                    <option value="Mentally Challenged" <?php if ($get_basic_data['disability'] == 'Mentally Challenged') {
                                                                            echo "selected";
                                                                        } ?>>Mentally Challenged
                                    </option>
                                    <option value="Physically Challenged" <?php if ($get_basic_data['disability'] == 'Physically Challenged') {
                                                                                echo "selected";
                                                                            } ?>>Physically Challenged
                                    </option>
                                    <option value="Physically and Mentally Challenged" <?php if ($get_basic_data['disability'] == 'Physically and Mentally Challenged') {
                                                                                            echo "selected";
                                                                                        } ?>>Physically and Mentally Challenged
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="complexion">Complexion</label>
                                <select id="complexion"
                                    class="form-control mb-5"
                                    name="complexion">
                                    <option value="Very Fair" <?= ($get_basic_data['complexion'] == 'Very Fair') ? "selected" : "" ?>>
                                        Very Fair
                                    </option>
                                    <option value="Fair" <?= ($get_basic_data['complexion'] == 'Fair') ? "selected" : "" ?>>
                                        Fair
                                    </option>
                                    <option value="Wheatish" <?= ($get_basic_data['complexion'] == 'Wheatish') ? "selected" : "" ?>>
                                        Wheatish
                                    </option>
                                    <option value="Wheatish Medium" <?= ($get_basic_data['complexion'] == 'Wheatish Medium') ? "selected" : "" ?>>
                                        Wheatish Medium
                                    </option>
                                    <option value="Wheatish Brown" <?= ($get_basic_data['complexion'] == 'Wheatish Brown') ? "selected" : "" ?>>
                                        Wheatish Brown
                                    </option>
                                    <option value="Dark" <?= ($get_basic_data['complexion'] == 'Dark') ? "selected" : "" ?>>
                                        Dark
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="body_type">Body Type</label>
                                <select id="body_type" name="body_type"
                                    class="form-control mb-5">
                                    <option value="" selected disabled>Body
                                        Type
                                    </option>
                                    <option value="Slim" <?= ($get_basic_data['bodytype'] == 'Slim') ? "selected" : "" ?>>
                                        Slim
                                    </option>
                                    <option value="Average" <?= ($get_basic_data['bodytype'] == 'Average') ? "selected" : "" ?>>
                                        Average
                                    </option>
                                    <option value="Athletic" <?= ($get_basic_data['bodytype'] == 'Athletic') ? "selected" : "" ?>>
                                        Athletic
                                    </option>
                                    <option value="Heavy" <?= ($get_basic_data['bodytype'] == 'Heavy') ? "selected" : "" ?>>
                                        Heavy
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="diet">Diet</label>
                                <select id="diet" class="form-control mb-5" name="diet">
                                    <option value="" selected disabled>Select
                                        Diet
                                    </option>
                                    <option value="Occasionally Non-Veg" <?= ($get_basic_data['diet'] == "Occasionally Non-Veg") ? "selected" : "" ?>>
                                        Occasionally Non-Veg
                                    </option>
                                    <option value="Veg" <?= ($get_basic_data['diet'] == "Veg") ? "selected" : "" ?>>
                                        Veg
                                    </option>
                                    <option value="Eggetarian" <?= ($get_basic_data['diet'] == "Eggetarian") ? "selected" : "" ?>>
                                        Eggetarian
                                    </option>
                                    <option value="Non-Veg" <?= ($get_basic_data['diet'] == "Non-Veg") ? "selected" : "" ?>>
                                        Non-Veg
                                    </option>
                                </select>
                            </div>
                        </div>

                        <?php if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] != 'Bride') { ?>
                            <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                                <div class="form-group">
                                    <label for="drink">Drink</label>
                                    <select class="form-control mb-5" name="drink" id="drink" required>
                                        <option value="" selected disabled>Drinking
                                            Habit ?
                                        </option>
                                        <option value="No" <?= ($get_basic_data['drink'] == 'No') ? "selected" : "" ?>>
                                            No
                                        </option>
                                        <option value="Yes" <?= ($get_basic_data['drink'] == 'Yes') ? "selected" : "" ?>>
                                            Yes
                                        </option>
                                        <option value="Occasionally" <?= ($get_basic_data['drink'] == 'Occasionally') ? "selected" : "" ?>>
                                            Occasionally
                                        </option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="b_group">Blood Group</label>
                                <select id="b_group" class="form-control mb-5" name="b_group"
                                    data-validetta="true">
                                    <option value="">Select</option>
                                    <option value="A+" <?php if ($get_basic_data['b_group'] == 'A+') {
                                                            echo "selected";
                                                        } ?>>A+
                                    </option>
                                    <option value="A-" <?php if ($get_basic_data['b_group'] == 'A-') {
                                                            echo "selected";
                                                        } ?>>A-
                                    </option>
                                    <option value="AB+" <?php if ($get_basic_data['b_group'] == 'AB+') {
                                                            echo "selected";
                                                        } ?>>AB+
                                    </option>
                                    <option value="AB-" <?php if ($get_basic_data['b_group'] == 'AB-') {
                                                            echo "selected";
                                                        } ?>>AB-
                                    </option>
                                    <option value="B+" <?php if ($get_basic_data['b_group'] == 'B+') {
                                                            echo "selected";
                                                        } ?>>B+
                                    </option>
                                    <option value="B-" <?php if ($get_basic_data['b_group'] == 'B-') {
                                                            echo "selected";
                                                        } ?>>B-
                                    </option>
                                    <option value="O+" <?php if ($get_basic_data['b_group'] == 'O+') {
                                                            echo "selected";
                                                        } ?>>O+
                                    </option>
                                    <option value="O-" <?php if ($get_basic_data['b_group'] == 'O-') {
                                                            echo "selected";
                                                        } ?>>O-
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5 pl-0">
                            <div class="form-group">
                                <label for="religion_id">Religion</label>
                                <select id="religion_id"
                                    name="religion_id"
                                    class="form-control mb-5"
                                    onchange="GetCaste('web-services/caste_search?religionId='+this.value)">
                                    <option value="" selected disabled>
                                        Select Religion
                                    </option>
                                    <?php
                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                    ?>
                                        <option value="<?= $DatabaseCo->dbRow->religion_id ?>" <?= ($get_basic_data['religion'] == $DatabaseCo->dbRow->religion_id) ? "selected" : "" ?>><?= $DatabaseCo->dbRow->religion_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="my_caste">Caste</label>
                                <select id="my_caste"
                                    name="my_caste"
                                    class="form-control mb-5"
                                    required>
                                    <?php
                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT DISTINCT caste_id, caste_name FROM caste WHERE status='APPROVED' and religion_id='" . $get_basic_data['religion'] . "' ORDER BY caste_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                    ?>
                                        <option value="<?= $DatabaseCo->dbRow->caste_id ?>" <?= ($get_basic_data['caste'] == $DatabaseCo->dbRow->caste_id) ? "selected" : "" ?>><?= $DatabaseCo->dbRow->caste_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] != 'Bride') { ?>
                            <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                                <div class="form-group">
                                    <?php $search_array12 = explode(',', $get_basic_data['smoke']); ?>
                                    <label for="smoke">Smoke</label>
                                    <select class="form-control mb-5" name="smoke"
                                        id="smoke" required>
                                        <option value="" selected disabled>Smoking
                                            Habit ?
                                        </option>
                                        <option value="No" <?php if (in_array("No", $search_array12)) {
                                                                echo "selected";
                                                            } ?>>No
                                        </option>
                                        <option value="Yes" <?php if (in_array("Yes", $search_array12)) {
                                                                echo "selected";
                                                            } ?>>Yes
                                        </option>
                                        <option value="Occasionally" <?php if (in_array("Occasionally", $search_array12)) {
                                                                            echo "selected";
                                                                        } ?>>Occasionally
                                        </option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12 mb-5">
                            <div class="form-group">
                                <label for="profile_for">Profile created by</label>
                                <select id="profile_for"
                                    class="form-control mb-5"
                                    name="profile_for"
                                    required>
                                    <option value="" selected disabled>
                                        posted by
                                    </option>
                                    <option value="Parents" <?= ($get_basic_data['profileby'] == 'Parents') ? "selected" : "" ?>>
                                        Parents
                                    </option>
                                    <option value="Self" <?= ($get_basic_data['profileby'] == 'Self') ? "selected" : "" ?>>
                                        Self
                                    </option>
                                    <option value="Friend" <?= ($get_basic_data['profileby'] == 'Friend') ? "selected" : "" ?>>
                                        Friend
                                    </option>
                                    <option value="Sibling" <?= ($get_basic_data['profileby'] == 'Sibling') ? "selected" : "" ?>>
                                        Sibling
                                    </option>
                                    <option value="Relatives" <?= ($get_basic_data['profileby'] == 'Relatives') ? "selected" : "" ?>>
                                        Relatives
                                    </option>
                                    <option value="Marriage Bureau" <?= ($get_basic_data['profileby'] == 'Marriage Bureau') ? "selected" : "" ?>>
                                        Marriage Bureau
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-xss-12">
                            <button type="submit" id="update_profile_btn"
                                class="btn btn-primary btn-sm mt-10"
                                name="update_basic_details">Update
                                Profile
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p style="font-size: 16px;"
                                id="response_profile_update"></p>
                        </div>
                    </div>
                </form>
                <form method="POST" action="" id="education_update_form">
                    <div class="section-title-3">
                        <h3 class="edit-heading">Education and Profession</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="education_level">Education Level</label>
                                <select class="form-control mb-5" id="education_level"
                                    data-validetta="required"
                                    name="education_level">
                                    <option value="">Select Education Level</option>
                                    <?php
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>" <?php if ($DatabaseCo->dbRow->e_level_id == $get_basic_data['education_level']) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                            <?php echo $DatabaseCo->dbRow->e_level_name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="education_field">Education Field</label>
                                <select class="form-control mb-5"
                                    id="education_field"
                                    data-validetta="required"
                                    name="education_field">
                                    <option value="">Select Education Field</option>
                                    <?php
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->e_field_id ?>" <?php if ($DatabaseCo->dbRow->e_field_id == $get_basic_data['education_field']) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                            <?php echo $DatabaseCo->dbRow->e_field_name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="income">Annual Income</label>
                                <select class="form-control mb-5" name="income"
                                    id="income" data-validetta="true">
                                    <option value=""> Select Annual Income</option>
                                    <?php
                                    $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) {
                                    ?>
                                        <option value="<?= $DatabaseCo->dbRow->title; ?>"
                                            <?= empty($get_basic_data['income']) ? "" : ($get_basic_data['income'] == $DatabaseCo->dbRow->title ? "selected" : "")
                                            ?>><?= $DatabaseCo->dbRow->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <select class="form-control mb-5" name="occupation"
                                    id="occupation" data-validetta="required">
                                    <option value=""> Select Occupation</option>
                                    <?php
                                    $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>" <?php if ($DatabaseCo->dbRow->ocp_id == $get_basic_data['occupation']) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 mb-5">
                            <div class="form-group">
                                <label for="emp_in">Employed in</label>
                                <select class="form-control mb-5" name="emp_in"
                                    id="emp_in" data-validetta="required">
                                    <option value="" <?php if ($get_basic_data['emp_in'] == '') {
                                                            echo "selected";
                                                        } ?>> Select Employed In
                                    </option>
                                    <option value="Private" <?php if ($get_basic_data['emp_in'] == 'Private') {
                                                                echo "selected";
                                                            } ?>>Private
                                    </option>
                                    <option value="Government" <?php if ($get_basic_data['emp_in'] == 'Government') {
                                                                    echo "selected";
                                                                } ?>>Government
                                    </option>
                                    <option value="Business" <?php if ($get_basic_data['emp_in'] == 'Business') {
                                                                    echo "selected";
                                                                } ?>>Business
                                    </option>
                                    <option value="Defence" <?php if ($get_basic_data['emp_in'] == 'Defence') {
                                                                echo "selected";
                                                            } ?>>Defence
                                    </option>
                                    <option value="MNC Company" <?php if ($get_basic_data['emp_in'] == 'MNC Company') {
                                                                    echo "selected";
                                                                } ?>>MNC Company
                                    </option>
                                    <option value="Not Employed in" <?php if ($get_basic_data['emp_in'] == 'Not Employed in') {
                                                                        echo "selected";
                                                                    } ?>>Not Employed in
                                    </option>
                                    <option value="Self Employed" <?php if ($get_basic_data['emp_in'] == 'Self Employed') {
                                                                        echo "selected";
                                                                    } ?>>Self Employed
                                    </option>
                                    <option value="Others" <?php if ($get_basic_data['emp_in'] == 'Others') {
                                                                echo "selected";
                                                            } ?>>Others
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0 mb-5">
                            <div class="form-group">
                                <label for="monthly_income">Monthly Income</label>
                                <input
                                    id="monthly_income"
                                    type="text"
                                    class="form-control mb-5"
                                    name="monthly_income"
                                    value="<?= $get_basic_data['monthly_sal'] ?>"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12 mb-5">
                            <div class="form-group">
                                <label for="qualification">Qualification</label>
                                <select class="chosen-select form-control mb-5"
                                    name="qualification[]"
                                    id="qualification" multiple>
                                    <?php
                                    $arr_edu = explode(",", $get_basic_data['edu_detail']);
                                    $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT edu_id, edu_name FROM education_detail WHERE status='APPROVED' ORDER BY edu_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->edu_id; ?>" <?php if (in_array($DatabaseCo->dbRow->edu_id, $arr_edu)) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->edu_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit"
                                class="btn btn-sm btn-primary mt-5"
                                name="update_education">Update Education
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p style="font-size: 16px;"
                                id="response_education_update"></p>
                        </div>
                    </div>
                </form>
                <form method="POST" action="" id="contact_update_form">
                    <div class="section-title-3">
                        <h3 class="edit-heading">Residence Detail</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="living_status">
                                    <option value="" disabled>Select Living Status</option>
                                    <option value="" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "") {
                                                            echo "selected";
                                                        } else {
                                                            echo "selected";
                                                        } ?>>Select Living Status
                                    </option>
                                    <option value="With Parents" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "With Parents") {
                                                                        echo "selected";
                                                                    } ?>>With Parents
                                    </option>
                                    <option value="As Room Mate" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "As Room Mate") {
                                                                        echo "selected";
                                                                    } ?>>As Room Mate
                                    </option>
                                    <option value="Myself" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "Myself") {
                                                                echo "selected";
                                                            } ?>>Myself
                                    </option>
                                    <option value="Paying Guest" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "Paying Guest") {
                                                                        echo "selected";
                                                                    } ?>>Paying Guest
                                    </option>
                                    <option value="In Hostel" <?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "In Hostel") {
                                                                    echo "selected";
                                                                } ?>>In Hostel
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="house_ownership"
                                    id="">
                                    <option value="" disabled>Select House Ownership</option>
                                    <option value="" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "") {
                                                            echo "selected";
                                                        } ?>>Please Select
                                    </option>
                                    <option value="Own Flat" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Own Flat") {
                                                                    echo "selected";
                                                                } ?>>Own Flat
                                    </option>
                                    <option value="Own Bungalow" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Own Bungalow") {
                                                                        echo "selected";
                                                                    } ?>>Own Bungalow
                                    </option>
                                    <option value="Parent Flat" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Parent Flat") {
                                                                    echo "selected";
                                                                } ?>>Parent Flat
                                    </option>
                                    <option value="Parent Bungalow" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Parent Bungalow") {
                                                                        echo "selected";
                                                                    } ?>>Parent Bungalow
                                    </option>
                                    <option value="Renting in Flat" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Renting in Flat") {
                                                                        echo "selected";
                                                                    } ?>>Renting in Flat
                                    </option>
                                    <option value="Renting in Bungalow" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Renting in Bungalow") {
                                                                            echo "selected";
                                                                        } ?>>Renting in Bungalow
                                    </option>
                                    <option value="Stay With Relative" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Stay With Relative") {
                                                                            echo "selected";
                                                                        } ?>>Stay With Relative
                                    </option>
                                    <option value="Don't have House" <?php if (htmlspecialchars_decode($get_basic_data['house_ownership'], ENT_QUOTES) == "Don't have House") {
                                                                            echo "selected";
                                                                        } ?>>Don't have House
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="residence">
                                    <option value="" disabled>Select Citizenship</option>
                                    <option value="Citizen" <?php if ($get_basic_data['residence'] == "Citizen") { ?> selected="selected" <?php } ?>>
                                        Citizen
                                    </option>
                                    <option value="Permanent Resident" <?php if ($get_basic_data['residence'] == "Permanent Resident") { ?> selected="selected" <?php } ?>>
                                        Permanent Resident
                                    </option>
                                    <option value="Student Visa" <?php if ($get_basic_data['residence'] == "Student Visa") { ?> selected="selected" <?php } ?>>
                                        Student Visa
                                    </option>
                                    <option value="Temporary Visa" <?php if ($get_basic_data['residence'] == "Temporary Visa") { ?> selected="selected" <?php } ?>>
                                        Temporary Visa
                                    </option>
                                    <option value="Work permit" <?php if ($get_basic_data['residence'] == "Work permit") { ?> selected="selected" <?php } ?>>
                                        Work permit
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="country" id=""
                                    required>
                                    <option value="" disabled>Select Country</option>
                                    <?php
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM country WHERE status='APPROVED' order by country_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>" <?php if ($get_basic_data['country_id'] == $DatabaseCo->dbRow->country_id) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="state" id=""
                                    required>
                                    <option value="" disabled> Select State</option>
                                    <?php
                                    $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("SELECT * FROM state WHERE status='APPROVED' ORDER BY state_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->state_id; ?>" <?php if ($get_basic_data['state_id'] == $DatabaseCo->dbRow->state_id) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->state_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="city" id=""
                                    data-validetta="required">
                                    <option value="" disabled>Select City</option>
                                    <?php

                                    $SQL_STATEMENT_city = $DatabaseCo->dbLink->query("SELECT * FROM city_view WHERE status='APPROVED' ORDER BY city_name ASC");


                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_city)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>" <?php if ($get_basic_data['city'] == $DatabaseCo->dbRow->city_id) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <input type="text" class="form-control mb-5"
                                    name="time_to_call" placeholder="Time to call"
                                    value="<?php echo $get_basic_data['time_to_call']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit"
                                class="btn btn-sm btn-primary mt-10"
                                name="update_residence">Update Residence
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p style="font-size: 16px;"
                                id="response_residence_update"></p>
                        </div>
                    </div>
                </form>
                <!--<div class="section-title-3">
                    <h3 class="edit-heading">Contact Details
                        <a class="ml-20" style="vertical-align: middle;" href="change-contact-detail" title="Change Contact Details">
                            <i class="fa fa-edit"></i>
                        </a>
                    </h3>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                        <div class="form-group">
                            <input type="text" class="form-control mb-5"
                                   name="mobile_no"
                                   id="mobileNoUser" readonly
                                   value="<?php /*echo $get_basic_data['mobile']; */ ?>"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                        <div class="form-group">
                            <input type="email" class="form-control mb-5"
                                   name="email_id" readonly
                                   placeholder="Enter Email Id"
                                   value="<?php /*echo $get_basic_data['email']; */ ?>"/>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                        <div class="form-group">
                            <input type="text" class="form-control mb-5" name="phone" readonly
                                   placeholder="Phone No" value="<?php /*echo $get_basic_data['phone']; */ ?>"/>
                        </div>
                    </div>
                </div>
                <div class="section-title-3">
                    <h3 class="edit-heading">Contact Security
                        <a class="ml-20" style="vertical-align: middle;" href="contact-security" title="Change Contact Security">
                            <i class="fa fa-edit"></i>
                        </a>
                    </h3>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                        <div class="form-group">
                            <select class="form-control mb-5"
                                    name="contact_visibility" readonly="">
                                <option value="" disabled>Select Contact Security</option>
                                <option value="1" <?php /*if ($get_basic_data['contact_view_security'] == '1') {
                                    echo "selected";
                                } */ ?>>Show to all paid members
                                </option>
                                <option value="0" <?php /*if ($get_basic_data['contact_view_security'] == '0') {
                                    echo "selected";
                                } */ ?>>Show to only express interest accepted and
                                    paid members.
                                </option>
                            </select>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="tab-pane fade" id="tab_1-02" style="padding: 10px;">
                <form method="post" action="#" id="family_update_form">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Family Details
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-xs-12 mb-5">
                            <label for="about_my_family"><span class="text-danger">*</span>Describe about your family</label>
                            <textarea class="form-control mb-5"
                                      name="about_my_family"
                                      id="about_my_family"
                                      placeholder="Define About Family"><?php /*if ($get_basic_data['family_details'] != 'Not Available') {
                                    echo htmlspecialchars_decode($get_basic_data['family_details'], ENT_QUOTES);
                                } */ ?></textarea>
                            <p class="mb-5">*Note: Please don't display any type of contact details on your profile.*</p>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select name="family_origin" id=""
                                    class="form-control mb-5">
                                    <option value="" disabled>Please Select Origin</option>
                                    <?php
                                    $query = "select * from city where status='APPROVED' ORDER BY city_name ASC";
                                    $result = $DatabaseCo->dbLink->query($query);
                                    while ($a = mysqli_fetch_array($result)) { ?>
                                        <option value="<?php echo $a['city_id'] ?>" <?php if ($get_basic_data['family_origin'] == $a['city_id']) { ?> selected="selected" <?php } ?>><?php echo $a['city_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="family_type">
                                    <option value="" disabled>Select Family Type</option>
                                    <option value="Seperate Family" <?php if ($get_basic_data['family_type'] == 'Seperate Family') {
                                                                        echo "selected";
                                                                    } ?>>Seperate Family
                                    </option>
                                    <option value="Joint Family" <?php if ($get_basic_data['family_type'] == 'Joint Family') {
                                                                        echo "selected";
                                                                    } ?>>Joint Family
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="family_status">
                                    <option value="">Select Family Status</option>
                                    <option value="Rich" <?php if ($get_basic_data['family_status'] == 'Rich') {
                                                                echo "selected";
                                                            } ?>>Rich
                                    </option>
                                    <option value="Upper Middle Class" <?php if ($get_basic_data['family_status'] == 'Upper Middle Class') {
                                                                            echo "selected";
                                                                        } ?>>Upper Middle Class
                                    </option>
                                    <option value="Middle Class" <?php if ($get_basic_data['family_status'] == 'Middle Class') {
                                                                        echo "selected";
                                                                    } ?>>Middle Class
                                    </option>
                                    <option value="Lower Middle Class" <?php if ($get_basic_data['family_status'] == 'Lower Middle Class') {
                                                                            echo "selected";
                                                                        } ?>>Lower Middle Class
                                    </option>
                                    <option value="Poor Family" <?php if ($get_basic_data['family_status'] == 'Poor Family') {
                                                                    echo "selected";
                                                                } ?>>Poor Family
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="family_value">
                                    <option value="" <?php if ($get_basic_data['family_value'] == "") {
                                                            echo "selected";
                                                        } ?>>Select Family Values
                                    </option>
                                    <option value="Traditional" <?php if ($get_basic_data['family_value'] == "Traditional") {
                                                                    echo "selected";
                                                                } ?>>Traditional
                                    </option>
                                    <option value="Orthodox" <?php if ($get_basic_data['family_value'] == "Orthodox") {
                                                                    echo "selected";
                                                                } ?>>Orthodox
                                    </option>
                                    <option value="Liberal" <?php if ($get_basic_data['family_value'] == "Liberal") {
                                                                echo "selected";
                                                            } ?>>Liberal
                                    </option>
                                    <option value="Moderate" <?php if ($get_basic_data['family_value'] == "Moderate") {
                                                                    echo "selected";
                                                                } ?>>Moderate
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select name="father_ocp" id="" class="form-control mb-5"
                                    data-validetta="true">
                                    <option value="" <?php if ($get_basic_data['father_occupation'] == "") {
                                                            echo "selected";
                                                        } ?>>Please Select
                                    </option>
                                    <option value="Retired" <?php if ($get_basic_data['father_occupation'] == "Retired") {
                                                                echo "selected";
                                                            } ?>>Retired
                                    </option>
                                    <option value="Employed" <?php if ($get_basic_data['father_occupation'] == "Employed") {
                                                                    echo "selected";
                                                                } ?>>Employed
                                    </option>
                                    <option value="Business" <?php if ($get_basic_data['father_occupation'] == "Business") {
                                                                    echo "selected";
                                                                } ?>>Business
                                    </option>
                                    <option value="Professional" <?php if ($get_basic_data['father_occupation'] == "Professional") {
                                                                        echo "selected";
                                                                    } ?>>Professional
                                    </option>
                                    <option value="Not Employed" <?php if ($get_basic_data['father_occupation'] == "Not Employed") {
                                                                        echo "selected";
                                                                    } ?>>Not Employed
                                    </option>
                                    <option value="No More" <?php if ($get_basic_data['father_occupation'] == "No More") {
                                                                echo "selected";
                                                            } ?>>No More
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select name="mother_ocp" id=""
                                    class="form-control mb-5"
                                    data-validetta="true">
                                    <option value="" <?php if ($get_basic_data['mother_occupation'] == "") {
                                                            echo "selected";
                                                        } ?>>Please Select
                                    </option>
                                    <option value="Housewife" <?php if ($get_basic_data['mother_occupation'] == "Housewife") {
                                                                    echo "selected";
                                                                } ?>>Housewife
                                    </option>
                                    <option value="Employed" <?php if ($get_basic_data['mother_occupation'] == "Employed") {
                                                                    echo "selected";
                                                                } ?>>Employed
                                    </option>
                                    <option value="Business" <?php if ($get_basic_data['mother_occupation'] == "Business") {
                                                                    echo "selected";
                                                                } ?>>Business
                                    </option>
                                    <option value="Professional" <?php if ($get_basic_data['mother_occupation'] == "Professional") {
                                                                        echo "selected";
                                                                    } ?>>Professional
                                    </option>
                                    <option value="Retired" <?php if ($get_basic_data['mother_occupation'] == "Retired") {
                                                                echo "selected";
                                                            } ?>>Retired
                                    </option>
                                    <option value="Not Employed" <?php if ($get_basic_data['mother_occupation'] == "Not Employed") {
                                                                        echo "selected";
                                                                    } ?>>Not Employed
                                    </option>
                                    <option value="No More" <?php if ($get_basic_data['mother_occupation'] == "No More") {
                                                                echo "selected";
                                                            } ?>>No More
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="no_of_brother">
                                    <option value="">Select</option>
                                    <option value="0" <?php if ($get_basic_data['no_of_brothers'] == '0') {
                                                            echo "selected";
                                                        } ?>>0
                                    </option>
                                    <option value="1" <?php if ($get_basic_data['no_of_brothers'] == '1') {
                                                            echo "selected";
                                                        } ?>>1
                                    </option>
                                    <option value="2" <?php if ($get_basic_data['no_of_brothers'] == '2') {
                                                            echo "selected";
                                                        } ?>>2
                                    </option>
                                    <option value="3" <?php if ($get_basic_data['no_of_brothers'] == '3') {
                                                            echo "selected";
                                                        } ?>>3
                                    </option>
                                    <option value="4" <?php if ($get_basic_data['no_of_brothers'] == '4') {
                                                            echo "selected";
                                                        } ?>>4
                                    </option>
                                    <option value="4 +" <?php if ($get_basic_data['no_of_brothers'] == '4 +') {
                                                            echo "selected";
                                                        } ?>>4 +
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="no_of_sister">
                                    <option value="">Select</option>
                                    <option value="0" <?php if ($get_basic_data['no_of_sisters'] == '0') {
                                                            echo "selected";
                                                        } ?>>0
                                    </option>
                                    <option value="1" <?php if ($get_basic_data['no_of_sisters'] == '1') {
                                                            echo "selected";
                                                        } ?>>1
                                    </option>
                                    <option value="2" <?php if ($get_basic_data['no_of_sisters'] == '2') {
                                                            echo "selected";
                                                        } ?>>2
                                    </option>
                                    <option value="3" <?php if ($get_basic_data['no_of_sisters'] == '3') {
                                                            echo "selected";
                                                        } ?>>3
                                    </option>
                                    <option value="4" <?php if ($get_basic_data['no_of_sisters'] == '4') {
                                                            echo "selected";
                                                        } ?>>4
                                    </option>
                                    <option value="4 +" <?php if ($get_basic_data['no_of_sisters'] == '4 +') {
                                                            echo "selected";
                                                        } ?>>4 +
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                                <select class="form-control mb-5" name="nmb">
                                    <option value="No married brother" <?php if ($get_basic_data['no_marri_brother'] == "No married brother") { ?> selected="selected" <?php } ?>>
                                        No married brother
                                    </option>
                                    <option value="One married brother" <?php if ($get_basic_data['no_marri_brother'] == "One married brother") { ?> selected="selected" <?php } ?>>
                                        One married brother
                                    </option>
                                    <option value="Two married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Two married brothers") { ?> selected="selected" <?php } ?>>
                                        Two married brothers
                                    </option>
                                    <option value="Three married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Three married brothers") { ?> selected="selected" <?php } ?>>
                                        Three married brothers
                                    </option>
                                    <option value="Four married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Four married brothers") { ?> selected="selected" <?php } ?>>
                                        Four married brothers
                                    </option>
                                    <option value="Above four married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Above four married brothers") { ?> selected="selected" <?php } ?>>
                                        Above four married brothers
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                                <select class="form-control mb-5" name="nms">
                                    <option value="No married sister" <?php if ($get_basic_data['no_marri_sister'] == "No married sister") { ?> selected="selected" <?php } ?>>
                                        No married sister
                                    </option>
                                    <option value="One married sister" <?php if ($get_basic_data['no_marri_sister'] == "One married sister") { ?> selected="selected" <?php } ?>>
                                        One married sister
                                    </option>
                                    <option value="Two married sister" <?php if ($get_basic_data['no_marri_sister'] == "Two married sister") { ?> selected="selected" <?php } ?>>
                                        Two married sister
                                    </option>
                                    <option value="Three married sister" <?php if ($get_basic_data['no_marri_sister'] == "Three married sister") { ?> selected="selected" <?php } ?>>
                                        Three married sister
                                    </option>
                                    <option value="Four married sister" <?php if ($get_basic_data['no_marri_sister'] == "Four married sister") { ?> selected="selected" <?php } ?>>
                                        Four married sister
                                    </option>
                                    <option value="Above four married sister" <?php if ($get_basic_data['no_marri_sister'] == "Above four married sister") { ?> selected="selected" <?php } ?>>
                                        Above four married sister
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <div class="form-group">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit"
                                class="btn btn-sm btn-primary mt-10"
                                name="update_family_details">Update Family
                                Details
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p style="font-size: 16px;"
                                id="response_family_update"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="tab_1-03" style="padding: 10px;">
                <form action="" id="partner_update_form">
                    <!--<div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Partner Expectations
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        <label><span class="text-danger">*</span>Describe your partner expectations</label>
                        <textarea class="form-control mb-5"
                                  id="partner_expectations"
                                  placeholder="Enter Partner Expectations"
                                  name="expectation"><?php /*echo htmlspecialchars_decode($get_basic_data['part_expect'], ENT_QUOTES); */ ?></textarea>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Basic Information
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select class="chosen-select form-control mb-5"
                                name="part_m_status[]"
                                data-placeholder="Looking For"
                                data-validetta="required" multiple>
                                <option value="" disabled>Select Looking For</option>
                                <?php $get_looking = explode(", ", $get_basic_data['looking_for']); ?>
                                <option value="Unmarried" <?php if (in_array("Unmarried", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Unmarried
                                </option>
                                <option value="Widow/Widower" <?php if (in_array("Widow/Widower", $get_looking)) {
                                                                    echo "selected";
                                                                } ?>>Widow/Widower
                                </option>
                                <option value="Divorcee" <?php if (in_array("Divorcee", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Divorcee
                                </option>
                                <option value="Separated" <?php if (in_array("Separated", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Separated
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Mothertongue"
                                class="chosen-select form-control mb-5"
                                name="part_m_tongue[]"
                                multiple tabindex="4"
                                data-validetta="required">
                                <option value="" disabled>Any Mothertongue</option>
                                <?php
                                $SQL_STATEMENT_pmtong = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");
                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_pmtong)) {
                                    $get_partmtongue = explode(",", $get_basic_data['part_mtongue']); ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?php
                                                                                                    if (!empty($get_partmtongue) && in_array($DatabaseCo->dbRow->mtongue_id, $get_partmtongue)) {
                                                                                                        echo "selected";
                                                                                                    } else if ($DatabaseCo->dbRow->mtongue_id == 7) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <select class="form-control mb-5"
                                name="part_from_age"
                                data-validetta="required">
                                <option value="" disabled>Select From Age</option>
                                <option value="<?php echo $get_basic_data['part_frm_age']; ?>"><?php echo $get_basic_data['part_frm_age']; ?>
                                    Years
                                </option>
                                <option value="18">18 Years</option>
                                <option value="19">19 Years</option>
                                <option value="20">20 Years</option>
                                <option value="21">21 Years</option>
                                <option value="22">22 Years</option>
                                <option value="23">23 Years</option>
                                <option value="24">24 Years</option>
                                <option value="25">25 Years</option>
                                <option value="26">26 Years</option>
                                <option value="27">27 Years</option>
                                <option value="28">28 Years</option>
                                <option value="29">29 Years</option>
                                <option value="30">30 Years</option>
                                <option value="31">31 Years</option>
                                <option value="32">32 Years</option>
                                <option value="33">33 Years</option>
                                <option value="34">34 Years</option>
                                <option value="35">35 Years</option>
                                <option value="36">36 Years</option>
                                <option value="37">37 Years</option>
                                <option value="38">38 Years</option>
                                <option value="39">39 Years</option>
                                <option value="40">40 Years</option>
                                <option value="41">41 Years</option>
                                <option value="42">42 Years</option>
                                <option value="43">43 Years</option>
                                <option value="44">44 Years</option>
                                <option value="45">45 Years</option>
                                <option value="46">46 Years</option>
                                <option value="47">47 Years</option>
                                <option value="48">48 Years</option>
                                <option value="49">49 Years</option>
                                <option value="50">50 Years</option>
                                <option value="51">51 Years</option>
                                <option value="52">52 Years</option>
                                <option value="53">53 Years</option>
                                <option value="54">54 Years</option>
                                <option value="55">55 Years</option>
                                <option value="56">56 Years</option>
                                <option value="57">57 Years</option>
                                <option value="58">58 Years</option>
                                <option value="59">59 Years</option>
                                <option value="60">60 Years</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <select class="form-control mb-5"
                                name="part_to_age"
                                data-validetta="required">
                                <option value="" disabled>Select To age</option>
                                <option value="<?php echo $get_basic_data['part_to_age']; ?>"><?php echo $get_basic_data['part_to_age']; ?>
                                    Years
                                </option>
                                <option value="18">18 Years</option>
                                <option value="19">19 Years</option>
                                <option value="20">20 Years</option>
                                <option value="21">21 Years</option>
                                <option value="22">22 Years</option>
                                <option value="23">23 Years</option>
                                <option value="24">24 Years</option>
                                <option value="25">25 Years</option>
                                <option value="26">26 Years</option>
                                <option value="27">27 Years</option>
                                <option value="28">28 Years</option>
                                <option value="29">29 Years</option>
                                <option value="30">30 Years</option>
                                <option value="31">31 Years</option>
                                <option value="32">32 Years</option>
                                <option value="33">33 Years</option>
                                <option value="34">34 Years</option>
                                <option value="35">35 Years</option>
                                <option value="36">36 Years</option>
                                <option value="37">37 Years</option>
                                <option value="38">38 Years</option>
                                <option value="39">39 Years</option>
                                <option value="40">40 Years</option>
                                <option value="41">41 Years</option>
                                <option value="42">42 Years</option>
                                <option value="43">43 Years</option>
                                <option value="44">44 Years</option>
                                <option value="45">45 Years</option>
                                <option value="46">46 Years</option>
                                <option value="47">47 Years</option>
                                <option value="48">48 Years</option>
                                <option value="49">49 Years</option>
                                <option value="50">50 Years</option>
                                <option value="51">51 Years</option>
                                <option value="52">52 Years</option>
                                <option value="53">53 Years</option>
                                <option value="54">54 Years</option>
                                <option value="55">55 Years</option>
                                <option value="56">56 Years</option>
                                <option value="57">57 Years</option>
                                <option value="58">58 Years</option>
                                <option value="59">59 Years</option>
                                <option value="60">60 Years</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6">
                            <select class="form-control mb-5"
                                name="part_from_height">
                                <option value="" disabled>Select From Height</option>
                                <?php if (!empty($get_basic_data['part_height'])) { ?>
                                    <option value="<?php echo $get_basic_data['part_height']; ?>"><?php $ao = $get_basic_data['part_height'];
                                                                                                    $ft = (int)($ao / 12);
                                                                                                    $inch = $ao % 12;
                                                                                                    echo $ft . "ft" . " " . $inch . "in"; ?></option>
                                <?php } ?>
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
                        <div class="col-md-3 col-sm-3 col-xs-6 col-xss-6 pl-0">
                            <select class="form-control mb-5"
                                name="part_to_height">
                                <option value="" disabled>Select to height</option>
                                <?php if (!empty($get_basic_data['part_height_to'])) { ?>
                                    <option value="<?php echo $get_basic_data['part_height_to']; ?>"><?php $ao = $get_basic_data['part_height_to'];
                                                                                                        $ft = (int)($ao / 12);
                                                                                                        $inch = $ao % 12;
                                                                                                        echo $ft . "ft" . " " . $inch . "in"; ?></option>
                                <?php } ?>
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
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Body Type"
                                class="chosen-select form-control mb-5"
                                name="part_bodytype[]"
                                multiple tabindex="4">
                                <option value="" disabled>Select Body Type</option>
                                <?php
                                $get_partbodytype = explode(", ", $get_basic_data['part_bodytype']);
                                ?>
                                <option value="Slim" <?php if (in_array("Slim", $get_partbodytype)) {
                                                            echo "selected";
                                                        } ?>>Slim
                                </option>
                                <option value="Average" <?php if (in_array("Average", $get_partbodytype)) {
                                                            echo "selected";
                                                        } ?>>Average
                                </option>
                                <option value="Athletic" <?php if (in_array("Athletic", $get_partbodytype)) {
                                                                echo "selected";
                                                            } ?>>Athletic
                                </option>
                                <option value="Heavy" <?php if (in_array("Heavy", $get_partbodytype)) {
                                                            echo "selected";
                                                        } ?>>Heavy
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Eating Habit"
                                class="chosen-select form-control mb-5"
                                name="part_diet[]" multiple>
                                <option value="" disabled>Select Diet Type</option>
                                <?php
                                $get_partdiet = explode(", ", $get_basic_data['part_diet']);
                                ?>
                                <option value="Occasionally Non-Veg" <?php if (in_array("Occasionally Non-Veg", $get_partdiet)) {
                                                                            echo "selected";
                                                                        } ?>>Occasionally Non-Veg
                                </option>
                                <option value="Veg" <?php if (in_array("Veg", $get_partdiet)) {
                                                        echo "selected";
                                                    } ?>>Veg
                                </option>
                                <option value="Eggetarian" <?php if (in_array("Eggetarian", $get_partdiet)) {
                                                                echo "selected";
                                                            } ?>>Eggetarian
                                </option>
                                <option value="Non-Veg" <?php if (in_array("Non-Veg", $get_partdiet)) {
                                                            echo "selected";
                                                        } ?>>Non-Veg
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select placeholder="Marry in other caste?"
                                class="form-control mb-5"
                                name="part_other_caste">

                                <option value="" disabled>Marry in other caste?</option>
                                <option value="0" <?= !empty($get_basic_data['other_caste']) ? $get_basic_data['other_caste'] == "0" ? "selected" : "" : "" ?>>Marry in same Caste</option>
                                <option value="1" <?= !empty($get_basic_data['other_caste']) ? $get_basic_data['other_caste'] == "1" ? "selected" : "" : "" ?>>Caste No Bar</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Drinking Habit"
                                class="chosen-select form-control mb-5"
                                name="part_drink[]" multiple
                                tabindex="4">
                                <option value="" disabled>Select Drinking Habit</option>
                                <?php
                                $get_partdrink = explode(", ", $get_basic_data['part_drink']);
                                ?>
                                <option value="No" <?php if (in_array("No", $get_partdrink)) {
                                                        echo "selected";
                                                    } ?>>No
                                </option>
                                <option value="Yes" <?php if (in_array("Yes", $get_partdrink)) {
                                                        echo "selected";
                                                    } ?>>Yes
                                </option>
                                <option value="Occasionally" <?php if (in_array("Occasionally", $get_partdrink)) {
                                                                    echo "selected";
                                                                } ?>>Occasionally
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Religion"
                                class="chosen-select form-control mb-5"
                                id="part_religion"
                                onchange="GetCaste1(this);"
                                name="part_religion[]" multiple
                                tabindex="4">
                                <option value="" disabled>Select Partner Religion</option>
                                <?php
                                $get_part_relg = $get_basic_data['part_religion'];
                                $arr_part_relg = explode(",", $get_part_relg);
                                $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT religion_id, religion_name FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"
                                        <?php if (!empty($arr_part_relg) && in_array($DatabaseCo->dbRow->religion_id, $arr_part_relg)) {
                                            echo "selected";
                                        } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select data-placeholder="Choose Partner Caste"
                                class="chosen-select form-control mb-5"
                                name="part_caste[]"
                                id="part_caste" multiple tabindex="4">
                                <option value="" disabled>Select Partner Caste</option>
                                <?php
                                $get_part_caste = $get_basic_data['part_caste'];
                                $arr_part_catse = explode(",", $get_part_caste);
                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT DISTINCT caste_id,caste_name FROM caste WHERE status='APPROVED' and religion_id IN ($get_part_relg) ORDER BY caste_name ASC");
                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->caste_id; ?>" <?php if ($arr_part_catse != '') {
                                                                                                    if (!empty($arr_part_catse) && in_array($DatabaseCo->dbRow->caste_id, $arr_part_catse)) {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                } ?>><?php echo $DatabaseCo->dbRow->caste_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <select class="form-control mb-5" name="part_manglik"
                                id="part_manglik">
                                <option value="" disabled>Manglik Partner?</option>
                                <option value="Does Not Matter"> Does Not Matter
                                </option>
                                <option value="Yes" <?php if ($get_basic_data['part_manglik'] == 'Yes') {
                                                        echo "selected";
                                                    } ?>>Yes
                                </option>
                                <option value="No" <?php if ($get_basic_data['part_manglik'] == 'No') {
                                                        echo "selected";
                                                    } ?>>No
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <?php
                            $get_parttone = explode(", ", $get_basic_data['part_complexion']);
                            ?>
                            <select data-placeholder="Choose Partner Complexion"
                                class="chosen-select form-control mb-5"
                                name="part_complexion[]"
                                multiple tabindex="4">
                                <option value="Wheatish" <?php if (in_array("Wheatish", $get_parttone)) {
                                                                echo "selected";
                                                            } ?>>Wheatish
                                </option>
                                <option value="Very Fair" <?php if (in_array("Very Fair", $get_parttone)) {
                                                                echo "selected";
                                                            } ?>>Very Fair
                                </option>
                                <option value="Fair" <?php if (in_array("Fair", $get_parttone)) {
                                                            echo "selected";
                                                        } ?>>Fair
                                </option>
                                <option value="Wheatish Medium" <?php if (in_array("Wheatish Medium", $get_parttone)) {
                                                                    echo "selected";
                                                                } ?>>Wheatish Medium
                                </option>
                                <option value="Wheatish Brown" <?php if (in_array("Wheatish Brown", $get_parttone)) {
                                                                    echo "selected";
                                                                } ?>>Wheatish Brown
                                </option>
                                <option value="Dark" <?php if (in_array("Dark", $get_parttone)) {
                                                            echo "selected";
                                                        } ?>>Dark
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Education and Profession
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select class="chosen-select  form-control mb-5" multiple
                                    name="part_edu_field[]" id="part_edu_field">
                                    <option value="" disabled>Select Educational Field</option>
                                    <?php
                                    $get_part_edu_field = $get_basic_data['part_edu_field'];
                                    $arr_part_edu_field = explode(",", $get_part_edu_field);

                                    $SQL_STATEMENT_edu_field = $DatabaseCo->dbLink->query("SELECT e_field_id, e_field_name FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu_field)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->e_field_id; ?>" <?php if (in_array($DatabaseCo->dbRow->e_field_id, $arr_part_edu_field)) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $DatabaseCo->dbRow->e_field_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select class="chosen-select  form-control mb-5" multiple
                                    name="part_education[]" id="part_education">
                                    <option value="" disabled>Select Educational Detail</option>
                                    <?php
                                    $get_part_edu = $get_basic_data['part_edu'];
                                    $arr_part_edu = explode(",", $get_part_edu);

                                    $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT * FROM education_detail WHERE status='APPROVED' ORDER BY edu_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->edu_id; ?>" <?php if (in_array($DatabaseCo->dbRow->edu_id, $arr_part_edu)) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->edu_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select data-placeholder="Choose Partner Employed in"
                                    class="chosen-select form-control mb-5"
                                    name="part_emp_in[]"
                                    id="part_emp_in" multiple tabindex="4">
                                    <option value="" disabled>Select Employed In</option>
                                    <?php
                                    $get_part_empin = $get_basic_data['part_emp_in'];
                                    $arr_part_empin = explode(",", $get_part_empin);
                                    ?>
                                    <option value="Private" <?php if (in_array('Private', $arr_part_empin)) {
                                                                echo "selected";
                                                            } ?>>Private
                                    </option>
                                    <option value="Government" <?php if (in_array('Government', $arr_part_empin)) {
                                                                    echo "selected";
                                                                } ?>>Government
                                    </option>
                                    <option value="Business" <?php if (in_array('Business', $arr_part_empin)) {
                                                                    echo "selected";
                                                                } ?>>Business
                                    </option>
                                    <option value="Defence" <?php if (in_array('Defence', $arr_part_empin)) {
                                                                echo "selected";
                                                            } ?>>Defence
                                    </option>
                                    <option value="Not Employed in" <?php if (in_array('Not Employed in', $arr_part_empin)) {
                                                                        echo "selected";
                                                                    } ?>>Not Employed in
                                    </option>
                                    <option value="Others" <?php if (in_array('Others', $arr_part_empin)) {
                                                                echo "selected";
                                                            } ?>>Others
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select data-placeholder="Choose Partner Occupation"
                                    class="chosen-select form-control mb-5"
                                    name="part_occupation[]"
                                    id="part_occupation" multiple tabindex="4">
                                    <option value="" disabled>Select Occupation</option>
                                    <?php
                                    $get_part_ocp = $get_basic_data['part_occupation'];
                                    $arr_part_ocp = explode(",", $get_part_ocp);

                                    $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>" <?php if (in_array($DatabaseCo->dbRow->ocp_id, $arr_part_ocp)) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select class="form-control mb-5"
                                    name="part_income" id="part_income">
                                    <option value="" disabled>Select Annual Income</option>
                                    <?php
                                    $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) {
                                    ?>
                                        <option value="<?= $DatabaseCo->dbRow->title; ?>"
                                            <?= empty($get_basic_data['part_income']) ? "" : ($get_basic_data['part_income'] == $DatabaseCo->dbRow->title ? "selected" : "")
                                            ?>><?= $DatabaseCo->dbRow->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12 pl-0">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title-3">
                                <h3 class="edit-heading">
                                    Partner Residence
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select name="part_country[]" id="part_country"
                                    data-placeholder="Choose Partner Country"
                                    class="chosen-select form-control mb-5" multiple
                                    tabindex="4">
                                    <option value="" disabled>Select Country</option>
                                    <option value="">Does Not Matter</option>
                                    <?php
                                    $get_part_cunt = $get_basic_data['part_country_living'];
                                    $arr_part_country = explode(",", $get_part_cunt);

                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT country_id,country_name FROM country WHERE status='APPROVED'");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>" <?php if (in_array($DatabaseCo->dbRow->country_id, $arr_part_country)) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select data-placeholder="Choose Partner State"
                                    class="chosen-select form-control mb-5"
                                    name="part_state[]"
                                    id="part_state" multiple tabindex="4">
                                    <option value="" disabled>Select State</option>
                                    <option value="">Does Not Matter</option>
                                    <?php
                                    $get_part_state = $get_basic_data['part_state'];
                                    $arr_part_state = explode(",", $get_part_state);

                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT state_id,state_name FROM state_view ORDER BY state_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>

                                        <option value="<?php echo $DatabaseCo->dbRow->state_id; ?>" <?php if ($get_part_state != '') {
                                                                                                        if (in_array($DatabaseCo->dbRow->state_id, $arr_part_state)) {
                                                                                                            echo "selected";
                                                                                                        }
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->state_name; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select data-placeholder="Choose Partner City"
                                    name="part_city[]"
                                    id="part_city"
                                    class="chosen-select form-control mb-5"
                                    multiple
                                    tabindex="4">
                                    <option value="" disabled>Select City</option>
                                    <option value="">Does Not Matter</option>
                                    <?php
                                    $get_part_city = $get_basic_data['part_city'];
                                    $arr_part_city = explode(",", $get_part_city);
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view where status='APPROVED' ORDER BY city_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id ?>" <?php if ($get_part_city != '') {
                                                                                                        if (in_array($DatabaseCo->dbRow->city_id, $arr_part_city)) {
                                                                                                            echo "selected";
                                                                                                        }
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->city_name ?></option>

                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select class="form-control mb-5" name="part_residence[]"
                                    tabindex="4">
                                    <option value="" disabled>Select Citizenship</option>
                                    <option value="">Does Not Matter</option>
                                    <option value="Citizen" <?php if ($get_basic_data['part_resi_status'] == "Citizen") { ?> selected="selected" <?php } ?>>
                                        Citizen
                                    </option>
                                    <option value="Permanent Resident" <?php if ($get_basic_data['part_resi_status'] == "Permanent Resident") { ?> selected="selected" <?php } ?>>
                                        Permanent Resident
                                    </option>
                                    <option value="Student Visa" <?php if ($get_basic_data['part_resi_status'] == "Student Visa") { ?> selected="selected" <?php } ?>>
                                        Student Visa
                                    </option>
                                    <option value="Temporary Visa" <?php if ($get_basic_data['part_resi_status'] == "Temporary Visa") { ?> selected="selected" <?php } ?>>
                                        Temporary Visa
                                    </option>
                                    <option value="Work permit" <?php if ($get_basic_data['part_resi_status'] == "Work permit") { ?> selected="selected" <?php } ?>>
                                        Work permit
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                                <select data-placeholder="Choose Partner Native Place"
                                    name="part_native_place[]"
                                    id="part_native_place"
                                    class="chosen-select form-control mb-5"
                                    multiple
                                    tabindex="4">
                                    <option value="" disabled>Select Native Place</option>
                                    <option value="">Does Not Matter</option>
                                    <?php
                                    $get_part_native_city = $get_basic_data['part_native_place'];
                                    $arr_part_native_city = explode(",", $get_part_native_city);
                                    $SQL_STATEMENT1 = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view where status='APPROVED' ORDER BY city_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT1)) {
                                    ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id ?>" <?php if ($get_part_city != '') {
                                                                                                        if (in_array($DatabaseCo->dbRow->city_id, $arr_part_native_city)) {
                                                                                                            echo "selected";
                                                                                                        }
                                                                                                    } ?>><?php echo $DatabaseCo->dbRow->city_name ?></option>

                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-xss-12">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p class="text-danger">*Note: Please don't display any type of contact details on your profile.*</p>
                            <button type="submit"
                                class="btn btn-sm btn-primary"
                                name="update_partner_reference">Update
                                Partner
                                Preference
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p style="font-size: 16px;"
                                id="response_partner_update"></p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="js/bootstrap-toolkit.min.js"></script>
<script type="text/javascript" src="js/device.js"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "100%"
        },
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }


    $(function() {
        $("#profile_update_form").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#profile_update_form").serialize() + "&update_type=profile",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.result == 'success') {
                        $("#response_profile_update").removeClass('text-danger').addClass('text-danger')
                            .html('Successfully Updated')
                            .fadeIn('fast').fadeOut(30000);
                    } else {
                        $("#response_profile_update").removeClass('text-danger').addClass('text-danger')
                            .html('Profile updation failed.').fadeIn('fast').fadeOut(30000);
                    }
                }
            });
            e.preventDefault();
        });


        $("#education_update_form").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#education_update_form").serialize() + "&update_type=education",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.result == 'success') {
                        $("#response_education_update").addClass('text-success').removeClass('text-danger').html('Education details successfully updated').fadeIn('fast').fadeOut(10000);
                    } else {
                        $("#response_education_update").addClass('text-danger').removeClass('text-success').html('Education details updation failed.').fadeIn('fast').fadeOut(10000);
                    }
                }
            });
            e.preventDefault();
        });


        $("#contact_update_form").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#contact_update_form").serialize() + "&update_type=contact",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.result == 'success') {
                        $("#response_residence_update").addClass('text-success').removeClass('text-danger').html('Residence details successfully updated').fadeIn('fast').fadeOut(10000);
                    } else {
                        $("#response_residence_update").addClass('text-danger').removeClass('text-success').html('Residence details updation failed.').fadeIn('fast').fadeOut(10000);
                    }
                }
            });
            e.preventDefault();
        });


        $("#family_update_form").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#family_update_form").serialize() + "&update_type=family",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.result == 'success') {
                        $("#response_family_update").removeClass('text-danger').addClass('text-danger')
                            .html('Family details successfully updated.').fadeIn('fast').fadeOut(30000);
                    } else {
                        $("#response_family_update").removeClass('text-danger').addClass('text-danger')
                            .html('Family details updation failed.').fadeIn('fast').fadeOut(30000);
                    }
                }
            });
            e.preventDefault();
        });


        $("#partner_update_form").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#partner_update_form").serialize() + "&update_type=partner",
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.result == 'success') {
                        $("#response_partner_update").removeClass('text-danger').addClass('text-danger')
                            .html('Partner details successfully updated.').fadeIn('fast').fadeOut(30000);
                    } else {
                        $("#response_partner_update").removeClass('text-danger').addClass('text-danger')
                            .html('Partner details updation failed.').fadeIn('fast').fadeOut(30000);
                    }
                }
            });
            e.preventDefault();
        });


        $("#change_password_form").submit(function(e) {
            $("#response_change_password").html("");
            if ($("#old_pass").val() == "" || $("#new_pass").val() == "" || $("#cnfm_pass").val() == "") {
                $("#response_change_password").html("Passwords should not be blank");
                return false;
            } else if ($("#new_pass").val() !== $("#cnfm_pass").val()) {
                $("#response_change_password").html("New Password and Confirm Password not matched");
                return false;
            } else {
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/change_password", //Where to make Ajax calls
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loader-animation-area").show();
                    },
                    data: $(this).serialize() + "&change_password=true",
                    success: function(response) {
                        $("#response_change_password").html(response.msg);
                        if (response.result == 'success') {
                            $("#change_password_form").get(0).reset()
                        }
                    },
                    complete: function() {
                        $("#loader-animation-area").hide();
                    }
                });
            }
            e.preventDefault();
        });
    });
</script>