<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 05/02/2021
 * Time: 09:45 PM
 */
$showId = $RowPremiumMembers->matri_id;
$redirectUrl = "view_profile?userId=" . $RowPremiumMembers->matri_id;
$title = "View Profile";
$target = "_blank";
?>

<div class="destination-grid-sm-item text-center" style="min-height: 330px;background-color: #fff;">
    <div class="image">
        <a href="<?= $redirectUrl ?>" title="<?= $title ?>" target="<?= $target ?>">
            <?php
            $isPhotoAvailable = "photos/" . trim($RowPremiumMembers->photo1);
            $photo = trim("photos/watermark?image=" . rtrim($RowPremiumMembers->photo1, ' 1') . "&watermark=watermark.png");
            if (!empty(trim($RowPremiumMembers->photo1)) && file_exists($isPhotoAvailable) &&
                !empty(trim($RowPremiumMembers->photo_protect) && trim($RowPremiumMembers->photo_protect == 'No'))) { ?>
                <img src="<?= $photo ?>"
                     title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
            <?php } else if (!empty(trim($RowPremiumMembers->photo2)) && file_exists("photos/" . trim($RowPremiumMembers->photo2)) &&
                !empty(trim($RowPremiumMembers->photo_protect) && trim($RowPremiumMembers->photo_protect == 'No'))) { ?>
                <img src="<?= trim("photos/watermark?image=" . rtrim($RowPremiumMembers->photo2, ' 1') . "&watermark=watermark.png") ?>"
                     title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
            <?php } else if (!empty(trim($RowPremiumMembers->photo3)) && file_exists("photos/" . trim($RowPremiumMembers->photo3)) &&
                !empty(trim($RowPremiumMembers->photo_protect) && trim($RowPremiumMembers->photo_protect == 'No'))) { ?>
                <img src="<?= trim("photos/watermark?image=" . rtrim($RowPremiumMembers->photo3, ' 1') . "&watermark=watermark.png") ?>"
                     title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
            <?php } else if (!empty(trim($RowPremiumMembers->photo4)) && file_exists("photos/" . trim($RowPremiumMembers->photo4)) &&
                !empty(trim($RowPremiumMembers->photo_protect) && trim($RowPremiumMembers->photo_protect == 'No'))) { ?>
                <img src="<?= trim("photos/watermark?image=" . rtrim($RowPremiumMembers->photo4, ' 1') . "&watermark=watermark.png") ?>"
                     title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
            <?php } else {
                if ($RowPremiumMembers->gender == 'Groom') {
                    if ($RowPremiumMembers->photo_protect == 'Yes') {
                        $showPhoto = "img/default-photo/photo-protected-male100.png";
                    } else {
                        $showPhoto = "img/default-photo/male-200.png";
                    }
                    ?>
                    <img src="<?= $showPhoto ?>" class="img img-responsive"
                         style="margin-left: 14%; width: 78%;"
                         title="<?php echo $RowPremiumMembers->matri_id; ?>" alt="<?php echo $RowPremiumMembers->matri_id; ?>">
                <?php } else {
                    if ($RowPremiumMembers->photo_protect == 'Yes') {
                        $showPhoto = "img/default-photo/photo-protected-female.png";
                    } else {
                        $showPhoto = "img/default-photo/female-200.png";
                    } ?>
                    <img src="<?= $showPhoto ?>" class="img img-responsive"
                         style="margin-left: 14%; width: 78%;"
                         title="<?php echo $RowPremiumMembers->matri_id; ?>" alt="<?php echo $RowPremiumMembers->matri_id; ?>">
                <?php }
            } ?>
        </a>
    </div>
    <div class="content text-darker" style="font-size: 13px;">
        <?php $ao31 = $RowPremiumMembers->height;
        $ft31 = (int)($ao31 / 12);
        $inch31 = $ao31 % 12; ?>
        <a title="<?= $title ?>" href="<?= $redirectUrl ?>" target="<?= $target ?>">
            <h6 style="font-size: 14px;"><?php echo $RowPremiumMembers->matri_id; ?> - <?php echo $RowPremiumMembers->firstname; ?></h6>
        </a>
        <?= floor((time() - strtotime($RowPremiumMembers->birthdate)) / 31556926) . ' Yrs, '; ?>
        <?= $ft31 . "'" . $inch31 . '", '; ?>
        <?= $RowPremiumMembers->religion_name . (($RowPremiumMembers->religion_name == 'Buddhist') ? "" : " - " . $RowPremiumMembers->caste_name) ?>,
        <?php
        $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $RowPremiumMembers->matri_id . "'  GROUP BY a.edu_detail"));
        echo $known_education['my_education'] . ", "; ?>
        <?= $RowPremiumMembers->ocp_name ?> from <?= $RowPremiumMembers->city_name ?>
        <br/>
        <p style="position: absolute;bottom: 20px;left: 28%;"><label class="label label-primary"
             style="font-weight:normal;text-transform: capitalize;float: none; padding: 4px 8px;color: #fff;border-radius: 4px;cursor: pointer;"
             onclick="ExpressInterest('<?= $RowPremiumMembers->matri_id; ?>', '<?= $RowPremiumMembers->firstname ?>')"
            ><i class="fa fa-paper-plane-o"></i> Connect Now</label>
        </p>
    </div>

</div>
