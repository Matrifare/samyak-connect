<?php

/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/13/2018
 * Time: 8:48 PM
 */
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();

if (!isset($_POST['gender']) && isset($_SESSION['gender123'])) {
    if ($_SESSION['gender123'] == 'Groom') {
        $gender = 'Bride';
    } else {
        $gender = 'Groom';
    }
} elseif (isset($_POST['gender'])) {
    $gender = $_POST['gender'];
    $_SESSION['gender'] = $gender;
} else {
    $gender = '';
}
if (isset($_GET['ss_id'])) {
    $ssid = mysqli_fetch_object($DatabaseCo->dbLink->query("select * from save_search where ss_id='" . $_GET['ss_id'] . "' and matri_id='" . $_SESSION['user_id'] . "'"));
    if ($ssid->fromage != '') {
        $_SESSION['fromage'] = $ssid->fromage;
    } else {
        unset($_SESSION['fromage']);
    }
    if ($ssid->toage != '') {
        $_SESSION['toage'] = $ssid->toage;
    } else {
        unset($_SESSION['toage']);
    }
    if ($ssid->from_height != '') {
        $_SESSION['fromheight'] = $ssid->from_height;
    } else {
        unset($_SESSION['fromheight']);
    }
    if ($ssid->to_height != '') {
        $_SESSION['toheight'] = $ssid->to_height;
    } else {
        unset($_SESSION['toheight']);
    }
    if ($ssid->marital_status != '') {
        $_SESSION['m_status'] = $ssid->marital_status;
    } else {
        unset($_SESSION['m_status']);
    }
    if ($ssid->religion != '') {
        $_SESSION['religion'] = $ssid->religion;
    } else {
        unset($_SESSION['religion']);
    }
    if ($ssid->caste != '') {
        $_SESSION['caste'] = $ssid->caste;
    } else {
        unset($_SESSION['caste']);
    }
    if ($ssid->mother_tongue) {
        $_SESSION['m_tongue'] = $ssid->mother_tongue;
    } else {
        unset($_SESSION['m_tongue']);
    }
    if ($ssid->education != '') {
        $_SESSION['education'] = $ssid->education;
    } else {
        unset($_SESSION['education']);
    }
    if ($ssid->occupation != '') {
        $_SESSION['occupation'] = $ssid->occupation;
    } else {
        unset($_SESSION['occupation']);
    }
    if ($ssid->country != '') {
        $_SESSION['country'] = $ssid->country;
    } else {
        unset($_SESSION['country']);
    }
    if ($ssid->state != '') {
        $_SESSION['state'] = $ssid->state;
    } else {
        unset($_SESSION['state']);
    }
    if ($ssid->city != '') {
        $_SESSION['city'] = $ssid->city;
    } else {
        unset($_SESSION['city']);
    }
    if ($ssid->manglik != '') {
        $_SESSION['manglik'] = $ssid->manglik;
    } else {
        unset($_SESSION['manglik']);
    }
    if ($ssid->keyword != '') {
        $_SESSION['keyword'] = $ssid->keyword;
    } else {
        unset($_SESSION['keyword']);
    }
    if ($ssid->id_search != '') {
        $_SESSION['id_search'] = $ssid->id_search;
    } else {
        unset($_SESSION['id_search']);
    }
    if ($ssid->with_photo != '') {
        $_SESSION['photo_search'] = $ssid->with_photo;
    } else {
        unset($_SESSION['photo_search']);
    }
    if ($ssid->tot_children != '') {
        $_SESSION['tot_children'] = $ssid->tot_children;
    } else {
        unset($_SESSION['tot_children']);
    }
    if ($ssid->annual_income != '') {
        $_SESSION['annual_income'] = $ssid->annual_income;
    } else {
        unset($_SESSION['annual_income']);
    }
    if ($ssid->diet != '') {
        $_SESSION['diet'] = $ssid->diet;
    } else {
        unset($_SESSION['diet']);
    }
    if ($ssid->drink != '') {
        $_SESSION['drink'] = $ssid->drink;
    } else {
        unset($_SESSION['drink']);
    }
    if ($ssid->smoking != '') {
        $_SESSION['smoking'] = $ssid->smoking;
    } else {
        unset($_SESSION['smoking']);
    }
    if ($ssid->complexion != '') {
        $_SESSION['complexion'] = $ssid->complexion;
    } else {
        unset($_SESSION['complexion']);
    }
    if ($ssid->bodytype != '') {
        $_SESSION['bodytype'] = $ssid->bodytype;
    } else {
        unset($_SESSION['bodytype']);
    }
    if ($ssid->star != '') {
        $_SESSION['star'] = $ssid->star;
    } else {
        unset($_SESSION['star']);
    }
}

