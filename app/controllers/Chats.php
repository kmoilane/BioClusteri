<?php

class Chats extends Controller {

 public function __construct() {
		$this->chatModel = $this->model("Chat");
	}

	public function index() {
		$data = [
			"username" => $_SESSION["username"]
		];

		$this->view('chats/index', $data);
	}

}

?>
