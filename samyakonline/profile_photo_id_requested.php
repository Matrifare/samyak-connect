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

if (empty($_SESSION['profile_photo_id_requested']))
    return header('Location: index');

$sql = "select * from register_view where matri_id='" . $_SESSION['profile_photo_id_requested'] . "'";
$SQL_STATEMENT = $DatabaseCo->dbLink->query($sql);
$DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)
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
    </style>
</head>

<body>
<div class="modal fade modal-border-transparent" id="photoIdRequestedModal" tabindex="-1" role="dialog"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" style="border: 2px solid red; background-color: #fff;">
        <div class="modal-content" style="box-shadow: none !important;">
            <div class="clear"></div>
            <div class="modal-body pb-10 text-center" id="">
                <h5 class="section-header-3 text-danger">Your Profile is temporary locked for verifying yourself.</h5>
                <p class="mb-20" style="font-style: italic;">
                    You can send the photo ID on WhatsApp using below link.
                </p>
                <a href="<?= "https://api.whatsapp.com/send?phone=918237374783&text=Hello Samyakmatrimony Admin,%0AMatri ID - " . $_SESSION['profile_photo_id_requested'] . "%0A%0AI am uploading a photo ID to verify my ID on Samyakmatrimony." ?>"
                   class="btn btn-md btn-warning" title="Whatsapp"><i class="fa fa-whatsapp"></i>
                    Upload your Photo ID now</a>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <p class="mb-20" style="font-style: italic;">
                        If you already done it, you can use the
                        Click to chat button to verify your photo ID.
                    </p>
                    <a href="<?= "https://api.whatsapp.com/send?phone=918237374783&text=Hello,%0APlease verify my photo ID. I have sent it on WhatsApp ." ?>"
                       class="btn btn-md btn-success" title="Whatsapp"><i class="fa fa-whatsapp"></i>
                        Click to chat for requesting activation</a>
                </div>
            </div>
            <div class="row mt-10">
                <div class="col-xs-12 text-center mt-10">
                    <a href="index"><i class="fa fa-arrow-circle-left"></i> Return to Samyakmatrimony.com</a>
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
        $("#photoIdRequestedModal").modal("show");
    });
</script>
</body>

</html>
