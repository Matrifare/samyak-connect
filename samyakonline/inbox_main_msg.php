<?php

include_once 'DatabaseConnection.php';

include_once 'lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();

include_once 'lib/Config.php';

$configObj = new Config();


$get_msg_id = $_GET['msg_id'];


$DatabaseCo->dbLink->query("update message set msg_read_status='Yes' where msg_id='$get_msg_id'");

$sel_msg_data = $DatabaseCo->dbLink->query("select * from message where msg_id='$get_msg_id'");

$get_msg_data = mysqli_fetch_object($sel_msg_data);
$msg_id = $get_msg_data->msg_id;

if ($get_msg_data->msg_to == $_SESSION['email']) {
    $msg_user = 'From';
} else {
    $msg_user = 'To';
}


if (isset($_GET['inb']) && $_GET['inb'] == '1') {


    $from_email_id = $get_msg_data->msg_from;

}

if (isset($_GET['sent']) || isset($_GET['draft']) || isset($_GET['trash']) || isset($_GET['imp'])) {


    $from_email_id = $get_msg_data->msg_to;

}


$msg_reg_nm = $DatabaseCo->dbLink->query("select username,photo1,photo1_approve from register where email='" . $from_email_id . "'");


$get_nm = mysqli_fetch_object($msg_reg_nm);


/*----create variable for back button -----*/

if (isset($_GET['inb'])) {

    $backurl = 'inbox.php';

    $backtooltip = 'Inbox';

    $del_var = '&inb=1';

    //$msg_status='inbox_msg_reply';

} elseif (isset($_GET['sent'])) {

    $backurl = 'sent_msg.php';

    $backtooltip = 'Sent Message';

    $del_var = '&sent=1';
    //$msg_status='replay_msg';
} elseif (isset($_GET['draft'])) {

    $backurl = 'draft_msg.php';

    $backtooltip = 'Draft Message';

    $del_var = '&draft=1';
    //$msg_status='replay_msg';
} elseif (isset($_GET['trash'])) {

    $backurl = 'trash_msg.php';

    $backtooltip = 'Trash Message';

    $del_var = '&trash=1';
    //$msg_status='replay_msg';
} elseif (isset($_GET['imp'])) {

    $backurl = 'important_msg.php';

    $backtooltip = 'Important Message';

    $del_var = '&imp=1';
    //$msg_status='replay_msg';
}

/*----create variable for back button end -----*/


if (isset($_GET['del'])) {

    $DatabaseCo->dbLink->query("delete from message where msg_id='" . $_GET['msg_id'] . "'");


    echo "<script>alert('Message Deleted Succcessfully.');

	window.location='" . $backurl . "';</script>";


}


?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $configObj->getConfigTitle(); ?></title>

    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>

    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>

    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>

    <!-------------------------------- Custome css --------------------------->


    <link href="css/style.css" rel="stylesheet">


    <!-------------------------------- Custome css End------------------------>

    <!-------------------------------- bootstrap css ------------------------->


    <link href="css/bootstrap.css" rel="stylesheet">


    <!-------------------------------- bootstrap css End---------------------->

    <!-------------------------------- Responsive css ------------------------>


    <link href="css/responsive.css" rel="stylesheet">


    <!-------------------------------- Responsive css End--------------------->

    <!-------------------------------- Hover css ------------------------>


    <link href="css/hover.css" rel="stylesheet">


    <!-------------------------------- hover css End--------------------->

    <!-------------------------------- Google font --------------------------->


    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>


    <!--------------------------------  Google font End---------------------->

    <!--------------------------------  icon font --------------------------->


    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


    <!--------------------------------  icon font End------------------------>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="js/html5shiv.js"></script>

    <script src="js/respond.js"></script>

    <![endif]-->


</head>

<body>

