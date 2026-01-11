<?php

/** * Created by PhpStorm.
 * User: Manish
 * Date: 09/02/2021
 * Time: 06:45 PM
 */

require_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'auth.php';
include_once 'lib/Config.php';
$configObj = new Config();
$sql4 = $DatabaseCo->dbLink->query("select * from payment_method where pay_name='Bank Detail'");
$row4 = mysqli_fetch_array($sql4);
?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;
 charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    <!-- Title Of Site --> <title>
        Samyakmatrimony</title>    <title><?php echo $configObj->getConfigTitle();
        ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword();
    ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription();
    ?>"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon();
    ?>" rel="shortcut icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">    <!-- CSS Cores and Plugins -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
    <link href="css/animate.css" rel="stylesheet">
    <link href="<?= auto_version("css/main.css") ?>" rel="stylesheet">
    <link href="css/component.css" rel="stylesheet">    <!-- CSS Font Icons -->
    <link rel="stylesheet" href="icons/open-iconic/font/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="icons/rivolicons/style.css">
    <link rel="stylesheet" href="icons/streamline-outline/flaticon-streamline-outline.css">
    <link rel="stylesheet" href="icons/around-the-world-icons/around-the-world-icons.css">
    <link rel="stylesheet" href="icons/et-line-font/style.css">    <!-- CSS Custom -->
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">    <!-- Add your style -->
    <link href="css/your-style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>    <![endif]-->
    <link href="<?= auto_version("css/membership.css") ?>" rel="stylesheet">
