<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/14/2018
 * Time: 1:49 PM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
$configObj = new Config();
$webfriendlyname = $configObj->getConfigFname();
$website = $configObj->getConfigName();
include_once '../page-parts/pagination.php';
$con = '';
$limit = '';
$adjacent = '';
if (isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction'] != '') {
    $actionfunction = $_REQUEST['actionfunction'];
    call_user_func($actionfunction, $_REQUEST, $con, $limit, $adjacent);
}
function showData($data, $con, $limit, $adjacent)
{
$limit = 8;
$adjacent = 4;
$page = $_POST['page'];
$DatabaseCo = new DatabaseConnection();
if ($page == 1) {
    $start = 0;
} else {
    $start = ($page - 1) * $limit;
}

//$get_st=$DatabaseCo->dbLink->query("select weddingphoto,successmessage,bridename,groomname from success_story where weddingphoto_type='photo' order by rand() limit $start,$limit");
$sql = "select weddingphoto,successmessage,bridename,groomname from success_story where weddingphoto_type='photo' and status='APPROVED'";
$rows = $DatabaseCo->dbLink->query($sql);
$rows = mysqli_num_rows($rows);
$sql = "select weddingphoto,successmessage,bridename,groomname from success_story where weddingphoto_type='photo' and status='APPROVED' order by story_id DESC limit $start,$limit";
$data = $DatabaseCo->dbLink->query($sql);

if (mysqli_num_rows($data) > 0) { ?>
<div class="top-hotel-grid-wrapper">
    <div class="row gap-20 min-height-alt">
        <?php
        while ($get_st_photo = mysqli_fetch_object($data)) { ?>
            <div class="col-xss-12 col-xs-12 col-sm-6 col-mdd-6 col-md-3" data-match-height="result-grid">
                <div class="hotel-item-grid" style="min-height: auto !important;">
                    <a href="#">
                        <div class="image">
                            <img src="SuccessStory/<?= $get_st_photo->weddingphoto ?>" class="img-responsive" alt="Top Destinations">
                        </div>
                        <div class="heading">
                            <div class="raty-wrapper mb-5">
                                <div class="star-rating-12px" data-rating-score="4"></div>
                            </div>
                            <h6 class="text-center" style="margin: 0px !important;"><?= ucfirst($get_st_photo->bridename) . " with " . ucfirst($get_st_photo->groomname) ?></h6>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
        } else { ?>
            <div class="xxl-16 xl-16 s-16 m-16 l-16 center-text padding-lr-zero-320 padding-lr-zero-480">
                <h4 class="xxl-16 xl-16 xs-16 box-shadow-light margin-bottom-0px border-radius-top-5px padding-top-10px padding-bottom-10px border-1px-light-grey font-light-grey bg-offwhite">
                    <img src="img/nodata.jpg" alt="User Image" class="img-responsive" border="1"/>
                </h4>
            </div>
            <?php
        }
        ?>
        <div class="col-xs-12 mb-20">
            <?php pagination($limit, $adjacent, $rows, $page); ?>
        </div>
<?php } ?>
