<?php
    error_reporting(0);
    require_once 'DatabaseConnection.php';
    $DatabaseCo = new DatabaseConnection();
    include('Crypto.php');
?>
<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>
<?php
	$merchant_data='';
    //Samyak Online
    /*$working_key='94B45638ED54B56FD26C06D518092360';//Shared by CCAVENUES
    $access_code='AVAV77FC02BV65VAVB';//Shared by CCAVENUES*/

    //Samyakmatrimony
    $working_key='9F4C110591281C5F97F07059D36EF56F';//Shared by CCAVENUES
    $access_code='AVAV77FC02BV63VAVB';//Shared by CCAVENUES
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

    $merchant_data.='amount='.$_SESSION["planDetails"]['plan_amount'];

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

