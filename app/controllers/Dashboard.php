<?php

class Dashboard extends Controller {

	public function __construct()
	{
		$this->dashModel = $this->model("Dash");
	}

	public function index() {
		$data = [
			"username" => $_SESSION["username"]
		];

		$this->view('dashboard/index', $data);
	}

}

?>
