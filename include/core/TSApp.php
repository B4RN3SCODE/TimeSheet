<?php
include_once("include/app/config.php");
include_once("include/app/glob.php");
include_once("include/data/DBCon.php");
include_once("include/core/TSControllerFactory.php");
include_once("include/core/TSViewFactory.php");
include_once("include/core/TSAuthService.php");
include_once("controllers/User/UserController.php");
/**************************************************
 * TSApp
 *
 * Base class for the application.
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 ***************************************************/
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *
 * 2015-10-20		Tyler J Barnes
 *  - redesigned to accommodate the new "more-of-a-
 *    framework" look
 *
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/

class TSApp {

	/**		Properties		**/

	// configuration (default mvc values - add more to config if needed)
	private $_config_;
	// max time allowed to be logged in for per session
	private $_maxSessionTime_;
	// debug mode - influences logging behavior and such
	private $_debug_;

	// authentication service
	private $_authService;
	// controller
	private $_controller;
	// dbcon instance
	public $_dbAdapter;

	// defaults (should get from config unless config is not passed)
	public $_defaultModule;
	public $_defaultView;
	public $_defaultAction;

	/**	STATIC	**/

	public static $DEFAULT_CONFIG_MAP = array(
		"module"	=>	array(
					"urii"		=>	0,
					"default"	=>	"timesheet",
				),
		"view"		=>	array(
					"urii"		=>	1,
					"default"	=>	"index",
				),
		"action"	=>	array(
					"urii"		=>	2,
					"default"	=>	"index",
				),
	);



	/**		END PROPS		**/


	/***************************
	 * C'TOR
	 * Constructs an application object
	 *
	 * @param config: array config vals (assoc array)
	 * @param debug: bool true means app will run in debug mode --- default false
	 ***************************/
	public function TSApp(array $config = array(), $maxLoggedInTime = 0, $debug = false) {
		// debug mode or not
		$this->_debug_ = $debug;

		$this->setMaxLoggedInTime($maxLoggedInTime);


		// check if config was passed
		if(!isset($config) || !is_array($config) || count($config) !== count(self::$DEFAULT_CONFIG_MAP)) {
			$this->_config_ = $this->getDefaultConfig();
		} else {
			$this->_config_ = $config;
		}


		// store default prop vals
		$this->_defaultModule = $this->_config_["module"];
		$this->_defaultView = $this->_config_["view"];
		$this->_defaultAction = $this->_config_["action"];

		// auth service
		$this->_authService = null;
		// app controller
		$this->_controller = null;

		// database adapter
		$this->_dbAdapter = new DBCon();
		if(!$this->_dbAdapter->Link()) {
			if($this->_debug_) {
				echo "CANT ESTABLISH DB CONNECTION";
				exit;
			}

			/* TODO handle the database connection error in a way that makes sense  replacing the following line of code */
			die("Cant Run Right Now.... sorry dude.");
		}

	}


	public function Boot() {
		// set auth service
		$this->_authService = new TSAuthService($this->_maxSessionTime_);
		// check entry point
		if(!$this->_authService->validEntryPoint()) {
			// TODO handle
		}
		// check user is logged in
		if(!$this->_authService->isLoggedIn()) {
			// set controller as user controller
			$this->_controller = TSControllerFactory::getController("user");
			// set controller vars to execute index & set global error msg
			$this->_controller->setVars(array("_module"=>"user","_view"=>"index","_action"=>"index"));

		} else {
			// find the module, instantiate a controller
			// based on result
			$module = $this->Isolate(self::$DEFAULT_CONFIG_MAP["module"]["urii"]);
			if($module === false)
				$module = $this->_defaultModule;

			$this->_controller = TSControllerFactory::getController($module);

			// get the view and action if there is one
			$view = $this->Isolate(self::$DEFAULT_CONFIG_MAP["view"]["urii"]);
			if($view === false)
				$view = $this->_defaultView;

			$action = $this->Isolate(self::$DEFAULT_CONFIG_MAP["action"]["urii"]);
			if($action === false)
				$action = $this->_defaultAction;

			// set controller vars
			$this->_controller->setVars(array("_module"=>$module,"_view"=>$view,"_action"=>$action));
		}

		if($this->_debug_) {
			echo "<!---";
			var_dump($this);
			echo "--->";
		}
		// run application
		$this->Run();

	}


