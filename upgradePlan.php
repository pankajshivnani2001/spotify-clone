<?php 
	include("includes/includedFiles.php");

	$username =  $user->getName();

	$currentPlanQuery = mysqli_query($con, "SELECT planType FROM userplan WHERE username = '$username'");
	if(mysqli_num_rows($currentPlanQuery) == 0)
		$currentPlan = 'Free';
	else 
	{
		$row = mysqli_fetch_array($currentPlanQuery);
		$currentPlan = $row['planType'];
	}
	

	echo "<h2 class='currentPlan'>Your Current Plan is - " . $currentPlan . "</h2>";

?>

<div class="plansContainer">
	
	<div class="plan plan1">
		<div class="planHeading">
		
			<h2>Hourly Plan</h2>
			<span class="planCost">₹1 Per Hour</span>

		</div>

		<div class="planInfo">

			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Create Upto 1 playlists</span>
			</div>
			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Add Upto 3 Songs to Playlists</span>
			</div>

		</div>
		<!--<button class="button green" style="margin-top: 10px;" onclick="upgradePlan('hourly')">Buy</button>-->
		<button class="button green" style="margin-top: 10px;" onclick="openPaymentPage('checkout.php?amount=1&planType=Hourly&orderId=<?php echo rand(100000, 350000).$user->getName(); ?>')">Buy</button>
	</div>



	<div class="plan plan2">
		
		<div class="planHeading">
		
			<h2>Daily Plan</h2>
			<span class="planCost">₹7 Per Day</span>

		</div>

		<div class="planInfo">

			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Create Upto 3 playlists</span>
			</div>
			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Add Upto 5 Songs to Playlists</span>
			</div>
		</div>

		<!--<button class="button green" style="margin-top: 10px;" onclick="upgradePlan('daily')">Buy</button>-->
		<button class="button green" style="margin-top: 10px;" onclick="openPaymentPage('checkout.php?amount=7&planType=Daily&orderId=<?php echo rand(100000, 350000).$user->getName(); ?>')">Buy</button>

	</div>

	<div class="plan plan3">
		
		<div class="planHeading">
		
			<h2>Monthly Plan</h2>
			<span class="planCost">₹100 Per Month</span>

		</div>
		<div class="planInfo">

			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Create Upto 10 playlists</span>
			</div>
			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Add Upto 15 Songs to Playlists</span>
			</div>

		</div>
		<!--<button class="button green" style="margin-top: 10px;" onclick="upgradePlan('monthly')">Buy</button>-->
		<button class="button green" style="margin-top: 10px;" onclick="openPaymentPage('checkout.php?amount=100&planType=Monthly&orderId=<?php echo rand(100000, 350000).$user->getName(); ?>')">Buy</button>
	</div>

	<div class="plan plan4">
		
		<div class="planHeading">
		
			<h2>Annual Plan</h2>
			<span class="planCost">₹1000 Per Year</span>

		</div>
		<div class="planInfo">

			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Unlimited Playlists</span>
			</div>
			<div class="features">
				<img src="assets/images/checkmark.png" height="20px">
				<span>Unlimited Songs in Playlists</span>
			</div>

		</div>
		<!--<button class="button green" style="margin-top: 10px;" onclick="upgradePlan('annually')">Buy</button>-->
		<button class="button green" style="margin-top: 10px;" onclick="openPaymentPage('checkout.php?amount=1000&planType=Annual&orderId=<?php echo rand(100000, 350000).$user->getName(); ?>')">Buy</button>
	</div>
</div>

<h2 class="successMessage"></h2>


<script>
	
	var currentPlan = <?php echo json_encode($currentPlan); ?>;
	if(currentPlan == "hourly")
		$(".plan1").remove();
	if(currentPlan == "daily")
	{
		$(".plan1").remove();
		$(".plan2").remove();
	}
	if(currentPlan == "monthly")
	{
		$(".plan1").hide();
		$(".plan2").hide();
		$(".plan3").hide();
	}
	if(currentPlan == "annually")
	{
		$(".plan1").hide();
		$(".plan2").hide();
		$(".plan3").hide();
		$(".plan4").hide();
	}

</script>