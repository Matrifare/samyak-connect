<div class="col-sm-6 col-md-4 isotope-item">
    <div class="hotel_container">
        <!--<div class="ribbon_3 popular"><span>Popular</span></div>-->
        <div class="img_container">
            <a href="login">
                <?php
                $photoViewStatus = $Row->photo_view_status;
                $isPhotoAvailable = "https://samyakmatrimony.com/photos/" . trim($Row->photo1);
                $photo = trim("https://samyakmatrimony.com/photos/watermark?image=" . rtrim($Row->photo1, ' 1') . "&watermark=watermark.png");
                if (!empty(trim($Row->photo1)) && file_exists($isPhotoAvailable) &&
                    ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) { ?>
                    <img src="<?= $photo ?>" class="img-fluid" width="800" height="533"
                         title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
                <?php } else if (!empty(trim($Row->photo2)) && file_exists("https://samyakmatrimony.com/photos/" . trim($Row->photo2)) &&
                    ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) { ?>
                    <img src="<?= trim("https://samyakmatrimony.com/photos/watermark?image=" . rtrim($Row->photo2, ' 1') . "&watermark=watermark.png") ?>"
                         title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>" width="800" height="533"
                         class="img-fluid">
                <?php } else if (!empty(trim($Row->photo3)) && file_exists("https://samyakmatrimony.com/photos/" . trim($Row->photo3)) &&
                    ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) { ?>
                    <img src="<?= trim("https://samyakmatrimony.com/photos/watermark?image=" . rtrim($Row->photo3, ' 1') . "&watermark=watermark.png") ?>"
                         title="<?php echo $showId; ?>" width="800" height="533" alt="<?php echo $showId; ?>"
                         class="img-fluid">
                <?php } else if (!empty(trim($Row->photo4)) && file_exists("https://samyakmatrimony.com/photos/" . trim($Row->photo4)) &&
                    ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) { ?>
                    <img src="<?= trim("https://samyakmatrimony.com/photos/watermark?image=" . rtrim($Row->photo4, ' 1') . "&watermark=watermark.png") ?>"
                         title="<?php echo $showId; ?>" width="800" height="533" alt="<?php echo $showId; ?>"
                         class="img-fluid">
                <?php } else {
                    if ($Row->gender == 'Groom') {
                        if ($Row->photo_protect == 'Yes') {
                            $showPhoto = "img/default-photo/photo-protected-male100.png";
                        } else {
                            $showPhoto = "img/default-photo/male-200.png";
                        }
                        ?>
                        <img src="<?= $showPhoto ?>" class="img-fluid"
                             style="margin-left: 14%;" width="800" height="533"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php } else {
                        if ($Row->photo_protect == 'Yes') {
                            $showPhoto = "img/default-photo/photo-protected-female.png";
                        } else {
                            $showPhoto = "img/default-photo/female-200.png";
                        } ?>
                        <img src="<?= $showPhoto ?>" class="img-fluid"
                             style="margin-left: 14%;" width="800" height="533"
                             title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                    <?php }
                } ?>
                <!--<div class="score"><span>7.5</span>Good</div>
                <div class="short_info hotel">
                    <span class="price"><sup>$</sup>59</span>
                </div>-->
            </a>
        </div>
        <div class="hotel_title">
            <?php $ao31 = $Row->height;
            $ft31 = (int)($ao31 / 12);
            $inch31 = $ao31 % 12; ?>
            <h3><span><strong><?= $Row->matri_id; ?></strong></span> - <?= $Row->firstname; ?></h3>
            <?= floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Yrs, '; ?>
            <?= $ft31 . "'" . $inch31 . '", '; ?>
            <?= $Row->religion_name . (($Row->religion_name == 'Buddhist') ? "" : " - " . $Row->caste_name) ?><br/>
            <?php
            $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
            echo $known_education['my_education'] . ", "; ?>
            <?= $Row->ocp_name ?> from <?= $Row->city_name ?><br/>
            <!-- end rating -->
            <div class="wishlist">
                <a class="tooltip_flip tooltip-effect-1" href="login">+<span
                            class="tooltip-content-flip"><span class="tooltip-back">Connect Now</span></span></a>
            </div>
            <!-- End wish list-->
        </div>
    </div>
    <!-- End box tour -->
</div>
<!-- End col-md-6 -->