<?php
$photo = "photos/".$Row->photo1;
if (isset($Row)) {
    if ($Row->photo1 != "" && $Row->photo1_approve == 'APPROVED' && file_exists($photo) &&
        (
            ($Row->photo_view_status == '1') || ($Row->photo_view_status == '2' && isset($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid')
        )
        && ($Row->photo_protect != "Yes" || $Row->photo_pswd == '')
    ) {
            ?>
            <img src="photos/watermark.php?image=<?php echo $Row->photo1;
            ?>&watermark=watermark.png" class="img img-responsive"
                 title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
            <?php
    } elseif ($Row->photo_protect == "Yes" && $Row->photo_pswd != '' && isset($_SESSION['user_id'])) {
        if ($Row->gender == 'Groom') {
            ?>
            <a href="javascript:;" data-toggle="modal"
               onClick="newWindow('send_pass_request.php?id=<?php echo $Row->matri_id; ?>','','790','440')">
                <img src="img/default-photo/photopassword_male.png" class="img img-responsive"
                     title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>"></a>
        <?php } else { ?>
            <a href="javascript:;" data-toggle="modal"
               onClick="newWindow('send_pass_request.php?id=<?php echo $Row->matri_id; ?>','','790','440')">
                <img src="img/default-photo/photopassword_female.png" class="img img-responsive"
                     title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
            </a>
        <?php }
    } else {
        if ($Row->gender == 'Groom') {
            ?>
            <img src="img/default-photo/male-200.png" class="img img-responsive"
                 title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
        <?php } else { ?>
            <img src="img/default-photo/female-200.png" class="img img-responsive"
                 title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
        <?php }
    } ?>
<?php } ?>
<style>
    .myimg {
        height: 100% !important;
        width: 100% !important;
    }
</style>