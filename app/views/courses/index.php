<?php

if (empty($_SESSION["user_id"]))
	header("location: " . URLROOT ."/users/login");

$_SESSION["title"] = "Courses";

require APPROOT . "/views/includes/head.php";
require APPROOT . "/views/includes/navigation.php";

?>

<div class="subject-title">Biologia</div>
<div class="course-grid">
	<?php
		$count = count($data);
		$i = 0;
		while ($i < $count)
		{ ?>
			<div class="card">
				<div class="card-img-container">
					<img src="<?php echo $data[$i]->course_img ?>" alt="Course image">
				</div>
				<p class="card-title"><?php echo $data[$i]->course_name ?></p>
			</div>
			<?php $i++;
		}
	?>
</div>


<script>
	const termMain = document.getElementsByClassName("term-main")[0];

	burger.addEventListener("click", (e) => {
		termMain.classList.toggle("active-nav");
	})
</script>
