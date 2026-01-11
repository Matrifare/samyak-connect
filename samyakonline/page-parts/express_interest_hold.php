<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 6:25 PM
 */

include_once '../page-parts/express_pagination.php';
require_once '../DatabaseConnection.php';
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
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT expressinterest.ei_receiver FROM expressinterest,register_view
 WHERE register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$mid' and expressinterest.trash_sender='No' and expressinterest.trash_receiver='No'
  and expressinterest.receiver_response='Hold' and register_view.status <> 'Suspended' GROUP BY expressinterest.ei_receiver"));
} else {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT expressinterest.ei_sender FROM expressinterest,register_view
 WHERE register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$mid'
  and expressinterest.trash_receiver='No' and expressinterest.trash_sender='No' and expressinterest.receiver_response='Hold' and register_view.status <> 'Suspended' GROUP BY expressinterest.ei_sender"));
}
if ($rows > 0) {
    if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'sent') {
        $sql = "SELECT DISTINCT r.firstname, r.username, r.m_status, r.last_login, r.photo1, r.photo1_approve, r.photo_protect,
                r.photo_view_status, r.matri_id, r.samyak_id, r.photo_pswd, r.gender, r.email, r.status, r.profile_text,
                r.birthdate, r.height, r.religion_name, r.caste_name, r.mtongue_name, r.edu_name, r.city_name, r.country_name,
                r.state_name, r.family_city, r.ocp_name, r.logged_in, r.index_id, e.ei_sent_date, e.ei_message, e.ei_id, e.receiver_response_date
                FROM expressinterest e LEFT JOIN register_view r ON e.ei_receiver = r.matri_id 
                    WHERE e.ei_sender = '$mid' AND e.trash_sender = 'No' AND e.trash_receiver = 'No' 
                      AND e.receiver_response = 'Hold' AND r.status <> 'Suspended' ORDER BY e.ei_id DESC LIMIT $start,$limit";
    } else {
        $sql = "SELECT DISTINCT r.firstname, r.username, r.m_status, r.last_login, r.photo1, r.photo1_approve, r.photo_protect,
                r.photo_view_status, r.matri_id, r.samyak_id, r.photo_pswd, r.gender, r.email, r.status, r.profile_text, r.birthdate,
                r.height, r.religion_name, r.caste_name, r.mtongue_name, r.edu_name, r.city_name, r.country_name, r.state_name,
                r.family_city, r.ocp_name, r.logged_in, r.index_id, e.ei_sent_date, e.ei_message, e.ei_id, e.receiver_response_date
                FROM expressinterest e LEFT JOIN register_view r ON e.ei_sender=r.matri_id 
                WHERE e.ei_receiver = '$mid' AND e.trash_receiver = 'No' AND e.trash_sender = 'No' 
                  AND e.receiver_response = 'Hold' AND r.status <> 'Suspended' ORDER BY e.ei_id DESC LIMIT $start,$limit";
    }
    $data = $DatabaseCo->dbLink->query($sql);
    ?>
    <div class="tab-content-inner">
        <ul class="hotel-message-list" id="express_interest_list">
            <?php if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'sent') { ?>
                <div style="color: darkslategray; font-weight: normal; padding: 10px;">NOTE: These persons have neither Accepted nor Rejected your interests.</div>
            <?php } else { ?>
                <div style="color: darkslategray; font-weight: normal; padding: 10px;">NOTE: Now you can delete express interests without letting the other profiles know about it.</div>
            <?php } ?>
            <?php
            while ($Row = mysqli_fetch_object($data)) { ?>
                <li id="delsentall<?= $Row->ei_id ?>">
                    <div class="clearfix relative">
                        <div class="row">
                            <div class="col-xs-4 col-sm-2 pr-5">
                                <a href="view_profile?userId=<?= $Row->matri_id ?>" target="_blank">
                                    <div class="image" style="cursor: pointer;">
                                        <?php include 'express_interest_photo.php'; ?>
                                        <p class="mb-5" style="color:darkslategray;margin-top: 20px;line-height: 14px;"> Decided later on:
                                            <?php echo date('d M, Y', strtotime($Row->receiver_response_date)); ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-8 col-sm-10 pl-5">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-xss-12 col-md-6 col-xs-6">
                                            <p class="text-danger mb-5" style="font-weight: bold;"> Interest received on:
                                                <?php echo date('d M, Y', strtotime($Row->ei_sent_date)); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="view_profile?userId=<?= $Row->matri_id ?>" target="_blank">
                                        <h4 class="mt-10"><?= $Row->firstname ?>
                                            -
                                            <?= $Row->matri_id ?></h4></a>
                                    <p class="mb-0"><?php echo floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Years'; ?>
                                        ,
                                        <?php echo $Row->m_status; ?>, <?php echo $Row->religion_name; ?></p>
                                    <p class="mb-5"><?php echo $Row->ocp_name; ?>
                                        From <?php echo $Row->city_name; ?></p>
                                    <?php if(!empty($Row->family_city)) { ?>
                                    <p class="mb-5">Family Origin
                                        From <?php echo $Row->family_city; ?></p>
                                    <?php } ?>
                                    <p class="mb-5"><strong><i class="fa fa-comments-o" aria-hidden="true"></i> :
                                        </strong> <?php echo htmlspecialchars_decode($Row->ei_message, ENT_QUOTES); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-6 pr-0">
                                <div class="date pt-5"><i
                                            class="fa fa-eye"></i>
                                    <a href="view_profile?userId=<?= $Row->matri_id ?>" target="_blank">View Profile</a>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-6">
                                <div class="action-btn">
                                    <?php
                                    if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'received') {
                                        ?>
                                        <button id="accept<?= $Row->ei_id ?>" class="btn btn-sm btn-success btn-shrink"
                                                onclick="acceptint('<?= $Row->ei_id ?>')">Accept
                                        </button>
                                        <button id="reject<?= $Row->ei_id ?>" class="btn btn-sm btn-primary btn-shrink"
                                                onclick="rejectint('<?= $Row->ei_id ?>')">Reject
                                        </button> |
                                        <button id="reject<?= $Row->ei_id ?>" class="btn btn-sm btn-danger btn-shrink"
                                                onclick="deleteexprev('<?= $Row->ei_id ?>', '<?= $_POST['interest_type'] ?>')">Delete
                                        </button>
                                        <?php
                                    } else { ?>
                                        <button id="reject<?= $Row->ei_id ?>" class="btn btn-sm btn-danger btn-shrink"
                                                onclick="deleteexprev('<?= $Row->ei_id ?>', '<?= $_POST['interest_type'] ?>')">Delete
                                        </button>
                                    <?php } ?>
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
                        pagination($limit, $adjacent, $rows, $page, $_POST['interest_type'],'hold');
                        ?>
                    </ul>
                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Decide Later - <?= $rows ?>");
    </script>
    <?php
} else { ?>
    <div class="tab-content-inner">
        <div style="color: darkslategray; font-weight: normal;padding: 10px;">NOTE: Now you can delete express interests without informing the other profiles about it.</div>
        <h3 class="text-center">No Data Found</h3>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Decide Later - 0");
    </script>
<?php }
?>