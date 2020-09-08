<?php
	class User {
		private $db;
		
		public function __construct() {
			$this->db = new Database();
		}
		
		# register user
		public function register($data) {
			$this->db->query("CALL spRegisterUser(:email, :password)");
			
			$params = [
				":email"    => $data->email->value, 
				":password" => $data->password->value
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
		
		# login user
		public function login($data) {
			$row = $this->findUserByEmail($data);
			
			if (password_verify($data->password->value, $row->password)) {
				return $row;
			}
			else {
				return false;
			}
		}
		
		# find user by email
		public function findUserByEmail($data) {
			$this->db->query("CALL spFindUserByEmail(:email)");
			$this->db->bind(":email", $data->email->value);
			$row = $this->db->single();
			
			# check row			
			return $row;
		}
	}	
?>