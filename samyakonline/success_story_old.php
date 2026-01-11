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

$page = isset($_GET['page']) ? $_GET['page'] : '1';
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
                            <li><a href="success_story">Success Story</a></li>
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
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-12 text-center">
                            <h5 class="btn btn-primary btn-shrink text-center">Success Story</h5>
                        </div>
                        <div class="col-xs-12">
                            <p class="mt-20 mb-40">
                                They say marriages are made in heaven and we at <?php echo $configObj->getConfigFname(); ?> are
                                trying to bring together that someone who is made for you. We welcome you all to celebrate with
                                us the Success Stories of the innumerable married couples who have found their dream partner
                                through <?php echo $configObj->getConfigFname(); ?>. We wish them the very best for a happy and
                                successful married life.
                            </p>
                        </div>
                        <div class="col-xs-12">
                            <div id="short_story"></div>
                        </div>
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

<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="js/customs.js"></script>
<script type="text/javascript" src="js/validetta.js"></script>

<!---------------Jquery Form validation------------------>
<script type="text/javascript">
    $(function () {
        $('#success_story_form').validetta({
            errorClose: false,
            custom: {
                regname: {
                    pattern: /^[\+][0-9]+?$|^[0-9]+?$/,
                    errorMessage: 'Custom Reg Error Message !'
                },
                // you can add more
                example: {
                    pattern: /^[\+][0-9]+?$|^[0-9]+?$/,
                    errorMessage: 'Lan mal !'
                }
            },
            realTime: true
        });

        $.post("web-services/success_story_pagination",
            { actionfunction: 'showData', page: '<?php echo $page; ?>'},
            function (response) {
                $('#suc_story').html(response);

            }
        );
    });
    $.post("web-services/short_success_story",
        {actionfunction: 'showData', page: '1'},
        function (response) {
            $('#short_story').html(response);
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
                'placement': 'top'
            });

        }
    );

    $('#suc_story').on('click', '.page-numbers', function () {

        $page = $(this).attr('href');
        $pageind = $page.indexOf('page=');
        $page = $page.substring(($pageind + 5));

        var dataString = 'actionfunction=showData' + '&page=' + $page;

        $.ajax({
            url: "web-services/success_story_pagination",
            type: "POST",
            data: dataString,
            cache: false,
            success: function (response) {
                $('#suc_story').html(response);
            }
        });
        return false;
    });


    $('#short_story').on('click', '.page-numbers', function () {

        $page = $(this).attr('href');
        $pageind = $page.indexOf('page=');
        $page = $page.substring(($pageind + 5));

        var dataString = 'actionfunction=showData' + '&page=' + $page;

        $.ajax({
            url: "web-services/short_success_story",
            type: "POST",
            data: dataString,
            cache: false,
            success: function (response) {
                $('#short_story').html(response);
            }
        });
        return false;
    });


</script>
<!---------------Jquery Form validation End------------------>
</body>
</html>