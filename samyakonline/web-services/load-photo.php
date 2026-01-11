<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 10/20/2018
 * Time: 3:41 PM
 */

include_once '../DatabaseConnection.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$matriId = !empty($_POST['matri_id']) ? mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['matri_id']) : "";
$SQL_STATEMENT = "SELECT photo1, photo2, photo3, photo4, photo5, photo6, photo7, photo8,
                photo1_approve, photo2_approve, photo3_approve, photo4_approve, photo5_approve, photo6_approve,
                 photo7_approve, photo8_approve from register_view WHERE matri_id='$matriId'";
$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);
if (mysqli_num_rows($DatabaseCo->dbResult) > 0) {
    $Row = mysqli_fetch_object($DatabaseCo->dbResult);
    ?>
    <div class="gallery-wrap">
        <div class="portfolio-wrap project-gallery">
            <ul id="portfolio_1"
                class="portf auto-construct  project-gallery"
                data-col="5">
                <?php if ($Row->photo1_approve == "APPROVED" && $Row->photo1 != '') {
                    ?>
                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo1; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo1; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo2_approve == "APPROVED" && $Row->photo2 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo2; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo2; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo3_approve == "APPROVED" && $Row->photo3 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo3; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo3; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo4_approve == "APPROVED" && $Row->photo4 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo4; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo4; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo5_approve == "APPROVED" && $Row->photo5 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo5; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo5; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo6_approve == "APPROVED" && $Row->photo6 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo6; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo6; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo7_approve == "APPROVED" && $Row->photo7 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo7; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo7; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php if ($Row->photo8_approve == "APPROVED" && $Row->photo8 != '') {
                    ?>

                    <li class="item"
                        data-src="watermark?image=photos_big/<?php echo $Row->photo8; ?>&watermark=photos_big/watermark.png"
                        data-sub-html="">
                        <a href="">
                            <img class="img-responsive"
                                 src="photos/watermark?image=<?php echo $Row->photo8; ?>&watermark=watermark.png"
                                 alt=""/>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}