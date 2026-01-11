<?php
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
$configObj = new Config();

/*$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$isMob = is_numeric(strpos($ua, "mobile"));*/
?>
<div class="tab-style-01-wrapper mb-20">
    <ul id="detailTab" class="tab-nav clearfix">
        <li class="active"><a href="#tab_1-01" data-toggle="tab">Quick Search</a></li>
        <li><a href="#tab_1-02" data-toggle="tab">Advanced Search</a></li>
        <li><a href="#tab_1-03" data-toggle="tab">ID Search</a></li>
        <li class="hidden-sm hidden-xs hidden-xss"><a href="#tab_1-04" data-toggle="tab">Keyword Search</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="tab_1-01"
             style="padding: 10px;background: rgba(0, 0, 0, .7);color:rgba(255, 255, 255, 1);">
            <form class="" name="search" method="POST" action="search_result">
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-1 col-sm-10">
                        <?php
                        if (empty($_SESSION['gender123'])) {
                            ?>
                            <div class="col-xss-12 col-xs-6 col-sm-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control mb-5">
                                    <?php
                                    if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Groom') { ?>
                                        <option value="Bride" selected>Female</option>
                                    <?php } else if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Bride') { ?>
                                        <option value="Groom">Male</option>
                                    <?php } else { ?>
                                        <option value="Bride" selected>Female</option>
                                        <option value="Groom">Male</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-xss-12 col-xs-6 col-sm-3">
                            <label for="m_status_quick_search">Looking For</label>
                            <select class="chosen-select form-control mb-5"
                                    name="m_status[]"
                                    id="m_status_quick_search"
                                    data-placeholder=" Select Marital Status"
                                    multiple>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Widow/Widower">Widow/Widower</option>
                                <option value="Divorcee">Divorcee</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                        <div class="col-xss-12 col-xs-6 col-sm-3">
                            <div class="row">
                                <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                    <label for="">Age From</label>
                                    <select title="from age" name="frm_age"
                                            class="form-control mb-5">
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
                                        <option value="42">41</option>
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
                                    </select>
                                </div>
                                <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                    <label for="">Age To</label>
                                    <select title="to age" name="to_age"
                                            class="form-control mb-5">
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
                                        <option value="42">41</option>
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
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xss-12 col-xs-6 col-sm-3">
                            <div class="row">
                                <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                    <label>Height From</label>
                                    <select title="from height"
                                            class="form-control mb-5"
                                            name="from_height">
                                        <option value="48">4ft less</option>
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
                                <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                    <label>Height To</label>
                                    <select title="to height" class="form-control mb-5"
                                            name="height_to"
                                            id="height_to">
                                        <option value="48">4ft less</option>
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
                                        <option value="72" selected>6ft</option>
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
                        </div>
                        <div class="col-xss-6 col-xs-6 col-sm-3 pr-5">
                            <label for="search_religion_quick_search">Religion</label>
                            <select name="religion[]"
                                    class="chosen-select form-control mb-5"
                                    data-placeholder=" Select Religion"
                                    id="search_religion_quick_search"
                                    onchange="GetCaste1(this, $('#search_caste_quick_search'));" multiple>
                                <?php

                                $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                    ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xss-6 col-xs-6 col-sm-3 pl-5">
                            <label for="search_caste_quick_search">Caste</label>
                            <select name="caste_id[]" id="search_caste_quick_search"
                                    class="chosen-select form-control mb-5"
                                    data-placeholder=" Select Caste" multiple>
                            </select>
                        </div>
                        <div class="col-xss-6 col-xs-6 col-sm-3 pr-5">
                            <label for="education_level_quick_search">Education Level</label>
                            <select class="chosen-select form-control mb-5"
                                    name="education_level[]"
                                    id="education_level_quick_search"
                                    data-placeholder=" Select Education Level"
                                    multiple>
                                <?php
                                $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");

                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                    ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>">
                                        <?php echo $DatabaseCo->dbRow->e_level_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xss-6 col-xs-6 col-sm-3 pl-5">
                            <label for="education_field_quick_search">Education Field</label>
                            <select class="chosen-select form-control mb-5"
                                    name="education_field[]"
                                    id="education_field_quick_search"
                                    data-placeholder=" Select Education" multiple>
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
                        <div class="col-xss-12 col-xs-6 col-sm-3">
                            <label for="residence_city_quick_search">Residence City</label>
                            <select name="city[]" id="residence_city_quick_search"
                                    class="chosen-select form-control mb-5"
                                    data-placeholder="Residence City" multiple>
                                <?php

                                $SQL_STATEMENT_mothertongue = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM city WHERE status='APPROVED' ORDER BY city_name ASC");
                                while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_mothertongue)) {
                                    ?>
                                    <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-1 col-sm-10">
                        <div class="col-xss-6 col-xs-6 col-sm-3 mt-10">
                            <select class="form-control mb-10"
                                    name="photo_search">
                                <option value="">Photo does not matter</option>
                                <option value="Yes" selected>With Photo</option>
                                <option value="No">Without Photo</option>
                            </select>
                        </div>
                        <div class="col-xs-6 col-md-2 text-center mt-10">
                            <button type="submit"
                                    class="btn btn-block btn-danger btn-md btn-icon">
                                Search <span class="icon"><i
                                            class="fa fa-search"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_1-02"
             style="padding: 10px;background: rgba(0, 0, 0, .7);color:rgba(255, 255, 255, 1);">
            <form class="" name="search" method="POST" action="search_result">
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-1 col-sm-10">
                        <div class="row">
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control mb-5">
                                    <?php
                                    if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Groom') { ?>
                                        <option value="Bride" selected>Female</option>
                                    <?php } else if (!empty($_SESSION['gender123']) && $_SESSION['gender123'] == 'Bride') { ?>
                                        <option value="Groom">Male</option>
                                    <?php } else { ?>
                                        <option value="Bride" selected>Female</option>
                                        <option value="Groom">Male</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="m_status">Marital Status</label>
                                <select class="chosen-select form-control mb-5"
                                        name="m_status[]"
                                        id="m_status"
                                        data-placeholder=" Select Marital Status"
                                        multiple>
                                    <option value="Unmarried">Unmarried</option>
                                    <option value="Widow/Widower">Widow/Widower</option>
                                    <option value="Divorcee">Divorcee</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <div class="row">
                                    <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                        <label for="from_age">From age</label>
                                        <select title="from age" name="frm_age"
                                                class="form-control mb-5">
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
                                            <option value="42">41</option>
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
                                        </select>
                                    </div>
                                    <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                        <label for="to_age">To age</label>
                                        <select title="to age" name="to_age"
                                                class="form-control mb-5">
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
                                            <option value="42">41</option>
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
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <div class="row">
                                    <div class="col-xss-6 col-xs-6 col-sm-6 pr-5">
                                        <label for="from_height">From Height</label>
                                        <select title="from height"
                                                class="form-control mb-5"
                                                name="from_height">
                                            <option value="48">4ft less</option>
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
                                    <div class="col-xss-6 col-xs-6 col-sm-6 pl-5">
                                        <label for="height_to">Height To</label>
                                        <select title="to height" class="form-control mb-5"
                                                name="height_to"
                                                id="height_to">
                                            <option value="48">4ft less</option>
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
                                            <option value="72" selected>6ft</option>
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="religion">Religion</label>
                                <select name="religion[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder=" Select Religion"
                                        id="search_religion"
                                        onchange="GetCaste1(this, $('#search_caste'));" multiple>
                                    <?php

                                    $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="search_caste">Caste</label>
                                <select name="caste_id[]" id="search_caste"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder=" Select Caste" multiple>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="occupation">Occupation</label>
                                <select class="chosen-select form-control mb-10"
                                        name="occupation[]"
                                        id="occupation"
                                        data-placeholder=" Select Occupation"
                                        multiple>
                                    <?php
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->ocp_id ?>">
                                            <?php echo $DatabaseCo->dbRow->ocp_name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="country">Country</label>
                                <select name="country_id[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder=" Select Country" multiple>
                                    <?php

                                    $SQL_STATEMENT_mothertongue = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM country WHERE status='APPROVED' ORDER BY country_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_mothertongue)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->country_id; ?>"><?php echo $DatabaseCo->dbRow->country_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="city">Residence City</label>
                                <select name="city[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder="Select City" multiple>
                                    <?php

                                    $SQL_STATEMENT_mothertongue = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM city WHERE status='APPROVED' ORDER BY city_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_mothertongue)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="family_origin">Family Origin</label>
                                <select name="family_origin[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder="Select Family Origin"
                                        multiple>
                                    <?php

                                    $SQL_STATEMENT_mothertongue = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM city WHERE status='APPROVED' ORDER BY city_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_mothertongue)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->city_id; ?>"><?php echo $DatabaseCo->dbRow->city_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="education_level">Education Level</label>
                                <select class="chosen-select form-control mb-5"
                                        name="education_level[]"
                                        id="education_level"
                                        data-placeholder=" Select Education Level"
                                        multiple>
                                    <?php
                                    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT * FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->e_level_id ?>">
                                            <?php echo $DatabaseCo->dbRow->e_level_name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="education_field">Education Field</label>
                                <select class="chosen-select form-control mb-5"
                                        name="education_field[]"
                                        id="education_field"
                                        data-placeholder=" Select Education" multiple>
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
                        </div>
                        <div class="row">
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="mtongue_id">Mothertongue</label>
                                <select name="mtongue_id[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder=" Select Mothertongue"
                                        multiple>
                                    <?php

                                    $SQL_STATEMENT_mothertongue = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM mothertongue WHERE status='APPROVED' ORDER BY mtongue_name ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_mothertongue)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->mtongue_id; ?>"><?php echo $DatabaseCo->dbRow->mtongue_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="special_case">Special case</label>
                                <select name="special_case[]"
                                        class="chosen-select form-control mb-5"
                                        data-placeholder="Select Special Case"
                                        multiple>
                                    <?php
                                    $SQL_STATEMENT_disability = $DatabaseCo->dbLink->query("SELECT DISTINCT disability FROM register_view where trim(disability) != '' ORDER BY disability ASC");
                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_disability)) {
                                        ?>
                                        <option value="<?php echo $DatabaseCo->dbRow->disability; ?>"><?php echo $DatabaseCo->dbRow->disability; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="other_caste">Other Caste</label>
                                <select class="form-control mb-10"
                                        name="other_caste">
                                    <option value="">Does not matter</option>
                                    <option value="1">Caste No Bar</option>
                                    <option value="0">Marry to same caste</option>
                                </select>
                            </div>
                            <div class="col-xss-6 col-xs-6 col-sm-3">
                                <label for="Photo_search">Photo?</label>
                                <select class="form-control mb-10"
                                        name="photo_search">
                                    <option value="">Photo does not matter</option>
                                    <option value="Yes" selected>With Photo</option>
                                    <option value="No">Without Photo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-offset-3 col-xs-6 col-md-offset-5 col-md-2 text-center">
                            <button type="submit"
                                    class="btn btn-block btn-danger btn-md btn-icon">
                                Search <span class="icon"><i
                                            class="fa fa-search"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_1-03"
             style="padding: 10px;background: rgba(0, 0, 0, .7);color:rgba(255, 255, 255, 1);">
            <form class="gap-10" name="search" method="POST" action="search_result">
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="">
                            <div class="row gap-10 padding-5">
                                <div class="col-xss-12 col-xs-12 col-sm-2 col-md-2">
                                    <label class="search_label" style="color: white !important;">Enter Id</label>
                                </div>
                                <div class="col-xss-12 col-xs-12 col-sm-10">
                                    <input type="text" name="txt_id_search" class="form-control"
                                           placeholder="Enter Id">
                                </div>
                            </div>
                            <div class="col-xs-offset-2 col-xs-8 col-md-offset-4 col-md-4 text-center">
                                <button type="submit"
                                        class="btn btn-block btn-danger btn-md btn-icon">
                                    Search <span class="icon"><i
                                                class="fa fa-search"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_1-04"
             style="padding: 10px;background: rgba(0, 0, 0, .7);color:rgba(255, 255, 255, 1);">
            <form class="gap-10" name="search" method="POST" action="search_result">
                <div class="row">
                    <div class="col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="">
                            <div class="row gap-10 padding-5">
                                <div class="col-xss-12 col-xs-12 col-sm-2 col-md-2">
                                    <label class="search_label" style="color: white !important;">Keyword</label>
                                </div>
                                <div class="col-xss-12 col-xs-12 col-sm-10">
                                    <input type="text" name="keyword" class="form-control"
                                           placeholder="Find profiles using First Name, Last Name, City etc. ">
                                </div>
                            </div>
                            <div class="col-xs-offset-2 col-xs-8 col-md-offset-4 col-md-4 text-center">
                                <button type="submit"
                                        class="btn btn-block btn-danger btn-md btn-icon">
                                    Search <span class="icon"><i
                                                class="fa fa-search"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--<script type="text/javascript" src="js/bootstrap-toolkit.min.js"></script>
<script type="text/javascript" src="js/device.js"></script>-->
<script>

    /*---------------Jquery Partener Caste Start-----------------*/
    function GetCaste1(context, responseContext) {
        $("#loader-animation-area").show();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'web-services/match_part_caste_search_sidebar',
            data: {
                religion: $(context).val()
            },
            error: function (e) {
                alert("There was a problem in fetching caste.");
            },
            success: function (data) {
                $(responseContext).html(data);
            },
            complete: function () {
                $("#loader-animation-area").hide();
            }
        });
    }

    /*Jquery Partener Caste End */
</script>