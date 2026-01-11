<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/11/2018
 * Time: 6:58 PM
 */
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
require_once 'auth.php';
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
$configObj = new Config();

$matri_id = $_SESSION['user_id'];
$mobile = (strlen($_SESSION['mobile']) == 13 ? substr($_SESSION['mobile'], 3, 10) : $_SESSION['mobile']);
$getnew_data = mysqli_fetch_object($DatabaseCo->dbLink->query("select * from payments where pmatri_id='$matri_id'"));

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
    <link rel="stylesheet" href="css/select2.min.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        table#profile-statistics tr td {
            text-align: center;
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

        <div class="breadcrumb-wrapper">
            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="homepage">Dashboard</a></li>
                            <li><a href="profile-statistics">Profile Statistics</a></li>
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

                            <div id="detail-content-sticky-nav-03" class="pt-30">
                                <div class="section-title-3">
                                    <h3 style="font-size: 18px; text-transform: capitalize;">Express Interest <button class="btn btn-danger btn-sm btn-shrink"
                                                                 onclick="newWindow('web-services/express-interest-list?matri_id=<?= $matri_id ?>&name=<?= $_SESSION['uname'] ?>&mobile=<?= $mobile ?>&pending_send=yes','','800','700');"
                                                                 style="margin-left: 10px;"><i class="fa fa-whatsapp"></i> Get on WhatsApp</button></h3>
                                </div>

                                <div class="detail-review-wrapper">

                                    <div class="review-score-wrapper border mb-30" style="padding: 15px 20px 0px;">

                                        <table id="profile-statistics" width="100%" align="center" cellpadding="2"
                                               cellspacing="0" style="border-collapse:separate; border-spacing: 0 1em;">
                                            <tr>
                                                <td></td>
                                                <td>Pending</td>
                                                <td>Accepted</td>
                                                <td>Rejected</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><i
                                                            class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                    Received
                                                </td>
                                                <td>
                                                    <a href="express-interest?type=received"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT expressinterest.ei_sender FROM expressinterest,register_view
 WHERE register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$matri_id'
  and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Pending' and register_view.status <> 'Suspended'")) ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="express-interest#tab_2-02"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT ei_sender FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$matri_id' and expressinterest.trash_receiver='No'
  and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended'")); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="express-interest#tab_2-03"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT ei_id FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$matri_id' and expressinterest.trash_receiver='No'
  and expressinterest.receiver_response='Reject' and register_view.status <> 'Suspended'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><i
                                                            class="glyphicon glyphicon-sort-by-attributes-alt"></i> Sent
                                                </td>
                                                <td>
                                                    <a href="express-interest?type=sent"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT expressinterest.ei_receiver FROM expressinterest,register_view
 WHERE register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$matri_id' and expressinterest.trash_sender='No'
  and expressinterest.receiver_response='Pending' and register_view.status <> 'Suspended'")) ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="express-interest?type=sent#tab_1-02"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT ei_receiver FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$matri_id' and expressinterest.trash_sender='No'
  and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended'")); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="express-interest?type=sent#tab_1-03"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?= mysqli_num_rows($DatabaseCo->dbLink->query("
