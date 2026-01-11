<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/17/2018
 * Time: 11:47 PM
 */

include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();

$sqlData = "select * from express_interest_privacy_details where matri_id='" . $_SESSION['user_id'] . "' LIMIT 1";
$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlData);
$dataResult = mysqli_fetch_object($DatabaseCo->dbResult);
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title>Samyakmatrimony</title>
    <meta name="description"
          content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- CSS Cores and Plugins -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
    <link href="css/animate.css" rel="stylesheet">
    <link href="<?= auto_version("css/main.css") ?>" rel="stylesheet">
    <link href="css/component.css" rel="stylesheet">

    <!-- CSS Font Icons -->
    <link rel="stylesheet" href="icons/open-iconic/font/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="icons/rivolicons/style.css">
    <link rel="stylesheet" href="icons/streamline-outline/flaticon-streamline-outline.css">
    <link rel="stylesheet" href="icons/around-the-world-icons/around-the-world-icons.css">
    <link rel="stylesheet" href="icons/et-line-font/style.css">

    <!-- CSS Custom -->
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">

    <!-- Add your style -->
    <link href="css/your-style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/select2.min.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            /*border:1px solid #aaa;*/
            border-radius: 0px;
            cursor: text;
            margin-bottom: 3px;
            overflow: hidden !important;
            height: auto !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0 5px;
            width: 100%;
            overflow: hidden !important;
            height: auto !important;
        }

        .select2-search__field {
            width: 100% !important;
        }
    </style>
</head>

<body class="not-home" style="overflow-x: hidden;">

