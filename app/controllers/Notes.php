<?php

class Notes extends Controller {

 public function __construct() {
		$this->noteModel = $this->model("Note");
	}

	public function index() {
		$data = [
			"username" => $_SESSION["username"]
		];

		$this->view('notes/index', $data);
	}

}

?>
