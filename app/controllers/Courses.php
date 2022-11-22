<?php

class Courses extends Controller {

	public function __construct()
	{
		$this->courseModel = $this->model("Course");
	}

	public function index() {

		$data = $this->courseModel->fetchAllCourses();
		$this->view('courses/index', $data);
	}

}

?>
