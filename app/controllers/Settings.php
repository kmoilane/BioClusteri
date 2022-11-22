<?php

class Settings extends Controller {

	public function __construct()
	{
		$this->settingModel = $this->Model("Setting");
	}

	public function index()
	{
		$data = [
			"username" => $_SESSION["username"]
		];

		$this->view("settings/index", $data);
	}
}

?>