if (!(isset($_POST['frm_age'])) && isset($_SESSION['fromage'])) {
    $t3 = $_SESSION['fromage'];
} elseif (isset($_POST['frm_age'])) {
    $t3 = $_POST['frm_age'];
    $_SESSION['fromage'] = $t3;
} else {
    $t3 = '';
}
if (!(isset($_POST['to_age'])) && isset($_SESSION['toage'])) {
    $t4 = $_SESSION['toage'];
} elseif (isset($_POST['to_age'])) {
    $t4 = $_POST['to_age'];
    $_SESSION['toage'] = $t4;
} else {
    $t4 = '';
}

if (!(isset($_POST['other_caste'])) && isset($_SESSION['other_caste'])) {
    $otherCaste = $_SESSION['other_caste'];
} elseif (isset($_POST['other_caste'])) {
    $otherCaste = $_POST['other_caste'];
    $_SESSION['other_caste'] = $otherCaste;
} else {
    $otherCaste = '';
}

if (!(isset($_POST['orderby'])) && isset($_SESSION['orderby'])) {
    $orderBy = $_SESSION['orderby'];
} elseif (isset($_POST['orderby'])) {
    $orderBy = $_POST['orderby'];
    $_SESSION['orderby'] = $orderBy;
} else {
    $orderBy = '';
}

if (!isset($_POST['religion']) && isset($_SESSION['religion'])) {
    $religion123 = $_SESSION['religion'];
} elseif (isset($_POST['religion'])) {
    $religion123 = implode(",", $_POST['religion']);
    $_SESSION['religion'] = $religion123;
} else {
    $religion123 = '';
}


if (!isset($_POST['special_case']) && isset($_SESSION['special_case'])) {
    $specialCase = $_SESSION['special_case'];
} elseif (isset($_POST['special_case'])) {
    $specialCase = implode(",", $_POST['special_case']);
    $_SESSION['special_case'] = $specialCase;
} else {
    $specialCase = '';
}

if (!isset($_POST['caste_id']) && isset($_SESSION['caste'])) {
    $caste123 = $_SESSION['caste'];
} elseif (isset($_POST['caste_id'])) {
    $caste123 = implode(",", $_POST['caste_id']);
    $_SESSION['caste'] = $caste123;
} elseif (isset($_POST['part_caste_id'])) {
    $caste123 = implode(",", $_POST['part_caste_id']);
    $_SESSION['caste'] = $caste123;
} else {
    $caste123 = '';
}
if (!isset($_POST['mtongue_id']) && isset($_SESSION['m_tongue'])) {
    $m_tongue123 = $_SESSION['m_tongue'];
} elseif (isset($_POST['mtongue_id'])) {
    $m_tongue123 = implode(",", $_POST['mtongue_id']);
    $_SESSION['m_tongue'] = $m_tongue123;
} else {
    $m_tongue123 = '';
}
if (!isset($_REQUEST['from_height']) && isset($_SESSION['fromheight'])) {
    $fromheight = $_SESSION['fromheight'];
} else if (isset($_REQUEST['from_height'])) {
    $fromheight = $_REQUEST['from_height'];
    $_SESSION['fromheight'] = $fromheight;
} else {
    $fromheight = '';
}
if (!isset($_REQUEST['height_to']) && isset($_SESSION['toheight'])) {
    $toheight = $_SESSION['toheight'];
} else if (isset($_REQUEST['height_to'])) {
    $toheight = $_REQUEST['height_to'];
    $_SESSION['toheight'] = $toheight;
} else {
    $toheight = '';
}