</head>
<body class="not-home" style="overflow-x: hidden;
">
<div style="overflow-x: hidden;
">    <?php @include_once 'page-parts/modal.php' ?> <!-- start Container Wrapper -->
    <div class="container-wrapper colored-navbar-brand">
        <!-- start Header --> <?php @include_once 'layouts/menu.php' ?> <!-- end Header -->
        <div class="clear"></div>        <!-- start Main Wrapper -->
        <div class="main-wrapper">
            <div class="sub-menu-content">
                <div class="new-sub-menu">
                    <div class="sub-menu-list"><a href="homepage"> Dashboard</a>
                        | <?php if (!empty($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid') { ?>
                            <a href="current_plan"> My Plan</a> |                        <?php } ?> <a
                                href="contact_us">Contact Us</a>
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
                                <li class="active"><a href="premium_member">Premium Member</a></li>
                            </ol>
                        </div>
                        <div class="col-xs-12 col-sm-4 hidden-xs"><p class="hot-line"><i class="fa fa-phone"></i> <a
                                        href="tel:+91-79779-93616"> Help Line: +91-79779-93616</a></p></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="equal-content-sidebar-by-gridLex">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="container-fluid mobile-padding-lr0">
                            <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                                <div class="LV-package-box">
                                    <div class="padd-60">
                                        <div class="row text-center">
                                            <ul class="nav nav-pills pckg-option text-center">
                                                <li class="active"><a data-toggle="pill" class="bor-r-l" href="#Online">Online</a>
                                                </li>
                                                <li><a class="bor-r-r" data-toggle="pill" href="#Personalized">Personalized </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content plans-box">
                                                <div id="Online" class="tab-pane fade active in gallery"><p
                                                            class="plan-tagline"> All online services are self-assisted.
                                                        Search, Shortlist and Send
                                                        Interest. </p> <?php $get_free = $DatabaseCo->dbLink->query("select * from membership_plan where status='APPROVED'");
                                                    $i = 0;
                                                    $colorsArray = ['#e8d954', '#92d6f5', '#a6e451'];
                                                    while ($sql_data = mysqli_fetch_object($get_free)) { ?>
                                                        <div class="row m-10">
                                                            <div class="col-md-12 col-sm-12 col-xs-12 packages-section ">
                                                                <div class="col-md-3 col-sm-3 col-xs-3 LV-Basic"
                                                                     style="background-color: <?= $colorsArray[$i] ?>;
                                                                             "><h2
                                                                            class="color-black"><?= ucfirst($sql_data->plan_name) ?></h2>
                                                                    <p class="color-black font-weight-bold"><?= floor($sql_data->plan_duration / 30) ?>
                                                                        Months</p></div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 get-contacts">
                                                                    <div class="get-contacts-detail"><p>View</p>
                                                                        <h3><?= $sql_data->plan_contacts ?></h3>
                                                                        <p>Contacts</p></div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 validity-offer-section">
                                                                    <div class="get-validity-detail"><p>Send SMS</p>
                                                                        <h3><?= $sql_data->plan_msg ?></h3>
                                                                        <p>Messages</p></div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 final-price-section">
                                                                    <div class="price-detail"><p><span
                                                                                    class="hidden-xs hidden-sm">Final</span>
                                                                            Price</p>
                                                                        <h3>
                                                                            <i class="fa fa-rupee"></i> <?= $sql_data->plan_amount ?>
                                                                        </h3>
                                                                        <button type="button"
                                                                                onclick="upgradeMembership(<?= $sql_data->plan_id ?>);
                                                                                        "
                                                                                class="btn btn-theme border-r-50 btn-LV-Basic ripplelink"
                                                                                style="background-color: #d60d45;
"> Buy Now
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        <?php $i++;
                                                    } ?>
                                                    <div class="row row-padded plan-features row-bordered text-center pt-20">
                                                        <h3>Features of Paid Membership</h3>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-address-card-o"></i></span>
                                                            <h5>View Contact Details</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-mobile-phone"></i></span>
                                                            <h5>View Mobile Number</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-commenting-o"></i></span>
                                                            <h5>Chat online members</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-envelope-o"></i></span>
                                                            <h5>Send Messages / SMS </h5></div>
                                                    </div>
                                                    <div class="div padding-15">
                                                        <div class="section-title-3 text-left"><h3 style="text-transform: capitalize;
">Other Online Payment Options</h3></div>
                                                        <div class="row">
                                                            <div class="col-sm-4"><a
                                                                        href="https://www.instamojo.com/@Samyakonline/l231428f3f90741ce8b6f8a76e18f4955/"
                                                                        rel="im-checkout" data-text="Buy 3 Month Plan"
                                                                        data-css-style="color:#ffffff;
 background:#75c26a;
 width:180px;
 border-radius:4px" data-layout="vertical"></a>
                                                                <script src="https://js.instamojo.com/v1/button.js"></script>
                                                            </div>
                                                            <div class="col-sm-4"><a
                                                                        href="https://www.instamojo.com/@Samyakonline/l4da9f8f1ff12456fbc4e6704ffbbff74/"
                                                                        rel="im-checkout" data-text="Buy 6 Month Plan"
                                                                        data-css-style="color:#ffffff;
 background:#75c26a;
 width:180px;
 border-radius:4px" data-layout="vertical"></a>
                                                                <script src="https://js.instamojo.com/v1/button.js"></script>
                                                            </div>
                                                            <div class="col-sm-4"><a
                                                                        href="https://www.instamojo.com/@Samyakonline/lf6d2c18f863d4ca195f4bc7698146dc2/"
                                                                        rel="im-checkout" data-text="Buy 1 Yr Plan"
                                                                        data-css-style="color:#ffffff;
 background:#75c26a;
 width:180px;
 border-radius:4px" data-layout="vertical"></a>
                                                                <script src="https://js.instamojo.com/v1/button.js"></script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="Personalized" class="tab-pane fade gallery"><p
                                                            class="plan-tagline mt-5 mb-0">You will get personal
                                                        assistance from Samyakmatrimony
                                                        team.</p> <?php $get_free = $DatabaseCo->dbLink->query("select * from membership_plan where status='PERSONALIZED'");
                                                    $i = 0;
                                                    $colorsArray = ['#a6e451', '#e8d954', '#92d6f5'];
                                                    while ($sql_data = mysqli_fetch_object($get_free)) { ?>
                                                        <div class="row m-10">
                                                            <div class="col-md-12 col-sm-12 col-xs-12 packages-section ">
                                                                <div class="col-md-3 col-sm-3 col-xs-3 LV-Basic"
                                                                     style="background-color: <?= $colorsArray[$i] ?>">
                                                                    <h2 class="color-black"><?= ucfirst($sql_data->plan_name) ?></h2>
                                                                    <p class="color-black font-weight-bold"><?= floor($sql_data->plan_duration / 30) ?>
                                                                        Months</p></div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 get-contacts">
                                                                    <div class="get-contacts-detail"><p>View</p>
                                                                        <h3><?= $sql_data->plan_contacts ?></h3>
                                                                        <p>Contacts</p></div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 validity-offer-section">
                                                                    <div class="get-validity-detail"><p>Send SMS</p>
                                                                        <h3><?= $sql_data->plan_msg ?></h3>
                                                                        <p>Messages</p></div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-3 final-price-section">
                                                                    <div class="price-detail"><p><span
                                                                                    class="hidden-xs hidden-sm">Final</span>
                                                                            Price</p>
                                                                        <h3>
                                                                            <i class="fa fa-rupee"></i> <?= $sql_data->plan_amount ?>
                                                                        </h3>
                                                                        <button type="button"
                                                                                onclick="upgradeMembership(<?= $sql_data->plan_id ?>)"
                                                                                class="btn btn-theme border-r-50 btn-LV-Basic ripplelink"
                                                                                style="background-color: #d60d45;
"> Buy Now
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        <?php $i++;
                                                    } ?>
                                                    <div class="row row-padded plan-features row-bordered pt-20 text-center">
                                                        <h3>All Paid Membership Features + Personal Assistance</h3>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-thumbs-o-up"></i></span>
                                                            <h5>Dedicated Relationship Manager</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-users"></i></span>
                                                            <h5 class="feature-mobh">Receive Profiles on
                                                                WhatsApp/Email</h5>
                                                            <h5 class="feature-mobs">Receive Profiles <br/>on
                                                                WhatsApp/Email</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-list-ul"></i></span>
                                                            <h5>Assistance for meeting <br/>with interested profiles
                                                            </h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-user-o"></i></span>
                                                            <h5>Highlighted as a <br/> Featured Profile</h5></div>
                                                    </div>
                                                    <div class="row row-padded plan-features row-bordered p-t text-center">
                                                        <hr>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-address-card-o"></i></span>
                                                            <h5>View Contact Details</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-mobile-phone"></i></span>
                                                            <h5>View Mobile Number</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-commenting-o"></i></span>
                                                            <h5>Chat online members</h5></div>
                                                        <div class="col-sm-3 col-xs-6"><span class="feature-steps"><i
                                                                        class="fa fa-envelope-o"></i></span>
                                                            <h5>Send Messages / SMS </h5></div>
                                                    </div>
                                                    <div class="text-center"><br>
                                                        <p class="btn btn-blue bor-r50 btn-big ripplelink"
                                                           id="HP_Membership_CTA">For More Details, call us @ <a
                                                                    href="tel:+91-79779-93616" class="color-white">+91-79779-93616</a>
                                                        </p></div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-xs-12" style="padding: 0px 30px;
"><p class="plan-tagline font-weight-bold text-left mb-0"> Please Note: </p>
                                                            <ul class="text-left">
                                                                <li>1. You need to ensure the details in your profile to
                                                                    be correct to get the maximum matches.
                                                                </li>
                                                                <li>2. We will send you the latest matches on email and
                                                                    WhatsApp.
                                                                </li>
                                                                <li>3. You need to Accept/Reject interests to get the
                                                                    matches.
                                                                </li>
                                                                <li> 4. Get more details on WhatsApp Chat <a
                                                                            target="_blank"
                                                                            class="btn btn-success btn-shrink btn-sm"
                                                                            style="background-color: #25d366;
"
                                                                            href="https://api.whatsapp.com/send?phone=917977993616&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am interested in Personalized Elite Plan on Samyakmatrimony.">
                                                                        <i class="fa fa-whatsapp"></i> Chat Now</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="div padding-15" style="padding-top: 0px !important;
"><p class="text-danger text-center mt-0" style="margin-top:0px;
 margin-bottom: 15px;
">Note: In case your profile details looks suspicious, we can ask for your photo identity proof.</p>
                                                <div class="section-title-3 text-left"><h3 style="text-transform: capitalize;
">Bank Payment Transfer Options</h3></div>
                                                <p class="text-left"><b>ICICI Bank</b> : Pavan Dongre A/c No :
                                                    000401622735<br/> [ IFSC Code: ICIC0000004 - Branch : Nariman Point,
                                                    Mumbai] <br/><br/> <b>SBI Bank</b> : Pavan Dongre A/c No :
                                                    0030291101831<br/> [ IFSC Code SBIN0001053 - Branch : Wagle
                                                    Estate,Thane] </p>
                                                <div class="section-title-3 text-left"><h3 style="text-transform: capitalize;
">UPI Payment Options</h3></div>
                                                <p class="text-center font-weight-bold" style="color: #D60D45;
font-size: 15px;
">You can Pay by Google Pay /PhonePay/PayTM on 9819725425</p>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-12">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="$('#gpay-container').slideToggle();
"> Gpay QR Code Show/Download
                                                        </button>
                                                        <div id="gpay-container" style="display: none;
"><img src="images/googlepay_payment.jpeg" class="img-responsive" alt="Google Pay QR Code"/></div>
                                                    </div>
                                                    <div class="col-md-6 col-xs-12">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="$('#phonepe-container').slideToggle();
"> PhonePe QR Code Show/Download
                                                        </button>
                                                        <div id="phonepe-container" style="display: none;
"><img src="images/phonepe_payment.jpeg" class="img-responsive" alt="PhonePe QR Code"/></div>
                                                    </div>
                                                    <div class="col-xs-12 mt-40"><p>After paying from UPI, kindly call
                                                            us on <a href="tel:+91-79779-93616">+91-79779-93616</a> or
                                                            you can inform us on WhatsApp by <a target="_blank"
                                                                                                class="btn btn-success btn-shrink btn-sm"
                                                                                                style="background-color: #25d366;
"
                                                                                                href="https://api.whatsapp.com/send?phone=917977993616&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0A">
                                                                <i class="fa fa-whatsapp"></i> Clicking here</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        <!-- row end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div> <?php @include_once 'layouts/footer.php' ?>            </div>
        </div>
    </div>    <!-- jQuery Cores -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>    <!-- Bootstrap Js -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugins - serveral jquery plugins that use in this template -->
    <script type="text/javascript" src="js/plugins.js"></script>    <!-- Custom js codes for plugins -->
    <script type="text/javascript" src="<?= auto_version("js/customs.js") ?>"></script>
    <script type="text/javascript" src="js/express_interest.js"></script>
    <script type="text/javascript" src="js/select2.full.js"></script>
    <script src="https://js.instamojo.com/v1/button.js"></script>
    <script type="text/javascript">
        function upgradeMembership(planId) {
            $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/premium_membership_selection", //Where to make Ajax calls
                    dataType: 'json',
                    data: {'planId': planId},
                    beforeSend: function () {
                        $("#loader-animation-area").show();
                    }, success: function (response) {
                        if (response.result == 'success') {
                            $("#loader-animation-area").show();
                            window.location.href = 'web-services/premium_member_payment';
                        } else {
                            $("#loader-animation-area").hide();
                            alert("Something went wrong, please try again later.");
                        }
                    }
                }
            )
            ;
        }    </script>
</body>
</html>