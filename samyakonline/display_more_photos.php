<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/4/2018
 * Time: 12:46 AM
 */

require_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();

$mid = $_SESSION['user_id'];

$Row = mysqli_fetch_object($DatabaseCo->dbLink->query("select matri_id,photo_view_status,photo1,photo2,photo3,photo4,
photo5,photo6,photo7,photo8,gender from register_view where matri_id='" . $mid . "'"));

?>

<div class="row mb-10">
    <div class="col-xs-12">
        <p>
            <strong> Facing issue Photo upload Email us or WhatsApp US <i class="fa fa-whatsapp"></i> <a style="font-weight: bold;" href="https://api.whatsapp.com/send?phone=919819886759&text=Please Upload my Photo">Click Here</a>
        </p>
    </div>
</div>

<div class='row mb-10'>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a title="" href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo1)."&watermark=watermark.png";
                if (!empty(trim($Row->photo1)) && file_exists('../photos/' . $Row->photo1)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo1" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo1"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo1"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo1" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button type="button"
                        class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo1 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo1" onclick="deletePhoto(this);" id="delete_photo1">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo2)."&watermark=watermark.png";
                if (!empty(trim($Row->photo2)) && file_exists('../photos/' . $Row->photo2)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo2" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo2"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo2"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo2" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm  <?= ($Row->photo2 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo2" onclick="deletePhoto(this);" id="delete_photo2">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo3)."&watermark=watermark.png";
                if (!empty(trim($Row->photo3)) && file_exists('../photos/' . $Row->photo3)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo3" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo3"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo3"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo3" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo3 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo3" onclick="deletePhoto(this);" id="delete_photo3">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo4)."&watermark=watermark.png";
                if (!empty(trim($Row->photo4)) && file_exists('../photos/' . $Row->photo4)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo4" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo4"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo4"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo4" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo4 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo4" onclick="deletePhoto(this);" id="delete_photo4">
                    Delete
                </button>
            </div>

        </a>
    </div>
</div>
<div class='row mb-10'>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo5)."&watermark=watermark.png";
                if (!empty(trim($Row->photo5)) && file_exists('../photos/' . $Row->photo5)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo5" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo5"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo5"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo5" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo5 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo5" onclick="deletePhoto(this);" id="delete_photo5">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo6)."&watermark=watermark.png";
                if (!empty(trim($Row->photo6)) && file_exists('../photos/' . $Row->photo6)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo6" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo6"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo6"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo6" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo6 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo6" onclick="deletePhoto(this);" id="delete_photo6">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo7)."&watermark=watermark.png";
                if (!empty(trim($Row->photo7)) && file_exists('../photos/' . $Row->photo7)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo7" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo7"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo7"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo7" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo7 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo7" onclick="deletePhoto(this);" id="delete_photo7">
                    Delete
                </button>
            </div>

        </a>
    </div>
    <div class="col-sm-3 col-xs-6 mb-10 pr-4">
        <a href="javascript:void(0);" class="destination-grid-sm-item"
           onclick="">
            <div class="image">
                <?php
                $isPhotoAvailable = "watermark?image=photos/" . trim($Row->photo8)."&watermark=watermark.png";
                if (!empty(trim($Row->photo8)) && file_exists('../photos/' . $Row->photo8)) { ?>
                    <img src="<?= $isPhotoAvailable ?>" id="photo8" style="height: 100%; width:100%;"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>" onclick="showPhoto('<?= $isPhotoAvailable ?>');">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        ?>
                        <img src="img/default-photo/male-200.png" class="img img-responsive" id="photo8"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else { ?>
                        <img src="img/default-photo/female-200.png" class="img img-responsive" id="photo8"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
            </div>

            <div class="content text-darker">
                <button type="button" class="btn btn-sm btn-shrink btn-sm btn-danger" title="Update Photo"
                        data-image="photo8" onclick="uploadPhoto(this);">
                    Edit
                </button>
                <button class="btn btn-sm btn-shrink btn-sm <?= ($Row->photo8 != '') ? "visible" : "hidden" ?>"
                        title="Delete Photo" data-image="photo8" onclick="deletePhoto(this);" id="delete_photo8">
                    Delete
                </button>
            </div>

        </a>
    </div>
</div>