if (!isset($_POST['m_status']) && isset($_SESSION['m_status'])) {
    $mstatus123 = $_SESSION['m_status'];
} else if (isset($_POST['m_status']) && is_array($_POST['m_status'])) {
    $mstatus123 = implode(",", $_POST['m_status']);
    $_SESSION['m_status'] = $mstatus123;
} else if (isset($_POST['m_status'])) {
    $mstatus123 = $_POST['m_status'];
    $_SESSION['m_status'] = $mstatus123;
} else {
    $mstatus123 = '';
}
if (!isset($_POST['education_level']) && isset($_SESSION['education_level'])) {
    $education_level = $_SESSION['education_level'];
} elseif (isset($_POST['education_level'])) {
    $education_level = implode(",", $_POST['education_level']);
    $_SESSION['education_level'] = $education_level;
} else {
    $education_level = '';
}
if (!isset($_POST['education_field']) && isset($_SESSION['education_field'])) {
    $education_field = $_SESSION['education_field'];
} elseif (isset($_POST['education_field'])) {
    $education_field = implode(",", $_POST['education_field']);
    $_SESSION['education_field'] = $education_field;
} else {
    $education_field = '';
}
if (!isset($_POST['occupation']) && isset($_SESSION['occupation'])) {
    $occupation = $_SESSION['occupation'];
} elseif (isset($_POST['occupation'])) {
    $occupation = implode(",", $_POST['occupation']);
    $_SESSION['occupation'] = $occupation;
} else {
    $occupation = '';
}
if (!isset($_POST['country_id']) && isset($_SESSION['country'])) {
    $country123 = $_SESSION['country'];
} elseif (isset($_POST['country_id'])) {
    $country123 = implode(",", $_POST['country_id']);
    $_SESSION['country'] = $country123;
} else {
    $country123 = '';
}
if (!isset($_POST['state']) && isset($_SESSION['state'])) {
    $state123 = $_SESSION['state'];
} else if (isset($_POST['state'])) {
    $state123 = implode(",", $_POST['state']);
    $_SESSION['state'] = $state123;
} else {
    $state123 = '';
}
if (!isset($_POST['city']) && isset($_SESSION['city'])) {
    $city123 = $_SESSION['city'];
} elseif (isset($_POST['city'])) {
    $city123 = is_array($_POST['city']) ? implode(",", $_POST['city']) : $_POST['city'];
    $_SESSION['city'] = $city123;
} else {
    $city123 = '';
}
if (!isset($_POST['family_origin']) && isset($_SESSION['family_origin'])) {
    $familyOrigin = $_SESSION['family_origin'];
} elseif (isset($_POST['family_origin'])) {
    $_POST['family_origin'] = $_POST['family_origin'] ?? "";
    $familyOrigin = !empty($_POST['family_origin']) ? implode(",", $_POST['family_origin']) : "";
    $_SESSION['family_origin'] = $familyOrigin;
} else {
    $familyOrigin = '';
}
if (isset($_SESSION['manglik'])) {
    $manglik = $_SESSION['manglik'];
} else {
    $manglik = '';
}
if (isset($_SESSION['keyword'])) {
    $keyword = $_SESSION['keyword'];
} else if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
} else {
    $keyword = '';
}
if (isset($_SESSION['user_id'])) {
    $mid = $_SESSION['user_id'];
} else {
    $mid = '';
}
if (isset($_SESSION['photo_search'])) {
    $photo_search = $_SESSION['photo_search'];
} elseif (isset($_POST['photo_search'])) {
    $photo_search = $_POST['photo_search'];
    $_SESSION['photo_search'] = $photo_search;
} else {
    $photo_search = '';
}
if (isset($_SESSION['samyak_id_search'])) {
    $samyak_id_search = $_SESSION['samyak_id_search'];
} elseif (isset($_POST['samyak_id'])) {
    $samyak_id_search = $_POST['samyak_id'];
    $_SESSION['samyak_id_search'] = $samyak_id_search;
} else {
    $samyak_id_search = '';
}
if (isset($_SESSION['samyak_search'])) {
    $samyak_search = $_SESSION['samyak_search'];
} elseif (isset($_POST['samyak_search'])) {
    $samyak_search = $_POST['samyak_search'];
    $_SESSION['samyak_search'] = $samyak_search;
} else {
    $samyak_search = '';
}


