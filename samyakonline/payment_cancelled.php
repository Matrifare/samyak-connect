<?php
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
require_once 'auth.php';
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
$configObj = new Config();
include_once 'lib/sendmail.php';
include_once 'lib/curl.php';

if (!empty($_POST['encResp']) && !empty($_SESSION['planDetails'])) {
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
        <link href="css/style.css" rel="stylesheet">

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

            <div class="breadcrumb-wrapper">

                <div class="container">

                    <div class="row">

                        <div class="col-xs-12 col-sm-8">
                            <ol class="breadcrumb">
                                <li><a href="index">Home</a></li>
                                <li><a href="#">Payment Cancelled</a></li>
                            </ol>
                        </div>

                        <div class="col-xs-12 col-sm-4 hidden-xs">
                            <p class="hot-line"><i class="fa fa-phone"></i> <a href="tel:+91-79779-93616"> Help Line:
                                    +91-79779-93616</a></p>
                        </div>

                    </div>

                </div>

            </div>
            <div class="container mt-50 mb-50">

                <div class="section-title-3">
                    <h5 class="btn-danger col-sm-offset-4 col-sm-4 col-xs-12">You have cancelled the Payment !!!</h5>
                </div>

                <div class="clear mb-10"></div>
                <div class="div padding-15" style="padding-top: 0px !important;">

                    <p class="text-center font-weight-bold"
                       style="color: #D60D45;font-size: 15px;">You can
                        Pay by Google Pay
                        /PhonePay/PayTM on
                        9819725425</p>
                </div>
                <div class="div padding-15" style="padding-top: 0px !important;">
                    <div class="div padding-15">
                        <div class="section-title-3 text-left">
                            <h3 style="text-transform: capitalize;">Other Online Payment
                                Options</h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="https://www.instamojo.com/@Samyakonline/l231428f3f90741ce8b6f8a76e18f4955/"
                                   rel="im-checkout" data-text="Buy 3 Month Plan"
                                   data-css-style="color:#ffffff; background:#75c26a; width:180px; border-radius:4px"
                                   data-layout="vertical"></a>
                                <script src="https://js.instamojo.com/v1/button.js"></script>
                            </div>
                            <div class="col-sm-4">
                                <a href="https://www.instamojo.com/@Samyakonline/l4da9f8f1ff12456fbc4e6704ffbbff74/"
                                   rel="im-checkout" data-text="Buy 6 Month Plan"
                                   data-css-style="color:#ffffff; background:#75c26a; width:180px; border-radius:4px"
                                   data-layout="vertical"></a>
                                <script src="https://js.instamojo.com/v1/button.js"></script>
                            </div>
                            <div class="col-sm-4">
                                <a href="https://www.instamojo.com/@Samyakonline/lf6d2c18f863d4ca195f4bc7698146dc2/"
                                   rel="im-checkout" data-text="Buy 1 Yr Plan"
                                   data-css-style="color:#ffffff; background:#75c26a; width:180px; border-radius:4px"
                                   data-layout="vertical"></a>
                                <script src="https://js.instamojo.com/v1/button.js"></script>
                            </div>
                        </div>
                    </div>

                    <div class="section-title-3 text-left">
                        <h3 style="text-transform: capitalize;">Bank Payment Transfer
                            Options</h3>
                    </div>
                    <p class="text-left"><b>ICICI Bank</b> : Pavan Dongre A/c No :
                        000401622735<br/>
                        [ IFSC Code: ICIC0000004 - Branch : Nariman Point, Mumbai]
                        <br/><br/>
                        <b>SBI Bank</b> : Pavan Dongre A/c No : 0030291101831<br/>
                        [ IFSC Code SBIN0001053 - Branch : Wagle Estate,Thane]
                    </p>
                    <p class="text-danger text-center mt-0"
                       style="margin-top:0px; margin-bottom: 15px;">Note:
                        In
                        case
                        your profile details looks suspicious, we can ask for your photo
                        identity
                        proof.</p>
                    <p style="margin-bottom: 10px;">By verifying your Photo Id Proof trust score will be increased.
                        Profile having good trust score gets more interest from other users</p>

                    <p style="margin-bottom: 10px;">**Note - To verify your email, please check your email id, you
                        should
                        have received an email verification.</p>
                    <p>**Note - To verify your Photo ID proof, kindly send your photo id proof on
                        <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or click on below button
                        to
                        send it on WhatsApp.</p>

                    <a target="_blank" class="btn btn-success btn-shrink btn-sm"
                       style="background-color: #25d366; margin-bottom: 20px;"
                       href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                class="fa fa-whatsapp"></i> Send Now</a>

                    <p>For whatsapp support: <a style="color: red;"
                                                href="https://api.whatsapp.com/send?phone=917977993616&text=Hello *Samyakmatrimony Admin*,%0A%0APlease approve my profile <?= $_SESSION['user_id'] ?>">Click
                            Here</a></p>
                </div>
            </div>

            <div class="clear"></div>

            <?php @include_once 'layouts/footer.php' ?>

        </div>

    </div>

    <!-- jQuery Cores -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

    <!-- Bootstrap Js -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugins - serveral jquery plugins that use in this template -->
    <script type="text/javascript" src="js/plugins.js"></script>

    <!-- Custom js codes for plugins -->
    <script type="text/javascript" src="<?= @auto_version("js/customs.js") ?>"></script>


    </body>
    </html>
    <?php
    unset($_SESSION['planDetails']);
} else {
    header('location: homepage');
}