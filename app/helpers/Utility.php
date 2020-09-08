<?php
	class Utility {
		public static function isActive($path) {
			return $_SERVER["REQUEST_URI"] == $path;
		}
		
		public static function setActive($path) {
			return self::isActive($path) ? " class=\"btn\"" : "";
		}		
		
		public static function redirect($location) {
			header("location: ".URL_ROOT."/$location");
		}		
		
		public static function isLoggedIn() {
			return isset($_SESSION["user_id"]);
		}
		
		public static function hasApplied() {
			return isset($_SESSION["has_applied"]) && $_SESSION["has_applied"] == true;
		}
		
		public static function isRole($role) {
			return isset($_SESSION["role"]) && $_SESSION["role"] == $role;
		}		
		
		public static function getStatus($role, $apps) {
			$status = null;
			
			if ($role == "student") {
				if (count($apps) == 0) {
					$status = "You have not submitted an application.<span class=\"btn-wrapper\"><a href=\"applications/add\" class=\"btn\">Apply Now</a></span>";
				}
				else {
					foreach($apps as $app) {
						if (empty($app->dateApproved)) {
							$status = "Your application is pending approval.";
						}
						elseif (empty($app->dateRecorded)) {
							$status = "Your application has been approved. Please pay your membership fees at the cashier's office.";
						}
						else {
							$status = "Your payment has been recorded. Your membership is now complete.";
						}
					}
				}
			}
			else {
				if (count($apps) == 0) {
					$status = "No applications have been submitted. Please check back at a later time.";
				}
			}
		
			return $status;
		}
	}
?>