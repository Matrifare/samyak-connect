<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/10/2018
 * Time: 1:50 AM
 */

include_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';
include_once '../lib/sendmail.php';
include_once '../lib/curl.php';
$DatabaseCo = new DatabaseConnection();
$config = new Config();
$mid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$from_id = isset($_REQUEST['toid']) ? $_REQUEST['toid'] : 0;
$select = "select r.*,p.p_no_contacts, p.r_cnt,p.exp_date,p.p_plan from register_view r JOIN payment_view p ON r.matri_id=p.pmatri_id where pmatri_id='$mid'";
$exe = $DatabaseCo->dbLink->query($select);
$fetch = mysqli_fetch_array($exe);
$total_cnt = $fetch['p_no_contacts'];
$used_cnt = $fetch['r_cnt'];
$exp_date = date('Y-m-d', strtotime($fetch['exp_date']));
$today = date('Y-m-d');
$planName = $fetch['p_plan'];
$checker = mysqli_num_rows($DatabaseCo->dbLink->query("select * from contact_checker where my_id='$mid' and viewed_id='$from_id'"));

if ($_SESSION['user_id'] != '') {
    if ($planName != 'Free') {
        if ($exp_date >= $today) {
            if ($total_cnt - $used_cnt > 0) {
                $sql = $DatabaseCo->dbLink->query("select * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.matri_id='" . $from_id . "'");

                $data = mysqli_fetch_array($sql);
                ?>
                <?php if ($data['contact_view_security'] == '1') {
                    if ($data['gender'] !== $_SESSION['gender123']) {
                        ?>
                        <p class="modal-title ne_font_weight_nrm font-orange" style="margin-bottom: 10px;"
                           id="myModalLabel">

                        <?php if ($checker != 0) {
                            echo "Contact details have been already seen.";
                        } else {
                            /**
                             * Contact Details Privacy with Express Interest
                             */

                            $sqlData = "select * from express_interest_privacy_details where matri_id='" . $from_id . "' AND status=1 LIMIT 1";
                            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlData);
                            $dataResult = mysqli_fetch_array($DatabaseCo->dbResult);
                            if (!empty($dataResult) && count($dataResult)) {
                                $isPrivacyMatched = isPrivacyMatch($fetch, $dataResult);
                                if (!empty($isPrivacyMatched)) { ?>
                                    <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                                        You are Not allowed to see the contact details:
                                    </p>
                                    <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                                        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                            <p class="ne_font_weight_nrm">
                                            <span>
                                            <p>This person only allows to view contact
                                                to people with his/her privacy match.</p>
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                                        <a href="#" type="button" class="btn btn-default pull-right"
                                           data-dismiss="modal">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php
                                    exit;
                                }
                            }

                            // Checking Monthly Limit for Showing Contacts
                            $seenContactMonthly = $DatabaseCo->getSelectQueryResult("SELECT count(my_id) as seenCountMonthly FROM contact_checker where my_id='$mid' and date(date)>='" . date('Y-m-d', strtotime('-30 days')) . "'");
                            $seenCountMonthly = mysqli_fetch_array($seenContactMonthly);
                            $count = $seenCountMonthly['seenCountMonthly'];
                            if ($fetch['request_photo_id'] != 2 && $count >= 30) { ?>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <h6 class='text-danger text-center mb-20'>You have reached the maximum limit for
                                            viewing contact.</h6>
                                        <p class="mb-10 text-center">By verifying Photo Id Proof you can view view more
                                            contacts now.</p>

                                        <p class="text-center mb-20">**Note - To verify your Photo ID proof, kindly send
                                            your photo id proof on
                                            <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or
                                            click on below button to send it on WhatsApp.</p>

                                        <a target="_blank" class="btn btn-success btn-shrink btn-sm"
                                           style="background-color: #25d366; margin-bottom: 20px;"
                                           href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                                    class="fa fa-whatsapp"></i> Send Now</a>
                                    </div>
                                </div>
                                <?php
                                return false;
                            }

                            $seenContact = $DatabaseCo->dbLink->query("SELECT count(my_id) as seenCount FROM contact_checker where my_id='$mid' and date(date)='" . date('Y-m-d') . "'");
                            $seenCount = mysqli_fetch_array($seenContact);
                            $count = $seenCount['seenCount'];
                            if ($count == 5 || $count == 10) {
                                $subject = "$mid has viewed " . $seenCount['seenCount'] . " contacts";
                                $emailTemplate = '<p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                                            </span>
                                            <span> ' . $_SESSION['user_id'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                                            </span>
                                            <span>
                                                ' . $fetch['username'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Plan Name:
                                            </span>
                                            <span>
                                             ' . $planName . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Contacts Seen Today as on ' . date('d M, Y H:i:s') . ':
                                            </span>
                                            <span>
                                             ' . $count . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Total Contacts Seen:
                                            </span>
                                            <span>
                                             ' . ((int)$used_cnt - 1) . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                                            </span>
                                            <span>
                                               ' . $fetch['mobile'] . '
                                            </span>
                                        </p>';
                                $from = $config->getConfigFrom();
                                $to = $config->getConfigTo();
                                send_email_from_samyak($from, $to, $subject, $emailTemplate);
                                if ($count >= 10) {
                                    echo "<h6 class='text-danger'>You have reached the maximum limit for viewing contact today.</h6>";
                                    return false;
                                }
                            }
                            ?>
                            Remaining Contacts  (<?php echo $total_cnt - ($used_cnt + 1); ?>) <?php
                        } ?>

                        </p>
                        <form name="MatriForm" id="MatriForm" class="form-horizontal" action="" method="post">
                            <center>

                                <?php
                                if ($data['photo1'] != "" && $data['photo1_approve'] == 'APPROVED' &&
                                    (
                                        ($data['photo_view_status'] == '1') || ($data['photo_view_status'] == '2' && $_SESSION['mem_status'] == 'Paid')
                                    )
                                ) {
                                    ?>

                                    <img src="https://www.samyakmatrimony.com/photos/<?php echo $data['photo1']; ?>"
                                         class="img-responsive" style="margin-bottom: 10px;width: 200px;"
                                         title="<?php echo $data['username']; ?>"
                                         alt="<?php echo $data['username']; ?>">


                                    <?php
                                } elseif ($data['photo_protect'] == "Yes" && $data['photo_pswd'] != '' && isset($_SESSION['user_id'])) {

                                    if ($data['gender'] == 'Groom') {
                                        ?>

                                        <img src="../img/default-photo/photopassword_male.png"
                                             class="img-responsive" style="margin-bottom: 10px;"
                                             title="<?php echo $data['username']; ?>"
                                             alt="<?php echo $data['username']; ?>">
                                    <?php } else { ?>

                                        <img src="../img/default-photo/photopassword_female.png"
                                             class="img-responsive" style="margin-bottom: 10px;"
                                             title="<?php echo $data['username']; ?>"
                                             alt="<?php echo $data['username']; ?>">

                                    <?php }
                                } else {
                                    if ($data['gender'] == 'Groom') {
                                        ?>
                                        <img src="../img/default-photo/male-200.png"
                                             class="img-responsive" style="margin-bottom: 10px;"
                                             title="<?php echo $data['username']; ?>"
                                             alt="<?php echo $data['username']; ?>">

                                    <?php } else { ?>

                                        <img src="../img/default-photo/female-200.png"
                                             class="img-responsive" style="margin-bottom: 10px;"
                                             title="<?php echo $data['username']; ?>"
                                             alt="<?php echo $data['username']; ?>">


                                    <?php }
                                } ?>


                                <style>
                                    .myimg {
                                        height: 180px !important;
                                        width: 100% !important;
                                    }
                                </style>
                            </center>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                                            </span>
                                        <span>
                                                <?php echo $data['matri_id']; ?>
                                            </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                                            </span>
                                        <span>
                                                <?php echo $data['username']; ?>
                                            </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                                            </span>
                                        <span>
                                               <?php echo $data['mobile']; ?>
                                            </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Phone:
                                            </span>
                                        <span>
                                             <?php echo $data['phone']; ?>
                                            </span>
                                    </p>
                                    <?php if (!empty($data['time_to_call'])) { ?>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-mobile ne_mrg_ri8_10"></i>Time to call:
                                            </span>
                                            <span>
                                               <?php echo $data['time_to_call']; ?>
                                            </span>
                                        </p>
                                    <?php }
                                    $mno = $data['mobile'];

                                    $mobile = substr($mno, 0, 3);
                                    if ($mobile != '+91') {
                                        $mno = '91' . $mno;
                                    } else {
                                        $mno = substr($mno, 1, 15);
                                    }
                                    $ao3 = $fetch['height'];
                                    $ft3 = (int)($ao3 / 12);
                                    $inch3 = $ao3 % 12;
                                    $height = $ft3 . "ft" . " " . $inch3 . "in";
                                    $age = floor((time() - strtotime($fetch['birthdate'])) / 31556926);
                                    $profileKey = dechex($fetch['index_id'] * 726925);
                                    ?>
                                    <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                                <i class="fa fa-whatsapp"></i> Send Whatsapp Message:
                                            </span>
                                        <span>
                                            <a class="btn btn-sm" target="_blank" style="background-color: #25d366;"
                                               href="https://api.whatsapp.com/send?phone=<?= $mno ?>&text=We are interested in your matrimony profile, our Samyakmatrimony.com profile id <?= $fetch['matri_id'] ?>, <?= $fetch['username'] ?>, <?= $age ?> Years, <?= $height ?>, <?= $fetch['edu_name'] ?>, <?= $fetch['ocp_name'] ?> from <?= $fetch['city_name'] ?>, native from <?= $fetch['family_city'] ?>, Mobile No. <?= $fetch['mobile'] ?> / <?= $fetch['phone'] ?>. <?= urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . $profileKey) ?>%0A%0A*Note: Kindly save this number to click on the link.*"> <i
                                                        class="fa fa-whatsapp"></i> Click Here</a>
                                        </span>
                                    </p>
                                </div>
                            </div>

                        </form>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <a href="#" type="button" class="btn btn-default text-center btn-shrink"
                                       data-dismiss="modal">Close</a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <?php
                        if ($checker == 0) {
                            $sel = $DatabaseCo->dbLink->query("SELECT * FROM payments where pmatri_id='$mid'");
                            $fet = mysqli_fetch_array($sel);
                            $tot_cnt = $fet['p_no_contacts'];
                            $use_cnt = $fet['r_cnt'];
                            $use_cnt = $use_cnt + 1;
                            if ($tot_cnt >= $use_cnt) {
                                $update = "UPDATE payments SET r_cnt='$use_cnt' WHERE pmatri_id='$mid' ";
                                $_SESSION['r_cnt'] = $use_cnt;
                                $d = $DatabaseCo->dbLink->query($update);
                            }
                            $ins = $DatabaseCo->dbLink->query("insert into contact_checker (my_id,viewed_id,date, ip_address) values ('$mid','$from_id','" . date('Y-m-d H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "')");

                            $sql = "select * from sms_api where status='APPROVED'";
                            $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
                            $num_sms = mysqli_num_rows($rr);


                            if ($num_sms > 0) {

                                // Start of Sending Contact Details to the User
                                $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Contact View'");
                                $rowcs5 = mysqli_fetch_array($result45);
                                $message = $rowcs5['temp_value'];
                                $ao3 = $data['height'];
                                $ft3 = (int)($ao3 / 12);
                                $incp = $ao3 % 12;
                                $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $from_id . "'  GROUP BY a.edu_detail"));
                                $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                                $data['phone'] = ($data['phone'] != 'Not Available') ? $data['phone'] : "-";
                                $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*mob*'),
                                    array($from_id, $data['username'], floor((time() - strtotime(trim($data['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $incp . "in", $known_education['my_education'] . ",", $data['ocp_name'], $data['city_name'] . ", ", $data['mobile'] . "/" . $data['phone']), $sms_template);

                                // Final action to send sms //
                                $mno = $_SESSION['mobile'];

                                $mobile = substr($mno, 0, 3);
                                if ($mobile == '+91') {
                                    $mno = substr($mno, 3, 15);
                                }
                                if ($_SERVER['REMOTE_ADDR'] != '::1') {
                                    send_to_curl($mno, $sms_template);
                                }
                                // End of Sending Contact Details to the User

                                // Start of Sending Contact Details to the Seen User
                                $sql = $DatabaseCo->dbLink->query("select * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.matri_id='" . $mid . "'");

                                $data1 = mysqli_fetch_array($sql);

                                $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'ContactSeenBy'");
                                $rowcs5 = mysqli_fetch_array($result45);
                                $message = $rowcs5['temp_value'];
                                $ao3 = $data1['height'];
                                $ft3 = (int)($ao3 / 12);
                                $incp = $ao3 % 12;
                                $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $mid . "'  GROUP BY a.edu_detail"));
                                $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                                $data1['phone'] = ($data1['phone'] != 'Not Available') ? $data1['phone'] : "-";
                                $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*mob*'),
                                    array($mid, $data1['username'], floor((time() - strtotime(trim($data1['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $incp . "in", $known_education['my_education'] . ",", $data1['ocp_name'], $data1['city_name'] . ", ", $data1['mobile'] . "/" . $data1['phone']), $sms_template);

                                // Final action to send sms //
                                $mno = $data['mobile'];

                                $mobile = substr($mno, 0, 3);
                                if ($mobile == '+91') {
                                    $mno = substr($mno, 3, 15);
                                }
                                if ($_SERVER['REMOTE_ADDR'] != '::1') {
                                    send_to_curl($mno, $sms_template);
                                }
                                // End of Sending Contact Details to the Seen User
                            }

                            /* Contact Detail Send to User */
                            $tempData = array(
                                'myData' => (object)$data1,
                                'viewedData' => (object)$data
                            );

                            $subject = 'Viewed Contact details on Samyakmatrimony - '. $mid;
                            $template = get_email_template($DatabaseCo, $tempData, '../email-templates/view_contact_detail_email_template.php');
                            send_email_from_samyak($config->getConfigFrom(), $_SESSION['email'], $subject, $template);
                            /*End of Contact Detail Sending to User */


                            /* Intimate for the contact details Seen User  */
                            $tempData = array(
                                'myData' => (object)$data,
                                'viewedData' => (object)$data1
                            );

                            $subject = 'Your contact details seen on Samyakmatrimony';
                            $template = get_email_template($DatabaseCo, $tempData, '../email-templates/seen_contact_detail_email_template.php');
                            send_email_from_samyak($config->getConfigFrom(), $data['email'], $subject, $template);
                            /* End of Intimate for the contact details Seen User */
                        }
                        ?>
                    <?php } else {
                        ?>
                        <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                            Cannot View
                        </p>
                        <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                <p class="ne_font_weight_nrm">
                                            <span>
                                <p>&nbsp;&nbsp;You cannot view same Gender Profile contact Details.</p>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                            <a href="#" type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</a>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                } else {
                    $exp_sel = $DatabaseCo->dbLink->query("select * from expressinterest where (ei_sender='$mid' and ei_receiver='$from_id' and receiver_response ='Accept') OR (ei_sender='$from_id' and ei_receiver='$mid' and receiver_response ='Accept')");
                    $num = mysqli_num_rows($exp_sel);
                    if ($num > 0) {
                        $sel = $DatabaseCo->dbLink->query("select * from  block_profile where block_by='$from_id' and block_to='$mid'");
                        $num_block = mysqli_num_rows($sel);
                        if ($num_block > 0) { ?>
                            <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                                You are Blocked:
                            </p>
                            <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                    <p class="ne_font_weight_nrm">

                    <span>
                                    <p>&nbsp;&nbsp;This member has blocked you.You can't see his contact details.</p>
                                    </span>
                                    </p>

                                </div>
                            </div>
                            <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                                <a href="#" type="button" class="btn btn-default pull-right"
                                   data-dismiss="modal">Close</a>
                            </div>
                            <div class="clearfix"></div>
                        <?php } else {

                            /**
                             * Contact Details Privacy with Express Interest
                             */

                            $sqlData = "select * from express_interest_privacy_details where matri_id='" . $from_id . "' AND status=1 LIMIT 1";
                            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlData);
                            $dataResult = mysqli_fetch_array($DatabaseCo->dbResult);
                            if (!empty($dataResult) && count($dataResult)) {
                                $isPrivacyMatched = isPrivacyMatch($fetch, $dataResult);
                                if (!empty($isPrivacyMatched)) { ?>
                                    <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                                        You are Not allowed to see the contact details:
                                    </p>
                                    <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                                        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                            <p class="ne_font_weight_nrm">
                                            <span>
                                            <p>This person only allows to view contact
                                                to people with his/her privacy match.</p>
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                                        <a href="#" type="button" class="btn btn-default pull-right"
                                           data-dismiss="modal">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php
                                    exit;
                                }
                            }
                            ?>
                            <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">

                            <?php if ($checker != 0) {
                                echo "Contact details have been already seen.";
                            } else {
                                // Checking Monthly Limit for Showing Contacts
                                $seenContactMonthly = $DatabaseCo->getSelectQueryResult("SELECT count(my_id) as seenCountMonthly FROM contact_checker where my_id='$mid' and date(date)>='" . date('Y-m-d', strtotime('-30 days')) . "'");
                                $seenCountMonthly = mysqli_fetch_array($seenContactMonthly);
                                $count = $seenCountMonthly['seenCountMonthly'];
                                if ($fetch['request_photo_id'] != 2 && $count >= 30) { ?>
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <h6 class='text-danger text-center mb-20'>You have reached the maximum limit
                                                for
                                                viewing contact.</h6>
                                            <p class="mb-10 text-center">By verifying Photo Id Proof you can view view
                                                more
                                                contacts now.</p>

                                            <p class="text-center mb-20">**Note - To verify your Photo ID proof, kindly
                                                send
                                                your photo id proof on
                                                <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a>
                                                or
                                                click on below button to send it on WhatsApp.</p>

                                            <a target="_blank" class="btn btn-success btn-shrink btn-sm"
                                               style="background-color: #25d366; margin-bottom: 20px;"
                                               href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                                        class="fa fa-whatsapp"></i> Send Now</a>
                                        </div>
                                    </div>
                                    <?php
                                    return false;
                                }

                                $seenContact = $DatabaseCo->dbLink->query("SELECT count(my_id) as seenCount FROM contact_checker where my_id='$mid' and date(date)='" . date('Y-m-d') . "'");
                                $seenCount = mysqli_fetch_array($seenContact);
                                $count = $seenCount['seenCount'];
                                if ($count == 5 || $count == 10) {
                                    $subject = "$mid has viewed " . $seenCount['seenCount'] . " contacts";
                                    $emailTemplate = '<p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                                        </span>
                                        <span> ' . $_SESSION['user_id'] . '
                                        </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                                        </span>
                                        <span>
                                            ' . $fetch['pname'] . '
                                        </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-phone ne_mrg_ri8_10"></i>Plan Name:
                                        </span>
                                        <span>
                                         ' . $planName . '
                                        </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-phone ne_mrg_ri8_10"></i>Contacts Seen Today as on ' . date('d M, Y H:i:s') . ':
                                        </span>
                                        <span>
                                         ' . $count . '
                                        </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-phone ne_mrg_ri8_10"></i>Total Contacts Seen:
                                        </span>
                                        <span>
                                         ' . ((int)$used_cnt - 1) . '
                                        </span>
                                    </p>
                                    <p class="ne_font_weight_nrm inline">
                                        <span class="ne_mrg_ri8_10">
                                     <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                                        </span>
                                        <span>
                                           ' . $fetch['mobile'] . '
                                        </span>
                                    </p>';

                                    $from = $config->getConfigFrom();
                                    $to = $config->getConfigTo();
                                    send_email_from_samyak($from, $to, $subject, $emailTemplate);
                                    if ($count >= 10) {
                                        echo "<h6 class='text-danger'>You have reached the maximum limit for viewing contact today.</h6>";
                                        return false;
                                    }
                                }

                                ?>
                                Remaining Contacts  (<?php echo $total_cnt - $used_cnt; ?>) <?php } ?>

                            </p>
                            <form name="MatriForm" id="MatriForm" class="form-horizontal" action=""
                                  method="post">

                                <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px "
                                     style="padding-left: 8px; padding-right: 8px;">
                                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero center-text pull-right">
                                        <div class="xxl-16 xs-16 margin-bottom-15px">
                                            <center>
                                                <?php


                                                if ($data['photo1'] != "" && $data['photo1_approve'] == 'APPROVED' &&
                                                    (
                                                        ($data['photo_view_status'] == '1') || ($data['photo_view_status'] == '2' && $_SESSION['mem_status'] == 'Paid')
                                                    )
                                                ) {
                                                    ?>
                                                    <img src="https://www.samyakmatrimony.com/photos/<?php echo $data['photo1']; ?>"
                                                         style="width:150px;height:180px;">
                                                <?php } elseif ($data['gender'] == 'Groom') {
                                                    ?>
                                                    <img src="img/default-photo/male-200.png"
                                                         style="width:150px;height:180px;">
                                                <?php } else {
                                                    ?>
                                                    <img src="img/default-photo/female-200.png"
                                                         style="width:150px;height:180px;">
                                                <?php } ?>
                                                <!--<img src="img/images.jpg" style="width:150px;height:180px;">-->
                                            </center>
                                        </div>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                    </span>
                                            <span>
                    	<?php echo $data['matri_id']; ?>
                    </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                    </span>
                                            <span>
                    	<?php echo $data['username']; ?>
                    </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-home ne_mrg_ri8_10"></i>Address :
                    </span>
                                            <span>
                    	<?php echo $data['city_name'], $data['country_name']; ?>
                    </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-phone ne_mrg_ri8_10"></i>Phone:
                    </span>
                                            <span>
                     <?php echo $data['phone']; ?>
                    </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                    </span>
                                            <span>
                       <?php echo $data['mobile']; ?>
                    </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                	<span class="ne_mrg_ri8_10">
            	 <i class="fa fa-envelope ne_mrg_ri8_10"></i>Email id:
                    </span>
                                            <span>
                     <?php echo $data['email']; ?>
                    </span>
                                        </p>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                                <a href="#" type="button" class="btn btn-default pull-right"
                                   data-dismiss="modal">Close</a>
                            </div>
                            <div class="clearfix"></div>

                            <?php
                            if ($checker == 0) {
                                $sel = $DatabaseCo->dbLink->query("SELECT * FROM payments where pmatri_id='$mid'");
                                $fet = mysqli_fetch_array($sel);
                                $tot_cnt = $fet['p_no_contacts'];
                                $use_cnt = $fet['r_cnt'];
                                $use_cnt = $use_cnt + 1;
                                if ($tot_cnt >= $use_cnt) {
                                    $update = "UPDATE payments SET r_cnt='$use_cnt' WHERE pmatri_id='$mid' ";
                                    $_SESSION['r_cnt'] = $use_cnt;
                                    $d = $DatabaseCo->dbLink->query($update);
                                }
                                $ins = $DatabaseCo->dbLink->query("insert into contact_checker (my_id,viewed_id,date, ip_address) values ('$mid','$from_id','" . date('Y-m-d H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "')");

                                $sql = "select * from sms_api where status='APPROVED'";
                                $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
                                $num_sms = mysqli_num_rows($rr);
                                $sms = mysqli_fetch_object($rr);


                                if ($num_sms > 0) {

                                    // Start of Sending Contact Details to the User
                                    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Contact View'");
                                    $rowcs5 = mysqli_fetch_array($result45);
                                    $message = $rowcs5['temp_value'];
                                    $ao3 = $data['height'];
                                    $ft3 = (int)($ao3 / 12);
                                    $incp = $ao3 % 12;
                                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $from_id . "'  GROUP BY a.edu_detail"));
                                    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                                    $data['phone'] = ($data['phone'] != 'Not Available') ? $data['phone'] : "-";
                                    $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*mob*'),
                                        array($from_id, $data['username'], floor((time() - strtotime(trim($data['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $incp . "in", $known_education['my_education'] . ",", $data['ocp_name'], $data['city_name'] . ", ", $data['mobile'] . "/" . $data['phone']), $sms_template);

                                    // Final action to send sms //
                                    $mno = $_SESSION['mobile'];

                                    $mobile = substr($mno, 0, 3);
                                    if ($mobile == '+91') {
                                        $mno = substr($mno, 3, 15);
                                    }
                                    if ($_SERVER['REMOTE_ADDR'] != '::1') {
                                        send_to_curl($mno, $sms_template);
                                    }
                                    // End of Sending Contact Details to the User

                                    // Start of Sending Contact Details to the Seen User
                                    $sql = $DatabaseCo->dbLink->query("select * from register_view where matri_id='" . $mid . "'");

                                    $data1 = mysqli_fetch_array($sql);

                                    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'ContactSeenBy'");
                                    $rowcs5 = mysqli_fetch_array($result45);
                                    $message = $rowcs5['temp_value'];
                                    $ao3 = $data1['height'];
                                    $ft3 = (int)($ao3 / 12);
                                    $incp = $ao3 % 12;
                                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $mid . "'  GROUP BY a.edu_detail"));
                                    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);
                                    $data1['phone'] = ($data1['phone'] != 'Not Available') ? $data1['phone'] : "-";
                                    $sms_template = str_replace(array('*profile*', '*name*', '*age*', '*height*', '*qualification*', '*profession*', '*city*', '*mob*'),
                                        array($from_id, $data1['username'], floor((time() - strtotime(trim($data1['birthdate']))) / 31556926) . " years", $ft3 . "ft" . " " . $incp . "in", $known_education['my_education'] . ",", $data1['ocp_name'], $data1['city_name'] . ", ", $data1['mobile'] . "/" . $data1['phone']), $sms_template);

                                    // Final action to send sms //
                                    $mno = $data['mobile'];

                                    $mobile = substr($mno, 0, 3);
                                    if ($mobile == '+91') {
                                        $mno = substr($mno, 3, 15);
                                    }
                                    if ($_SERVER['REMOTE_ADDR'] != '::1') {
                                        send_to_curl($mno, $sms_template);
                                    }
                                    // End of Sending Contact Details to the Seen User
                                }

                                /* Contact Detail Send to User */
                                $tempData = array(
                                    'myData' => (object)$data1,
                                    'viewedData' => (object)$data
                                );

                                $subject = 'Viewed Contact details on Samyakmatrimony - '.$mid;
                                $template = get_email_template($DatabaseCo, $tempData, '../email-templates/view_contact_detail_email_template.php');
                                send_email_from_samyak($config->getConfigFrom(), $_SESSION['email'], $subject, $template);
                                /*End of Contact Detail Sending to User */


                                /* Intimate for the contact details Seen User  */
                                $tempData = array(
                                    'myData' => (object)$data,
                                    'viewedData' => (object)$data1
                                );

                                $subject = 'Your contact details seen on Samyakmatrimony';
                                $template = get_email_template($DatabaseCo, $tempData, '../email-templates/seen_contact_detail_email_template.php');
                                send_email_from_samyak($config->getConfigFrom(), $data['email'], $subject, $template);
                                /* End of Intimate for the contact details Seen User */
                            }
                            ?>
                        <?php }
                    } else { ?>
                        <p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                            Only Express Interest Accepted :
                        </p>
                        <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                <p class="ne_font_weight_nrm">

                    <span>
                                <p>&nbsp;&nbsp;This member only shows his/her contact details if you have already sent
                                    him/her express interest, and he/she has accepted it.</p>
                                </span>
                                </p>

                            </div>
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                <p class="ne_font_weight_nrm">

                    <span>
                                <p style="color:red;">&nbsp;&nbsp;Please send him/her express interest if you are
                                    interested</p>
                                </span>
                                </p>

                            </div>

                        </div>
                        <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                            <a href="#" type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</a>
                        </div>
                        <div class="clearfix"></div>
                    <?php }
                }
            } else {
                if (!empty($_SESSION['plan_id']) && $_SESSION['plan_id'] == '35') { ?>
                    </div>
                    <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member"
                          method="post">
                        <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                <p class="ne_font_weight_nrm">

                    <span>
                                <p class="text-center text-danger">Your view contact details limit reached.</p>

                                <p class="text-center text-danger mt-10">Please contact admin for more details.</p>

                                </span>

                            </div>
                        </div>
                    </form>
                    <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                        <a href="#" type="button" style="padding: 2px 10px;" class="btn btn-sm btn-default pull-right"
                           data-dismiss="modal">Close</a>
                    </div>
                    <div class="clearfix"></div>
                <?php } else {
                    ?><p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                        Buy Contacts View
                    </p>
                    </div>
                    <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member"
                          method="post">
                        <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                <p class="ne_font_weight_nrm">

                    <span>
                                <p class="text-center">Rs. 750 for 25 Contacts/50 messages.</p>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-shrink btn-danger text-center" type="button"
                                                style="background-color: #D60D45;padding: 2px 10px;"
                                                onclick="window.open('https://imjo.in/R58f2T', '_blank')">Buy Now
                                        </button>
                                    </div>
                                </div>

                                <p class="text-center mt-10">Rs. 1500 for 50 Contacts/100 messages.</p>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-shrink btn-danger text-center" type="button"
                                                style="background-color: #D60D45;padding: 2px 10px;"
                                                onclick="window.open('https://imjo.in/VpJQYB', '_blank')">Buy Now
                                        </button>
                                    </div>
                                </div>
                                </span>

                            </div>
                        </div>
                    </form>
                    <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
                        <a href="#" type="button" style="padding: 2px 10px;" class="btn btn-sm btn-default pull-right"
                           data-dismiss="modal">Close</a>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
            }

        } else { ?><p class="modal-title text-center ne_font_weight_nrm font-orange mb-10" id="myModalLabel"
                      style="font-weight: bold;">
            Upgrade Your Membership to view contacts.
        </p>
            <div class="row">
                <div class="col-xs-6 text-center">
                    <button class="btn btn-sm btn-shrink btn-danger" type="button" style="background-color: #D60D45;"
                            onclick="redirect_to_payment();">Upgrade Now
                    </button>
                </div>
                <div class="col-xs-6 text-center">
                    <button type="button" class="btn btn-sm btn-shrink" data-dismiss="modal">Close</button>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php }
    } else {
        ?><p class="modal-title text-center ne_font_weight_nrm font-orange mb-10" id="myModalLabel"
             style="font-weight: bold;">
            Upgrade Your Membership to view contacts.
        </p>
        <div class="row">
            <div class="col-xs-6 text-center">
                <button class="btn btn-sm btn-shrink btn-danger" type="button" style="background-color: #D60D45;"
                        onclick="redirect_to_payment();">Upgrade Now
                </button>
            </div>
            <div class="col-xs-6 text-center">
                <button type="button" class="btn btn-sm btn-shrink" data-dismiss="modal">Close</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php
    }
} /* Main if else*/
else { ?><p class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
    Please Login :
</p>
    <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
            <p class="ne_font_weight_nrm">
                    <span>
            <p>&nbsp;&nbsp;Please Login to access this feature.</p>
            </span>
            </p>
        </div>
    </div>
    <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
        <a href="#" type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</a>
    </div>
    <div class="clearfix"></div>

    <?php

}

function isPrivacyMatch($userDetails, $privacyDetails)
{
    $result = [];
    if (!empty($privacyDetails['looking_for']) &&
        !in_array($userDetails['m_status'], explode(",", $privacyDetails['looking_for']))) {
        $result['error'][] = "Marital Status not matched.";
    }
    if (!empty($privacyDetails['religion']) &&
        !in_array($userDetails['religion'], explode(",", $privacyDetails['religion']))) {
        $result['error'][] = "Religion not matched.";
    }
    if (!empty($privacyDetails['age_from']) && !empty($privacyDetails['age_to']) &&
        !(floor((time() - strtotime($userDetails['birthdate'])) / 31556926) >= $privacyDetails['age_from'] &&
            floor((time() - strtotime($userDetails['birthdate'])) / 31556926) <= $privacyDetails['age_to'])) {
        $result['error'][] = "Age not matched.";
    }
    if (!empty($privacyDetails['height_from']) && !empty($privacyDetails['height_to']) &&
        !($userDetails['height'] >= $privacyDetails['height_from'] && $userDetails['height'] <= $privacyDetails['height_to'])) {
        $result['error'][] = "Height not matched.";
    }
    if (!empty($privacyDetails['edu_level']) &&
        !in_array($userDetails['e_level'], explode(",", $privacyDetails['edu_level']))) {
        $result['error'][] = "Education level not matched.";
    }
    if (!empty($privacyDetails['edu_field']) &&
        !in_array($userDetails['e_field'], explode(",", $privacyDetails['edu_field']))) {
        $result['error'][] = "Education field not matched.";
    }
    if (!empty($privacyDetails['with_photo']) && $privacyDetails['with_photo'] == 1 &&
        !((!empty($userDetails['photo1']) && $userDetails['photo1_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo2']) && $userDetails['photo2_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo3']) && $userDetails['photo3_approve'] == 'APPROVED') ||
            (!empty($userDetails['photo4']) && $userDetails['photo4_approve'] == 'APPROVED'))) {
        $result['error'][] = "Photo is required.";
    }

    return $result;
}

?>
