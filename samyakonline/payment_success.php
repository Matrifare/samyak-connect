<?php
require_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
require_once 'auth.php';
include_once 'lib/RequestHandler.php';
include_once 'lib/Config.php';
$configObj = new Config();
include_once 'Crypto.php';
include_once 'lib/sendmail.php';
include_once 'lib/curl.php';
include_once 'lib/Voicecall.php';
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title><?php echo $configObj->getConfigTitle(); ?></title>
    <meta name="keyword" content="<?php echo $configObj->getConfigKeyword(); ?>"/>
    <meta name="description" content="<?php echo $configObj->getConfigDescription(); ?>"/>
    <link type="image/x-icon" href="img/<?php echo $configObj->getConfigFevicon(); ?>" rel="shortcut icon"/>
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- CSS Cores and Plugins -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
    <link href="css/animate.css" rel="stylesheet">
    <link href="<?= @auto_version("css/main.css") ?>" rel="stylesheet">
    <link href="css/component.css" rel="stylesheet">

    <!-- CSS Font Icons -->
    <link rel="stylesheet" href="icons/open-iconic/font/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="icons/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="icons/rivolicons/style.css">
    <link rel="stylesheet" href="icons/streamline-outline/flaticon-streamline-outline.css">
    <link rel="stylesheet" href="icons/around-the-world-icons/around-the-world-icons.css">
    <link rel="stylesheet" href="icons/et-line-font/style.css">

    <!-- CSS Custom -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Add your style -->
    <link href="css/your-style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="not-home" style="overflow-x: hidden;">

