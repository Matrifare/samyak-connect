<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/13/2018
 * Time: 8:48 PM
 */
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
error_reporting(0);
ini_set('display_errors', 0);
// to Sanitize database inputs for security purpose  starts //


$input = $_GET['profile'] ?? "";
$profile = sanitize($input);
$match = $_GET['match'] ?? "";
$match = sanitize($match);
$reverseProfile = hexdec($profile);
$reverseMatch = hexdec($match);
$key = 726925;
$reverseProfile = $reverseProfile / $key;
$reverseMatch = $reverseMatch / $key;
//$reverseMatch = '6487';
//Match Data
$sqlMatch = "select matri_id from register_view WHERE index_id=" . $reverseMatch;
$fetch = mysqli_fetch_array($DatabaseCo->getSelectQueryResult($sqlMatch));
$matriIdMatch = $fetch['matri_id'] ?? "";


//$reverseProfile = '6113';
$sql = "select matri_id from register_view WHERE index_id=" . $reverseProfile;
$fetch = mysqli_fetch_array($DatabaseCo->getSelectQueryResult($sql));
$matriId = $mid = $fetch['matri_id'] ?? "";

if (!empty($matriId)) {
    $SQL_STATEMENT = "SELECT r.*, p.p_plan,
                m.mtongue_id, m.mtongue_name, 
                rel.religion_id, rel.religion_name, 
                c.caste_id, c.caste_name, 
                con.country_id, con.country_name,
                st.state_id, st.state_name, 
                ct.city_id, ct.city_name, ct1.city_id, ct1.city_name as family_origin_city,
                des.desg_id, des.desg_name, 
                ocp.ocp_id, ocp.ocp_name,
				el.e_level_id, el.e_level_name,
				ef.e_field_id, ef.e_field_name,
				edtl.edu_id, edtl.edu_name
                FROM register r
                LEFT JOIN payments p ON r.matri_id = p.pmatri_id
                LEFT JOIN mothertongue m ON r.m_tongue = m.mtongue_id
                LEFT JOIN religion rel ON r.religion = rel.religion_id
                LEFT JOIN caste c ON r.caste = c.caste_id
                LEFT JOIN country con ON r.country_id = con.country_id
                LEFT JOIN state st ON r.state_id = st.state_id 
                LEFT JOIN city ct ON r.city = ct.city_id
                LEFT JOIN city ct1 ON r.family_origin = ct1.city_id
                LEFT JOIN designation des ON r.designation = des.desg_id
                LEFT JOIN occupation ocp ON r.occupation = ocp.ocp_id
				LEFT JOIN education_field ef ON r.education_field = ef.e_field_id
				LEFT JOIN education_level el ON r.education_level = el.e_level_id
				LEFT JOIN education_detail edtl ON r.edu_detail = edtl.edu_id
                WHERE r.matri_id = '" . $matriIdMatch . "'  AND r.status NOT IN ('Inactive', 'Suspended')";
    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);
    if (mysqli_num_rows($DatabaseCo->dbResult) > 0) {
        $Row = mysqli_fetch_object($DatabaseCo->dbResult); ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
            <title><?php echo $configObj->getConfigTitle(); ?></title>
            <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
            <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
            <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
            <!-- Google Fonts -->
            <!--<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
                  type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
                  rel='stylesheet' type='text/css'>-->
            <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="view_profile_res/dist/css/style.css?v=1.1" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
            <style>
                body {
                    color: #333;
                    font-family: 'Lato', sans-serif !important;
                    font-size: 14px;
                }

                .show-form-message {
                    display: none;
                }
            </style>
        </head>

        <body>
        <div class="container" style="padding-right: 0px; padding-left: 0px;">
            <div class="wrapper box-layout theme-1-active pimary-color-blue pt-0">
                <!-- Main Content -->
                <div class="page-wrapper pt-0">
                    <div class="container-fluid pt-0">
                        <div class="row" style="background-color: #c5073b; height: 40px; margin-bottom: 5px;">
                            <div class="col-sm-12" style="display:table-row">
                                <div class="col-sm-4" style="display:table-cell; padding-top: 7px;cursor: pointer;"
                                     onclick="window.close();">
                                <span>
                                    <i class="fa fa-arrow-left" style="color: white;"></i>
                                </span>
                                    <span style="font-size: 16px;color: white;"
                                          class="hidden-xs hidden-xss">Close Profile</span>
                                </div>
                                <div class="col-sm-8 hidden-sm hidden-xs hidden-xss"
                                     style="display: table-cell;padding-top: 5px;">
                                    <img src="logo/buddhist-matrimony.jpg" alt="Buddhist Matrimony"
                                         title="Buddhist Matrimony" align="right">
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="panel panel-default card-view  pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body  pa-0">
                                            <div class="profile-box">
                                                <!--<div class="profile-cover-pic">-->
                                                <!--<div class="fileupload btn btn-default">
                                                    <span class="btn-text">edit</span>
                                                    <input class="upload" type="file">
                                                </div>-->
                                                <!--<div class="profile-image-overlay"></div>
                                            </div>-->
                                                <div class="profile-info text-center mb-5">
                                                    <h6 class="capitalize-font txt-orange text-center ml-5 mt-5"
                                                        style="font-size: 12px;font-weight: bold;">
                                                        <?php echo htmlspecialchars_decode($Row->firstname, ENT_QUOTES); ?>
                                                        -
                                                        <?php echo $Row->matri_id; ?> |
                                                        <span style="color: #333;font-weight: normal; font-size:12px;">
                                                        Last Online
                                                    - <?= date('d M, Y', strtotime($Row->last_login)) ?>
                                                    </span>
                                                    </h6>
                                                    <div class="profile-img-wrap">
                                                        <a href="login" title="Login to View Photo">
                                                            <?php
                                                            if (isset($_SESSION['email']) &&
                                                                (trim($_SESSION['email']) == trim($Row->email)) &&
                                                                !empty(trim($Row->photo1)) &&
                                                                file_exists('photos_big/' . trim($Row->photo1))) {
                                                                $showPhoto = "photos_big/watermark?image=photos_big/" . trim($Row->photo1) . "&watermark=photos_big/watermark.png";
                                                            } else {
                                                                if (!empty(trim($Row->photo1)) && file_exists('photos/' . trim($Row->photo1)) && !empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') {
                                                                    $showPhoto = "photos_big/watermark?image=photos_big/" . trim($Row->photo1) . "&watermark=photos_big/watermark.png";
                                                                } else {
                                                                    if ($Row->gender == 'Groom') {
                                                                        if ($Row->photo_protect == 'Yes') {
                                                                            $showPhoto = "img/default-photo/photo-protected-male100.png";
                                                                        } else {
                                                                            $showPhoto = "img/default-photo/male-200.png";
                                                                        }
                                                                    } else {
                                                                        if ($Row->photo_protect == 'Yes') {
                                                                            $showPhoto = "img/default-photo/photo-protected-female.png";
                                                                        } else {
                                                                            $showPhoto = "img/default-photo/female-200.png";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <img class="inline-block mb-10"
                                                                 src="<?= $showPhoto ?>"
                                                                 alt="user"/></a>

                                                        <div class="photo-overlay text-center">
                                                            <p class="text-center"
                                                               style="font-size: 12px;"><?php echo floor((time() - strtotime($Row->birthdate)) / 31556926); ?>
                                                                Yrs, <?= $Row->m_status ?>, <?= $Row->religion_name ?>
                                                                ,<br/>
                                                                <?= $Row->ocp_name; ?> from <?= $Row->city_name; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <a href="login" class="btn btn-link btn-xs"
                                                               style="color: #D60D45;"
                                                               title="View Contact Detail"><i
                                                                        class="fa fa-phone"></i> View Contact Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($matriIdMatch)) {
                                                        $sqlInterest = "select id from personal_matches where matri_id_by='" . $matriId . "' and matri_id_to='" . $matriIdMatch . "' and status='4'";
                                                        $dataInterest = $DatabaseCo->dbLink->query($sqlInterest);
                                                        while ($RowMatch = mysqli_fetch_object($dataInterest)) {
                                                            ?>
                                                            <div class="row mt-10">
                                                                <div class="col-xs-12">
                                                                    <button id="accept<?= $RowMatch->id ?>"
                                                                            href="javascript:void(0);"
                                                                            onclick="acceptMatch('<?= $RowMatch->id ?>')"
                                                                            class="btn btn-success btn-xs"
                                                                            style="background: #005294; border-color: #005294;"
                                                                            title="Interested and Send Interest">
                                                                        <i class="fa fa-thumbs-up"></i> Interested
                                                                    </button>
                                                                    <button id="reject<?= $RowMatch->id ?>"
                                                                            href="javascript:void(0);"
                                                                            onclick="rejectMatch('<?= $RowMatch->id ?>')"
                                                                            class="btn btn-danger btn-xs"
                                                                            style="background: #D60D45; border-color: #D60D45;"
                                                                            title="Not Interested">
                                                                        <i class="fa fa-thumbs-down"></i> Not Interested
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-10">
                                                                <div class="col-xs-12">
                                                                    <div class="text-success acceptedMatch"></div>
                                                                    <div class="text-danger rejectedMatch"></div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pb-0">
                                            <div class="tab-struct custom-tab-1">
                                                <ul role="tablist" class="nav nav-tabs nav-tabs-responsive"
                                                    id="myTabs_8">
                                                    <li class="active" role="presentation"
                                                        style="display: inline-block;"><a data-toggle="tab"
                                                                                          id="profile_tab_8"
                                                                                          role="tab"
                                                                                          href="#profile_8"
                                                                                          aria-expanded="false"><span>profile</span></a>
                                                    </li>
                                                    <?php
                                                    if(!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
                                                        ?>
                                                        <li role="presentation" class="hidden-xs"><a
                                                                    data-toggle="tab" id="earning_tab_8"
                                                                    role="tab" href="#earnings_8"
                                                                    aria-expanded="false"><span>Partner Expectations</span></a>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="tab-content" id="myTabContent_8">
                                                    <div id="profile_8" class="tab-pane fade active in" role="tabpanel">
                                                        <div class="col-md-12">
                                                            <div class="pt-20">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p class="pb-10" style="font-weight: bold;"><i
                                                                                    class="fa fa-newspaper-o"></i> Basic
                                                                            Information
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-5 col-md-3 mb-7">Name:</div>
                                                                    <div class="col-xs-7 col-md-3 mb-7"><?php echo htmlspecialchars_decode($Row->firstname, ENT_QUOTES); ?></div>
                                                                    <div class="col-xs-5 col-md-3 mb-7">Age:</div>
                                                                    <div class="col-xs-7 col-md-3 mb-7"><?php echo floor((time() - strtotime($Row->birthdate)) / 31556926); ?>
                                                                        years
                                                                    </div>
                                                                    <?php
                                                                    if (!empty($Row->height)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Height:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                            $ao3 = $Row->height;
                                                                            $ft3 = (int)($ao3 / 12);
                                                                            $inch3 = $ao3 % 12;
                                                                            echo $ft3 . "ft" . " " . $inch3 . "in"; ?> </div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->weight)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Weight:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo $Row->weight ?? "-"; ?>
                                                                            kg
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->religion_name)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Religion:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo $Row->religion_name ?? "-"; ?>
                                                                            /<?php echo $Row->caste_name ?? "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->birthdate)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Date of
                                                                            Birth:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo date('d M, Y', strtotime($Row->birthdate)); ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->mtongue_name)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                            Tongue:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->mtongue_name) ? $Row->mtongue_name : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->m_status)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Marital Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->m_status) ? $Row->m_status : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if ($Row->m_status != 'Unmarried' && !empty($Row->status_children)) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-xs-5 col-md-3 mb-7">Children
                                                                                Status:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->status_children) ? $Row->status_children : "-"; ?></div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->complexion)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Skin Tone:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->complexion) ? $Row->complexion : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->bodytype)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Body type:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->bodytype) ? $Row->bodytype : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->diet)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Eating
                                                                            Habit:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->diet) ? $Row->diet : "-"; ?> </div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->drink)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Drinking:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->drink) ? $Row->drink : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->b_group)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Blood Group:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->b_group) ? $Row->b_group : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->smoke)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Smoking:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->smoke) ? $Row->smoke : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->disability)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Disability:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->disability) ? $Row->disability : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->profileby)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Posted By:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->profileby) ? $Row->profileby : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p class="pt-15 pb-10"
                                                                           style="font-weight: bold;"><i
                                                                                    class="fa fa-graduation-cap"></i>
                                                                            Educational
                                                                            and Professional Detail</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <?php
                                                                    if (!empty($Row->e_level_name)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Education:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?= $Row->e_level_name ?? "-" ?>
                                                                            in <?= $Row->e_field_name ?? "-" ?></div>
                                                                        <?php
                                                                    }
                                                                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
                                                                    if (!empty($known_education['my_education'])) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Qualification:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                            echo !empty($known_education['my_education']) ? $known_education['my_education'] : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->emp_in)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Employed
                                                                            in:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->emp_in) ? $Row->emp_in : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->ocp_name)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Occupation:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->ocp_name) ? $Row->ocp_name : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->monthly_sal)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Monthly
                                                                            Salary:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->monthly_sal) ? $Row->monthly_sal : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->income)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Annual
                                                                            Income:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->income) ? $Row->income : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if (!empty($Row->profile_text)) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <p class="pt-15 pb-10"
                                                                               style="font-weight: bold;"><i
                                                                                        class="fa fa-user"></i>
                                                                                About myself</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <?php echo html_entity_decode($Row->profile_text, ENT_QUOTES); ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p class="pb-10 mt-10"
                                                                           style="font-weight: bold;"><i
                                                                                    class="fa fa-users"></i> About
                                                                            My
                                                                            Family
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <?php
                                                                    if (!empty($Row->family_type)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family Type:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_type) ? $Row->family_type : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty(!empty($Row->family_status))) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_status) ? $Row->family_status : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->father_occupation)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Father
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->father_occupation) ? $Row->father_occupation : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->mother_occupation)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->mother_occupation) ? $Row->mother_occupation : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->no_of_brothers)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">No. of
                                                                            Brothers
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->no_of_brothers) ? $Row->no_of_brothers : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->no_of_sisters)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">No of
                                                                            Sisters:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->no_of_sisters) ? $Row->no_of_sisters : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->family_origin_city)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Origin
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_origin_city) ? $Row->family_origin_city : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->family_value)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Value
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_value) ? $Row->family_value : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->family_details) && $Row->family_details != 'Not Available') {
                                                                        ?>
                                                                        <div class="col-xs-12 mb-7">About My Family
                                                                            : <?php if ($Row->family_details != 'Not Available') {
                                                                                echo htmlspecialchars_decode($Row->family_details, ENT_QUOTES);
                                                                            } ?>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <p class="pt-15 pb-10"
                                                                           style="font-weight: bold;"><i
                                                                                    class="fa fa-map-marker"></i>
                                                                            Residence
                                                                            Detail</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <?php
                                                                    if (!empty($Row->city_name)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">City /
                                                                            Country:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->city_name) ? $Row->city_name : "-"; ?>
                                                                            - <?php echo !empty($Row->country_name) ? $Row->country_name : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->family_origin_city)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Origin:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_origin_city) ? $Row->family_origin_city : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->living_status)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Living
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->living_status) ? $Row->living_status : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->house_ownership)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">House
                                                                            Ownership:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->house_ownership) ? $Row->house_ownership : "-"; ?></div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if(!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
                                                                ?>
                                                                <div class="pt-20 pb-10 hidden-sm hidden-md hidden-lg">
                                                                    <div class="row">
                                                                        <div class="col-xs-12 text-center">
                                                                            <p class="pb-10" style="font-weight: bold;">
                                                                                <i
                                                                                        class="fa fa-star-o"></i>
                                                                                Partner
                                                                                Expectations <i
                                                                                        class="fa fa-star-o"></i>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <p class="pb-10" style="font-weight: bold;">
                                                                                <i
                                                                                        class="fa fa-newspaper-o"></i>
                                                                                Basic
                                                                                Information
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <?php
                                                                        if (!empty($Row->looking_for)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Looking
                                                                                For:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->looking_for) ? $Row->looking_for : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_frm_age)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Age:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_frm_age) ? $Row->part_frm_age : "-"; ?>
                                                                                to <?php echo !empty($Row->part_to_age) ? $Row->part_to_age : "-"; ?>
                                                                                years
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_height)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Height:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php $ao31 = $Row->part_height;
                                                                                $ft31 = (int)($ao31 / 12);
                                                                                $inch31 = $ao31 % 12;
                                                                                echo $ft31 . "ft" . " " . $inch31 . "in"; ?>
                                                                                to <?php $ao32 = $Row->part_height_to;
                                                                                $ft32 = (int)($ao32 / 12);
                                                                                $inch32 = $ao32 % 12;
                                                                                echo $ft32 . "ft" . " " . $inch32 . "in"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_religion = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', religion_name, ''SEPARATOR ', ' ) AS part_religion FROM register a INNER JOIN religion b ON FIND_IN_SET(b.religion_id, a.part_religion) > 0 where a.matri_id = '$mid'  GROUP BY a.part_religion"));
                                                                        if (!empty($part_religion['part_religion'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Religion:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_religion['part_religion']) ? $part_religion['part_religion'] : "-";
                                                                                ?>
                                                                                / <?php $part_caste = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', caste_name, ''SEPARATOR ', ' ) AS part_caste FROM register a INNER JOIN caste b ON FIND_IN_SET(b.caste_id, a.part_caste) > 0 where a.matri_id = '$mid'  GROUP BY a.part_caste"));
                                                                                echo !empty($part_caste['part_caste']) ? $part_caste['part_caste'] : "-";
                                                                                ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($part_mtongue['part_mtongue'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                                Tongue:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php $part_mtongue = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', mtongue_name, ''SEPARATOR ', ' ) AS part_mtongue FROM register a INNER JOIN mothertongue b ON FIND_IN_SET(b.mtongue_id, a.part_mtongue) > 0 where a.matri_id = '$mid'  GROUP BY a.part_mtongue"));
                                                                                echo !empty($part_mtongue['part_mtongue']) ? $part_mtongue['part_mtongue'] : "-";
                                                                                ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_bodytype)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Body
                                                                                Type:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_bodytype) ? $Row->part_bodytype : "-"; ?></div>
                                                                        <?php }
                                                                        $part_country = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', country_name, ''SEPARATOR ', ' ) AS part_country FROM register a INNER JOIN country b ON FIND_IN_SET(b.country_id, a.part_country_living) > 0 where a.matri_id = '$mid'  GROUP BY a.part_country_living"));
                                                                        if (!empty($part_country['part_country'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Country:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_country['part_country']) ? $part_country['part_country'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_city) > 0 where a.matri_id = '$mid'  GROUP BY a.part_city"));
                                                                        if (!empty($part_city['part_city'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">City:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_city']) ? $part_city['part_city'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_native_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_native_place) > 0 where a.matri_id = '$mid'  GROUP BY a.part_native_place"));
                                                                        if (!empty($part_city['part_native_city'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Native
                                                                                Place:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_native_city']) ? $part_city['part_native_city'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <p class="pt-15 pb-10"
                                                                               style="font-weight: bold;"><i
                                                                                        class="fa fa-graduation-cap"></i>
                                                                                Educational
                                                                                and Professional Detail</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <?php
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_level_name, ''SEPARATOR ', ' ) AS part_edu_level FROM register a INNER JOIN education_level b ON FIND_IN_SET(b.e_level_id, a.part_edu_level) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_level"));
                                                                        if (!empty($part_education['part_edu_level'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Level:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_education['part_edu_level']) ? $part_education['part_edu_level'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_field_name, ''SEPARATOR ', ' ) AS part_edu_field FROM register a INNER JOIN education_field b ON FIND_IN_SET(b.e_field_id, a.part_edu_field) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_field"));
                                                                        if (!empty($part_education['part_edu_field'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Field:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_education['part_edu_field']) ? $part_education['part_edu_field'] : "-"; ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_emp_in)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Employed
                                                                                in:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_emp_in) ? implode(", ", explode(",", $Row->part_emp_in)) : "-"; ?></div>
                                                                        <?php }
                                                                        $part_occupation = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', ocp_name, ''SEPARATOR ', ' ) AS part_occupation FROM register a INNER JOIN occupation b ON FIND_IN_SET(b.ocp_id, a.part_occupation) > 0 where a.matri_id = '$mid'  GROUP BY a.part_occupation"));
                                                                        if (!empty($part_occupation['part_occupation'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Occupation:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_occupation['part_occupation']) ? $part_occupation['part_occupation'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_income)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Annual
                                                                                Income:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_income) ? $Row->part_income : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php
                                                                    if (!empty($Row->part_expect) && $Row->part_expect != 'Not Available') {
                                                                        ?>
                                                                        <!--<div class="row">
                                                                            <div class="col-xs-12">
                                                                                <p class="pt-10 pb-15"
                                                                                   style="font-weight: bold;"><i
                                                                                            class="fa fa-user"></i>
                                                                                    Partner Expectation</p>
                                                                            </div>
                                                                        </div>-->
                                                                        <div class="row">
                                                                            <div class="col-xs-12">
                                                                                <?php echo htmlspecialchars_decode($Row->part_expect, ENT_QUOTES); ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if(!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
                                                        ?>
                                                        <div id="earnings_8" class="tab-pane fade hidden-xs"
                                                             role="tabpanel">
                                                            <div class="col-md-12">
                                                                <div class="pt-20 pb-10">
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <p class="pb-10" style="font-weight: bold;">
                                                                                <i
                                                                                        class="fa fa-newspaper-o"></i>
                                                                                Basic
                                                                                Information
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <?php
                                                                        if (!empty($Row->looking_for)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Looking
                                                                                For:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->looking_for) ? $Row->looking_for : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_frm_age)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Age:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_frm_age) ? $Row->part_frm_age : "-"; ?>
                                                                                to <?php echo !empty($Row->part_to_age) ? $Row->part_to_age : "-"; ?>
                                                                                years
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_height)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Height:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php $ao31 = $Row->part_height;
                                                                                $ft31 = (int)($ao31 / 12);
                                                                                $inch31 = $ao31 % 12;
                                                                                echo $ft31 . "ft" . " " . $inch31 . "in"; ?>
                                                                                to <?php $ao32 = $Row->part_height_to;
                                                                                $ft32 = (int)($ao32 / 12);
                                                                                $inch32 = $ao32 % 12;
                                                                                echo $ft32 . "ft" . " " . $inch32 . "in"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_religion = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', religion_name, ''SEPARATOR ', ' ) AS part_religion FROM register a INNER JOIN religion b ON FIND_IN_SET(b.religion_id, a.part_religion) > 0 where a.matri_id = '$mid'  GROUP BY a.part_religion"));
                                                                        if (!empty($part_religion['part_religion'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Religion:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_religion['part_religion']) ? $part_religion['part_religion'] : "-";
                                                                                ?>
                                                                                / <?php $part_caste = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', caste_name, ''SEPARATOR ', ' ) AS part_caste FROM register a INNER JOIN caste b ON FIND_IN_SET(b.caste_id, a.part_caste) > 0 where a.matri_id = '$mid'  GROUP BY a.part_caste"));
                                                                                echo !empty($part_caste['part_caste']) ? $part_caste['part_caste'] : "-";
                                                                                ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        $part_mtongue = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', mtongue_name, ''SEPARATOR ', ' ) AS part_mtongue FROM register a INNER JOIN mothertongue b ON FIND_IN_SET(b.mtongue_id, a.part_mtongue) > 0 where a.matri_id = '$mid'  GROUP BY a.part_mtongue"));
                                                                        if (!empty($part_mtongue['part_mtongue'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                                Tongue:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_mtongue['part_mtongue']) ? $part_mtongue['part_mtongue'] : "-";
                                                                                ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_bodytype)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Body
                                                                                Type:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_bodytype) ? $Row->part_bodytype : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_country = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', country_name, ''SEPARATOR ', ' ) AS part_country FROM register a INNER JOIN country b ON FIND_IN_SET(b.country_id, a.part_country_living) > 0 where a.matri_id = '$mid'  GROUP BY a.part_country_living"));
                                                                        if (!empty($part_country['part_country'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Country:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_country['part_country']) ? $part_country['part_country'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_city) > 0 where a.matri_id = '$mid'  GROUP BY a.part_city"));
                                                                        if (!empty($part_city['part_city'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">City:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_city']) ? $part_city['part_city'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_native_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_native_place) > 0 where a.matri_id = '$mid'  GROUP BY a.part_native_place"));
                                                                        if (!empty($part_city['part_native_city'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Native
                                                                                Place:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_native_city']) ? $part_city['part_native_city'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <p class="pt-15 pb-10"
                                                                               style="font-weight: bold;"><i
                                                                                        class="fa fa-graduation-cap"></i>
                                                                                Educational
                                                                                and Professional Detail</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <?php
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_level_name, ''SEPARATOR ', ' ) AS part_edu_level FROM register a INNER JOIN education_level b ON FIND_IN_SET(b.e_level_id, a.part_edu_level) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_level"));
                                                                        if (!empty($part_education['part_edu_level'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Level:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_education['part_edu_level']) ? $part_education['part_edu_level'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_field_name, ''SEPARATOR ', ' ) AS part_edu_field FROM register a INNER JOIN education_field b ON FIND_IN_SET(b.e_field_id, a.part_edu_field) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_field"));
                                                                        if (!empty($part_education['part_edu_field'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Field:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_education['part_edu_field']) ? $part_education['part_edu_field'] : "-"; ?>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_emp_in)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Employed
                                                                                in:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_emp_in) ? implode(", ", explode(",", $Row->part_emp_in)) : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        $part_occupation = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', ocp_name, ''SEPARATOR ', ' ) AS part_occupation FROM register a INNER JOIN occupation b ON FIND_IN_SET(b.ocp_id, a.part_occupation) > 0 where a.matri_id = '$mid'  GROUP BY a.part_occupation"));
                                                                        if (!empty($part_occupation['part_occupation'])) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Occupation:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_occupation['part_occupation']) ? $part_occupation['part_occupation'] : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        if (!empty($Row->part_income)) {
                                                                            ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Annual
                                                                                Income:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_income) ? $Row->part_income : "-"; ?></div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php
                                                                    if (!empty($Row->part_expect)) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-xs-12">
                                                                                <p class="pt-10 pb-15"
                                                                                   style="font-weight: bold;"><i
                                                                                            class="fa fa-user"></i>
                                                                                    Partner Expectation</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xs-12">
                                                                                <?php echo htmlspecialchars_decode($Row->part_expect, ENT_QUOTES); ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div id="settings_8" class="tab-pane fade" role="tabpanel">
                                                        <!-- Row -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <div class="panel-wrapper collapse in">
                                                                        <div class="panel-body pa-0">
                                                                            <div class="col-sm-12 col-xs-12">
                                                                                <div class="form-wrap">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /Row -->
                    </div>

                </div>
                <!-- /Main Content -->

            </div>
        </div>


        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Slimscroll JavaScript -->
        <script src="view_profile_res/dist/js/jquery.slimscroll.js"></script>

        <!-- Fancy Dropdown JS -->
        <script src="view_profile_res/dist/js/dropdown-bootstrap-extended.js"></script>

        <!-- Owl JavaScript -->
        <script src="view_profile_res/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

        <!-- Switchery JavaScript -->
        <script src="view_profile_res/vendors/bower_components/switchery/dist/switchery.min.js"></script>


        <!-- Gallery JavaScript -->
        <script src="view_profile_res/dist/js/isotope.js"></script>
        <script src="view_profile_res/dist/js/lightgallery-all.js"></script>
        <script src="view_profile_res/dist/js/froogaloop2.min.js"></script>
        <script src="view_profile_res/dist/js/gallery-data.js?v=1.0"></script>

        <!-- Init JavaScript -->
        <script src="view_profile_res/dist/js/init.js?v=2.0"></script>
        <script src="view_profile_res/dist/js/widgets-data.js"></script>
        <script type="text/javascript">
            function acceptMatch(match_id,) {
                $.ajax({
                    url: "web-services/privilege-match-accept",
                    type: "POST",
                    data: "match_id=" + match_id + '&match_status=accept',
                    cache: false,
                    beforeSend: function () {
                    },
                    success: function (response) {
                        $('#accept' + match_id + '').fadeOut('slow');
                        $('#reject' + match_id + '').fadeOut('slow');
                        $(".acceptedMatch").html("You expressed interest successfully");
                        setTimeout(function () {
                            $(".acceptedMatch").html("");
                        }, 5000);
                    },
                    complete: function () {
                    }
                });
            }

            function rejectMatch(match_id) {
                $.ajax({
                    url: "web-services/privilege-match-accept",
                    type: "POST",
                    data: "match_id=" + match_id + '&match_status=reject',
                    cache: false,
                    beforeSend: function () {
                    },
                    success: function (response) {
                        $('#accept' + match_id + '').fadeOut('slow');
                        $('#reject' + match_id + '').fadeOut('slow');
                        $(".rejectedMatch").html("Privilege Match Rejected Successfully");
                        setTimeout(function () {
                            $(".rejectedMatch").html("");
                        }, 5000);
                    },
                    complete: function () {
                    }
                });
            }
        </script>
        </body>

        </html>
        <?php
    }
} else {
    echo "<h1 style='text-align: center; color: red;'>Unauthorized URL.</h1>";
}