<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/27/2018
 * Time: 9:58 PM
 */
require_once 'DatabaseConnection.php';
include_once 'auth.php';
require_once 'lib/RequestHandler.php';
require_once 'lib/Config.php';
require_once 'lib/sendmail.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

$getnew_data = mysqli_fetch_object($DatabaseCo->dbLink->query("select * from payments where pmatri_id='" . $_SESSION['user_id'] . "'"));
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
                    <a href="homepage"> Dashboard</a> |
                    <a href="premium_member"> Membership Plan</a> |
                    <a href="contact_us">Contact Us</a>
                    <!--<a href="express-interest?type=sent#tab_1-03"> Pending Order</a>-->
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
                            <li><a href="#">Current Plan</a></li>
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

            <?php
            if(!empty($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid') {
                ?>
                <div class="section-title-3">
                    <h2>My Plan</h2>
                </div>
                <?php
            }
            ?>
            <div class="clear mb-10"></div>

            <h5 class="text-center text-darker mb-40">
                Thank You to be Our Site Member <br>Need Any Help Just Call Us : +91 9819725425 /+91 9819886759
            </h5>

            <?php
            if(!empty($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid') {
                ?>
                <div class="destination-list-sm-wrapper mmb-10">

                    <div class="GridLex-gap-10-wrapper">

                        <div class="GridLex-grid-noGutter-equalHeight">

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">
                                    <a href="javascript:void(0)">
                                        <div class="content">
                                            <h5><?php echo $getnew_data->p_plan; ?> Plan</h5>
                                            <p><?php echo $getnew_data->p_amount; ?></p>
                                        </div>
                                    </a>
                                </div>

                            </div>

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">

                                    <a href="javascript:void(0)">

                                        <div class="content">
                                            <h5>Duration</h5>
                                            <p><?php echo $getnew_data->plan_duration . ' Days'; ?></p>
                                        </div>

                                    </a>

                                </div>

                            </div>

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">

                                    <a href="javascript:void(0)">

                                        <div class="content">
                                            <h5>Contact</h5>
                                            <p class="mb-5"><?php echo $getnew_data->p_no_contacts; ?></p>
                                            <p>(Used : <?php echo($getnew_data->r_cnt); ?>)</p>
                                        </div>

                                    </a>

                                </div>

                            </div>

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">

                                    <a href="javascript:void(0)">

                                        <div class="content">
                                            <h5>View Profile</h5>
                                            <p class="mb-5"><?php echo $getnew_data->profile; ?></p>
                                            <p>(Used : <?php echo($getnew_data->r_profile); ?>)</p>
                                        </div>

                                    </a>

                                </div>

                            </div>

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">

                                    <a href="javascript:void(0)">

                                        <div class="content">
                                            <h5>Personal Message</h5>
                                            <p class="mb-5"><?php echo $getnew_data->p_msg; ?></p>
                                            <p>(Used : <?php echo($getnew_data->r_sms); ?>)</p>
                                        </div>

                                    </a>

                                </div>

                            </div>

                            <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                <div class="destination-list-sm-item mb-10 text-center">

                                    <a href="javascript:void(0)">

                                        <div class="content">
                                            <h5>Expiry Date</h5>
                                            <p><?php echo date("d M Y", (strtotime($getnew_data->exp_date))); ?></p>
                                        </div>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <?php
            } else { ?>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <p><span style="font-weight: bold;">Your Profile is Under Approval</span>,<br/> please wait some time.</p>
                        <p style="margin-bottom: 30px;">By verifying email address, mobile number, and Photo Id Proof trust score will be increased. Profile having good trust score gets more interest from other users</p>
                        <p>In case your profile details looks suspicious, we can ask for your photo identity proof.</p><br/>
                        <p>For whatsapp support: <a style="color: red;"
                                                    href="https://api.whatsapp.com/send?phone=917977993616&text=Hello *Samyakmatrimony Admin*,%0A%0APlease approve my profile <?= $_SESSION['user_id'] ?>">Click
                                Here</a></p>
                    </div>
                </div>
            <?php } ?>

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


</body>
</html>