<div class="page-wrap ne-aft-log">

    <div class="container-fluid ne-aft-log-tp">

        <div class="row">


            <?php include 'page-parts/header_after_login.php'; ?>

            <?php include 'page-parts/menu_after_login.php'; ?>

            <div class="container">

                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-320 padding-lr-zero-480 padding-lr-zero-768 padding-lr-zero">

                    <?php include "page-parts/msg-left-menu.php"; ?>

                    <div class="xxl-12 xl-12 l-12 xs-16 m-16 s-16 ne_inbox_right_pan padding-lr-zero-320 margin-top-10px-320px padding-lr-zero-480 margin-top-10px-480px  ne-mrg-top-10-768">

                        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne-bdr-tpstrip-inbox ne_pad_tp_5px ne_pad_btm_5px">

                            <div class="xxl-3 xl-3 m-2 xs-16 s-16 l-3 ne_pad_tp_3px padding-lr-zero">

                                <a href="<?php echo $backurl; ?>"
                                   class="ne_msg_tp_strip xxl-16 xl-16 l-16 m-16 s-16 xs-16 center-text"
                                   data-toggle="tooltip" data-placement="left"
                                   title="Back To <?php echo $backtooltip; ?>">

                                    <i class="fa fa-angle-double-left ne_mrg_ri8_10"></i> Back

                                </a>

                            </div>

                            <div class="xxl-8 xl-8 m-8 l-13 xs-16 ne_pad_tp_10px ne_pad_btm_10px padding-lr-zero-320 font-12px-320 font-12px-480 font-12px-768">

                                <span class="ne_mrg_ri8_10">Subject  :</span><?php echo $get_msg_data->msg_subject; ?></b>

                            </div>

                            <div class="xxl-5 xl-5 m-6 xs-16 ne_pad_tp_3px">

                                <a href="?msg_id=<?php echo $_GET['msg_id'] . $del_var . '&del=1'; ?>"
                                   class="ne_msg_tp_strip pull-right" data-toggle="tooltip" data-placement="left"
                                   title="Delete">

                                    <i class="fa fa-trash"></i>

                                </a>

                                <a href="compose_msg.php?msg_id=<?php echo $_GET['msg_id']; ?>&frwd=1"
                                   class="ne_msg_tp_strip pull-right" data-toggle="tooltip" data-placement="left"
                                   title="Forward">

                                    <i class="fa fa-share"></i>

                                </a>

                                <a href="compose_msg.php?msg_id=<?php echo $_GET['msg_id'] . $del_var; ?>"
                                   class="ne_msg_tp_strip pull-right" data-toggle="tooltip" data-placement="left"
                                   title="Reply">

                                    <i class="fa fa-reply"></i>

                                </a>


                            </div>

                        </div>

                        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_tp_5px ne_pad_btm_5px">

                            <div class="xxl-8 xl-9 m-10 s-16 xs-16 l-9 padding-lr-zero ne_pad_left_5px">


                                <div class="row">

                                    <b class="font-orange"><?php if (isset($_GET['inb'])) {
                                            echo "From";
                                        } else {
                                            echo $msg_user;
                                        } ?> : </b>
                                    <b class="font-orange ne_mrg_ri8_10"><?php echo $get_nm->username; ?></b>


                                </div>


                            </div>

                            <div class="xxl-8 xl-7 l-7 m-6 s-16 xs-16 ne_pad_tp_5px right-text">

                                <span class="fa fa-clock-o ne_mrg_ri8_10"></span><span><?php echo date('d M Y ,H:i A', strtotime($get_msg_data->msg_date)); ?></span>

                            </div>

                        </div>

                        <ul class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 ne_inbox_msg_section padding-lr-zero ">

                            <li class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 ne_pad_tp_10px ne_pad_btm_10px ne-bdr-btm-lgt-grey">

                                <?php echo htmlspecialchars_decode($get_msg_data->msg_content); ?>

                            </li>


                            <li class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 ne_font_14 ne_pad_tp_15px ne_pad_btm_15px">

                                <a href="compose_msg.php?msg_id=<?php echo $_GET['msg_id'] . $del_var; ?>"
                                   class="font-red">

                                    <b>Reply</b>

                                </a>

                                or

                                <a href="compose_msg.php?msg_id=<?php echo $_GET['msg_id']; ?>&frwd=1" class="font-red">

                                    <b>Forward</b>

                                </a>

                                this message..

                            </li>


                        </ul>


                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

<?php

include 'page-parts/footer.php';

?>

</body>

<!-------------------------------------- jQuery Letest -------------------------------->

<script src="js/jquery-1.11.1.min.js"></script>

<!-------------------------------------- jQuery Letest End ---------------------------->

<!-------------------------------------- Bootstrap js --------------------------------->

<script src="js/bootstrap.min.js"></script>

<!-------------------------------------- Bootstrap js End ----------------------------->

<!--------------------------------------Pace js --------------------------------------->

<script src="js/pace.min.js"></script>

<!-------------------------------------- Pace js End ----------------------------------->


<script>

    $('[data-toggle="tooltip"]').tooltip({

        trigger: 'hover',

        'placement': 'top'

    });


</script>


</html>