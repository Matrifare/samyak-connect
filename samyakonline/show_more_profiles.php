<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/1/2018
 * Time: 1:28 AM
 */

include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();

$type = $_GET['type'] ?? "";
$limit = 12;
$page = $_GET['page'] ?? 1;
$adjacent = 2;
if ($page == 1) {
    $start = 0;
} else {
    $start = ($page - 1) * $limit;
}
if ($type == 'recent_premium') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND p.p_plan!='Free' AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "')"));

    $sql = "select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND p.p_plan !='Free' AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY pactive_dt DESC limit $start, $limit";
    $text = 'Recently Joined Premium Members';
} else if ($type == 'recent') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select pmatri_id from payments where p_plan !='Free') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "')"));

    $sql = "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select pmatri_id from payments where p_plan !='Free') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit $start, $limit";
    $text = 'Recently Joined Members';
} else if ($type == 'bookmark') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id where r.status!= 'Inactive' and fb_id!='2' and r.status!='Suspended' and r.photo1 != '' and photo1_approve='APPROVED' and matri_id IN (select to_id from shortlist where from_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "')"));

    $sql = "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.status!= 'Inactive' and fb_id!='2' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' and matri_id IN (select to_id from shortlist where from_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit $start, $limit";
    $text = 'My Bookmarked Profiles';
} else if ($type == 'viewed') {

    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select viewed_member_id from `who_viewed_my_profile` where  my_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC"));

    $sql = "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select viewed_member_id from `who_viewed_my_profile` where  my_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit $start, $limit";
    $text = 'Profiles visited by Me';
} else if ($type == 'visitor') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id 
where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select my_id from who_viewed_my_profile where viewed_member_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC"));

    $sql = "select DISTINCT r.*, v.viewed_date,p.* from register_view r INNER JOIN who_viewed_my_profile v ON r.matri_id=v.my_id
INNER JOIN payment_view p ON r.matri_id = p.pmatri_id
           where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive'
     and r.status!='Suspended' and r.photo1 != '' and r.photo1_approve='APPROVED' AND v.viewed_member_id='" . $_SESSION['user_id'] . "'
      AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "')
       ORDER BY v.viewed_date DESC limit $start, $limit";

    $text = 'My Visitors Profiles';
} else if ($type == 'block') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT * from register_view r 
            INNER JOIN payment_view p ON r.matri_id=p.pmatri_id 
            JOIN block_profile ON block_profile.block_to=r.matri_id where block_profile.block_by='" . $_SESSION['user_id'] . "' and r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and r.photo1 != '' and r.photo1_approve='APPROVED'"));

    $sql = "SELECT DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id JOIN 
block_profile ON block_profile.block_to=r.matri_id where block_profile.block_by='" . $_SESSION['user_id'] . "' 
and r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and r.photo1 != '' and r.photo1_approve='APPROVED' ORDER BY block_date DESC limit $start, $limit";
    $text = 'My Blocklisted Profiles';
} else if ($type == 'viewed_contacts') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT register_view.index_id FROM contact_checker INNER JOIN register_view ON contact_checker.viewed_id=register_view.matri_id
 INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where contact_checker.my_id='" . $_SESSION['user_id'] . "' and fb_id!='2' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'"));

    $sql = "SELECT DISTINCT * FROM contact_checker INNER JOIN register_view ON contact_checker.viewed_id=register_view.matri_id
 INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where contact_checker.my_id='" . $_SESSION['user_id'] . "' and fb_id!='2' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED' ORDER BY contact_checker.date DESC limit $start, $limit";

    $text = 'My Viewed Profiles Contact';
} else if ($type == 'viewed_my_contact') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT register_view.index_id FROM contact_checker INNER JOIN register_view ON contact_checker.my_id=register_view.matri_id
 where contact_checker.viewed_id='" . $_SESSION['user_id'] . "' and fb_id!='2' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'"));

    $sql = "select DISTINCT * from register_view INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where matri_id IN (SELECT DISTINCT contact_checker.my_id FROM contact_checker INNER JOIN register_view ON contact_checker.my_id=register_view.matri_id where contact_checker.viewed_id='" . $_SESSION['user_id'] . "' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED' ORDER BY contact_checker.date DESC) and fb_id!='2' limit $start, $limit";
    $text = 'Profiles Who Viewed My Contact';
} else {
    $text = 'Recently Joined Premium Members';
}

