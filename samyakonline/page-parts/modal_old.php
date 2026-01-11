<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/16/2018
 * Time: 8:00 PM
 */
?>
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

                <!-- Begin # Login Form -->
                <form id="login-form" action="login" method="post">

                    <div class="modal-body pb-10">

                        <h4 class="text-center mb-15">Login</h4>

                        <div class="form-group mb-0">
                            <input id="login_username" class="form-control mb-5" placeholder="Profile ID / Email ID"
                                   name="username"
                                   type="text">
                        </div>
                        <div class="form-group mb-0">
                            <input id="login_password" class="form-control mb-5" placeholder="Password" name="password"
                                   type="password">
                        </div>
                        <div class="form-group mb-0 mt-10">
                            <div class="row gap-5">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="remember_me_checkbox" name="keep_login"
                                               class="checkbox" <?php if (isset($_COOKIE['password']) || isset($_COOKIE['username'])) {
                                            echo "checked";
                                        } ?>
                                               value="First Choice" type="checkbox">
                                        <label class="" for="remember_me_checkbox">Keep me Logged in</label>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                    <button id="login_lost_btn" type="button" class="btn btn-link">forgot pass?</button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer pt-25 pb-5">

                            <div class="row gap-10">
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button type="submit" name="member_login" class="btn btn-primary btn-block">
                                        Sign-in
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button type="submit" class="btn btn-danger btn-block" data-dismiss="modal"
                                            aria-label="Close">Cancel
                                    </button>
                                </div>
                            </div>
                            <div class="text-left">
                                No account?
                                <button id="login_register_btn" type="button" class="btn btn-link">Register</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- End # Login Form -->

                <!-- Begin | Lost Password Form -->
                <form id="lost-form" style="display:none;">
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
                            <button id="lost_login_btn" type="button" class="btn btn-link">Sign-in</button>
                            or
                            <button id="lost_register_btn" type="button" class="btn btn-link">Register</button>
                        </div>


                    </div>

                </form>
                <!-- End | Lost Password Form -->


                <form id="register-profile" action="#" method="post" enctype="multipart/form-data">
                    <div id="showRegisterError" class="font22 text-center text-danger"></div>

                    <!-- Begin | Register Form -->
                    <div id="register-form" style="display:none;">

                        <div class="modal-body" style="padding-bottom: 0px;">

                            <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">Let's start
                                partner search with Register profile
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <input id="register_firstname" name="first_name" class="form-control mb-5"
                                           type="text" required
                                           placeholder="First Name">
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 5px !important;">
                                <div class="form-group mb-0">
                                    <input id="register_lastname" name="last_name" class="form-control mb-5" type="text"
                                           required
                                           placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <input id="register_mobile" name="mobile_no" minlength="10" maxlength="10"
                                           class="form-control mb-5" type="text"
                                           required
                                           placeholder="Mobile No">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <input id="register_email" name="email" class="form-control mb-5" type="email"
                                           required
                                           placeholder="Email">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <input id="register_password" name="password" class="form-control mb-5"
                                           type="password" required
                                           placeholder="Password">
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-3 col-xss-3"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_date" name="day" class="form-control mb-5" required
                                            onchange="setDays(month,this,year)">
                                        <option value="" disabled selected>Day</option>
                                        <?php
                                        if (isset($_REQUEST['day']) && $_REQUEST['day'] != '') {
                                            ?>
                                            <option value="<?php echo $_REQUEST['day']; ?>"><?php echo $_REQUEST['day']; ?></option>
                                            <?php
                                        }
                                        ?>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4 col-xss-4"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_month" name="month" class="form-control mb-5" required
                                            onchange="setDays(this,day,year)">
                                        <option value="" selected disabled>Month</option>
                                        <option value="01" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '01') {
                                            echo "selected";
                                        } ?>>Jan
                                        </option>
                                        <option value="02" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '02') {
                                            echo "selected";
                                        } ?>>Feb
                                        </option>
                                        <option value="03" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '03') {
                                            echo "selected";
                                        } ?>>Mar
                                        </option>
                                        <option value="04" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '04') {
                                            echo "selected";
                                        } ?>>Apr
                                        </option>
                                        <option value="05" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '05') {
                                            echo "selected";
                                        } ?>>May
                                        </option>

                                        <option value="06" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '06') {
                                            echo "selected";
                                        } ?>>Jun
                                        </option>
                                        <option value="07" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '07') {
                                            echo "selected";
                                        } ?>>Jul
                                        </option>
                                        <option value="08" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '08') {
                                            echo "selected";
                                        } ?>>Aug
                                        </option>
                                        <option value="09" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '09') {
                                            echo "selected";
                                        } ?>>Sep
                                        </option>
                                        <option value="10" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '10') {
                                            echo "selected";
                                        } ?>>Oct
                                        </option>
                                        <option value="11" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '11') {
                                            echo "selected";
                                        } ?>>Nov
                                        </option>
                                        <option value="12" <?php if (isset($_REQUEST['month']) && $_REQUEST['month'] == '12') {
                                            echo "selected";
                                        } ?>>Dec
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-5 col-xs-5 col-xss-5"
                                 style="padding:0px 0px 0px 5px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_year" name="year" class="form-control mb-5" required
                                            onchange="setDays(month,day,this)">
                                        <option value="" selected disabled>Year</option>
                                        <?php
                                        for ($x = 1997; $x >= 1960; $x--) {
                                            ?>
                                            <option value="<?php echo $x; ?>"
                                                <?php if (isset($_REQUEST['year']) && $_REQUEST['year'] == $x) {
                                                    echo "selected";
                                                } elseif (isset($_REQUEST['year']) && $_REQUEST['year'] == '' && $x == 1990) {
                                                    echo "selected";
                                                } ?> ><?php echo $x; ?></option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <select id="register_height" class="form-control mb-5" name="height" required>
                                        <option value="" selected disabled>Select Height</option>
                                        <?php
                                        if (isset($_REQUEST['height'])) {
                                            ?>
                                            <option value="<?php echo $_REQUEST['height']; ?>"><?php $ao3 = $_REQUEST['height'];
                                                $ft3 = (int)($ao3 / 12);
                                                $inch3 = $ao3 % 12;
                                                echo $ft3 . "ft" . " " . $inch3 . "in"; ?> </option>
                                            <?php
                                        }
                                        ?>
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
                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <select id="register_gender" class="form-control mb-5" name="gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Bride"
                                            <?php if (isset($gender) && $gender == 'Bride') {
                                                echo "selected";
                                            } elseif (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'Bride') {
                                                echo "selected";
                                            } ?>>Female
                                        </option>
                                        <option value="Groom"
                                            <?php if (isset($gender) && $gender == 'Groom') {
                                                echo "selected";
                                            } elseif (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'Groom') {
                                                echo "selected";
                                            } ?>>Male
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <select id="register_complexion" class="form-control mb-5" name="complexion"
                                            required>
                                        <option value="" selected disabled>Select Complexion</option>
                                        <option value="Wheatish Brown">Wheatish Brown</option>
                                        <option value="Wheatish">Wheatish</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Very Fair">Very Fair</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <select id="register_profile_for" class="form-control mb-5" name="profile_for"
                                            required>
                                        <option value="" selected disabled>Profile posted by</option>
                                        <option value="Parents">Parents</option>
                                        <option value="Self">Self</option>
                                        <option value="Friend">Friend</option>
                                        <option value="Sibling">Sibling</option>
                                        <option value="Relatives">Relatives</option>
                                        <option value="Marriage Bureau">Marriage Bureau</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <select id="register_referred_by" class="form-control mb-5" name="referred_by"
                                            required>
                                        <option value="" selected disabled>Select Reference from</option>
                                        <option value="Google">Google</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Samrat Paper">Samrat Paper</option>
                                        <option value="Lokmat Newspaper">Lokmat Newspaper</option>
                                        <option value="Other Newspaper">Other Newspaper</option>
                                        <option value="Relative">Relative</option>
                                        <option value="Friend">Friend</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding mb-0">
                                <div class="text-center">
                                    By signing up, you agree to our <a href="terms"> Terms</a>.
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer pb-5" style="border-top:none; margin-top: 10px;">
                            <div class="row gap-10">
                                <div class="col-xs-offset-3 col-sm-offset-3 col-xs-6 col-sm-6 mb-10">
                                    <button id="register_page2_btn" type="button" class="btn btn-danger btn-block">
                                        Create Profile
                                    </button>
                                </div>
                            </div>
                            <div class="text-left">
                                Already have account?
                                <button id="register_login_btn" type="button" class="btn btn-link">Login</button>
                            </div>
                        </div>
                    </div>
                    <!-- End | Register Form -->

                    <!-- Begin | Register Form 2 -->
                    <div id="register-form-2" style="display:none;">

                        <div class="modal-body" style="padding-bottom: 0px;">

                            <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">Great!
                                Let's be familiar
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_religion_id" name="religion_id" class="form-control mb-5"
                                            onchange="GetCaste('web-services/caste_search?religionId='+this.value)">
                                        <option value="" selected disabled>Religion</option>
                                        <?php
                                        $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>" <?php if (isset($religion_id) && $DatabaseCo->dbRow->religion_id == $religion_id) {
                                                echo "selected";
                                            } else if (isset($_REQUEST['religion_id']) && $_REQUEST['religion_id'] == $DatabaseCo->dbRow->religion_id) {
                                                echo "selected";
                                            } else if (!isset($_REQUEST['religion_id']) && $DatabaseCo->dbRow->religion_id == 7) {
                                                echo "selected";
                                            } ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0" id="CasteDiv">
                                    <?php
                                    $caste_name = '';

                                    if (isset($_POST['caste_id'])) {
                                        $caste_name = $caste_id;
                                    } elseif (isset($_REQUEST['my_caste'])) {
                                        $caste_name = $_REQUEST['my_caste'];
                                    }

                                    if ($caste_name != '') {
                                        $caste = $DatabaseCo->dbLink->query("select * from caste where caste_id='$caste_name'");
                                        $row = mysqli_fetch_array($caste);
                                    }

                                    ?>
                                    <select id="register_my_caste" name="my_caste" class="form-control mb-5"
                                            required>
                                        <option value="" selected disabled>Caste</option>
                                        <option value="227" selected>SC</option>
                                        <?php
                                        if (isset($caste_name) && $caste_name != '') {
                                            ?>
                                            <option value="<?php echo $row['caste_id']; ?>"><?php echo $row['caste_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_mothertongue" name="mothertongue"
                                            class="form-control mb-5">
                                        <option value="" selected disabled>Select Mothertongue</option>
                                        <?php
                                        $SQL_STATEMENT_Mtongu = $DatabaseCo->dbLink->query("SELECT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_Mtongu)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>" <?php if (isset($_REQUEST['mothertongue']) && $_REQUEST['mothertongue'] == $DatabaseCo->dbRow->mtongue_id) {
                                                echo "selected";
                                            } else if ($DatabaseCo->dbRow->mtongue_id == 7) {
                                                echo "selected";
                                            } ?>><?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="marital_status" id="marital_status">
                                        <option value="" selected disabled>Marital Status</option>
                                        <option value="Unmarried" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Unmarried') {
                                            echo "selected";
                                        } else if (!isset($_REQUEST['marital_status'])) {
                                            echo "selected";
                                        } ?>>Unmarried
                                        </option>
                                        <option value="Widow/Widower" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Widow/Widower') {
                                            echo "selected";
                                        } ?>>Widow/Widower
                                        </option>
                                        <option value="Divorcee" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Divorcee') {
                                            echo "selected";
                                        } ?>>Divorcee
                                        </option>
                                        <option value="Separated" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Separated') {
                                            echo "selected";
                                        } ?>>Separated
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div id="divorcee_section" style="display: none;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="child" id="register_divorcee_child">
                                        <option value="" selected disabled>Have any Children ?</option>
                                        <option value="No">No</option>
                                        <option value="Yes. Living together">Yes. Living together</option>
                                        <option value="Yes. Not living together">Yes. Not living together</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="education_level" id="edu_level">

                                        <option value="" selected disabled>Select Education Level</option>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>" <?php if ($DatabaseCo->dbRow->e_level_id == $_POST['education_level']) {
                                                echo "selected";
                                            } ?>>
                                                <?php echo $DatabaseCo->dbRow->e_level_name ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="edu_field" id="register_edu_field">
                                        <option value="" selected disabled>Select Education Field</option>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->e_field_id ?>" <?php if ($DatabaseCo->dbRow->e_field_id == $_REQUEST['education_field']) {
                                                echo "selected";
                                            } ?>>
                                                <?php echo $DatabaseCo->dbRow->e_field_name ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group mb-0">
                                <select class="form-control mb-5" name="edu_id[]" id="edu_id">
                                    <option value="" selected disabled>Select Qualification</option>
                                    <?php
                                    $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT * FROM education_detail WHERE status='APPROVED' ORDER BY edu_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->edu_id; ?>" <?php if (isset($edu_id) && $DatabaseCo->dbRow->edu_id == $edu_id) {
                                            echo "selected";
                                        } else if (isset($_REQUEST['edu_id']) && in_array($DatabaseCo->dbRow->edu_id, $_POST['edu_id'])) {
                                            echo "selected";
                                        } ?>><?php echo $DatabaseCo->dbRow->edu_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="employed_in" id="register_employed_in">
                                        <option value="" selected disabled>Select Employed In</option>
                                        <option value="Private" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Private') {
                                            echo "selected";
                                        } ?>>Private
                                        </option>
                                        <option value="Government" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Government') {
                                            echo "selected";
                                        } ?>>Government
                                        </option>
                                        <option value="Business" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Business') {
                                            echo "selected";
                                        } ?>>Business
                                        </option>
                                        <option value="Defence" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Defence') {
                                            echo "selected";
                                        } ?>>Defence
                                        </option>
                                        <option value="Not Employed in" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Not Employed in') {
                                            echo "selected";
                                        } ?>>Not Employed in
                                        </option>
                                        <option value="Others" <?php if (isset($_REQUEST['employed_in']) && $_REQUEST['employed_in'] == 'Others') {
                                            echo "selected";
                                        } ?>>Others
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="occupation" id="register_occupation">
                                        <option value="" selected disabled> Select Occupation</option>
                                        <?php
                                        $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>" <?php if (isset($occupation) && $DatabaseCo->dbRow->ocp_id == $occupation) {
                                                echo "selected";
                                            } else if (isset($_REQUEST['occupation']) && $_REQUEST['occupation'] == $DatabaseCo->dbRow->ocp_id) {
                                                echo "selected";
                                            } ?>><?php echo $DatabaseCo->dbRow->ocp_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12 no-padding">
                                <div class="form-group mb-0">
                                    <input id="register_salary" name="monthly_salary" minlength="4" maxlength="7"
                                           class="form-control mb-5" type="text"
                                           required
                                           placeholder="Monthly Salary">
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <select class="form-control mb-5" name="annual_income" id="register_annual_income">
                                    <option value="" selected disabled>Select Annual Income</option>
                                    <option value="Rs 50,000 - 1,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 50,000 - 1,00,000') {
                                        echo "selected";
                                    } ?>>Rs 50,000 - 1,00,000
                                    </option>
                                    <option value="Rs 1,00,000 - 2,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 1,00,000 - 2,00,000') {
                                        echo "selected";
                                    } ?>>Rs 1,00,000 - 2,00,000
                                    </option>
                                    <option value="Rs 2,00,000 - 5,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 2,00,000 - 5,00,000') {
                                        echo "selected";
                                    } ?>>Rs 2,00,000 - 5,00,000
                                    </option>
                                    <option value="Rs 5,00,000 - 10,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 5,00,000 - 10,00,000') {
                                        echo "selected";
                                    } ?>>Rs 5,00,000 - 10,00,000
                                    </option>
                                    <option value="Rs 10,00,000 - 20,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 10,00,000 - 20,00,000') {
                                        echo "selected";
                                    } ?>>Rs 10,00,000 - 20,00,000
                                    </option>
                                    <option value="Rs 20,00,000 - 30,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 20,00,000 - 30,00,000') {
                                        echo "selected";
                                    } ?>>Rs 20,00,000 - 30,00,000
                                    </option>
                                    <option value="Rs 30,00,000 - 50,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 30,00,000 - 50,00,000') {
                                        echo "selected";
                                    } ?>>Rs 30,00,000 - 50,00,000
                                    </option>
                                    <option value="Rs 50,00,000 - 1,00,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Rs 50,00,000 - 1,00,00,000') {
                                        echo "selected";
                                    } ?>>Rs 50,00,000 - 1,00,00,000
                                    </option>
                                    <option value="Above Rs 1,00,00,000" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Above Rs 1,00,00,000') {
                                        echo "selected";
                                    } ?>>Above Rs 1,00,00,000
                                    </option>
                                    <option value="Does not matter" <?php if (isset($_REQUEST['annual_income']) && $_REQUEST['annual_income'] == 'Does not matter') {
                                        echo "selected";
                                    } ?>>Does not matter
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer pb-5" style="border-top: none; margin-top: 10px;">

                            <div class="row gap-10">
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button id="register_page2_prev_btn" type="button"
                                            class="btn btn-danger btn-block">Previous Page
                                    </button>
                                </div>

                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button id="register_page3_btn" type="button" class="btn btn-primary btn-block">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End | Register Form 2-->

                    <!-- Begin | Register Form 3 -->
                    <div id="register-form-3" style="display:none;">

                        <div class="modal-body" style="padding-bottom: 0px;">

                            <div class="text-center mt-15 mb-15" style="font-size: 14px; font-weight: bold;">A
                                little brief about you
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_father_occupation" name="father_occupation"
                                            class="form-control mb-5" required>
                                        <option value="" selected disabled>Father Status</option>
                                        <option value="Retired">Retired</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Business">Business</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Not Employed">Not Employed</option>
                                        <option value="No More">No More</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <select id="register_mother_occupation" name="mother_occupation"
                                        class="form-control mb-5" required>
                                    <option value="" selected disabled>Mother Status</option>
                                    <option value="Housewife">Housewife</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Business">Business</option>
                                    <option value="Professional">Professional</option>
                                    <option value="Not Employed">Not Employed</option>
                                    <option value="No More">No More</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_brother_nos" name="no_of_brothers"
                                            class="form-control mb-5">
                                        <option value="" selected disabled>No of Brothers</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="4 +">4 +</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_sister_nos" name="no_of_sisters" class="form-control mb-5">
                                        <option value="" selected disabled>No of Sisters</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="4 +">4 +</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_living_status" name="living_status"
                                            class="form-control mb-5">
                                        <option value="" selected disabled>Living Status</option>
                                        <option value="With Parents">With Parents</option>
                                        <option value="As Room Mate">As Room Mate</option>
                                        <option value="Myself">Myself</option>
                                        <option value="Paying Guest">Paying Guest</option>
                                        <option value="In Hostel">In Hostel</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_house_ownership" name="house_ownership"
                                            class="form-control mb-5">
                                        <option value="" selected disabled>House Ownership</option>
                                        <option value="Own Flat">Own Flat/Bungalow</option>
                                        <option value="Parent Flat">Parent Flat/Bungalow</option>
                                        <option value="Renting in Flat">Renting in Flat/Bungalow</option>
                                        <option value="Stay With Relative">Stay With Relative</option>
                                        <option value="Don't have House">Don't have House</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_body_type" name="body_type" class="form-control mb-5">
                                        <option value="" selected disabled>Body Type</option>
                                        <option value="Slim">Slim</option>
                                        <option value="Average">Average</option>
                                        <option value="Athletic">Athletic</option>
                                        <option value="Heavy">Heavy</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 0px 0px 0px !important;">
                                <div class="form-group mb-0">
                                    <select id="register_disability" name="disability" class="form-control mb-5">
                                        <option value="" selected disabled>Any Disability</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Physically Challenged">Physically Challanged</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="family_origin" id="family_origin">
                                        <option selected value="" disabled>Select Family Origin / Native Place
                                        </option>
                                        <?php
                                        $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 col-sm-12 col-xs-12 col-xss-12" style="padding: 0px;">
                                <div class="form-group mb-0">
                                    <select class="form-control mb-5" name="country_id" id="country_id">
                                        <option value="" selected disabled>Select Your Country</option>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT country_id,country_name FROM country WHERE status='APPROVED' order by country_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>"
                                                <?php if (isset($_REQUEST['country_id']) && $_REQUEST['country_id'] == $DatabaseCo->dbRow->country_id) {
                                                    echo "selected";
                                                } else if ($DatabaseCo->dbRow->country_id == 95) {
                                                    echo "selected";
                                                } ?>><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group mb-0">
                                <select class="form-control mb-5" name="city" id="city">
                                    <option selected value="" disabled>Select Residence City</option>
                                    <?php
                                    $SQL_STATEMENT_state = $DatabaseCo->dbLink->query("select city_id,city_name from city_view where status='APPROVED' order by city_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_state)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                    <textarea style="height: 75px;" class="form-control mb-5" name="profile_text"
                                              id="register_profile_text"
                                              placeholder="Write about your personality, family background and what you are looking for in your partner."></textarea>
                            </div>

                        </div>

                        <div class="modal-footer pb-5" style="border-top: none; margin-top: 10px;">

                            <div class="row gap-10">
                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <button id="register_page3_prev_btn" type="button"
                                            class="btn btn-danger btn-block">Previous Page
                                    </button>
                                </div>

                                <div class="col-xs-6 col-sm-6 mb-10">
                                    <!--<button id="register_page4_btn" type="button" class="btn btn-primary btn-block">
                                        Continue
                                    </button>-->
                                    <button id="register_me" type="button" class="btn btn-primary btn-block">
                                        Finish
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- End | Register Form 3-->

                </form>


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
                                    <select class="chosen-select form-control mb-5" name="part_caste_id[]"
                                            id="register_part_caste" data-placeholder="Partner Caste" multiple>
                                        <option value="227" selected>SC</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6 col-xss-6"
                                 style="padding:0px 5px 0px 0px !important;">
                                <div class="form-group mb-0">
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
    <div class="modal-dialog modal-sm">
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

