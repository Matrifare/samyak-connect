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
?>
</div>
</div>
<div class="clearfix"></div>
<div class="row mb-10">
    <div class="hidden-xs hidden-xss">
        <div class="col-sm-1"></div>
    </div>
    <div class='mb-10'>
        <?php
        }
        $showId = $Row->matri_id;
        $profile = dechex($Row->index_id * 726925);
        ?>

        <div class="col-sm-2 col-xs-6 mb-10">
            <a title="View Profile" href="view-profile?profile=<?= $profile ?>" target="_blank"
               class="destination-grid-sm-item">
                <div class="image" style="height: 230px;">
                    <?php
                    $isPhotoAvailable = "photos_big/" . trim($Row->photo1);
                    $photo = trim("photos_big/watermark?image=photos_big/" . rtrim($Row->photo1, ' 1') . "&watermark=photos_big/watermark.png");
                    if (!empty(trim($Row->photo1)) && file_exists($isPhotoAvailable) && !empty(trim($Row->photo_protect) && trim($Row->photo_protect == 'No'))) { ?>
                        <img src="<?= $photo ?>"
                             title="<?php echo $showId; ?>" alt="<?php echo $showId; ?>">
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
                </div>

                <div class="content text-darker" style="font-size: 13px;">
                    <?php $ao31 = $Row->height;
                    $ft31 = (int)($ao31 / 12);
                    $inch31 = $ao31 % 12; ?>
                    <h5 style="margin-bottom: 10px;"><label class="label label-danger"> <?= "NO. " . $count ?></label> | <label class="label label-primary"> <?php echo $Row->matri_id; ?> </label></h5>
                    <h5><?php echo $Row->username; ?></h5>
                    <?php echo floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Yrs'; ?>,
                    <?= $ft31 . "ft" . " " . $inch31 . "in"; ?>,
                    <?php
                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
                    echo $known_education['my_education']; ?><br/>
                    <?php /*$ao = $Row->height;
                    $ft = (int)($ao / 12);
                    $inch = $ao % 12;
                    echo $ft . "ft" . " " . $inch . "in";*/ ?>
                    <?= $Row->ocp_name ?> from <?= $Row->city_name ?><br/>
                    Family Origin <?= $Row->family_city ?>
                </div>

            </a>
        </div>
