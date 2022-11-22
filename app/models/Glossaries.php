<?php

class Glossaries
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function fetchTerm($term)
	{
		$this->db->query("SELECT * FROM terms WHERE term = :term");

		$this->db->bind(":term", $term);

		return $this->db->resultSet();
	}

	public function fetchAllTerms()
	{
		$this->db->query("SELECT * FROM terms ORDER BY term ASC");

		return $this->db->resultSet();
	}

	public function addTerm($data)
	{
		$this->db->query("INSERT INTO terms (term, course, explanation) VALUES (:term, :course, :explanation)");

		$this->db->bind(":term", $data["term"]);
		$this->db->bind(":course", $data["course"]);
		$this->db->bind(":explanation", $data["explanation"]);

		if ($this->db->execute())
			return true;
		else
			return false;
	}
}

?>
