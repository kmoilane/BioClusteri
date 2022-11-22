<?php

$term = false;
$explanation = false;
$courses = [
	"1" => false,
	"2" => false,
	"3" => false,
	"4" => false,
	"5" => false
];

if ($_SESSION["title"] === "Käsite")
{
	$term = htmlspecialchars($data[0]->term);
	$explanation = $data[0]->explanation;
	if (strpos($data[0]->course, "1") !== false)
	{
		$courses["1"] = true;
	}
	if (strpos($data[0]->course, "2") !== false)
	{
		$courses["2"] = true;
	}
	if (strpos($data[0]->course, "3") !== false)
	{
		$courses["3"] = true;
	}
	if (strpos($data[0]->course, "4") !== false)
	{
		$courses["4"] = true;
	}
	if (strpos($data[0]->course, "5") !== false)
	{
		$courses["5"] = true;
	}
}

?>

<div class="popup-container">
	<div class="popup-form-container" id="addTermForm">
		<div id="closeFormBtn" class="round-btn">
			<ion-icon name="close-outline"></ion-icon>
		</div>
		<h1>Lisää uusi käsite</h1>
		<form id="addTermForm" method="POST">
			<span class="user-form-error">
				<?php echo $data["termError"]; ?>
			</span>
			<input id="addTermName" type="text" placeholder="Käsite" name="term" value="<?php echo $term; ?>">
			<p>Valitse yksi tai useampi kurssi, jolle käsite kuuluu</p>
			<span class="user-form-error">
				<?php echo $data["courseError"]; ?>
			</span>
			<ul class="filter-checkboxes">
				<li><input type="checkbox" name="course[]" id="addOne" value="1" <?php if ($courses["1"]) {echo "checked";} ?>><label for="addOne">Bilsa 1</label></li>
				<li><input type="checkbox" name="course[]" id="addTwo" value="2" <?php if ($courses["2"]) {echo "checked";} ?>><label for="addTwo">Bilsa 2</label></li>
				<li><input type="checkbox" name="course[]" id="addThree" value="3" <?php if ($courses["3"]) {echo "checked";} ?>><label for="addThree">Bilsa 3</label></li>
				<li><input type="checkbox" name="course[]" id="addFour" value="4" <?php if ($courses["4"]) {echo "checked";} ?>><label for="addFour">Bilsa 4</label></li>
				<li><input type="checkbox" name="course[]" id="addFive" value="5" <?php if ($courses["5"]) {echo "checked";} ?>><label for="addFive">Bilsa 5</label></li>
			</ul>
			<span class="user-form-error">
				<?php echo $data["explanationError"]; ?>
			</span>
			<textarea name="explanation" id="addTermExplanation" placeholder="Lisää selitys" cols="30" rows="10" maxlength="500" value="<?php echo $explanation; ?>"></textarea>
			<input type="submit" value="Tallenna" disabled name="saveTerm" id="popupSaveBtn">
		</form>
	</div>
</div>
