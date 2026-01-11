<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/16/2018
 * Time: 8:00 PM
 */
?>

<div class="home_screen_popup pt-10">
    <div class="row">
        <div class="col-xs-12">
            <h5 class="text-center">Add to Home screen to create App</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <button class="btn btn-danger mr-10" id="btnAddHomeScreen" style="text-transform: capitalize;letter-spacing: 1px;">Add to Create App</button>
            <button class="btn btn-muted" id="btnCloseHomeScreen" style="text-transform: capitalize;letter-spacing: 1px;">Dismiss</button>
        </div>
    </div>
</div>
<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-login modal-border-transparent" data-backdrop="static" data-keyboard="false"
     id="loginModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>

            <div class="clear"></div>

            <!-- Begin # DIV Form -->
            <div id="modal-login-form-wrapper">

                <!-- Begin | Lost Password Form -->
                <form id="lost-form">
                    <div class="modal-body pb-10">

                        <h4 class="text-center mb-15">Forgot password</h4>

                        <div class="text-center"><b>Using <a href="forgot-password" title="Forgot Password"> Mobile
                                    No</a> or
                                <a href="javascript:void(0);" class="" onclick="$('#forgot_password_area').slideToggle();">
                                    Email </a></b></div>
                        <div id="forgot_password_area">
                            <div class="form-group mb-0">
                                <input id="lost_email" name="lost_email" class="form-control mb-5" type="text"
                                       placeholder="Enter Your Email" required>
                            </div>
                            <div class="row gap-10">
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"
                                            aria-label="Close">Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer pt-25 pb-5">
                        <div class="row gap-10">
                            <div class="col-xs-12"><p class="text-center" id="response_forgot_password"></p></div>
                        </div>
                        <div class="text-center">
                            <a href="login" id="lost_login_btn" type="button" class="btn btn-link">Sign-in</a>
                            or
                            <a href="register" id="lost_register_btn" type="button" class="btn btn-link">Register</a>
                        </div>


                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-xss-12 text-center">
                            <p>
                                Reset password on WhatsApp <i class="fa fa-whatsapp"></i> <a style="font-weight: bold;" href="https://api.whatsapp.com/send?phone=919819886759&text=Please Reset my password">Click Here</a>
                            </p>
                        </div>
                    </div>

                </form>
                <!-- End | Lost Password Form -->

            </div>
            <!-- End # DIV Form -->

        </div>
    </div>
</div>
<!-- END # MODAL LOGIN -->


