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
$get_data = mysqli_fetch_object($DatabaseCo->dbLink->query("select photo_view_status,photo_pswd from register where matri_id='" . $_SESSION['user_id'] . "'"));
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

    <link rel="stylesheet" href="css/select2.min.css"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                    <a href="my-matches"> My Matches</a> |
                    <a href="edit-profile"> Edit Profile</a>
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
                            <li><a href="edit-profile">Edit Profile</a></li>
                            <li><a href="edit_photo">Manage Photo</a></li>
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

                    <div class="GridLex-col-3_sm-4_xs-12_xss-12 hidden-xs hidden-xss">

                        <?php @include_once 'layouts/sidebar.php' ?>

                    </div>

                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">

                        <div class="content-wrapper">

                            <div class="row">

                                <div class="row mb-10">
                                    <div class="col-xs-6 text-right">
                                        <h5 class="text-center btn btn-primary btn-sm btn-shrink">
                                            Manage Your Photos
                                        </h5>
                                    </div>
                                    <div class="col-xs-6 text-left">
                                        <button type="button" id="photo_setting_btn"
                                                class="btn btn-shrink btn-sm btn-danger"><i class="fa fa-cog"></i> Photo
                                            Security
                                        </button>
                                    </div>
                                    <div class="col-xs-12 text-center mt-10">
                                        <h6 id="response_photo_settings" class="text-danger"></h6>
                                    </div>
                                    <div class="col-sm-offset-6 col-sm-6 col-xs-12 text-right"
                                         id="photo_setting_content">
                                        <form method="post" action="#" id="photo_visibility_form"
                                              onsubmit="return false;">
                                            <div class="row mt-10">
                                                <div class="col-xs-12 col-md-6 mb-7 pt-5">My Photo: </div>
                                                <div class="col-xs-12 col-md-6 mb-7">
                                                    <select class="form-control" name="photo_visibility"
                                                            onchange="photoSettings(this.value)">
                                                        <option value="0" <?php if ($get_data->photo_view_status == '0') {
                                                            echo "selected";
                                                        } ?>>Hide For All
                                                        </option>
                                                        <option value="1" <?php if ($get_data->photo_view_status == '1') {
                                                            echo "selected";
                                                        } ?>>Visible to All
                                                        </option>
                                                        <option value="2" <?php if ($get_data->photo_view_status == '2') {
                                                            echo "selected";
                                                        } ?>>Visible only to Paid Members
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="row mt-10">
                                                <div class="col-xs-12" id="photo_pass_btn">
                                                    <?php
                                            /*                                                    if ($get_data->photo_pswd == '' || $get_data->photo_pswd == '0') {
                                                                                                    */ ?>
                                                        <button type="button" id="set_photo_pass_btn"
                                                                class="btn btn-shrink btn-success btn-sm">Set Password
                                                            for protect photo
                                                        </button>
                                                    <?php /*} else {
                                                        */ ?>
                                                        <button type="button" id="edit_photo_pass_btn"
                                                                class="btn btn-shrink btn-success btn-sm">Edit Password
                                                            for protect photo
                                                        </button>
                                                        <br/>
                                                        OR
                                                        <br/>
                                                        <button type="button" id="remove_photo_pass_btn" onclick="updatePhotoSettings(3);"
                                                                class="btn btn-shrink btn-warning btn-sm">Remove
                                                            Password for protect photo
                                                        </button>
                                                    <?php /*} */ ?>
                                                </div>
                                                <div class="col-xs-12 photo_pass_field pt-10">
                                                    <div class="col-xs-8">
                                                        <input type="password" class="form-control"
                                                               name="photo_pass" id="photo_pass"
                                                               placeholder="Enter your password for protecting photo" required/>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="updatePhotoSettings(2);">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="">

                                    <div class="contaiiner">
                                        <div id="display_photos"></div>
                                    </div>
                                </div>

                            </div>
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
        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();

        $.ajax({
            type: "POST",
            url: "page-parts/display_more_photos",
            dataType: "html",
            success: function (response) {
                $("#display_photos").html(response);
            }
        });
    });
</script>
</body>


</html>