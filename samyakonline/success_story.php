<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 09/01/2022
 * Time: 11:55 AM
 */
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
$configObj = new Config();

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title>Real Couples from Our Trusted Matrimonial Services</title>
    <meta name="keyword" content="Matrimonial Success Stories, Marriage Success Stories, Real Wedding Stories, Happy Couples, Successful Matches, Matrimonial Testimonials, Love Stories, Wedding Success, Matchmaking Success, Bride and Groom Stories."/>
    <meta name="description" content="Read inspiring matrimonial success stories from real couples who found their perfect match through our trusted platform. Start your journey to love today!"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
    <meta name="author" content="Manish Gupta <contact@manishdesigner.com>">

    <!-- Favicons-->
    <link rel="shortcut icon" href="new-design/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="new-design/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
          href="new-design/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
          href="new-design/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
          href="new-design/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="new-design/css/bootstrap.min.css" rel="stylesheet">
    <link href="new-design/css/style.css" rel="stylesheet">
    <link href="new-design/css/vendors.css" rel="stylesheet">

    <!-- CUSTOM CSS -->
    <link href="new-design/css/custom.css" rel="stylesheet">

</head>

<body class="not-home" style="overflow-x: hidden;">
<?php
require_once 'layouts/new-header.php';
?>

<section class="parallax-window parallax-window-small" data-parallax="scroll" data-image-src="new-design/img/hero_3.jpg"
         data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-1 parallax-content-1-small opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
        <div class="animated fadeInDown">
            <h1>Success stories</h1>
            <p>We are proudly presenting our success stories</p>
        </div>
    </div>
</section>
<!-- End Section -->

<main>
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="index">Home</a></li>
                <li>Success Stories</li>
            </ul>
        </div>
    </div>
    <!-- End Position -->

    <div class="container margin_60">
        <div class="main_title">
            <h2>Some <span>matches</span> made through us</h2>
            <p class="font-11 mt-10">
                They say marriages are made in heaven and we at <?php echo $configObj->getConfigFname(); ?> are
                trying to bring together that someone who is made for you. We welcome you all to celebrate with
                us the Success Stories of the innumerable married couples who have found their dream partner
                through <?php echo $configObj->getConfigFname(); ?>. We wish them the very best for a happy and
                successful married life.
            </p>
        </div>
        <hr>
        <div class="row magnific-gallery add_bottom_60" id="success_story">
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
</main>
<!-- End main -->
<?php
require_once 'layouts/new-footer.php';
?>


<!-- Common scripts -->
<script src="new-design/js/jquery-3.6.0.min.js"></script>
<script src="new-design/js/common_scripts_min.js"></script>
<script src="new-design/js/functions.js"></script

        <!---------------Jquery Form validation------------------>
<script type="text/javascript">
    let shallFire = true;
    sessionStorage.setItem('success-page', 1);
    $(function () {
        getSuccessStory();
        // For Desktops
        $(window).on('scroll', infiniteScroll);
        // For Mobiles
        $(window).on('touchmove', infiniteScroll);
    });

    function getSuccessStory() {
        let dataString = 'page=' + (sessionStorage.getItem('success-page') || 1) + '&limit=18';
        $.ajax({
            url: "web-services/success_story_service",
            type: "POST",
            data: dataString,
            cache: false,
            beforeSend: function () {
                $("#preloader").show();
            },
            success: function (response) {
                if (response.trim() !== "") {
                    $('#success_story').append(response);
                } else {
                    shallFire = false;
                }
            },
            complete: function () {
                $("#preloader").hide();
            }
        });
    }

    function infiniteScroll() {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
            if (shallFire) {
                shallFire = false;
                resetFlag();
                if (!isNaN(parseInt(sessionStorage.getItem('success-page')))) {
                    sessionStorage.setItem('success-page', parseInt(sessionStorage.getItem('success-page')) + 1);
                } else {
                    sessionStorage.setItem('success-page', 1);
                }
                getSuccessStory();
            }
        }
    }

    function resetFlag() {
        setTimeout(function () {
            shallFire = true;
        }, 2000)
    }
</script>
</body>
</html>