<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 9/21/2018
 * Time: 10:40 PM
 */

?>
<li>

    <?php if ($fetch->photo1 != '') {
        ?>
        <img src="../photos/<?php echo $fetch->photo1; ?>" alt="<?php echo $fetch->username; ?>"
             style="height:56px; width:56px;"/>
        <?php
    } else {
        ?>
        <img src="../img/ne-no-photo-img.png" alt="<?php echo $fetch->username; ?>"
             style="height:56px; width:56px;" border="1"/>
        <?php
    }
    ?>
    <p class="users-list-name mb-0 mt-5"><?= $fetch->matri_id ?> - <?= ucfirst($fetch->firstname) ?></p>
    <p class="users-list-name mb-0 normal-font"><?= floor((time() - strtotime($fetch->birthdate)) / 31556926); ?> Years,
        <?php $ao3 = $fetch->height;
        $ft3 = (int)($ao3 / 12);
        $inch3 = $ao3 % 12;
        echo $ft3 . "ft" . " " . $inch3 . "in"; ?>
    </p>
    <p class="users-list-name mb-0 normal-font"><?= $fetch->m_status ?> From <?= ucfirst($fetch->city_name) ?></p>
    <p class="users-list-name mb-0 normal-font">
        <?php
        $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $fetch->matri_id . "'  GROUP BY a.edu_detail"));
        echo !empty($known_education['my_education']) ? $known_education['my_education'] : "-"; ?>
        | <?php echo !empty($fetch->ocp_name) ? $fetch->ocp_name : "-"; ?></p>
    <p class="users-list-name mb-0 normal-font">
        <?= date('d M y', strtotime($fetch->birthdate)) ?> | Native Place: <?= ucfirst($fetch->family_city) ?>
    </p>
    <p class="users-list-name mb-0 normal-font">
        <?= !empty($fetch->mobile) ? $fetch->mobile : "-" ?> / <?= !empty($fetch->phone) ? $fetch->phone : "-" ?>
    </p>
    <?php
    if(!$hideButtons) {
        ?>
        <div class="row mt-10 no-print" id="buttonContainer<?= $fetch->ei_id ?>">
            <div class="col-xs-12">
                <button id="accept<?= $fetch->ei_id ?>"
                        href="javascript:void(0);"
                        onclick="acceptMatch('<?= $fetch->ei_id ?>')"
                        class="btn btn-success btn-xs"
                        style="background: #005294; border-color: #005294;"
                        title="Accept Match">
                    <i class="fa fa-thumbs-up"></i>
                </button>
                |
                <button id="reject<?= $fetch->ei_id ?>"
                        href="javascript:void(0);"
                        onclick="rejectMatch('<?= $fetch->ei_id ?>')"
                        class="btn btn-danger btn-xs"
                        style="background: #D60D45; border-color: #D60D45;"
                        title="Decline Interest">
                    <i class="fa fa-thumbs-down"></i>
                </button>
            </div>
        </div>
        <div class="row mt-10">
            <div class="col-xs-12">
                <div class="text-success"><p
                            class="users-list-name mb-0 normal-font acceptedMatch<?= $fetch->ei_id ?>"></p></div>
                <div class="text-danger"><p
                            class="users-list-name mb-0 normal-font rejectedMatch<?= $fetch->ei_id ?>"></p></div>
            </div>
        </div>
        <?php
    }
    ?>
</li>
