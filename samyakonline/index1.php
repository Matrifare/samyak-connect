<?php
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
//include_once 'lib/RedisLib.php';
$DatabaseCo = new DatabaseConnection();
//$cache = new RedisLib();
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

if (isset($_GET['invalid']) && $_GET['invalid'] == 'true') {
    echo "<script>alert('Your Username or Password is wrong.');</script>";
}
if (isset($_REQUEST['confirm_id'])) {
    $confid = mysqli_real_escape_string($DatabaseCo->dbLink, $_REQUEST['confirm_id']);
    $confemail = mysqli_real_escape_string($DatabaseCo->dbLink, $_REQUEST['email']);

    $select = mysqli_query($DatabaseCo->dbLink, "select * from register where email='$confemail' and cpassword='$confid' and status='Inactive' and last_login IS NULL");
    $exe = mysqli_num_rows($select);

    $reg_fet = mysqli_fetch_array($select);

    if ($exe > 0) {
        $gtp = mysqli_query($DatabaseCo->dbLink, "select * from membership_plan where plan_name='Free' limit 1");

        if (mysqli_num_rows($gtp) == 1) {
            $update = mysqli_query($DatabaseCo->dbLink, "update register set cpass_status='yes',status='Paid' where email='$confemail'");

            $rr = mysqli_fetch_array($gtp);

            $today1 = strtotime('now');
            $today = date("Y-m-d", $today1);
            $plan_duration = $rr['plan_duration'];
            $p_no_contacts = $rr['plan_contacts'];
            $p_msg = $rr['plan_msg'];
            $profile = $rr['profile'];
            $date = strtotime(date("Y-m-d", strtotime($today)) . +$plan_duration . " day");
            $exp_date = date('Y-m-d', $date);


            $pmatri_id = $reg_fet['matri_id'];
            $pname = $reg_fet['username'];
            $pemail = $reg_fet['email'];
            $paddress = $reg_fet['address'];


            mysqli_query($DatabaseCo->dbLink, "insert into payments (pmatri_id,pname,pemail,paddress, paymode,pactive_dt,p_plan,plan_duration,profile,video,chat,p_no_contacts, p_amount,p_bank_detail,p_msg,exp_date)
								 values('$pmatri_id','$pname','$pemail','$paddress','Other','$today','Free','$plan_duration','$profile','Yes','Yes','$p_no_contacts','0','','$p_msg','$exp_date')");
        } else {
            $update = mysqli_query($DatabaseCo->dbLink, "update register set cpass_status='yes',status='Active' where email='$confemail'");
        }
        ?>
        <script>alert('Your account has been activated.');</script>
        <?php echo "<script>window.location.href='index.php';</script>";
    } else { ?>
        <script>alert('Error in activation. Please Contact to Administrator.');</script>
        <?php echo "<script>window.location.href='contact_us'; </script>";
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" sizes="192x192" href="img/<?php echo $configObj->getConfigFevicon(); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="img/<?php echo $configObj->getConfigFevicon(); ?>">
    <link rel="icon" type="image/png" href="img/<?php echo $configObj->getConfigFevicon(); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="img/<?php echo $configObj->getConfigFevicon(); ?>" sizes="16x16">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#C70C41">
    <!-- Title Of Site -->
    <title><?php echo $configObj->getConfigTitle(); ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/<?php echo $configObj->getConfigFevicon(); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/<?php echo $configObj->getConfigFevicon(); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/<?php echo $configObj->getConfigFevicon(); ?>">
    <link rel="apple-touch-icon-precomposed" href="img/<?php echo $configObj->getConfigFevicon(); ?>">

    <!-- CSS Plugins -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
    <link href="css/animate.css" rel="stylesheet">
    <link href="<?= auto_version("css/main.css") ?>?v=1.0" rel="stylesheet">
    <link href="css/component.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/owl.carousel.min.css">
    <link rel="stylesheet" href="css/template.css?v=1.0">

    <!-- CSS Font Icons -->
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.min.css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
          rel='stylesheet' type='text/css'>

    <!-- CSS Custom -->
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">
    <link href="<?= auto_version('css/membership.css') ?>" rel="stylesheet">

    <!-- Add your style -->
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="css/select2.min.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .owl-prev, .owl-next {
            width: 15px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: block !important;
            border: 0px solid black;
        }

        .owl-prev {
            left: -15px;
        }

        .owl-next {
            right: -15px;
        }

        .owl-prev i, .owl-next i {
            color: #ccc;
        }
    </style>
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

<body class="">
<div style="overflow-x: hidden !important;">
    <?php @include_once 'page-parts/modal.php'; ?>

    <!-- start Container Wrapper -->
    <div class="container-wrapper colored-navbar-brand">

        <?php @include_once 'layouts/menu.php' ?>

        <div class="clear"></div>

        <!-- start Main Wrapper -->
        <div class="main-wrapper">

            <!-- start hero-header -->
            <div class="hero1"
                 style="background-image:url('img/buddhist-matrimonials.jpg');background-size: cover;height: 300px;">

                <div class="container">

                    <div class="text-center hidden-xs hidden-xss hidden-sm mt-70">
                        <h1 class="" style="font-weight: bold; font-size: 25px;color: #FFFFFF;">
                            India's No. 1 Exclusive Buddhist Matrimony
                        </h1>
                    </div>
                    <div class="main-search-wrapper mt-20" style="background: rgba(0, 0, 0, 0.6);">
                        <?php @include_once 'page-parts/index-search-box.php'; ?>
                    </div>
                </div>
            </div>
            <!-- end hero-header -->

            <div class="clear"></div>
            <?php
            if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
                ?>
                <div class="row mt-20 hidden-sm hidden-md hidden-lg">
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                            <a href="register" class="btn btn-block btn-primary btn-md btn-icon">Register
                                <span
                                        class="icon"><i
                                            class="fa fa-edit"></i></span></a>
                        </div>
                        <div class="col-xs-6">
                            <a href="login" class="btn btn-block btn-danger btn-md btn-icon">Login<span
                                        class="icon"><i
                                            class="fa fa-sign-in"></i></span></a>
                        </div>
                    </div>

                </div>
                <?php
            }
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                ?>
                <div class="bg-white hidden-sm hidden-xs">

                    <?php
                    if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Bride') {
                        $genderToSearch = "and gender='Groom' ";
                    } else if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Groom') {
                        $genderToSearch = "and gender='Bride' ";
                    } else {
                        $genderToSearch = "";
                    }
                    $SQLSTATEMENT_resnt = $DatabaseCo->dbLink->query("select DISTINCT matri_id, photo1,ocp_name,birthdate,gender from register_view where status!='Inactive' and fstatus='Featured' and photo1!='' {$genderToSearch} and photo1_approve='APPROVED' ORDER BY index_id DESC limit 0,20");
                    if (mysqli_num_rows($SQLSTATEMENT_resnt) > 0) { ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                                <div class="section-title" style="margin-bottom: 20px;">
                                </div>
                            </div>
                        </div>
                        <?php if ($genderToSearch == "") { ?>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div class="btn-filter-wrap">
                                        <button class="btn-filter" data-filter=".grid-groom">Buddhist Groom</button>
                                        <button id="activeBrideFilter" class="btn-filter" data-filter=".grid-bride">
                                            Buddhist
                                            Bride
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="top-hotel-grid-wrapper">
                            <div class="GridLex-gap-20-wrapper">
                                <div class="GridLex-grid-noGutter-equalHeight GridLex-grid-center owl-carousel"
                                     id="featured_profiles">
                                    <?php while ($Row = mysqli_fetch_object($SQLSTATEMENT_resnt)) {
                                        if (!empty($Row->photo1) && file_exists('photos/' . trim($Row->photo1))) {
                                            $isPhotoAvailable = "photos/" . trim($Row->photo1);
                                        } else {
                                            if ($Row->gender == 'Bride') {
                                                $isPhotoAvailable = "img/default-photo/female-200.png";
                                            } else {
                                                $isPhotoAvailable = "img/default-photo/male-200.png";
                                            }
                                        }
                                        ?>
                                        <div class="hotel-item-grid <?= $Row->gender == 'Bride' ? "grid-bride" : "grid-groom" ?>"
                                             style="width: 100%; min-height: 0px;">
                                            <?php
                                            if (!empty($_SESSION['user_id'])) {
                                                $onClick = "openProfileInModal('" . $Row->matri_id . "')";
                                            } else {
                                                $onClick = "open_login();";
                                            }
                                            ?>
                                            <a href="javascript:void(0);" onclick="<?= $onClick ?>">
                                                <img src="<?= $isPhotoAvailable ?>"
                                                     title="<?php echo $Row->matri_id; ?>"
                                                     alt="<?php echo $Row->matri_id; ?>" width="100">
                                                <div class="feature-data">
                                                    <b><?= $Row->matri_id ?></b>
                                                    , <?= floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Years'; ?>
                                                    <br/>
                                                    <div class="texting text-center">
                                                        <?= $Row->ocp_name ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php }
                        ?>
                    </div>

                </div>
                <?php
            }
            ?>
            <div class="clear"></div>

            <div class="mb-20"></div>
            <?php include 'advertise/ad_level_2.php'; ?>
            <div class="mb-20"></div>

            <div class="bg-primary newsletter-wrapper hidden-sm hidden-xs"
                 style="padding-top: 15px;padding-bottom: 0px;">

                <div class="container">

                    <div class="GridLex-grid-middle">

                        <div class="GridLex-col-10_sm-12_xs-12 pt-0 pb-0">
                            <div class="text-holder">
                                <p style="font-family:inherit;font-style: normal;text-align: justify;">More than
                                    thousand Buddhist profiles are registered at Samyakonline.Com. Majority of these
                                    profiles belong to Mumbai, Nagpur, Pune,satara,chandrapur,nashik etc. You can also
                                    browse through Buddhist profiles with professions like Business / Consultant,
                                    Engineer, Non-Working etc. for your exclusive online Buddhist matrimony website in
                                    india. We are Excellence Marriage Bureau is a Mumbai-Pune based matrimonial service
                                    provider. </p>
                            </div>
                        </div>


                    </div>

                </div>

            </div>

            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="section-title mb20 text-center">
                            <p>Find inspiration for your Special Day. Yours could be the next Success Story.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="success-story-block" class="owl-carousel">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/10.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/9.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/11.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/12.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/5.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/6.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/7.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="success-story-block mb30">
                                <div class="real-wedding-img"><a href="success_story">
                                        <img alt="" class="img-responsive"
                                             src="https://www.samyakmatrimony.com/SuccessStory/8.jpg"></a>
                                </div>
                                <div class="well-box text-center no-padding">
                                    <p class="font-16 font-weight-bold padding-5"><a
                                                href="success_story"
                                                class=""></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Success Stories center -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center mt-15"><a
                                href="success_story"
                                class="btn btn-blue bor-r50 btn-big ripplelink">View More Success
                            Stories</a></div>
                </div>

                <div class="section-space40 bg-light mt-50">
                    <div class="container">
                        <div class="col-md-10 col-md-offset-1 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="section-title mb-0 text-center">
                                        <p class="mt-15">Search Buddhist Bride & Groom authentic profiles.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 mt-20">
                                    <div class="well-box feature-block text-center">
                                        <div class="membership-icon micon-contact"></div>
                                        <div class="feature-info">
                                            <h3>View Contacts</h3>
                                            <p>View contact number to connect or WhatsApp.
                                                Visit office to view Profile</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 mt-20">
                                    <div class="well-box feature-block text-center">
                                        <div class="membership-icon micon-email"></div>
                                        <div class="feature-info">
                                            <h3>Send Personal Message</h3>
                                            <p>Send message/sms to interested profile.Connnect via WhatsApp</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 mt-20">
                                    <div class="well-box feature-block text-center">
                                        <div class="membership-icon micon-chat"></div>
                                        <div class="feature-info">
                                            <h3>Chat</h3>
                                            <p>Chat instantly with online Members <br/> Send message to discuss more</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-15 text-center">
                                    <p class="member-know"> To know more, call us @ <a href="tel:+91-79779-93616">+91-79779-93616</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clear"></div>

            <!-- jQuery Cores -->
            <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
            <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
            <?php @include_once 'layouts/footer.php' ?>

        </div>
        <!-- end Main Wrapper -->
        <!-- jQuery Cores -->
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
        <?php @include_once 'layouts/footer.php' ?>

    </div>
    <!-- end Main Wrapper -->

</div> <!-- / .wrapper -->
<!-- end Container Wrapper -->

<!-- start Back To Top -->
<div id="back-to-top">
    <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->
<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>


<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script type="text/javascript" src="js/customs-validate.js?v=1.0"></script>

<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery.owl-filter.js?v=1.0"></script>
<script>
    $(function () {
        $.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");


        var owl = $('#featured_profiles').owlCarousel({
            loop: true,
            /*nav: true,*/
            margin: 5,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 6
                },
                1000: {
                    items: 8
                }
            },
            /*navText: ['<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'],*/
        });

        /* animate filter */
        var owlAnimateFilter = function (even) {
            $(this)
                .addClass('__loading')
                .delay(70 * $(this).parent().index())
                .queue(function () {
                    $(this).dequeue().removeClass('__loading')
                })
        }

        var owl = $('#success-story-block').owlCarousel({
            loop: true,
            nav: true,
            margin: 5,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 4
                }
            },
            autoplay: true,
            navText: ['<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'],
        });

        $('.btn-filter-wrap').on('click', '.btn-filter', function (e) {
            var filter_data = $(this).data('filter');

            /* return if current */
            if ($(this).hasClass('btn-active')) return;

            /* active current */
            $(this).addClass('btn-active').siblings().removeClass('btn-active');

            //owl.owlFilter(filter_data);
            /* Filter */
            owl.owlFilter(filter_data, function (_owl) {
                $(_owl).find('.hotel-item-grid').each(owlAnimateFilter);
            });
        });

        $("#activeBrideFilter").trigger('click');
    });
</script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script>
    $(function () {
        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();

        /*$.ajax({
            type: "POST", // HTTP method POST or GET
            url: "page-parts/index-search-box", //Where to make Ajax calls
            dataType: 'html',
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend: function () {
                $("#loader-animation-area").show();
            },
            success: function (response) {
                $(".main-search-wrapper").html(response);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });*/


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

        /*Jquery Partener Caste End */
    });
</script>
<!-- Custom js codes for plugins -->
<script type="text/javascript" src="<?= auto_version('js/customs.js') ?>"></script>
</body>
</html>