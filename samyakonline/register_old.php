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
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">

    <!-- CSS Custom -->
    <link href="css/style.css?v=1.0" rel="stylesheet">

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

        <div class="clear"></div>

        <div class="container">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
                        <form id="register-profile" action="#" method="post" enctype="multipart/form-data"
                              style="padding: 10px; border: 1px solid silver;">
                            <div id="showRegisterError" class="font22 text-center text-danger"></div>
                            <!-- Begin | Register Form -->
                            <div id="register-form">

                                <div class="text-center mb-15" style="font-size: 14px; font-weight: bold;">Let's start
                                    partner search with Register profile
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                     style="padding:0px 5px 0px 0px !important;">
                                    <div class="form-group mb-0">
                                        <input id="register_firstname" name="first_name" class="form-control mb-5"
                                               type="text" required onkeyup="removeWhiteSpace(this);"
                                               placeholder="First Name">
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                     style="padding:0px 0px 0px 5px !important;">
                                    <div class="form-group mb-0">
                                        <input id="register_lastname" name="last_name" class="form-control mb-5"
                                               type="text"
                                               required onkeyup="removeWhiteSpace(this);"
                                               placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <input id="register_mobile" name="mobile_no" minlength="10" maxlength="10"
                                               class="form-control mb-5" type="text"
                                               required
                                               placeholder="Mobile No">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <input id="alternate_mobile" name="alternate_no" minlength="10" maxlength="10"
                                               class="form-control mb-5" type="text"
                                               title="You can put any of your family member's contact number"
                                               placeholder="Alternate Mobile No">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <input id="register_email" name="email" class="form-control mb-5" type="email"
                                               required
                                               placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <input id="register_password" name="password" class="form-control mb-5"
                                               type="password" required
                                               placeholder="Password">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3 col-xss-3"
                                     style="padding:0px 5px 0px 0px !important;">
                                    <div class="form-group mb-0">
                                        <select id="register_date" name="day" class="form-control mb-5" required
                                                onchange="setDays(month,this,year)">
                                            <option value="" disabled selected>Day</option>
                                            <?php
                                            if (isset($_REQUEST['day']) && $_REQUEST['day'] != '') {
                                                ?>
                                                <option value="<?php echo $_REQUEST['day']; ?>"><?php echo $_REQUEST['day']; ?></option>
                                                <?php
                                            }
                                            ?>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4 col-xss-4"
                                     style="padding:0px 0px 0px 0px !important;">
                                    <div class="form-group mb-0">
                                        <select id="register_month" name="month" class="form-control mb-5" required
                                                onchange="setDays(this,day,year)">
                                            <option value="" selected disabled>Month</option>
                                            <option value="01" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '01') {
                                                echo "selected";
                                            } ?>>Jan
                                            </option>
                                            <option value="02" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '02') {
                                                echo "selected";
                                            } ?>>Feb
                                            </option>
                                            <option value="03" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '03') {
                                                echo "selected";
                                            } ?>>Mar
                                            </option>
                                            <option value="04" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '04') {
                                                echo "selected";
                                            } ?>>Apr
                                            </option>
                                            <option value="05" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '05') {
                                                echo "selected";
                                            } ?>>May
                                            </option>

                                            <option value="06" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '06') {
                                                echo "selected";
                                            } ?>>Jun
                                            </option>
                                            <option value="07" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '07') {
                                                echo "selected";
                                            } ?>>Jul
                                            </option>
                                            <option value="08" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '08') {
                                                echo "selected";
                                            } ?>>Aug
                                            </option>
                                            <option value="09" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '09') {
                                                echo "selected";
                                            } ?>>Sep
                                            </option>
                                            <option value="10" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '10') {
                                                echo "selected";
                                            } ?>>Oct
                                            </option>
                                            <option value="11" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '11') {
                                                echo "selected";
                                            } ?>>Nov
                                            </option>
                                            <option value="12" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '12') {
                                                echo "selected";
                                            } ?>>Dec
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-5 col-xs-5 col-xss-5"
                                     style="padding:0px 0px 0px 5px !important;">
                                    <div class="form-group mb-0">
                                        <select id="register_year" name="year" class="form-control mb-5" required
                                                onchange="setDays(month,day,this)">
                                            <option value="" selected disabled>Year</option>
                                            <?php
                                            for ($x = 2000; $x >= 1960; $x--) {
                                                ?>
                                                <option value="<?php echo $x; ?>"
                                                    <?php if (isset($_REQUEST['year']) && $_REQUEST['year'] == $x) {
                                                        echo "selected";
                                                    } elseif (isset($_REQUEST['year']) && $_REQUEST['year'] == '' && $x == 1990) {
                                                        echo "selected";
                                                    } ?> ><?php echo $x; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <select id="register_height" class="form-control mb-5" name="height" required>
                                            <option value="" selected disabled>Select Height</option>
                                            <?php
                                            if (isset($_REQUEST['height'])) {
                                                ?>
                                                <option value="<?php echo $_REQUEST['height']; ?>"><?php $ao3 = $_REQUEST['height'];
                                                    $ft3 = (int)($ao3 / 12);
                                                    $inch3 = $ao3 % 12;
                                                    echo $ft3 . "ft" . " " . $inch3 . "in"; ?> </option>
                                                <?php
                                            }
                                            ?>
                                            <option value="48">4ft</option>
                                            <option value="49">4ft 01in</option>
                                            <option value="50">4ft 02in</option>
                                            <option value="51">4ft 03in</option>
                                            <option value="52">4ft 04in</option>
                                            <option value="53">4ft 05in</option>
                                            <option value="54">4ft 06in</option>
                                            <option value="55">4ft 07in</option>
                                            <option value="56">4ft 08in</option>
                                            <option value="57">4ft 09in</option>
                                            <option value="58">4ft 10in</option>
                                            <option value="59">4ft 11in</option>
                                            <option value="60">5ft</option>
                                            <option value="61">5ft 01in</option>
                                            <option value="62">5ft 02in</option>
                                            <option value="63">5ft 03in</option>
                                            <option value="64">5ft 04in</option>
                                            <option value="65">5ft 05in</option>
                                            <option value="66">5ft 06in</option>
                                            <option value="67">5ft 07in</option>
                                            <option value="68">5ft 08in</option>
                                            <option value="69">5ft 09in</option>
                                            <option value="70">5ft 10in</option>
                                            <option value="71">5ft 11in</option>
                                            <option value="72">6ft</option>
                                            <option value="73">6ft 01in</option>
                                            <option value="74">6ft 02in</option>
                                            <option value="75">6ft 03in</option>
                                            <option value="76">6ft 04in</option>
                                            <option value="77">6ft 05in</option>
                                            <option value="78">6ft 06in</option>
                                            <option value="79">6ft 07in</option>
                                            <option value="80">6ft 08in</option>
                                            <option value="81">6ft 09in</option>
                                            <option value="82">6ft 10in</option>
                                            <option value="83">6ft 11in</option>
                                            <option value="84">7ft</option>
                                            <option value="85">Above 7ft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <select id="register_gender" class="form-control mb-5" name="gender" required>
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="Bride"
                                                <?php if (isset($gender) && $gender == 'Bride') {
                                                    echo "selected";
                                                } elseif (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'Bride') {
                                                    echo "selected";
                                                } ?>>Female
                                            </option>
                                            <option value="Groom"
                                                <?php if (isset($gender) && $gender == 'Groom') {
                                                    echo "selected";
                                                } elseif (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'Groom') {
                                                    echo "selected";
                                                } ?>>Male
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <select id="register_complexion" class="form-control mb-5" name="complexion"
                                                required>
                                            <option value="" selected disabled>Select Complexion</option>
                                            <option value="Wheatish Brown">Wheatish Brown</option>
                                            <option value="Wheatish">Wheatish</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Very Fair">Very Fair</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <select id="register_profile_for" class="form-control mb-5" name="profile_for"
                                                required>
                                            <option value="" selected disabled>Profile posted by</option>
                                            <option value="Parents">Parents</option>
                                            <option value="Self">Self</option>
                                            <option value="Friend">Friend</option>
                                            <option value="Sibling">Sibling</option>
                                            <option value="Relatives">Relatives</option>
                                            <option value="Marriage Bureau">Marriage Bureau</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                    <div class="form-group mb-0">
                                        <select id="register_referred_by" class="form-control mb-5" name="referred_by"
                                                required>
                                            <option value="" selected disabled>Select Reference from</option>
                                            <option value="Google">Google</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Samrat Paper">Samrat Paper</option>
                                            <option value="Lokmat Newspaper">Lokmat Newspaper</option>
                                            <option value="Other Newspaper">Other Newspaper</option>
                                            <option value="Relative">Relative</option>
                                            <option value="Friend">Friend</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding mb-0">
                                    <div class="text-center" style="font-size: 11px;">
                                        By signing up, you agree to our <a href="terms"> Terms</a>.
                                    </div>
                                </div>
                                <div class="row gap-10">
                                    <div class="col-xs-offset-3 col-sm-offset-3 col-xs-6 col-sm-6 mb-10">
                                        <button id="register_page2_btn" type="button" class="btn btn-danger btn-block">
                                            Create Profile
                                        </button>
                                    </div>
                                </div>
                                <div class="text-left">
                                    If you need any help whatsapp us - <a href="https://api.whatsapp.com/send?phone=917977993616&text=Hello,%0A%0AI am facing issues in registering myself, please help." title="Help in Register"><i class="fa fa-whatsapp"></i> Click Here</a>
                                </div>
                                <div class="text-left">
                                    Already have account?
                                    <a href="login" id="register_login_btn" type="button" class="btn btn-link" style="font-weight: bold;">Login</a>
                                </div>
                            </div>
                            <!-- End | Register Form -->

                            <!-- Begin | Register Form 2 -->
                            <div id="register-form-2" style="display:none;">

                                <div class="modal-body" style="padding-bottom: 0px;">

                                    <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">
                                        Great!
                                        Let's be familiar
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_religion_id" name="religion_id"
                                                    class="form-control mb-5"
                                                    onchange="GetCaste('web-services/caste_search?religionId='+this.value)">
                                                <option value="" selected disabled>Religion</option>
                                                <?php
                                                $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>" <?php if (isset($religion_id) && $DatabaseCo->dbRow->religion_id == $religion_id) {
                                                        echo "selected";
                                                    } else if (isset($_REQUEST['religion_id']) && $_REQUEST['religion_id'] == $DatabaseCo->dbRow->religion_id) {
                                                        echo "selected";
                                                    } else if (!isset($_REQUEST['religion_id']) && $DatabaseCo->dbRow->religion_id == 7) {
                                                        echo "selected";
                                                    } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <div class="form-group mb-0" id="CasteDiv">
                                            <?php
                                            $caste_name = '';

                                            if (isset($_POST['caste_id'])) {
                                                $caste_name = $caste_id;
                                            } elseif (isset($_REQUEST['my_caste'])) {
                                                $caste_name = $_REQUEST['my_caste'];
                                            }

                                            if ($caste_name != '') {
                                                $caste = $DatabaseCo->dbLink->query("select * from caste where caste_id='$caste_name'");
                                                $row = mysqli_fetch_array($caste);
                                            }

                                            ?>
                                            <select id="register_my_caste" name="my_caste" class="form-control mb-5"
                                                    required>
                                                <option value="" selected disabled>Caste</option>
                                                <option value="227" selected>SC</option>
                                                <?php
                                                if (isset($caste_name) && $caste_name != '') {
                                                    ?>
                                                    <option value="<?php echo $row['caste_id']; ?>"><?php echo $row['caste_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_mothertongue" name="mothertongue"
                                                    class="form-control mb-5">
                                                <option value="" selected disabled>Select Mothertongue</option>
                                                <?php
                                                $SQL_STATEMENT_Mtongu = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");

                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_Mtongu)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?php if (isset($_REQUEST['mothertongue']) && $_REQUEST['mothertongue'] == $DatabaseCo->dbRow->mtongue_id) {
                                                        echo "selected";
                                                    } else if ($DatabaseCo->dbRow->mtongue_id == 7) {
                                                        echo "selected";
                                                    } ?>><?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="marital_status" id="marital_status">
                                                <option value="" selected disabled>Marital Status</option>
                                                <option value="Unmarried" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Unmarried') {
                                                    echo "selected";
                                                } else if (!isset($_REQUEST['marital_status'])) {
                                                    echo "selected";
                                                } ?>>Unmarried
                                                </option>
                                                <option value="Widow/Widower" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Widow/Widower') {
                                                    echo "selected";
                                                } ?>>Widow/Widower
                                                </option>
                                                <option value="Divorcee" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Divorcee') {
                                                    echo "selected";
                                                } ?>>Divorcee
                                                </option>
                                                <option value="Separated" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Separated') {
                                                    echo "selected";
                                                } ?>>Separated
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="divorcee_section" style="display: none;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="child" id="register_divorcee_child">
                                                <option value="" selected disabled>Have any Children ?</option>
                                                <option value="No">No</option>
                                                <option value="Yes. Living together">Yes. Living together</option>
                                                <option value="Yes. Not living together">Yes. Not living together
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="education_level" id="edu_level">

                                                <option value="" selected disabled>Select Education Level</option>
                                                <?php
                                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_level_id, e_level_name FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");
                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>">
                                                        <?= $DatabaseCo->dbRow->e_level_name ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="edu_field" id="register_edu_field">
                                                <option value="" selected disabled>Select Education Field</option>
                                                <?php
                                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT e_field_id, e_field_name FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");
                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                    ?>
                                                    <option value="<?= $DatabaseCo->dbRow->e_field_id ?>">
                                                        <?= $DatabaseCo->dbRow->e_field_name ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0">
                                        <select class="form-control mb-5" name="edu_id[]" id="edu_id">
                                            <option value="" selected disabled>Select Qualification</option>
                                            <?php
                                            $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT edu_id, edu_name FROM education_detail WHERE status='APPROVED' ORDER BY edu_name ASC");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                                                ?>
                                                <option value="<?= $DatabaseCo->dbRow->edu_id; ?>">
                                                    <?= $DatabaseCo->dbRow->edu_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="employed_in"
                                                    id="register_employed_in">
                                                <option value="" selected disabled>Select Employed In</option>
                                                <option value="Private" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Private') {
                                                    echo "selected";
                                                } ?>>Private
                                                </option>
                                                <option value="Government" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Government') {
                                                    echo "selected";
                                                } ?>>Government
                                                </option>
                                                <option value="Business" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Business') {
                                                    echo "selected";
                                                } ?>>Business
                                                </option>
                                                <option value="Defence" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Defence') {
                                                    echo "selected";
                                                } ?>>Defence
                                                </option>
                                                <option value="Not Employed in" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Not Employed in') {
                                                    echo "selected";
                                                } ?>>Not Employed in
                                                </option>
                                                <option value="Others" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Others') {
                                                    echo "selected";
                                                } ?>>Others
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="occupation"
                                                    id="register_occupation">
                                                <option value="" selected disabled> Select Occupation</option>
                                                <?php
                                                $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>" <?php if (isset($occupation) && $DatabaseCo->dbRow->ocp_id == $occupation) {
                                                        echo "selected";
                                                    } else if (isset($_REQUEST['occupation']) && $_REQUEST['occupation'] == $DatabaseCo->dbRow->ocp_id) {
                                                        echo "selected";
                                                    } ?>><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                        <div class="form-group mb-0">
                                            <input id="register_salary" name="monthly_salary" minlength="4"
                                                   maxlength="7"
                                                   class="form-control mb-5" type="text"
                                                   placeholder="Monthly Salary">
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <select class="form-control mb-5" name="annual_income"
                                                id="register_annual_income">
                                            <option value="" selected disabled>Select Annual Income</option>
                                            <?php
                                            $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");

                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) {
                                                ?>
                                                <option value="<?= $DatabaseCo->dbRow->title; ?>"><?= $DatabaseCo->dbRow->title ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer pb-5" style="border-top: none; margin-top: 10px;">

                                    <div class="row gap-10">
                                        <div class="col-xs-6 col-sm-6 mb-10">
                                            <button id="register_page2_prev_btn" type="button"
                                                    class="btn btn-danger btn-block">Previous Page
                                            </button>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 mb-10">
                                            <button id="register_page3_btn" type="button"
                                                    class="btn btn-primary btn-block">
                                                Continue
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- End | Register Form 2-->

                            <!-- Begin | Register Form 3 -->
                            <div id="register-form-3" style="display:none;">

                                <div class="modal-body" style="padding-bottom: 0px;">

                                    <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">A
                                        little brief about you
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_father_occupation" name="father_occupation"
                                                    class="form-control mb-5" required>
                                                <option value="" selected disabled>Father Status</option>
                                                <option value="Retired">Retired</option>
                                                <option value="Employed">Employed</option>
                                                <option value="Business">Business</option>
                                                <option value="Professional">Professional</option>
                                                <option value="Not Employed">Not Employed</option>
                                                <option value="No More">No More</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <select id="register_mother_occupation" name="mother_occupation"
                                                class="form-control mb-5" required>
                                            <option value="" selected disabled>Mother Status</option>
                                            <option value="Housewife">Housewife</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Business">Business</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Not Employed">Not Employed</option>
                                            <option value="No More">No More</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_brother_nos" name="no_of_brothers"
                                                    class="form-control mb-5">
                                                <option value="" selected disabled>No of Brothers</option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="4 +">4 +</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_sister_nos" name="no_of_sisters" class="form-control mb-5">
                                                <option value="" selected disabled>No of Sisters</option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="4 +">4 +</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_living_status" name="living_status"
                                                    class="form-control mb-5">
                                                <option value="" selected disabled>Living Status</option>
                                                <option value="With Parents">With Parents</option>
                                                <option value="As Room Mate">As Room Mate</option>
                                                <option value="Myself">Myself</option>
                                                <option value="Paying Guest">Paying Guest</option>
                                                <option value="In Hostel">In Hostel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_house_ownership" name="house_ownership"
                                                    class="form-control mb-5">
                                                <option value="" selected disabled>House Ownership</option>
                                                <option value="Own Flat">Own Flat/Bungalow</option>
                                                <option value="Parent Flat">Parent Flat/Bungalow</option>
                                                <option value="Renting in Flat">Renting in Flat/Bungalow</option>
                                                <option value="Stay With Relative">Stay With Relative</option>
                                                <option value="Don't have House">Don't have House</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 5px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_body_type" name="body_type" class="form-control mb-5">
                                                <option value="" selected disabled>Body Type</option>
                                                <option value="Slim">Slim</option>
                                                <option value="Average">Average</option>
                                                <option value="Athletic">Athletic</option>
                                                <option value="Heavy">Heavy</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                         style="padding:0px 0px 0px 0px !important;">
                                        <div class="form-group mb-0">
                                            <select id="register_disability" name="disability" class="form-control mb-5">
                                                <option value="" selected disabled>Any Disability</option>
                                                <option value="None">None</option>
                                                <option value="HIV Positive">HIV Positive</option>
                                                <option value="Mentally Challenged">Mentally Challenged</option>
                                                <option value="Physically Challenged">Physically Challenged</option>
                                                <option value="Physically and Mentally Challenged">Physically and Mentally Challenged</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="family_origin" id="family_origin">
                                                <option selected value="" disabled>Select Family Origin / Native Place
                                                </option>
                                                <?php
                                                $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                        <div class="form-group mb-0">
                                            <select class="form-control mb-5" name="country_id" id="country_id">
                                                <option value="" selected disabled>Select Your Country</option>
                                                <?php
                                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT country_id,country_name FROM country WHERE status='APPROVED' order by country_name ASC");

                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>"
                                                        <?php if (isset($_REQUEST['country_id']) && $_REQUEST['country_id'] == $DatabaseCo->dbRow->country_id) {
                                                            echo "selected";
                                                        } else if ($DatabaseCo->dbRow->country_id == 95) {
                                                            echo "selected";
                                                        } ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0">
                                        <select class="form-control mb-5" name="city" id="city">
                                            <option selected value="" disabled>Select Residence City</option>
                                            <?php
                                            $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-0">
                                    <textarea style="height: 75px;" class="form-control mb-5" name="profile_text"
                                              id="register_profile_text"
                                              placeholder="Write about your personality, family background and what you are looking for in your partner."></textarea>
                                    </div>

                                </div>

                                <div class="modal-footer pb-5" style="border-top: none; margin-top: 10px;">

                                    <div class="row gap-10">
                                        <div class="col-xs-6 col-sm-6 mb-10">
                                            <button id="register_page3_prev_btn" type="button"
                                                    class="btn btn-danger btn-block">Previous Page
                                            </button>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 mb-10">
                                            <button id="register_me" type="button" class="btn btn-primary btn-block">
                                                Finish
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- End | Register Form 3-->
                        </form>
                    </div>
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

<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script type="text/javascript" src="js/customs-validate.js?v=1.0"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="<?= auto_version('js/customs.js') ?>"></script>
</body>
</html>