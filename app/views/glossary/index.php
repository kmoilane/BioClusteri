<?php

if (empty($_SESSION["user_id"]))
	header("location: " . URLROOT ."/users/login");

$_SESSION["title"] = "Glossary";

require APPROOT . "/views/includes/head.php";
require APPROOT . "/views/includes/navigation.php";
require APPROOT . "/views/includes/popup_term.php";

?>
		<div class="top-wrapper">
			<section class="top" id="top">
				<div class="top-row">
					<div class="search-box-wrapper">
						<input class="term-search" type="text" placeholder="Hae käsitteitä">
					</div>
					<div class="round-btn" id="addNewTerm">
							<input type="button" value="+" title="Lisää uusi käsite">
					</div>
				</div>
				<div class="search-filters">
					<ul class="filter-checkboxes">
						<li><input type="checkbox" name="all" id="checkboxOne" value="all" checked="true"><label for="checkboxOne">Kaikki Kurssit</label></li>
						<li><input type="checkbox" name="b1" id="checkboxTwo" value="Biologia 1" specific-course="1"><label for="checkboxTwo">Bilsa 1</label></li>
						<li><input type="checkbox" name="bi2" id="checkboxThree" value="Biologia 2" specific-course="2"><label for="checkboxThree">Bilsa 2</label></li>
						<li><input type="checkbox" name="bi3" id="checkboxFour" value="Biologia 3" specific-course="3"><label for="checkboxFour">Bilsa 3</label></li>
						<li><input type="checkbox" name="bi4" id="checkboxFive" value="Biologia 4" specific-course="4"><label for="checkboxFive">Bilsa 4</label></li>
						<li><input type="checkbox" name="bi5" id="checkboxSix" value="Biologia 5" specific-course="5"><label for="checkboxSix">Bilsa 5</label></li>
					</ul>
				</div>
				<section class="alphabetical-filter">
					<ul>
						<li><a>A</a></li>
						<li><a>B</a></li>
						<li><a>C</a></li>
						<li><a>D</a></li>
						<li><a>E</a></li>
						<li><a>F</a></li>
						<li><a>G</a></li>
						<li><a>H</a></li>
						<li><a>I</a></li>
						<li><a>J</a></li>
						<li><a>K</a></li>
						<li><a>L</a></li>
						<li><a>M</a></li>
						<li><a>N</a></li>
						<li><a>O</a></li>
						<li><a>P</a></li>
						<li><a>Q</a></li>
						<li><a>R</a></li>
						<li><a>S</a></li>
						<li><a>T</a></li>
						<li><a>U</a></li>
						<li><a>V</a></li>
						<li><a>W</a></li>
						<li><a>X</a></li>
						<li><a>Y</a></li>
						<li><a>Z</a></li>
						<li><a>Å</a></li>
						<li><a>Ä</a></li>
						<li><a>Ö</a></li>
					</ul>
				</section>
			</section>
		</div>
		<div class="main-container" id="mainContainer">
			<section class="middle">
				<div class="left-split">
				<?php
					$i = 0;
					while (!empty($data[$i]->term)) {
						?><a course="<?php echo $data[$i]->course ?>" class="term" href="<?php echo URLROOT . "/glossary?term=" . lcfirst($data[$i]->term) ?>" style="display:block; margin-block:5px;"><?php
						echo $data[$i]->term;
						?></a><?php
						$i++;
					}
				?>
				</div>
			</section>
		</div>
	</main>

	<script>

		const searchInput = document.getElementsByClassName("term-search")[0];
		const checkBoxForAll = document.getElementById("checkboxOne");
		const checkBoxes = document.querySelectorAll("[specific-course]");
		const termList = document.querySelectorAll(".term");

		/*
		**	Element variables related to adding a new term
		*/
		const addNewTermBtn = document.getElementById("addNewTerm");
		const popupContainer = document.getElementsByClassName("popup-container")[0];
		const addTermForm = document.getElementById("addTermForm");
		const closeFormBtn = document.getElementById("closeFormBtn");
		const popupSaveBtn = document.getElementById("popupSaveBtn");
		const addTermCheckBoxes = document.querySelectorAll('[name="course[]"]');
		const addTermName = document.getElementById("addTermName");
		const addTermExplanataion = document.getElementById("addTermExplanation");

		/*
		**	Element variables for alphabetical filtering
		*/
		const alphabeticalFilter = document.querySelectorAll(".alphabetical-filter ul li a");

		const topSection = document.getElementsByClassName("top")[0];
		const topWrapper = document.getElementsByClassName("top-wrapper")[0];

		$(document).ready(() => {
			$('#mainContainer').css('marginTop', $('#top').outerHeight(true));
		});

		$(window).resize(() => {
			$('#mainContainer').css('marginTop', $('#top').outerHeight(true));
		});

		burger.addEventListener("click", (e) => {
			topSection.classList.toggle('active-nav');
		});

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

		function resetAlphabeticalFilters() {
			alphabeticalFilter.forEach((alphabet) => {
					alphabet.classList.remove("current");
				});
		}

		alphabeticalFilter.forEach((filter) => {
			filter.addEventListener("click", (e) => {
				if (!filter.classList.contains("current"))
					resetAlphabeticalFilters();
				filter.classList.toggle("current");
				searchInput.value = "";
				termList.forEach((term) => {
					term.style.display = "block";
					let inputVal = filter.innerHTML.toLowerCase();
					let alphabet = getAlphabeticalFilter();
					let termLow = term.innerHTML.toLowerCase();
					let course = term.getAttribute("course");
					if (alphabet != "" && termLow[0] != alphabet) {
						term.style.display = "none";
						term.nextElementSibling.style.display = "none";
					}
					else if (alphabet === ""){
						checkBoxes.forEach((box) => {
							let selectedCourse = box.getAttribute("specific-course");
							if (box.checked || checkBoxForAll.checked) {
								if (course.indexOf(selectedCourse) >= 0)
									term.style.display = "block";
							}
							else {
								if (course.indexOf(selectedCourse) >= 0)
									term.style.display = "none";
									term.nextElementSibling.style.display = "none";
							}
						});
					}
				});
			});
		});

		closeFormBtn.addEventListener("click", (e) => {
			e.preventDefault();
			popupContainer.style.display = "none";
		});

		addNewTermBtn.addEventListener("click", (e) => {
			e.preventDefault();
			popupContainer.style.display = "flex";

		});

		popupContainer.addEventListener("click", (e) => {
			if (!event.target.closest("#addTermForm")) {
				popupContainer.style.display = "none";
			}
		});

		addTermName.addEventListener("keyup", checkPopupForm);
		addTermCheckBoxes.forEach((box) => {
			box.addEventListener("click", checkPopupForm);
		});
		addTermExplanataion.addEventListener("keyup", checkPopupForm);


		function getAlphabeticalFilter() {
			let alphabet = "";
			alphabeticalFilter.forEach((filter) => {
				if (filter.classList.contains("current"))
					alphabet = filter.innerHTML.toLowerCase();
			});
			return alphabet;
		}

		checkBoxForAll.addEventListener("click", () => {
			if (checkBoxForAll.checked)
			{
				let inputVal = searchInput.value.toLowerCase();
				let alphabet = getAlphabeticalFilter();

				checkBoxes.forEach((box) => {
					box.checked = false;
				});
				if (inputVal != "" || alphabet === "") {
					termList.forEach((term) => {
						let termLow = term.innerHTML.toLowerCase();
						if (termLow.indexOf(inputVal) >= 0) {
							term.style.display = "block";
						}
					});
				}
				else if (alphabet != "") {
					termList.forEach((term) => {
						let termLow = term.innerHTML.toLowerCase();
						if (termLow[0] === alphabet) {
							term.style.display = "block";
						}
					});
				}
			}
			else {
				termList.forEach((term) => {
					term.style.display = "none";
				});
			}
		});

		checkBoxes.forEach((box) => {
			box.addEventListener("click", () => {
				let selectedCourse = box.getAttribute("specific-course");
				if (checkBoxForAll.checked) {
					checkBoxForAll.checked = false;
					termList.forEach((term) => {
						term.style.display = "none";
					});
				}
				if (box.checked) {
					let inputVal = searchInput.value.toLowerCase();
					let alphabet = getAlphabeticalFilter();

					if (inputVal != "" || alphabet === "") {
						termList.forEach((term) => {
							let termLow = term.innerHTML.toLowerCase();
							let course = term.getAttribute("course");
							if (course.indexOf(selectedCourse) >= 0 && termLow.indexOf(inputVal) >= 0) {
								term.style.display = "block";
							}
						});
					}

					else if (alphabet != "") {
						termList.forEach((term) => {
							let termLow = term.innerHTML.toLowerCase();
							let course = term.getAttribute("course");
							if (course.indexOf(selectedCourse) >= 0 && termLow[0] === alphabet) {
								term.style.display = "block";
							}
						});
					}
				}
				else if (!box.checked) {
					termList.forEach((term) => {
						let course = term.getAttribute("course");
						if (course.indexOf(selectedCourse) >= 0) {
							term.style.display = "none";
						}
					});
				}
			})
		});

		searchInput.addEventListener("keyup", searchTerms);

		function searchTermsEnter(e){
			if (e.keyCode === 13)
				searchTerms(e);
		}

		function searchTerms(e){
			e.preventDefault();
			resetAlphabeticalFilters();
			if (searchInput.value === ""){
				console.log(termList);
				termList.forEach((term) => {
					if (term.style.display == "none")
						term.style.display = "block";
				});
			}
			else {
				termList.forEach((term) => {
					let inputVal = searchInput.value.toLowerCase();
					let termLow = term.innerHTML.toLowerCase();
					let course = term.getAttribute("course");
					if (termLow.indexOf(inputVal) == -1) {
						term.style.display = "none";
					}
					else {
						checkBoxes.forEach((box) => {
							let selectedCourse = box.getAttribute("specific-course");
							if (box.checked || checkBoxForAll.checked) {
								if (course.indexOf(selectedCourse) >= 0)
									term.style.display = "block";
							}
							else {
								if (course.indexOf(selectedCourse) >= 0)
									term.style.display = "none";
							}
						});
					}
				});
			}
		}

	</script>
	<script src="https://kit.fontawesome.com/1a2f647694.js" crossorigin="anonymous"></script>
</body>
