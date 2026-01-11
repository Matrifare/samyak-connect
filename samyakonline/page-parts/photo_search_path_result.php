<?php
if (isset($Row)) {

    if ($Row->photo1 != "" && $Row->photo1_approve == 'APPROVED' &&
        (
            ($Row->photo_view_status == '1') || ($Row->photo_view_status == '2' && $_SESSION['mem_status'] == 'Paid')
        )
        && ($Row->photo_protect != "Yes" || $Row->photo_pswd == '') && file_exists("photos/".$Row->photo1)
    ) {
        return print(trim("photos/watermark.php?image=". $Row->photo1 ."&watermark=watermark.png"));
    } elseif ($Row->photo_protect == "Yes" && $Row->photo_pswd != '' && isset($_SESSION['user_id'])) {

        if ($Row->gender == 'Groom') {
            return print("./img/default-photo/photopassword_male.png");
         } else {
            return print(trim("./img/default-photo/photopassword_female.png")); ?>
            <!--<a href="javascript:;" data-toggle="modal"
               onClick="newWindow('send_pass_request.php?id=<?php /*echo $Row->matri_id; */?>','','790','440')">
                <img src="./img/default-photo/photopassword_female.png" class="img-responsive ne_result_img myimg"
                     title="<?php /*echo $Row->username; */?>" alt="<?php /*echo $Row->matri_id; */?>">
            </a>-->
        <?php }
    } else {
        if ($Row->gender == 'Groom') {
            return print(trim("./img/default-photo/male-200.png"));
            ?>
            <!--<img src="./img/default-photo/male-200.png" class="img-responsive ne_result_img myimg"
                 title="<?php /*echo $Row->username; */?>" alt="<?php /*echo $Row->matri_id; */?>">-->

        <?php } else {
            return print(trim("./img/default-photo/female-200.png"));
            ?>

            <!--<img src="./img/default-photo/female-200.png" class="img-responsive ne_result_img myimg"
                 title="<?php /*echo $Row->username; */?>" alt="<?php /*echo $Row->matri_id; */?>">-->
        <?php }
    } ?>

<?php } ?>