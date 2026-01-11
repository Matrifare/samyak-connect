<?php

include_once 'DatabaseConnection.php';

include_once 'lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();

include_once 'lib/Config.php';

$configObj = new Config();

?>



<?php


if (isset($_POST['msg_status']) && $_POST['msg_status'] == 'replay_msg') {

    echo "<script>window.location='compose_msg.php?msg_id=" . $_POST['msg_id'] . "&inb=1'</script>";


}


if (isset($_POST['msg_status']) && $_POST['msg_status'] == 'forward_msg') {

    echo "<script>window.location='compose_msg.php?msg_id=" . $_POST['msg_id'] . "&frwd=1'</script>";


}


if (isset($_POST['msg_status']) && $_POST['msg_status'] == 'trash') {

    $msg_id = explode(",", $_POST['msg_id']);


    foreach ($msg_id as $key => $value) {

        $DatabaseCo->dbLink->query("update message set trash_receiver='Yes' where msg_id='" . $value . "'");


    }

    echo "<script>alert('Your message trash action complete successfully.');</script>";

}


if (isset($_POST['msg_status']) && $_POST['msg_status'] == 'important') {


    $msg_id = explode(",", $_POST['msg_id']);


    foreach ($msg_id as $key => $value) {

        echo "update message set msg_important_status='Yes' where msg_id='" . $value . "'";
        $DatabaseCo->dbLink->query("update message set msg_important_status='Yes' where msg_id='" . $value . "'");


    }

    echo "<script>alert('Your message important action complete successfully.');</script>";

}


if (isset($_POST['msg_important_status']) && $_POST['msg_important_status'] == 'No') {

    $DatabaseCo->dbLink->query("update message set msg_important_status='No' where msg_id='" . $_POST['msg_id'] . "'");

}


if (isset($_POST['msg_important_status']) && $_POST['msg_important_status'] == 'Yes') {

    $DatabaseCo->dbLink->query("update message set msg_important_status='Yes' where msg_id='" . $_POST['msg_id'] . "'");

}


if (isset($_POST['msg_read_type']) && $_POST['msg_read_type'] == 'read') {


    $get_msg = $DatabaseCo->dbLink->query("select * from message where msg_to='" . $_SESSION['email'] . "' and msg_read_status='Yes' and trash_receiver='No' order by msg_id desc");


} else if (isset($_POST['msg_read_type']) && $_POST['msg_read_type'] == 'unread') {


    $get_msg = $DatabaseCo->dbLink->query("select * from message where msg_to='" . $_SESSION['email'] . "' and msg_read_status='No' and trash_receiver='No' order by msg_id desc");

} else if (isset($_POST['msg_read_type']) && $_POST['msg_read_type'] == 'read_all') {


    $get_msg = $DatabaseCo->dbLink->query("select * from message where msg_to='" . $_SESSION['email'] . "' and trash_receiver='No' order by msg_id desc");

} else {


    $get_msg = $DatabaseCo->dbLink->query("select * from message where msg_to='" . $_SESSION['email'] . "' and msg_status='sent' and trash_receiver='No' order by msg_id desc");

}


?>
<?php
if (mysqli_num_rows($get_msg) > 0) {
    ?>


    <form method="post" action="" id="msg_data_form">

        <ul class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 bg-white margin-top-10px ne_inbox_msg_section padding-lr-zero list">


            <?php

            while ($DatabaseCo->dbRow = mysqli_fetch_object($get_msg)) {

                ?>

                <?php include "page-parts/main_msg_inbox.php"; ?>

                <?php

            }

            ?>


        </ul>


    </form>
<?php } else {
    ?>
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero margin-top-10px">
        <div class="thumbnail">
            <img src="img/nodata-available.jpg">
        </div>
    </div>
    <?php
}
?>                    