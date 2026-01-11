<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 6:25 PM
 */

include_once 'message_pagination.php';
include_once '../DatabaseConnection.php';
include_once '../lib/Config.php';

$DatabaseCo = new DatabaseConnection();

$limit = 10;
$page = $_POST['page'] ?? 1;
$adjacent = 2;
if ($page == 1) {
    $start = 0;
} else {
    $start = ($page - 1) * $limit;
}
$mid = $_SESSION['user_id'];
if (!empty($_POST['messages_type']) && $_POST['messages_type'] == 'sent') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT m.msg_id from message m INNER JOIN register_view r ON r.email = m.msg_to where m.msg_from='".$_SESSION['email']."' and m.trash_sender='No'"));
} else {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT m.msg_id from message m INNER JOIN register_view r ON r.email = m.msg_from where m.msg_to='".$_SESSION['email']."' and m.trash_receiver='No'"));
}
?>
<script type="text/javascript">
    $("#countOfMessage").html("<?= $_POST['messages_type'] ?> Messages <?= "- $rows" ?>");
</script>
<?php
if ($rows > 0) {
    if (!empty($_POST['messages_type']) && $_POST['messages_type'] == 'sent') {
        $sql = "SELECT DISTINCT  r.matri_id, r.last_login, r.firstname, r.photo1, r.photo1_approve, r.photo_protect, r.photo_pswd, r.photo_view_status, r.gender, m.msg_id, m.msg_content, m.msg_date from message m INNER JOIN register_view r ON r.email = m.msg_to where m.msg_from='".$_SESSION['email']."' and m.trash_sender='No' order by m.msg_id desc limit $start,$limit ";
    } else {
        $sql = "SELECT DISTINCT  r.matri_id, r.last_login, r.firstname, r.photo1, r.photo1_approve, r.photo_protect, r.photo_pswd, r.photo_view_status, r.gender, m.msg_id, m.msg_content, m.msg_date from message m INNER JOIN register_view r ON r.email = m.msg_from where m.msg_to='".$_SESSION['email']."' and m.trash_receiver='No' order by m.msg_id desc limit $start,$limit ";
    }
    $data = $DatabaseCo->dbLink->query($sql);
    ?>
    <div class="tab-content-inner">
        <ul class="hotel-message-list" id="message_list">
            <?php
            while ($Row = mysqli_fetch_object($data)) { ?>
                <li id="deleteBox<?= $Row->msg_id ?>" style="min-height: auto;">
                    <div class="clearfix relative">
                        <div class="row">
                            <div class="col-xs-4 col-sm-2 pr-5">
                                <div class="image">
                                    <?php include 'express_interest_photo.php'; ?>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-10 pl-5">
                                <div class="content">
                                    <span class="action-label label label-shadow">Last Online:
                                        <?php if ($Row->last_login == '0000-00-00 00:00:00') {
                                            echo "Never";
                                        } else {
                                            echo date('d M Y', strtotime($Row->last_login));
                                        } ?>
                                    </span>
                                    <a target="_blank"
                                       href="view_profile?userId=<?= $Row->matri_id ?>"><h4 class="mt-10"><?= $Row->firstname ?> -
                                            <?= $Row->matri_id ?></h4></a>

                                    <p class="mb-5 text-danger"><strong><i class="fa fa-comments-o" aria-hidden="true"></i> :
                                        </strong> <?php echo htmlspecialchars_decode($Row->msg_content, ENT_QUOTES); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-6 pr-0">
                                <div class="date pt-5"><i
                                            class="fa fa-calendar-o"></i> <?php echo date('d M, Y', strtotime($Row->msg_date)); ?>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-6">
                                <div class="action-btn">
                                    <button class="btn btn-sm btn-primary btn-shrink" onclick="view_message_box('<?= $Row->matri_id ?>');">Reply
                                    </button>
                                    <button id="delete<?= $Row->msg_id ?>" class="btn btn-sm btn-danger btn-shrink"
                                            onclick="delete_message('<?= $Row->msg_id ?>', '<?= $_POST['messages_type'] ?>')">Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <div class="result-paging-wrapper mt-0">

            <div class="result-paging-wrapper mt-0">

                <div class="row">

                    <div class="col-sm-12">
                        <ul class="paging mb-5">
                            <?php
                            pagination($limit, $adjacent, $rows, $page, $_POST['messages_type']);
                            ?>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <?php
} else { ?>
    <div class="tab-content-inner">
        <h3 class="text-center">No Data Found</h3>
    </div>
<?php }
?>