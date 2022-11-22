<?php

if (isset($_SESSION["user_id"]))
	header("Location: ../dashboard/index");

require APPROOT . "/views/includes/head.php";
?>

<body>
	<div class="user-page">
		<div class="green-blur">
			<div class="user-form-container">
				<form id="registerForm" name="registerForm" class="user-form" method="POST">
					<h4>Bio<span>Cluster</span></h4>
					<h3>Creeate a new account</h3>
					<span class="user-form-error">
					<?php echo $data["emailError"]; ?>
					</span>
					<input type="text" name="email" placeholder="Email" autocomplete="off">
					<span class="user-form-error">
					<?php echo $data["usernameError"]; ?>
					</span>
					<input type="text" name="username" id="username" autocomplete="off" placeholder="Username">
					<span class="user-form-error">
					<?php echo $data["firstNameError"]; ?>
					</span>
					<input type="text" name="firstName" id="firstName" autocomplete="off" placeholder="First Name">
					<span class="user-form-error">
					<?php echo $data["lastNameError"]; ?>
					</span>
					<input type="text" name="lastName" id="lastName" autocomplete="off" placeholder="Last Name">
					<span class="user-form-error">
					<?php echo $data["passwordError"]; ?>
					</span>
					<input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">
					<span class="user-form-error">
					<?php echo $data["confirmPasswordError"]; ?>
					</span>
					<input type="password" name="confirmPassword" placeholder="Confirm Passsword" id="confirmPwd" autocomplete="off">
					<input id="register" type="submit" value="Register" class="user-form-btn" name="register">
					<p class="user-form-link">Already registered? <a href="<?php echo URLROOT; ?>/users/login">Sign in!</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
