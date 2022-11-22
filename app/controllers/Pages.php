<?php

class Pages extends Controller
{
	public function __construct()
	{
		$this->pageModel = $this->model("Page");
	}

	public function index()
	{
		$uname = null;
		if (isset($_SESSION["username"]))
			$uname = $_SESSION["username"];
		$data = [
			"username" => $uname
		];
		$this->view("pages/index", $data);
	}
}

?>
