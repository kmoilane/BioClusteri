<?php

if (isLoggedIn())
	header("location: " . URLROOT ."/dashboard");

if (empty($_SESSION["email"]))
	header("location: " . URLROOT ."/users/login");

if (isset($_GET["email"]) && isset($_GET["otp"]))
	$this->verify();

require APPROOT . "/views/includes/head.php";
?>

<body>
	<div class="user-page">
		<div class="green-blur">
			<div class="user-form-container">
				<form id="verifyForm" name="verifyForm" class="user-form" method="POST">
					<h4>Bio<span>Cluster</span></h4>
					<h3>Verify your Email</h3>
					<span class="user-form-error">
					<?php echo $data["otpError"]; ?>
					</span>
					<input type="text" name="otp" placeholder="Verification Code" id="otp" autocomplete="off">
					<input id="verify" type="submit" value="Verify" class="user-form-btn" name="verify">
					<p class="user-form-link">Already verified? <a href="<?php echo URLROOT; ?>/users/login">Sign in!</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
