<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 7:45 PM
 */
if ($Row->photo1 != "" && $Row->photo1_approve == 'APPROVED' &&
    (
        ($Row->photo_view_status == '1') || ($Row->photo_view_status == '2' && $_SESSION['mem_status'] == 'Paid')
    )
) {
    ?>

    <img src="watermark?image=photos/<?php echo $Row->photo1; ?>&watermark=photos/watermark.png" class="img-thumbnail square_photo"
         title="<?php echo $Row->firstname; ?>" alt="<?php echo $Row->matri_id; ?>">


    <?php
} elseif ($Row->photo_protect == "Yes" && $Row->photo_pswd != '' && $_SESSION['user_id']) {

    if ($Row->gender == 'Groom') {
        ?>
        <img src="./img/default-photo/photopassword_male.png" class="img-thumbnail square_photo"
             title="<?php echo $Row->firstname; ?>" alt="<?php echo $Row->matri_id; ?>">
    <?php } else { ?>
        <img src="./img/default-photo/photopassword_female.png" class="img-thumbnail square_photo"
             title="<?php echo $Row->firstname; ?>" alt="<?php echo $Row->matri_id; ?>">
    <?php }
} else {
    if ($Row->gender == 'Groom') {
        ?>
        <img src="./img/default-photo/male-200.png" class="img-thumbnail square_photo" title="<?php echo $Row->firstname; ?>"
             alt="<?php echo $Row->matri_id; ?>">

    <?php } else { ?>

        <img src="./img/default-photo/female-200.png" class="img-thumbnail square_photo" title="<?php echo $Row->firstname; ?>"
             alt="<?php echo $Row->matri_id; ?>">


    <?php }
} ?>
<style>
    center > .img-thumbnail {
        height: 126px;
        width: 100%;
    }
</style>

