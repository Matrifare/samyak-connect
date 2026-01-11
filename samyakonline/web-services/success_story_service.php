<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/14/2018
 * Time: 1:49 PM
 */
include_once '../DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
$configObj = new Config();
$limit = $_POST['limit'] ?? 16;
$page = $_POST['page'] ?? 1;
if ($page == 1) {
    $start = 0;
} else {
    $start = ($page - 1) * $limit;
}
if(!empty($_POST['limit'])) {
    $_SESSION['result_limit'] = mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['limit']);
}
$limit = !empty($_SESSION['result_limit']) ? $_SESSION['result_limit'] : 18;

/*$sql = "select weddingphoto,successmessage,bridename,groomname from success_story where weddingphoto_type='photo' and status='APPROVED'";
$rows = $DatabaseCo->dbLink->query($sql);
$rows = mysqli_num_rows($rows);*/
$sql = "select weddingphoto,successmessage,bridename,groomname from success_story where weddingphoto_type='photo' and status='APPROVED' order by story_id DESC limit $start,$limit";
$data = $DatabaseCo->dbLink->query($sql);
if (mysqli_num_rows($data) > 0) {
    while ($get_st_photo = mysqli_fetch_object($data)) { ?>
        <div class="col-sm-4">
            <div class="img_wrapper_gallery">
                <div class="img_container_gallery">
                    <a href="https://samyakmatrimony.com/SuccessStory/<?= $get_st_photo->weddingphoto ?>"
                       title="<?= ucfirst($get_st_photo->bridename) . " with " . ucfirst($get_st_photo->groomname) ?>"
                       data-effect="mfp-zoom-in">
                        <img src="https://samyakmatrimony.com/SuccessStory/<?= $get_st_photo->weddingphoto ?>"
                             alt="<?= ucfirst($get_st_photo->bridename) . " with " . ucfirst($get_st_photo->groomname) ?>"
                             class="img-fluid">
                        <i class="icon-resize-full-2"></i>
                    </a>
                    <h6 class="text-center"
                        style="margin: 0px !important;"><?= ucfirst($get_st_photo->bridename) . " with " . ucfirst($get_st_photo->groomname) ?></h6>
                </div>
            </div>
        </div>
        <?php
    }
} else { ?>
    <div class="col-sm-12">
        <h4 class="text-center">No Success Story Found.</h4>
    </div>
<?php }