if (isset($_SESSION['search_by_profile_id'])) {
    $search_by_profile_id = $_SESSION['search_by_profile_id'];
} elseif (isset($_POST['search_by_profile_id'])) {
    $search_by_profile_id = $_POST['search_by_profile_id'];
    $_SESSION['search_by_profile_id'] = $search_by_profile_id;
} else {
    $search_by_profile_id = '';
}

if (isset($_SESSION['tot_children'])) {
    $tot_children = $_SESSION['tot_children'];
} else {
    $tot_children = '';
}
if (isset($_SESSION['annual_income'])) {
    $annual_income = $_SESSION['annual_income'];
} else {
    $annual_income = '';
}
if (isset($_SESSION['diet'])) {
    $diet = $_SESSION['diet'];
} else {
    $diet = '';
}
if (isset($_SESSION['drink'])) {
    $drink = $_SESSION['drink'];
} else {
    $drink = '';
}
if (isset($_SESSION['smoking'])) {
    $smoking = $_SESSION['smoking'];
} else {
    $smoking = '';
}
if (!isset($_POST['complexion']) && isset($_SESSION['complexion'])) {
    $complexion = $_SESSION['complexion'];
} else if (isset($_POST['complexion'])) {
    $complexion = !empty($_POST['complexion']) ? implode(",", $_POST['complexion']) : "";
    $_SESSION['complexion'] = $complexion;
} else {
    $complexion = '';
}
if (isset($_SESSION['bodytype'])) {
    $bodytype = $_SESSION['bodytype'];
} else {
    $bodytype = '';
}
if (isset($_SESSION['star'])) {
    $star = $_SESSION['star'];
} else {
    $star = '';
}
if (isset($_POST['txt_id_search'])) {
    $txt_id_search = sanitize($_POST['txt_id_search']);
    $_SESSION['id_search'] = $txt_id_search;
} else {
    $txt_id_search = '';
}
if (isset($_SESSION['id_search'])) {
    $txt_id_search = $_SESSION['id_search'];
} else {
    $txt_id_search = '';
}
if (isset($_SESSION['samyak_id_search'])) {
    $samyak_id_search = $_SESSION['samyak_id_search'];
} else {
    $samyak_id_search = '';
}
if (isset($_SESSION['search_by_profile_id'])) {
    $search_by_profile_id = $_SESSION['search_by_profile_id'];
} else {
    $search_by_profile_id = '';
}

