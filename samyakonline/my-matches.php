<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/4/2018
 * Time: 9:47 PM
 */
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
include_once 'auth.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();


unset($_SESSION['religion']);
unset($_SESSION['caste']);
unset($_SESSION['m_tongue']);
unset($_SESSION['fromage']);
unset($_SESSION['toage']);
unset($_SESSION['fromheight']);
unset($_SESSION['toheight']);
unset($_SESSION['m_status']);
unset($_SESSION['education_level']);
unset($_SESSION['education_field']);
unset($_SESSION['occupation']);
unset($_SESSION['country']);
unset($_SESSION['state']);
unset($_SESSION['city']);
unset($_SESSION['family_origin']);
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
unset($_SESSION['other_caste']);
unset($_SESSION['special_case']);
unset($_SESSION['orderby']);
unset($_SESSION['samyak_id_search']);
unset($_SESSION['samyak_search']);
unset($_SESSION['search_by_profile_id']);

$myProfile = $DatabaseCo->dbLink->query("select DISTINCT matri_id, looking_for, part_height, part_height_to, part_religion,
part_caste, part_occupation, part_complexion, part_country_living, part_edu_field, part_frm_age, part_to_age,
 part_city, part_native_place,part_edu_level from register_view WHERE matri_id='" . $_SESSION['user_id'] . "'");

$data = mysqli_fetch_object($myProfile);
$lookingFor = $data->looking_for;
$partHeight = $data->part_height;
$partHeightTo = $data->part_height_to;
$partReligion = $data->part_religion;
$partCaste = $data->part_caste;
$partOcc = $data->part_occupation;
$partComplexion = $data->part_complexion;
$partCountry = $data->part_country_living;
$partEduField = $data->part_edu_field;
$partAgeFrom = $data->part_frm_age;
$partAgeTo = $data->part_to_age;
$partCity = $data->part_city;
$partNative = $data->part_native_place;
$partEduLevel = $data->part_edu_level;


?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title><?php echo $configObj->getConfigTitle(); ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
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
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="css/select2.min.css"/>
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
                    <a href="homepage">Homepage</a> |
                    <a  target="_blank"
                        href='view_profile?userId=<?= $_SESSION['user_id'] ?>'> My Profile</a> |
                    <a href="edit-profile"> Edit Profile</a> |
                    <a href="edit_photo"> Edit Photo</a>
                </div>
            </div>
        </div>

        <div class="breadcrumb-wrapper hidden-sm hidden-xs hidden-xss">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="my-matches">My Matches</a></li>
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

                                    <div class="section-title-3">
                                        <h3 style="font-size: 18px; text-transform: capitalize;">My Match
                                            <?php
                                            if ($_SESSION['mem_status'] == 'Paid') { ?>
                                                <button class="btn btn-danger btn-sm btn-shrink"
                                                        onclick="newWindow('web-services/match-list-message?matri_id=<?= $_SESSION['user_id'] ?>','','800','700');"
                                                        style="margin-left: 10px;"><i class="fa fa-whatsapp"></i> Get on
                                                    WhatsApp
                                                </button>
                                            <?php } ?>

                                            <button class="btn btn-primary btn-sm btn-shrink" id="edit_match_btn"
                                                    style="float: right;">
                                                Edit Match
                                            </button>

                                        </h3>
                                    </div>

                                </div>

                            </div>

                            <div class="row" id="samyak_edit_matches" style="display: none;">

                                <form method="post" action="#" id="my-match-form">
                                    <!--                                Looking For and Age-->
                                    <input type="hidden"
                                           value="<?= (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Groom') ? "Bride" : "Groom" ?>"
                                           name="gender"/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_looking_for">Looking For</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group mb-0">
                                                    <select class="chosen-select form-control mb-0" name="m_status[]"
                                                            id="match_looking_for" multiple
                                                            data-placeholder="Looking For">
                                                        <?php
                                                        $getLooking = explode(",", $lookingFor);
                                                        ?>
                                                        <option value="Unmarried" <?php if (in_array("Unmarried", $getLooking)) {
                                                            echo "selected";
                                                        } ?>>Unmarried
                                                        </option>
                                                        <option value="Widow/Widower" <?php if (in_array("Widow/Widower", $getLooking)) {
                                                            echo "selected";
                                                        } ?>>Widow/Widower
                                                        </option>
                                                        <option value="Divorcee" <?php if (in_array("Divorcee", $getLooking)) {
                                                            echo "selected";
                                                        } ?>>Divorcee
                                                        </option>
                                                        <option value="Separated" <?php if (in_array("Separated", $getLooking)) {
                                                            echo "selected";
                                                        } ?>>Separated
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!--                                Age and Height-->
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="">Age</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                        <select class="form-control mb-5" name="t3"
                                                                id="match_pform_age">
                                                            <option value="" selected>Any</option>
                                                            <option value="<?= $partAgeFrom ?>" <?= ($partAgeFrom > 0) ? "selected" : "" ?>><?= $partAgeFrom ?>
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
                                                    <div class="col-xs-2">TO</div>
                                                    <div class="col-xs-5">
                                                        <select class="form-control mb-0" name="t4" id="match_pto_age">
                                                            <option value="" selected>Any</option>
                                                            <option value="<?= $partAgeTo ?>" <?= ($partAgeTo > 0) ? "selected" : "" ?>><?= $partAgeTo ?>
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="">Height</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                        <select class="form-control mb-5" name="fromheight"
                                                                id="match_part_height">
                                                            <option value="" selected>Any</option>
                                                            <option value="<?= $partHeight ?>" <?= ($partHeight > 48) ? "selected" : "" ?>><?php $ao = $partHeight;
                                                                $ft = (int)($ao / 12);
                                                                $inch = $ao % 12;
                                                                echo $ft . "ft" . " " . $inch . "in"; ?></option>
                                                            <option value="48">Below 4ft</option>
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
                                                    <div class="col-xs-2">TO</div>
                                                    <div class="col-xs-5">
                                                        <select class="form-control mb-0" name="toheight"
                                                                id="match_part_height_to">
                                                            <option value="" disabled>To Height</option>
                                                            <option value="" selected>Any</option>
                                                            <option value="<?= $partHeightTo ?>" <?= ($partHeightTo > 48) ? "selected" : "" ?> ><?php $ao = $partHeightTo;
                                                                $ft = (int)($ao / 12);
                                                                $inch = $ao % 12;
                                                                echo $ft . "ft" . " " . $inch . "in"; ?></option>
                                                            <option value="48">Below 4ft</option>
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

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_native">Edu. Level</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-placeholder="Choose Partner Education Level"
                                                        name="education_level[]"
                                                        id="match_part_edu_level" class="chosen-select form-control mb-5"
                                                        multiple>
                                                    <option value="">Any</option>
                                                    <?php
                                                    $arr_part_edu_level = explode(",", $partEduLevel);
                                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_level_id, e_level_name FROM education_level where status='APPROVED' ORDER BY e_level_name ASC");

                                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                        ?>
                                                        <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>" <?php if ($partEduLevel != '') {
                                                            if (in_array($DatabaseCo->dbRow->e_level_id, $arr_part_edu_level)) {
                                                                echo "selected";
                                                            }
                                                        } ?> ><?php echo $DatabaseCo->dbRow->e_level_name ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_edu">Education</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-placeholder="Partner Education Field"
                                                            class="chosen-select form-control mb-5"
                                                            name="education_field[]"
                                                            id="match_part_edu" multiple>
                                                        <option value="">Any</option>
                                                        <?php
                                                        $arr_part_edu_field = explode(",", $partEduField);

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
                                    </div>
                                    <!--                                Religion/Caste and  Complexion-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="">Religion</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="chosen-select form-control mb-5"
                                                        onchange="GetCaste(this)"
                                                        name="religion[]"
                                                        id="match_part_religion"
                                                        data-placeholder="Partner Religion" multiple>
                                                    <option value="">Any</option>
                                                    <?php
                                                    $arr_part_relg = explode(",", $partReligion);
                                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT religion_id, religion_name FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                        ?>
                                                        <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>" <?php if (in_array($DatabaseCo->dbRow->religion_id, $arr_part_relg)) {
                                                            echo "selected";
                                                        } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_complexion">Caste</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div id="CasteDivMatch">
                                                    <select class="chosen-select form-control mb-5"
                                                            name="caste[]"
                                                            id="match_part_caste"
                                                            data-placeholder="Partner Caste" multiple>
                                                        <?php
                                                        $arr_part_catse = explode(",", $partCaste);

                                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT DISTINCT caste_id, caste_name FROM caste ORDER BY caste_name ASC");

                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                            ?>
                                                            <option value="<?php echo $DatabaseCo->dbRow->caste_id; ?>" <?php if ($arr_part_catse != '') {
                                                                if (in_array($DatabaseCo->dbRow->caste_id, $arr_part_catse)) {
                                                                    echo "selected";
                                                                }
                                                            } ?>><?php echo $DatabaseCo->dbRow->caste_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--                                Partner Occupation & Partner Country-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_complexion">Complexion</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-placeholder="Partner Complexion" id="match_part_complexion"
                                                        class="chosen-select form-control mb-5" name="complexion[]"
                                                        multiple>
                                                    <?php
                                                    $get_parttone = explode(", ", $partComplexion);
                                                    ?>
                                                    <option value="">Any</option>
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
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_country">Country</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="chosen-select form-control mb-5" name="country[]"
                                                        multiple id="match_part_country"
                                                        data-placeholder="Partner Country">
                                                    <option value="">Any</option>
                                                    <?php
                                                    $arr_part_country = explode(",", $partCountry);

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

                                    </div>

                                    <!--                                Partner City & Partner Native Place-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_city">Residence</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-placeholder="Choose Partner City" name="city[]"
                                                            id="match_part_city" class="chosen-select form-control mb-5"
                                                            multiple>
                                                        <option value="">Any</option>
                                                        <?php
                                                        $arr_part_city = explode(",", $partCity);
                                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view where status='APPROVED' ORDER BY city_name ASC");

                                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                            ?>
                                                            <option value="<?php echo $DatabaseCo->dbRow->city_id ?>" <?php if ($partCity != '') {
                                                                if (in_array($DatabaseCo->dbRow->city_id, $arr_part_city)) {
                                                                    echo "selected";
                                                                }
                                                            } ?> ><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="match_part_native">Native Place</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-placeholder="Choose Partner Native Place"
                                                        name="family_origin[]"
                                                        id="match_part_native" class="chosen-select form-control mb-5"
                                                        multiple>
                                                    <option value="">Any</option>
                                                    <?php
                                                    $arr_part_city = explode(",", $partNative);
                                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view where status='APPROVED' ORDER BY city_name ASC");

                                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                        ?>
                                                        <option value="<?php echo $DatabaseCo->dbRow->city_id ?>" <?php if ($partNative != '') {
                                                            if (in_array($DatabaseCo->dbRow->city_id, $arr_part_city)) {
                                                                echo "selected";
                                                            }
                                                        } ?> ><?php echo $DatabaseCo->dbRow->city_name ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 text-center mt-10">
                                            <button class="btn btn-shrink btn-primary" type="submit"
                                                    name="match_submit">Save and Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="row mt-30">
                                <div class="col-xs-12">
                                    <div id="samyak-results"></div>
                                </div>


                            </div>
                            <!--<div class="row">
                                <div class="col-xs-12">
                                    <?php /*include 'advertise/ad_level_2_homepage.php'; */ ?>
                                </div>
                            </div>-->
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
<script type="text/javascript" src="js/customs.js?v=1.0"></script>

