<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 03/23/2021
 * Time: 07:41 PM
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
    <link href="<?= auto_version('css/style.css') ?>" rel="stylesheet">

    <!-- Add your style -->
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="css/select2.min.css"/>

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

        <div class="breadcrumb-wrapper hidden-sm hidden-xs hidden-xss">
            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="homepage">Dashboard</a></li>
                            <li><a href="javascript:void(0);">Quick Links</a></li>
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
        <div class="container">
            <div class="content-wrapper">
                <div class="row" style="padding: 0px 5px;">
                    <div class="col-xs-12 text-center">
                        <p class="font-16 font-weight-bold">Browse profiles by</p>
                    </div>
                    <div class="col-xs-12 mt-10 font-12 text-center">
                        <b>Quick Links - </b>
                        <a title="Divorcee Matrimony" href="divorcee-matrimonials"
                           class="tag-item">Divorcee </a> |
                        <a title="Separated Matrimony " href="separated-matrimonials"
                           class="tag-item">Separated </a> |
                        <a title="Widow/Widower Matrimony" href="widow-widower-matrimonials"
                           class="tag-item">Widow/Widower </a> |
                        <a title="Caste No Bar" href="no-caste-bar-matrimonials"
                           class="tag-item">No Caste Bar
                        </a> |
                        <a title="Physically Challenged Profiles" href="physically-challenged-matrimonials"
                           class="tag-item">Physically Challenged
                        </a> |

                    </div>
                    <div class="col-xs-12 mt-10 text-center font-12">

                        <b>Education - </b>
                        <a title="Buddhist Bride & Groom Enginner Profile" href="engineer-matrimonials"
                           class="tag-item">Engineering</a> |
                        <a title="Buddhist Bride & Groom Doctor Matrimonials profile" href="doctor-matrimonials"
                           class="tag-item">Doctor </a>|
                        <a title="Buddhist Bride & Groom MBA Matrimonials profile" href="management-matrimonials"
                           class="tag-item">Management</a> |
                        <a title="Buddhist Bride & Groom Architect Matrimonials profile" href="architect-matrimonials"
                           class="tag-item">Architect </a> |
                        <a title="Buddhist Bride & Groom Finance Matrimonials" href="finance-matrimonials"
                           class="tag-item"> Finance </a> |
                        <a title="Buddhist Bride & Groom Lawyers Profile" href="lawyers-matrimonials"
                           class="tag-item">Lawyers </a> |
                        <a title="Buddhist Bride & Groom IT Software " href="it-software-matrimonials"
                           class="tag-item">IT Software </a> |
                        <a title="Buddhist Bride & Groom Pharmacy Profile" href="pharmacy-matrimonials"
                           class="tag-item">Pharmacy </a> |
                        <a title="Buddhist Bride & Groom Administrative Profile" href="administrative-matrimonials"
                           class="tag-item"> Administrative</a> |
                        <a title="Buddhist Bride & Groom Marketing Profile" href="marketing-matrimonials"
                           class="tag-item"> Marketing</a> |
                        <a title="Buddhist Bride & Groom BA/MA Profile" href="art-matrimonials" class="tag-item">
                            BA/MA </a> |
                        <a title="Buddhist Bride & Groom BCom/MCom profile" href="commerce-matrimonials"
                           class="tag-item"> BCom/MCom</a> |
                        <a title="Buddhist Bride & Groom BSc/MSc profile " href="science-matrimonials"
                           class="tag-item"> BSc/MSc </a> |
                        <a title="Buddhist Bride & Groom Healthcare profile" href="healthcare-media-matrimonials"
                           class="tag-item"> Healthcare</a> |
                        <a title="Buddhist Bride & Groom Less than High School profile"
                           href="less-than-high-school-matrimonials"
                           class="tag-item"> High School</a>

                    </div>

                    <div class="col-xs-12 mt-10 font-12 text-center">
                        <b>Residence District - </b>
                        <a title="India Buddhist Matrimony " href="vidarbha-city-matrimonials"
                           class="tag-item">Vidarbha</a> |
                                                   <a title="India Buddhist Matrimony " href="Kokan-city-matrimonials"
                           class="tag-item">Kokan</a> |
                                                                              <a title="India Buddhist Matrimony " href="marathwada-city-matrimonials"
                           class="tag-item">Marathwada</a> |
                                                   <a title="India Buddhist Matrimony " href="mumbai-city-matrimonials"
                           class="tag-item">Mumbai</a> |
                           <a title="India Buddhist Matrimony " href="khandesh-city-matrimonials"
                           class="tag-item">Khandesh</a> |
                                                      <a title="India Buddhist Matrimony " href="paschim_maharashtra-city-matrimonials.php"
                           class="tag-item">Paschim Maharashtra</a> |
                        </a>
                    </div>
                    
                    <div class="col-xs-12 mt-10 font-12 text-center">

                        <b>City - </b>

                        <a title="Pune Buddhist Matrimony" href="pune-matrimonials"
                           class="tag-item">Pune</a>
                        |
                        <a title="Mumbai Buddhist Matrimony" href="mumbai-matrimonials"
                           class="tag-item">Mumbai </a>|
                        <a title="Thane Buddhist Matrimony" href="thane-matrimonials"
                           class="tag-item">Thane</a>|
                        <a title="Kalyan Buddhist Matrimony" href="kalyan-matrimonials"
                           class="tag-item">kalyan</a>|
                        <a title="Nagpur Buddhist Matrimony" href="nagpur-matrimonials"
                           class="tag-item">Nagpur</a>|
                        <a title="Amaravati Buddhist Matrimony" href="amaravati-matrimonials"
                           class="tag-item">Amaravati</a>|
                        <a title="Akola Buddhist Matrimony" href="akola-matrimonials"
                           class="tag-item">Akola</a>|
                        <a title="Ahmednagar Buddhist Matrimony" href="ahmednagar-matrimonials"
                           class="tag-item">Ahmednagar</a>|
                        <a title="Beed Buddhist Matrimony" href="beed-matrimonials"
                           class="tag-item">Beed</a>
                        |
                        <a title="Karad Buddhist Matrimony" href="karad-matrimonials"
                           class="tag-item">Karad</a>|
                        <a title="Kokan Buddhist Matrimony" href="kokan-matrimonials"
                           class="tag-item">Kokan</a>|
                        <a title="Kolhapur Buddhist Matrimony" href="kolhapur-matrimonials"
                           class="tag-item">Kolhapur</a>|
                        <a title="Latur Buddhist Matrimony" href="latur-matrimonials"
                           class="tag-item">Latur</a>|
                        <a title="Nashik Buddhist Matrimony" href="nashik-matrimonials"
                           class="tag-item">Nashik</a>|
                        <a title="Navi-Mumbai Buddhist Matrimony"
                           href="navi-mumbai-matrimonials"
                           class="tag-item">Navi-Mumbai</a>|
                        <a title="Raigad Buddhist Matrimony" href="raigad-matrimonials"
                           class="tag-item">Raigad</a>|
                        <a title="Ratnagiri Buddhist Matrimony" href="ratnagiri-matrimonials"
                           class="tag-item">Ratnagiri</a>|
                        <a title="Sangli Buddhist Matrimony" href="sangli-matrimonials"
                           class="tag-item">Sangli</a>|
                        <a title="Satara Buddhist Matrimony" href="satara-matrimonials"
                           class="tag-item">Satara</a>|
                        <a title="Chandrapur Buddhist Matrimony" href="chandrapur-matrimonials"
                           class="tag-item">Chandrapur</a>


                    </div>

                    <div class="col-xs-12 mt-10 font-12 text-center">

                        <b>Country - </b>
                        <a title="India Buddhist Matrimony " href="india-matrimonials"
                           class="tag-item">India</a> |
                        <a title="Outside India Buddhist Matrimony" href="nri-matrimonials"
                           class="tag-item">Outside India Profiles
                        </a>
                    </div>

                    <div class="col-xs-12 mt-10 font-12 text-center">
                        <b>Native District - </b>
                        <a title="India Buddhist Matrimony " href="vidarbha-native-city-matrimonials"
                           class="tag-item">Vidarbha</a> |
                                                   <a title="India Buddhist Matrimony " href="kokan-native-city-profile"
                           class="tag-item">Kokan</a> |
                            <a title="India Buddhist Matrimony " href="marathwada-native-city-matrimonials"
                           class="tag-item">Marathwada</a> |
                                                       <a title="India Buddhist Matrimony " href="mumbai-native-city-matrimonials"
                           class="tag-item">Mumbai</a> |
                            <a title="India Buddhist Matrimony " href="khandesh-native-city-profile"
                           class="tag-item">Khandesh</a> |
                                                       <a title="India Buddhist Matrimony " href="paschim_maharashtra-native-city-matrimonials"
                           class="tag-item">Paschim Maharashtra</a> |
                    </div>

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
</body>
</html>