SELECT DISTINCT ei_id FROM expressinterest,register_view
 WHERE register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$matri_id' and expressinterest.trash_sender='No' and
  expressinterest.receiver_response='Reject' and register_view.status <> 'Suspended'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div id="detail-content-sticky-nav-04" class="pt-30">

                                <div class="section-title-3">
                                    <h3 style="font-size: 18px; text-transform: capitalize;">Messages <button class="btn btn-danger btn-sm btn-shrink"
                                                         onclick="newWindow('web-services/received-message-list?matri_id=<?= $matri_id ?>&name=<?= $_SESSION['uname'] ?>','','800','700');"
                                                         style="margin-left: 10px;"><i class="fa fa-whatsapp"></i> Get on WhatsApp</button></h3>
                                </div>

                                <div class="detail-review-wrapper">

                                    <div class="review-score-wrapper border mb-30" style="padding: 15px 20px 0px;">

                                        <table id="message-statistics" width="100%" align="center" cellpadding="2"
                                               cellspacing="0" style="border-collapse:separate; border-spacing: 0 1em;">
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Received Messages
                                                </td>
                                                <td>
                                                    <a href="messages?type=received"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT m.msg_id from message m INNER JOIN register_view r ON r.email = m.msg_from where m.msg_to='" . $_SESSION['email'] . "' and m.trash_receiver='No'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Sent Messages
                                                </td>
                                                <td>
                                                    <a href="messages#tab_2-02"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT m.msg_id from message m INNER JOIN register_view r ON r.email = m.msg_to where m.msg_from='" . $_SESSION['email'] . "' and m.trash_sender='No'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="detail-content-sticky-nav-03" class="pt-30">

                                <div class="section-title-3">
                                    <h3 style="font-size: 18px; text-transform: capitalize;">Statistics <button class="btn btn-danger btn-sm btn-shrink"
                                                           onclick="newWindow('web-services/express-interest-msg?matri_id=<?= $matri_id ?>&name=<?= $_SESSION['uname'] ?>&mobile=<?= $mobile ?> ?>','','800','700')"
                                                           style="margin-left: 10px;"><i class="fa fa-whatsapp"></i> Get on WhatsApp</button></h3>
                                </div>

                                <div class="detail-review-wrapper">

                                    <div class="review-score-wrapper border mb-30" style="padding: 15px 20px 0px;">

                                        <table width="100%" align="center" cellpadding="2" cellspacing="0"
                                               style="border-collapse:separate; border-spacing: 0 1em;">
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Short Listed Profiles By Me
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=bookmark"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view where status!= 'Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' and matri_id IN (select to_id from shortlist where from_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "')")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                                </td>
                                                <td>
                                                    Block Listed Profiles By Me
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=block"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT * from register_view JOIN block_profile ON block_profile.block_to=register_view.matri_id where block_profile.block_by='" . $_SESSION['user_id'] . "' and register_view.gender!='" . $_SESSION['gender123'] . "' and register_view.status!='Inactive' and register_view.status!='Suspended' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Profiles visited by Me
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=viewed"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view where gender!='" . $_SESSION['gender123'] . "' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select viewed_member_id from `who_viewed_my_profile` where  my_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY index_id DESC")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Visitor List of My Profile
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=visitor"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view where gender!='" . $_SESSION['gender123'] . "' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select my_id from who_viewed_my_profile where viewed_member_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY index_id DESC")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Contact Details of profiles viewed by me
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=viewed_contacts"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT register_view.index_id FROM contact_checker INNER JOIN register_view ON contact_checker.viewed_id=register_view.matri_id where contact_checker.my_id='" . $_SESSION['user_id'] . "' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="glyphicon glyphicon-sort-by-attributes-alt"></i>
                                                </td>
                                                <td>
                                                    Who Viewed my Contact Details
                                                </td>
                                                <td>
                                                    <a href="show_more_profiles?type=viewed_my_contact"
                                                       class="btn btn-default btn-shrink btn-sm">
                                                        <?php echo mysqli_num_rows($DatabaseCo->dbLink->query("SELECT register_view.index_id FROM contact_checker INNER JOIN register_view ON contact_checker.my_id=register_view.matri_id where contact_checker.viewed_id='" . $_SESSION['user_id'] . "' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'")); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title-3">
                                <h3>Plan Details</h3>
                            </div>

                            <div class="destination-list-sm-wrapper mmb-10">

                                <div class="GridLex-gap-10-wrapper">

                                    <div class="GridLex-grid-noGutter-equalHeight">

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">
                                                <a href="javascript:void(0)">
                                                    <div class="content">
                                                        <h5><?php echo $getnew_data->p_plan;?> Plan</h5>
                                                        <p><?php echo $getnew_data->p_amount;?></p>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">

                                                <a href="javascript:void(0)">

                                                    <div class="content">
                                                        <h5>Duration</h5>
                                                        <p><?php echo $getnew_data->plan_duration.' Days';?></p>
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">

                                                <a href="javascript:void(0)">

                                                    <div class="content">
                                                        <h5>Contact</h5>
                                                        <p class="mb-5"><?php echo $getnew_data->p_no_contacts;?></p><p>(Used : <?php echo ($getnew_data->r_cnt);?>)</p>
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">

                                                <a href="javascript:void(0)">

                                                    <div class="content">
                                                        <h5>View Profile</h5>
                                                        <p class="mb-5"><?php echo $getnew_data->profile;?></p><p>(Used : <?php echo ($getnew_data->r_profile);?>)</p>
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">

                                                <a href="javascript:void(0)">

                                                    <div class="content">
                                                        <h5>Message</h5>
                                                        <p class="mb-5"><?php echo $getnew_data->p_msg;?></p><p>(Used : <?php echo ($getnew_data->r_sms);?>)</p>
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

                                        <div class="GridLex-col-2_sm-4_xs-6_xss-12">

                                            <div class="destination-list-sm-item mb-10 text-center">

                                                <a href="javascript:void(0)">

                                                    <div class="content">
                                                        <h5>Expiry Date</h5>
                                                        <p><?php echo date("d M Y", (strtotime($getnew_data->exp_date)));?></p>
                                                    </div>

                                                </a>

                                            </div>

                                        </div>

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
    });
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
</script>
</body>
</html>