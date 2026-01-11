<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 28-11-2018
 * Time: 12:40 AM
 */

include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
include_once 'auth.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
$recenlty = $DatabaseCo->dbLink->query("select DISTINCT * from register_view r JOIN payment_view p ON r.matri_id = p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select pmatri_id from payments where p_plan !='Free') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit 0,8 ");

$recentPremium = $DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select pmatri_id from payments where p_plan NOT IN ('Free', 'Classic', 'Classic Plus', 'Special', 'Standard', 'Trial')) AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') AND p_plan != 'Free' ORDER BY pactive_dt DESC limit 0,8 ");

$bookmarked = $DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.status!= 'Inactive' and fb_id!='2' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' and matri_id IN (select to_id from shortlist where from_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit 0,8");

$contactsViewed = $DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select viewed_id from contact_checker where  my_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit 0,8 ");

$sqlVisitor = "select DISTINCT * from register_view r INNER JOIN who_viewed_my_profile v ON r.matri_id=v.my_id
INNER JOIN payment_view p ON r.matri_id = p.pmatri_id
where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != ''
 and photo1_approve='APPROVED' AND viewed_member_id='" . $_SESSION['user_id'] . "' AND matri_id NOT IN
  (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY v.viewed_date DESC limit 0,8";

$myProfileViewed = $DatabaseCo->dbLink->query($sqlVisitor);
$rowsVisitor = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id
where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and 
photo1_approve='APPROVED' AND matri_id IN (select my_id from who_viewed_my_profile where viewed_member_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC"));

$viewedMyContacts = $DatabaseCo->dbLink->query("select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id 
where r.gender!='" . $_SESSION['gender123'] . "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select my_id from contact_checker where viewed_id='" . $_SESSION['user_id'] . "') AND matri_id NOT IN (select block_to from block_profile where block_by='" . $_SESSION['user_id'] . "') ORDER BY r.index_id DESC limit 0,8 ");
$rowsViewedMyContacts = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT register_view.index_id FROM contact_checker INNER JOIN register_view ON contact_checker.my_id=register_view.matri_id
 INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where contact_checker.viewed_id='" . $_SESSION['user_id'] . "' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED'"));
?>
<div class="col-xs-12">

    <div class="tab-style-01-wrapper">

        <ul id="detailTab" class="tab-nav clearfix">
            <li class="active"><a href="#tab_1-01" data-toggle="tab"
                                  onclick="change_heading('Recently');">Recent Premium
                    <!--<i class="fa fa-folder-open-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
            <li class=""><a href="#tab_1-06" data-toggle="tab"
                            onclick="change_heading('Recent');">New Members
                    <!--<i class="fa fa-folder-open-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
            <li class="hidden-xs hidden-xss"><a href="#tab_1-02" data-toggle="tab"
                                                onclick="change_heading('Bookmark');">Bookmarked Profiles
                    <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
            <li class="hidden-xs hidden-xss"><a href="#tab_1-03" data-toggle="tab"
                                                onclick="change_heading('Viewed');">Contacts Viewed Profile
                    <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
            <li><a href="#tab_1-04" data-toggle="tab"
                   onclick="change_heading('Visitor');">Visitor List
                    <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
            <li class="hidden-xs hidden-xss"><a href="#tab_1-05" data-toggle="tab"
                                                onclick="change_heading('Viewed_My_Contacts');">View My Contact
                    <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>
            </li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="tab_1-01" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($recentPremium) > 0) {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($recentPremium)) {
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
                echo '</div>'; ?>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=recent_premium">Show
                            More</a>
                    </div>
                </div>
                <?php } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade" id="tab_1-06" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($recenlty) > 0) {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($recenlty)) {
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
                echo '</div>'; ?>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=recent">Show
                            More</a>
                    </div>
                </div>
                <?php } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade hidden-xs hidden-xss" id="tab_1-02" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($bookmarked) > 0) {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($bookmarked)) {
                if ($colCount > 4) { ?>
            </div>
            <div class='row mb-10 hidden-xs hidden-xss'>
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
                echo '</div>'; ?>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=bookmark">Show
                            More</a>
                    </div>
                </div>
                <?php } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade hidden-xss hidden-xs" id="tab_1-03" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($contactsViewed) > 0) {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($contactsViewed)) {
                if ($colCount > 4) { ?>
            </div>
            <div class='row mb-10 hidden-xss hidden-xs'>
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
                echo '</div>'; ?>
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=viewed">Show
                            More</a>
                    </div>
                </div>
                <?php } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade" id="tab_1-04" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($myProfileViewed) > 0) {
                if ($_SESSION['membership'] != 'Free') {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($myProfileViewed)) {
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
                echo '</div>'; ?>

                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=visitor">Show
                            More</a>
                    </div>
                </div>
                <?php
                } else { ?>
                    <div class="row mt-30">
                        <div class="col-xs-12 text-center">
                            <label class="label label-primary" style="font-weight: normal;"> My Visitors Profile</label>
                            -
                            <label class="label label-danger"  style="font-weight: normal;"> <?= $rowsVisitor ?></label>
                        </div>
                        <div class="col-xs-12 text-center mt-20">
                            <h4>Please upgrade your membership to access this feature.</h4>
                            <a href="premium_member" class="btn btn-danger btn-sm">Upgrade Membership</a>
                        </div>
                    </div>
                <?php }
                } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade" id="tab_1-05" style="padding: 10px;">
                <?php
                if (mysqli_num_rows($viewedMyContacts) > 0) {
                if ($_SESSION['membership'] != 'Free') {
                $colCount = 1;
                $rowCount = 1;
                $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
                if ($viewType == 'icon_view') {
                    echo "<div class='row mb-10'>";
                }
                while ($Row = mysqli_fetch_object($viewedMyContacts)) {
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
                echo '</div>'; ?>

                <div class="row">
                    <div class="col-xs-12 text-right">
                        <a class="link" href="show_more_profiles?type=viewed_my_contact">Show
                            More</a>
                    </div>
                </div>
                <?php } else { ?>
                    <div class="row mt-30">
                        <div class="col-xs-12 text-center">
                            <label class="label label-primary" style="font-weight: normal;"> Who viewed my contact</label>
                            -
                            <label class="label label-danger"  style="font-weight: normal;"> <?= $rowsViewedMyContacts ?></label>
                        </div>
                        <div class="col-xs-12 text-center mt-20">
                            <h4>Please upgrade your membership to access this feature.</h4>
                            <a href="premium_member" class="btn btn-danger btn-sm">Upgrade Membership</a>
                        </div>
                    </div>
                <?php }
                } else {
                    ?>
                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
                        <div class="thumbnail">
                            <img src="img/nodata-available.jpg">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>

</div>