if (isset($_POST['samyak_id_search'])) {
    if (isset($_POST['samyak_id'])) {
        $samyak_id = sanitize($_POST['samyak_id']);
    } else {
        $samyak_id = "";
    }
    $_SESSION['samyak_id_search'] = $samyak_id;
    echo "<script>window.location='search_result.php';</script>";
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
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>" />
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>" />
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon" />

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <!-- CSS Plugins -->
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

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
        type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
        rel='stylesheet' type='text/css'>

    <!-- CSS Custom -->
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= auto_version("css/select2.min.css") ?>" />

    <!-- Add your style -->
    <link href="<?= auto_version("css/your-style.css") ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="not-home">
    <div style="overflow-x: hidden !important;">
        <?php @include_once 'page-parts/modal.php' ?>

        <!-- start Container Wrapper -->
        <div class="container-wrapper colored-navbar-brand">

            <?php @include_once 'layouts/menu.php' ?>

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
                                    <li><a href="#" style="cursor: none;">Search Results</a></li>
                                </ol>
                            </div>
                            <div class="col-xs-12 col-sm-4 hidden-xs">
                                <p class="hot-line"><i class="fa fa-phone"></i> <a href="tel:+91-79779-93616"> Help Line:
                                        +91-79779-93616</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="two-tone-layout">

                    <div class="equal-content-sidebar">

                        <div class="container">


                            <div class="content-wrapper">
                                <div class="mb-10"></div>
                                <div class="sort-wrapper">
                                    <ul class="clearfix">
                                        <li class="text">Sort:</li>
                                        <li id="sortBylogin"
                                            class="<?= (!empty($_SESSION['orderby']) && $_SESSION['orderby'] == 'login') ? "active" : "" ?>">
                                            <a href="javascript:void(0);" onclick="callFilter('login')">Last
                                                Login</a>
                                        </li>
                                        <li id="sortByregister"
                                            class="<?= (!empty($_SESSION['orderby']) && $_SESSION['orderby'] == 'register') ? "active" : "" ?>">
                                            <a href="javascript:void(0);"
                                                onclick="callFilter('register')">New
                                                Profile</a>
                                        </li>
                                        <li id="sortBypremium"
                                            class="<?= (!empty($_SESSION['orderby']) && $_SESSION['orderby'] == 'premium') ? "active" : "" ?>">
                                            <a href="javascript:void(0);"
                                                onclick="callFilter('premium')">Premium
                                                Members</a>
                                        </li>
                                        <!--<li onclick="changeView('list_view')" class="list-grid"><a href="#"><i class="fa fa-align-justify"></i></a></li>
                                    <li onclick="changeView('icon_view')" class="list-grid"><a href="#"><i class="fa fa-th-large"></i></a></li>-->
                                    </ul>
                                </div>
                                <div id="samyak-results"></div>
                                <div class="mb-20"></div>
                            </div>

                            <?php @include_once 'page-parts/search_filter.php' ?>
                        </div>

                    </div>

                </div>

                <div class="clear"></div>
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                </div>

                <!-- jQuery Cores -->
                <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
                <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
                <?php @include_once 'page-parts/view_profile.php' ?>
                <?php @include_once 'layouts/footer.php' ?>

            </div>

        </div>

        <!-- start Back To Top -->
        <div id="back-to-top">
            <a href="#"><i class="ion-ios-arrow-up"></i></a>
        </div>
        <!-- end Back To Top -->
    </div>
    <!-- Bootstrap Js -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugins - serveral jquery plugins that use in this template -->
    <script type="text/javascript" src="js/plugins.js"></script>


    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/additional-methods.min.js"></script>
    <script type="text/javascript" src="js/customs-validate.js"></script>


    <!-- Date Piacker -->
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/customs-datepicker.js"></script>

    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    <!--Custom JS Start-->

    <script type="text/javascript">
        //Clear the storage first time
        const pageAccessedByReload = (
            (window.performance.navigation && window.performance.navigation.type === 1) ||
            window.performance
            .getEntriesByType('navigation')
            .map((nav) => nav.type)
            .includes('reload')
        );

        if (document.referrer !== document.documentURI && !pageAccessedByReload) {
            sessionStorage.clear();
        }
        let loading = false;
        $(document).ready(function() {
            if (!sessionStorage.isCalled) {
                sessionStorage.clear();
            }
            $("#loader-animation-area").show();
            var dataString = 'photo_search=' + '<?php echo sanitize($photo_search); ?>' + '&manglik=' + '<?php echo sanitize($manglik); ?>' +
                '&tot_children=' + '<?php echo sanitize($tot_children); ?>' + '&annual_income=' + '<?php echo sanitize($annual_income); ?>' +
                '&id_search=' + '<?php echo $txt_id_search; ?>' + '&diet=' + '<?php echo sanitize($diet); ?>' + '&drink=' +
                '<?php echo sanitize($drink); ?>' + '&smoking=' + '<?php echo sanitize($smoking); ?>' + '&complexion=' +
                '<?php echo sanitize($complexion); ?>' + '&bodytype=' + '<?php echo sanitize($bodytype); ?>' + '&star=' +
                '<?php echo sanitize($star); ?>' + '&religion=' + '<?php echo sanitize($religion123); ?>' + '&caste=' +
                '<?php echo sanitize($caste123); ?>' + '&t3=' + '<?php echo sanitize($t3); ?>' + '&t4=' + '<?php echo sanitize($t4); ?>' +
                '&fromheight=' + '<?php echo sanitize($fromheight); ?>' + '&toheight=' + '<?php echo sanitize($toheight); ?>' +
                '&state=' + '<?php echo sanitize($state123); ?>' + '&city=' + '<?php echo sanitize($city123); ?>' +
                '&family_origin=' + '<?php echo sanitize($familyOrigin); ?>' + '&keyword=' +
                '<?php echo $keyword; ?>' + '&occupation=' + '<?php echo sanitize($occupation); ?>' + '&country=' +
                '<?php echo sanitize($country123); ?>' + '&special_case=' + '<?= sanitize($specialCase) ?>' +
                '&other_caste=' + '<?= sanitize($otherCaste) ?>' + '&gender=' + '<?php echo sanitize($gender); ?>' + '&m_status=' +
                '<?php echo sanitize($mstatus123); ?>' + '&m_tongue=' + '<?php echo sanitize($m_tongue123); ?>' +
                '&education_field=' + '<?php echo sanitize($education_field); ?>' + '&education_level=' +
                '<?php echo sanitize($education_level); ?>' + '&samyak_id_search=' + '<?php echo sanitize($samyak_id_search); ?>' +
                '&samyak_search=' + '<?php echo sanitize($samyak_search); ?>' + '&search_by_profile_id=' + '<?php echo sanitize($search_by_profile_id); ?>' +
                '&orderby=' + '<?= sanitize($orderBy) ?>' + '&actionfunction=showData' +
                '&page=' + (sessionStorage.setPage || 1);
            $.ajax({
                url: "dbmanupulate2",
                type: "POST",
                data: dataString,
                cache: false,
                success: function(response) {
                    $('#samyak-results').html(response);
                },
                complete: function() {
                    $("#loader-animation-area").hide();
                    sessionStorage.isCalled = true;
                }
            });

            /*$(window).scroll(function() {
                if ($(window).scrollTop() >= $(document).height() - $(window).height() - 450) {
                    if(!loading) {
                        $.ajax({
                            url: "dbmanupulate2",
                            type: "POST",
                            data: dataString,
                            cache: false,
                            beforeSend: function() {
                                loading = true;
                            },
                            success: function (response) {
                                // sessionStorage.setPage = $page;
                                $('#samyak-results').append(response);
                            },
                            complete: function () {
                                $("#loader-animation-area").hide();
                                loading = false;
                            }
                        });
                    }
                }
            });*/

            $('#samyak-results').on('click', '.page-numbers', function() {
                $("#loader-animation-area").show();
                $page = $(this).attr('href');
                $pageind = $page.indexOf('page=');
                $page = $page.substring(($pageind + 5));
                var dataString = '&actionfunction=showData' + '&page=' + $page;
                $.ajax({
                    url: "dbmanupulate2",
                    type: "POST",
                    data: dataString,
                    cache: false,
                    success: function(response) {
                        sessionStorage.setPage = $page;
                        $('#samyak-results').html(response);
                    },
                    complete: function() {
                        $("#loader-animation-area").hide();
                    }
                });
                return false;
            });
        });

        /**
         * ion Range Slider for price and star rating range slider
         */
        var saveResultAge = function(data) {
            $("#from_age").val(data.from);
            $("#to_age").val(data.to);
        };

        var saveResultHeight = function(data) {
            $("#from_height").val(data.from);
            $("#to_height").val(data.to);
        };

        $("#age_range").ionRangeSlider({
            grid: true,
            type: "double",
            min: 18,
            max: 60,
            from: <?= !empty(trim($t3)) ? $t3 : 18 ?>,
            to: <?= !empty(trim($t4)) ? $t4 : 60 ?>,
            onStart: function(data) {
                //            saveResultAge(data);
            },
            onChange: function(data) {
                //            saveResultAge(data);
            },
            onFinish: function(data) {
                saveResultAge(data);
                callFilter();
            }
        });

        function round(value, precision) {
            var multiplier = Math.pow(10, precision || 0);
            return Math.round(value * multiplier) / multiplier;
        }

        function getHeight(num) {
            var ft = round(num / 12, 0);
            var inch = round(num % 12, 1);
            return ft + "ft" + " " + inch + "in";
        }

        $("#height_range").ionRangeSlider({
            type: "double",
            from: <?= !empty(trim($fromheight)) ? $fromheight : 60 ?>,
            to: <?= !empty(trim($toheight)) ? $toheight : 85 ?>,
            values: [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85],
            step: 1,
            grid: true,
            prettify: function(num) {
                return getHeight(num);
            },
            onStart: function(data) {
                //            saveResultHeight(data);
            },
            onChange: function(data) {
                //            saveResultHeight(data);
            },
            onFinish: function(data) {
                saveResultHeight(data);
                callFilter();
            }
        });


        function callFilter(orderby = "") {
            var selectedOrderBy = new Array();
            $('input[name="orderby"]:checked').each(function() {
                selectedOrderBy.push(this.value);
            });
            if (selectedOrderBy == "" && orderby != "") {
                $("#sortBy" + orderby).addClass('active');
                if (orderby == 'login') {
                    $("#sortByregister").removeClass('active');
                    $("#sortBypremium").removeClass('active');
                } else if (orderby == 'register') {
                    $("#sortBylogin").removeClass('active');
                    $("#sortBypremium").removeClass('active');
                } else if (orderby == 'premium') {
                    $("#sortBylogin").removeClass('active');
                    $("#sortByregister").removeClass('active');
                } else {
                    $("#sortByregister").removeClass('active');
                    $("#sortBypremium").removeClass('active');
                }
                selectedOrderBy.push(orderby);
            }
            if (selectedOrderBy == '') {
                var selectedOrderBy = 'null';
            }
            var selectedGender = new Array();
            $('input[name="gender"]:checked').each(function() {
                selectedGender.push(this.value);
            });
            if (selectedGender == '') {
                var selectedGender = 'null';
            }
            var selectedPhoto = new Array();
            $('input[name="photo_search"]:checked').each(function() {
                selectedPhoto.push(this.value);
            });
            if (selectedPhoto == '') {
                var selectedPhoto = 'null';
            }
            var selectedMstatus = new Array();
            $('input[name="m_status"]:checked').each(function() {
                selectedMstatus.push(this.value);
            });
            if (selectedMstatus == '') {
                var selectedMstatus = 'null';
            }
            var selectedCaste = new Array();
            $('input[name="caste_id"]:checked').each(function() {
                selectedCaste.push(this.value);
            });
            if (selectedCaste == '') {
                var selectedCaste = 'null';
            }
            if ($('#annual_income').val() != '') {
                var annual_income = $("#annual_income").val();
            } else {
                var annual_income = '';
            }
            var selectedReligion = new Array();
            $('input[name="religion"]:checked').each(function() {
                selectedReligion.push(this.value);
            });
            if (selectedReligion == '') {
                var selectedReligion = 'null';
            }
            var selectedOccupation = new Array();
            $('input[name="occupation"]:checked').each(function() {
                selectedOccupation.push(this.value);
            });
            if (selectedOccupation == '') {
                var selectedOccupation = 'null';
            }
            var selectedEducation = new Array();
            $('input[name="education_level"]:checked').each(function() {
                selectedEducation.push(this.value);
            });
            if (selectedEducation == '') {
                var selectedEducation = 'null';
            }

            var selectedEducationField = new Array();
            $('input[name="education_field"]:checked').each(function() {
                selectedEducationField.push(this.value);
            });
            if (selectedEducationField == '') {
                var selectedEducationField = 'null';
            }
            var selectedCountry = new Array();
            $('input[name="country"]:checked').each(function() {
                selectedCountry.push(this.value);
            });
            if (selectedCountry == '') {
                var selectedCountry = 'null';
            }
            var selectedState = new Array();
            $('input[name="state_id"]:checked').each(function() {
                selectedState.push(this.value);
            });
            if (selectedState == '') {
                var selectedState = 'null';
            }
            var selectedCity = new Array();
            $('input[name="city_id"]:checked').each(function() {
                selectedCity.push(this.value);
            });
            if (selectedCity == '') {
                var selectedCity = 'null';
            }
            var selectedMothertongue = new Array();
            $('input[name="mothertongue"]:checked').each(function() {
                selectedMothertongue.push(this.value);
            });
            if (selectedMothertongue == '') {
                var selectedMothertongue = 'null';
            }
            if ($('#to_height').val() != '') {
                var toheight = $('#to_height').val();
            } else {
                var toheight = '';
            }
            if ($('#from_height').val() != '') {
                var fromheight = $('#from_height').val();
            } else {
                var fromheight = '';
            }
            if ($('#to_age').val() != '') {
                var toage = $('#to_age').val();
            } else {
                var toage = '';
            }
            if ($('#from_age').val() != '') {
                var fromage = $('#from_age').val();
            } else {
                var fromage = '';
            }
            if ($('#from_age').val() != '') {
                var fromage = $('#from_age').val();
            } else {
                var fromage = '';
            }
            if ($('input[name="photo_search"]:checked').val() != '') {
                var photo_search = $('input[name="photo_search"]:checked').val();
            } else if ($('input[name="photo_search"]:checked').val() == '') {
                var photo_search = 'null';
            } else {
                var photo_search = '';
            }
            $("#loader-animation-area").show();
            var dataString = 'religion=' + selectedReligion + '&caste=' + selectedCaste + '&fromheight=' + fromheight + '&toheight=' + toheight +
                '&occupation=' + selectedOccupation + '&t3=' + fromage + '&t4=' + toage + '&country=' + selectedCountry + '&state=' + selectedState +
                '&city=' + selectedCity + '&gender=' + '<?php echo $gender; ?>' + '&m_status=' + selectedMstatus + '&photo=' + selectedPhoto +
                '&m_tongue=' + selectedMothertongue + '&education_level=' + selectedEducation + '&education_field=' + selectedEducationField +
                '&annual_income=' + annual_income + '&photo_search=' + photo_search + '&orderby=' + selectedOrderBy + '&actionfunction=showData' +
                '&page=1';
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "dbmanupulate2", //Where to make Ajax calls
                dataType: "text", // Data type, HTML, json etc.
                data: dataString,
                success: function(response) {
                    $("#samyak-results").empty();
                    $("#samyak-results").append(response);
                },
                complete: function() {
                    $("#loader-animation-area").hide();
                }
            });
        }

        $("#search-filter").on('change', function() {
            callFilter();
        });

        function changeView(viewType) {
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "web-services/change_view", //Where to make Ajax calls
                dataType: "json", // Data type, HTML, json etc.
                data: 'viewType=' + viewType,
                success: function(response) {
                    if (response.result == 'success') {
                        callFilter();
                    }
                },
            });
        }
    </script>

    <script>
        $(function() {
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z]+$/i.test(value);
            }, "Letters only please");

            $('.owl-carousel').owlCarousel({
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
                navText: ['<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'],
            });
        });
    </script>
    <script type="text/javascript" src="js/select2.min.js"></script>
    <script>
        $(function() {
            $(".chosen-select").css('width', '100%');
            $("ul > li > input").css('width', '100%');
            $('.chosen-select').select2();

            /*---------------Jquery Partener Caste Start-----------------*/
            $("#register_part_religion").on('select2:select', function() {
                var selectedReligion = $("#register_part_religion").val()
                var dataString = 'religion=' + selectedReligion;
                $("#loader-animation-area").show();
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/part_caste_search", //Where to make Ajax calls
                    dataType: "text", // Data type, HTML, json etc.
                    data: dataString,
                    success: function(response) {
                        $("#register_part_caste").remove();
                        $('#CasteDiv1').find('option').remove().end().append(response);
                        $(".chosen-select").css('width', '100%');
                        $('.chosen-select').select2();
                        $("ul > li > input").css('width', '100%');
                    },
                    complete: function() {
                        $("#loader-animation-area").hide();
                    }
                });
            });

            /*Jquery Partener Caste End */
        })
    </script>
    <!-- Custom js codes for plugins -->
    <script type="text/javascript" src="<?= auto_version("js/customs.js") ?>"></script>
    <script>
        function ExpressInterest(toid, name) {
            $("#sendExpressInterestModal").modal("show");
            $.post("web-services/search_send_interest", "frmid=" + toid + "&name=" + name,
                function(data) {
                    $("#expressInterestContentModal").html(data);
                });
        }
    </script>
    <!--Custom JS End-->
</body>
<!--<script>
    $(window).scroll(function (){
        //set scroll position in session storage
        sessionStorage.scrollPos = $(window).scrollTop();
    });
    var init = function () {
        //get scroll position in session storage
        $(window).scrollTop(sessionStorage.scrollPos || 0);
    };
    window.onload = init;
</script>-->
<script>
    $(document).ready(function() {
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
</script>

</html>