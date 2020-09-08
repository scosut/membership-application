<?php
	/*
		App core class
		Creates URL and loads core controller
		URL format: /controller/method/params
	*/

	class Core {
		protected $currentController = "Pages";
		protected $currentMethod = "index";
		protected $params = [];
		
		public function __construct() {			
			$url = $this->getUrl();
			
			# look in controllers folder for url controller
			if (file_exists("../app/controllers/".ucfirst($url["controller"]).".php")) {
				# set as controller
				$this->currentController = ucfirst($url["controller"]);
			}
			
			# require controller
			require_once "../app/controllers/$this->currentController.php";
				
			# instantiate controller class
			# Pages = new Pages();
			$this->currentController = new $this->currentController;
			
			# check controller for url method
			if ($url["method"]) {
				# check if method exists in controller
				if (method_exists($this->currentController, $url["method"])) {
					$this->currentMethod = $url["method"];
				}
			}
			
			# assign params
			$this->params = $url["params"];
			 
			# call controller method with params
			call_user_func([$this->currentController, $this->currentMethod], $this->params);
		}
		
		public function getUrl() {
			if (isset($_GET["url"])) {
				$url = $_GET["url"];
				$url = rtrim($url, "/");
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode("/", $url);
				
				return [
					"controller" => count($url) > 0 ? $url[0] : null,
					"method" => count($url) > 1 ? $url[1] : null,
					"params" => count($url) > 2 ? $url[2] : null
				];
			}
		}
	}
?>