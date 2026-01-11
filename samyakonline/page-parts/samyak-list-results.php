<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/21/2018
 * Time: 09:15 PM
 */


?>

    <div class="hotel-item-list">
    <div class="image" style="background-image:url(<?= trim(rtrim(include 'photo_search_path_result.php',' 1')) ?>);"></div>
    <div class="content">
        <div class="heading">
            <h4><?= htmlspecialchars_decode($Row->firstname, ENT_QUOTES) ?></h4>
            <p>
                <?php
                if (isset($_SESSION['samyak_search']) && !empty($_SESSION['samyak_search'])) {
                    ?>
                    <i class="glyphicon glyphicon-user font-size-14 ne_mrg_ri8_10"></i>
                    <span>Samyak ID : <?php echo strtoupper($Row->samyak_id); ?></span>
                <?php } else { ?>
                    <i class="glyphicon glyphicon-user font-size-14 ne_mrg_ri8_10"></i>
                    <span>Matri ID : <?php echo strtoupper($Row->matri_id); ?></span>
                <?php } ?>
            </p>
        </div>
        <?php
        $ao = $Row->height;
        $ft = (int)($ao / 12);
        $inch = $ao % 12;
        ?>
        <div class="short-info">
            <div class="row">
                <div class="col-xs-3">Age:</div>
                <div class="col-xs-3"> <?php echo floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Years'; ?></div>
                <div class="col-xs-3">Height:</div>
                <div class="col-xs-3"> <?php echo trim($ft . "ft" . " " . $inch . "in"); ?></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Religion:</div>
                <div class="col-xs-3">
                    <?php echo $Row->religion_name; ?>
                </div>
                <div class="col-xs-3">Last Online:</div>
                <div class="col-xs-3"><?= date('d M, Y', strtotime($Row->last_login)) ?></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Marital Status:</div>
                <div class="col-xs-3"><?= $Row->m_status; ?></div>
                <div class="col-xs-3">Education:</div>
                <div class="col-xs-3">
                    <?php
                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
                    echo $known_education['my_education']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3">Occupation:</div>
                <div class="col-xs-3"><?php echo $Row->ocp_name; ?></div>
                <div class="col-xs-3">Residence:</div>
                <div class="col-xs-3"><?php echo $Row->city_name ?></div>
            </div>
            <div class="row">
                <div class="col-xs-12">About Me:
                    <?php
                    if(!empty(trim($Row->profile_text))) { ?>
                        <?php echo substr(htmlspecialchars_decode($Row->profile_text, ENT_QUOTES), 0, 65) . '...'; ?>
                        <a target="_blank" href="memberFullProfile?user_id=<?php echo $Row->matri_id; ?>">Read More</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute-bottom">
        <p class="text-primary">
            <a target="_blank" href="<?php if (!isset($_SESSION['user_id'])) {
                echo "login.php";
            } else {
                echo "compose_msg.php?user_id=" . $Row->matri_id . "";
            } ?>" title="Send Message"><i class="fa fa-envelope"></i> Send Message</a>

            <?php
            if ($_SESSION['user_id'] != '') {
            $select = $DatabaseCo->dbLink->query("select sh_id from shortlist where to_id='" . $Row->matri_id . "' and from_id='" . $_SESSION['user_id'] . "'");
            if (mysqli_num_rows($select) == 0) {
            ?>
            <a href="javascript:;"
               onclick="run_shortlist('<?php echo $Row->matri_id; ?>')" title="Add to Shortlist">
                <span class="mh-5">|</span> <i class="fa fa-filter"></i> Shortlist
            </a>
        <?php } else { ?>
            <a href="javascript:;" onclick="remove_shortlist('<?php echo $Row->matri_id; ?>')"
               title="Remove From Shortlist">
                <span class="mh-5">|</span> <i class="fa fa-filter"></i> Shortlisted
            </a>
            <?php
        }
        $select1 = $DatabaseCo->dbLink->query("select block_id from block_profile where block_by='" . $_SESSION['user_id'] . "' and block_to='" . $Row->matri_id . "'");
        if (mysqli_num_rows($select1) == 0) {
            ?>
                <a href="javascript:;"
                   onclick="run_blocklist('<?php echo $Row->matri_id; ?>')" title="Add to Blocklist">
                    <span class="mh-5">|</span> <i class="fa fa-ban"></i> Blocklist
                </a>
        <?php } else { ?>
                <a href="javascript:;"
                   onclick="remove_blocklist('<?php echo $Row->matri_id; ?>')"
                   title="Remove From Blocklist">
                    <span class="mh-5">|</span> <i class="fa fa-ban"></i> Blocklisted
                </a>
        <?php }
        } ?>
            <a href="javascript:;" title="Send Interest"
               onclick="ExpressInterest('<?php echo $Row->matri_id; ?>', '<?= (isset($_SESSION['last_login']) && $_SESSION['last_login'] == 'first_time') ? 'No' : 'Yes' ?>')">
                <span class="mh-5">|</span> <i class="fa fa-paper-plane"></i> Send Interest
            </a>
        </p>
    </div>
    <div class="absolute-right">
        <div class="meta-option">
            <a href="#" class="tripadvisor-module">
                <div class="texting">
                    <?= $Row->matri_id; ?>
                </div>
                <div class="hover-underline"></div>
            </a>
        </div>
        <!--<div class="price-wrapper">
            <p class="price"><span class="block">start from</span><span class="number">$187</span> <span class="block">avg / night</span></p>
            <a href="#" class="btn btn-danger btn-sm">Details</a>
        </div>-->
    </div>
</div>

        <div class="col-sm-3 col-xs-6 mb-10">
            <a target="_blank" title="View Profile" href="memberFullProfile?user_id=<?php echo $Row->matri_id; ?>"
               class="destination-grid-sm-item">

                <div class="image">
                    <?php
                        $photo = "photos/watermark.php?image=$Row->photo1&watermark=watermark.png";
                        if(!file_exists($photo)){
                            if($Row->gender == 'Bride') {
                                $photo = "img/default-photo/no-photo-female.png";
                            } else {
                                $photo = "img/default-photo/no-photo-male.png";
                            }
                        }
                    ?>
                    <img src="<?= $photo ?>"
                         title="<?php echo $Row->matri_id; ?>" alt="<?php echo $Row->matri_id; ?>">
                </div>

                <div class="content text-darker">
                    <h5><?php echo $Row->matri_id; ?> - <?php echo $Row->firstname; ?></h5>
                    <?php $ao = $Row->height;
                    $ft = (int)($ao / 12);
                    $inch = $ao % 12;
                    echo $ft . "ft" . " " . $inch . "in"; ?>
                    , <?php echo floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Years'; ?><br/>
                    <?= $Row->ocp_name ?> from <?= $Row->city_name ?>
                </div>

            </a>

        </div>
