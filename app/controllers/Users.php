<?php

class Users extends Controller
{
	public function __construct()
	{
		$this->userModel = $this->model("User");
	}

	public function login()
	{
		$data = [
			"email" => "",
			"password" => "",
			"emailError" => "",
			"passwordError" => "",
			"verifyError" => ""
		];

		// Check for POST (user has clicked Login)
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				"email" => trim($_POST["email"]),
				"password" => trim($_POST["password"]),
				"emailError" => "",
				"passwordError" => "",
				"verifyError" => ""
			];

			// Validate email
			if (empty($data["email"]))
				$data["emailError"] = "Please enter email to log in";
			else if (filter_var($data["email"], FILTER_VALIDATE_EMAIL))
			{
				if (!$this->userModel->findUserFromDb($data["email"], 1))
					$data["emailError"] = "Email not reigstered";
			}
			else
				$data["emailError"] = "Given email is not a proper email address";
			// Validate password
			if (empty($data["password"]))
				$data["password"] = "Please enter password to log in";

			// Check that there's no errors
			if (empty($data["emailError"]) && empty($data["passwordError"]))
			{
				if (!$loggedInUser = $this->userModel->login($data["email"], $data["password"]))
					$data["passwordError"] = "Invalid Password";
				// Check that the user has verified email
				else if ($loggedInUser->active === '0')
					$data["verifyError"] = "Email not verified, check your inbox!";
				else if ($loggedInUser)
					$this->createUserSession($loggedInUser);
			}
		}
		else
		{
			$data = [
				"email" => "",
				"password" => "",
				"emailError" => "",
				"passwordError" => "",
				"verifyError" => ""

			];
		}
		$this->view("users/login", $data);
	}

	public function createUserSession($user)
	{
		$_SESSION["user_id"] = $user->id;
		$_SESSION["email"] = $user->email;
		$_SESSION["username"] = $user->username;
		$_SESSION["firstName"] = $user->firstName;
		$_SESSION["lastName"] = $user->lastName;
		header("location:" . URLROOT . "/dashboard/index");
	}

	public function logout()
	{
		unset($_SESSION["user_id"]);
		unset($_SESSION["email"]);
		unset($_SESSION["username"]);
		unset($_SESSION["firstName"]);
		unset($_SESSION["lastName"]);
		header("location:" . URLROOT . "/users/login");
	}

	public function register()
	{
		$data = [
			"email" => "",
			"username" => "",
			"firstName" => "",
			"lastName" => "",
			"password" => "",
			"confirmPassword" => "",
			"usernameError" => "",
			"firstNameError" => "",
			"lastNameError" => "",
			"emailError" => "",
			"passwordError" => "",
			"confirmPasswordError" => "",
			"createDatetime" => "",
			"otp" => "",
			"active" => "",
			"mailError" => "",
			"otpError" => ""
		];

		// Check for POST (user has clicked Continue on register site)
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Fill the data array with user registration data
			$data = [
				"username" => htmlspecialchars(stripslashes(trim($_POST["username"]))),
				"email" => htmlspecialchars(stripslashes(trim($_POST["email"]))),
				"firstName" => htmlspecialchars(stripslashes(trim($_POST["firstName"]))),
				"lastName" => htmlspecialchars(stripslashes(trim($_POST["lastName"]))),
				"password" => htmlspecialchars(stripslashes(trim($_POST["password"]))),
				"confirmPassword" => htmlspecialchars(stripslashes(trim($_POST["confirmPassword"]))),
				"usernameError" => "",
				"emailError" => "",
				"passwordError" => "",
				"confirmPasswordError" => "",
				"createDatetime" => date("Y-m-d H:i:s"),
				"otp" => generate_otp(),
				"active" => 0,
				"mailError" => "",
				"otpError" => ""
			];

			$nameValidation = "/^[a-zA-Z0-9]*$/";
			$passwordValidation = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/";

			// Validate username (letters/numbers/4-20 chars)
			if (empty($data["username"]))
				$data["usernameError"] = "Please enter username";
			else if (strlen($data["username"]) < 2 || strlen($data["username"] > 20))
				$data["usernameError"] = "Username must contain 2-20 characters";
			else if (!preg_match($nameValidation, $data["username"]))
				$data["usernameError"] = "Only letters and numbers allowed";
			else
				if ($this->userModel->findUserFromDb("username", $data["username"]))
					$data["usernameError"] = "Username already taken";

			// Validate first name
			if (empty($data["firstName"]))
				$data["firstNameError"] = "First name is required";
			else if (strlen($data["firstName"]) < 2)
				$data["firstNameError"] = "First name has to be at least 2 characters long";

			// Validate last name
			if (empty($data["lastName"]))
				$data["lastNameError"] = "Last name is required";
			else if (strlen($data["lastName"]) < 2)
				$data["lastNameError"] = "Last name has to be at least 2 characters long";

			// Validate email address
			if (empty($data["email"]))
				$data["emailError"] = "Please enter email address";
			else if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
				$data["emailError"] = "Given email is not valid";
			else
				if ($this->userModel->findUserFromDb("email", $data["email"]))
					$data["emailError"] = "Email already registered";

			// Validate password
			if (empty($data["password"]))
				$data["passwordError"] = "Please enter password";
			else if (strlen($data["password"]) < 8)
				$data["passwordError"] = "Password must be at least 8 characters long";
			else if (!preg_match($passwordValidation, $data["password"]))
				$data["passwordError"] = "Must contain, lower-, uppercase, numerical and special (!@#$%) character";

			// Valitade password confirmation
			if (empty($data["confirmPassword"]))
				$data["confirmPasswordError"] = "Please confirm your password";
			else
				if ($data["password"] != $data["confirmPassword"])
					$data["confirmPasswordError"] = "Passwords don't match";

			// Make sure there's no errors
			if (empty($data["usernameError"]) &&
				empty($data["emailError"]) &&
				empty($data["passwordError"]) &&
				empty($data["passwordConfirmError"]) &&
				empty($data["firstNameError"]) &&
				empty($data["lastNameError"]))
			{
				// Encrypt password
				$data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

				// Register user from model function
				if ($this->userModel->register($data))
				{
					// Send verification email
					$email = $data["email"];
					$otp = $data["otp"];
					$subject = "Welcome to BioCluster";
					$message = "Your verification code is $otp <br><br>You can also activate your account by clicking the link below:<br>
					<a href='127.0.01/BioClusteri/users/verify?email=$email&otp=$otp'>Activate Account</a>";
					$headers = "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= 'From: BioCluster <admin@kmoilane.me>' . "\r\n";
					if (mail($data["email"], $subject, $message, $headers))
					{
						// Redirect to verification page
						$_SESSION["email"] = $email;
						header("location: " .URLROOT . "/users/verify?email=" . $email);
					}
					else
					{
						$data["mailError"] = "Failed to send verification code!";
					}
				}
				else
					die ("Oops, Something went wrong...");
			}

		}

		$this->view("users/register", $data);
	}

	public function recover_password()
	{
		$data = [
			"email" => "",
			"emailError" => "",
			"mailError" => "",
			"otp" => ""
		];

		if (isset($_POST["recover"]))
		{
			$data["email"] =  htmlspecialchars(stripslashes(trim($_POST["email"])));
			$data["emailError"] = validateEmail($data, $this);
			if ($data["emailError"] === "Email already registered")
				$data["emailError"] = "";
			if ($data["emailError"] == "")
			{
				if ($this->userModel->findUserFromDb("email", $data["email"]))
				{
					$data["otp"] = generate_otp();

					// Send verification email
					$email = $data["email"];
					$otp = $data["otp"];
					$subject = "BioCluster Password Recovery";
					$message = "Your password recovery code is:<br> $otp <br>";
					$headers = "Content-Type: text/html; charset=UTF-8\r\n";
					$headers .= 'From: BioCluster <admin@kmoilane.me>' . "\r\n";
					if (mail($email, $subject, $message, $headers))
					{
						$this->userModel->setOtp($data);

						// Redirect to verification page
						$_SESSION["email"] = $email;
						header("location: " .URLROOT . "/users/verify_password_recovery");
					}
					else
					{
						$data["mailError"] = "Failed to send verification code!";
					}
				}
				else
					$data["emailError"] = "Unknown error";

			}
			else
			{
				$data["emailError"] = validateEmail($data, $this);
				$this->view("users/recover_password", $data);
			}
			$this->view("users/verify_password_recovery", $data);
		}
		$this->view("users/recover_password", $data);
	}

	public function verify()
	{
		$data = [
			"email" => "",
			"otp" => "",
			"otpError" => ""
		];
		// Check GET
		if (isset($_GET["email"]) && isset($_GET["otp"]))
		{
			$data = [
				"email" => trim($_GET["email"]),
				"otp" => trim($_GET["otp"]),
				"otpError" => ""
			];
			if ($this->userModel->verify($data["email"], $data["otp"]))
			{
				unset($_SESSION["email"]);
				header("location: " . URLROOT . "/users/login");
			}
			else
				$data["otpError"] = "Failed to activate account for: ". $data["email"] .  " with " . $data["otp"] . "\nErrorMsg: " .$_SESSION["msg"];
		}
		// Check POST
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$data = [
				"email" => trim($_SESSION["email"]),
				"otp" => trim($_POST["otp"]),
				"otpError" => ""
			];
			if ($this->userModel->verify($data["email"], $data["otp"]))
			{
				unset($_SESSION["email"]);
				header("location: " . URLROOT . "/users/login");
			}
			else
				$data["otpError"] = "Failed to activate account for: " . $_SESSION["email"] .  " with " . $data["otp"] . "\nErrorMsg: " .$_SESSION["msg"];
		}

		$this->view("users/verify", $data);
	}
}

?>
