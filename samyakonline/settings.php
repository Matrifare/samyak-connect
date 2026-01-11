<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 31/12/2019
 * Time: 9:51 PM
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
unset($_SESSION['family_origin']);
unset($_SESSION['occupation']);
unset($_SESSION['country']);
unset($_SESSION['state']);
unset($_SESSION['city']);
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
unset($_SESSION['samyak_id']);
unset($_SESSION['samyak_id_search']);
unset($_SESSION['samyak_search']);
unset($_SESSION['search_by_profile_id']);

$select = "select r.mobile_verify_status, r.email_verify_status, r.request_photo_id from register_view r where r.matri_id='" . $_SESSION['user_id'] . "'";
$exe = $DatabaseCo->dbLink->query($select) or die(mysqli_error($DatabaseCo->dbLink));
$fetch = mysqli_fetch_array($exe);
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
    <style>
        a {
            color: #000;
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
                    <a href="homepage">Homepage</a> |
                    <a target="_blank"
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
                            <li><a href="homepage">Home</a></li>
                            <li><a href="#">Settings</a></li>
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
                                        <h3 style="font-size: 15px; text-transform: capitalize;">Settings</h3>
                                    </div>

                                </div>

                            </div>

                            <div class="mt-10">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <a href="change-password" style="font-size: 15px;">Change Password</a>
                                        </div>
                                        <div class="col-xs-2">
                                            <a href="change-password"><i class="fa fa-2x fa-edit"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-10">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <a href="change-contact-detail" style="font-size: 15px;">Edit Contact
                                                Details</a>
                                        </div>
                                        <div class="col-xs-2">
                                            <a href="change-contact-detail"><i class="fa fa-2x fa-edit"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-10">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <a href="contact-security" style="font-size: 15px;">Contact Security</a>
                                        </div>
                                        <div class="col-xs-2">
                                            <a href="contact-security"><i class="fa fa-2x fa-edit"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-10">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <a href="edit_photo" style="font-size: 15px;">Edit Photo</a>
                                        </div>
                                        <div class="col-xs-2">
                                            <a href="edit_photo"><i class="fa fa-2x fa-edit"></i> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="edit-profile" style="font-size: 15px;">Edit Profile</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="edit-profile"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="my-matches" style="font-size: 15px;">Edit Match</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="my-matches"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="photo-security" style="font-size: 15px;">Photo Hide/Unhide</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="photo-security"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="profile-security" style="font-size: 15px;">Profile
                                                    Hide/Unhide</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="profile-security"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="update-descriptions" style="font-size: 15px;">
                                                    Profile Description Update
                                                </a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="update-descriptions"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="express-interest-privacy" style="font-size: 15px;">Express
                                                    Interest
                                                    / View Contact Privacy</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="profile-security"><i class="fa fa-2x fa-edit"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a href="delete_profile" style="font-size: 15px;">Delete Profile</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="delete_profile"><i class="fa fa-2x fa-trash-o"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-xs-12">

                                        <div class="section-title-3 mt-50">
                                            <h3 style="font-size: 15px; text-transform: capitalize;">Profile Trust
                                                Status</h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-10">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <a style="font-size: 15px;">Phone Number</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <?php if ($fetch['mobile_verify_status'] == 'Yes') { ?>
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
                                                <?php if ($fetch['email_verify_status'] == 'Yes') { ?>
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
                                                <a href="update-photo-id-proof" style="font-size: 15px;">Photo Id Proof
                                                    Verification</a>
                                            </div>
                                            <div class="col-xs-2">
                                                <?php if ($fetch['request_photo_id'] == 2) { ?>
                                                    <i class="fa fa-2x fa-check-square-o text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-2x fa-times text-danger"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-offset-1 col-xs-10">
                                    <p class="mt-30 text-center">By verifying email address, mobile number, and Photo Id
                                        Proof trust score will be increased.
                                        Profile having good trust score gets more interest from other users</p>
                                </div>

                                <div class="col-xs-12 mt-30">
                                    <?php if ($fetch['email_verify_status'] != 'Yes') { ?>
                                        <p><b>*Note</b> - To verify your email, please check your email id, you should
                                            have received an email verification.</p>
                                    <?php } ?>
                                    <?php if ($fetch['request_photo_id'] != 2) { ?>
                                        <p><b>*Note</b> - To verify your Photo ID proof, kindly send your photo id proof
                                            on
                                            <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or
                                            click on below button to send it on WhatsApp.</p>

                                        <a target="_blank" class="btn btn-success btn-shrink btn-sm"
                                           style="background-color: #25d366;"
                                           href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                                    class="fa fa-whatsapp"></i> Send Now</a>
                                    <?php } ?>
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
    <script type="text/javascript" src="<?= auto_version('js/customs.js') ?>"></script>

    <script type="text/javascript" src="js/select2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-toolkit.min.js"></script>
    <script type="text/javascript" src="js/device.js"></script>

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