<?php

if (empty($_SESSION["user_id"]))
	header("location: " . URLROOT ."/users/login");

$_SESSION["title"] = "Foorumit";

require APPROOT . "/views/includes/head.php";
require APPROOT . "/views/includes/navigation.php";

?>

<div>
	<?php echo $data["username"] ?>
</div>

</body>
