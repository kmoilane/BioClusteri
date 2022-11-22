<?php

class Glossary extends Controller {

	public function __construct()
	{
		$this->glossariesModel = $this->model("Glossaries");
	}
/*
	public function term()
	{
		$data = [];
		if (isset($_GET["glossary"]))
		{
			$data = $this->glossariesModel->fetchTerm($_GET["glossary"]);
		}
		$this->view("glossary/term", $data);
	}
*/
	public function index()
	{
		$data = [];
		$termData = [
			"term" => "",
			"course" => "",
			"explanation" => "",
			"termError" => "",
			"courseError" => "",
			"explanationError" => ""
		];

		if (isset($_GET["term"])) {
			$data = $this->glossariesModel->fetchTerm($_GET["term"]);
			$data = array_merge($data, $termData);
			$this->view("glossary/term", $data);
		}

		else if (!isset($_GET["term"])) {
			$data = $this->glossariesModel->fetchAllTerms();
			$data = array_merge($data, $termData);

			if (isset($_SESSION["msg"]))
				unset($_SESSION["msg"]);

			if (isset($_POST["saveTerm"])) {
				$coursesArray = (isset($_POST['course'])) ? $_POST['course'] : array();
				$courses = "";
				if (count($coursesArray) > 0) {
					foreach ($coursesArray as $course) {
						$courses .= $course;
					}
				}

				$data["term"] = trim($_POST["term"]);
				$data["course"] = $courses;
				$data["explanation"] = trim($_POST["explanation"]);

				if (empty($data["term"])) {
					$data["termError"] = "Antaisitko termille nimen :)";
				}

				if (empty($data["course"])) {
					$data["courseError"] = "Valitse vähintään yksi kurssi :)";
				}

				if (empty($data["explanation"])) {
					$data["explanationError"] = "Antaisitko edes lyhyen selityksen termillesi :)";
				}

				if (empty($data["termError"]) &&
					empty($data["courseError"]) &&
					empty($data["explanationError"])) {
					if ($this->glossariesModel->addTerm($data)) {
						header("location: " .URLROOT."/glossary/");
					}
					else
						die("Oopsie daisie");
				}
			}
			$this->view("glossary/index", $data);
		}
		else
			$this->view("glossary/index", $data);
	}


}

?>
