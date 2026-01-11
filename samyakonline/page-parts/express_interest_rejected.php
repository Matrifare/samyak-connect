<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 6:26 PM
 */
include_once '../page-parts/express_pagination.php';
include_once '../DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
$limit = 8;
$page = !empty($_POST['page']) ? $_POST['page'] : 1;
$adjacent = 2;
if ($page == 1) {
    $start = 0;
} else {
    $start = ($page - 1) * $limit;
}
$mid = $_SESSION['user_id'];
if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'sent') {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT ei_id FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$mid' and expressinterest.trash_sender='No' and expressinterest.trash_receiver='No'
  and expressinterest.receiver_response='Reject' and register_view.status <> 'Suspended'"));
} else {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT ei_id FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$mid' and expressinterest.trash_receiver='No' and expressinterest.trash_sender='No'
 and expressinterest.receiver_response='Reject' and register_view.status <> 'Suspended'"));
}
if ($rows > 0) {
    if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'sent') {
        $sql = "SELECT DISTINCT * FROM expressinterest,register_view WHERE 
register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$mid'
 and expressinterest.trash_sender='No' and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Reject' and
  register_view.status <> 'Suspended' ORDER BY expressinterest.ei_id DESC limit $start,$limit ";
    } else {
        $sql = "SELECT DISTINCT * FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$mid'
  and expressinterest.trash_receiver='No' and expressinterest.trash_sender='No' and expressinterest.receiver_response='Reject'
   and register_view.status <> 'Suspended' ORDER BY expressinterest.ei_id DESC limit $start,$limit";
    }
    $data = $DatabaseCo->dbLink->query($sql);
    ?>
    <div class="tab-content-inner">
        <ul class="hotel-message-list" id="express_interest_list">
            <?php
            while ($Row = mysqli_fetch_object($data)) { ?>
                <li id="delsentall<?= $Row->ei_id ?>">
                    <div class="clearfix relative">
                        <div class="row">
                            <div class="col-xs-4 col-sm-2 pr-5">
                                <a href="view_profile?userId=<?= $Row->matri_id ?>" target="_blank">
                                    <div class="image" style="cursor: pointer;">
                                        <?php include 'express_interest_photo.php'; ?>
                                    </div>
                                </a>
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
                                    <a href="view_profile?userId=<?= $Row->matri_id ?>" target="_blank">
                                        <h4 class="mt-10"><?= $Row->firstname ?>
                                            -
                                            <?= $Row->matri_id ?></h4></a>
                                    <p class="mb-0"><?php echo floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Years'; ?>
                                        ,
                                        <?php echo $Row->m_status; ?>, <?php echo $Row->religion_name; ?></p>
                                    <p class="mb-5"><?php echo $Row->ocp_name; ?>
                                        From <?php echo $Row->city_name; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-6 pr-0">
                                <div class="date pt-5"><i
                                            class="fa fa-calendar-o"></i> <?php echo date('d M, Y', strtotime($Row->ei_sent_date)); ?>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-6">
                                <div class="action-btn">
                                    <button class="btn btn-sm btn-primary btn-shrink">Messsage</button>
                                    <button class="btn btn-sm btn-danger btn-shrink"
                                            onclick="deleteexprev('<?= $Row->ei_id ?>', '<?= $_POST['interest_type'] ?>')">
                                        Delete
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <div class="result-paging-wrapper mt-0">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="paging mb-5">
                        <?php
                        pagination($limit, $adjacent, $rows, $page, $_POST['interest_type'], 'rejected');
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Rejected - <?= $rows ?>");
    </script>
    <?php
} else { ?>
    <div class="tab-content-inner">
        <h3 class="text-center">No Data Found</h3>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Rejected - 0");
    </script>
<?php }
?>