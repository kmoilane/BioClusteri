<?php

class Controller
{

	public function model($model)
	{
		// Require model file
		require_once "../app/models/" . $model . ".php";
		// Instantiate model
		return new $model();
	}

	// Check for the view and load it if it exists
	public function view($view, $data = [])
	{
		if (file_exists("../app/views/" . $view . ".php"))
			require_once "../app/views/" . $view . ".php";
		else
			header("location: " .URLROOT."/dashboard/");
	}

}
?>
