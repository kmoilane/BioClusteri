<?php

	// Require libraries from libraries folder
	require_once 'libraries/Controller.php';
	require_once 'libraries/Core.php';
	require_once 'libraries/Database.php';

	// Require configuration file
	require_once 'config/config.php';

	// Require helpers
	require_once "helpers/generate_otp.php";
	require_once "helpers/validations.php";
	require_once "helpers/session_helper.php";

	// Instantiate core class
	$init = new Core();

?>
