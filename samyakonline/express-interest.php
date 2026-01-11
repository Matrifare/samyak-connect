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
                    <a href="messages?type=received">Received Message</a> |
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
                            <li class="active"><a href="express-interest">Express Interest</a></li>
                                 
                            
                            
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
                                                    <h5 class="text-center">
                                                        <button href="javascript:void(0);"
                                                                class="btn btn-shrink btn-sm btn-danger"
                                                                onclick="express_interest('received')">
                                                            Interest Received
                                                        </button>
                                                        <button class="btn btn-shrink btn-sm btn-primary"
                                                                onclick="express_interest('sent')">
                                                            Interest Sent
                                                        </button>
                                                        <button class="btn btn-shrink btn-sm btn-success"
                                                                title="Who can send me interest?"
                                                                onclick="javascript:window.location.href='express-interest-privacy'">
                                                            Interest Privacy Setting
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="express_interest_content"></div>

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
<script type="text/javascript" src="<?= auto_version("js/express_interest.js") ?>"></script>

<script type="text/javascript" src="js/select2.min.js"></script>
<script>
    /**
     * Select 2
     */
    $(".chosen-select").css('width', '100%');
    $("ul > li > input").css('width', '100%');
    $('.chosen-select').select2();
</script>
<!---
Some Scripts on runtime
-->
<script type="text/javascript">
    <?php
            if(!empty($_GET['type']) && $_GET['type'] == 'sent') { ?>
                express_interest('sent');
            <?php } else { ?>
                express_interest('received');
            <?php }
    ?>
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

    function convertToPrivilege(matri_id_by, matri_id_to, ei_id) {
        $.ajax({
            url: "web-services/update-interest-to-privilege",
            type: "POST",
            data: "matri_id=" + matri_id_by+"&match_ids="+matri_id_to,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
                $('#buttonContainer' + ei_id + '').fadeOut('slow');
                if(response.status == 'accepted') {
                    $(".acceptedMatch" + ei_id + '').html("Success: Interest converted to Privilege.");
                } else {
                    $(".rejectedMatch" + ei_id + '').html("Error: Privilege Match already present.");
                }
                setTimeout(function () {
                    $(".privilegeConvert"+ei_id+'').html("");
                }, 5000);
            },
            complete: function () {
            }
        });
    }
</script>

</body>


</html>