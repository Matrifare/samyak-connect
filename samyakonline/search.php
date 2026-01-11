<?php

/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/11/2018
 * Time: 6:58 PM
 */
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/RequestHandler.php';
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
    <title>Find Your Perfect Match: Trusted Buddhist Matrimonial Services</title>
    <meta name="keyword" content="Buddhist Matrimonial, Buddhist Marriage, Buddhist Matchmaking, Buddhist Bride, Buddhist Groom, Buddhist Matrimony Site, Buddhist Wedding, Find Buddhist Partner, Buddhist Marriage Bureau, Online Buddhist Matrimony" />
    <meta name="description" content="Looking for a compatible Buddhist life partner? Join our trusted Buddhist matrimonial platform to connect with genuine brides and grooms. Safe, secure, and reliable matchmaking. Register today!" />
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon" />
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
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="css/select2.min.css" />

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
            width: 100% overflow: hidden !important;
            height: auto !important;
        }

        input.select2-search__field {
            width: 100% !important;
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
            <?php if (isset($_SESSION['user_name']) || (trim($_SESSION['user_id']) != '')) { ?>
                <div class="sub-menu-content">
                    <div class="new-sub-menu">
                        <div class="sub-menu-list">
                            <a href="homepage"> Dashboard</a> |
                            <a href="my-matches"> My Matches</a>
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
                                    <li><a href="search">Search</a></li>
                                </ol>
                            </div>

                            <div class="col-xs-12 col-sm-4 hidden-xs">
                                <p class="hot-line"><i class="fa fa-phone"></i> <a href="tel:+91-79779-93616"> Help Line:
                                        +91-79779-93616</a></p>
                            </div>

                        </div>

                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
            <div class="container">

                <div class="content-wrapper">
                    <div class="section-title-3">
                        <h3 style="font-size: 15px; text-transform: capitalize;">Search Profile</h3>
                    </div>
                    <div id="search_page_content">
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="clear"></div>
            <?php @include_once 'layouts/footer.php' ?>
        </div>

    </div>

    <!-- jQuery Cores -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>


    <?php
    if (isset($_SESSION['last_login'])) {
        @include_once 'page-parts/mobile_verification.php';
    }
    if (!isset($_SESSION['last_login']) && isset($_SESSION['partner_profile'])) { ?>
        <script>
            alert(" complete partner preference");
            window.location.href = 'edit-profile';
        </script>
    <?php } ?>


    <!-- Bootstrap Js -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugins - serveral jquery plugins that use in this template -->
    <script type="text/javascript" src="js/plugins.js"></script>

    <!-- Custom js codes for plugins -->
    <script type="text/javascript" src="<?= auto_version("js/customs.js") ?>"></script>
    <script type="text/javascript" src="js/select2.min.js"></script>
    <script>
        $(function() {
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "search_page_content", //Where to make Ajax calls
                dataType: 'html',
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                beforeSend: function() {
                    $("#loader-animation-area").show();
                },
                success: function(response) {
                    $("#search_page_content").html(response);
                    $(".chosen-select").css('width', '100%');
                    $("ul > li > input").css('width', '100%');
                    $('.chosen-select').select2();

                    var url = document.location.toString();
                    if (url.match('#')) {
                        $('.tab-nav a[href="#' + url.split('#')[1] + '"]').tab('show');
                    }

                    // Change hash for page-reload
                    $('.tab-nav a').on('shown.bs.tab', function(e) {
                        window.location.hash = e.target.hash;
                    })
                },
                complete: function() {
                    $("#loader-animation-area").hide();
                }
            });
        });
    </script>
</body>

</html>