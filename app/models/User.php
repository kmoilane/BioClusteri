<?php

class User
{
	private $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function register($data)
	{
		$this->db->query("INSERT INTO users (email, username, firstName, lastName, password, otp, active, createDatetime) VALUES
		(:email, :username, :firstName, :lastName, :password, :otp, :active, :createDatetime)");

		// Bind values
		$this->db->bind(":email", $data["email"]);
		$this->db->bind(":username", $data["username"]);
		$this->db->bind(":firstName", $data["firstName"]);
		$this->db->bind(":lastName", $data["lastName"]);
		$this->db->bind(":password", $data["password"]);
		$this->db->bind(":otp", $data["otp"]);
		$this->db->bind(":active", $data["active"]);
		$this->db->bind(":createDatetime", $data["createDatetime"]);

		// Execute function
		if ($this->db->execute())
			return true;
		else
			return false;
	}


	public function login($email, $password)
	{
		$this->db = $this->findUserFromDb($email, 1);

		$row = $this->db->single();
		$hashedPassword = $row->password;

		if (password_verify($password, $hashedPassword))
		{
			// Remove OTP if there is one
			$this->db->query("UPDATE users SET otp = :otp WHERE email = :email");

			$this->db->bind(":email", $email);
			$this->db->bind(":otp", "");
			$this->db->execute();

			return $row;
		}
		else
			return false;
	}

	public function findUserFromDb($email, $login = 0)
	{
			// Prepared statement
			$this->db->query("SELECT * FROM users WHERE email = :email");

			// Bind email parameter with email variable
			$this->db->bind(":email", $email);

			// Return prepared and binded statement if logging in
			if ($login == 1)
				return $this->db;

			// Check if email is already in db
			if ($this->db->rowCount() > 0)
				return true;
			else
				return false;
	}

	public function setOtp($data)
	{
		if (isset($data["email"]) && isset($data["otp"]))
		{
			$this->db->query("UPDATE users SET otp = :otp WHERE email = :email");
			$this->db->bind(":otp", $data["otp"]);
			$this->db->bind(":email", $data["email"]);
			if ($this->db->execute())
				return true;
		}
		return false;
	}

	public function verify($email, $otp, $active = 0)
	{
		$this->db->query("SELECT * FROM users
		WHERE `email` = :email AND `otp` = :otp AND `active` = :active");

		$this->db->bind(":email", $email);
		$this->db->bind(":otp", $otp);
		$this->db->bind(":active", $active);

		if ($this->db->rowCount() === 0)
		{
			$this->db->query("UPDATE users SET active = :active, otp = :otp WHERE email = :email");

			$this->db->bind(":email", $email);
			$this->db->bind(":otp", "");
			$this->db->bind(":active", 1);


			if ($this->db->execute())
				if ($this->initiateProfile($email))
					return true;
			else
			{
				$_SESSION["msg"] = "Failed to execute";
				return false;
			}
		}
		return false;
	}

	// Creates new profile to database
	public function initiateProfile($email)
	{
		$this->db->query("INSERT INTO `profiles` (`user_id`) SELECT users.id FROM `users` WHERE users.email = :email");
		$this->db->bind(":email", $email);
		if ($this->db->execute())
			return true;
		else
			return false;

	}
}

?>
