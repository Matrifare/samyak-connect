<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 6:25 PM
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
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT ei_receiver FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_receiver and expressinterest.ei_sender='$mid' and expressinterest.trash_sender='No' AND expressinterest.trash_receiver='No'
  and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended' GROUP BY ei_receiver"));
} else {
    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT ei_sender FROM expressinterest,register_view WHERE
 register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='$mid' and expressinterest.trash_receiver='No' AND expressinterest.trash_sender='No'
  and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended' GROUP BY ei_sender"));
}
if ($rows > 0) {
    if (!empty($_POST['interest_type']) && $_POST['interest_type'] == 'sent') {
        $sql = "SELECT DISTINCT r.firstname, r.username, r.m_status, r.last_login, r.photo1, r.photo1_approve, r.photo_protect,
                r.photo_view_status, r.matri_id, r.samyak_id, r.photo_pswd, r.gender, r.email, r.status, r.profile_text,
                r.birthdate, r.height, r.religion_name, r.caste_name, r.mtongue_name, r.edu_name, r.city_name, r.country_name,
                r.state_name, r.family_city, r.ocp_name, r.logged_in, r.index_id, e.ei_sent_date, e.ei_message, e.ei_id
            FROM expressinterest e LEFT JOIN register_view r ON e.ei_receiver = r.matri_id
            WHERE e.ei_sender = '$mid' AND e.trash_sender = 'No' AND e.trash_receiver = 'No' 
              AND e.receiver_response = 'Accept' AND r.status <> 'Suspended' ORDER BY e.ei_id DESC LIMIT $start,$limit";
    } else {
        $sql = "SELECT DISTINCT r.firstname, r.username, r.m_status, r.last_login, r.photo1, r.photo1_approve,
                r.photo_protect, r.photo_view_status, r.matri_id, r.samyak_id, r.photo_pswd, r.gender, r.email, r.status,
                r.profile_text, r.birthdate, r.height, r.religion_name, r.caste_name, r.mtongue_name, r.edu_name,
                r.city_name, r.country_name, r.state_name, r.family_city, r.ocp_name, r.logged_in, r.index_id, e.ei_sent_date,
                e.ei_message, e.ei_id 
                FROM expressinterest e LEFT JOIN register_view r ON e.ei_sender = r.matri_id 
                WHERE r.matri_id = e.ei_sender AND e.ei_receiver = '$mid' AND e.trash_receiver = 'No' 
                  AND e.trash_sender = 'No' AND e.receiver_response = 'Accept' AND r.status <> 'Suspended' 
            ORDER BY e.ei_id DESC LIMIT $start, $limit";
    }
    $data = $DatabaseCo->dbLink->query($sql);
    ?>
    <div class="tab-content-inner">
        <ul class="hotel-message-list" id="express_interest_list">
            <?php
            while ($Row = mysqli_fetch_object($data)) { ?>
                <li>
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
                                    <button class="btn btn-sm btn-primary btn-shrink"
                                            onclick="view_message_box('<?= $Row->matri_id ?>');">Message
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-shrink"
                                            onclick="getContactDetail('<?php echo $Row->matri_id; ?>');">View Contact
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
                            pagination($limit, $adjacent, $rows, $page, $_POST['interest_type'], 'accepted');
                            ?>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Accepted - <?= $rows ?>");
    </script>
    <?php
} else { ?>
    <div class="tab-content-inner">
        <h3 class="text-center">No Data Found</h3>
    </div>
    <script type="text/javascript">
        $("#countWithExpressInterest").html("Accepted - 0");
    </script>
<?php }
?>