<!-- start Container Wrapper -->
<div class="container-wrapper colored-navbar-brand">

    <!-- start Header -->
    <?php @include_once 'layouts/menu.php' ?>
    <!-- end Header -->

    <div class="clear"></div>

    <!-- start Main Wrapper -->
    <div class="main-wrapper">

        <div class="breadcrumb-wrapper">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-8">
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ol>
                    </div>

                    <div class="col-xs-12 col-sm-4 hidden-xs">
                        <p class="hot-line"><i class="fa fa-phone"></i> <a href="tel:+91-79779-93616"> Help Line:
                                +91-79779-93616</a></p>
                    </div>

                </div>

            </div>

        </div>

        <?php
        $workingKey = '9F4C110591281C5F97F07059D36EF56F';        //Working Key should be provided here.
        $encResponse = $_POST["encResp"];            //This is the response sent by the CCAvenue Server
        $rcvdString = decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        echo "<center>";

        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3) $order_status = $information[1];
        }
        $merchant_data = '';
        if ($order_status === "Success") {

            $information3_id = array();
            $information3_value = array();
            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                // $information[0].$information[1];
                $information3_id[$i] = $information[0];
                $information3_value[$i] = $information[1];
            }
            /*		0->order_id	MWM554
            1->tracking_id	103000544192
            2->bank_ref_no	IGY1246231
            3->order_status	Success
            4->failure_message
            5->payment_mode	Net Banking
            6->card_name	State Bank of India
            7->status_code	null
            8->status_message	Completed Successfully
            9->currency	INR
            10->amount	2.0
            11->billing_name	jai kumar
            12->billing_address	h-65 laxminagar
            13->billing_city	delhi
            14->billing_state	new delhi
            15->billing_zip	110092
            16->billing_country	India
            17->billing_tel	7827827028
            18->billing_email	nitin@tos.in
            19->delivery_name	jai kumar
            20->delivery_address	h-65 laxminagar
            21->delivery_city	delhi
            22->delivery_state	new delhi
            23->delivery_zip	110092
            24->delivery_country	India
            25->delivery_tel	7827827028
            */

            $order = explode("-", $information3_value[0]);
            $order_id = $order[0];
            $plan_id2 = $order[1];
            $tracking_id = $information3_value[1];
            $bank_ref_no = $information3_value[2];
            $order_status = $information3_value[3];
            $failure_message = $information3_value[4];
            $payment_mode = $information3_value[5];
            $card_name = $information3_value[6];
            $status_code = $information3_value[7];
            $status_message = $information3_value[8];
            $currency = $information3_value[9];
            $amount = $information3_value[10];
            $billing_name = $information3_value[11];
            $billing_address = $information3_value[12];
            $billing_email = $information3_value[13];

            $qury = "SELECT `plan_id`, `plan_name`, `plan_type`, `plan_contacts`, `plan_duration`,
		`plan_amount`, `plan_offers`, `plan_msg`, `video`, `chat`, `profile`, `status` from  membership_plan where plan_id = '$plan_id2' ";
            $result = mysqli_query($DatabaseCo->dbLink, $qury);
            $rowmem_plan = mysqli_fetch_assoc($result);
            $plan_name = $rowmem_plan['plan_name'];

            if ($rowmem_plan['plan_duration'] > 0) {
                $plan_duration = $rowmem_plan['plan_duration'];
            } else {
                $plan_duration = 1;
            }

            $profile = $rowmem_plan['profile'];
            $amount = $rowmem_plan['plan_amount'];
            $plan_contacts = $rowmem_plan['plan_contacts'];
            $plan_free_msg = $rowmem_plan['plan_msg'];
            $video = $rowmem_plan['video'];
            $chat = $rowmem_plan['chat'];

            $del_old = mysqli_query($DatabaseCo->dbLink, "delete from payments where pmatri_id='$order_id'");
            $query01 = "UPDATE `register` SET `status`='Paid' WHERE matri_id='$order_id'";
            $qury20 = "INSERT INTO `payments`
		(`payid`,
		`pmatri_id`,
		`pname`,
		`pemail`,
		`paymode`,
		`pactive_dt`,
		`p_plan`,
		`plan_duration`,
		`profile`,
		`video`,
		`chat`,
		`p_no_contacts`,
		`p_amount`,
		`p_bank_detail`,
		`pay_id`,
		`p_msg`,
		`r_profile`,
		`r_cnt`,
		`r_sms`,
		`exp_date`)
		VALUES
		(NULL,
		'$order_id',
		'$billing_name',
		'" . $_SESSION['user_name'] . "',
		'$card_name',
		CURDATE(),
		'$plan_name',
		'$plan_duration',
		'$profile',
		'Yes',
		'Yes',
		'$plan_contacts',
		'Rs. $amount',
		'$status_code',
		'$tracking_id',
		'$plan_free_msg',
		'0',
		'0',
		'0',
		DATE_ADD(CURDATE(), INTERVAL +$plan_duration DAY))";

            $res1 = mysqli_query($DatabaseCo->dbLink, $qury20);
            if ($res1) {
                $res2 = mysqli_query($DatabaseCo->dbLink, $query01);
                $_SESSION['membership'] = $plan_name;
            }
            $select = mysqli_query($DatabaseCo->dbLink, "select * from `register` WHERE matri_id='$order_id'");
            while ($row = mysqli_fetch_array($select)) {
                $result = $DatabaseCo->dbLink->query("SELECT * FROM register_view r INNER JOIN payment_view p 
                                                            ON r.matri_id = p.pmatri_id 
                                                            LEFT JOIN membership_plan mp ON mp.plan_name=p.p_plan 
                                                            where r.matri_id = '$order_id' AND mp.plan_id='$plan_id2' AND
                                                             (mp.status='APPROVED' OR mp.status='PERSONALIZED')");
                $row = mysqli_fetch_array($result);
                $name = mysqli_real_escape_string($DatabaseCo->dbLink, $row['username']);
                $matriid = mysqli_real_escape_string($DatabaseCo->dbLink, $row['matri_id']);
                $samyakId = mysqli_real_escape_string($DatabaseCo->dbLink, $row['samyak_id']);
                $email = mysqli_real_escape_string($DatabaseCo->dbLink, $row['email']);

                $tempData = (Object) $row;
                $template = get_email_template($DatabaseCo, $tempData, 'email-templates/upgrade_membership_email_template.php');
                $subject = "Your Paid Membership on Samyakmatrimony has been upgraded";
                @send_email_from_samyak($configObj->getConfigFrom(), trim($tempData->email), $subject, $template);

                $today1 = strtotime('now');
                $pactive_dt = date("Y-m-d", $today1);
                $date = strtotime(date("Y-m-d", strtotime($pactive_dt)) . +$plan_duration . " day");
                $exp_date = date('Y-m-d', $date);



                $subject = "Profile ".$matriid." has been upgraded by Online Payment";
                $message = "
<table width=50% style='border: none;'>
    <tr>
        <th colspan='2' style='text-align: left;'>Profile has been upgraded from Samyakmatrimony.com</th>
    </tr>
    <tr>
        <th colspan='2' style='text-align: left;'>----------------------------------------------------------------------------------</th>
    </tr>
    <tr>
        <td width='20%'>Profile Id : </td>
        <td width='50%'>$matriid</td>
    </tr>
    <tr>
        <td>Samyak Id : </td>
        <td>$samyakId</td>
    </tr>
    <tr>
        <td>Name : </td>
        <td>$name</td>
    </tr>
    <tr>
        <td>Email : </td>
        <td>" . $row["email"] . "</td>
    </tr>
    <tr>
        <td>Mobile No : </td>
        <td>" . $row["mobile"] . "</td>
    </tr>
    <tr>
        <td>Plan Name : </td>
        <td>$plan_name</td>
    </tr>
    <tr>
        <td>Plan Duration : </td>
        <td>$plan_duration</td>
    </tr>
    <tr>
        <td>No of Contact : </td>
        <td>$plan_contacts</td>
    </tr>
    <tr>
        <td>Expiry Date : </td>
        <td>$exp_date</td>
    </tr>
    <tr>
        <td>Payment Mode : </td>
        <td>$card_name</td>
    </tr>
    <tr>
        <td>Bank Details : </td>
        <td>$status_code</td>
    </tr>
    <tr>
        <td>Office Use : </td>
        <td>$matriid</td>
    </tr>
    <tr>
        <td>Payment Date : </td>
        <td>" . date('d M, Y') . "</td>
    </tr>
    <tr>
        <td>Amount : </td>
        <td>$amount</td>
    </tr>
    
</table>
";
                @send_email_from_samyak($configObj->getConfigFrom(), $configObj->getConfigTo(), $subject, $message);


                $sql = "select * from sms_api where status='APPROVED'";
                $rr = mysqli_query($DatabaseCo->dbLink, $sql) or die(mysqli_error($DatabaseCo->dbLink));
                $num_sms = mysqli_num_rows($rr);
                $sms = mysqli_fetch_object($rr);
                // Getting SMS API, if yes proceed further //

                if ($num_sms > 0) {
                    // Getting predefined SMS Template //
                    $result45 = $DatabaseCo->dbLink->query("SELECT * FROM sms_templete where temp_name = 'Membership'");
                    $rowcs5 = mysqli_fetch_array($result45);
                    $message = trim($rowcs5['temp_value']);
                    $sms_template = htmlspecialchars_decode($message, ENT_QUOTES);

                    $sms_template = str_replace(array('*samyakid*', '*days*', '*contact*'), array($order_id, $plan_duration, $plan_contacts), $sms_template);
                    // Final action to send sms //
                    $mno = $row['mobile'];
                    $mobile = substr($mno, 0, 3);
                    if ($mobile == '+91') {
                        $mno = substr($mno, 3, 15);
                    }
                    include_once 'lib/curl.php';
                    send_to_curl($mno, $sms_template);
                }

                //Make Voice Call
                $resultVoiceCall = $DatabaseCo->dbLink->query("SELECT * FROM voice_template where name = 'Membership' and status = 'Y'");
                if($resultVoiceCall->num_rows > 0) {
                    $rowcs5 = mysqli_fetch_array($resultVoiceCall);
                    $fileName = $rowcs5['file_name'];
                    $fileName = htmlspecialchars_decode($fileName, ENT_QUOTES);
                    make_voice_call($fileName, $mno);
                }
                //End of Making Voice Call
            }
        }
        ?>
        <div class="container mt-50 mb-50">

            <div class="section-title-3">
                <h5 class="btn-danger col-sm-offset-4 col-sm-4 col-xs-12">Thank you for the payment !!!</h5>
                <h4 class="btn-danger col-sm-offset-4 col-sm-4 col-xs-12">Your membership is upgraded successfully.</h4>
            </div>

            <div class="clear mb-10"></div>
            <p style="margin-bottom: 10px;">By verifying your Photo Id Proof trust score will be increased.
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

        <div class="clear"></div>

        <?php @include_once 'layouts/footer.php' ?>

    </div>

</div>

<!-- jQuery Cores -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- Plugins - serveral jquery plugins that use in this template -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- Custom js codes for plugins -->
<script type="text/javascript" src="<?= @auto_version("js/customs.js") ?>"></script>


</body>
</html>