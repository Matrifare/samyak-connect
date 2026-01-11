<?php
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
include_once '../auth.php';
$configObj = new Config();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$matriId = !empty($_GET['matri_id']) ? htmlspecialchars($_GET['matri_id']) : "";
$username = !empty($_GET['name']) ? htmlspecialchars($_GET['name']) : "";
$sql = "select distinct email,mobile from register WHERE matri_id='$matriId' LIMIT 1";
$data = mysqli_fetch_object($DatabaseCo->dbLink->query($sql));
$email = $data->email ?? "";
$mobile = $data->mobile ?? "";
if (empty($matriId)) {
    echo "<h1>Unauthorized 401</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $matriId ?> - Message List</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!--<link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" type="text/css" href="plugins/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/libs/nifty-component.css"/>    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins          folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/all_check.css"/>
    <script type="text/javascript" src="js/util/redirection.js"></script>
    <link rel="stylesheet" href="css/libs/select2.css"/>
    <script type="text/javascript" src="js/util/location.js"></script>
    <script src="../js/swfobject.js" type="text/javascript"></script>
    <style type="text/css">
        body, td, th {
            font-family: "Open Sans", sans-serif;
        }

        .default {
            width: 200px !important;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e4e4e4;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .mt-5 {
            margin-top: 5px !important;
        }

        .users-list-name {
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
        }

        .normal-font {
            font-size: 11px !important;
            font-weight: normal !important;
        }
    </style>
</head>
<body class="skin-blue">        <!-- Content Header (Page header) -->
<section class="content">
    <?php
    $sql = "select DISTINCT r.index_id, r.username,r.matri_id,r.email,m.msg_content,m.msg_date
 FROM message m INNER JOIN register_view r ON m.msg_from = r.email WHERE m.msg_to='$email'
  and r.status <> 'Suspended' ORDER BY m.msg_date DESC";

    $data = $DatabaseCo->dbLink->query($sql);

    if ($data->num_rows > 0) {
        //        pagination($limit, $adjacent, $rows, $page);
        ?>
        <div class="box no-border">
            <?php
            $count = 1;
            $pageNo = 1;
            $text = "Hello *{$username} [{$matriId}],*%0A%0A*Total Received Message  - [{$data->num_rows}]*%0A%0A";
            while ($fetch = mysqli_fetch_object($data)) {
                $text .= "*{$count}) " . $fetch->matri_id . " | {$fetch->username}*%0AMessage received on ".date('d M, Y', strtotime($fetch->msg_date)).": %0A%0A*Message*:  " . urlencode($fetch->msg_content) . "%0A%0A*View profile*:" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
                $text .= "----------------------------------------------------%0A%0A";
                $count++;
            }
            $text .= "%0A%0A*Thanks,*%0A*Samyakmatrimony Team*"; ?>
            <a id="clickLink"
               href="<?= "https://api.whatsapp.com/send?phone=91" . (strlen($mobile) == 13 ? substr($mobile, 3, 10) : $mobile) . "&text={$text}" ?>"
               title="Whatsapp"><i class="fa fa-whatsapp"></i> Send</a>
            <script>document.getElementById("clickLink").click();</script>
        </div>
        <?php
//pagination($limit, $adjacent, $rows, $page);
    } else {
        ?>
        <h1 class="text-center text-danger">No Data Found to send.</h1>
    <?php }
    ?>
</section>
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>    <!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>   <!--jquery for left menu active class-->
<script type="text/javascript" src="dist/js/general.js"></script>
<script type="text/javascript" src="dist/js/cookieapi.js"></script>
<script type="text/javascript">        setPageContext("members", "express-interest-reminder");    </script>
<!--jquery for left menu active class end-->    <!-- DATA TABES SCRIPT -->
<!--<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->    <!-- SlimScroll -->
<script type="text/javascript" src="plugins/datatables/datatables.min.js"></script>
<!--<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->    <!-- FastClick -->
<!--<script src='plugins/fastclick/fastclick.min.js'></script>-->    <!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">
    var win = null;
    function newWindow(mypage, myname, w, h, features) {
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        if (winl < 0) winl = 0;
        if (wint < 0) wint = 0;
        var settings = 'height=' + h + ',';
        settings += 'width=' + w + ',';
        settings += 'top=' + wint + ',';
        settings += 'left=' + winl + ',';
        settings += features;
        win = window.open(mypage, myname, settings);
        win.window.focus();
    }
</script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        var refreshRequired = false;
        $("input[name=action_id]").click(function () {
            $("#selectall").prop("checked", false);
        });
        //     js for Check/Uncheck all CheckBoxes by Checkbox     //
        $("#selectall").click(function () {
            $(".second").prop("checked", $("#selectall").prop("checked"))
        })
        // add details //
        var t = $('#example123').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [[1, 'asc']],
            "pageLength": 100,
            "lengthMenu": [[100, 250, 500, 1000, 2000, -1], [100, 250, 500, 1000, 2000, "All"]],
        });
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
</body>
</html>