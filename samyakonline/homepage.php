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
unset($_SESSION['occupation']);
unset($_SESSION['country']);
unset($_SESSION['state']);
unset($_SESSION['city']);
unset($_SESSION['family_origin']);
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
unset($_SESSION['other_caste']);
unset($_SESSION['special_case']);
unset($_SESSION['orderby']);
unset($_SESSION['samyak_id_search']);
unset($_SESSION['samyak_search']);
unset($_SESSION['search_by_profile_id']);

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
    <link rel="stylesheet" href="css/select2.min.css"/>

    <!-- CSS Custom -->
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">

    <!-- Add your style -->
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            /*border:1px solid #aaa;*/
            border-radius: 0px;
            cursor: text;
            margin-bottom: 3px;
            overflow: hidden !important;
            height: auto !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0 5px;
            width: 100%
            overflow: hidden !important;
            height: auto !important;
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
                    <a href="search"> Search</a> |
                       <a href="messages?type=received">Message</a> |
                    <a href="express-interest"> Pending Interest
                        <?php if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) {
                            echo "(" . mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT e.ei_sender FROM expressinterest e LEFT JOIN register_view r 
                                ON e.ei_receiver=r.matri_id WHERE e.ei_receiver='" . $_SESSION["user_id"] . "' and e.trash_receiver='No' and
                                 e.trash_sender='No' and e.receiver_response='Pending' and r.status <> 'Suspended'")) . ")";
                        }
                        ?>
                    </a>
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

                    <div class="GridLex-col-3_sm-4_xs-12_xss-12">

                        <?php @include_once 'layouts/sidebar.php' ?>

                    </div>

                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">

                        <div class="content-wrapper">

                            <div class="row">

                                <div class="col-xs-12 text-center">

                                    <h4 class="text-center btn btn-primary btn-shrink btn-sm mb-20 hidden-xss hidden-xs"
                                        style="font-size:14px;text-transform: capitalize;" id="current_heading">Recently
                                        Joined Premium Members</h4>

                                </div>

                            </div>

                            <div class="row">
                                <div id="profiles_list_content"></div>
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