<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/bootstrap-toolkit.min.js"></script>
<script type="text/javascript" src="js/device.js"></script>
<script>
    $(function () {
        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();
    });

    function GetCaste(context) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'web-services/match_part_caste_search_sidebar',
            data: {
                religion: $("#match_part_religion").val()
            },
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#match_part_caste").html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

    $(function () {


        $.ajax({
            url: "dbmanupulate2",
            type: "POST",
            data: $("#my-match-form").serialize() + '&orderby=' + 'register' + '&actionfunction=showData' +
            '&page=1',
            cache: false,
            beforeSend: function(){
                $("#loader-animation-area").show();
            },
            success: function (response) {
                $('#samyak-results').html(response);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });

        $("#my-match-form").submit(function (e) {
            $("#loader-animation-area").show();
            $.ajax({
                url: "web-services/save-my-match",
                type: "POST",
                data: $("#my-match-form").serialize() + '&orderby=' + 'register' + '&actionfunction=showData' +
                '&page=1',
                cache: false,
                success: function (response) {
                    $("#loader-animation-area").show();
                    $.ajax({
                        url: "dbmanupulate2",
                        type: "POST",
                        data: $("#my-match-form").serialize() + '&orderby=' + 'register' + '&actionfunction=showData' +
                        '&page=1',
                        cache: false,
                        success: function (response) {
                            $('#samyak-results').html(response);
                        },
                        complete: function () {
                            $("#loader-animation-area").hide();
                        }
                    });
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
            e.preventDefault();
        });


        $('#samyak-results').on('click', '.page-numbers', function () {
            $("#loader-animation-area").show();
            $page = $(this).attr('href');
            $pageind = $page.indexOf('page=');
            $page = $page.substring(($pageind + 5));
            var dataString = '&actionfunction=showData' + '&page=' + $page;
            $.ajax({
                url: "dbmanupulate2",
                type: "POST",
                data: dataString,
                cache: false,
                success: function (response) {
                    $('#samyak-results').html(response);
                },
                complete: function () {
                    $("#loader-animation-area").hide();
                }
            });
            return false;
        });
    });

    $(function () {
        $("#edit_match_btn").click(function () {
            $("#samyak_edit_matches").slideToggle('200');
        });
    });

</script>
<!---
Some Scripts on runtime
-->
</body>





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
</script>
</html>