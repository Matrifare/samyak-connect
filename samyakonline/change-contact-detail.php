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
$sql = "select email, mobile, phone from register_view where matri_id='" . $matri_id . "'";
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
                                <li><a href="#">Change Contact Details</a></li>
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
                <div class="content-wrapper mb-70">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pt-20">
                                <form method="post" id="change_contact_detail_form">
                                    <h6 id="response_change_contact_detail"
                                        class="text-center text-danger"></h6>
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <p class="font-16 pt-15 pb-10"><i
                                                        class="fa fa-edit"></i> Change Contact Details
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Email:
                                        </div>
                                        <div class="col-xs-7 col-md-4 mb-7">
                                            <input type="email" class="form-control"
                                                   id="email" autocomplete="off"
                                                   value="<?= $Row->email ?>"
                                                   name="email" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">Primary Mobile No:
                                        </div>
                                        <div class="col-xs-7 col-md-4 mb-7">
                                            <input type="text" class="form-control"
                                                   id="p_mobile_no" autocomplete="off"
                                                   value="<?= $Row->mobile ?>"
                                                   name="p_mobile_no" maxlength="10"
                                                   onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-2 col-xs-5 col-md-3 mb-7">
                                            Secondary Mobile:
                                        </div>
                                        <div class="col-xs-7 col-md-4 mb-7">
                                            <input type="text" class="form-control"
                                                   id="s_mobile_no" autocomplete="off" maxlength="10"
                                                   onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"
                                                   name="s_mobile_no" value="<?= $Row->phone ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm mr-10 mt-30 mb-30"
                                                    name="change_contact_details">Update Contact Details
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        $("#change_contact_detail_form").submit(function (e) {
            $("#response_change_contact_detail").html("");
            if ($("#email").val() == "" || $("#p_mobile_no").val() == "") {
                $("#response_change_contact_detail").html("Email and Primary Mobile Number should not be blank");
                return false;
            } else {
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/change_contact_detail", //Where to make Ajax calls
                    dataType: 'json',
                    beforeSend: function () {
                        $("#loader-animation-area").show();
                    },
                    data: $(this).serialize() + "&change_contact_detail=true",
                    success: function (response) {
                        $("#response_change_contact_detail").html(response.msg);
                        if (response.result == 'success') {
                            if(response.action == 'redirect') {
                                window.location.reload();
                            }
                        }
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