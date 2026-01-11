<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 25-01-2020
 * Time: 07:30 PM
 */

include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once './lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once './lib/Config.php';
$configObj = new Config();
$matri_id = $_SESSION['user_id'] ?? "";
// Outdated Income Values
$outdatedIncome = ['Rs 50,000 - 1,00,000', 'Rs 1,00,000 - 2,00,000', 'Rs 2,00,000 - 5,00,000', 'Rs 5,00,000 - 10,00,000',
    'Rs 10,00,000 - 20,00,000', 'Rs 20,00,000 - 30,00,000', 'Rs 30,00,000 - 50,00,000', 'Rs 50,00,000 - 1,00,00,000',
    'Above Rs 1,00,00,000', 'Does not matter'];

$sql = "select index_id, matri_id, family_origin, profile_text, 
       family_details, part_expect, income, part_income
from register_view where matri_id='" . $matri_id . "'";

$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
if (mysqli_num_rows($DatabaseCo->dbResult) > 0) {
    $Row = mysqli_fetch_object($DatabaseCo->dbResult);
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
        <link href="css/main.css" rel="stylesheet">
        <link href="css/component.css" rel="stylesheet">

        <!-- CSS Font Icons -->
        <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">

        <!-- CSS Custom -->
        <link href="css/style.css?v=1.0" rel="stylesheet">

        <!-- Add your style -->
        <link href="css/your-style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .font-weight-bold {
                font-weight: bold;
            }
        </style>
    </head>

    <body class="not-home" style="overflow-x: hidden;">

    <!-- start Container Wrapper -->
    <div class="container-wrapper colored-navbar-brand">

        <!-- start Header -->
        <?php @include_once 'layouts/menu.php' ?>
        <!-- end Header -->

        <div class="clear"></div>

        <!-- start Main Wrapper -->
        <div class="main-wrapper">

            <div class="breadcrumb-wrapper hidden-sm hidden-xs hidden-xss">
                <div class="container">

                    <div class="row">

                        <div class="col-xs-12 col-sm-8">
                            <ol class="breadcrumb">
                                <li><a href="homepage">Home</a></li>
                                <li><a href="settings">Settings</a></li>
                                <li><a href="#">Update Descriptions</a></li>
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

            <div class="container mb-80">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pt-20">
                            <form method="post" id="update_description_form">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="section-title-3">
                                            <h3 style="font-size: 15px; text-transform: capitalize;">Update
                                                Descriptions</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-2 col-xs-12 col-md-3 mb-7 font-weight-bold">Profile
                                        Descriptions (About Yourself):
                                    </div>
                                    <div class="col-xs-12 col-md-4 mb-7">
                                            <textarea name="profile_text" class="form-control mb-5"
                                                      rows="5" id="profile_text"><?= $Row->profile_text ?></textarea>
                                        <p class="mb-5 label label-warning">*Note: Please don't write any type of
                                            contact details.*</p>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-md-offset-2 col-xs-12 col-md-3 mb-7 font-weight-bold">
                                        About my family:
                                    </div>
                                    <div class="col-xs-12 col-md-4 mb-7">
                                            <textarea class="form-control mb-5"
                                                      name="about_my_family"
                                                      rows="3"
                                                      id="about_my_family"
                                                      placeholder="Define About Family"><?php if ($Row->family_details != 'Not Available') {
                                                    echo htmlspecialchars_decode($Row->family_details, ENT_QUOTES);
                                                } ?></textarea>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-md-offset-2 col-xs-12 col-md-3 mb-7 font-weight-bold">
                                        Partner Expectations:
                                    </div>
                                    <div class="col-xs-12 col-md-4 mb-7">
                                            <textarea class="form-control mb-5"
                                                      id="partner_expectations"
                                                      rows="3"
                                                      placeholder="Enter Partner Expectations"
                                                      name="expectation"><?= htmlspecialchars_decode($Row->part_expect, ENT_QUOTES); ?></textarea>
                                    </div>
                                </div>
                                <?php
                                if (empty($Row->family_origin)) { ?>
                                    <div class="row mt-20">
                                        <div class="col-md-offset-2 col-xs-12 col-md-3 mb-7 font-weight-bold">
                                            Family Origin:<span class="text-danger">*</span>
                                        </div>
                                        <div class="col-xs-12 col-md-4 mb-7">
                                            <select name="family_origin" id="family_origin"
                                                    class="form-control mb-5">
                                                <option value="">Please Select Your Native Place</option>
                                                <?php
                                                $query = "select city_id, city_name from city where status='APPROVED' ORDER BY city_name ASC";
                                                $result = $DatabaseCo->dbLink->query($query);
                                                while ($a = mysqli_fetch_array($result)) { ?>
                                                    <option value="<?php echo $a['city_id'] ?>"><?php echo $a['city_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php
                                if (empty($Row->income) || in_array($Row->income, $outdatedIncome)) { ?>
                                    <div class="row mt-20">
                                        <div class="col-md-offset-2 col-xs-12 col-md-3 mb-7 font-weight-bold">
                                            Annual Income:<span class="text-danger">*</span>
                                        </div>
                                        <div class="col-xs-12 col-md-4 mb-7">
                                            <select class="form-control mb-5" name="income"
                                                    id="annual_income">
                                                <option value="" selected>Select Annual Income</option>
                                                <?php
                                                $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");
                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) { ?>
                                                    <option value="<?= $DatabaseCo->dbRow->title; ?>"><?= $DatabaseCo->dbRow->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row mt-20">
                                    <div class="col-xs-12">
                                        <h6 id="response_update_description"
                                            class="text-center text-danger"></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" id="btn_description_update"
                                                class="btn btn-danger btn-sm mr-10 mt-30 mb-30"
                                                name="update_description_details">Submit Description for approval
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="clear"></div>
            <?php @include_once 'page-parts/modal.php'; ?>
            <?php @include_once 'layouts/footer.php' ?>
        </div>

    </div>

    <!-- jQuery Cores -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>


    <?php
    if (isset($_SESSION['last_login'])) {
        @include_once 'page-parts/mobile_verification.php';
    }
    if (!isset($_SESSION['last_login']) && isset($_SESSION['partner_profile'])) { ?>
        <script>
            alert("Please complete partner preference");
            window.location.href = 'edit-profile';
        </script>
    <?php } ?>


    <!-- Bootstrap Js -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugins - serveral jquery plugins that use in this template -->
    <script type="text/javascript" src="js/plugins.js"></script>

    <!-- Custom js codes for plugins -->
    <script type="text/javascript" src="js/customs.js?v=1.2"></script>
    <script>
        $("#update_description_form").submit(function (e) {
            $("#response_update_description").html("");
            if ($("#family_origin").val() == "") {
                $("#response_update_description").html("Family Origin is mandatory.");
                return false;
            } else if ($("#annual_income").val() == "") {
                $("#response_update_description").html("Annual Income is mandatory.");
                return false;
            } else if ($("#part_income").val() == "") {
                $("#response_update_description").html("Partner Annual Income is mandatory.");
                return false;
            } else {
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/update_profile", //Where to make Ajax calls
                    dataType: 'json',
                    beforeSend: function () {
                        $("#loader-animation-area").show();
                    },
                    data: $(this).serialize() + "&update_type=description_page",
                    success: function (response) {
                        alert("Profile details successfully updated and sent for approval");
                        $("#btn_description_update").prop('disabled', 'true');
                        window.location.href = 'homepage';
                    },
                    complete: function () {
                        $("#loader-animation-area").hide();
                    }
                });
            }
            e.preventDefault();
        });
    </script>
    </body>
    </html>
    <?php
} else {
    header("Location: index");
}