<?php @include_once 'page-parts/modal.php' ?>
<!-- start Container Wrapper -->
<div class="container-wrapper colored-navbar-brand">

    <!-- start Header -->
    <?php @include_once 'layouts/menu.php' ?>
    <!-- end Header -->

    <div class="clear"></div>

    <!-- start Main Wrapper -->
    <div class="main-wrapper">

        <div class="sub-menu-content">
            <div class="new-sub-menu">
                <div class="sub-menu-list">
                    <a href="homepage">Dashboard</a> |
                    <a href="my-matches"> My Matches</a> |
                    <a href="search">Search</a> |
                    <a href="settings">Settings</a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-wrapper hidden-sm hidden-xs hidden-xss">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="homepage">Dashboard</a></li>
                            <li class="active"><a href="express-interest-privacy">Express Interest Privacy</a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-sm-4 hidden-xs">
                        <p class="hot-line"><i class="fa fa-phone"></i> <a href="tel:+91-79779-93616"> Help Line:
                                +91-79779-93616</a></p>
                    </div>
                </div>

            </div>

        </div>
        <div class="clear"></div>

        <div class="equal-content-sidebar-by-gridLex">

            <div class="container">

                <div class="GridLex-grid-noGutter-equalHeight">

                    <div class="GridLex-col-3_sm-4_xs-12_xss-12 hidden-sm hidden-xs hidden-xss">

                        <?php @include_once 'layouts/sidebar.php' ?>

                    </div>

                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">

                        <div class="content-wrapper">

                            <div class="row">

                                <div class="col-xs-12">

                                    <div class="dashboard-content">
                                        <div class="row">
                                            <div class="col-xs-12 col-xss-12">
                                                <div class="dashboard-heading">
                                                    <h6 class="text-center" style="font-weight: bold;">
                                                        Interest Received / View Contact Privacy Setting <br/>
                                                        <small>(Who can send me interest and see my contact
                                                            details?)</small>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <form class="express_interest_privacy" name="express_interest_privacy" method="POST"
                                  id="express-interest-privacy">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label style="font-weight: bold;">Please check a privacy type</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 pl-25">
                                        <label class="checkbox-inline check">
                                            <input name="privacy_type" type="checkbox" class="privacy_type"
                                                   value="anyone"
                                                   onchange="showHideForm(this);"
                                                   checked
                                                   id="privacy_type_anyone"
                                                   style="display: block;opacity: 1;margin-left: 0px;position: relative;">
                                            Anyone can send me interest and see my contact details
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-xs-12 col-sm-12 pl-25">
                                        <label class="checkbox-inline check">
                                            <input name="privacy_type" type="checkbox" value="restrict"
                                                   onchange="showHideForm(this);" class="privacy_type"
                                                   id="privacy_type_restrict"
                                                   style="display: block;opacity: 1;margin-left: 0px;position: relative;">
                                            Receive express interest and my contact details viewing limited to
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div style="padding: 10px;background: rgba(0, 0, 0, .7);color:rgba(255, 255, 255, 1);">

                                            <div class="row user_based_criteria" id="user_based_criteria">
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label for="m_status_quick_search">Looking For</label>
                                                        <select class="chosen-select form-control mb-5"
                                                                name="m_status[]"
                                                                id="m_status_quick_search"
                                                                data-placeholder=" Select Marital Status"
                                                                multiple>
                                                            <?php $get_looking = explode(",", $dataResult->looking_for); ?>
                                                            <option value="Unmarried"<?php if (in_array("Unmarried", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Unmarried</option>
                                                            <option value="Widow/Widower" <?php if (in_array("Widow/Widower", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Widow/Widower</option>
                                                            <option value="Divorcee" <?php if (in_array("Divorcee", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Divorcee</option>
                                                            <option value="Separated" <?php if (in_array("Separated", $get_looking)) {
                                                                echo "selected";
                                                            } ?>>Separated</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label for="search_religion_quick_search">Religion</label>
                                                        <select name="religion[]"
                                                                class="chosen-select form-control mb-5"
                                                                data-placeholder=" Select Religion"
                                                                id="search_religion_quick_search"
                                                                multiple>
                                                            <?php
                                                            $getReligion = explode(",", $dataResult->religion);
                                                            $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                                ?>
                                                                <option value="<?= $DatabaseCo->dbRow->religion_id; ?>" <?php if (in_array($DatabaseCo->dbRow->religion_id, $getReligion)) {
                                                                    echo "selected";
                                                                } ?>>
                                                                    <?= $DatabaseCo->dbRow->religion_name; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                                                <label for="">Age From</label>
                                                                <select title="from age" name="frm_age"
                                                                        class="form-control mb-5">
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
                                                                    <option value="32">32</option>
                                                                    <option value="33">33</option>
                                                                    <option value="34">34</option>
                                                                    <option value="35">35</option>
                                                                    <option value="36">36</option>
                                                                    <option value="37">37</option>
                                                                    <option value="38">38</option>
                                                                    <option value="39">39</option>
                                                                    <option value="40">40</option>
                                                                    <option value="41">41</option>
                                                                    <option value="42">41</option>
                                                                    <option value="43">43</option>
                                                                    <option value="44">44</option>
                                                                    <option value="45">45</option>
                                                                    <option value="46">46</option>
                                                                    <option value="47">47</option>
                                                                    <option value="48">48</option>
                                                                    <option value="49">49</option>
                                                                    <option value="50">50</option>
                                                                    <option value="51">51</option>
                                                                    <option value="52">52</option>
                                                                    <option value="53">53</option>
                                                                    <option value="54">54</option>
                                                                    <option value="55">55</option>
                                                                    <option value="56">56</option>
                                                                    <option value="57">57</option>
                                                                    <option value="58">58</option>
                                                                    <option value="59">59</option>
                                                                    <option value="60">60</option>
                                                                    <?php if(!empty($dataResult->age_from)) { ?>
                                                                        <option value="<?= $dataResult->age_from ?>" selected><?= $dataResult->age_from ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                                                <label for="">Age To</label>
                                                                <select title="to age" name="to_age"
                                                                        class="form-control mb-5">
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
                                                                    <option value="32">32</option>
                                                                    <option value="33">33</option>
                                                                    <option value="34">34</option>
                                                                    <option value="35">35</option>
                                                                    <option value="36">36</option>
                                                                    <option value="37">37</option>
                                                                    <option value="38">38</option>
                                                                    <option value="39">39</option>
                                                                    <option value="40">40</option>
                                                                    <option value="41">41</option>
                                                                    <option value="42">41</option>
                                                                    <option value="43">43</option>
                                                                    <option value="44">44</option>
                                                                    <option value="45" selected>45</option>
                                                                    <option value="46">46</option>
                                                                    <option value="47">47</option>
                                                                    <option value="48">48</option>
                                                                    <option value="49">49</option>
                                                                    <option value="50">50</option>
                                                                    <option value="51">51</option>
                                                                    <option value="52">52</option>
                                                                    <option value="53">53</option>
                                                                    <option value="54">54</option>
                                                                    <option value="55">55</option>
                                                                    <option value="56">56</option>
                                                                    <option value="57">57</option>
                                                                    <option value="58">58</option>
                                                                    <option value="59">59</option>
                                                                    <option value="60">60</option>
                                                                    <?php if(!empty($dataResult->age_to)) { ?>
                                                                        <option value="<?= $dataResult->age_to ?>" selected><?= $dataResult->age_to ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                                                <label>Height From</label>
                                                                <select title="from height"
                                                                        class="form-control mb-5"
                                                                        name="from_height">
                                                                    <option value="48" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 48 ? "selected" : "") : "" ?>>4ft less</option>
                                                                    <option value="54" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 54 ? "selected" : "") : "" ?>>4ft 06in</option>
                                                                    <option value="55" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 55 ? "selected" : "") : "" ?>>4ft 07in</option>
                                                                    <option value="56" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 56 ? "selected" : "") : "" ?>>4ft 08in</option>
                                                                    <option value="57" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 57 ? "selected" : "") : "" ?>>4ft 09in</option>
                                                                    <option value="58" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 58 ? "selected" : "") : "" ?>>4ft 10in</option>
                                                                    <option value="59" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 59 ? "selected" : "") : "" ?>>4ft 11in</option>
                                                                    <option value="60" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 60 ? "selected" : "") : "" ?>>5ft</option>
                                                                    <option value="61" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 61 ? "selected" : "") : "" ?>>5ft 01in</option>
                                                                    <option value="62" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 62 ? "selected" : "") : "" ?>>5ft 02in</option>
                                                                    <option value="63" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 63 ? "selected" : "") : "" ?>>5ft 03in</option>
                                                                    <option value="64" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 64 ? "selected" : "") : "" ?>>5ft 04in</option>
                                                                    <option value="65" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 65 ? "selected" : "") : "" ?>>5ft 05in</option>
                                                                    <option value="66" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 66 ? "selected" : "") : "" ?>>5ft 06in</option>
                                                                    <option value="67" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 67 ? "selected" : "") : "" ?>>5ft 07in</option>
                                                                    <option value="68" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 68 ? "selected" : "") : "" ?>>5ft 08in</option>
                                                                    <option value="69" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 69 ? "selected" : "") : "" ?>>5ft 09in</option>
                                                                    <option value="70" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 70 ? "selected" : "") : "" ?>>5ft 10in</option>
                                                                    <option value="71" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 71 ? "selected" : "") : "" ?>>5ft 11in</option>
                                                                    <option value="72" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 72 ? "selected" : "") : "" ?>>6ft</option>
                                                                    <option value="73" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 73 ? "selected" : "") : "" ?>>6ft 01in</option>
                                                                    <option value="74" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 74 ? "selected" : "") : "" ?>>6ft 02in</option>
                                                                    <option value="75" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 75 ? "selected" : "") : "" ?>>6ft 03in</option>
                                                                    <option value="76" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 76 ? "selected" : "") : "" ?>>6ft 04in</option>
                                                                    <option value="77" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 77 ? "selected" : "") : "" ?>>6ft 05in</option>
                                                                    <option value="78" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 78 ? "selected" : "") : "" ?>>6ft 06in</option>
                                                                    <option value="79" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 79 ? "selected" : "") : "" ?>>6ft 07in</option>
                                                                    <option value="80" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 80 ? "selected" : "") : "" ?>>6ft 08in</option>
                                                                    <option value="81" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 81 ? "selected" : "") : "" ?>>6ft 09in</option>
                                                                    <option value="82" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 82 ? "selected" : "") : "" ?>>6ft 10in</option>
                                                                    <option value="83" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 83 ? "selected" : "") : "" ?>>6ft 11in</option>
                                                                    <option value="84" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 84 ? "selected" : "") : "" ?>>7ft</option>
                                                                    <option value="85" <?= !empty($dataResult->height_from) ? ($dataResult->height_from == 85 ? "selected" : "") : "" ?>>Above 7ft</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                                                <label>Height To</label>
                                                                <select title="to height" class="form-control mb-5"
                                                                        name="height_to"
                                                                        id="height_to">
                                                                    <option value="48" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 48 ? "selected" : "") : "" ?>>4ft less</option>
                                                                    <option value="54" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 54 ? "selected" : "") : "" ?>>4ft 06in</option>
                                                                    <option value="55" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 55 ? "selected" : "") : "" ?>>4ft 07in</option>
                                                                    <option value="56" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 56 ? "selected" : "") : "" ?>>4ft 08in</option>
                                                                    <option value="57" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 57 ? "selected" : "") : "" ?>>4ft 09in</option>
                                                                    <option value="58" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 58 ? "selected" : "") : "" ?>>4ft 10in</option>
                                                                    <option value="59" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 59 ? "selected" : "") : "" ?>>4ft 11in</option>
                                                                    <option value="60" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 60 ? "selected" : "") : "" ?>>5ft</option>
                                                                    <option value="61" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 61 ? "selected" : "") : "" ?>>5ft 01in</option>
                                                                    <option value="62" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 62 ? "selected" : "") : "" ?>>5ft 02in</option>
                                                                    <option value="63" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 63 ? "selected" : "") : "" ?>>5ft 03in</option>
                                                                    <option value="64" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 64 ? "selected" : "") : "" ?>>5ft 04in</option>
                                                                    <option value="65" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 65 ? "selected" : "") : "" ?>>5ft 05in</option>
                                                                    <option value="66" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 66 ? "selected" : "") : "" ?>>5ft 06in</option>
                                                                    <option value="67" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 67 ? "selected" : "") : "" ?>>5ft 07in</option>
                                                                    <option value="68" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 68 ? "selected" : "") : "" ?>>5ft 08in</option>
                                                                    <option value="69" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 69 ? "selected" : "") : "" ?>>5ft 09in</option>
                                                                    <option value="70" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 70 ? "selected" : "") : "" ?>>5ft 10in</option>
                                                                    <option value="71" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 71 ? "selected" : "") : "" ?>>5ft 11in</option>
                                                                    <option value="72" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 72 ? "selected" : "") : "" ?>>6ft</option>
                                                                    <option value="73" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 73 ? "selected" : "") : "" ?>>6ft 01in</option>
                                                                    <option value="74" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 74 ? "selected" : "") : "" ?>>6ft 02in</option>
                                                                    <option value="75" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 75 ? "selected" : "") : "" ?>>6ft 03in</option>
                                                                    <option value="76" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 76 ? "selected" : "") : "" ?>>6ft 04in</option>
                                                                    <option value="77" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 77 ? "selected" : "") : "" ?>>6ft 05in</option>
                                                                    <option value="78" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 78 ? "selected" : "") : "" ?>>6ft 06in</option>
                                                                    <option value="79" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 79 ? "selected" : "") : "" ?>>6ft 07in</option>
                                                                    <option value="80" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 80 ? "selected" : "") : "" ?>>6ft 08in</option>
                                                                    <option value="81" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 81 ? "selected" : "") : "" ?>>6ft 09in</option>
                                                                    <option value="82" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 82 ? "selected" : "") : "" ?>>6ft 10in</option>
                                                                    <option value="83" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 83 ? "selected" : "") : "" ?>>6ft 11in</option>
                                                                    <option value="84" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 84 ? "selected" : "") : "" ?>>7ft</option>
                                                                    <option value="85" <?= !empty($dataResult->height_to) ? ($dataResult->height_to == 85 ? "selected" : "") : "" ?>>Above 7ft</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label for="education_level_quick_search">Education
                                                            Level</label>
                                                        <select class="chosen-select form-control mb-5"
                                                                name="education_level[]"
                                                                id="education_level_quick_search"
                                                                data-placeholder=" Select Education Level"
                                                                multiple>
                                                            <?php
                                                            $getEducationLevel = explode(",", $dataResult->edu_level);
                                                            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_level_id, e_level_name FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");
                                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
                                                                <option value="<?= $DatabaseCo->dbRow->e_level_id ?>" <?php if (in_array($DatabaseCo->dbRow->e_level_id, $getEducationLevel)) {
                                                                    echo "selected";
                                                                } ?>>
                                                                    <?php echo $DatabaseCo->dbRow->e_level_name ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label for="education_field_quick_search">Education
                                                            Field</label>
                                                        <select class="chosen-select form-control mb-5"
                                                                name="education_field[]"
                                                                id="education_field_quick_search"
                                                                data-placeholder=" Select Education" multiple>
                                                            <?php
                                                            $getEducationField = explode(",", $dataResult->edu_field);
                                                            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_field_id, e_field_name FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");
                                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                                ?>
                                                                <option value="<?php echo $DatabaseCo->dbRow->e_field_id ?>" <?php if (in_array($DatabaseCo->dbRow->e_field_id, $getEducationField)) {
                                                                    echo "selected";
                                                                } ?>>
                                                                    <?php echo $DatabaseCo->dbRow->e_field_name ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!--<div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label for="annual_income">Annual Income</label>
                                                        <select class="form-control mb-5" name="income"
                                                                id="annual_income"
                                                                data-validetta="true">
                                                            <option value="Does not matter">Does not matter</option>
                                                            <option value="Rs 10,000 - 50,000" <?php /*if ($dataResult->annual_income == 'Rs 10,000 - 50,000') {
                                                                echo "selected";
                                                            } */?>>Rs 10,000 - 50,000
                                                            </option>
                                                            <option value="Rs 50,000 - 1,00,000" <?php /*if ($dataResult->annual_income == 'Rs 50,000 - 1,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 50,000 - 1,00,000
                                                            </option>
                                                            <option value="Rs 1,00,000 - 2,00,000" <?php /*if ($dataResult->annual_income == 'Rs 1,00,000 - 2,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 1,00,000 -
                                                                2,00,000
                                                            </option>
                                                            <option value="Rs 2,00,000 - 5,00,000" <?php /*if ($dataResult->annual_income == 'Rs 2,00,000 - 5,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 2,00,000 -
                                                                5,00,000
                                                            </option>
                                                            <option value="Rs 5,00,000 - 10,00,000" <?php /*if ($dataResult->annual_income == 'Rs 5,00,000 - 10,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 5,00,000 -
                                                                10,00,000
                                                            </option>
                                                            <option value="Rs 10,00,000 - 20,00,000" <?php /*if ($dataResult->annual_income == 'Rs 10,00,000 - 20,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 10,00,000 -
                                                                20,00,000
                                                            </option>
                                                            <option value="Rs 20,00,000 - 30,00,000" <?php /*if ($dataResult->annual_income == 'Rs 20,00,000 - 30,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 20,00,000 -
                                                                30,00,000
                                                            </option>
                                                            <option value="Rs 30,00,000 - 50,00,000" <?php /*if ($dataResult->annual_income == 'Rs 30,00,000 - 50,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 30,00,000 -
                                                                50,00,000
                                                            </option>
                                                            <option value="Rs 50,00,000 - 1,00,00,000" <?php /*if ($dataResult->annual_income == 'Rs 50,00,000 - 1,00,00,000') {
                                                                echo "selected";
                                                            } */?>>Rs 50,00,000 -
                                                                1,00,00,000
                                                            </option>
                                                            <option value="Above Rs 1,00,00,000" <?php /*if ($dataResult->annual_income == 'Above Rs 1,00,00,000') {
                                                                echo "selected";
                                                            } */?>>Above Rs 1,00,00,000
                                                            </option>
                                                        </select>
                                                    </div>-->
                                                    <div class="col-xss-12 col-xs-12 col-sm-6">
                                                        <label>Profile with Photo?</label>
                                                        <select class="form-control mb-10"
                                                                name="photo_search">
                                                            <option value="" selected>Photo does not matter
                                                            </option>
                                                            <option value="Yes" <?php if($dataResult->with_photo == 1) {
                                                                echo "selected";
                                                            } ?>>With Photo Only</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row mt-20 mb-10">
                                                <div class="col-xs-12 col-sm-offset-1 col-sm-10 text-center">
                                                    <button type="submit"
                                                            class="btn btn-danger btn-md btn-icon"
                                                            style="letter-spacing: 1px;">
                                                        Update Privacy Setting &nbsp; <span class="icon"><i
                                                                    class="fa fa-cog"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row text-center" id="express-interest-response-container">
                                                <div class="col-xs-12 col-sm-12">
                                                    <span id="express-interest-response"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="clear"></div>

        <?php @include_once 'layouts/footer.php' ?>

    </div>

