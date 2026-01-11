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
$sql = "select index_id, matri_id, family_origin, profile_text, family_details, part_expect,
       email_verify_status,request_photo_id, mobile_verify_status from register_view where matri_id='" . $matri_id . "'";

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
                                <li><a href="#">Update Photo Id Proof</a></li>
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
                                <h6 id="response_update_description"
                                    class="text-center text-danger"></h6>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="section-title-3">
                                            <h3 style="font-size: 15px; text-transform: capitalize;">Update Photo
                                                Id</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="mt-10">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-xs-10">
                                                        <a style="font-size: 15px;">Phone Number</a>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <?php if ($Row->mobile_verify_status == 'Yes') { ?>
                                                            <i class="fa fa-2x fa-check-square-o text-success"></i>
                                                        <?php } else { ?>
                                                            <i class="fa fa-2x fa-times text-danger"></i>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-10">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-xs-10">
                                                        <a style="font-size: 15px;">Email Verification</a>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <?php if ($Row->email_verify_status == 'Yes') { ?>
                                                            <i class="fa fa-2x fa-check-square-o text-success"></i>
                                                        <?php } else { ?>
                                                            <i class="fa fa-2x fa-times text-danger"></i>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-10">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-xs-10">
                                                        <a href="update-photo-id-proof" style="font-size: 15px;">Photo
                                                            Id Proof
                                                            Verification</a>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <?php if ($Row->request_photo_id == 2) { ?>
                                                            <i class="fa fa-2x fa-check-square-o text-success"></i>
                                                        <?php } else { ?>
                                                            <i class="fa fa-2x fa-times text-danger"></i>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <p class="mt-30">By verifying email address, mobile number, and
                                            Photo Id
                                            Proof trust score will be increased.
                                            Profile having good trust score gets more interest from other users</p>

                                        <?php if ($Row->email_verify_status != 'Yes') { ?>
                                            <p><b>*Note</b> - To verify your email, please check your email id, you
                                                should have received an email verification.</p>
                                        <?php } ?>
                                        <?php if ($Row->request_photo_id != 2) { ?>
                                            <p><b>*Note</b> - To verify your Photo ID proof, kindly send your photo id
                                                proof on
                                                <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a>
                                                or click on below button to send it on WhatsApp.</p>

                                            <a target="_blank" class="btn btn-success btn-md"
                                               style="background-color: #25d366;"
                                               href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                                        class="fa fa-whatsapp"></i> Send Now on WhatsApp</a>
                                            <?php
                                        } ?>
                                    </div>
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
    </body>
    </html>
    <?php
} else {
    header("Location: index");
}