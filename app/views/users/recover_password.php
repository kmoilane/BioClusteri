<?php

if (isset($_SESSION["user_id"]))
{
	header("location: ../pages/index.php");
	exit ;
}


require APPROOT . "/views/includes/head.php";
?>

<body>
	<div class="user-page">
		<div class="green-blur">
			<div class="user-form-container">
				<form id="recoverPassword" name="recoveryForm" class="user-form" method="POST">
					<h4>Bio<span>Cluster</span></h4>
					<h3>Password recovery</h3>
					<span class="user-form-error" id="msg"></span>
					<input type="text" name="email" placeholder="Email" autocomplete="off">
					<input id="recover" type="submit" value="Send Recovery Email" class="user-form-btn" name="login">
					<p class="user-form-link">Not registered? <a href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
					<p class="user-form-link">Hehe, I remember it after all! <a href="<?php echo URLROOT; ?>/users/login">Sign in!</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
