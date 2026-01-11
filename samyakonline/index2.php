<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 9/2/2018
 * Time: 11:16 PM
 */
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title><?php echo $configObj->getConfigTitle(); ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <!-- CSS Plugins -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/component.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/owl.carousel.min.css">
    <link rel="stylesheet" href="css/template.css?v=1.0">

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
    <link href="css/style.css" rel="stylesheet">

    <!-- Add your style -->
    <link href="css/your-style.css" rel="stylesheet">
    <!-------------------chosen css ------------------>
    <!--<link rel="stylesheet" href="css/chosen.css?v=2.0">
    <link rel="stylesheet" href="css/chosen.min.css">-->
    <link rel="stylesheet" href="css/select2.min.css"/>
    <link rel="stylesheet" href="css/prism.css?v=1.0">
    <!-------------------chosen css end------------------>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="">
<div style="overflow-x: hidden !important;">
    <!--<div id="introLoader" class="introLoading"></div>-->

    <?php @include_once 'page-parts/modal.php'; ?>

    <!-- start Container Wrapper -->
    <div class="container-wrapper colored-navbar-brand">

        <?php @include_once 'layouts/menu.php' ?>

        <div class="clear"></div>

        <!-- start Main Wrapper -->
        <div class="main-wrapper">

            <!-- start hero-header -->
            <div class="hero" style="background-image:url('img/buddhist-matrimony.jpg');">

                <div class="container">

                    <div class="">
                        <!-- Hero heading -->
                        <!--<h1>Samyakmatrimony</h1>-->
                        <!-- Hero subheading -->
                        <p>India's No. 1 Exclusive Buddhist Matrimony</p>
                    </div>
                    <div class="main-search-wrapper">
                        <div class="inner animated">
                            <form class="row gap-20" method="post" enctype="" action="search_result"
                                  id="search_form">

                                <div class="col-xss-12 col-xs-12 col-sm-12 col-md-2">

                                    <div class="typeahead-container form-group form-icon-right">

                                        <label class="destination-search-3">Looking For</label>

                                        <div class="typeahead-field">
                                            <select name="gender" class="form-control">
                                                <?php
                                                if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Groom') { ?>
                                                    <option value="Bride" selected>Female</option>
                                                <?php } else if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Bride') { ?>
                                                    <option value="Groom">Male</option>
                                                <?php } else { ?>
                                                    <option value="Bride" selected>Female</option>
                                                    <option value="Groom">Male</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xss-12 col-xs-12 col-sm-3 col-md-3">
                                    <div class="row gap-10">
                                        <div class="col-xss-6 col-xs-6 col-sm-6">
                                            <div class="form-group form-icon-right">
                                                <label for="dpd1">Age</label>
                                                <select name="frm_age" class="form-control">
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
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                    <option value="51">51</option>
                                                    <option value="52">52</option>
                                                    <option value="53">53</option>
                                                    <option value="54">54</option>
                                                    <option value="55">55</option>
                                                    <option value="56">56</option>
                                                    <option value="57">57</option>
                                                    <option value="58">58</option>
                                                    <option value="59">59</option>
                                                    <option value="60">60</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xss-6 col-xs-6 col-sm-6">
                                            <div class="form-group form-icon-right">
                                                <label for="dpd2">To</label>
                                                <select name="to_age" class="form-control">
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
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38" selected>38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                    <option value="51">51</option>
                                                    <option value="52">52</option>
                                                    <option value="53">53</option>
                                                    <option value="54">54</option>
                                                    <option value="55">55</option>
                                                    <option value="56">56</option>
                                                    <option value="57">57</option>
                                                    <option value="58">58</option>
                                                    <option value="59">59</option>
                                                    <option value="60">60</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xss-12 col-xs-12 col-sm-6 col-md-3">
                                    <div class="row gap-10">
                                        <div class="col-xss-6 col-xs-6 col-sm-6">

                                            <div class="form-group form-spin-group">
                                                <label for="room-amount">Of Religion</label>
                                                <select name="religion[]" class="form-control">
                                                    <option value="">Any</option>
                                                    <?php

                                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                        ?>
                                                        <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-xss-6 col-xs-6 col-sm-6">
                                            <label for="adult-amount">Marital Status </label>
                                            <select class="form-control" name="m_status" id="m_status">
                                                <option value="">All Status</option>
                                                <option value="Unmarried" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Unmarried') {
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
                                </div>

                                <div class="col-xss-12 col-xs-12 col-sm-6 col-md-2">

                                    <div class="row gap-10">
                                        <div class="col-xss-12 col-xs-12 col-sm-12">
                                            <label for="child-amount">Education</label>
                                            <select class="form-control" name="education_field[]" id="education_field"
                                                    data-placeholder="Select Your Education">
                                                <option value="">Any Education</option>
                                                <?php
                                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");

                                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                                    ?>
                                                    <option value="<?php echo $DatabaseCo->dbRow->e_field_id ?>">
                                                        <?php echo $DatabaseCo->dbRow->e_field_name ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <input id="photo_checkbox" name="photo_search" class="checkbox"
                                               value="Yes" type="hidden">
                                        <!--<div class="col-xss-4 col-xs-4 col-sm-3">
                                            <div class="checkbox-block font-icon-checkbox">
                                                <input id="photo_checkbox" name="photo_search" class="checkbox"
                                                       value="Yes" type="checkbox" checked>
                                                <label class="" for="photo_checkbox">With Photo</label>
                                            </div>
                                        </div>-->
                                    </div>

                                </div>

                                <div class="col-xs-12 col-xss-12 col-sm-12 col-md-2 mt-30">
                                    <button class="btn btn-block btn-danger btn-md btn-icon">Search <span
                                                class="icon"><i
                                                    class="fa fa-search"></i></span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end hero-header -->

            <div class="clear"></div>

            <div class="post-hero">

                <div class="container mb-5">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                            <div class="section-title" style="margin-bottom: 20px;">
                                <h5 class="btn btn-danger">Benefits of Membership</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-4">

                            <div class="featured-item-03 clearfix">

                                <div class="icon">
                                    <i class="et-line-mobile"></i>
                                </div>

                                <div class="content">

                                    <h5>View Contact</h5>
                                    <p>View contact number and reach via phone</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="featured-item-03 clearfix">

                                <div class="icon">
                                    <i class="et-line-envelope"></i>
                                </div>

                                <div class="content">

                                    <h5>Connect </h5>
                                    <p>Send personal message of your selected profile</p>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="featured-item-03 clearfix">

                                <div class="icon">
                                    <i class="et-line-chat"></i>
                                </div>

                                <div class="content">

                                    <h5>Interact </h5>
                                    <p>Chat instantly with all other online users</p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="clear"></div>

            <div class="bg-white">

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
                                <h5>Featured Members</h5>
                            </div>
                        </div>
                    </div>
                    <?php if ($genderToSearch == "") { ?>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <div class="btn-filter-wrap">
                                    <button class="btn-filter" data-filter=".grid-groom">Buddhist Groom</button>
                                    <button id="activeBrideFilter" class="btn-filter" data-filter=".grid-bride">Buddhist Bride</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="top-hotel-grid-wrapper">
                        <div class="GridLex-gap-20-wrapper">
                            <div class="GridLex-grid-noGutter-equalHeight GridLex-grid-center owl-carousel">
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

            <div class="clear"></div>

<!--            Start of HomePage Tags-->

            <div class="home_tags">
                <div class="main-footer" style="padding-top: 0px;">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 col-xss-12 col-xs-12">
                                <h1 class="head_tag_matrimony text-center mb-20 font15">Buddhist Matrimony Brides and Grooms Profiles By</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">

                                    <div class="col-xs-4">

                                        <h4 class="footer-title1">Education</h4>

                                        <ul class="menu-footer1">
                                            <li><a title="Browse By Buddhist ..." href="#"> Commerce</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">Engineer</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Computers</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Need Help ?</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">Sitemap</a></li>
                                        </ul>

                                    </div>

                                    <div class="col-xs-4">

                                        <h4 class="footer-title1">City</h4>

                                        <ul class="menu-footer1">
                                            <li><a title="Browse By Buddhist ..." href="#"> Mumbai</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">Pune</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Akola</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Ahemednagar</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">Sitemap</a></li>
                                        </ul>

                                    </div>

                                    <div class="col-xs-4">

                                        <h4 class="footer-title1">Country</h4>

                                        <ul class="menu-footer1">
                                            <li><a title="Browse By Buddhist ..." href="#"> USA</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">Canada</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Belgium</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#"> Dubai</a></li> |
                                            <li><a title="Browse By Buddhist ..." href="#">London</a></li>
                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

<!--            End of HomePage Tags-->


            <div class="clear"></div>

            <div class="bg-primary newsletter-wrapper" style="padding-top: 15px;padding-bottom: 0px;">

                <div class="container">

                    <div class="GridLex-grid-middle">

                        <div class="GridLex-col-10_sm-12_xs-12 pt-0 pb-0">
                            <div class="text-holder">
                                <p style="font-family:inherit;font-style: normal;text-align: justify;">More than 1 lakhs Buddhist profiles are registered at MatrimonialsIndia.Com.
                                    Majority of these profiles belong to Mumbai, Nagpur, Pune etc.
                                    There are many Buddhist profiles on this portal that are Marathi,
                                    Sinhala, Hindi etc speaking. You can also browse through Buddhist profiles
                                    with professions like Business / Consultant, Engineer, Non-Working etc. for your Buddhist matrimonial.</p>
                            </div>
                        </div>

                        <div class="GridLex-col-2_sm-12_xs-12 pt-0 pb-0 text-right">
                            <a href="https://play.google.com/store/apps/details?id=com.www.samyakmatrimony">
                                <img style="width:140px; margin: 0px auto;"
                                            class="img img-responsive mb-20"
                                            src="img/playstore-v2.png"></a>
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

    </div> <!-- / .wrapper -->
    <!-- end Container Wrapper -->

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

<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery.owl-filter.js?v=1.0"></script>
<script>
    $(function () {
        $.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");


        var owl = $('.owl-carousel').owlCarousel({
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

        /* animate filter */
        var owlAnimateFilter = function (even) {
            $(this)
                .addClass('__loading')
                .delay(70 * $(this).parent().index())
                .queue(function () {
                    $(this).dequeue().removeClass('__loading')
                })
        }

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
    })
</script>
<!-- Custom js codes for plugins -->
<script type="text/javascript" src="js/customs.js"></script>
</body>




<small class="pull-right"><?php
    if (isset($_SESSION['user_id'])) {
        $sql = "select DISTINCT p.* from payment_view p where p.pmatri_id='" . $_SESSION['user_id'] . "' and p_plan!='Free'";
        $result = $DatabaseCo->dbLink->query($sql);
        if ($result->num_rows > 0) {
            while ($DatabaseCo->dbRow = mysqli_fetch_object($result)) {
                include_once "chat.php";
                ?>
                <link rel="stylesheet" type="text/css" href="who-is-online/widget.css"/>
                <script type="text/javascript" src="who-is-online/widget.js"></script>


                <div class="onlineWidget">
                    <div class="channel">
                        <img class="preloader" src="who-is-online/img/preloader.gif" alt="Loading.." width="22"
                             height="22"/>
                    </div>
                    <div class="count" id="count"></div>
                    <div class="label">online member</div>

                    <div class="arrow"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</small>
</html>