	private function Run() {

	/*	TODO
	 * 		uncomment when done testing
	 */
		//if(!$this->HasUser()) {
			//if($this->_debug_) {
				//var_dump($_SESSION);
			//}
			//exit;
		//}

		if($this->_controller->Init()) {
			// lets the app access these functions later
			$GLOBALS["APP"]["INSTANCE"] = $this;
			$this->_controller->Proc();
			$this->CleanUp();
		} else {
			die("Could not initialize controller");
		}

	}



	/************************************************
	 * Isolate
	 * Finds the module, view, action vars from the
	 * request URI
	 *
	 * @param uri_idx: int index number
	 * @return string value
	 *************************************************/
	private function Isolate($uri_idx) {
		$uri_cmpnts = explode("/", $_SERVER['REQUEST_URI']);

		foreach($uri_cmpnts as $idx => $cmpnt)
			if(!self::StringHasValue($cmpnt) || is_null($cmpnt))
				unset($uri_cmpnts[$idx]);

		if(count($uri_cmpnts) > $uri_idx)
			return $uri_cmpnts[array_keys($uri_cmpnts)[$uri_idx]];
		else
			return false;
	}


	/*************************************
	 * getDefaultconfig
	 * Gets default config
	 *
	 * @return array of config vals
	 **************************************/
	private function getDefaultConfig() {
		$ret = array();
		foreach(self::$DEFAULT_CONFIG_MAP as $item => $data) {
			$ret[$item] = $data["default"];
		}

		return $ret;
	}



	/********************************
	 * sets max session time allowed
	 * default 1 hour (3600 seconds)
	 *********************************/
	public function setMaxLoggedInTime($secs = DEFAULT_SESSION_TIME) {
		$this->_maxSessionTime_ = $secs;
	}




	private function HasUser() {
		return (isset($_SESSION["User"]) && gettype($_SESSION["User"]) == "User");
	}


	/*****************************************
	 * CleanUp
	 * clear resources and things
	 ****************************************/
	private function CleanUp() {
		return true;
	}


	/*********************************************
	 * SessionActivate
	 * starts a session
	 *
	 * @return bool true if success
	 **********************************************/
	public function SessionActivate() {
		if(isset($_SESSION["PHPSESSID"]) && $_SESSION["PHPSESSID"] == true && isset($_COOKIE["PHPSESSID"]) && !(is_null(session_id())))
			return false;

		if(isset($_SESSION["PHPSESSID"])) unset($_SESSION["PHPSESSID"]);
		session_start();
		$_SESSION["PHPSESSID"] = true;
		return true;
	}

	/*********************************************
	 * SessionTerminate
	 * destroys a session
	 *********************************************/
	public function SessionTerminate() {
		if(isset($_SESSION["PHPSESSID"])) unset($_SESSION["PHPSESSID"]);
		session_destroy();
	}



	public function CookieBake($name = null, $value = null, $expr = 1, $pth = "/", $domain = null, $secr = null, $httpOnly = null) {
		if(!isset($name) || empty($name)) return false;
		$expr = (time() + (3600 * $expr));
		$domain = (is_null($domain)) ? ((isset($_SERVER["HTTP_HOST"])) ? $_SERVER["HTTP_HOST"] : BASE_PTH) : $domain;
		setcookie($name, $value, $expr, $pth, $domain, $secr, $httpOnly);
	}

	public function CookieBurn($name) {
		if(!isset($name) || empty($name)) return false;
		$this->CookieBake($name, "", -1);
	}

	public function BurnAllCookies() {
		foreach($_COOKIE as $name => $props) {
			$this->CookieBurn($name);
		}
	}

	public static function StringHasValue($str = STR_EMP) {
		if(!isset($str) || empty($str) || is_null($str))
			return false;

		$str = str_replace(array(" ", "\t", "\r", "\n"), "", $str);
		return (strlen($str) > 0 && !empty($str) && !is_null($str));
	}



}
?>
