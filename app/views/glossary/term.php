<?php

if (empty($_SESSION["user_id"]))
	header("location: " . URLROOT ."/users/login");

$_SESSION["title"] = "Käsitte";

require APPROOT . "/views/includes/head.php";
require APPROOT . "/views/includes/navigation.php";
require APPROOT . "/views/includes/popup_term.php";

?>

<div class="term-main">
	<div class="term-header">
		<div class="term-container">
			<h2><?php echo htmlspecialchars($data[0]->term); ?></h2>
		</div>
		<div class="term-options">
			<button id="editTermBtn">Edit</button>
		</div>
	</div>
	<div class="term-explanation">
		<div class="explanation-container">
			<p><?php echo $data[0]->explanation; ?></p>
		</div>
	</div>
</div>

<script>
	const termMain = document.getElementsByClassName("term-main")[0];
	const editTermBtn = document.getElementById("editTermBtn");
	const addTermCheckBoxes = document.querySelectorAll('[name="course[]"]');
	const addTermName = document.getElementById("addTermName");
	const addTermExplanataion = document.getElementById("addTermExplanation");
	const closeFormBtn = document.getElementById("closeFormBtn");
	const popupSaveBtn = document.getElementById("popupSaveBtn");
	const popupContainer = document.getElementsByClassName("popup-container")[0];

	function checkPopupForm(e) {
		var check = false;
		addTermCheckBoxes.forEach((box) => {
			if (box.checked)
				check = true;
		});
		if (check &&
		addTermName.value != "" &&
		addTermExplanataion.value != "")
		{
				popupSaveBtn.disabled = false;
		}
		else
			popupSaveBtn.disabled = true;
	}

	closeFormBtn.addEventListener("click", (e) => {
		e.preventDefault();
		popupContainer.style.display = "none";
	});

	editTermBtn.addEventListener("click", (e) => {
		e.preventDefault();
		popupContainer.style.display = "flex";
	});

	closeFormBtn.addEventListener("click", (e) => {
		e.preventDefault();
		popupContainer.style.display = "none";
	});

	burger.addEventListener("click", (e) => {
		termMain.classList.toggle("active-nav");
	});

</script>
