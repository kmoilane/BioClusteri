<?php
require_once "../../controllers/Users.php";

if (isset($_SESSION["user_id"]))
{
	$user = new Users;

	$user->logout();
	header("location: " . URLROOT ."/users/login");
}

?>
