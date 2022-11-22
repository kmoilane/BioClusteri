<?php

class Forums extends Controller {

 public function __construct() {
		$this->forumModel = $this->model("Forum");
	}

	public function index() {
		$data = [
			"username" => $_SESSION["username"]
		];

		$this->view('forums/index', $data);
	}

}

?>
