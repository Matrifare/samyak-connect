<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/8/2018
 * Time: 12:42 AM
 */

$myProfile = $DatabaseCo->dbLink->query("select DISTINCT matri_id, looking_for, part_height, part_height_to, part_religion,
part_caste, part_occupation, part_edu_field, part_frm_age, part_to_age, r.request_photo_id, r.view_profile_condition,
 r.send_interest_condition, part_city, p.p_plan, r.status,p.p_no_contacts, p.r_cnt,p.exp_date  from register_view r 
 LEFT JOIN payment_view p ON p.pmatri_id=r.matri_id WHERE matri_id='" . $_SESSION['user_id'] . "'");

$data1 = mysqli_fetch_object($myProfile);
$lookingFor = $data1->looking_for;
$partHeight = $data1->part_height;
$partHeightTo = $data1->part_height_to;
$partReligion = $data1->part_religion;
$partCaste = $data1->part_caste;
$partEduField = $data1->part_edu_field;
$partAgeFrom = $data1->part_frm_age;
$partAgeTo = $data1->part_to_age;
$partCity = $data1->part_city;
$partOccupation = $data1->part_occupation;

$_SESSION['request_photo_id'] = $data1->request_photo_id;
$_SESSION['view_profile_condition'] = $data1->view_profile_condition;
$_SESSION['send_interest_condition'] = $data1->send_interest_condition;

if ((!empty($data1->status) && $_SESSION['mem_status'] != $data1->status)
    || (!empty($data1->p_plan) && $_SESSION['membership'] != $data1->p_plan)) {
    $_SESSION['mem_status'] = $data1->status;
    $_SESSION['membership'] = $data1->p_plan;
    $_SESSION['p_no_contact'] = $data1->p_no_contacts;
    $_SESSION['r_cnt'] = $data1->r_cnt;
    $_SESSION['exp_date'] = $data1->exp_date;
}

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { ?>
    <aside class="sidebar-wrapper no-padding">

        <div class="dashboard-sidebar" style="margin-top: 2px;">

            <div class="dashboard-avatar">

                <div class="content" style="margin-top: 10px;">
                    <h4 title="View Profile" style="cursor: pointer;text-transform: capitalize;"
                        onclick="window.open('view_profile?userId=<?= $_SESSION['user_id'] ?>')">
                        <?= substr($_SESSION['uname'], 0, strrpos($_SESSION['uname'], ' ')) ?> | ID
                        : <?= $_SESSION['user_id'] ?? "" ?></h4>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="image">
                            <?php
                            if (!empty($_SESSION['photo1']) && file_exists('photos/' . trim($_SESSION['photo1']))) { ?>
                                <img src="photos/<?= trim($_SESSION['photo1']) ?>" alt="Image"
                                     onclick="window.location.href='edit_photo';" style="cursor: pointer;"
                                     class="img-circle">
                            <?php } else {
                                if ($_SESSION['gender123'] == 'Groom') { ?>
                                    <img src="img/default-photo/male-200.png" alt="<?= $_SESSION['uname'] ?? "" ?>"
                                         class="img-circle">
                                <?php } else { ?>
                                    <img src="img/default-photo/female-200.png" alt="<?= $_SESSION['uname'] ?? "" ?>"
                                         class="img-circle">
                                <?php } ?>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-6 ml-0" style="padding: 5px 0px 0px 0px;">
                        <div class="content text-left">
                            <p>
                                <a style="color: #0c0c0c;" target="_blank"
                                   href='view_profile?userId=<?= $_SESSION['user_id'] ?>'><i class="fa fa-eye"></i> My
                                    Profile</a>
                            </p>
                            <p>
                                <a href="my-matches" style="color: #0c0c0c;"><i class="fa fa-user"></i> My Matches</a>
                            </p>
                            <p><a href="edit-profile" style="color: #0c0c0c;"><i class="fa fa-edit"></i> Edit
                                    Profile</a></p>
                            <p><a href="edit_photo" style="color: #0c0c0c;"><i class="fa fa-picture-o"></i> Edit
                                    Photo</a></p>
                        </div>
                    </div>
                </div>
                <ul class="meta clearfix mt-5">
                    <li style="padding: 7px 0 0px;">
                        <?php
                        if ($_SESSION['membership'] != 'Free') { ?>
                            <span class="btn btn-primary btn-sm btn-shrink btn-success"
                                  onclick="window.location.href='current_plan';" title="Click to view your plan details"
                                  style="font-weight: normal; width: fit-content; margin: 0px auto; text-transform: capitalize;"><?= $_SESSION['membership'] ?? "" ?>
                                Plan</span>
                        <?php } else { ?>
                            <button class="btn btn-xs btn-danger" onclick="redirect_to_payment();"
                                    style="letter-spacing: 1px; padding-top: 5px; padding-bottom: 5px; width: fit-content; font-weight: normal; margin: 0px auto;text-transform: capitalize;">
                                <i
                                        class="fa fa-rupee"></i> Upgrade <span class="icon"></span>
                            </button>
                        <?php } ?>
                    </li>
                    <li style="padding: 7px 0 0px;">
                        <span class="btn btn-primary btn-sm btn-shrink"
                              onclick="window.location.href='profile-statistics';"
                              style="cursor:pointer;  margin: 0px auto;width: fit-content;font-weight: normal; text-transform: capitalize;"
                              title="Click to view Profile Statistics">Profile Statistics</span>
                    </li>
                </ul>

                <?php
                if ($_SESSION['membership'] != 'Free' && $_SESSION['mem_status'] != 'Inactive') {
                    ?>
                    <ul class="meta clearfix mt-5">
                        <li style="padding: 2px 0 0px;">
                            <div>
                                Expire on
                                <span style="display: inline;">
                                <?php
                                $expDate = $_SESSION['exp_date'] ?? "";
                                ?>
                                <?= !empty($expDate) ? date('M d, y', strtotime($expDate)) : "<p class='text-danger' style='padding-top: 5px;'>Expired</p>" ?>
                            </span>
                            </div>
                        </li>
                        <li style="padding: 2px 0 0px;">
                            <div>
                                Contact Balance
                                <span style="display: inline;">
                                <?php
                                $assignedContacts = $_SESSION['p_no_contact'] ?? 0;
                                $usedContacts = $_SESSION['r_cnt'] ?? 0;
                                ?>
                                <?= $assignedContacts - $usedContacts ?>
													</span>
                            </div>
                        </li>
                    </ul>
                <?php } else if ($_SESSION['mem_status'] == 'Inactive') { ?>
                    <div class="text-center">
                        <ul class="meta clearfix" style="margin-left: 12.5%;">
                            <li style="width: 82%;">
                                <span class="btn btn-danger btn-sm btn-shrink"
                                      style="cursor:default;font-weight: normal;">Profile Under Approval</span>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <ul class="meta clearfix mt-5">
                    <li style="padding: 2px 0 2px;font-weight: bold;" class="blink"
                        onclick="window.location='express-interest'">Pending Interest - <span
                                style="display: inline;">
                            <?php if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) { ?>
                            <?= mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT e.ei_sender FROM expressinterest e LEFT JOIN register_view r 
                                ON e.ei_receiver=r.matri_id WHERE e.ei_receiver='" . $_SESSION["user_id"] . "' and e.trash_receiver='No' and
                                 e.trash_sender='No' and e.receiver_response='Pending' and r.status <> 'Suspended'")); ?>
                            <?php } ?>
                        </span>
                    </li>
                    <li style="padding: 2px 0 2px;" onclick="window.location='messages'">Message Received - <span
                                style="display: inline;">
                            <?php if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) { ?>
                            <?= mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from message m 
                                LEFT JOIN register_view r ON r.email = m.msg_from where m.msg_to='" . $_SESSION['email'] . "' and m.trash_receiver='No'")); ?>
                            <?php } ?>
                        </span>
                    </li>
                </ul>
            </div>

            <div class="dashboard-menu-wrapper">

                <div class="relative">
                    <div id="slicknav-mobile-dashboard"></div>
                </div>

                <div class="result-search-form-wrapper clearfix">
                    <h3 class="text-center">Search Profile</h3>
                    <form class="" method="post" action="search_result" style="padding-top: 10px;">
                        <input type="hidden" name="orderby" value="login">
                        <div class="inner" style="padding: 0px 10px;">
                            <div class="row">
                                <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                    <div class=" form-icon-right">
                                        <label for="dpd1">Age</label>
                                        <select name="frm_age" id="sideBarStartAge" class="form-control pr-10 pl-5 mb-10"
                                                <!--onchange="return validateField('start', 'sideBarEndAge', this.value);"-->>
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
                                            <option value="32">32</option>
                                            <option value="33">33</option>
                                            <option value="34">34</option>
                                            <option value="35">35</option>
                                            <option value="36">36</option>
                                            <option value="37">37</option>
                                            <option value="38">38</option>
                                            <option value="39">39</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                            <option value="42">42</option>
                                            <option value="43">43</option>
                                            <option value="44">44</option>
                                            <option value="45">45</option>
                                            <option value="46">46</option>
                                            <option value="47">47</option>
                                            <option value="48">48</option>
                                            <option value="49">49</option>
                                            <option value="50">50</option>
                                            <option value="51">51</option>
                                            <option value="52">52</option>
                                            <option value="53">53</option>
                                            <option value="54">54</option>
                                            <option value="55">55</option>
                                            <option value="56">56</option>
                                            <option value="57">57</option>
                                            <option value="58">58</option>
                                            <option value="59">59</option>
                                            <option value="60">60</option>
                                            <?php
                                            if(!empty($partAgeFrom) && !empty($partAgeTo)) { ?>
                                                <option value="<?= $partAgeFrom ?>" selected><?= $partAgeFrom ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                    <div class=" form-icon-right">
                                        <label for="dpd2">To</label>
                                        <select name="to_age" id="sideBarEndAge" class="form-control pr-10 pl-5 mb-10"
                                                <!--onchange="return validateField('end', 'sideBarStartAge', this.value);"-->>
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
                                            <option value="32">32</option>
                                            <option value="33">33</option>
                                            <option value="34">34</option>
                                            <option value="35">35</option>
                                            <option value="36">36</option>
                                            <option value="37">37</option>
                                            <option value="38">38</option>
                                            <option value="39">39</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                            <option value="42">42</option>
                                            <option value="43">43</option>
                                            <option value="44">44</option>
                                            <option value="45" selected>45</option>
                                            <option value="46">46</option>
                                            <option value="47">47</option>
                                            <option value="48">48</option>
                                            <option value="49">49</option>
                                            <option value="50">50</option>
                                            <option value="51">51</option>
                                            <option value="52">52</option>
                                            <option value="53">53</option>
                                            <option value="54">54</option>
                                            <option value="55">55</option>
                                            <option value="56">56</option>
                                            <option value="57">57</option>
                                            <option value="58">58</option>
                                            <option value="59">59</option>
                                            <option value="60">60</option>
                                            <?php
                                            if(!empty($partAgeFrom) && !empty($partAgeTo)) { ?>
                                                <option value="<?= $partAgeTo ?>" selected><?= $partAgeTo ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row gap-10">
                                <div class="col-xss-6 col-xs-6 col-sm-6">

                                    <div class=" form-spin-group">
                                        <label for="room-amount">Religion</label>
                                        <select name="religion[]" class="chosen-select form-control mb-10" data-placeholder="Religion" multiple>
                                            <option value="">Any</option>
                                            <?php
                                            $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                                ?>
                                                <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"
                                                <?= ($partReligion == $DatabaseCo->dbRow->religion_id) ? "selected" : "" ?>><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-xss-6 col-xs-6 col-sm-6">
                                    <label for="adult-amount">Marital Status </label>
                                    <select class="form-control mb-10 chosen-select" name="m_status[]" id="m_status" data-placeholder="Marital Status" multiple>
                                        <?php
                                        $maritalStatus = explode(",", str_replace(" ", "", $lookingFor));
                                        ?>
                                        <option value="">All Status</option>
                                        <option value="Unmarried" <?= (in_array('Unmarried', $maritalStatus)) ? "selected" : "" ?>>Unmarried</option>
                                        <option value="Widow/Widower" <?= (in_array('Widow/Widower', $maritalStatus)) ? "selected" : "" ?>>Widow/Widower</option>
                                        <option value="Divorcee" <?= (in_array('Divorcee', $maritalStatus)) ? "selected" : "" ?>>Divorcee</option>
                                        <option value="Separated" <?= (in_array('Separated', $maritalStatus)) ? "selected" : "" ?>>Separated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gap-10">
                                <div class="col-xss-12 col-xs-12 col-sm-12">
                                    <label for="child-amount">Education</label>
                                    <select class="chosen-select form-control mb-10" name="education_field[]" id="education_field"
                                            data-placeholder="Select Your Education" multiple>
                                        <option value="">Any Education</option>
                                        <?php
                                        $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");

                                        while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                            ?>
                                            <option value="<?php echo $DatabaseCo->dbRow->e_field_id ?>">
                                                <?php echo $DatabaseCo->dbRow->e_field_name ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xss-12 col-xs-12 col-sm-12 text-center">
                                    <label class="checkbox-inline check" style="margin: 4px 0 3px;">
                                        <input name="photo_search" type="checkbox" value="Yes" checked
                                               style="display: block;opacity: 1;margin-left: 0px;position: relative;">
                                        Photo Search
                                    </label>
                                </div>

                            </div>
                            <button class="btn btn-block btn-danger btn-md btn-icon mb-20 mt-10">Search <span
                                        class="icon"><i
                                            class="fa fa-search"></i></span>
                            </button>
                        </div>
                    </form>


                </div>

                <div class="result-search-form-wrapper clearfix">

                    <h3 class="text-center">Search Profile By ID</h3>
                    <form class="" method="post" action="search_result" style="padding-top: 10px;">
                        <div class="inner" style="padding: 0px 5px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                   style="margin-bottom: 0px;">
                                <tr style="">
                                    <td style="padding: 4px;">
                                        <input type="text" name="search_by_profile_id"
                                               class="form-control input-sm mb-10"
                                               placeholder="Enter Profile ID">
                                    </td>
                                    <td style="padding: 4px;">
                                        <input type="submit" name="search" value="Search"
                                               class="btn btn-danger btn-sm btn-shrink"
                                               style="cursor:pointer;"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-xs-6 text-center mb-10">
                        <button class="btn btn-primary btn-xs"
                                onclick="window.location.href='search';" title="Click for quick search"
                                style="letter-spacing: 0.5px; padding-top: 5px; padding-bottom: 5px; font-weight: normal; margin: 0px auto;text-transform: capitalize;">
                            Quick Search
                        </button>
                    </div>
                    <div class="col-xs-6 mb-10">
                        <button class="btn btn-xs btn-danger" onclick="window.location.href='my-matches'"
                                style="letter-spacing: 0.5px; padding-top: 5px; padding-bottom: 5px; font-weight: normal; margin: 0px auto;text-transform: capitalize;">
                            Show My Matches
                        </button>
                    </div>
                </div>


            </div>
        </div>

        <?php include 'advertise/ad_level_3.php' ?>
    </aside>
<?php } else {

}
?>
<script>
    /*function GetCaste1(context) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: 'web-services/match_part_caste_search',
            data: {
                religion: $("#match_part_religion1").val(),
                page: "homepage"
            },
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#CasteDivMatch1").html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }*/
    function GetCaste1(context) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'web-services/match_part_caste_search_sidebar',
            data: {
                religion: $("#match_part_religion1").val()
            },
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $("#match_part_caste1").html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

</script>
