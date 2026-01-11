<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/10/2018
 * Time: 9:03 PM
 */
@include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
$mid = $_SESSION['user_id'];
$sql = mysqli_fetch_array(mysqli_query($DatabaseCo->dbLink, "select mobile, mobile_verify_status from register where matri_id='$mid'"));
$mobile = $sql['mobile'];
$mno = substr($mobile, 0, 3);
if ($mno == '+91') {
    $mobile = substr($mobile, 3, 15);
}
if (!empty($sql['mobile_verify_status']) && $sql['mobile_verify_status'] == 'No') {
    ?>

    <!-- BEGIN # MODAL LOGIN -->
    <div class="modal fade modal-login modal-border-transparent" id="mobileModal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="clear"></div>

                <!-- Begin # DIV Form -->
                <div id="modal-mobile-form-wrapper">

                    <!-- Begin | Mobile Verification Form -->
                    <form id="mobile-form">
                        <div class="modal-body pb-10">

                            <h4 class="text-center mb-15">Mobile Verification</h4>
                            <div id="mobile_area">
                                <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-xs-10 col-sm-10 old-mobile" style="margin-right: 0px;">
                                            <input id="mobile_verification" class="form-control mb-5" type="text"
                                                   placeholder="Enter Your Mobile Number"
                                                   value="<?= $sql['mobile'] ?? "" ?>" readonly>
                                        </div>
                                        <div class="col-xs-10 col-sm-10 new-mobile-no" id="new-mobile"
                                             style="margin-right: 0px; display: none;">
                                            <input id="new-mobile-input" class="form-control mb-5" type="text"
                                                   placeholder="Enter Your Mobile Number" value="">
                                        </div>
                                        <div class="col-xs-2 col-sm-2 text-left">
                                    <span style="" class="edit_btn" title="Click to Edit Mobile Number">
                                        <i class="fa fa-2x fa-pencil text-danger"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-danger" type="button" id="new-mobile-btn"
                                            style="display: none;">
                                        Update Mobile
                                    </button>
                                    <button class="btn btn-danger" type="button" id="sendOTP">Send OTP</button>
                                    <button class="btn btn-warning" type="button" id="backToOTP">Back to Enter OTP
                                    </button>
                                </div>
                            </div>
                            <div id="otp_area" style="display: none;">
                                <div class="text-center mb-5">
                                    <label class="label label-info">OTP has been sent on <?= substr($mobile, 0, 3) ?>
                                        XXX<?= substr($mobile, -4) ?></label>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-xs-10 col-sm-10 old-mobile" style="margin-right: 0px;">
                                            <input id="otp_code" class="form-control mb-5" name="varify_code"
                                                   type="text"
                                                   placeholder="Enter OTP">
                                        </div>
                                        <div class="col-xs-2 col-sm-2 text-left">
                                    <span style="" class="edit_btn1" title="Click to Edit Mobile Number">
                                        <i class="fa fa-2x fa-pencil text-danger"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-danger" type="button" name="verify_otp" id="verify_otp">
                                        Submit
                                    </button>
                                </div>
                                <p>Send whatsapp message to verify : <a
                                            href="https://api.whatsapp.com/send?phone=917977993616&text=Hello *Samyakmatrimony Admin*,%0A%0AMy Matri ID: <?= $_SESSION['user_id'] ?>%0A%0APlease verify my mobile number.">Click
                                        Here</a></p>

                                <p>Please check your email for completing verification of email and upload your Photo ID
                                    proof for profile activation.</p>
                                <p>Please wait for some time for profile activation once verification done.</p>
                            </div>

                        </div>
                    </form>
                    <!-- End | Mobile Verification Form -->

                </div>
                <!-- End # DIV Form -->

            </div>
        </div>
    </div>
    <!-- END # MODAL LOGIN -->

    <script>
        $(function () {
            $("#mobileModal").modal("show");
            $(".edit_btn").click(function () {
                $("#new-mobile-input").val("");
                $(".old-mobile").slideToggle('slow');
                $(".new-mobile-no").slideToggle('slow');
                $("#new-mobile-btn").slideToggle('slow');
                $("#sendOTP").slideToggle('slow');
                $("#backToOTP").slideToggle('slow');
                $("#new-mobile-input").focus();
            });
            $(".edit_btn1").click(function () {
                $("#mobile_area").slideToggle('slow');
                $("#otp_area").slideToggle('slow');
            });
            $("#new-mobile-input").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            $("#new-mobile-btn").click(function (e) {
                $("#loader-animation-area").show();
                if ($("#new-mobile-input").val().length == 10) {
                    $.ajax({
                        type: 'POST',
                        url: "web-services/change_mobile_no",
                        data: {
                            "matriId": "<?= $mid ?>",
                            "mobileNo": $("#new-mobile-input").val(),
                        },
                        dataType: "json",
                        success: function (data) {
                            if ($.trim(data.result) == "true") {
                                alert("Mobile No Successfully Updated");
                                $("#mobile_verification").val($.trim(data.mobileNo));
                                $(".old-mobile").slideToggle('slow');
                                $(".new-mobile-no").slideToggle('slow');
                                $("#new-mobile-btn").slideToggle('slow');
                                $("#sendOTP").slideToggle('slow');
                            } else {
                                alert("Some Error Occurred");
                            }
                        },
                        complete: function () {
                            $("#loader-animation-area").hide();
                        }
                    });
                } else {
                    alert("Invalid Mobile No");
                }
            });

            $("#sendOTP").click(function (e) {
                $("#loader-animation-area").show();
                $.ajax({
                    type: 'POST',
                    url: "web-services/send_otp",
                    data: {
                        "otp_send": "true",
                    },
                    dataType: "json",
                    success: function (data) {
                        if ($.trim(data.result) == "success") {
                            alert("OTP Sent Successfully");
                            $("#mobile_area").slideToggle('slow');
                            $("#otp_area").slideToggle('slow');
                        } else {
                            alert("Something went wrong, kindly contact to Administrator");
                        }
                    },
                    complete: function () {
                        $("#loader-animation-area").hide();
                    }
                });
            });

            $("#backToOTP").click(function (e) {
                $("#mobile_area").slideToggle('slow');
                $("#otp_area").slideToggle('slow');
            });

            $("#verify_otp").click(function (e) {
                $("#loader-animation-area").show();
                $.ajax({
                    type: 'POST',
                    url: "web-services/send_otp",
                    data: {
                        "verify_otp": "true",
                        "otp_code": $("#otp_code").val(),
                    },
                    dataType: "json",
                    success: function (data) {
                        if ($.trim(data.result) == "success") {
                            alert('OTP verified successfully.');
                            alert('By verifying email address, mobile number, and Photo Id Proof trust score will be increased. Profile having good trust score gets more interest from other users.');
                            window.location.reload();
                        } else if ($.trim(data.result) == "password") {
                            alert("Invalid OTP, please try again");
                        } else {
                            alert("Something went wrong, kindly contact to Administrator");
                        }
                    },
                    complete: function () {
                        $("#loader-animation-area").hide();
                    }
                });
            });

            $("#sendOTP").trigger("click");
        });
    </script>
    <?php
} else {
    unset($_SESSION['last_login']);
}