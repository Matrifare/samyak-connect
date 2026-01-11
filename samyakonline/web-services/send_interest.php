<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/10/2018
 * Time: 1:10 AM
 */
include_once '../DatabaseConnection.php';
include_once '../auth.php';
include_once '../lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();
$mid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$from_id = isset($_REQUEST['frmid']) ? $_REQUEST['frmid'] : 0;

$select = "select * from payments where pmatri_id='$mid'";
$exe = mysqli_query($DatabaseCo->dbLink, $select) or die(mysqli_error($DatabaseCo->dbLink));
$fetch = mysqli_fetch_array($exe);

$exp_date = date('Y-m-d', strtotime($fetch['exp_date']));
$today = date('Y-m-d');

if ($_SESSION['user_id'] != '') {
    if ($exp_date > $today) {

        $sel = $DatabaseCo->dbLink->query("select * from  block_profile where block_by='$from_id' and block_to='$mid'");

        $num_block = mysqli_num_rows($sel);
        if ($num_block > 0) {
            ?>
            <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member" method="post">
                <div class="form-group">
                    <div class="col-sm-12">
                        <h4>This member has blocked you.You can't express your interest.</h4>
                    </div>
                </div>
            </form>
        <?php } else {
            $sel = $DatabaseCo->dbLink->query("select * from expressinterest where ei_sender='$mid' and ei_receiver='$from_id'
                            AND trash_sender='No' AND trash_receiver='No' UNION 
                            select * from expressinterest where ei_sender='$from_id' and ei_receiver='$mid'
                            AND trash_sender='No' AND trash_receiver='No' LIMIT 1 ");

            $num_block = mysqli_num_rows($sel);
            if ($num_block < 1) {
                $sqlInterestPrivacy = $DatabaseCo->dbLink->query("select gender,birthdate,m_status from `register_view` where `matri_id`='$from_id'");
                $interestPrivacy = mysqli_fetch_array($sqlInterestPrivacy);
                $isInterestCheckPassed = checkPrivacyBeforeInterestSend($interestPrivacy);
                if ($isInterestCheckPassed == FALSE) {
                    if (!empty($_SESSION['askPhotoId']) && $_SESSION['askPhotoId']) { ?>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4 class='text-danger text-center mb-20 font-weight-bold'>You cannot send the express
                                    interest.</h4>
                                <p class="mb-10 text-center font-weight-bold">By verifying Photo Id Proof you can send
                                    interest to this member.</p>

                                <p class="text-center mb-20">**Note - To verify your Photo ID proof, kindly send
                                    your photo id proof on
                                    <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or
                                    click on below button to send it on WhatsApp.</p>

                                <a target="_blank" class="btn btn-success btn-shrink btn-sm"
                                   style="background-color: #25d366; margin-bottom: 20px;"
                                   href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i
                                            class="fa fa-whatsapp"></i> Send Now</a>
                                <a href="#" type="button" class="btn btn-sm btn-default mb-20" data-dismiss="modal">Close</a>
                            </div>
                        </div>
                    <?php } else if (!empty($_SESSION['askUpgradePlan']) && $_SESSION['askUpgradePlan']) { ?>
                        <p class="modal-title text-center ne_font_weight_nrm font-orange mb-10" id="myModalLabel"
                           style="font-weight: bold;">
                            Upgrade Your Membership to send Express Interests.
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
                    <?php } else { ?>
                        <h6 class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
                            You cannot send express interest
                        </h6>
                        <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member"
                              method="post">
                            <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                                    <p class="text-left">
                                        The settings of privacy of this member does not allow you to send the express interest to him/her.
                                        <br/>
                                        You need to contact administrator to send the privacy interests
                                        for
                                        these type of members.</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="https://api.whatsapp.com/send?phone=919819886759&text=Hello My Name is *<?= $_SESSION['uname'] ?> [<?= $_SESSION['user_id'] ?>]*%0APlease allow my express interest privacy to send express interests to all the members."
                                   type="button" class="btn btn-sm btn-success pull-left">Contact Now</a>
                                <a href="#" type="button" class="btn btn-sm btn-default pull-right"
                                   data-dismiss="modal">Close</a>
                            </div>
                        </form>
                    <?php }
                } else { ?>
                    <div class="xxl-16 xl-16 m-16 l-16 s-16 xs-16" id="ExpressLabel">
                        Express Interest
                    </div>
                    <div class="clearfix"></div>
                    <form name="MatriForm" id="MatriForm" class="form-horizontal" action="" method="post">
                        <div class="modal-body xxl-16 xl-16 m-16 l-16 s-16 xs-16">

                            <input type="hidden" name="ExmatriId" id="ExmatriId" value="<?php echo $from_id; ?>"/>
                            <div class="xxl-16 xl-16 l-16 s-16 m-16 xs-16 margin-top-10px-320px margin-top-10px-480px ne-mrg-top-10-768 margin-top-10px-999">

                                <ul class="list-unstyled">
                                    <li><input name="exp_interest" class="radio-inline" type="radio" checked
                                               value="You seem to be the kind of person who suits our family. Please accept if you are interested.">
                                        You seem to be the kind of person who suits our family. Please accept if you
                                        are
                                        interested.
                                    </li>
                                    <li><input name="exp_interest" class="radio-inline" type="radio"
                                               value="Your profile matches my sister's/brother's profile. Please ' accept ' if you are interested.">
                                        Your profile matches my sister's/brother's profile. Please 'accept' if you
                                        are
                                        interested.
                                    </li>
                                    <li><input name="exp_interest" class="radio-inline" type="radio"
                                               value="Our children's profile seems to match. Please 'Accept' if you are interested">
                                        Our children's profile seems to match. Please 'Accept' if you are interested
                                    </li>
                                    <li><input name="exp_interest" class="radio-inline" type="radio"
                                               value="Your profile suitable to matches. Please 'Accept' if you are interested.">
                                        Your profile suitable to matches. Please 'Accept' if you are interested.
                                    </li>
                                </ul>

                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-sm-offset-6 col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6"><input type="hidden" name="ExmatriId"
                                                                          id="ExmatriId"
                                                                          value="<?php echo $from_id; ?>"/>
                                        <button type="button" class="btn btn-sm btn-block"
                                                style="background-color: lightgray;" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <button type="button" name="send-interest" value="submit"
                                                class="btn btn-sm btn-block" style="background-color: #D60D45;"
                                                id="go_go_go">Send Interest
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>

                    <?php
                }
            } else { ?>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="margin-top:5px;">
                    <i class="glyphicon glyphicon-remove-circle" style="display:block;"></i>
                </button>
                <?php
                $expressResult = mysqli_fetch_object($sel);
                if ($expressResult->receiver_response == 'Pending') {
                    if ($expressResult->ei_sender == $mid) { ?>
                        <span style="color: #0a77d5; font-weight: bold"> You had already sent an express interest to this member.</span>
                    <?php } else { ?>
                        <span style="color: #0a77d5; font-weight: bold"> Express interest of this member is pending by your side.</span>
                    <?php }
                } else if ($expressResult->receiver_response == 'Accept') {
                    if ($expressResult->ei_sender == $mid) { ?>
                        <span style="color: green; font-weight: bold"> Your express interest has been accepted by this member.</span>
                        <p class="mt-5">You can view the contact details or send message to this member now.</p>
                        <div class="action-btn mt-10">
                            <button class="btn btn-xs btn-danger" data-dismiss="modal"
                                    onclick="getContactDetail('<?= $expressResult->ei_receiver ?>');">View Contact
                            </button>
                            <button class="btn btn-xs btn-primary" data-dismiss="modal"
                                    onclick="view_message_box('<?= $expressResult->ei_receiver ?>');">Message Now
                            </button>
                        </div>
                    <?php } else { ?>
                        <span style="color: green; font-weight: bold"> You have already accepted express interest by this member.</span>
                        <p class="mt-5">You can view the contact details or send message to this member now.</p>
                        <div class="action-btn mt-10">
                            <button class="btn btn-xs btn-danger" data-dismiss="modal"
                                    onclick="getContactDetail('<?= $expressResult->ei_sender ?>');">View Contact
                            </button>
                            <button class="btn btn-xs btn-primary" data-dismiss="modal"
                                    onclick="view_message_box('<?= $expressResult->ei_sender ?>');">Message Now
                            </button>
                        </div>
                    <?php }
                } else if ($expressResult->receiver_response == 'Reject') {
                    if ($expressResult->ei_sender == $mid) { ?>
                        <span style="color: red; font-weight: bold"> Your express interest has been rejected by this member.</span>
                    <?php } else { ?>
                        <span style="color: red; font-weight: bold"> Your have rejected the express interest of this member.</span>
                    <?php }
                } else if ($expressResult->receiver_response == 'Hold') {
                    if ($expressResult->ei_sender == $mid) { ?>
                        <span style="color: orange; font-weight: bold"> Your had already sent the express interest and it has been neither accepted nor rejected by this member, instead, the member chosen to decide later.</span>
                    <?php } else { ?>
                        <span style="color: orange; font-weight: bold"> You have chosen to decide later this express interest.</span>
                        <button class="btn btn-xs btn-primary"
                                onclick="window.location.href='express-interest#tab_2-04'">
                            Respond Now
                        </button>
                    <?php }
                }
            }
        }
    } else {
        ?>
        <h4 class="modal-title ne_font_weight_nrm font-orange" id="myModalLabel">
            Upgrade Your Membership :
        </h4>
        </div>
        <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member" method="post">
            <div class="modal-body xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px">
                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                    <h3 class="ne_font_weight_nrm">

                    <span>
                    	<h4>&nbsp;&nbsp;You are not a paid member, Please upgrade your membership to express the interest.</h4>
                    </span>
                    </h3>

                </div>
            </div>
            <div class="modal-footer">
                <a href="premium_member" type="button" class="btn btn-default pull-left">Upgrade Now</a>
            </div>
        </form>
        <div class="modal-footer  xxl-16 xl-16 l-16 m-16 s-16 xs-16">
            <a href="#" type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</a>
        </div>
        <?php
    }


} else { ?>
    <form name="MatriForm" id="MatriForm" class="form-horizontal" action="premium_member" method="post">
        <div class="form-group">
            <div class="col-sm-12">
                <h4>&nbsp;&nbsp;Please Login to access this feature.</h4>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-10">
                <button class="btn btn-success" formaction="login">Login Now</button>
            </div>
        </div>
    </form>

    <?php
}
?>

    <script type="text/javascript">
        $('#go_go_go').click(function () {
            var dataString = $("#MatriForm").serialize();
            $.ajax({
                url: "web-services/admit_interest",
                type: "POST",
                data: dataString,
                cache: false,
                beforeSend: function () {
                    $("#go_go_go").attr("disabled", "disabled");
                },
                success: function (response) {
                    $("#ExpressLabel").fadeOut('fast');
                    $("#MatriForm").html('');
                    $('#MatriForm').html(response);
                }
            });
        })
    </script>
<?php
function checkPrivacyBeforeInterestSend($interestPrivacy)
{
    $_SESSION['askPhotoId'] = false;
    $_SESSION['askUpgradePlan'] = false;
    $isOtherThanUnMarried = ($_SESSION['marital_status'] == 'Unmarried') ? FALSE : TRUE;
    $gender = $_SESSION['gender123'];
    $photoIdRequested = $_SESSION['request_photo_id'];
    $membership = $_SESSION['membership'];
    $sendExpressInterestCondition = $_SESSION['send_interest_condition'] ?? "none";
    $senderDate = new DateTime(date('Y-m-d', strtotime($_SESSION['birthdate'])));
    $receiverDate = new DateTime(date('Y-m-d', strtotime($interestPrivacy['birthdate'])));

    if ($membership == 'Free' && $photoIdRequested != 2) {
        $_SESSION['askPhotoId'] = true;
        return false;
    } else if ($gender == 'Bride' && $membership != 'Free') {
        return true; //Brides can send interests directly
    } else if ($membership == 'Free' && $sendExpressInterestCondition == 'upgrade_plan') {
        $_SESSION['askUpgradePlan'] = true;
        return false;
    } else if ($membership != 'Free' &&
        $gender == 'Groom' &&
        !$isOtherThanUnMarried &&
        $photoIdRequested != 2 &&
        $_SESSION['adminrole_view_status'] == 'Yes' &&
        (($senderDate > $receiverDate &&
                strtotime($_SESSION['birthdate']) - strtotime($interestPrivacy['birthdate']) >= 315619200)
            || in_array($interestPrivacy['m_status'], ['Divorcee', 'Widow/Widower', 'Separated']))) {
        $_SESSION['askPhotoId'] = true;
        return false;
    } else if ($isOtherThanUnMarried && in_array($interestPrivacy['m_status'], ['Divorcee', 'Widow/Widower', 'Separated'])) {
        return true;    //Can send interest
    } else if ($gender == 'Groom' &&
        !$isOtherThanUnMarried &&
        $photoIdRequested != 2 &&
        ($senderDate > $receiverDate ||
            strtotime($_SESSION['birthdate']) - strtotime($interestPrivacy['birthdate']) >= 315619200
            || in_array($interestPrivacy['m_status'], ['Divorcee', 'Widow/Widower', 'Separated'])) &&
        $_SESSION['adminrole_view_status'] == 'Yes') {
        $_SESSION['askPhotoId'] = true;
        return false;
    } else if ($gender == 'Groom' && $isOtherThanUnMarried && $_SESSION['adminrole_view_status'] == 'Yes' &&
        ($interestPrivacy['m_status'] == 'Unmarried' ||
            ($senderDate > $receiverDate &&
                strtotime($_SESSION['birthdate']) - strtotime($interestPrivacy['birthdate']) >= 315619200))) {
        return false;
    }
    return true;
}