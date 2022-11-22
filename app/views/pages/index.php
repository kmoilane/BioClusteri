<?php

if (!isset($_SESSION["user_id"]))
{
	header("location: " . URLROOT ."/users/login");
	exit;
}
else
{
	header("location: ./dashboard");
	exit ;
}

require APPROOT . "/views/includes/head.php";
require APPROOT . "/views/includes/navigation.php";

?>

<body>
	<h1><?php echo $data["username"]; ?>Jippiii</h1>
</body>
