<?php
include_once("include/app/config.php");
include_once("include/app/glob.php");
include_once("include/data/DBCon.php");
include_once("include/core/TSControllerFactory.php");
include_once("include/core/TSViewFactory.php");

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
	public $_config_;
	// debug mode - influences logging behavior and such
	public $_debug_;

	// controller
	public $_controller;
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
		"view"	=>	array(
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
	 ***************************/
	public function TSApp(array $config = array(), $debug = false) {
		// debug mode or not
		$this->_debug_ = $debug;

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

		// app controller
		$this->_controller = null;

		// database adapter
		$this->_dbAdapter = new DBCon();
		if(!$this->_dbAdapter->Link()) {
			if($this->_debug_) {
				echo "CANT ESTABLISH DB CONNECTION";
				exit;
			}

			/* TODO handle the database connection error in a way that makes sense */
		}

	}


	public function Boot() {


		$this->Run();

	}


	private function Run() {
		// lets the app use these functions later without having everything static
		$GLOBALS["APP"]["INSTANCE"] = $this;
	}




	/************************************************
	 * Isolate
	 * Isolates the module, view, action vars from the
	 * request URI
	 *
	 *************************************************/
	private function Isolate() {
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
