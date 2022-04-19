<?php

	include("includes/includedFiles.php");
	if(isset($_GET['amount']) && isset($_GET['orderId']))
	{

		$amount = $_GET['amount'];
		$orderId = $_GET['orderId'];
		$customerId = "CUST".md5($user->getName());
		$planType = $_GET['planType'];
	}

?>


<div class="paymentInfoContainer">
	
	<div class="paymentInfo">
		<h2 style="display: inline; color: #2ebd;">Customer Id :</h2> <h2 style="display: inline;"> <?php echo $customerId; ?></h2>
		<br><br>
		<h2 style="display: inline; color: #2ebd;">Plan Type: </h2> <h2 style="display: inline;"> <?php echo $planType; ?></h2>
		<br><br>
		<h2 style="display: inline; color: #2ebd;">Order Id :</h2> <h2 style="display: inline;"> <?php echo $orderId; ?></h2>
		<br><br>
		<h2 style="display: inline; color: #2ebd;">Amount :</h2> <h2 style="display: inline;"> ₹<?php echo $amount; ?></h2>
	</div>

	<div class="paymentButtonContainer">
		
		<form method="post" action="PaytmKit/pgRedirect.php">

			<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20"
						name="ORDER_ID" autocomplete="off"
						value="<?php echo  $orderId; ?>">

			<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo $customerId; ?>">

			<input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">

			<input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12"
						size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">

			<input type="hidden" title="TXN_AMOUNT" tabindex="10"
			type="text" name="TXN_AMOUNT"
			value="<?php echo $amount; ?>">

			<input class="paymentButton" value="Process To Payment" type="submit">

		</form>

	</div>


</div>