$data = $DatabaseCo->dbLink->query($sql);

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

<?php @include_once 'page-parts/modal.php' ?>
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
                            <li><a href="#">View Profiles</a></li>
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

        <div class="equal-content-sidebar-by-gridLex">

            <div class="container">

                <div class="GridLex-grid-noGutter-equalHeight">

                    <div class="GridLex-col-3_sm-4_xs-12_xss-12 hidden-xs hidden-xss">

                        <?php @include_once 'layouts/sidebar.php' ?>

                    </div>

                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">

                        <div class="content-wrapper">

                            <div class="row">

                                <div class="col-xs-12 text-center">

                                    <h4 class="text-center hidden-xs hidden-xss"
                                        style="font-size:14px;text-transform: capitalize;"
                                        id="current_heading"><span
                                                class="btn btn-primary btn-shrink btn-sm mb-20"><?= $text ?></span>
                                        <?php
                                        if ($type != 'recent_premium') {
                                            ?>
                                            -
                                            <span class="btn btn-shrink btn-sm mb-20"
                                                  style="background-color: #DC0D3B !important; color: #fff;"><?= $rows ?></span>
                                        <?php } ?>
                                    </h4>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-xs-12">

                                    <?php

                                    if ($rows > 0) {
                                    if ($_SESSION['membership'] != 'Free' ||
                                    ($_SESSION['membership'] == 'Free' && $type != 'visitor' && $type != 'viewed_my_contact')) {
                                    pagination($limit, $adjacent, $rows, $page, $type);
                                    $colCount = 1;
                                    $rowCount = 1;
                                    $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                                    if ($viewType == 'icon_view') {
                                        echo "<div class='row mb-10'>";
                                    }
                                    while ($Row = mysqli_fetch_object($data)) {
                                    if ($colCount > 4) { ?>
                                </div>
                                <div class='row mb-10'>
                                    <?php }
                                    include "page-parts/samyak-grid-results-home.php";
                                    if ($rowCount % 2 == 0) { ?>
                                        <div class="clearfix visible-xs"></div>
                                    <?php }
                                    if ($colCount > 4) {
                                        $colCount = 1;
                                    }
                                    $colCount++;
                                    $rowCount++;
                                    }
                                    echo '</div>';
                                    pagination($limit, $adjacent, $rows, $page, $type);
                                    } else { ?>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <h4>Please upgrade your membership to access this feature.</h4>
                                                <a href="premium_member" class="btn btn-danger btn-sm">Upgrade Membership</a>
                                            </div>
                                        </div>
                                    <?php }
                                    } else {
                                        ?>
                                        <div class="mb-95">
                                            <div class="thumbnail">
                                                <img src="img/nodata-available.jpg">
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    function pagination($limit, $adjacents, $rows, $page, $type)
                                    {
                                        $pagination = '';
                                        if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
                                        $prev = $page - 1;                            //previous page is page - 1
                                        $next = $page + 1;                            //next page is page + 1
                                        $prev_ = '';
                                        $first = '';
                                        $lastpage = ceil($rows / $limit);
                                        $next_ = '';
                                        $last = '';
                                        $isLoggedIn = false;
                                        if (!empty($_SESSION['user_name']) && !empty($_SESSION['user_id'])) {
                                            $isLoggedIn = true;
                                        }
                                        if ($lastpage > 1) {

                                            if ($page > 1)
                                                $prev_ .= "<li><a href=\"?type=$type&page=$prev\">&laquo;</a></li>";
                                            else {
                                                //$pagination.= "<span class=\"disabled\">previous</span>";
                                            }

                                            //pages
                                            if ($lastpage < 5 + ($adjacents * 2))    //not enough pages to bother breaking it up
                                            {
                                                $first = '';
                                                for ($counter = 1; $counter <= $lastpage; $counter++) {
                                                    if ($counter == $page) {
                                                        $pagination .= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                                                    } else {
                                                        if ($isLoggedIn) {
                                                            $pagination .= "<li><a class='page-numbers' href=\"?type=$type&page=$counter\">$counter</a></li>";
                                                        } else {
                                                            $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                                                        }
                                                    }
                                                }
                                                $last = '';
                                            } elseif ($lastpage > 3 + ($adjacents * 2))    //enough pages to hide some
                                            {
                                                //close to beginning; only hide later pages
                                                $first = '';
                                                if ($page < 1 + ($adjacents * 2)) {
                                                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                        if ($counter == $page) {
                                                            $pagination .= "<li class=\"active \"><a href=\"#\">$counter</a></li>";
                                                        } else {
                                                            if ($isLoggedIn) {
                                                                $pagination .= "<li><a class='page-numbers' href=\"?type=$type&page=$counter\">$counter</a></li>";
                                                            } else {
                                                                $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                                                            }
                                                        }
                                                    }
                                                    $last .= "<li><a class='page-numbers' href=\"?type=$type&page=$lastpage\">Last</a></li>";
                                                } //in middle; hide some front and some back
                                                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                                    $first .= "<li><a class='page-numbers' href=\"?type=$type&page=1\">First</a></li>";
                                                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                        if ($counter == $page) {
                                                            $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                                                        } else {
                                                            if ($isLoggedIn) {
                                                                $pagination .= "<li><a class='page-numbers' href=\"?type=$type&page=$counter\">$counter</a></li>";
                                                            } else {
                                                                $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                                                            }
                                                        }
                                                    }
                                                    if ($isLoggedIn) {
                                                        $last .= "<li><a class='page-numbers' href=\"?type=$type&page=$lastpage\">Last</a></li>";
                                                    } else {
                                                        $last .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">Last</a></li>";
                                                    }
                                                } //close to end; only hide early pages
                                                else {
                                                    $first .= "<li><a class='page-numbers' href=\"?type=$type&page=1\">First</a></li>";
                                                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                                        if ($counter == $page) {
                                                            $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                                                        } else {
                                                            if ($isLoggedIn) {
                                                                $pagination .= "<li><a class='page-numbers' href=\"?type=$type&page=$counter\">$counter</a></li>";
                                                            } else {
                                                                $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                                                            }
                                                        }
                                                    }
                                                    $last = '';
                                                }

                                            }
                                            if ($page < $counter - 1) {
                                                if ($isLoggedIn) {
                                                    $next_ .= "<li><a class='page-numbers' href=\"?type=$type&page=$next\">&raquo;</a></li>";
                                                } else {
                                                    $next_ .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">&raquo;</a></li>";
                                                }
                                            } else {
                                                //$pagination.= "<span class=\"disabled\">next</span>";
                                            }
                                            $pagination = "<div class=\"result-paging-wrapper mb-10\"><div class=\"row\"><div class=\"col-sm-offset-6 col-sm-6\">
                    <ul class=\"paging\">
		"
                                                . $first . $prev_ . $pagination . $next_ . $last;
                                            //next button

                                            $pagination .= "</ul></div></div></div>\n";
                                        }

                                        echo $pagination;
                                    }

                                    ?>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="clear"></div>

        <?php @include_once 'layouts/footer.php' ?>

    </div>

</div>

<!-- start Back To Top -->
<div id="back-to-top">
    <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->


<!-- jQuery Cores -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="js/customs.js"></script>
<script type="text/javascript" src="js/express_interest.js"></script>

<script type="text/javascript" src="js/select2.min.js"></script>
<script>
    /**
     * Select 2
     */
    $(function () {

        $(".chosen-select").css('width', '100%');
        $("ul > li > input").css('width', '100%');
        $('.chosen-select').select2();
    })


    function ExpressInterest(toid, name) {
        $("#sendExpressInterestModal").modal("show");
        $.post("web-services/search_send_interest", "frmid=" + toid + "&name=" + name,
            function (data) {
                $("#expressInterestContentModal").html(data);
            });
    }
</script>
</body>


</html>
