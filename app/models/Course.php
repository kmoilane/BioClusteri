<?php

class Course {
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function fetchAllCourses()
	{
		$this->db->query("SELECT * FROM courses");

		return $this->db->resultSet();
	}
}

?>
