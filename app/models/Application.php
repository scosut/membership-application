<?php
	class Application {
		private $db;
		
		public function __construct() {
			$this->db = new Database();
		}
		
		# find all applications
		public function getApps($user_id) {
			$this->db->query("CALL spGetApps(:user_id)");
			$this->db->bind(":user_id", $user_id);
			$results = $this->db->resultSet();

			return $results;
		}
		
		public function addApp($data) {
			$this->db->query("CALL spAddApp(:sid, :first, :last, :daypref, :timepref, :user_id)");
			
			$params = [
				":sid"      => $data->sid->value, 
				":first"    => $data->first->value, 
				":last"     => $data->last->value,
				":daypref"  => $data->daypref->value,
				":timepref" => $data->timepref->value,
				":user_id"  => $data->user_id->value
			];
			
			$this->db->bindArray($params);
			
			# execute
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function approveApp($id) {
			$this->db->query("CALL spApproveApp(:id)");
			$this->db->bind(":id", $id);			
			
			# execute
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function recordApp($id) {
			$this->db->query("CALL spRecordApp(:id)");
			$this->db->bind(":id", $id);
			
			# execute
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function getAppById($id) {
			$this->db->query("CALL spGetAppById(:app_id)");
			$this->db->bind(":app_id", $id);
			$row = $this->db->single();

			return $row;
		}
	}
?>