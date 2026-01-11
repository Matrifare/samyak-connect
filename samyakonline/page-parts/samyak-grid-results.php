<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/15/2018
 * Time: 11:15 PM
 */
if ($colCount == 2){ ?>
<div class="hidden-md hidden-sm hidden-lg">
    <div class="clearfix"></div>
</div>
<?php }
if ($colCount == 4){
$colCount = 0;
?></div>
</div>
<div class="clearfix"></div>
<div class="row mb-10">
    <div class='mb-10'>
        <?php
        }
        $isLoggedIn = false;
        if (!empty($_SESSION['user_name']) && !empty($_SESSION['user_id'])) {
            $isLoggedIn = true;
        }
        if ($colCount % 2 == 0) {
            $style = "padding-right:4px !important;";
        } else {
            $style = "padding-left:4px !important;padding-right:4px !important;";
        }

        $showId = "";
        if (isset($_SESSION['samyak_id_search'])) {
            $showId = $Row->samyak_id;
        } else {
            $showId = $Row->matri_id;
        }
        ?>

        <div class="col-sm-3 col-xs-6 mb-10" style="<?= $style ?>">
            <?php
            if ($isLoggedIn) {
                $redirectUrl = "view_profile?userId=" . $Row->matri_id;
                $title = "View Profile";
                $target = "_blank";
            } else {
                $redirectUrl = "login";
                $title = "Login to view Profile";
                $target = "";
            }
            ?>
            <div class="destination-grid-sm-item">
                <?php
                if ($Row->p_plan == 'Silver' || $Row->p_plan == 'Gold' || $Row->p_plan == 'Premium' ||
                    $Row->p_plan == 'Gold Plus' || $Row->p_plan == 'Premium Plus') {
                    ?>
                    <div class="mask"></div>
                    <?php
                }
                ?>
                <div class="image">
                    <a href="<?= $redirectUrl ?>" title="<?= $title ?>" target="<?= $target ?>">
                        <?php
                        $photoViewStatus = $Row->photo_view_status;
                        $isPhotoAvailable = "photos/" . trim($Row->photo1);
                        $photo = trim("photos/watermark?image=" . rtrim($Row->photo1, ' 1') . "&watermark=watermark.png");
                        if (!empty(trim($Row->photo1)) && file_exists($isPhotoAvailable) &&
                            (!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') && ($photoViewStatus == 1 || (($photoViewStatus == 2 || $photoViewStatus == 0) && $_SESSION['membership'] != 'Free'))) { ?>
                            <img src="<?= $photo ?>"
                                 title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
                        <?php } else if (!empty(trim($Row->photo2)) && file_exists("photos/" . trim($Row->photo2)) &&
                            (!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') && ($photoViewStatus == 1 || (($photoViewStatus == 2 || $photoViewStatus == 0) && $_SESSION['membership'] != 'Free'))) { ?>
                            <img src="<?= trim("photos/watermark?image=" . rtrim($Row->photo2, ' 1') . "&watermark=watermark.png") ?>"
                                 title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
                        <?php } else if (!empty(trim($Row->photo3)) && file_exists("photos/" . trim($Row->photo3)) &&
                            (!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') && ($photoViewStatus == 1 || (($photoViewStatus == 2 || $photoViewStatus == 0) && $_SESSION['membership'] != 'Free'))) { ?>
                            <img src="<?= trim("photos/watermark?image=" . rtrim($Row->photo3, ' 1') . "&watermark=watermark.png") ?>"
                                 title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
                        <?php } else if (!empty(trim($Row->photo4)) && file_exists("photos/" . trim($Row->photo4)) &&
                            (!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') && ($photoViewStatus == 1 || (($photoViewStatus == 2 || $photoViewStatus == 0) && $_SESSION['membership'] != 'Free'))) { ?>
                            <img src="<?= trim("photos/watermark?image=" . rtrim($Row->photo4, ' 1') . "&watermark=watermark.png") ?>"
                                 title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
                        <?php } else if (!$photoViewStatus) {
                            if ($Row->gender == 'Groom') {
                                $showPhoto = "img/default-photo/photo-protected-male100.png";
                            } else {
                                $showPhoto = "img/default-photo/photo-protected-female.png";
                            } ?>
                            <img src="<?= $showPhoto ?>" class="img img-responsive"
                                 style="margin-left: 14%; width: 78%;"
                                 title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                        <?php } else {
                            if ($Row->gender == 'Groom') {
                                if ($Row->photo_protect == 'Yes') {
                                    $showPhoto = "img/default-photo/photo-protected-male100.png";
                                } else {
                                    $showPhoto = "img/default-photo/male-200.png";
                                }
                                ?>
                                <img src="<?= $showPhoto ?>" class="img img-responsive"
                                     style="margin-left: 14%; width: 78%;"
                                     title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                            <?php } else {
                                if ($Row->photo_protect == 'Yes') {
                                    $showPhoto = "img/default-photo/photo-protected-female.png";
                                } else {
                                    $showPhoto = "img/default-photo/female-200.png";
                                } ?>
                                <img src="<?= $showPhoto ?>" class="img img-responsive"
                                     style="margin-left: 14%; width: 78%;"
                                     title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                            <?php }
                        } ?>
                    </a>
                </div>
                <div class="content text-darker" style="font-size: 13px;">
                    <?php $ao31 = $Row->height;
                    $ft31 = (int)($ao31 / 12);
                    $inch31 = $ao31 % 12; ?>
                    <a title="<?= $title ?>" href="<?= $redirectUrl ?>" target="<?= $target ?>">
                        <h5><?php echo $Row->matri_id; ?> - <?php echo $Row->firstname; ?></h5>
                    </a>
                    <?= floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Yrs, '; ?>
                    <?= $ft31 . "'" . $inch31 . '", '; ?>
                    <?= $Row->religion_name . (($Row->religion_name == 'Buddhist') ? "" : " - " . $Row->caste_name) ?>,
                    <?php
                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
                    echo $known_education['my_education'] . ", "; ?>
                    <?= $Row->ocp_name ?> from <?= $Row->city_name ?><br/>
                    <p style="position: absolute;bottom: 20px;left: 28%;"><label class="label label-primary"
                                                                                 style="font-weight:normal;text-transform: capitalize;float: none; padding: 4px 8px;color: #fff;border-radius: 4px;cursor: pointer;"
                                                                                 onclick="ExpressInterest('<?= $Row->matri_id; ?>', '<?= $Row->firstname ?>')"
                        ><i class="fa fa-paper-plane-o"></i> Connect Now</label></p><br/>
                    <label class="label"
                           style="float: none; padding: 2px 5px;color: #333!important;position: absolute;bottom: 16px;left: 18%;">Last
                        Login: <?= date('d M, Y', strtotime($Row->last_login)) ?></label>
                </div>

            </div>
        </div>
