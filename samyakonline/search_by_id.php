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
unset($_SESSION['samyak_id']);
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
    <link href="css/main.css" rel="stylesheet">
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

        <div class="clear"></div>

        <div class="container">
            <div class="content-wrapper">
                <div class="col-xs-12 col-md-offset-4 col-md-4">
                    <div class="result-search-form-wrapper clearfix">

                        <h3 class="text-center">Search Profile By ID</h3>
                        <form class="" method="post" action="search_result" style="padding-top: 10px;">
                            <div class="inner" style="padding: 0px 5px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                       style="margin-bottom: 0px;">
                                    <tr style="">
                                        <td style="padding: 4px;">
                                            <input type="text" name="search_by_profile_id"
                                                   class="form-control input-sm mb-10"
                                                   placeholder="Enter Profile ID">
                                        </td>
                                        <td style="padding: 4px;">
                                            <input type="submit" name="search" value="Search"
                                                   class="btn btn-danger btn-sm btn-shrink"
                                                   style="cursor:pointer;"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
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
        alert("Please complete partner preference");
        window.location.href = 'edit-profile';
    </script>
    <?php } ?>


<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="js/customs.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script>
    $(function(){
        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();
    });

    // Change hash for page-reload
    $('.tab-nav a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    })
</script>
</body>
</html>