</div>

<!-- start Back To Top -->
<div id="back-to-top">
    <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->


<!-- jQuery Cores -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="<?= auto_version("js/customs.js") ?>"></script>

<script type="text/javascript" src="js/select2.min.js"></script>
<script>
    $(function () {
        <?php
        if(!empty($dataResult->status) && $dataResult->status == 1) { ?>
            $("#privacy_type_anyone").prop("checked", false);
            $("#privacy_type_restrict").trigger('click');
        <?php } ?>
        $('.check input:checkbox').click(function () {
            $('.check input:checkbox').not(this).prop('checked', false);
        });

        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();


        $("#express-interest-privacy").submit(function (e) {
            var privacy_type = $(".privacy_type:checked").val();
            if (privacy_type != 'anyone' && privacy_type != 'restrict') {
                alert("Checking a privacy type is mandatory");
                return false;
            }
            $("#express-interest-response").html("");
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "web-services/interest-details-privacy", //Where to make Ajax calls
                dataType: 'json',
                beforeSend: function () {
                    $("#loader-animation-area").show();
                },
                data: $(this).serialize(),
                success: function (response) {
                    $("#express-interest-response").html(response.msg).slideDown(500);
                    setTimeout(function(){
                        $("#express-interest-response").slideUp()
                    }, 7000);
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
            e.preventDefault();
        });
    });
</script>


<SCRIPT LANGUAGE="JavaScript">
    var win = null;

    function newWindow(mypage, myname, w, h, features) {
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        if (winl < 0) winl = 0;
        if (wint < 0) wint = 0;
        var settings = 'height=' + h + ',';
        settings += 'width=' + w + ',';
        settings += 'top=' + wint + ',';
        settings += 'left=' + winl + ',';
        settings += features;
        win = window.open(mypage, myname, settings);
        win.window.focus();
    }

    function showHideForm(context) {
        var privacy_type = $(context).val();
        if (privacy_type == 'anyone') {
            $("#user_based_criteria").slideUp(500);
        } else {
            $("#user_based_criteria").slideDown(500);
        }
    }
</script>

</body>


</html>