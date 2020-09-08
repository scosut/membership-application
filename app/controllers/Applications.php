<?php
	class Applications extends Controller {
		private $applicationModel;
		
		public function __construct() {
			# make all application functionality available only to logged in users
			# otherwise per method basis
			
			# check whether user is logged in
			if (!Utility::isLoggedIn()) {
				Utility::redirect("users/login");
			}
			
			$this->applicationModel = $this->model("Application");
		}
		
		public function index() {
			if (Utility::isLoggedIn()) {
				$role     = $_SESSION["role"];
				$user_id  = $role == "student" ? $_SESSION["user_id"] : null;
				$apps     = $this->applicationModel->getApps($user_id);
				$status   = Utility::getStatus($role, $apps);
				$dates    = [];				
				$date_key = $role == "approver" ? "dateApproved" : ($role == "cashier" ? "dateRecorded" : "");
				$filter   = null;
				
				if ($role != "student") {
					foreach($apps as $app) {
						if (!empty($app->$date_key)) {
							$date_string = date("Y-m-d", strtotime($app->$date_key));
							
							if (!in_array($date_string, $dates)) {
								$dates[] = $date_string;
							}
						}
					}
						
					usort($dates, function($a, $b) {
						return strtotime($b) - strtotime($a);
					});
				}
				
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					# process form
					$post   = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$filter = $post["filter"];
					
					$apps_filtered = array_filter($apps, function($app) use($filter, $date_key) {
						if ($filter == "approved" || $filter == "recorded") {
							return !empty($app->$date_key);
						}
						elseif ($filter == "pending") {
							return empty($app->$date_key);
						}
						elseif (date('Y-m-d', strtotime($filter)) == $filter) {
							return date('Y-m-d', strtotime($app->$date_key)) == $filter;
						}
						return $app;
					});
					
					if (count($apps_filtered) > 0) {
						$apps = $apps_filtered;
					}
				}

				$data = [
					"applications" => $apps,
					"role" => $role,
					"status" => $status,
					"dates" => $dates,
					"filter" => $filter
				];

				$this->view("applications/index", $data);
			}
		}
		
		public function add() {
			# check for POST
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# process form
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$post["user_id"] = $_SESSION["user_id"];
				$post["daypref"] = array_key_exists("daypref", $post) ? join(",", $post["daypref"]) : "";
				
				$data = Validate::setProperties(["sid", "first", "last", "email", "daypref", "timepref", "user_id"], $post);
				
				Validate::isNotEmpty($data->sid, "Please enter student ID.");
				
				Validate::isNotEmpty($data->first, "Please enter first name.");
				
				Validate::isNotEmpty($data->last, "Please enter last name.");
				
				Validate::isNotEmpty($data->daypref, "Please select a day.");
				
				Validate::isNotEmpty($data->timepref, "Please select a time.");
				
				if (Validate::isValid($data)) {
					if ($this->applicationModel->addApp($data)) {
						$_SESSION["has_applied"] = true;
						Utility::redirect("applications");
					}
					else {
						die("Something went wrong");
					}
				}
				else {
					echo "errors";
					$this->view("applications/add", $data);
				}
			}
			else {
				if (Utility::isRole("student") && !Utility::hasApplied()) {
					# load view
					$data  = Validate::setProperties(["sid", "first", "last", "email", "daypref", "timepref", "user_id"]);
					$data->email->value = $_SESSION["user_email"];
				
					$this->view("applications/add", $data);
				}
				else {					
					Utility::redirect("applications");
				}
			}
		}
		
		public function approve($id) {
			# check for POST
			if ($_SERVER["REQUEST_METHOD"] == "POST") {				
				if ($this->applicationModel->approveApp($id)) {
					Utility::redirect("applications");
				}
				else {
					die("Something went wrong");
				}				
			}
			else {
				# get existing application from model
				$app = $this->applicationModel->getAppById($id);

				if (Utility::isRole("approver") && !empty($app->dateSubmitted) && empty($app->dateApproved)) {
					# load view				
					$data = Validate::setProperties(["appId", "sid", "first", "last", "email", "daypref", "timepref"], ["appId" => $id, "sid" => $app->sid, "first" => $app->first, "last" => $app->last, "email" => $app->email, "daypref" => $app->daypref, "timepref" => $app->timepref]);

					$this->view("applications/approve", $data);
				}
				else {					
					Utility::redirect("applications");
				}				
			}
		}
		
		public function record($id) {
			# check for POST
			if ($_SERVER["REQUEST_METHOD"] == "POST") {				
				if ($this->applicationModel->recordApp($id)) {
					Utility::redirect("applications");
				}
				else {
					die("Something went wrong");
				}				
			}
			else {
				# get existing application from model
				$app = $this->applicationModel->getAppById($id);

				if (Utility::isRole("cashier") && !empty($app->dateApproved) && empty($app->dateRecorded)) {
					# load view				
					$data = Validate::setProperties(["appId", "sid", "first", "last", "email", "daypref", "timepref"], ["appId" => $id, "sid" => $app->sid, "first" => $app->first, "last" => $app->last, "email" => $app->email, "daypref" => $app->daypref, "timepref" => $app->timepref]);

					$this->view("applications/record", $data);
				}
				else {					
					Utility::redirect("applications");
				}				
			}
		}
	}
?>