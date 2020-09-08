<?php
	class Users extends Controller {
		private $userModel;
		
		public function __construct() {
			$this->userModel = $this->model("User");
		}
		
		public function register() {
			# check for POST
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# process form
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				
				$data = Validate::setProperties(["email", "password", "confirm"], $post);
				
				if (Validate::isValidEmail($data->email)) {
					$row = $this->userModel->findUserByEmail($data);
					
					if (!empty($row->email)) {
						Validate::toggleError($data->email, true, "Email is already taken.");
					}
				}														 
				
				if (Validate::isNotEmpty($data->password, "Please enter password.")) {
					Validate::isMinLength($data->password, 6, "Password must be at least 6 characters.");
				}
				
				if (Validate::isNotEmpty($data->confirm, "Please confirm password.")) {
					Validate::doMatch($data->password, $data->confirm, "Passwords do not match.");
				}
				
				if (Validate::isValid($data)) {					
					# hash password
					$data->password->value = password_hash($data->password->value, PASSWORD_DEFAULT);
					
					# register user
					if ($this->userModel->register($data)) {
						Utility::redirect("users/login");
					}
					else {
						die("Something went wrong.");
					}
				}
				else {
					$this->view("users/register", $data);
				}				
			}
			else {
				# load view
				$data  = Validate::setProperties(["email", "password", "confirm"]);
				
				$this->view("users/register", $data);
			}
		}
		
		public function login() {			
			# check for POST
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# process form
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				
				$data = Validate::setProperties(["role", "email", "password"], $post);
				
				if (Validate::isNotEmpty($data->role, "Please select a role.")) {
					$data->email->value    = $data->role->value != "student" ? "{$data->role->value}@hillsdale.edu" : $data->email->value;
					$data->password->value = $data->role->value != "student" ? $data->role->value : $data->password->value;
				}
				
				if ($data->role->value == "student") {
					if (Validate::isValidEmail($data->email)) {
						$row = $this->userModel->findUserByEmail($data);

						if (empty($row->email)) {
							Validate::toggleError($data->email, true, "No user found with that email address.");
						}
						else {
							$role = new stdClass();
							$role->value = $row->role;

							Validate::doMatch($role, $data->role, "Please select the correct role ({$role->value}).");
						}					
					}

					Validate::isNotEmpty($data->password, "Please enter password.");
				}
				
				if (Validate::isValid($data)) {
					// check and set logged in user
					$loggedInUser = $this->userModel->login($data);
					
					if ($loggedInUser) {
						// create session variables
						$this->createUserSession($loggedInUser);
					}
					else {
						Validate::toggleError($data->password, !$loggedInUser, "Incorrect password.");
						$this->view("users/login", $data);
					}
				}
				else {
					$this->view("users/login", $data);
				}			
			}
			else {
				# initialize data
				$data  = Validate::setProperties(["role", "email", "password"]);
				
				# load view
				$this->view("users/login", $data);
			}
		}
		
		public function logout() {
			# unset all session variables
			$_SESSION = [];
			session_destroy();
			Utility::redirect("users/login");
		}

		public function createUserSession($user) {
			$_SESSION["user_id"]     = $user->id;		
			$_SESSION["role"]        = $user->role;
			$_SESSION["user_email"]  = $user->email;
			$_SESSION["has_applied"] = $user->hasApplied;
			Utility::redirect("applications");
		}
	}
?>