<?php
include_once 'DatabaseConnection.php';
include_once 'auth.php';
include_once 'lib/sendmail.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();
//error_reporting(E_ERROR);
//ini_set('display_errors', 1);
//To change the Membership Status if Account is activated from an Inactive Account
if (!empty($_SESSION['mem_status']) &&
    ($_SESSION['mem_status'] == 'Inactive') &&
    !empty($_GET['userId']) && ($_GET['userId'] != $_SESSION['user_id'])
) {
    $query = "select DISTINCT status from register where matri_id='" . trim($_SESSION['user_id']) . "'";
    $result = mysqli_fetch_object($DatabaseCo->dbLink->query($query));
    if ($result->status != 'Inactive') {
        $_SESSION['mem_status'] = $result->status;
    }
}

if (!empty($_SESSION['mem_status']) && ($_SESSION['mem_status'] == 'Suspended')
    && !empty($_GET['userId']) && ($_GET['userId'] != $_SESSION['user_id'])
) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title><?php echo $configObj->getConfigTitle(); ?></title>
        <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
        <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
        <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
        <!-- Custom CSS -->
        <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
        <style>
            body {
                color: #333;
                font-family: Microsoft Tai Le, Arial !important;
                font-size: 14px;
            }

            .show-form-message {
                display: none;
            }
        </style>
    </head>

    <body>
    <div class="modal fade modal-border-transparent" id="suspendedProfileModal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
            <div class="modal-content" style="box-shadow: none !important;">
                <div class="clear"></div>
                <div class="modal-body pb-10 text-center" id="">
                    <p>Your Profile is Suspended for doing Inappropriate activity.</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-sm btn-danger" data-dismiss="modal" onclick="window.close();">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->

    <!-- jQuery -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Init JavaScript -->
    <script type="text/javascript">
        $(function () {
            $("#suspendedProfileModal").modal("show");
        });
    </script>
    </body>

    </html>
    <?php
    return false;
} else if (!empty($_SESSION['mem_status']) && ($_SESSION['mem_status'] == 'Inactive')
    && !empty($_GET['userId']) && ($_GET['userId'] != $_SESSION['user_id'])
) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

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
        <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
        <style>
            body {
                color: #333;
                font-family: Microsoft Tai Le, Arial !important;
                font-size: 14px;
            }

            .show-form-message {
                display: none;
            }
        </style>
    </head>

    <body>
    <div class="modal fade modal-border-transparent" id="inactiveProfileModal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
            <div class="modal-content" style="box-shadow: none !important;">
                <div class="clear"></div>
                <div class="modal-body pb-10 text-center" id="">
                    <p>
                        <span style="font-weight: bold;" class="text-danger">Your Profile is Under Approval</span>,<br/>
                        please wait some time.</p><br/>
                    <p style="margin-bottom: 10px;">By verifying email address, mobile number, and Photo Id Proof trust score will be increased.
                        Profile having good trust score gets more interest from other users</p>

                    <p style="margin-bottom: 10px;">**Note - To verify your email, please check your email id, you should have received an email verification.</p>
                    <p>**Note - To verify your Photo ID proof, kindly send your photo id proof on
                        <a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a> or click on below button to send it on WhatsApp.</p>

                    <a target="_blank" class="btn btn-success btn-shrink btn-sm" style="background-color: #25d366; margin-bottom: 20px;"
                       href="https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - <?= trim($_SESSION['user_id']) ?>%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony."><i class="fa fa-whatsapp"></i> Send Now</a>

                    <p>For whatsapp support: <a style="color: red;"
                                                href="https://api.whatsapp.com/send?phone=917977993616&text=Hello *Samyakmatrimony Admin*,%0A%0APlease approve my profile <?= $_SESSION['user_id'] ?>">Click
                            Here</a></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-sm btn-danger" data-dismiss="modal" onclick="window.close();">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->

    <!-- jQuery -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Init JavaScript -->
    <script type="text/javascript">
        $(function () {
            $("#inactiveProfileModal").modal("show");
        });
    </script>
    </body>

    </html>
    <?php
    return false;
}
if (isset($_GET['userId']) && !empty($_GET['userId'])) {
    $mid = mysqli_real_escape_string($DatabaseCo->dbLink, $_GET['userId']);
} else {
    $mid = $_SESSION['user_id'];
}

if (!empty($mid) && ($mid != $_SESSION['user_id'])) {
    $status = " AND r.status NOT IN ('Inactive', 'Suspended')";
} else {
    $status = "";
}

$SQL_STATEMENT = "SELECT r.*, p.p_plan,
                m.mtongue_id, m.mtongue_name, 
                rel.religion_id, rel.religion_name, 
                c.caste_id, c.caste_name, 
                con.country_id, con.country_name,
                st.state_id, st.state_name, 
                ct.city_id, ct.city_name, ct1.city_id,
                ct1.city_name as family_origin_city,
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
                WHERE r.matri_id = '" . $mid . "' $status";
$DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);
if (mysqli_num_rows($DatabaseCo->dbResult) > 0) {
    $Row = mysqli_fetch_object($DatabaseCo->dbResult);

    //Check if There is Pending Profile Views
    $sqlLimit = "select (profile - r_profile) as remaining_profiles from payments where pmatri_id='" . $_SESSION['user_id'] . "'";
    $resultLimit = mysqli_fetch_object($DatabaseCo->getSelectQueryResult($sqlLimit));

    $sql_block = "select block_to from block_profile where block_to='" . $_SESSION['user_id'] . "' and block_by='" . $mid . "'";
    $result_block = $DatabaseCo->getSelectQueryResult($sql_block);
    if (mysqli_num_rows($result_block) == 0) {
        $whocheck = $DatabaseCo->dbLink->query("SELECT * FROM who_viewed_my_profile where my_id='" . $_SESSION['user_id'] . "' and viewed_member_id='$mid'");

        if (mysqli_num_rows($whocheck) == 0) {
            if (trim($_SESSION['user_id']) != trim($mid)) {
                //Checking if Free Plan then check the Profiles Per Day
                if (!empty($_SESSION['membership']) && $_SESSION['membership'] == 'Free') {
                    $result3 = $DatabaseCo->dbLink->query("SELECT * FROM site_config, membership_plan where plan_name='Free'");
                    $rowcc = mysqli_fetch_array($result3);
                    $profilePerDay = $rowcc['profile_view_per_day'];
                    $sqlProfile = $DatabaseCo->dbLink->query("select count(DISTINCT viewed_member_id) as profile_view_per_day from who_viewed_my_profile where my_id='" . $_SESSION['user_id'] . "' and viewed_date LIKE '" . date('Y-m-d') . "%'");
                    $rowProfileCount = mysqli_fetch_object($sqlProfile);

                    //Count of Profiles Viewed till Date
                    $sqlProfileTotal = $DatabaseCo->dbLink->query("select count(DISTINCT viewed_member_id) as profile_viewed_till_date from who_viewed_my_profile where my_id='" . $_SESSION['user_id'] . "'");
                    $rowProfileCountTotal = mysqli_fetch_object($sqlProfileTotal);

                    if (!empty($rowProfileCount) && $rowProfileCount->profile_view_per_day >= $profilePerDay) {
                        $subject = $_SESSION['user_id'] . " has viewed " . $rowProfileCount->profile_view_per_day . " profiles";
                        $emailTemplate = '<p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10 "></i>Matri Id :
                                            </span>
                                            <span> ' . $_SESSION['user_id'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-user ne_mrg_ri8_10"></i>Name :
                                            </span>
                                            <span>
                                                ' . $_SESSION['uname'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Plan Name:
                                            </span>
                                            <span>
                                             ' . $_SESSION['membership'] . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-phone ne_mrg_ri8_10"></i>Total Profile Views as on ' . date('d M, Y H:i:s') . ':
                                            </span>
                                            <span>
                                             ' . $rowProfileCountTotal->profile_viewed_till_date . '
                                            </span>
                                        </p>
                                        <p class="ne_font_weight_nrm inline">
                                            <span class="ne_mrg_ri8_10">
                                         <i class="fa fa-mobile ne_mrg_ri8_10"></i>Mobile:
                                            </span>
                                            <span>
                                               ' . $_SESSION['mobile'] . '
                                            </span>
                                        </p>';
                        $from = $rowcc['from_email'];
                        $to = $rowcc['to_email'];
                        send_email_from_samyak($from, $to, $subject, $emailTemplate);
                        ?>
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>

                            <meta name="viewport"
                                  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
                            <title><?php echo $configObj->getConfigTitle(); ?></title>
                            <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
                            <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
                            <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>"
                                  rel="shortcut icon"/>
                            <!-- Google Fonts -->
                            <!--<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
                                  type='text/css'>
                            <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
                                  rel='stylesheet' type='text/css'>-->
                            <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                            <!-- Custom CSS -->
                            <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet"
                                  type="text/css">
                            <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
                            <style>
                                body {
                                    color: #333;
                                    font-family: Microsoft Tai Le, Arial !important;
                                    font-size: 14px;
                                }

                                .show-form-message {
                                    display: none;
                                }
                            </style>
                        </head>

                        <body>
                        <!-- BEGIN # MODAL EXPRESS INTEREST -->
                        <div class="modal fade modal-border-transparent" id="profileViewModal" tabindex="-1"
                             role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg" style="margin-top: 50px;">
                                <div class="modal-content">
                                    <button type="button" class="btn btn-close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    padding: 5px;
    margin-top: -30px;
    float: right;
    color: white;" data-dismiss="modal">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <div class="modal-body pb-10">
                                        <p style='margin-top:-10px; color:#ff0000;'><b>Please upgrade your profile to
                                                continue viewing profile.<br/>You have exceeded the limit for today.</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- jQuery -->
                        <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

                        <!-- Bootstrap Core JavaScript -->
                        <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

                        <!-- Init JavaScript -->
                        <script type="text/javascript">
                            $(function () {
                                $("#profileViewModal").modal("show");
                            });
                        </script>
                        </body>

                        </html>
                        <?php
                        exit;
                    }
                }

                $insert = $DatabaseCo->dbLink->query("insert into who_viewed_my_profile(my_id,viewed_member_id,viewed_date) values('" . $_SESSION['user_id'] . "','$mid','" . date('Y-m-d H:i:s') . "')");
                $updatePayment = $DatabaseCo->dbLink->query("update payments set r_profile = r_profile+1 where pmatri_id='" . $_SESSION['user_id'] . "'");
            }
        } else {
            $update = $DatabaseCo->dbLink->query("update who_viewed_my_profile set my_id='" . $_SESSION['user_id'] . "',viewed_member_id='$mid',viewed_date='" . date('Y-m-d H:i:s') . "' where my_id='" . $_SESSION['user_id'] . "' and viewed_member_id='$mid'");
        }
        if (!empty($resultLimit->remaining_profiles) && $resultLimit->remaining_profiles > 0) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>

                <meta name="viewport"
                      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
                <?php
                $title = "Buddhist Matrimony | " . $Row->matri_id . " | " . $Row->firstname . " | " .
                    floor((time() - strtotime($Row->birthdate)) / 31556926) . ' Yrs | ' .
                    $Row->ocp_name . " from " . $Row->city_name;
                ?>
                <title><?= $title ?></title>
                <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
                <meta name="description" content="<?= $title." | Buddhist vadhu var suchak mandal | Marriage bureau" ?>" />
                <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
                <!-- Google Fonts -->
                <!--<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet'
                      type='text/css'>
                <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic'
                      rel='stylesheet' type='text/css'>-->
                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                <!-- Custom CSS -->
                <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet"
                      type="text/css">
                <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
                <link rel="stylesheet" href="assets/owl.carousel.min.css">
                <style>
                    body {
                        color: #333;
                        font-family: Microsoft Tai Le, Arial !important;
                        font-size: 14px;
                    }

                    .show-form-message {
                        display: none;
                    }
                    .owl-prev, .owl-next {
                        width: 15px;
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                        display: block !important;
                        border:0px solid black;
                    }
                    .owl-prev { left: -15px; }
                    .owl-next { right: -15px; }
                    .owl-prev i, .owl-next i { color: #ccc;}
                </style>
            </head>

            <body>
        <span id="loader-animation-area">
            <img src="img/loader.gif" id="loader-icon-animated"/>
        </span>
        <div class="container" style="padding-right: 0px; padding-left: 0px;">
            <div class="wrapper box-layout theme-1-active pimary-color-blue pt-0">
                <!-- Main Content -->
                <div class="page-wrapper pt-0">
                    <div class="container-fluid pt-0">
                        <div class="row">
                            <div class="col-sm-12" style="background-color: #c5073b; height: 40px; margin: 0 auto 5px auto;
                                        position: fixed;z-index: 1000;width: 100%;left: 0;right: 0;">
                                <div class="col-sm-4"
                                    <?php if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "com.samyakmatrimony.app") { ?>
                                        onclick="window.history.back();"
                                    <?php } else { ?>
                                        onclick="window.close();"
                                    <?php } ?>
                                     style="display:table-cell; padding-top: 7px;cursor: pointer;">
                                <span>
                                    <i class="fa fa-arrow-left" style="color: white;"></i>
                                </span>
                                    <span style="font-size: 16px;color: white;"
                                          class="hidden-sm hidden-md hidden-lg">Back to Results</span>
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
                        <div class="row" style="margin-top: 45px;">
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
                                                        style="font-size: 13px;font-weight: bold;">
                                                        <?php echo htmlspecialchars_decode($Row->firstname, ENT_QUOTES); ?>
                                                        -
                                                        <?php echo $Row->matri_id; ?> |
                                                        <span style="color: #333;font-weight: normal; font-size:12px;">
                                                        Last Online
                                                    - <?= date('d M, Y', strtotime($Row->last_login)) ?>
                                                    </span>
                                                    </h6>
                                                    <div class="profile-img-wrap">
                                                        <?php
                                                        $statusPhoto = "";
                                                        if ((!empty($_SESSION['photo1']) && file_exists('photos/' . $_SESSION['photo1'])) ||
                                                            (!empty(trim($Row->photo2)) && file_exists('photos/' . trim($Row->photo2))) ||
                                                            (!empty(trim($Row->photo3)) && file_exists('photos/' . trim($Row->photo3))) ||
                                                            (!empty(trim($Row->photo4)) && file_exists('photos/' . trim($Row->photo4)))) {
                                                            $statusPhoto = 'open';
                                                        } else {
                                                            $statusPhoto = 'shut';
                                                        }
                                                        ?>
                                                        <a href="javascript:void(0);"
                                                           onclick="viewPhotos('<?= $statusPhoto ?>');">
                                                            <?php
                                                            $isPhotoPresent = true;
                                                            $photoViewStatus = $Row->photo_view_status;
                                                            if ($Row->p_plan == 'Silver' || $Row->p_plan == 'Gold' || $Row->p_plan == 'Premium' || $Row->p_plan == 'Gold Plus' || $Row->p_plan == 'Premium Plus') { ?>
                                                                <div class="mask"></div>
                                                            <?php }
                                                            if ((trim($_SESSION['email']) == trim($Row->email)) && !empty(trim($Row->photo1)) &&
                                                                file_exists('photos_big/' . trim($Row->photo1))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo1) . "&watermark=photos_big/watermark.png";
                                                            } else if (!empty(trim($Row->photo1)) && file_exists('photos/' . trim($Row->photo1)) &&
                                                                ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo1) . "&watermark=photos_big/watermark.png";
                                                            } else if ((trim($_SESSION['email']) == trim($Row->email)) && !empty(trim($Row->photo2))
                                                                && file_exists('photos_big/' . trim($Row->photo2))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo2) . "&watermark=photos_big/watermark.png";
                                                            } else if (!empty(trim($Row->photo2)) && file_exists('photos/' . trim($Row->photo2)) &&
                                                                ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo2) . "&watermark=photos_big/watermark.png";
                                                            } else if ((trim($_SESSION['email']) == trim($Row->email)) && !empty(trim($Row->photo3))
                                                                && file_exists('photos_big/' . trim($Row->photo3))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo3) . "&watermark=photos_big/watermark.png";
                                                            } else if (!empty(trim($Row->photo3)) && file_exists('photos/' . trim($Row->photo3)) &&
                                                                ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo3) . "&watermark=photos_big/watermark.png";
                                                            } else if ((trim($_SESSION['email']) == trim($Row->email)) && !empty(trim($Row->photo4))
                                                                && file_exists('photos_big/' . trim($Row->photo4))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo4) . "&watermark=photos_big/watermark.png";
                                                            } else if (!empty(trim($Row->photo4)) && file_exists('photos/' . trim($Row->photo4)) &&
                                                                ((!empty(trim($Row->photo_protect)) && $Row->photo_protect == 'No') || $photoViewStatus == 1 || ($photoViewStatus == 2 && $_SESSION['membership'] != 'Free'))) {
                                                                $showPhoto = "watermark?image=photos_big/" . trim($Row->photo4) . "&watermark=photos_big/watermark.png";
                                                            } else {
                                                                $isPhotoPresent = false;
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
                                                            ?>
                                                            <img class="inline-block mb-10"
                                                                 src="<?= $showPhoto ?>"
                                                                 alt="user"/></a>
                                                        <?php if(!$isPhotoPresent) { ?>
                                                            <div class="request-photo-block">
                                                                <button type="button" id="photo_request_btn" class="btn btn-xs">
                                                                    <i class="fa fa-camera-retro"></i>
                                                                    Request for Photo</button>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="photo-overlay text-left" style="display: table;">
                                                            <div class="" style="width: 90%;display: table-cell">
                                                                <p class="text-left pl-10"
                                                                   style="font-size: 12px;line-height: 16px;padding-bottom: 10px;"><?php echo floor((time() - strtotime($Row->birthdate)) / 31556926); ?>
                                                                    Yrs,
                                                                    <?php $ao3 = $Row->height;
                                                                    $ft3 = (int)($ao3 / 12);
                                                                    $inch3 = $ao3 % 12;
                                                                    echo "Height " . $ft3 . "'" . $inch3 . '"'; ?>,<br/>
                                                                    <?= $Row->m_status ?>, <?= $Row->religion_name ?>
                                                                    - <?= $Row->caste_name ?>
                                                                    <br/>
                                                                    <?= $Row->ocp_name; ?> from <?= $Row->city_name; ?>
                                                                </p>
                                                            </div>
                                                            <div class="pl-0 pt-10"
                                                                 style="width: 10%; display: table-cell;"
                                                                 onclick="viewPhotos('<?= $statusPhoto ?>');">
                                                                <i class="fa fa-photo" style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if (!empty($Row->video_url) && $Row->video_approval == 'APPROVED' && $Row->video_view_status == 1) {
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div id="play_video" class="text-center"
                                                                     onclick="viewVideo('<?php echo $Row->matri_id; ?>');">
                                                                            <span class="counts-text block">
                                                                                <label class="label label-danger"
                                                                                       style="border-radius: 0px; font-size:10px;"><i
                                                                                            class="fa fa-video-camera"></i></label> View Video
                                                                            </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="social-info">
                                                        <div class="row">
                                                            <?php
                                                            if ($_SESSION['user_id'] != $Row->matri_id) {
                                                                //Check if There is Pending Express Interest
                                                                $sqlExpressInterest = "select * from expressinterest where ei_sender='" . $_SESSION['user_id'] . "' and ei_receiver='" . $Row->matri_id . "' AND 
                                                                receiver_response='Pending' AND trash_receiver='No' AND trash_sender='No' LIMIT 1";
                                                                $resultExpressInterest = mysqli_fetch_object($DatabaseCo->getSelectQueryResult($sqlExpressInterest));
                                                                if (!empty($resultExpressInterest)) { ?>
                                                                    <div class="col-xs-6 text-left mt-10 mb-10" id="">
                                                                        <div id="send_interest_reminder_button"
                                                                             style="cursor: pointer;"
                                                                             onclick="sendReminder('<?= $resultExpressInterest->ei_id ?>', 'reminder');">
                                                                            <span class="counts-text block">
                                                                                <i class="fa fa-bell-o"></i> Remind Again
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="col-xs-6 text-left mt-10 mb-10" id="">
                                                                        <div id="send_interest_button"
                                                                             onclick="ExpressInterest('<?php echo $Row->matri_id; ?>', '<?= (isset($_SESSION['last_login']) && $_SESSION['last_login'] == 'first_time') ? 'No' : 'Yes' ?>')">
                                                                            <span class="counts-text block">
                                                                                <i class="fa fa-thumbs-o-up"></i> Send Interest
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="col-xs-6 text-left mt-10 mb-10 pl-10"
                                                                     id="sendMessageBox"
                                                                     onclick="view_message_box('<?= $Row->matri_id ?>')">
                                                                    <div id="send_message_button">
                                                                <span class="counts-text block">
                                                                    <i class="fa fa-envelope-o text-warning"></i>
                                                                    Send Message
                                                                </span>
                                                                    </div>
                                                                </div>
                                                                <?php if (empty($resultExpressInterest)) { ?>
                                                                    <div class="col-xs-6 text-left"
                                                                         style="padding-left:10px;padding-right: 0px">
                                                                        <div id="bookmark_profile_button"
                                                                             onclick="shortlist(this, '<?= $Row->matri_id ?>');"
                                                                             style="cursor: pointer; font-size: 13px;">
                                                                            <?php
                                                                            $sql = "select * from shortlist where from_id='" . $_SESSION['user_id'] . "' and to_id='" . $Row->matri_id . "'";
                                                                            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
                                                                            if (mysqli_num_rows($DatabaseCo->dbResult) > 0) { ?>
                                                                                <span class="head-font"><i
                                                                                            class="fa fa-star text-primary"></i> </span>
                                                                                <span class="counts-text">Remove Bookmark</span>
                                                                            <?php } else { ?>
                                                                                <span class="head-font"><i
                                                                                            class="fa fa-star-o text-primary"></i> </span>
                                                                                <span class="counts-text">Bookmark Profile</span>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="col-xs-6 text-left">
                                                                        <div id="bookmark_profile_button"
                                                                             onclick="deleteexprev('<?= $resultExpressInterest->ei_id ?>', 'sent');"
                                                                             style="cursor: pointer; font-size: 13px;">
                                                                            <span class="head-font"><i
                                                                                        class="fa fa-trash-o text-primary"></i> </span>
                                                                            <span class="counts-text"> Delete Interest</span>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="col-xs-6 text-left" id="">
                                                                    <div id="block_profile_button"
                                                                         onclick="block(this, '<?= $Row->matri_id ?>');"
                                                                         style="cursor: pointer;">
                                                                        <?php
                                                                        $sql = "select * from block_profile where block_by='" . $_SESSION['user_id'] . "' and block_to='" . $Row->matri_id . "'";
                                                                        $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sql);
                                                                        if (mysqli_num_rows($DatabaseCo->dbResult) > 0) { ?>
                                                                            <span class="head-font"><i
                                                                                        class="fa fa-check text-success"></i> </span>
                                                                            <span class="counts-text">Unblock Profile</span>
                                                                        <?php } else { ?>
                                                                            <span class="head-font"><i
                                                                                        class="fa fa-ban text-danger"></i> </span>
                                                                            <span class="counts-text">Block Profile</span>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }

                                                            if ($_SESSION['user_id'] != $Row->matri_id) {
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-xs-12 text-center">
                                                                        <button class="mt-10 mb-5 btn-sm btn-primary"
                                                                                style="margin: 0px auto;"
                                                                                id="showContactDetails"
                                                                                onclick="getContactDetail('<?php echo $Row->matri_id; ?>')">
                                                                            <i class="fa fa-mobile-phone"></i> View
                                                                            Contact Details
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>


                                                        <p class="capitalize-font text-center mb-5 hidden-sm hidden-xs hidden-xss">
                                                            <?php
                                                            $profileKey = dechex($Row->index_id * 726925);
                                                            ?>
                                                            <a href="whatsapp://send?text=<?= urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . $profileKey) ?>"><i
                                                                        class="fa fa-whatsapp"></i> Share Profile</a>
                                                        </p>

                                                    </div>
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
                                                    if (!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
                                                        ?>
                                                        <li role="presentation" class="hidden-xs"><a
                                                                    data-toggle="tab" id="earning_tab_8"
                                                                    role="tab" href="#earnings_8"
                                                                    aria-expanded="false"><span>Partner Expectations</span></a>
                                                        </li>
                                                        <?php
                                                    }
                                                    if (trim($Row->photo_protect) != 'Yes' && (
                                                            (!empty($_SESSION['photo1']) && file_exists('photos/' . trim($_SESSION['photo1']))) ||
                                                            (!empty(trim($Row->photo2)) && file_exists('photos/' . trim($Row->photo2))) ||
                                                            (!empty(trim($Row->photo3)) && file_exists('photos/' . trim($Row->photo3))) ||
                                                            (!empty(trim($Row->photo4)) && file_exists('photos/' . trim($Row->photo4))))) {
                                                        ?>
                                                        <li role="presentation" class="" style="display: inline-block;">
                                                            <a data-toggle="tab"
                                                               id="photos_tab_8"
                                                               role="tab" href="#photos_8"
                                                               aria-expanded="false"><span>photos</span></a>
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
                                                                </div>
                                                                <div class="row">
                                                                    <?php if (!empty($Row->height)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Height:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php $ao3 = $Row->height;
                                                                            $ft3 = (int)($ao3 / 12);
                                                                            $inch3 = $ao3 % 12;
                                                                            echo $ft3 . "ft" . " " . $inch3 . "in"; ?> </div>
                                                                    <?php }
                                                                    if (!empty($Row->weight)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Weight:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo $Row->weight ?? "-"; ?>
                                                                            kg
                                                                        </div>
                                                                    <?php }
                                                                    if (!empty($Row->religion_name)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Religion:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo $Row->religion_name ?? "-"; ?>
                                                                            /<?php echo $Row->caste_name ?? "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->birthdate)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Date of
                                                                            Birth:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo date('d M, Y', strtotime($Row->birthdate)); ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->mtongue_name)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                            Tongue:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->mtongue_name) ? $Row->mtongue_name : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->m_status)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Marital
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->m_status) ? $Row->m_status : "-"; ?></div>
                                                                    <?php }
                                                                    if ($Row->m_status != 'Unmarried') {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Children
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->status_children) ? $Row->status_children : "-"; ?></div>
                                                                        <?php
                                                                    }
                                                                    if (!empty($Row->complexion) && $Row->complexion != 'Not Available') {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Skin Tone:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->complexion) ? $Row->complexion : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->bodytype) && $Row->bodytype != 'Not Available' ) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Body type:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->bodytype) ? $Row->bodytype : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->diet) && $Row->diet != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Eating
                                                                            Habit:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->diet) ? $Row->diet : "-"; ?> </div>
                                                                    <?php }
                                                                    if ($Row->gender != 'Bride' && !empty($Row->drink) && trim($Row->drink) == 'Yes') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Drinking:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->drink) ? $Row->drink : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->b_group) && $Row->b_group != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Blood Group:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->b_group) ? $Row->b_group : "-"; ?></div>
                                                                    <?php }
                                                                    if ($Row->gender != 'Bride' && !empty($Row->smoke) && trim($Row->smoke) == 'Yes') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Smoking:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->smoke) ? $Row->smoke : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->disability)) {
                                                                        ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Disability:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->disability) ? $Row->disability : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->profileby)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Posted By:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->profileby) ? $Row->profileby : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->profile_text)) { ?>
                                                                        <div class="col-xs-12 mb-7">
                                                                            <?= html_entity_decode($Row->profile_text, ENT_QUOTES); ?>
                                                                        </div>
                                                                    <?php } ?>
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
                                                                    if (!empty($Row->e_level_name)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Education:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?= $Row->e_level_name ?? "-" ?>
                                                                            in <?= $Row->e_field_name ?? "-" ?></div>
                                                                    <?php }
                                                                    $known_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', edu_name, ''SEPARATOR ', ' ) AS my_education FROM register a INNER JOIN education_detail b ON FIND_IN_SET(b.edu_id, a.edu_detail) > 0 where a.matri_id = '" . $Row->matri_id . "'  GROUP BY a.edu_detail"));
                                                                    if (!empty($known_education['my_education'])) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">
                                                                            Qualification:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                            echo !empty($known_education['my_education']) ? $known_education['my_education'] : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->emp_in) && $Row->emp_in != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Employed in:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->emp_in) ? $Row->emp_in : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->ocp_name)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Occupation:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->ocp_name) ? $Row->ocp_name : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->monthly_sal)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Monthly
                                                                            Income:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->monthly_sal) ? $Row->monthly_sal : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->income) && $Row->income != 'Not Available' && $Row->income != 'No Income') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Annual
                                                                            Income:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->income) ? $Row->income : "-"; ?></div>
                                                                    <?php } ?>
                                                                </div>

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
                                                                    <?php if (!empty($Row->family_type) && $Row->family_type != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family Type: </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_type) ? $Row->family_type : "-"; ?></div>
                                                                    <?php }
                                                                    if ($Row->family_status && $Row->family_status != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family Status: </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_status) ? $Row->family_status : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->father_occupation) && $Row->father_occupation != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Father
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->father_occupation) ? $Row->father_occupation : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->mother_occupation) && $Row->mother_occupation != 'Not Available') { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->mother_occupation) ? $Row->mother_occupation : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->no_of_brothers)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">No. of
                                                                            Brothers
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->no_of_brothers) ? $Row->no_of_brothers : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->no_of_sisters)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">No of
                                                                            Sisters:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->no_of_sisters) ? $Row->no_of_sisters : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->family_origin)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Origin
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_origin_city) ? $Row->family_origin_city : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->family_value)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family Value
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_value) ? $Row->family_value : "-"; ?></div>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php
                                                                if (!empty(trim($Row->family_details)) && $Row->family_details != 'Not Available') {
                                                                    ?>
                                                                    <div class="col-xs-12 mb-7">
                                                                        <?php if (!empty($Row->family_details) && $Row->family_details != 'Not Available') {
                                                                            echo htmlspecialchars_decode($Row->family_details, ENT_QUOTES);
                                                                        } ?>
                                                                    </div>
                                                                <?php } ?>

                                                                <div class="row">
                                                                    <div class="col-sm-5 col-xs-12">
                                                                        <p class="pt-15 pb-10"
                                                                           style="font-weight: bold;"><i
                                                                                    class="fa fa-phone-square"></i>
                                                                            Contact
                                                                            Detail</p>
                                                                    </div>
                                                                    <div class="col-sm-7 col-xs-12">
                                                                        <button class="mt-10 mb-5 btn-sm btn-primary"
                                                                                style="margin: 0px auto;"
                                                                                onclick="getContactDetail('<?php echo $Row->matri_id; ?>')">
                                                                            <i class="fa fa-mobile-phone"></i> View
                                                                            Contact
                                                                            Details / Send Whatsapp Message
                                                                        </button>
                                                                    </div>
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
                                                                    <?php if (!empty($Row->city_name)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">City /
                                                                            Country:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->city_name) ? $Row->city_name : "-"; ?>
                                                                            - <?php echo !empty($Row->country_name) ? $Row->country_name : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->family_origin_city)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Family
                                                                            Origin:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->family_origin_city) ? $Row->family_origin_city : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->living_status)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">Living
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->living_status) ? $Row->living_status : "-"; ?></div>
                                                                    <?php }
                                                                    if (!empty($Row->house_ownership)) { ?>
                                                                        <div class="col-xs-5 col-md-3 mb-7">House
                                                                            Status:
                                                                        </div>
                                                                        <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->house_ownership) ? $Row->house_ownership : "-"; ?></div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            if (!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
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
                                                                        if (!empty($Row->looking_for)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Looking
                                                                                For:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->looking_for) ? $Row->looking_for : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->part_frm_age)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Age:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_frm_age) ? $Row->part_frm_age : "-"; ?>
                                                                                to <?php echo !empty($Row->part_to_age) ? $Row->part_to_age : "-"; ?>
                                                                                years
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_height)) { ?>
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
                                                                        <?php }
                                                                        $part_religion = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', religion_name, ''SEPARATOR ', ' ) AS part_religion FROM register a INNER JOIN religion b ON FIND_IN_SET(b.religion_id, a.part_religion) > 0 where a.matri_id = '$mid'  GROUP BY a.part_religion"));
                                                                        if (!empty($part_religion['part_religion'])) { ?>
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
                                                                        <?php }
                                                                        $part_mtongue = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', mtongue_name, ''SEPARATOR ', ' ) AS part_mtongue FROM register a INNER JOIN mothertongue b ON FIND_IN_SET(b.mtongue_id, a.part_mtongue) > 0 where a.matri_id = '$mid'  GROUP BY a.part_mtongue"));
                                                                        if (!empty($part_mtongue['part_mtongue'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                                Tongue:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_mtongue['part_mtongue']) ? $part_mtongue['part_mtongue'] : "-";
                                                                                ?>
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_bodytype)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Body
                                                                                Type:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_bodytype) ? $Row->part_bodytype : "-"; ?></div>
                                                                        <?php }
                                                                        $part_country = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', country_name, ''SEPARATOR ', ' ) AS part_country FROM register a INNER JOIN country b ON FIND_IN_SET(b.country_id, a.part_country_living) > 0 where a.matri_id = '$mid'  GROUP BY a.part_country_living"));
                                                                        if (!empty($part_country['part_country'])) { ?>

                                                                            <div class="col-xs-5 col-md-3 mb-7">Country:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_country['part_country']) ? $part_country['part_country'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_city) > 0 where a.matri_id = '$mid'  GROUP BY a.part_city"));
                                                                        if (!empty($part_city['part_city'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">City:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_city']) ? $part_city['part_city'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_native_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_native_place) > 0 where a.matri_id = '$mid'  GROUP BY a.part_native_place"));
                                                                        if (!empty($part_city['part_native_city'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Native
                                                                                Place:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_native_city']) ? $part_city['part_native_city'] : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->other_caste) && $Row->other_caste == 1) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Marry to
                                                                                other caste:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo (!empty($Row->other_caste) && $Row->other_caste == 1) ? "Yes" : "-"; ?></div>
                                                                        <?php } ?>
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
                                                                        if (!empty($part_education['part_edu_level'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Level:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_education['part_edu_level']) ? $part_education['part_edu_level'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_field_name, ''SEPARATOR ', ' ) AS part_edu_field FROM register a INNER JOIN education_field b ON FIND_IN_SET(b.e_field_id, a.part_edu_field) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_field"));
                                                                        if (!empty($part_education['part_edu_field'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Field:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_education['part_edu_field']) ? $part_education['part_edu_field'] : "-"; ?>
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_emp_in)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Employed
                                                                                in:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_emp_in) ? implode(", ", explode(",", $Row->part_emp_in)) : "-"; ?></div>
                                                                        <?php }
                                                                        $part_occupation = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', ocp_name, ''SEPARATOR ', ' ) AS part_occupation FROM register a INNER JOIN occupation b ON FIND_IN_SET(b.ocp_id, a.part_occupation) > 0 where a.matri_id = '$mid'  GROUP BY a.part_occupation"));
                                                                        if (!empty($part_occupation['part_occupation'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Occupation:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_occupation['part_occupation']) ? $part_occupation['part_occupation'] : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->part_expect) && $Row->part_expect != 'Not Available') {
                                                                            ?>
                                                                            <div class="col-xs-12 mb-7">
                                                                                <?= htmlspecialchars_decode($Row->part_expect, ENT_QUOTES); ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-xs-5">
                                                                    <p class="pt-15 pb-10"
                                                                       style="font-weight: bold;"><i
                                                                                class="fa fa-whatsapp"></i>
                                                                        Share
                                                                        Profile</p>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <p class="block capitalize-font text-left mt-5 mb-5 hidden-md hidden-lg">
                                                                        <?php
                                                                        $profileKey = dechex($Row->index_id * 726925);
                                                                        ?>
                                                                        <a class="btn btn-sm"
                                                                           style="background-color: #25d366;"
                                                                           href="whatsapp://send?text=<?= urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . $profileKey) ?>">
                                                                            <i class="fa fa-whatsapp"></i> Share Profile
                                                                        </a>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div id="photos_8" class="tab-pane fade" role="tabpanel">
                                                        <div class="col-md-12 pb-20 responsePhoto">
                                                            &nbsp;&nbsp;
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!($Row->part_frm_age <= '19' || $Row->part_height == '48')) {
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
                                                                        if (!empty($Row->looking_for)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Looking
                                                                                For:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->looking_for) ? $Row->looking_for : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->part_frm_age)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Age:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_frm_age) ? $Row->part_frm_age : "-"; ?>
                                                                                to <?php echo !empty($Row->part_to_age) ? $Row->part_to_age : "-"; ?>
                                                                                years
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_height)) { ?>
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
                                                                        <?php }
                                                                        $part_religion = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', religion_name, ''SEPARATOR ', ' ) AS part_religion FROM register a INNER JOIN religion b ON FIND_IN_SET(b.religion_id, a.part_religion) > 0 where a.matri_id = '$mid'  GROUP BY a.part_religion"));
                                                                        if (!empty($part_religion['part_religion'])) { ?>
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
                                                                        <?php }
                                                                        $part_mtongue = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT '', mtongue_name, ''SEPARATOR ', ' ) AS part_mtongue FROM register a INNER JOIN mothertongue b ON FIND_IN_SET(b.mtongue_id, a.part_mtongue) > 0 where a.matri_id = '$mid'  GROUP BY a.part_mtongue"));
                                                                        if (!empty($part_mtongue['part_mtongue'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Mother
                                                                                Tongue:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_mtongue['part_mtongue']) ? $part_mtongue['part_mtongue'] : "-";
                                                                                ?>
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_bodytype)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Body
                                                                                Type:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_bodytype) ? $Row->part_bodytype : "-"; ?></div>
                                                                        <?php }
                                                                        $part_country = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', country_name, ''SEPARATOR ', ' ) AS part_country FROM register a INNER JOIN country b ON FIND_IN_SET(b.country_id, a.part_country_living) > 0 where a.matri_id = '$mid'  GROUP BY a.part_country_living"));
                                                                        if (!empty($part_country['part_country'])) { ?>

                                                                            <div class="col-xs-5 col-md-3 mb-7">Country:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_country['part_country']) ? $part_country['part_country'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_city) > 0 where a.matri_id = '$mid'  GROUP BY a.part_city"));
                                                                        if (!empty($part_city['part_city'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">City:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_city']) ? $part_city['part_city'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_city = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_native_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_native_place) > 0 where a.matri_id = '$mid'  GROUP BY a.part_native_place"));
                                                                        if (!empty($part_city['part_native_city'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Native
                                                                                Place:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_city['part_native_city']) ? $part_city['part_native_city'] : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->other_caste) && $Row->other_caste == 1) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Marry to
                                                                                other Caste:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo (!empty($Row->other_caste) && $Row->other_caste == 1) ? "Yes" : "-"; ?></div>
                                                                        <?php } ?>
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
                                                                        if (!empty($part_education['part_edu_level'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Level:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_education['part_edu_level']) ? $part_education['part_edu_level'] : "-"; ?></div>
                                                                        <?php }
                                                                        $part_education = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT(DISTINCT '', e_field_name, ''SEPARATOR ', ' ) AS part_edu_field FROM register a INNER JOIN education_field b ON FIND_IN_SET(b.e_field_id, a.part_edu_field) > 0 where a.matri_id = '$mid'  GROUP BY a.part_edu_field"));
                                                                        if (!empty($part_education['part_edu_field'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Education
                                                                                Field:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7">
                                                                                <?php
                                                                                echo !empty($part_education['part_edu_field']) ? $part_education['part_edu_field'] : "-"; ?>
                                                                            </div>
                                                                        <?php }
                                                                        if (!empty($Row->part_emp_in)) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">Employed
                                                                                in:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php echo !empty($Row->part_emp_in) ? implode(", ", explode(",", $Row->part_emp_in)) : "-"; ?></div>
                                                                        <?php }
                                                                        $part_occupation = mysqli_fetch_array($DatabaseCo->dbLink->query("SELECT GROUP_CONCAT( DISTINCT ' ', ocp_name, ''SEPARATOR ', ' ) AS part_occupation FROM register a INNER JOIN occupation b ON FIND_IN_SET(b.ocp_id, a.part_occupation) > 0 where a.matri_id = '$mid'  GROUP BY a.part_occupation"));
                                                                        if (!empty($part_occupation['part_occupation'])) { ?>
                                                                            <div class="col-xs-5 col-md-3 mb-7">
                                                                                Occupation:
                                                                            </div>
                                                                            <div class="col-xs-7 col-md-3 mb-7"><?php
                                                                                echo !empty($part_occupation['part_occupation']) ? $part_occupation['part_occupation'] : "-"; ?></div>
                                                                        <?php }
                                                                        if (!empty($Row->part_expect) && $Row->part_expect != 'Not Available') {
                                                                            ?>
                                                                            <div class="col-xs-12 mb-7">
                                                                                <?= htmlspecialchars_decode($Row->part_expect, ENT_QUOTES); ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
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


                        <?php
                        if (!empty($_SESSION['premium_profiles'])) {
                            $sqlPremiumMembers = $_SESSION['premium_profiles'];
                            $dataPremiumMembers = $DatabaseCo->dbLink->query($sqlPremiumMembers);
                            if ($dataPremiumMembers->num_rows >= 8) { ?>
                                <h5 class="text-center" style="margin-bottom: 15px;">Premium Featured Profiles</h5>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="owl-carousel" id="premium_members_container">
                                            <?php while ($RowPremiumMembers = mysqli_fetch_object($dataPremiumMembers)) {
                                                @include "page-parts/samyak-premium-results.php";
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        } ?>

                        <div class="row hidden-sm hidden-md hidden-lg" style="margin-top: 60px;">
                            <div class="col-sm-12">
                                <div class="col-sm-12"
                                    <?php if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "com.samyakmatrimony.app") { ?>
                                        onclick="window.history.back();"
                                    <?php } else { ?>
                                        onclick="window.close();"
                                    <?php } ?>
                                     style="background-color: #c5073b; height: 40px; margin: 5px auto 0 auto;
                                        padding-top: 8px; text-align: center;
                                        position: fixed;z-index: 1000;width: 100%;left: 0;bottom:0;right: 0;cursor: pointer;">
                                    <span style="font-size: 16px;color: white;"
                                          class="hidden-sm hidden-md hidden-lg">Close Profile</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Main Content -->

        </div>
        </div>
        <!-- /#wrapper -->

        <!-- BEGIN # MODAL EXPRESS INTEREST -->
        <div class="modal fade modal-border-transparent" id="expressInterestModal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" style="margin-top: 50px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-close" style="background-color: rgba(0, 0 ,0, 0.6);
    border: 2px solid;
    padding: 5px;
    margin-top: -30px;
    float: right;
    color: white;" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="modal-body pb-10" id="contentExpressInterestModal"></div>
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

        <!-- BEGIN # MODAL CONTACT DETAIL -->
        <div class="modal fade modal-border-transparent" id="sendMsgModal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="clear"></div>
                    <div class="modal-body pb-10" id="msgContentModal"></div>
                </div>
            </div>
        </div>

        <!-- BEGIN # MODAL CONTACT DETAIL -->
        <div class="modal fade modal-border-transparent" id="viewVideoModal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="clear"></div>
                    <div class="text-center embed-responsive embed-responsive-16by9" id="viewVideoContentModal"></div>
                </div>
            </div>
        </div>


        <div class="modal fade modal-border-transparent" id="photoNotModal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm" style="border: 2px solid red; background-color: #fff;">
                <div class="modal-content" style="box-shadow: none !important;">
                    <div class="clear"></div>
                    <div class="modal-body pb-10 text-center" id="">
                        <p>View Photo Album, upload your photo,</p>
                        <p style="font-weight: bold;"><a href="edit_photo" target="_blank">Click Here photo
                                upload.</a>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JavaScript -->

        <!-- jQuery -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Slimscroll JavaScript -->
        <script type="text/javascript" src="view_profile_res/dist/js/jquery.slimscroll.js"></script>

        <!-- Fancy Dropdown JS -->
        <script type="text/javascript" src="view_profile_res/dist/js/dropdown-bootstrap-extended.js"></script>

        <!-- Owl JavaScript -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
        <!-- Switchery JavaScript -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/switchery/dist/switchery.min.js"></script>


        <!-- Gallery JavaScript -->
        <script type="text/javascript" src="view_profile_res/dist/js/isotope.js"></script>
        <script type="text/javascript" src="view_profile_res/dist/js/lightgallery-all.js"></script>
        <script type="text/javascript" src="view_profile_res/dist/js/froogaloop2.min.js"></script>
        <script type="text/javascript" src="<?= auto_version('view_profile_res/dist/js/gallery-data.js') ?>"></script>
        <!-- Init JavaScript -->
        <script type="text/javascript" src="<?= auto_version('view_profile_res/dist/js/init.js') ?>"></script>
        <script type="text/javascript" src="view_profile_res/dist/js/widgets-data.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#premium_members_container').owlCarousel({
                    loop: true,
                    nav: true,
                    margin: 5,
                    dots: false,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 6
                        },
                        1000: {
                            items: 8
                        }
                    },
                    autoplay: true,
                    navText: ['<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'],
                });

                <?php if(!empty($_GET['view_contact']) && $_GET['view_contact'] == 'yes') { ?>
                $("#showContactDetails").trigger('click');
                <?php }
                if(!empty($_GET['send_message']) && $_GET['send_message'] == 'yes') { ?>
                $("#sendMessageBox").trigger('click');
                <?php } ?>

                setTimeout(loadPhoto('<?= $Row->matri_id ?>'), 2000);
            });

            function viewVideo(matriId) {
                $.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "web-services/load-video", //Where to make Ajax calls
                    dataType: 'json',
                    data: {
                        "matri_id": matriId,
                    },
                    beforeSend: function () {
                        $("#loader-animation-area").show();
                        $("#viewVideoContentModal").html("");
                    },
                    success: function (response) {
                        try {
                            if (response.result == 'success') {
                                var ifrm = document.createElement("iframe");
                                ifrm.setAttribute("src", response.url);
                                ifrm.setAttribute("class", "embed-responsive-item")
                                ifrm.setAttribute("frameborder", "0");
                                ifrm.setAttribute("allowfullscreen", "");
                                ifrm.setAttribute("gesture", "autoplay");
                                ifrm.setAttribute("allow", "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture");
                                /*ifrm.style.width = "640px";
                                ifrm.style.height = "480px";*/
                                document.getElementById("viewVideoContentModal").appendChild(ifrm);
                                $("#viewVideoModal").modal("show");
                            } else if (response.result == 'failed') {
                                $("#viewVideoContentModal").html(response.message);
                                $("#viewVideoModal").modal("show");
                            } else {
                                alert("Oops! Something Went Wrong!!");
                            }
                        } catch (e) {
                            alert("Oops! Something Went Wrong!!");
                        }
                    },
                    complete: function () {
                        $("#loader-animation-area").hide();
                    }
                });
            }

            <?php if(!$isPhotoPresent) { ?>
            $(function() {
                $("#photo_request_btn").click(function (e) {
                    $.ajax({
                        type: "POST", // HTTP method POST or GET
                        url: "web-services/photo-request", //Where to make Ajax calls
                        dataType: 'json',
                        data: {
                            "matri_id": '<?= $Row->matri_id ?>',
                        },
                        beforeSend: function () {
                            $("#loader-animation-area").show();
                        },
                        success: function (response) {
                            try {
                                if(response.result == 'success') {
                                    alert("Success! You have successfully sent a photo request to this user.");
                                } else {
                                    alert("Oops! Something Went Wrong!!");
                                }
                            } catch (e) {
                                alert("Oops! Something Went Wrong!!");
                            }
                        },
                        complete: function () {
                            $("#loader-animation-area").hide();
                        }
                    });
                });
            });
            <?php } ?>
        </script>
            </body>

            </html>
        <?php } else {
            // If Profile View Limit Exceeded
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>

                <meta name="viewport"
                      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
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
                <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet"
                      type="text/css">
                <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
                <style>
                    body {
                        color: #333;
                        font-family: Microsoft Tai Le, Arial !important;
                        font-size: 14px;
                    }

                    .show-form-message {
                        display: none;
                    }
                </style>
            </head>

            <body>
            <div class="modal fade modal-border-transparent" id="limitExceedModal" tabindex="-1" role="dialog"
                 aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
                    <div class="modal-content" style="box-shadow: none !important;">
                        <div class="clear"></div>
                        <div class="modal-body pb-10 text-center" id="">
                            <p>Your Profile View Limit has exceeded.</p>
                            <p>Upgrade your Membership to view more profiles:
                                <a href="premium_member" style="color: red; font-weight: bold;">
                                    Click Here
                                </a></p>
                            <p>Send WhatsApp message to us:
                                <a href="https://wa.me/918237374783?text=Profile Id: <?= $_SESSION['user_id'] ?>,%0A%0AMy%20Profile%20View%20Limit%20Exceeded"
                                   style="color: red; font-weight: bold;">
                                    Click Here
                                </a></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-sm btn-danger" data-dismiss="modal" onclick="window.close();">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- JavaScript -->

            <!-- jQuery -->
            <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

            <!-- Init JavaScript -->
            <script type="text/javascript">
                $(function () {
                    $("#limitExceedModal").modal("show");
                });
            </script>
            </body>

            </html>

            <?php
        }
    } else { ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>

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
            <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
            <style>
                body {
                    color: #333;
                    font-family: Microsoft Tai Le, Arial !important;
                    font-size: 14px;
                }

                .show-form-message {
                    display: none;
                }
            </style>
        </head>

        <body>
        <div class="modal fade modal-border-transparent" id="blockedProfileModal" tabindex="-1" role="dialog"
             aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
                <div class="modal-content" style="box-shadow: none !important;">
                    <div class="clear"></div>
                    <div class="modal-body pb-10 text-center" id="">
                        <p>This user has blocked you, hence you cannot see his/her profile.</p>
                        <p>Contact to Samyakmatrimony Admin: <a
                                    href="https://api.whatsapp.com/send?phone=917977993616&text=Hello *Samyakmatrimony Admin*,%0A%0ANeed Help">Click
                                Here</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-danger" data-dismiss="modal" onclick="window.close();">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JavaScript -->

        <!-- jQuery -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Init JavaScript -->
        <script type="text/javascript">
            $(function () {
                $("#blockedProfileModal").modal("show");
            });
        </script>
        </body>

        </html>

    <?php }
} else { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

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
        <link href="<?= auto_version('view_profile_res/dist/css/style.css') ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
        <style>
            body {
                color: #333;
                font-family: Microsoft Tai Le, Arial !important;
                font-size: 14px;
            }

            .show-form-message {
                display: none;
            }
        </style>
    </head>

    <body>
    <div class="modal fade modal-border-transparent" id="noProfileModal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
            <div class="modal-content" style="box-shadow: none !important;">
                <div class="clear"></div>
                <div class="modal-body pb-10 text-center" id="">
                    <p>This user doesn't exist, possibly he/she chosen to delete his/her profile permanently.</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-sm btn-danger" data-dismiss="modal" onclick="window.close();">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->

    <!-- jQuery -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Init JavaScript -->
    <script type="text/javascript">
        $(function () {
            $("#noProfileModal").modal("show");
        });
    </script>
    </body>

    </html>
    <?php
}