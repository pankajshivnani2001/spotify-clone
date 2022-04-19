<style>
	body{
		background-color: #181818;
    	color: white;
	    letter-spacing: 0.8px;
	    font-family: Helvetica;
	    text-align: center;
	    padding: 100px;
	}

	a{
		text-decoration: none;
    	color: blue;
	}

	div.info{
		background-color: #505050;
    	padding: 10px;
	    border-radius: 15px;
	}



</style>

<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");


// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

echo "<div class=info>";;

if($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<h2>Transaction status is success</h2>" . "<br/>";

		//AJAX CALL TO UPDATE THE userplan TABLE
		$amt = $_POST['TXNAMOUNT'];
		if($amt == 1.00)
			$planType = "hourly";

		if($amt == 7.00)
			$planType = "daily";

		if($amt == 100.00)
			$planType = "monthly";

		if($amt == 1000.00)
			$planType = "annually";

		$orderId = $paramList['ORDERID'];
		$username = substr($orderId, 6);

		echo "<h2>Your Plan Has Been Upgraded</h2>";
		echo "<h2>Plan Type: $planType</h2>";

		$con = mysqli_connect("localhost", "root", "", "slotify");

		$checkQuery = mysqli_query($con, "SELECT * FROM userplan WHERE username = '$username'");

		//if no entry, then simply add the username with the plantype
		if(mysqli_num_rows($checkQuery) == 0)
		{
			$insertQuery = mysqli_query($con, "INSERT INTO userplan VALUES('', '$planType', '$username', current_timestamp())");
			//echo "Your Current Plan is - " . $planType;
		}

		//if entry found, then update if a higher plan is chosen, else return message
		else 
		{
			$map = array();
			$map['hourly'] = 1;
			$map['daily'] = 2;
			$map['monthly'] = 3;
			$map['annually'] = 4;

			$row = mysqli_fetch_array($checkQuery);
			$currentPlan = $row['planType'];

			if($map[$currentPlan] < $map[$planType]) 
			{
				$updateQuery = mysqli_query($con, "UPDATE userplan SET planType = '$planType' WHERE username = '$username'");
				$updateQuery = mysqli_query($con, "UPDATE userplan SET startDateTime = current_timestamp() WHERE username = '$username'");
				//echo "Your Current Plan is - " . $planType;
			}

		//echo "<script> upgradePlan(".$planType."); </script>";
		//echo $paramList['CUST_ID'];




		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
		}
	}

	else {
		echo "<b>Transaction Failed</b>" . "<br/>";
	}

	/*
	if (isset($_POST) && count($_POST)>0 )
	{ 
		foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		}
	}
	*/
	
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}
echo "<h2><a href='http://localhost/slotify/upgradePlan.php?'>Go Back To Spotify</a></h2>";
echo "</div>";



?>
