<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/4/2018
 * Time: 9:47 PM
 */

include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
include_once 'lib/sendmail.php';
include_once 'auth.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
$mid = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $from = mysqli_real_escape_string($DatabaseCo->dbLink, $_SESSION['user_id']);
    $subject = "Delete Profile on www.samyakmatrimony.com : " . $_SESSION['user_id'];
    $message = mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['message']);
    $to = "admin";
    $status = 'sent';


    $insert = $DatabaseCo->dbLink->query("insert into delete_request (msg_to,msg_from,msg_subject,msg_content,msg_date,msg_status) values ('$to','$from','$subject','$message',now(),'$status')");

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:' . $from . "\r\n";
    $finalMessage = "Name : " . $_SESSION['uname'] . "<br/>"
        . "------------------------------------" . "<br/>"
        . "Profile ID : " . $_SESSION['user_id'] . "<br/>"
        . "Email ID : " . $_SESSION['email'] . "<br/>"
        . "Mobile : " . $_SESSION['mobile'] . "<br/>"
        . "Reason To Delete : " . $message . "<br/>"
        . "IP Address : " . $_SERVER['REMOTE_ADDR'];
    send_email_from_samyak($configObj->getConfigFrom(), $configObj->getConfigTo(), $subject, $finalMessage);
    echo "<script type='text/javascript'>
        alert('Your Delete profile request successfully Sent.');
        window.location.href = 'logout';
        </script>";

}
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
    <link href="css/style.css" rel="stylesheet">

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

        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="homepage">Dashboard</a></li>
                            <li><a href="edit-profile">Edit Profile</a></li>
                            <li><a href="delete_profile">Delete Profile</a></li>
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

                                <div class="row mb-10">
                                    <div class="col-xs-12 text-center">
                                        <h5 class="text-center btn btn-primary btn-sm btn-shrink">
                                            <i class="fa fa-user-times"></i> Delete Your Profile
                                        </h5>
                                    </div>
                                </div>
                                <div id="msg2"><h3 class="right-panel-title pull-left" style="color:green;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($msg)) {
                                            echo $msg;
                                        } ?></h3></div>
                                <div class="col-sm-offset-2 col-sm-8 col-xs-12" style="">

                                    <div class="">
                                        <div class="row mb-5">
                                            <div class="col-xs-4">Name :</div>
                                            <div class="col-xs-8"><?= $_SESSION['uname'] ?></div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-xs-4">Matri ID :</div>
                                            <div class="col-xs-8"><?= $_SESSION['user_id'] ?></div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-xs-4">Email :</div>
                                            <div class="col-xs-8"><?= $_SESSION['email'] ?></div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-xs-4">Phone :</div>
                                            <div class="col-xs-8"><?= $_SESSION['mobile'] ?></div>
                                        </div>
                                        <form name="MatriForm" id="MatriForm" class="" action="" onsubmit="return confirm('Are you sure you want to delete your profile?')" method="post">
                                            <div class="row mb-5">
                                                <div class="col-xs-4">Reason to Delete :</div>
                                                <div class="col-xs-8">
                                                    <select class="form-control" name="message" id="message" required>
                                                        <option value="">Select Reason to Delete</option>
                                                        <option value="Marriage fixed">Marriage Fixed</option>
                                                        <option value="Not interested now">Not interested now</option>
                                                        <option value="No suitable match found">No suitable match found </option>
                                                        <option value="Found my match through samyakmatrimony">Found my match through samyakmatrimony</option>
                                                        <option value="Need to create new profile">Need to create new profile</option>
                                                        <option value="Not Listed">Not Listed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-xs-12 text-center">
                                                    <button type="submit" name="submit" value="Submit"
                                                            class="btn btn-danger "
                                                            style="cursor:pointer;">
                                                        <i class="fa fa-paper-plane-o"></i>Delete Profile
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
<!---------------Jquery Form validation End------------------>
<!--------------------status Meassage---------------------------------------->
<script>
    $(document).ready(function (e) {

        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();

        if ($('#msg2').html() != '') {
            setTimeout(function () {
                $("#msg2").css("opacity", 0);
                $("#msg2").html('');
            }, 4000);
        }
    });
</script>
</body>


</html>