<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-border-transparent" data-backdrop="static" data-keyboard="false"
     id="partnerExpectationModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="clear"></div>
            <div id="modal-login-form-wrapper">
                <form method="POST" id="partner-expectations-form">
                    <!-- Begin | Register Form 4 -->
                    <div id="register-form-4">

                        <div class="modal-body" style="padding-bottom: 0px;">

                            <div class="text-center mt-15 mb-15" id="partner-expectations-response"
                                 style="font-size: 14px; font-weight: bold;"></div>

                            <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">
                                Please fill partner expectations
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_looking_for">Looking For</label>
                                    <select class="chosen-select form-control mb-5" name="looking[]"
                                            id="register_looking_for" multiple required
                                            data-placeholder="Looking For">
                                        <option value="Unmarried" selected>Unmarried</option>
                                        <option value="Widow/Widower">Widow/Widower</option>
                                        <option value="Divorcee">Divorcee</option>
                                        <option value="Separated">Separated</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <label for="register_part_religion">Partner Religion</label>
                                <select class="chosen-select form-control mb-5" name="part_religion_id[]"
                                        id="register_part_religion" data-placeholder="Partner Religion" multiple>
                                    <?php
                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT religion_id,religion_name FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                        ?>
                                        <option value="<?= $DatabaseCo->dbRow->religion_id ?>" <?= $DatabaseCo->dbRow->religion_id == 7 ? "selected" : ""; ?>><?= $DatabaseCo->dbRow->religion_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div id="CasteDiv1">
                                    <label for="register_part_caste">Partner Caste</label>
                                    <select class="chosen-select form-control mb-5" name="part_caste_id[]"
                                            id="register_part_caste" data-placeholder="Partner Caste" multiple>
                                        <option value="227" selected>SC</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_pform_age">Partner Age from</label>
                                    <select class="chosen-select form-control mb-5" name="pfrom_age"
                                            id="register_pform_age">
                                        <option value="" selected disabled>From Age</option>
                                        <option value="18">18 Years</option>
                                        <option value="19">19 Years</option>
                                        <option value="20">20 Years</option>
                                        <option value="21">21 Years</option>
                                        <option value="22">22 Years</option>
                                        <option value="23">23 Years</option>
                                        <option value="24">24 Years</option>
                                        <option value="25">25 Years</option>
                                        <option value="26">26 Years</option>
                                        <option value="27">27 Years</option>
                                        <option value="28">28 Years</option>
                                        <option value="29">29 Years</option>
                                        <option value="30">30 Years</option>
                                        <option value="31">31 Years</option>
                                        <option value="32">32 Years</option>
                                        <option value="33">33 Years</option>
                                        <option value="34">34 Years</option>
                                        <option value="35">35 Years</option>
                                        <option value="36">36 Years</option>
                                        <option value="37">37 Years</option>
                                        <option value="38">38 Years</option>
                                        <option value="39">39 Years</option>
                                        <option value="40">40 Years</option>
                                        <option value="41">41 Years</option>
                                        <option value="42">42 Years</option>
                                        <option value="43">43 Years</option>
                                        <option value="44">44 Years</option>
                                        <option value="45">45 Years</option>
                                        <option value="46">46 Years</option>
                                        <option value="47">47 Years</option>
                                        <option value="48">48 Years</option>
                                        <option value="49">49 Years</option>
                                        <option value="50">50 Years</option>
                                        <option value="51">51 Years</option>
                                        <option value="52">52 Years</option>
                                        <option value="53">53 Years</option>
                                        <option value="54">54 Years</option>
                                        <option value="55">55 Years</option>
                                        <option value="56">56 Years</option>
                                        <option value="57">57 Years</option>
                                        <option value="58">58 Years</option>
                                        <option value="59">59 Years</option>
                                        <option value="60">60 Years</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_pto_age">Partner to Age</label>
                                    <select class="chosen-select form-control mb-5" name="pto_age"
                                            id="register_pto_age">
                                        <option value="" selected disabled>To Age</option>
                                        <option value="18">18 Years</option>
                                        <option value="19">19 Years</option>
                                        <option value="20">20 Years</option>
                                        <option value="21">21 Years</option>
                                        <option value="22">22 Years</option>
                                        <option value="23">23 Years</option>
                                        <option value="24">24 Years</option>
                                        <option value="25">25 Years</option>
                                        <option value="26">26 Years</option>
                                        <option value="27">27 Years</option>
                                        <option value="28">28 Years</option>
                                        <option value="29">29 Years</option>
                                        <option value="30">30 Years</option>
                                        <option value="31">31 Years</option>
                                        <option value="32">32 Years</option>
                                        <option value="33">33 Years</option>
                                        <option value="34">34 Years</option>
                                        <option value="35">35 Years</option>
                                        <option value="36">36 Years</option>
                                        <option value="37">37 Years</option>
                                        <option value="38">38 Years</option>
                                        <option value="39">39 Years</option>
                                        <option value="40">40 Years</option>
                                        <option value="41">41 Years</option>
                                        <option value="42">42 Years</option>
                                        <option value="43">43 Years</option>
                                        <option value="44">44 Years</option>
                                        <option value="45">45 Years</option>
                                        <option value="46">46 Years</option>
                                        <option value="47">47 Years</option>
                                        <option value="48">48 Years</option>
                                        <option value="49">49 Years</option>
                                        <option value="50">50 Years</option>
                                        <option value="51">51 Years</option>
                                        <option value="52">52 Years</option>
                                        <option value="53">53 Years</option>
                                        <option value="54">54 Years</option>
                                        <option value="55">55 Years</option>
                                        <option value="56">56 Years</option>
                                        <option value="57">57 Years</option>
                                        <option value="58">58 Years</option>
                                        <option value="59">59 Years</option>
                                        <option value="60">60 Years</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_height">Partner Height From</label>
                                    <select class="chosen-select form-control mb-5" name="part_height"
                                            id="register_part_height">
                                        <option value="" selected disabled>From Height</option>
                                        <option value="48">Below 4ft</option>
                                        <option value="54">4ft 06in</option>
                                        <option value="55">4ft 07in</option>
                                        <option value="56">4ft 08in</option>
                                        <option value="57">4ft 09in</option>
                                        <option value="58">4ft 10in</option>
                                        <option value="59">4ft 11in</option>
                                        <option value="60">5ft</option>
                                        <option value="61">5ft 01in</option>
                                        <option value="62">5ft 02in</option>
                                        <option value="63">5ft 03in</option>
                                        <option value="64">5ft 04in</option>
                                        <option value="65">5ft 05in</option>
                                        <option value="66">5ft 06in</option>
                                        <option value="67">5ft 07in</option>
                                        <option value="68">5ft 08in</option>
                                        <option value="69">5ft 09in</option>
                                        <option value="70">5ft 10in</option>
                                        <option value="71">5ft 11in</option>
                                        <option value="72">6ft</option>
                                        <option value="73">6ft 01in</option>
                                        <option value="74">6ft 02in</option>
                                        <option value="75">6ft 03in</option>
                                        <option value="76">6ft 04in</option>
                                        <option value="77">6ft 05in</option>
                                        <option value="78">6ft 06in</option>
                                        <option value="79">6ft 07in</option>
                                        <option value="80">6ft 08in</option>
                                        <option value="81">6ft 09in</option>
                                        <option value="82">6ft 10in</option>
                                        <option value="83">6ft 11in</option>
                                        <option value="84">7ft</option>
                                        <option value="85">Above 7ft</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_height_to">Partner Height To</label>
                                    <select class="chosen-select form-control mb-5" name="part_height_to"
                                            id="register_part_height_to">
                                        <option value="" selected disabled>To Height</option>
                                        <option value="48">Below 4ft</option>
                                        <option value="54">4ft 06in</option>
                                        <option value="55">4ft 07in</option>
                                        <option value="56">4ft 08in</option>
                                        <option value="57">4ft 09in</option>
                                        <option value="58">4ft 10in</option>
                                        <option value="59">4ft 11in</option>
                                        <option value="60">5ft</option>
                                        <option value="61">5ft 01in</option>
                                        <option value="62">5ft 02in</option>
                                        <option value="63">5ft 03in</option>
                                        <option value="64">5ft 04in</option>
                                        <option value="65">5ft 05in</option>
                                        <option value="66">5ft 06in</option>
                                        <option value="67">5ft 07in</option>
                                        <option value="68">5ft 08in</option>
                                        <option value="69">5ft 09in</option>
                                        <option value="70">5ft 10in</option>
                                        <option value="71">5ft 11in</option>
                                        <option value="72">6ft</option>
                                        <option value="73">6ft 01in</option>
                                        <option value="74">6ft 02in</option>
                                        <option value="75">6ft 03in</option>
                                        <option value="76">6ft 04in</option>
                                        <option value="77">6ft 05in</option>
                                        <option value="78">6ft 06in</option>
                                        <option value="79">6ft 07in</option>
                                        <option value="80">6ft 08in</option>
                                        <option value="81">6ft 09in</option>
                                        <option value="82">6ft 10in</option>
                                        <option value="83">6ft 11in</option>
                                        <option value="84">7ft</option>
                                        <option value="85">Above 7ft</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding: 0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_edu_level">Partner Education Level</label>
                                    <select data-placeholder="Any Edu. Level"
                                            class="chosen-select form-control mb-5" name="part_edu_level[]"
                                            id="register_part_edu_level" multiple>
                                        <?php
                                        $edures2 = $DatabaseCo->dbLink->query("select e_level_id,e_level_name from education_level where status='APPROVED' order by e_level_name ASC");
                                        while ($edu = mysqli_fetch_array($edures2)) { ?>
                                            <option value="<?php echo $edu['e_level_id']; ?>"><?php echo $edu['e_level_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <label for="register_part_edu_field">Partner Education Field</label>
                                    <select data-placeholder="Any Education"
                                            class="chosen-select form-control mb-5" name="part_edu_field[]"
                                            id="register_part_edu_field" multiple>
                                        <?php
                                        $edures2 = $DatabaseCo->dbLink->query("select e_field_id,e_field_name from education_field where status='APPROVED' order by e_field_name ASC");
                                        while ($edu = mysqli_fetch_array($edures2)) { ?>
                                            <option value="<?php echo $edu['e_field_id']; ?>"><?php echo $edu['e_field_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6" style="padding: 0px 5px 0px 0px;">
                                <div class="form-group mb-0">
                                    <label for="register_part_occupation">Partner Occupation</label>
                                    <select data-placeholder="Any Occupation"
                                            class="chosen-select form-control mb-5" name="part_occupation[]"
                                            id="register_part_occupation" multiple>
                                        <?php
                                        $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT ocp_id,ocp_name FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) { ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>"><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <label for="register_part_emp_in">Partner Employed In</label>
                                    <select data-placeholder="Employed in Any"
                                            class="chosen-select form-control mb-5" name="part_emp_in[]"
                                            id="register_part_emp_in" multiple>
                                        <option value="Private">Private</option>
                                        <option value="Government">Government</option>
                                        <option value="Semi-Government">Semi-Government</option>
                                        <option value="Contract Basis">Contract Basis</option>
                                        <option value="Business">Business</option>
                                        <option value="Defence">Defence</option>
                                        <option value="MNC Company">MNC Company</option>
                                        <option value="Banking">Banking</option>
                                        <option value="Hospitality">Hospitality</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Job & Business">Job & Business</option>
                                        <option value="Not Employed">Not Employed</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_country">Partner Residence Country</label>
                                    <select class="chosen-select form-control mb-5" name="part_country_id[]"
                                            multiple id="register_part_country"
                                            data-placeholder="Any Country">
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT country_id, country_name FROM country WHERE status='APPROVED' ORDER BY country_name");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>" <?= $DatabaseCo->dbRow->country_id == 95 ? "selected" : "" ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_complexion">Partner Complexion</label>
                                    <select data-placeholder="Any Complexion" id="register_part_complexion"
                                            class="chosen-select form-control mb-5" name="part_complexion[]"
                                            multiple>
                                        <option value="Very Fair">Very Fair</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Wheatish">Wheatish</option>
                                        <option value="Wheatish Medium">Wheatish Medium</option>
                                        <option value="Wheatish Brown">Wheatish Brown</option>
                                        <option value="Dark">Dark</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding: 0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_part_city">Partner Residence City</label>
                                    <select data-placeholder="Any City" name="part_city[]"
                                            id="register_part_city" class="chosen-select form-control" multiple>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view WHERE status='APPROVED' ORDER BY city_name ASC");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->city_id ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <label for="register_part_native_city">Partner Native Place</label>
                                    <select data-placeholder="Any Native Place" name="part_native_city[]"
                                            id="register_part_native_city" class="chosen-select form-control" multiple>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT city_id,city_name FROM city_view WHERE status='APPROVED' ORDER BY city_name ASC");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->city_id ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <label for="register_caste_bar">Ready to marry in other caste?</label>
                                    <select class="form-control mb-5" name="caste_bar"
                                            id="register_caste_bar"
                                            data-placeholder="Ready to marry in other caste ?">
                                        <option value="">Ready to marry in other caste ?</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer pb-5" style="border-top: none; margin-top: 10px;">

                            <div class="row gap-10">
                                <div class="col-xs-offset-3 col-xs-6 mb-10">
                                    <button type="submit" id="update_partner_expectations"
                                            class="btn btn-primary btn-block">Finish
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End | Register Form 4-->
                </form>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-border-transparent" id="profileModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content" style="border: none;">
            <button type="button" id="close_profile_btn" class="btn btn-close close" data-dismiss="modal"
                    aria-label="Close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    border-radius: 50%;
    padding: 8px;
    color: white;
    opacity: 10;">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
            <div class="clear"></div>
            <div class="modal-body pb-10" id="contentProfileModal" style="padding: 0px !important;">
                <iframe id="iframe" style="width: 100%; height:50em; border: none;"></iframe>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-border-transparent" id="editProfileModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content" style="border: none;">
            <button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    border-radius: 50%;
    padding: 5px;
    color: white;
    opacity: 10;">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
            <div class="clear"></div>
            <div class="modal-body pb-10" id="contentProfileModal" style="padding: 0px !important;">
                <iframe id="iframe" style="width: 100%; height:50em; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-border-transparent" id="msgModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content" style="border: none;">
            <button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    border-radius: 50%;
    padding: 5px;
    color: white;
    opacity: 10;">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
            <div class="clear"></div>
            <div class="modal-body pb-10" id="contentProfileModal" style="padding: 0px !important;">
                <iframe id="iframe" style="width: 100%; height:50em; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN # MODAL CONTACT DETAIL -->
<div class="modal fade modal-border-transparent" id="contactDetailModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="clear"></div>
            <div class="modal-body pb-10" id="contentContactDetailModal"></div>
        </div>
    </div>
</div>


<div class="modal fade modal-border-transparent" id="sendMsgModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="clear"></div>
            <div class="modal-body pb-10" id="msgContentModal"></div>
        </div>
    </div>
</div>


<div class="modal fade modal-border-transparent" id="updatePhotoModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding-bottom: 0px;">
            <div class="modal-body" id="updateContentPhoto" style="padding-bottom: 0px;"></div>
        </div>
    </div>
</div>

<div class="modal fade modal-border-transparent" id="viewPhotoModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 10px;">
            <button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
            <div class="clear"></div>
            <div class="modal-body" style="padding: 10px;">
                <div class="row">
                    <div class="col-xs-12 text-center" id="viewContentPhoto">
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-sm btn-danger btn-shrink" type="button" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-border-transparent" id="sendExpressInterestModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="clear"></div>
            <div class="modal-body pb-10 pt-20" id="expressInterestContentModal">
                Please wait...
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-border-transparent" id="alertToVerify" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="clear"></div>
            <div class="modal-body pb-10 pt-20" id="alertToVerifyModalContent">
                <p style="margin-bottom: 10px;">By verifying email address, mobile number, and Photo Id Proof trust score will be increased.
                    Profile having good trust score gets more interest from other users</p>

                <p style="margin-bottom: 10px;">**Note - To verify your email, please check your email id, you should have received an email verification.</p>
                <p>**Note - To verify your Photo ID proof, kindly send your photo id proof on
                    <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or click on below button to send it on WhatsApp.</p>

                <a target="_blank" class="btn btn-success btn-shrink btn-sm" style="background-color: #25d366; margin-bottom: 20px;"
                   href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i class="fa fa-whatsapp"></i> Send Now</a>
            </div>
        </div>
    </div>
</div>

<!---------------Js Birth date------------------>

<script type="text/javascript">


    var numDays = {
        '01': 31, '02': 28, '03': 31, '04': 30, '05': 31, '06': 30,
        '07': 31, '08': 31, '09': 30, '10': 31, '11': 30, '12': 31
    };

    function setDays(oMonthSel, oDaysSel, oYearSel) {
        var nDays, oDaysSelLgth, opt, i = 1;
        nDays = numDays[oMonthSel[oMonthSel.selectedIndex].value];
        if (nDays == 28 && oYearSel[oYearSel.selectedIndex].value % 4 == 0)
            ++nDays;
        oDaysSelLgth = oDaysSel.length;
        if (nDays != oDaysSelLgth) {
            if (nDays < oDaysSelLgth)
                oDaysSel.length = nDays;
            else for (i; i < nDays - oDaysSelLgth + 1; i++) {
                opt = new Option(oDaysSelLgth + i, oDaysSelLgth + i);
                oDaysSel.options[oDaysSel.length] = opt;
            }
        }
        var oForm = oMonthSel.form;
        var month = oMonthSel.options[oMonthSel.selectedIndex].value;
        var day = oDaysSel.options[oDaysSel.selectedIndex].value;
        var year = oYearSel.options[oYearSel.selectedIndex].value;


        //oForm.datepicker.value = year + '-' + month + '-' + day;
    }

    function GetCaste(url) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#CasteDiv").html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

    window.pressed = function () {
        var a = document.getElementById('register_profile_img');
        var fileLabel = document.getElementById('photoLabel');
        if (a.value == "") {
            fileLabel.innerHTML = "Select your photo";
        }
        else {
            var theSplit = a.value.split('\\');
            fileLabel.innerHTML = theSplit[theSplit.length - 1];
        }
    };
</script>
<!---------------Js Birth date End------------------>

