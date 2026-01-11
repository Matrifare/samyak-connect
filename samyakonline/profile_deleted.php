<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 11-03-2020
 * Time: 11:44 PM
 */

include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
$configObj = new Config();

if (empty($_SESSION['profile_delete_id']))
    header('Location: index');
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
<div class="modal fade modal-border-transparent" id="deletedProfileModal" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
        <div class="modal-content" style="box-shadow: none !important;">
            <div class="clear"></div>
            <div class="modal-body pb-10 text-center" id="">
                    <h5 class="section-header-3 text-danger">Your Profile is under deletion process.</h5>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div id="response_deleted">
                    </div>
                    <a href="<?= "https://api.whatsapp.com/send?phone=919819886759&text=Hello,%0APlease recover my account. I have mistakenly deleted my profile." ?>"
                       title="Whatsapp"><i class="fa fa-whatsapp"></i>
                        Click to chat for recovering your account</a>
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
        $("#deletedProfileModal").modal("show");
    });
</script>
</body>

</html>
