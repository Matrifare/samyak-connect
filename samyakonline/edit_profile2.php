<?php

include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
$sql = $DatabaseCo->dbLink->query("select * from register where matri_id='" . ($_SESSION["user_id"] ?? "") . "'");
$get_basic_data = mysqli_fetch_array($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Samyakmatrimony</title>


    <!-- Morris Charts CSS -->
    <link href="view_profile_res/vendors/bower_components/morris.js/morris.css" rel="stylesheet" type="text/css"/>

    <!-- vector map CSS -->
    <link href="view_profile_res/vendors/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" type="text/css"/>

    <!-- Calendar CSS -->
    <link href="view_profile_res/vendors/bower_components/fullcalendar/dist/fullcalendar.css" rel="stylesheet"
          type="text/css"/>

    <!-- Data table CSS -->
    <link href="view_profile_res/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css"
          rel="stylesheet" type="text/css"/>
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
          rel='stylesheet' type='text/css'>
    <!-- Custom CSS -->
    <link href="view_profile_res/dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- Select  2 -->
    <!--<link rel="stylesheet" href="view_profile_res/vendors/bower_components/select2/dist/css/select2.min.css?v=1.1"
          type="text/css">-->
    <link rel="stylesheet" href="css/chosen.css" type="text/css">
    <style>
        body {
            color: #333;
        }
    </style>
</head>

<body style="background: #EDEDED;">
<div class="container">
    <div class="wrapper box-layout theme-1-active pimary-color-blue">
        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid pt-10" style="background: #EDEDED;">

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-3 col-xs-12">
                        <div class="panel panel-default card-view  pa-0" style="border-radius: 0px;">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body  pa-0">
                                    <div class="profile-box">
                                        <!--<div class="profile-cover-pic" style="border-radius: 0px;">
                                            <div class="fileupload btn btn-default">
                                                <span class="btn-text">edit</span>
                                                <input class="upload" type="file">
                                            </div>
                                            <div class="profile-image-overlay"></div>
                                        </div>-->
                                        <div class="profile-info text-center">
                                            <div class="profile-img-wrap">
                                                <a href="#photos_8">
                                                    <?php
                                                    if (!empty(trim($get_basic_data['photo1'])) && file_exists('photos/' . trim($get_basic_data['photo1']))) {
                                                        $showPhoto = "watermark?image=photos/" . trim($get_basic_data['photo1']) . "&watermark=watermark.png";
                                                    } else {
                                                        if (!empty(trim($get_basic_data['photo1'])) && file_exists('photos/' . trim($get_basic_data['photo1']))) {
                                                            $showPhoto = "watermark?image=photos/" . trim($get_basic_data['photo1']) . "&watermark=watermark.png";
                                                        } else {
                                                            if ($get_basic_data['gender'] == 'Groom') {
                                                                $showPhoto = "img/default-photo/male-200.png";
                                                            } else {
                                                                $showPhoto = "img/default-photo/female-200.png";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <img class="inline-block mb-10"
                                                         src="<?= $showPhoto ?>"
                                                         alt="user"/>
                                                </a>
                                            </div>
                                            <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-orange"><?php echo htmlspecialchars_decode($get_basic_data['firstname'], ENT_QUOTES); ?>
                                                -
                                                <?php echo $get_basic_data['matri_id']; ?></h5>
                                        </div>
                                        <div class="social-info">
                                            <!--<div class="row">
                                            <?php
                                            /*                                            if ($_SESSION['user_id'] != $Row->matri_id) {
                                                                                            */ ?>
                                                <div class="col-xs-6 text-center" id="">
                                                    <div id="send_interest_button"
                                                         onclick="ExpressInterest('<?php /*echo $Row->matri_id; */ ?>', '<? /*= (isset($_SESSION['last_login']) && $_SESSION['last_login'] == 'first_time') ? 'No' : 'Yes' */ ?>')">
                                                    <span class="counts block head-font"><i
                                                                class="fa fa-heart-o"></i></span>
                                                        <span class="counts-text block">Send Interest</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 text-center" id=""
                                                     onclick="view_message_box('<? /*= $Row->matri_id */ ?>')">
                                                    <div id="send_message_button">
                                                    <span class="counts block head-font"><i
                                                                class="fa fa-paper-plane-o text-warning"></i> </span>
                                                        <span class="counts-text block">Send Message</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 text-center" id="" onclick="">
                                                    <div id="bookmark_profile_button"
                                                         onclick="shortlist(this, '<? /*= $Row->matri_id */ ?>');">
                                                        <?php
                                            /*                                                        $sql = "select * from shortlist where from_id='" . $_SESSION['user_id'] . "' and to_id='" . $Row->matri_id . "'";
                                                                                                    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
                                                                                                    if (mysqli_num_rows($DatabaseCo->dbResult) > 0) { */ ?>
                                                            <span class="counts block head-font"><i
                                                                        class="fa fa-bookmark text-primary"></i> </span>
                                                            <span class="counts-text block">Remove from Bookmark</span>
                                                        <?php /*} else { */ ?>
                                                            <span class="counts block head-font"><i
                                                                        class="fa fa-bookmark-o text-primary"></i> </span>
                                                            <span class="counts-text block">Bookmark Profile</span>
                                                        <?php /*} */ ?>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 text-center" id=""
                                                     onclick="">
                                                    <div id="block_profile_button"
                                                         onclick="block(this, '<? /*= $Row->matri_id */ ?>');">
                                                        <?php
                                            /*                                                        $sql = "select * from block_profile where block_by='" . $_SESSION['user_id'] . "' and block_to='" . $Row->matri_id . "'";
                                                                                                    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
                                                                                                    if (mysqli_num_rows($DatabaseCo->dbResult) > 0) { */ ?>
                                                            <span class="counts block head-font"><i
                                                                        class="fa fa-check text-success"></i> </span>
                                                            <span class="counts-text block">Unblock Profile</span>
                                                        <?php /*} else { */ ?>
                                                            <span class="counts block head-font"><i
                                                                        class="fa fa-ban text-danger"></i> </span>
                                                            <span class="counts-text block">Block Profile</span>
                                                        <?php /*} */ ?>
                                                    </div>
                                                </div>
                                                <?php
                                            /*                                            }
                                                                                        */ ?>
                                        </div>-->
                                            <!--<div class="row">
                                            <div class="col-xs-4 text-center" id="">
                                                <div id="send_interest_button"
                                                     onclick="block_contact('<?php /*echo $Row->matri_id; */ ?>', '<? /*= (isset($_SESSION['last_login']) && $_SESSION['last_login'] == 'first_time') ? 'No' : 'Yes' */ ?>')">
                                                    <span class="counts block head-font"><i
                                                                class="fa fa-ban text-danger"></i></span>
                                                    <span class="counts-text block">Block</span>
                                                </div>

                                            </div>
                                            <div class="col-xs-4 text-center" id="">
                                                <div id="send_message_button">
                                                    <span class="counts block head-font"><i
                                                                class="fa fa-bookmark-o"></i> </span>
                                                    <span class="counts-text block">Bookmark</span>
                                                </div>

                                            </div>
                                            <div class="col-xs-4 text-center" id=""
                                                 onclick="getContactDetail('<?php /*echo $Row->matri_id; */ ?>')">
                                                <div id="view_contact_button">
                                                    <span class="counts block head-font"><i
                                                                class="fa fa-whatsapp"></i> </span>
                                                    <span class="counts-text block">Share</span>
                                                </div>
                                            </div>
                                        </div>-->
                                            <!--<button class="btn btn-warning btn-block  btn-anim mt-30" data-toggle="modal"
                                                    data-target="#myModal"><i class="fa fa-pencil"></i><span
                                                        class="btn-text">edit profile</span></button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-12">
                        <div class="panel panel-default card-view pa-0" style="border-radius: 0px;">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pb-0">
                                    <div class="tab-struct custom-tab-1">
                                        <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                                            <li class="active" role="presentation"><a data-toggle="tab"
                                                                                      id="profile_tab_8"
                                                                                      role="tab" href="#profile_8"
                                                                                      aria-expanded="false"><span>profile</span></a>
                                            </li>
                                            <!--<li role="presentation"><a data-toggle="tab" id="education_tab_8"
                                                                       role="tab" href="#education_8"
                                                                       aria-expanded="false"><span>Education Details</span></a></li>-->
                                            <!--<li role="presentation"><a data-toggle="tab" id="contact_tab_8"
                                                                       role="tab" href="#contact_8"
                                                                       aria-expanded="false"><span>Contact Details</span></a></li>-->
                                            <li role="presentation" class="next"><a aria-expanded="true"
                                                                                    data-toggle="tab"
                                                                                    role="tab" id="follo_tab_8"
                                                                                    href="#follo_8"><span>Family Details</span></a>
                                            </li>
                                            <li role="presentation" class=""><a data-toggle="tab" id="earning_tab_8"
                                                                                role="tab" href="#earnings_8"
                                                                                aria-expanded="false"><span>Partner Expectations</span></a>
                                            </li>
                                            <li role="presentation" class=""><a data-toggle="tab" id="password_tab_8"
                                                                                role="tab" href="#change_password"
                                                                                aria-expanded="false"><span>Change Password</span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent_8">
                                            <div id="profile_8" class="tab-pane fade active in" role="tabpanel">
                                                <div class="col-md-12">
                                                    <form method="post" id="profile_update_form" action="#">
                                                        <div class="pt-20">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pb-10"><i
                                                                                class="fa fa-newspaper-o"></i> Basic
                                                                        Information
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">First Name</div>
                                                                <div class="col-xs-7 col-md-4 mb-7"><input
                                                                            type="text"
                                                                            class="form-control"
                                                                            name="first_name"
                                                                            value="<?= $get_basic_data['firstname'] ?>"
                                                                            required/></div>

                                                                <div class="col-xs-5 col-md-2 mb-7">Last Name</div>
                                                                <div class="col-xs-7 col-md-4 mb-7"><input
                                                                            type="text"
                                                                            class="form-control"
                                                                            name="last_name"
                                                                            value="<?= $get_basic_data['lastname'] ?>"
                                                                            required/></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Date of Birth
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-4 p-r-0"><select
                                                                                    id="register_date"
                                                                                    name="day"
                                                                                    class="form-control"
                                                                                    required
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
                                                                            </select></div>
                                                                        <div class="col-xs-4 p-r-0"
                                                                             style="padding-left: 5px !important;">
                                                                            <select
                                                                                    id="register_month"
                                                                                    name="month"
                                                                                    class="form-control"
                                                                                    required
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
                                                                            </select></div>
                                                                        <div class="col-xs-4"
                                                                             style="padding-left: 5px !important;">
                                                                            <select
                                                                                    id="register_year"
                                                                                    name="year"
                                                                                    class="form-control"
                                                                                    required
                                                                                    onchange="setDays(month,day,this)">
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
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">
                                                                    Marital Status
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control mb-5"
                                                                            name="marital_status"
                                                                            id="marital_status">
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
                                                            <div class="row" id="child_section"
                                                                 style="display: <?= ($get_basic_data['m_status'] != 'Unmarried') ? "block" : "none" ?>">
                                                                <div class="col-xs-5 col-md-2 mb-7">
                                                                    Children Status
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Height :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select id="register_height"
                                                                            class="form-control"
                                                                            name="height" required>
                                                                        <option value="" selected disabled>Select
                                                                            Height
                                                                        </option>
                                                                        <option value="48" <?= ($get_basic_data['height'] == 48) ? "selected" : "" ?>>
                                                                            4ft
                                                                        </option>
                                                                        <option value="49" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
                                                                            4ft 01in
                                                                        </option>
                                                                        <option value="50" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
                                                                            4ft 02in
                                                                        </option>
                                                                        <option value="51" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
                                                                            4ft 03in
                                                                        </option>
                                                                        <option value="52" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
                                                                            4ft 04in
                                                                        </option>
                                                                        <option value="53" <?= ($get_basic_data['height'] == 54) ? "selected" : "" ?>>
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Weight :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="weight" required>
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Mother Tongue
                                                                    :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select id="register_mothertongue"
                                                                            name="mothertongue"
                                                                            class="form-control mb-5" required>
                                                                        <option value="" selected disabled>Select
                                                                            Mothertongue
                                                                        </option>
                                                                        <?php
                                                                        $SQL_STATEMENT_Mtongu = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");

                                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_Mtongu)) {
                                                                            ?>
                                                                            <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?= ($DatabaseCo->dbRow->mtongue_id == $get_basic_data['m_tongue']) ? "selected" : ($DatabaseCo->dbRow->mtongue_id == 7) ? "selected" : "" ?>>
                                                                                <?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Special Case :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="disability">
                                                                        <option value="None"<?php if ($get_basic_data['disability'] == 'None') {
                                                                            echo "selected";
                                                                        } ?>>None
                                                                        </option>
                                                                        <option value="HIV Positive"<?php if ($get_basic_data['disability'] == 'HIV Positive') {
                                                                            echo "selected";
                                                                        } ?>>HIV Positive
                                                                        </option>
                                                                        <option value="Mentally Challenged"<?php if ($get_basic_data['disability'] == 'Mentally Challenged') {
                                                                            echo "selected";
                                                                        } ?>>Mentally Challenged
                                                                        </option>
                                                                        <option value="Physically Challenged"<?php if ($get_basic_data['disability'] == 'Physically Challenged') {
                                                                            echo "selected";
                                                                        } ?>>Physically Challenged
                                                                        </option>
                                                                        <option value="Physically and Mentally Challenged"<?php if ($get_basic_data['disability'] == 'Physically and Mentally Challenged') {
                                                                            echo "selected";
                                                                        } ?>>Physically and Mentally Challenged
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Complexion :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select id="register_complexion"
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Body type :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select id="register_body_type" name="body_type"
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Eating Habit :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="diet" required>
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Drinking :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="drink" required>
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Blood Group :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="b_group"
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Smoking :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <?php $search_array12 = explode(',', $get_basic_data['smoke']);
                                                                    ?>
                                                                    <select class="form-control" name="smoke"
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Religion :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-6 p-r-0">
                                                                            <select id="register_religion_id"
                                                                                    name="religion_id"
                                                                                    class="form-control"
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
                                                                        <div class="col-xs-6"
                                                                             style="padding-left: 5px !important;">
                                                                            <select id="register_my_caste"
                                                                                    name="my_caste"
                                                                                    class="form-control"
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

                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Profile Posted
                                                                    By :
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select id="register_profile_for"
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
                                                            <div class="row">
                                                                <div class="col-md-2 hidden-xs hidden-sm">
                                                                    <p class="font-16 pt-15 pb-10"><i
                                                                                class="fa fa-user"></i>
                                                                        About myself</p>
                                                                </div>
                                                                <div class="col-xs-2 hidden-md hidden-lg">
                                                                    Myself
                                                                </div>
                                                                <div class="col-xs-10">
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                    <textarea name="profile_text" class="form-control"
                                                                              id="profile_text"><?= $get_basic_data['profile_text'] ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-12 text-center">
                                                                        <button type="submit" id="update_profile_btn"
                                                                                class="btn btn-sm mr-10 mt-30 mb-30"
                                                                                style="background-color: #005294;"
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
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="col-md-12">
                                                    <form method="POST" action="" id="education_update_form">
                                                        <div class="pt-0">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pt-15 pb-10"><i
                                                                                class="fa fa-graduation-cap"></i>
                                                                        Educational
                                                                        and Professional Detail</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Education Level:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control"
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Education Field:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control"
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Qualification:</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="chosen-select form-control"
                                                                            name="qualification[]"
                                                                            id="qualification" multiple>
                                                                        <option value="" disabled selected> Select Qualification</option>
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Occupation:</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="occupation"
                                                                            data-validetta="required">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Employed In:</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="emp_in"
                                                                            data-validetta="required">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Salary:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input
                                                                            type="text"
                                                                            class="form-control"
                                                                            name="monthly_income"
                                                                            value="<?= $get_basic_data['monthly_sal'] ?>"
                                                                            required/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Annual Income:</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="income"
                                                                            data-validetta="true">
                                                                        <option value=""> Select Annual Income</option>
                                                                        <option value="Rs 10,000 - 50,000" <?php if ($get_basic_data['income'] == 'Rs 10,000 - 50,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 10,000 - 50,000
                                                                        </option>
                                                                        <option value="Rs 50,000 - 1,00,000" <?php if ($get_basic_data['income'] == 'Rs 50,000 - 1,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 50,000 - 1,00,000
                                                                        </option>
                                                                        <option value="Rs 1,00,000 - 2,00,000" <?php if ($get_basic_data['income'] == 'Rs 1,00,000 - 2,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 1,00,000 - 2,00,000
                                                                        </option>
                                                                        <option value="Rs 2,00,000 - 5,00,000" <?php if ($get_basic_data['income'] == 'Rs 2,00,000 - 5,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 2,00,000 - 5,00,000
                                                                        </option>
                                                                        <option value="Rs 5,00,000 - 10,00,000" <?php if ($get_basic_data['income'] == 'Rs 5,00,000 - 10,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 5,00,000 - 10,00,000
                                                                        </option>
                                                                        <option value="Rs 10,00,000 - 20,00,000" <?php if ($get_basic_data['income'] == 'Rs 10,00,000 - 20,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 10,00,000 - 20,00,000
                                                                        </option>
                                                                        <option value="Rs 20,00,000 - 30,00,000" <?php if ($get_basic_data['income'] == 'Rs 20,00,000 - 30,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 20,00,000 - 30,00,000
                                                                        </option>
                                                                        <option value="Rs 30,00,000 - 50,00,000" <?php if ($get_basic_data['income'] == 'Rs 30,00,000 - 50,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 30,00,000 - 50,00,000
                                                                        </option>
                                                                        <option value="Rs 50,00,000 - 1,00,00,000" <?php if ($get_basic_data['income'] == 'Rs 50,00,000 - 1,00,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 50,00,000 -
                                                                            1,00,00,000
                                                                        </option>
                                                                        <option value="Above Rs 1,00,00,000" <?php if ($get_basic_data['income'] == 'Above Rs 1,00,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Above Rs 1,00,00,000
                                                                        </option>
                                                                        <option value="Does not matter" <?php if ($get_basic_data['income'] == 'Does not matter') {
                                                                            echo "selected";
                                                                        } ?>>Does not matter
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit"
                                                                            class="btn btn-sm mr-10 mt-30 mb-30"
                                                                            style="background-color: #005294;"
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
                                                        </div>
                                                    </form>
                                                </div>


                                                <div class="col-md-12">
                                                    <form method="post" id="contact_update_form">
                                                        <div class="pt-0">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pt-15 pb-10"><i
                                                                                class="fa fa-map-marker"></i> Residence
                                                                        Detail</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Living Status</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="living_status">
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
                                                                        <option value="As Room Mate"<?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "As Room Mate") {
                                                                            echo "selected";
                                                                        } ?>>As Room Mate
                                                                        </option>
                                                                        <option value="Myself"<?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "Myself") {
                                                                            echo "selected";
                                                                        } ?>>Myself
                                                                        </option>
                                                                        <option value="Paying Guest"<?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "Paying Guest") {
                                                                            echo "selected";
                                                                        } ?>>Paying Guest
                                                                        </option>
                                                                        <option value="In Hostel"<?php if (htmlspecialchars_decode($get_basic_data['living_status'], ENT_QUOTES) == "In Hostel") {
                                                                            echo "selected";
                                                                        } ?>>In Hostel
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">House Status
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="house_ownership"
                                                                            id="">
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
                                                            <div class="row">

                                                                <div class="col-xs-5 col-md-2 mb-7">Residence:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="residence">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Country</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="country" id=""
                                                                            required>
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">State</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="state" id=""
                                                                            required>
                                                                        <option value=""> Select State</option>
                                                                        <?php
                                                                        $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("SELECT * FROM state_view WHERE status='APPROVED' ORDER BY state_name ASC");

                                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                                                            ?>
                                                                            <option value="<?php echo $DatabaseCo->dbRow->state_id; ?>" <?php if ($get_basic_data['state_id'] == $DatabaseCo->dbRow->state_id) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $DatabaseCo->dbRow->state_name ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">City</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="city" id=""
                                                                            data-validetta="required">

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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Mobile No:</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="text" class="form-control"
                                                                           name="mobile_no"
                                                                           id="mobileNoUser"
                                                                           maxlength="13"
                                                                           value="<?php echo $get_basic_data['mobile']; ?>"/>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Email ID</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="text" class="form-control"
                                                                           name="email_id"
                                                                           value="<?php echo $get_basic_data['email']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Phone</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="text" class="form-control" name="phone" maxlength="13"
                                                                           value="<?php echo $get_basic_data['phone']; ?>"/>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Time to Call</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="text" class="form-control"
                                                                           name="time_to_call"
                                                                           value="<?php echo $get_basic_data['time_to_call']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Contact Visibility
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control"
                                                                            name="contact_visibility">
                                                                        <option value="1" <?php if ($get_basic_data['contact_view_security'] == '1') {
                                                                            echo "selected";
                                                                        } ?>>Show to all paid members
                                                                        </option>
                                                                        <option value="0" <?php if ($get_basic_data['contact_view_security'] == '0') {
                                                                            echo "selected";
                                                                        } ?>>Show to only express interest accepted and
                                                                            paid members.
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit"
                                                                            class="btn btn-sm mr-10 mt-30 mb-30"
                                                                            style="background-color: #005294;"
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
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--<div id="education_8" class="tab-pane fade" role="tabpanel">
                                            </div>-->
                                            <!--<div id="contact_8" class="tab-pane fade" role="tabpanel">
                                            </div>-->
                                            <div id="follo_8" class="tab-pane fade" role="tabpanel">
                                                <div class="col-md-12">
                                                    <form method="post" action="#" id="family_update_form">
                                                        <div class="pt-20">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pb-10"><i
                                                                                class="fa fa-users"></i> About My Family
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Family Origin</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select name="family_origin" id=""
                                                                            class="form-control ">
                                                                        <option value="">Please Select City</option>
                                                                        <?php
                                                                        $query = "select * from city where status='APPROVED' ORDER BY city_name ASC";
                                                                        $result = $DatabaseCo->dbLink->query($query);
                                                                        while ($a = mysqli_fetch_array($result)) { ?>
                                                                            <option value="<?php echo $a['city_id'] ?>" <?php if ($get_basic_data['family_origin'] == $a['city_id']) { ?> selected="selected" <?php } ?>><?php echo $a['city_name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Family Type</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="family_type">
                                                                        <option value="">Select Family Type</option>
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Family Status</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="family_status">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Family Values</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control " name="family_value">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Father
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select name="father_ocp" id="" class="form-control"
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Mother
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select name="mother_ocp" id=""
                                                                            class="form-control "
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">No. of Brothers
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="no_of_brother">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">No. of Sisters</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="no_of_sister">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Married Brother
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="nmb">
                                                                        <option value="No married brother" <?php if ($get_basic_data['no_marri_brother'] == "No married brother") { ?> selected="selected"<?php } ?>>
                                                                            No married brother
                                                                        </option>
                                                                        <option value="One married brother" <?php if ($get_basic_data['no_marri_brother'] == "One married brother") { ?> selected="selected"<?php } ?>>
                                                                            One married brother
                                                                        </option>
                                                                        <option value="Two married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Two married brothers") { ?> selected="selected"<?php } ?>>
                                                                            Two married brothers
                                                                        </option>
                                                                        <option value="Three married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Three married brothers") { ?> selected="selected"<?php } ?>>
                                                                            Three married brothers
                                                                        </option>
                                                                        <option value="Four married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Four married brothers") { ?> selected="selected"<?php } ?>>
                                                                            Four married brothers
                                                                        </option>
                                                                        <option value="Above four married brothers" <?php if ($get_basic_data['no_marri_brother'] == "Above four married brothers") { ?> selected="selected"<?php } ?>>
                                                                            Above four married brothers
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Married Sister</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="nms">
                                                                        <option value="No married sister" <?php if ($get_basic_data['no_marri_sister'] == "No married sister") { ?> selected="selected"<?php } ?>>
                                                                            No married sister
                                                                        </option>
                                                                        <option value="One married sister" <?php if ($get_basic_data['no_marri_sister'] == "One married sister") { ?> selected="selected"<?php } ?>>
                                                                            One married sister
                                                                        </option>
                                                                        <option value="Two married sister" <?php if ($get_basic_data['no_marri_sister'] == "Two married sister") { ?> selected="selected"<?php } ?>>
                                                                            Two married sister
                                                                        </option>
                                                                        <option value="Three married sister" <?php if ($get_basic_data['no_marri_sister'] == "Three married sister") { ?> selected="selected"<?php } ?>>
                                                                            Three married sister
                                                                        </option>
                                                                        <option value="Four married sister" <?php if ($get_basic_data['no_marri_sister'] == "Four married sister") { ?> selected="selected"<?php } ?>>
                                                                            Four married sister
                                                                        </option>
                                                                        <option value="Above four married sister" <?php if ($get_basic_data['no_marri_sister'] == "Above four married sister") { ?> selected="selected"<?php } ?>>
                                                                            Above four married sister
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">About My Family
                                                                </div>
                                                                <div class="col-xs-7 col-md-10 mb-7">
                                                            <textarea class="form-control" cols="5"
                                                                      name="about_my_family"
                                                                      placeholder="Define About Family"><?php if ($get_basic_data['family_details'] != 'Not Available') {
                                                                    echo htmlspecialchars_decode($get_basic_data['family_details'], ENT_QUOTES);
                                                                } ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit"
                                                                            class="btn btn-sm mr-10 mt-30 mb-30"
                                                                            style="background-color: #005294;"
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
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="earnings_8" class="tab-pane fade" role="tabpanel">
                                                <div class="col-md-12">
                                                    <form method="post" action="#" id="partner_update_form">
                                                        <div class="pt-20 pb-10">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pb-10"><i
                                                                                class="fa fa-newspaper-o"></i> Basic
                                                                        Information
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Looking For</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="chosen-select form-control"
                                                                            name="part_m_status[]"
                                                                            data-validetta="required" multiple>
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Mothertongue</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Mother Tongue"
                                                                            class="chosen-select form-control"
                                                                            name="part_m_tongue[]"
                                                                            multiple tabindex="4"
                                                                            data-validetta="required">
                                                                        <option value=""></option>
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Age :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-6 p-r-0">
                                                                            <select class="form-control"
                                                                                    name="part_from_age"
                                                                                    data-validetta="required">
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
                                                                        <div class="col-xs-6"
                                                                             style="padding-left: 5px !important;">
                                                                            <select class="form-control"
                                                                                    name="part_to_age"
                                                                                    data-validetta="required">
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
                                                                    </div>

                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Height :</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-6 p-r-0">
                                                                            <select class="form-control"
                                                                                    name="part_from_height">
                                                                                <option value="<?php echo $get_basic_data['part_height']; ?>"><?php $ao = $get_basic_data['part_height'];
                                                                                    $ft = (int)($ao / 12);
                                                                                    $inch = $ao % 12;
                                                                                    echo $ft . "ft" . " " . $inch . "in"; ?></option>
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
                                                                        <div class="col-xs-6"
                                                                             style="padding-left: 5px !important;">
                                                                            <select class="form-control"
                                                                                    name="part_to_height">

                                                                                <option value="<?php echo $get_basic_data['part_height_to']; ?>"><?php $ao = $get_basic_data['part_height_to'];
                                                                                    $ft = (int)($ao / 12);
                                                                                    $inch = $ao % 12;
                                                                                    echo $ft . "ft" . " " . $inch . "in"; ?></option>
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

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7"> Body Type</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Body Type"
                                                                            class="chosen-select form-control"
                                                                            name="part_bodytype[]"
                                                                            multiple tabindex="4">
                                                                        <?php
                                                                        $get_partbodytype = explode(", ", $get_basic_data['part_bodytype']);
                                                                        ?>
                                                                        <option value="Slim" <?php if (in_array("Slim", $get_partbodytype)) {
                                                                            echo "selected";
                                                                        } ?>>Slim
                                                                        </option>
                                                                        <option value="Average"<?php if (in_array("Average", $get_partbodytype)) {
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Eating Habit</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Eating Habit"
                                                                            class="chosen-select form-control"
                                                                            name="part_diet[]" multiple>
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
                                                                        <option value="Eggetarian"<?php if (in_array("Eggetarian", $get_partdiet)) {
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Smoking Habit</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Smoking Habit"
                                                                            class="chosen-select form-control"
                                                                            name="part_smoke[]" multiple
                                                                            tabindex="4">
                                                                        <?php
                                                                        $get_partsmoke = explode(", ", $get_basic_data['part_smoke']);
                                                                        ?>

                                                                        <option value="No" <?php if (in_array("No", $get_partsmoke)) {
                                                                            echo "selected";
                                                                        } ?>>No
                                                                        </option>
                                                                        <option value="Yes" <?php if (in_array("Yes", $get_partsmoke)) {
                                                                            echo "selected";
                                                                        } ?>>Yes
                                                                        </option>
                                                                        <option value="Occasionally" <?php if (in_array("Occasionally", $get_partsmoke)) {
                                                                            echo "selected";
                                                                        } ?>>Occasionally
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Drinking Habit</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Drinking Habit"
                                                                            class="chosen-select form-control"
                                                                            name="part_drink[]" multiple
                                                                            tabindex="4">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Religion</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Religion"
                                                                            class="chosen-select form-control"
                                                                            id="part_religion"
                                                                            name="part_religion[]" multiple
                                                                            tabindex="4">
                                                                        <?php
                                                                        $get_part_relg = $get_basic_data['part_religion'];
                                                                        $arr_part_relg = explode(",", $get_part_relg);
                                                                        $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT religion_id, religion_name FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                                            ?>
                                                                            <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"
                                                                                <?php if (!empty($arr_part_relg) && in_array($DatabaseCo->dbRow->religion_id, $arr_part_relg)) {
                                                                                    echo "selected";
                                                                                } else if($DatabaseCo->dbRow->religion_id == 7) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Caste</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Caste"
                                                                            class="chosen-select form-control"
                                                                            name="part_caste[]"
                                                                            id="part_caste" multiple tabindex="4">
                                                                        <?php
                                                                        $get_part_caste = $get_basic_data['part_caste'];
                                                                        $arr_part_catse = explode(",", $get_part_caste);
                                                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT DISTINCT caste_id,caste_name FROM caste ORDER BY caste_name ASC");
                                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                                            ?>
                                                                            <option value="<?php echo $DatabaseCo->dbRow->caste_id; ?>" <?php if ($arr_part_catse != '') {
                                                                                if (!empty($arr_part_catse) && in_array($DatabaseCo->dbRow->caste_id, $arr_part_catse)) {
                                                                                    echo "selected";
                                                                                } else if($DatabaseCo->dbRow->caste_id == 227) {
                                                                                    echo "selected";
                                                                                }
                                                                            } ?>><?php echo $DatabaseCo->dbRow->caste_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Manglik</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="part_manglik"
                                                                            id="part_manglik">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Complexion</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <?php
                                                                    $get_parttone = explode(", ", $get_basic_data['part_complexion']);
                                                                    ?>
                                                                    <select data-placeholder="Choose Partner Complexion"
                                                                            class="chosen-select form-control"
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Expectations</div>
                                                                <div class="col-xs-7 col-md-10 mb-7">
                                                                <textarea class="form-control" cols="5"
                                                                          name="expectation"><?php echo htmlspecialchars_decode($get_basic_data['part_expect'], ENT_QUOTES); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pb-10">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pb-10"><i
                                                                                class="fa fa-graduation-cap"></i>
                                                                        Educational
                                                                        and Professional Detail</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Education Field
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="chosen-select  form-control" multiple
                                                                            name="part_edu_field[]" id="part_edu_field">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Qualification</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="chosen-select  form-control" multiple
                                                                            name="part_education[]" id="part_education">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Employed in</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Employed in"
                                                                            class="chosen-select form-control"
                                                                            name="part_emp_in[]"
                                                                            id="part_emp_in" multiple tabindex="4">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">Occupation</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Occupation"
                                                                            class="chosen-select form-control"
                                                                            name="part_occupation[]"
                                                                            id="part_occupation" multiple tabindex="4">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Annual Income</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control"
                                                                            name="part_income" id="part_income">
                                                                        <option value="">Select Annual Income</option>
                                                                        <option value="Rs 10,000 - 50,000" <?php if ($get_basic_data['part_income'] == 'Rs 10,000 - 50,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 10,000 - 50,000
                                                                        </option>
                                                                        <option value="Rs 50,000 - 1,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 50,000 - 1,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 50,000 - 1,00,000
                                                                        </option>
                                                                        <option value="Rs 1,00,000 - 2,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 1,00,000 - 2,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 1,00,000 - 2,00,000
                                                                        </option>
                                                                        <option value="Rs 2,00,000 - 5,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 2,00,000 - 5,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 2,00,000 - 5,00,000
                                                                        </option>
                                                                        <option value="Rs 5,00,000 - 10,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 5,00,000 - 10,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 5,00,000 - 10,00,000
                                                                        </option>
                                                                        <option value="Rs 10,00,000 - 20,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 10,00,000 - 20,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 10,00,000 - 20,00,000
                                                                        </option>
                                                                        <option value="Rs 20,00,000 - 30,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 20,00,000 - 30,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 20,00,000 - 30,00,000
                                                                        </option>
                                                                        <option value="Rs 30,00,000 - 50,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 30,00,000 - 50,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 30,00,000 - 50,00,000
                                                                        </option>
                                                                        <option value="Rs 50,00,000 - 1,00,00,000" <?php if ($get_basic_data['part_income'] == 'Rs 50,00,000 - 1,00,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Rs 50,00,000 - 1,00,00,000
                                                                        </option>
                                                                        <option value="Above Rs 1,00,00,000" <?php if ($get_basic_data['part_income'] == 'Above Rs 1,00,00,000') {
                                                                            echo "selected";
                                                                        } ?>>Above Rs 1,00,00,000
                                                                        </option>
                                                                        <option value="Does not matter">Does not matter
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" pb-10">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <p class="font-16 pb-15"><i
                                                                                class="fa fa-map-marker"></i>
                                                                        Partner Residence</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Country</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select name="part_country[]" id="part_country"
                                                                            data-placeholder="Choose Partner Country"
                                                                            class="chosen-select form-control" multiple
                                                                            tabindex="4">
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
                                                                <div class="col-xs-5 col-md-2 mb-7">State</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner State"
                                                                            class="chosen-select form-control"
                                                                            name="part_state[]"
                                                                            id="part_state" multiple tabindex="4">
                                                                        <?php
                                                                        $get_part_state = $get_basic_data['part_state'];
                                                                        $arr_part_state = explode(",", $get_part_state);

                                                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT state_id,state_name FROM state_view ORDER BY state_name ASC");
                                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>

                                                                            <option value="<?php echo $DatabaseCo->dbRow->state_id; ?>" <?php if ($get_part_state != '') {
                                                                                if (in_array($DatabaseCo->dbRow->state_id, $arr_part_state)) {
                                                                                    echo "selected";
                                                                                }
                                                                            } ?> ><?php echo $DatabaseCo->dbRow->state_name; ?></option>
                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">City</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner City"
                                                                            name="part_city[]"
                                                                            id="part_city"
                                                                            class="chosen-select form-control"
                                                                            multiple
                                                                            tabindex="4">
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
                                                                            } ?> ><?php echo $DatabaseCo->dbRow->city_name ?></option>

                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-5 col-md-2 mb-7">Residence Status
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select class="form-control" name="part_residence[]"
                                                                            tabindex="4">
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
                                                            <div class="row">
                                                                <div class="col-xs-5 col-md-2 mb-7">Native Place</div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <select data-placeholder="Choose Partner Native Place"
                                                                            name="part_native_place[]"
                                                                            id="part_native_place"
                                                                            class="chosen-select form-control"
                                                                            multiple
                                                                            tabindex="4">
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
                                                                            } ?> ><?php echo $DatabaseCo->dbRow->city_name ?></option>

                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit"
                                                                            class="btn btn-sm mr-10 mt-30 mb-30"
                                                                            style="background-color: #005294;"
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
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                            <div id="photos_8" class="tab-pane fade" role="tabpanel">
                                                <div class="col-md-12 pb-20">
                                                    <div class="gallery-wrap">
                                                        <div class="portfolio-wrap project-gallery">
                                                            <ul id="portfolio_1"
                                                                class="portf auto-construct  project-gallery"
                                                                data-col="4">
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock1.jpg"
                                                                    data-sub-html="<h6>Bagwati</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock1.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Bagwati</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock2.jpg"
                                                                    data-sub-html="<h6>Not a Keyboard</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock2.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Not a Keyboard</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock3.jpg"
                                                                    data-sub-html="<h6>Into the Woods</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock3.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Into the Woods</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock4.jpg"
                                                                    data-sub-html="<h6>Ultra Saffire</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock4.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap"> Ultra Saffire</span>
                                                                    </a>
                                                                </li>

                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock5.jpg"
                                                                    data-sub-html="<h6>Happy Puppy</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock5.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Happy Puppy</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock6.jpg"
                                                                    data-sub-html="<h6>Wooden Closet</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock6.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Wooden Closet</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock7.jpg"
                                                                    data-sub-html="<h6>Happy Puppy</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock7.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Happy Puppy</span>
                                                                    </a>
                                                                </li>
                                                                <li class="item"
                                                                    data-src="view_profile_res/img/gallery/equal-size/mock8.jpg"
                                                                    data-sub-html="<h6>Wooden Closet</h6><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>">
                                                                    <a href="">
                                                                        <img class="img-responsive"
                                                                             src="view_profile_res/img/gallery/equal-size/mock8.jpg"
                                                                             alt="Image description"/>
                                                                        <span class="hover-cap">Wooden Closet</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="delete_profile" class="tab-pane fade" role="tabpanel">
                                                <div class="col-md-12">
                                                    <div class="pt-20">
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <p class="font-16 pt-15 pb-10"><i
                                                                            class="fa fa-user-times"></i> Delete Profile
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Name:
                                                            </div>
                                                            <div class="col-xs-7 col-md-4 mb-7">
                                                                <?= $_SESSION['uname'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Matri
                                                                ID:
                                                            </div>
                                                            <div class="col-xs-7 col-md-4 mb-7">
                                                                <?= $_SESSION['user_id'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Email:
                                                            </div>
                                                            <div class="col-xs-7 col-md-4 mb-7">
                                                                <?= $_SESSION['email'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Phone:
                                                            </div>
                                                            <div class="col-xs-7 col-md-4 mb-7">
                                                                <?= $_SESSION['mobile'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Reason
                                                                to
                                                                Delete:
                                                            </div>
                                                            <div class="col-xs-7 col-md-4 mb-7">
                                                            <textarea class="form-control border-radius-5px"
                                                                      placeholder="Enter Your Message Here" id="message"
                                                                      name="message"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <button type="button"
                                                                        class="btn btn-sm btn-danger mr-10 mt-20 mb-30"
                                                                        name="delete_profile">Delete Profile
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="change_password" class="tab-pane fade" role="tabpanel">
                                                <div class="col-md-12">
                                                    <div class="pt-20">
                                                        <form method="post" id="change_password_form">
                                                            <h6 id="response_change_password"
                                                                class="text-center text-danger"></h6>
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <p class="font-16 pt-15 pb-10"><i
                                                                                class="fa fa-shield"></i> Change
                                                                        Password
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Old
                                                                    Password:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="password" class="form-control"
                                                                           id="old_pass"
                                                                           name="old_pass" data-validetta="required">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">New
                                                                    Password:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="password" class="form-control"
                                                                           id="new_pass"
                                                                           name="new_pass" data-validetta="required">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">
                                                                    Confirm
                                                                    Password:
                                                                </div>
                                                                <div class="col-xs-7 col-md-4 mb-7">
                                                                    <input type="password" class="form-control"
                                                                           id="cnfm_pass"
                                                                           name="cnfm_pass" data-validetta="required">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 text-center">
                                                                    <button type="submit"
                                                                            style="background-color: #005294;"
                                                                            class="btn btn-sm mr-10 mt-30 mb-30"
                                                                            name="change_password">Change Password
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- /Row -->

            </div>

        </div>
        <!-- /Main Content -->

    </div>
</div>

<!-- /#wrapper -->

<!-- JavaScript -->

<!-- jQuery -->
<script src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Vector Maps JavaScript -->
<script src="view_profile_res/vendors/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="view_profile_res/vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="view_profile_res/dist/js/vectormap-data.js"></script>

<!-- Calender JavaScripts -->
<script src="view_profile_res/vendors/bower_components/moment/min/moment.min.js"></script>
<script src="view_profile_res/vendors/jquery-ui.min.js"></script>
<script src="view_profile_res/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="view_profile_res/dist/js/fullcalendar-data.js"></script>

<!-- Counter Animation JavaScript -->
<script src="view_profile_res/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="view_profile_res/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>

<!-- Data table JavaScript -->
<script src="view_profile_res/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>

<!-- Slimscroll JavaScript -->
<script src="view_profile_res/dist/js/jquery.slimscroll.js"></script>

<!-- Fancy Dropdown JS -->
<script src="view_profile_res/dist/js/dropdown-bootstrap-extended.js"></script>

<!-- Sparkline JavaScript -->
<script src="view_profile_res/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>

<script src="view_profile_res/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="view_profile_res/dist/js/skills-counter-data.js"></script>

<!-- Morris Charts JavaScript -->
<script src="view_profile_res/vendors/bower_components/raphael/raphael.min.js"></script>
<script src="view_profile_res/vendors/bower_components/morris.js/morris.min.js"></script>
<script src="view_profile_res/dist/js/morris-data.js"></script>

<!-- Owl JavaScript -->
<script src="view_profile_res/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

<!-- Switchery JavaScript -->
<script src="view_profile_res/vendors/bower_components/switchery/dist/switchery.min.js"></script>

<!-- Data table JavaScript -->
<script src="view_profile_res/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>

<!-- Select  2 -->
<!--<script src="view_profile_res/vendors/bower_components/select2/dist/js/select2.min.js"></script>-->
<script src="js/chosen.jquery.js"></script>

<!-- Gallery JavaScript -->
<script src="view_profile_res/dist/js/isotope.js"></script>
<script src="view_profile_res/dist/js/lightgallery-all.js"></script>
<script src="view_profile_res/dist/js/froogaloop2.min.js"></script>
<script src="view_profile_res/dist/js/gallery-data.js"></script>


<!-- Init JavaScript -->
<script src="view_profile_res/dist/js/init.js"></script>
<script src="view_profile_res/dist/js/widgets-data.js"></script>
<script type="text/javascript">
    var numDays = {
        '01': 31, '02': 28, '03': 31, '04': 30, '05': 31, '06': 30,
        '07': 31, '08': 31, '09': 30, '10': 31, '11': 30, '12': 31
    };

    function setDays(oMonthSel, oDaysSel, oYearSel) {
        var nDays, oDaysSelLgth, opt, i = 1;
        nDays = numDays[oMonthSel[oMonthSel.selectedIndex].value];
        if (nDays == 28 && oYearSel[oYearSel.selectedIndex].value % 4 == 0)
            ++nDays;
        oDaysSelLgth = oDaysSel.length;
        if (nDays != oDaysSelLgth) {
            if (nDays < oDaysSelLgth)
                oDaysSel.length = nDays;
            else for (i; i < nDays - oDaysSelLgth + 1; i++) {
                opt = new Option(oDaysSelLgth + i, oDaysSelLgth + i);
                oDaysSel.options[oDaysSel.length] = opt;
            }
        }
        var oForm = oMonthSel.form;
        var month = oMonthSel.options[oMonthSel.selectedIndex].value;
        var day = oDaysSel.options[oDaysSel.selectedIndex].value;
        var year = oYearSel.options[oYearSel.selectedIndex].value;


        //oForm.datepicker.value = year + '-' + month + '-' + day;
    }

    function GetCaste(url) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#CasteDiv").html(data);
                $("#register_my_caste").html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

    /*$(function () {
     $(".chosen-select").select2({
     width: 'resolve'
     });
     });*/

</script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "100%"},
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
<script type="text/javascript">
    function resizeIframe(iframe) {
        iframe.style.height = (iframe.contentWindow.document.body.scrollHeight+300) + "px";
    }
</script>
</body>
</html>
