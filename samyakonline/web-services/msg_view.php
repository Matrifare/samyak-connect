<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/18/2018
 * Time: 12:50 AM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();
$mid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$to_id = isset($_POST['toId']) ? $_POST['toId'] : 0;

$select = "select r.index_id, r.matri_id, r.username, r.birthdate, r.height, r.edu_name, r.ocp_name, r.city_name, r.family_city,
 r.mobile, r.phone, r.request_photo_id, p.p_msg, p.r_sms, p.exp_date from register_view r INNER JOIN payment_view p
  on r.matri_id=p.pmatri_id where pmatri_id='$mid'";
$exe = $DatabaseCo->dbLink->query($select) or die(mysqli_error($DatabaseCo->dbLink));
$fetch = mysqli_fetch_array($exe);

$total_msg = $fetch['p_msg'];
$used_msg = $fetch['r_sms'];

$exp_date = date('Y-m-d', strtotime($fetch['exp_date']));
$today = date('Y-m-d');

if ($_SESSION['user_id'] != '') {

    if ((($total_msg - $used_msg) > 0 && strtotime($exp_date) > strtotime($today)) ||
        $_SESSION['mem_status'] == 'Paid') {

        // Checking Monthly Limit for Showing Contacts
        $seenContactMonthly = $DatabaseCo->getSelectQueryResult("SELECT count(my_id) as seenCountMonthly FROM contact_checker where my_id='$mid' and date(date)>='" . date('Y-m-d', strtotime('-30 days')) . "'");
        $seenCountMonthly = mysqli_fetch_array($seenContactMonthly);
        $count = $seenCountMonthly['seenCountMonthly'];
        if ($fetch['request_photo_id'] != 2 && $count >= 30) { ?>
            <script>
                $(function () {
                    $("#sendMsgModal .modal-dialog").removeClass("modal-sm").addClass("modal-md");
                })
            </script>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h6 class='text-danger text-center mb-20'>You have reached the maximum limit.</h6>
                    <p class="mb-10 text-center">By verifying Photo Id Proof you can send more
                        messages now.</p>

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
            <div class="clearfix"></div>
            <?php
            return false;
        } else { ?>
            <div class="pa-20">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div class="label label-danger">Balance SMS: <?= $total_msg - $used_msg ?></div>
                    </div>
                </div>
                <h5 class="text-center text-muted">Send Message to <?= $to_id ?></h5>
                <form method="post" action="#" id="send_message_form" class="form-horizontal">
                    <div class="form-group text-center">
                        <input type="radio" checked name="type" value="sms" onclick="msgViewChange('sms')"/> Send SMS
                        <input type="radio" name="type" value="message" onclick="msgViewChange('message')"/> Send
                        Message
                    </div>
                    <p class="text-danger" id="response_text"></p>
                    <div class="form-group show-form-sms">
                        <p style="font-size: 11px;">
                            <?php
                            $ao3 = $fetch['height'];
                            $ft3 = (int)($ao3 / 12);
                            $inch3 = $ao3 % 12;
                            $height = $ft3 . "ft" . " " . $inch3 . "in";
                            $age = floor((time() - strtotime($fetch['birthdate'])) / 31556926);

                            echo "Samyakmatrimony profile {$mid} is interested in your profile, {$fetch['username']},
                         {$age} Years, {$height}, {$fetch['edu_name']}, {$fetch['ocp_name']} from {$fetch['city_name']},
                          native from {$fetch['family_city']}, Mobile No {$fetch['mobile']}/{$fetch['phone']}.
                          Click to <a target='_blank' href='view_profile?userId=" . $fetch['matri_id'] . "' title='View Profile Link'>View Profile</a>";
                            ?>
                        </p>
                    </div>
                    <div class="form-group show-form-message">
                    <textarea name="msg_text" id="msg_text" class="form-control" rows="4"
                              placeholder="Type your message here.."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-center">
                            <input type="hidden" name="toId" value="<?= $to_id ?>"/>
                            <input type="hidden" name="msg_status" value="sent_msg"/>
                            <?php
                            if ($_SESSION['membership'] == 'Free') { ?>
                                <button class="btn btn-xs btn-shrink btn-danger" type="button"
                                        style="background-color: #D60D45;"
                                        onclick="redirect_to_payment();">Upgrade Now
                                </button>
                            <?php } else { ?>
                                <button type="submit" id="sendMessageBtn" name="send_msg"
                                        class="btn btn-shrink btn-xs btn-danger">Send SMS
                                </button>
                            <?php }
                            ?>
                        </div>
                        <div class="col-xs-6 text-center">
                            <button type="button" class="btn btn-xs btn-shrink" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
    } else {
        ?>
        <p class="modal-title text-center ne_font_weight_nrm font-orange mb-10" id="myModalLabel"
           style="font-weight: bold;">
            Upgrade Membership to send messages.
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
}
?>
<script>
    $(function(){
        $("#sendMsgModal .modal-dialog").addClass("modal-sm").removeClass("modal-md");
    })
</script>
