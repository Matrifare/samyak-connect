<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 11/30/2020
 * Time: 09:16 PM
 */
?>
<div class="inner animated" style="background: none;">
    <form class="row gap-20" method="post" enctype="" action="search_result"
          id="search_form">
        <input type="hidden" name="orderby" value="login">
        <div class="col-xss-6 col-xs-6 col-sm-12 col-md-2">

            <div class="typeahead-container form-group form-icon-right">

                <label class="destination-search-3">Looking For</label>

                <div class="typeahead-field">
                    <select name="gender" class="form-control">
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
            </div>

        </div>

        <div class="col-xss-6 col-xs-6 col-sm-3 col-md-3">
            <div class="row gap-10">
                <div class="col-xss-6 col-xs-6 col-sm-6">
                    <div class="form-group form-icon-right">
                        <label for="dpd1">Age</label>
                        <select name="frm_age" class="form-control pr-10 pl-5">
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
                        </select>
                    </div>
                </div>

                <div class="col-xss-6 col-xs-6 col-sm-6">
                    <div class="form-group form-icon-right">
                        <label for="dpd2">To</label>
                        <select name="to_age" class="form-control pr-10 pl-5">
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
                            <option value="38" selected>38</option>
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
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xss-12 col-xs-12 col-sm-6 col-md-3">
            <div class="row gap-10">
                <div class="col-xss-6 col-xs-6 col-sm-6">

                    <div class="form-group form-spin-group">
                        <label for="room-amount">Of Religion</label>
                        <select name="religion[]" class="form-control">
                            <option value="">Any</option>
                            <?php

                            $SQL_STATEMENT_religion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_religion)) {
                                ?>
                                <option value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"><?php echo $DatabaseCo->dbRow->religion_name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="col-xss-6 col-xs-6 col-sm-6">
                    <label for="adult-amount">Marital Status </label>
                    <select class="form-control" name="m_status[]" id="m_status"
                            data-placeholder="Marital Status">
                        <option value="">All Status</option>
                        <option value="Unmarried" <?php if (isset($_REQUEST['marital_status']) && $_REQUEST['marital_status'] == 'Unmarried') {
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
        </div>

        <div class="col-xss-6 col-xs-6 col-sm-6 col-md-2">

            <div class="row gap-10">
                <div class="col-xss-12 col-xs-12 col-sm-12">
                    <label for="child-amount">Education</label>
                    <select class="form-control" name="education_field[]" id="education_field"
                            data-placeholder="Select Your Education">
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
                <input id="photo_checkbox" name="photo_search" class="checkbox"
                       value="Yes" type="hidden">
            </div>

        </div>

        <div class="col-xs-6 col-xss-6 col-sm-12 col-md-2 mt-30">
            <button class="btn btn-block btn-danger btn-md btn-icon">Search <span
                        class="icon"><i
                            class="fa fa-search"></i></span></button>
        </div>

    </form>
</div>