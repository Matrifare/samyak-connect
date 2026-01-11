<?php
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once '../lib/Config.php';
include_once '../auth.php';
$configObj = new Config();
$records = !empty($_GET['records']) ? htmlspecialchars($_GET['records']) : "200";
$records = $records ?? 0;
$matriId = !empty($_GET['matri_id']) ? htmlspecialchars($_GET['matri_id']) : "";
if (empty($matriId)) {
    echo "<h1>Unauthorized 401</h1>";
    exit;
}
$sql = $DatabaseCo->dbLink->query("select * from register_view where matri_id='$matriId'");
$row = mysqli_fetch_array($sql);
$mobile = $row['mobile'] ?? "";
$lookingFor = $row['looking_for'];
$ageFrom = $row['part_frm_age'];
$ageTo = $row['part_to_age'];
$complexion = $row['part_complexion'];
$heightFrom = $row['part_height'];
$heightTo = $row['part_height_to'];
$religion = $row['part_religion'];
$caste = $row['part_caste'];
$education = $row['part_edu_field'];
$educationLevel = $row['part_edu_level'];
$partEmpIn = $row['part_emp_in'];
$country = $row['part_country_living'];
$nativePlace = $row['part_native_place'];
$city = $row['part_city'];
$gender = $row['gender'];
$orderby = "register";


if (!empty($lookingFor)) {
    $lookingFor = str_replace(",", "','", trim($lookingFor));
} else {
    $lookingFor = '';
}

if (!empty($partEmpIn)) {
    $partEmpIn = str_replace(",", "','", trim($partEmpIn));
} else {
    $partEmpIn = '';
}


if (!empty($city) && is_array($city)) {
    $city = implode(",", $city);
} else if (empty($city)) {
    $city = "";
}

if (!empty($nativePlace)) {
    $nativePlace = str_replace(",", "','", trim($nativePlace));
} else {
    $nativePlace = "";
}


if (!empty($complexion)) {
    $complexion = str_replace(", ", "','", trim($complexion));
} else {
    $complexion = "";
}


if ($gender != '') {
    $b = "and gender!='$gender'";
} else {
    $b = '';
}


if ($ageFrom != '' && $ageTo != '') {
    $a = "AND ((
			(
			date_format( now( ) , '%Y' ) - date_format( birthdate, '%Y' )
			) - ( date_format( now( ) , '00-%m-%d' ) < date_format( birthdate, '00-%m-%d' ) )
			)
			BETWEEN '$ageFrom'
			AND '$ageTo')";
} else {
    $a = '';
}

if ($religion != '') {
    $c = "and religion IN ($religion)";
} else {
    $c = '';
}

if ($education != '') {
    $edu = "and e_field IN ($education)";
} else {
    $edu = '';
}

if ($educationLevel != '') {
    $eduLevel = "and e_level IN ($educationLevel)";
} else {
    $eduLevel = '';
}

if ($partEmpIn != '') {
    $emp = "and emp_in IN ('$partEmpIn')";
} else {
    $emp = '';
}

if ($caste != '') {
    $d = "and caste IN ($caste)";
} else {
    $d = '';
}

if ($lookingFor != 'Any' && $lookingFor != '') {
    $h = "and m_status IN ('$lookingFor')";
} else {
    $h = '';
}

if ($country != '') {

    $i = "and country_id IN ($country)";
} else {
    $i = '';
}


if ($city != '') {

    $k = "and city IN ($city)";
} else {
    $k = '';
}

if ($nativePlace != '') {
    $family = "and family_origin IN ('$nativePlace')";
} else {
    $family = '';
}

if ($heightFrom != '' && $heightTo) {
    $l = "and height between '$heightFrom' and '$heightTo'";
} else {
    $l = '';
}

if ($orderby != '' && $orderby == 'register') {
    $o = "order by reg_date DESC";
} else if ($orderby != '' && $orderby == 'login') {
    $o = "order by last_login DESC";
} else {
    $o = '';
}

if ($complexion != '') {
    $x = "and complexion IN ('$complexion')";
} else {
    $x = '';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $matriId ?>- Match List</title>
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
    if ($records) {
        $limit = "LIMIT $records";
    } else {
        $limit = "";
    }
    $sql = "select DISTINCT firstname,username,m_status, last_login,reg_date,photo1,photo1_approve,photo_protect,photo_view_status,
matri_id,samyak_id,photo_pswd,gender,email,status,profile_text,video_approval,birthdate,height,religion_name,caste_name,
mtongue_name,edu_name,city_name,country_name,state_name,family_city,ocp_name,logged_in,index_id from register_view where status
 NOT IN ('Inactive', 'Suspended') and photo1!='' and photo1_approve='APPROVED' and matri_id NOT IN (select block_by from block_profile where block_to='$matriId')
  $a $b $c $d $h $i $k $edu $eduLevel $emp $family $l $x $o $limit";

    $data = $DatabaseCo->dbLink->query($sql);

    if ($data->num_rows > 0) {
        $text = "Hello *" . $row['username'] . " - [{$matriId}],*%0A%0A*Match List* For Profile ID *" . $matriId . "* on Samyakmatrimony.com%0ATotal Profiles - *[" . $data->num_rows . "]*%0A............................................................%0A%0A";
        while ($fetch = mysqli_fetch_object($data)) {
            $ao3 = $fetch->height;
            $ft3 = (int)($ao3 / 12);
            $inch3 = $ao3 % 12;
            $text .= "*" . trim($fetch->matri_id . " - " . ucfirst($fetch->firstname)) . "* | " . floor((time() - strtotime($fetch->birthdate)) / 31556926) . "Years | " .
                $ft3 . "ft" . " " . $inch3 . "in | " . $fetch->m_status . ", Residence from " . ucfirst($fetch->city_name) . " | " . $fetch->edu_name . " " . $fetch->ocp_name .
                " | DOB: " . date('d M, y', strtotime($fetch->birthdate)) . " | Native Place: " . ucfirst($fetch->family_city) . "%0A" .
                "" . urlencode("https://www.samyakmatrimony.com/view-profile?profile=" . dechex($fetch->index_id * 726925)) . "%0A%0A";
        }
    } else {
        echo "<h1 class='text-danger text-center'>No Data to Display</h1>";
    }
    if ($data->num_rows > 0) {
        $text .= "%0A%0ANote: This match list is received on your partner preference settings, you can edit your partner preference by login in to your profile on samyakmatrimony or you can reply us on whatsapp.%0A%0A*Thanks,*%0A*Samyakmatrimony Team*"; ?>
        <a id="clickLink"
           href="<?= "https://api.whatsapp.com/send?phone=91" . (strlen($mobile) == 13 ? substr($mobile, 3, 10) : $mobile) . "&text={$text}" ?>"
           title="Whatsapp"><i class="fa fa-whatsapp"></i> Send</a>
        <script>document.getElementById("clickLink").click();</script>
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
</body>
</html>