<!-- BEGIN # MODAL CONTACT DETAIL -->
<div class="modal fade modal-border-transparent" id="adViewModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <button type="button" class="btn btn-close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    padding: 5px;
    margin-top: 0px;
    float: right;
    color: white;" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
            <div class="modal-body pb-10" id="adViewContentModal">
                <?php
                if (!empty($_SESSION["membership"]) && $_SESSION['membership'] == 'Free') {
                    $sql = "select * from advertisement where adv_level='free-member' and status='APPROVED' order by adv_date DESC LIMIT 1";
                    $count = $DatabaseCo->dbLink->query($sql);
                    $isAdPresent = mysqli_num_rows($count);
                    if ($isAdPresent > 0) {
                        $_SESSION['show_member_ad'] = true;
                        $data = mysqli_fetch_object($count);
                        $image = $data->adv_img;
                        $advLink = $data->adv_link;
                        echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='Free Member Offer' title='Free Member Offer' /></a>";
                    }
                } else if (!empty($_SESSION["membership"]) && $_SESSION['membership'] != 'Free') {
                    $sql = "select * from advertisement where adv_level='paid-member' and status='APPROVED' order by adv_date DESC LIMIT 1";
                    $count = $DatabaseCo->dbLink->query($sql);
                    $isAdPresent = mysqli_num_rows($count);
                    if ($isAdPresent > 0) {
                        $_SESSION['show_member_ad'] = true;
                        $data = mysqli_fetch_object($count);
                        $image = $data->adv_img;
                        $advLink = $data->adv_link;
                        echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='Paid Member Offer' title='Paid Member Offer' /></a>";
                    } else {
                        if (!empty($_SESSION["membership"]) && in_array(trim($_SESSION['membership']), ['Silver', 'Gold', 'Premium'])) {
                            $sql = "select * from advertisement where adv_level='premium-member' and status='APPROVED' order by adv_date DESC LIMIT 1";
                            $count = $DatabaseCo->dbLink->query($sql);
                            $isAdPresent = mysqli_num_rows($count);
                            if ($isAdPresent > 0) {
                                $_SESSION['show_member_ad'] = true;
                                $data = mysqli_fetch_object($count);
                                $image = $data->adv_img;
                                $advLink = $data->adv_link;
                                echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='Paid Member Offer' title='Paid Member Offer' /></a>";
                            }
                        } else if (!empty($_SESSION["membership"]) && in_array(trim($_SESSION['membership']), ['Classic', 'Classic Plus'])) {
                            $sql = "select * from advertisement where adv_level='classic-member' and status='APPROVED' order by adv_date DESC LIMIT 1";
                            $count = $DatabaseCo->dbLink->query($sql);
                            $isAdPresent = mysqli_num_rows($count);
                            if ($isAdPresent > 0) {
                                $_SESSION['show_member_ad'] = true;
                                $data = mysqli_fetch_object($count);
                                $image = $data->adv_img;
                                $advLink = $data->adv_link;
                                echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='Paid Member Offer' title='Paid Member Offer' /></a>";
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN # MODAL CONTACT DETAIL -->
<div class="modal fade modal-border-transparent" id="promoteViewModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <button type="button" class="btn btn-close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    padding: 5px;
    margin-top: 0px;
    float: right;
    color: white;" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
            <div class="modal-body pb-10" id="promoteViewContentModal">
                <?php
                if (!empty($_SESSION['pendingInterest'])) {
                    $sql = "select * from advertisement where adv_level='pending-interest' and status='APPROVED' order by adv_date DESC LIMIT 1";
                    $count = $DatabaseCo->dbLink->query($sql);
                    $isAdPresent = mysqli_num_rows($count);
                    if ($isAdPresent > 0) {
                        $_SESSION['ad_promote_pending_interest'] = true;
                        $data = mysqli_fetch_object($count);
                        $image = $data->adv_img;
                        $advLink = $data->adv_link;
                        echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='" . $data->adv_name . "' title='" . $data->adv_name . "' /></a>";
                    }
                } else if (!empty($_SESSION['pending_order'])) {
                    $sql = "select * from advertisement where adv_level='pending-order' and status='APPROVED' order by adv_date DESC LIMIT 1";
                    $count = $DatabaseCo->dbLink->query($sql);
                    $isAdPresent = mysqli_num_rows($count);
                    if ($isAdPresent > 0) {
                        $_SESSION['ad_promote_pending_order'] = true;
                        $data = mysqli_fetch_object($count);
                        $image = $data->adv_img;
                        $advLink = $data->adv_link;
                        echo "<a href='$advLink' target='_blank'><img class='img img-responsive' src='advertise/" . $image . "' alt='" . $data->adv_name . "' title='" . $data->adv_name . "' /></a>";
                    }
                } else if (!empty($_SESSION['custom_ad'])) {
                    echo "<a href='" . $_SESSION['custom_adv_link'] . "' target='_blank'><img class='img img-responsive' src='advertise/" . $_SESSION['custom_adv_image'] . "' alt='" . $_SESSION['custom_adv_name'] . "' title='" . $_SESSION['custom_adv_name'] . "' /></a>";
                }
                ?>
            </div>
        </div>
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

<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script type="text/javascript" src="js/customs-validate.js?v=1.1"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="<?= auto_version('js/customs.js') ?>"></script>

<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/bootstrap-toolkit.min.js"></script>
<script type="text/javascript" src="js/device.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script>

    $(function () {
        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();
    });


    /*---------------Jquery Partener Caste Start-----------------*/
    $("#register_part_religion").on('select2:select', function () {
        var selectedReligion = $("#register_part_religion").val()
        var dataString = 'religion=' + selectedReligion;
        $("#loader-animation-area").show();
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "web-services/part_caste_search", //Where to make Ajax calls
            dataType: "text", // Data type, HTML, json etc.
            data: dataString,
            success: function (response) {
                $("#register_part_caste").remove();
                $('#CasteDiv1').find('option').remove().end().append(response);
                $(".chosen-select").css('width', '100%');
                $('.chosen-select').select2();
                $("ul > li > input").css('width', '100%');
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    });

    function ExpressInterest(toid, name) {
        $("#sendExpressInterestModal").modal("show");
        $.post("web-services/search_send_interest", "frmid=" + toid + "&name=" + name,
            function (data) {
                $("#expressInterestContentModal").html(data);
            });
    }
</script>
<!---
Some Scripts on runtime
-->
<?php
if (isset($_SESSION['last_login'])) { ?>
    <!-- Event snippet for registration conversion page -->
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-1066074472/9iiiCMXclusBEOiCrPwD'});
    </script>
<?php
@include_once 'page-parts/mobile_verification.php';
} else if (isset($_SESSION['partner_profile'])) { ?>
    <script>
        fillPartnerExpectations();
    </script>
<?php } ?>
</body>
<script language=JavaScript>
    var message = "Function Disabled!";

    function clickIE4() {
        if (event.button == 2) {
            return false;
        }
    }

    function clickNS4(e) {
        if (document.layers || document.getElementById && !document.all) {
            if (e.which == 2 || e.which == 3) {

                return false;
            }
        }
    }

    if (document.layers) {
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = clickNS4;
    } else if (document.all && !document.getElementById) {
        document.onmousedown = clickIE4;
    }

    document.oncontextmenu = new Function("return false")

</script>


<script type="text/javascript">


    $(function () {
        $.ajax({
            type: "POST", // HTTP method POST or GET
            url: "profiles_list", //Where to make Ajax calls
            dataType: 'html',
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function () {
                $("#loader-animation-area").show();
            },
            success: function (response) {
                $("#profiles_list_content").html(response);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
        <?php
        if(!empty($_SESSION['show_member_ad']) && $_SESSION['show_member_ad'] == true) { ?>
        if (!$.cookie('adSeen')) {
            $.cookie("adSeen", "yes", {path: '/'});
            $("#adViewModal").modal("show");
        }
        <?php } else if ((!empty($_SESSION['ad_promote_pending_interest']) && $_SESSION['ad_promote_pending_interest'] == true) ||
    (!empty($_SESSION['pending_order']) && $_SESSION['pending_order'] == true) ||
    (!empty($_SESSION['custom_ad']) && $_SESSION['custom_ad'] == true)){ ?>
        if (!$.cookie('adSeen')) {
            $.cookie("adSeen", "yes", {path: '/'});
            $("#promoteViewModal").modal("show");
        }
        <?php } ?>
    });
</script>

</html>