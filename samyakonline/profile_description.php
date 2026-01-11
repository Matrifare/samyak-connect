<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 22-11-2018
 * Time: 11:31 PM
 */

include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();

if (empty($_SESSION['profile_suspended_id']))
    header('Location: index');
$sql = "select profile_text, family_details, part_expect from register_view where matri_id='" . $_SESSION['profile_suspended_id'] . "'";
$SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);
if ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) {
    $profileText = $DatabaseCo->dbRow->profile_text;
    $familyDetails = $DatabaseCo->dbRow->family_details;
    $partExpectations = $DatabaseCo->dbRow->part_expect;
}
?>

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
<div class="modal fade modal-border-transparent" id="suspendedProfileModal" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
        <div class="modal-content" style="box-shadow: none !important;">
            <div class="clear"></div>
            <div class="modal-body pb-10 text-center" id="">
                    <h5 class="section-header-3 text-danger">Profile description </h5>
                    <form id="suspended_form" method="post">
                    <p class="mb-20" style="font-style: normal;">To get more matching profiles it is better to fill all partner details  </p>
                    <div class="row">
                        <div class="col-xss-6 col-xs-4 col-sm-4"><label for="profile_text">Profile Text</label></div>
                        <div class="col-xss-6 col-xs-8 col-sm-8">
                        <textarea name="profile_text" class="form-control mb-5"
                                  id="profile_text"><?= htmlspecialchars_decode($profileText, ENT_QUOTES) ?? "" ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xss-6 col-xs-4 col-sm-4"><label for="about_my_family">Family Details</label>
                        </div>
                        <div class="col-xss-6 col-xs-8 col-sm-8">
                        <textarea name="about_my_family" class="form-control mb-5"
                                  id="about_my_family"><?= htmlspecialchars_decode($familyDetails, ENT_QUOTES) ?? "" ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xss-6 col-xs-4 col-sm-4"><label for="expectation"> Partner Expectations</label>
                        </div>
                        <div class="col-xss-6 col-xs-8 col-sm-8">
                        <textarea class="form-control mb-10" id="expectation"
                                  name="expectation"><?php echo htmlspecialchars_decode($partExpectations, ENT_QUOTES); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-4 col-xs-4 text-center">
                            <button type="submit" class="btn btn-danger btn-xs">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div id="response_suspended">
                    </div>
                   <p class="mb-20" style="font-style: normal;">After update please Wait for admin approval to display on profile</p></li>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JavaScript -->

<!-- jQuery -->
<script src="view_profile_res/vendors/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="view_profile_res/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Init JavaScript -->
<script>
    $(function () {
        $("#suspendedProfileModal").modal("show");

        $("#suspended_form").submit(function (e) {
            $.ajax({
                type: "POST",
                url: "web-services/update_profile",
                data: $("#suspended_form").serialize() + "&update_type=suspended",
                dataType: "json",
                cache: false,
                success: function (response) {
                    if (response.result == 'success') {
                        $("#response_suspended").addClass('text-success').removeClass('text-danger').html('Profile successfully updated and sent for approval').fadeIn('fast').fadeOut(10000);
                        $("#suspended_form").fadeOut('500');
                    } else {
                        $("#response_suspended").addClass('text-danger').removeClass('text-success').html('Profile updation failed, please check your details').fadeIn('fast').fadeOut(10000);
                    }
                }
            });
            e.preventDefault();
        });
    });
</script>
</body>

</html>
