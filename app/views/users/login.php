<?php

if (isset($_SESSION["user_id"]))
{
	header("location: " . URLROOT ."/dashboard");
	exit ;
}


require APPROOT . "/views/includes/head.php";
?>

<body>
	<div class="user-page">
		<div class="green-blur">
			<div class="user-form-container">
				<form id="loginForm" name="loginForm" class="user-form" method="POST">
					<h4>Bio<span>Cluster</span></h4>
					<h3>Log in to your account</h3>
					<span class="user-form-error">
						<?php echo $data["emailError"]; ?>
					</span>
					<input type="text" name="email" placeholder="Email" autocomplete="off">
					<span class="user-form-error">
						<?php echo $data["passwordError"]; ?>
					</span>
					<input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">
					<span class="user-form-error">
						<?php echo $data["verifyError"]; ?>
					</span>
					<input id="login" type="submit" value="Log in" class="user-form-btn" name="login">
					<p class="user-form-link">Not registered? <a href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
					<p class="user-form-link"><a href="<?php echo URLROOT;?>/users/recover_password">Forgot your password?</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
