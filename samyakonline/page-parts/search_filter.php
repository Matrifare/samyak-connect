<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/15/2018
 * Time: 9:49 PM
 */
?>
<div class="sidebar-wrapper hidden-xss hidden-xs hidden-sm" style="padding:0px 0px 0px 30px; margin-bottom: 80px;">

    <aside>

        <div class="result-filter-wrapper clearfix">

            <h3><span class="icon"><i class="fa fa-sliders"></i></span> Filter</h3>

            <div class="another-toggle filter-toggle">
                <h4 class="">Age </h4>
                <div class="another-toggle-content">
                    <div class="another-toggle-inner">
                        <div class="range-slider-wrapper">
                            <input id="age_range"/>
                        </div>
                    </div>
                </div>

            </div>

            <div class="another-toggle filter-toggle">
                <h4 class="">Height</h4>
                <div class="another-toggle-content">
                    <div class="another-toggle-inner">
                        <div class="range-slider-wrapper">
                            <input id="height_range"/>
                        </div>
                    </div>
                </div>
            </div>

            <form id="search-filter" name="search-filter">
                <input type="hidden" id="from_height" value="<?= !empty(trim($fromheight)) ? $fromheight : 48 ?>"/>
                <input type="hidden" id="to_height" value="<?= !empty(trim($toheight)) ? $toheight : 85 ?>"/>
                <input type="hidden" id="from_age" value="<?= !empty(trim($t3)) ? $t3 : 18 ?>"/>
                <input type="hidden" id="to_age" value="<?= !empty(trim($t4)) ? $t4 : 60 ?>"/>
                <div class="another-toggle filter-toggle">
                    <h4 class="">Marital Status</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $search_array1 = explode(',', isset($_SESSION['m_status']) ? $_SESSION['m_status'] : "");
                            ?>
                            <div class="checkbox-block font-icon-checkbox">
                                <input id="filter_amenities-1" name="m_status" type="checkbox" value="Unmarried"
                                       class="checkbox" <?php
                                if (in_array('Unmarried', $search_array1)) {
                                    echo "checked";
                                } ?>/>
                                <label class="" for="filter_amenities-1">Unmarried</label>
                            </div>
                            <div class="checkbox-block font-icon-checkbox">
                                <input id="filter_amenities-2" name="m_status" type="checkbox" value="Widow/Widower"
                                       class="checkbox" <?php
                                if (in_array('Widow/Widower', $search_array1)) {
                                    echo "checked";
                                } ?>/>
                                <label class="" for="filter_amenities-2">Widow/Widower</label>
                            </div>
                            <div class="checkbox-block font-icon-checkbox">
                                <input id="filter_amenities-3" name="m_status" type="checkbox" value="Divorcee"
                                       class="checkbox" <?php
                                if (in_array('Divorcee', $search_array1)) {
                                    echo "checked";
                                } ?>/>
                                <label class="" for="filter_amenities-3">Divorcee</label>
                            </div>
                            <div class="checkbox-block font-icon-checkbox">
                                <input id="filter_amenities-4" name="m_status" type="checkbox" value="Separated"
                                       class="checkbox" <?php
                                if (in_array('Separated', $search_array1)) {
                                    echo "checked";
                                } ?>/>
                                <label class="" for="filter_amenities-4">Separated</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!--- Religion --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">Religion</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $search_array2 = explode(',', isset($_SESSION['religion']) ? $_SESSION['religion'] : "");
                            $counter = 1;
                            $SQL_STATEMENT_preligion = $DatabaseCo->dbLink->query("SELECT * FROM religion WHERE status='APPROVED' ORDER BY religion_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_preligion)) {
                                ?>
                                <div class="checkbox-block font-icon-checkbox">
                                    <input id="religion-<?= $counter ?>" name="religion" type="checkbox"
                                           class="checkbox"
                                           value="<?php echo $DatabaseCo->dbRow->religion_id; ?>"
                                        <?php
                                        if (in_array($DatabaseCo->dbRow->religion_id, $search_array2)) {
                                            echo "checked";
                                        } ?>/>
                                    <label class=""
                                           for="religion-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->religion_name; ?></label>
                                </div>
                                <?php
                                $counter++;
                            } ?>
                        </div>
                    </div>
                </div>
                <!--- End of Religion --->

                <!--- Country --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">Country</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $counter = 0;
                            $search_array3 = explode(',', isset($_SESSION['country']) ? $_SESSION['country'] : "");
                            $SQL_STATEMENT_pcountry = $DatabaseCo->dbLink->query("SELECT * FROM country WHERE status='APPROVED' order by country_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_pcountry)) {
                            if ($counter == 5){ ?>
                            <div id="country-more-less" class="collapse">
                                <div class="inner">
                                    <?php } ?>
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="country-<?= $counter ?>"
                                               name="country" type="checkbox" class="checkbox"
                                               value="<?php echo $DatabaseCo->dbRow->country_id; ?>"
                                            <?php
                                            if (in_array($DatabaseCo->dbRow->country_id, $search_array3)) {
                                                echo "checked";
                                            } ?>/>
                                        <label class=""
                                               for="country-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->country_name; ?></label>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    if ($counter > 5){ ?>
                                </div>
                            </div>
                        <?php } ?>
                            <button class="btn btn-more-less" type="button" data-toggle="collapse"
                                    data-target="#country-more-less">
                                Show more
                            </button>
                        </div>
                    </div>
                </div>
                <!--- End of Country --->

                <!--- City --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">City</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $counter = 0;
                            $search_array3 = explode(',', isset($_SESSION['city']) ? $_SESSION['city'] : "");
                            $SQL_STATEMENT_pcountry = $DatabaseCo->dbLink->query("SELECT * FROM city_view WHERE status='APPROVED' order by city_name");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_pcountry)) {
                            if ($counter == 5){ ?>
                            <div id="city-more-less" class="collapse">
                                <div class="inner">
                                    <?php } ?>
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="city-<?= $counter ?>"
                                               name="city_id" type="checkbox" class="checkbox"
                                               value="<?php echo $DatabaseCo->dbRow->city_id; ?>"
                                            <?php
                                            if (in_array($DatabaseCo->dbRow->city_id, $search_array3)) {
                                                echo "checked";
                                            } ?>/>
                                        <label class=""
                                               for="city-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->city_name; ?></label>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    if ($counter > 5){ ?>
                                </div>
                            </div>
                        <?php } ?>
                            <button class="btn btn-more-less" type="button" data-toggle="collapse"
                                    data-target="#city-more-less">Show
                                more
                            </button>
                        </div>
                    </div>
                </div>
                <!--- End of City --->

                <!--- Education Level --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">Education Level</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $counter = 0;
                            $search_array4 = explode(',', isset($_SESSION['education_level']) ? $_SESSION['education_level'] : "");
                            $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT e_level_id, e_level_name FROM education_level WHERE status='APPROVED' ORDER BY e_level_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                            if ($counter == 5){ ?>
                            <div id="education-level-more-less" class="collapse">
                                <div class="inner">
                                    <?php } ?>
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="education-level-<?= $counter ?>"
                                               name="education_level" type="checkbox" class="checkbox"
                                               value="<?php echo $DatabaseCo->dbRow->e_level_id; ?>"
                                            <?php
                                            if (in_array($DatabaseCo->dbRow->e_level_id, $search_array4)) {
                                                echo "checked";
                                            } ?>/>
                                        <label class=""
                                               for="education-level-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->e_level_name; ?></label>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    if ($counter > 5){ ?>
                                </div>
                            </div>
                        <?php } ?>
                            <button class="btn btn-more-less" type="button" data-toggle="collapse"
                                    data-target="#education-level-more-less">Show more
                            </button>
                        </div>
                    </div>
                </div>
                <!--- End of Education Level --->

                <!--- Education Field --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">Education Field</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $counter = 0;
                            $search_array4 = explode(',', isset($_SESSION['education_field']) ? $_SESSION['education_field'] : "");
                            $SQL_STATEMENT_edu = $DatabaseCo->dbLink->query("SELECT e_field_id, e_field_name FROM education_field WHERE status='APPROVED' ORDER BY e_field_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_edu)) {
                            if ($counter == 5){ ?>
                            <div id="education-field-more-less" class="collapse">
                                <div class="inner">
                                    <?php } ?>
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="education-field-<?= $counter ?>"
                                               name="education_field" type="checkbox" class="checkbox"
                                               value="<?php echo $DatabaseCo->dbRow->e_field_id; ?>"
                                            <?php
                                            if (in_array($DatabaseCo->dbRow->e_field_id, $search_array4)) {
                                                echo "checked";
                                            } ?>/>
                                        <label class=""
                                               for="education-field-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->e_field_name; ?></label>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    if ($counter > 5){ ?>
                                </div>
                            </div>
                        <?php } ?>
                            <button class="btn btn-more-less" type="button" data-toggle="collapse"
                                    data-target="#education-field-more-less">Show more
                            </button>
                        </div>
                    </div>
                </div>
                <!--- End of Education Field --->


                <!--- Occupation --->
                <div class="another-toggle filter-toggle">
                    <h4 class="">Occupation</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <?php
                            $counter = 0;
                            $search_array5 = explode(',', isset($_SESSION['occupation']) ? $_SESSION['occupation'] : "");
                            $SQL_STATEMENT_ocp = $DatabaseCo->dbLink->query("SELECT * FROM occupation WHERE status='APPROVED' ORDER BY ocp_name ASC");
                            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_ocp)) {
                            if ($counter == 5){ ?>
                            <div id="occupation-more-less" class="collapse">
                                <div class="inner">
                                    <?php } ?>
                                    <div class="checkbox-block font-icon-checkbox">
                                        <input id="occupation-<?= $counter ?>"
                                               name="occupation" type="checkbox" class="checkbox"
                                               value="<?php echo $DatabaseCo->dbRow->ocp_id; ?>"
                                            <?php
                                            if (in_array($DatabaseCo->dbRow->ocp_id, $search_array5)) {
                                                echo "checked";
                                            } ?>/>
                                        <label class=""
                                               for="occupation-<?= $counter ?>"><?php echo $DatabaseCo->dbRow->ocp_name; ?></label>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    if ($counter > 5){ ?>
                                </div>
                            </div>
                        <?php } ?>
                            <button class="btn btn-more-less" type="button" data-toggle="collapse"
                                    data-target="#occupation-more-less">Show more
                            </button>
                        </div>
                    </div>
                </div>
                <!--- End of Occupation --->


                <div class="another-toggle filter-toggle">
                    <h4 class="">Annual Income</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <div class="form-group mb-0">
                                <select class="custom-select" id="annual_income" name="annual_income"
                                        onchange="callFilter();">
                                    <option value=""> Select Annual Income</option>
                                    <?php
                                    $SQL_STATEMENT_annual_income = $DatabaseCo->dbLink->query("SELECT id, title FROM annual_income WHERE show_frontend='Y' AND delete_status='N'");

                                    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT_annual_income)) {
                                        ?>
                                        <option value="<?= $DatabaseCo->dbRow->title; ?>"
                                            <?= empty($_SESSION['annual_income']) ? "" : ($_SESSION['annual_income'] == $DatabaseCo->dbRow->title ? "selected" : "")
                                            ?>><?= $DatabaseCo->dbRow->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="another-toggle filter-toggle">
                    <h4 class="active">Profile Picture</h4>
                    <div class="another-toggle-content">
                        <div class="another-toggle-inner">
                            <div class="radio-block font-icon-radio">
                                <input id="radio_block_1" name="photo_search" type="radio" class="radio" value="Yes"
                                    <?php if ($_SESSION['photo_search'] == 'Yes') {
                                        echo "checked";
                                    } ?> />
                                <label class="" for="radio_block_1">With Picture</label>
                            </div>

                            <div class="radio-block font-icon-radio">
                                <input id="radio_block_2" name="photo_search" type="radio" class="radio"
                                       value=""/>
                                <label class="" for="radio_block_2">Does not matter</label>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <div class="mb-20"></div>
        <?php include 'advertise/ad_level_3.php'; ?>
        <div class="mb-20"></div>

    </aside>


</div>