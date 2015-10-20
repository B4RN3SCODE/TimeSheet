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

	// configuration (default values - add more to config if needed)
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

	public static $_DEFAULT_CONFIG_ = array(
			"defaultModule"=>"timesheet",
			"defaultView"=>"index",
			"defaultAction"=>"index"
		);

	// change this only if the URI structure changes
	//	ex: (http://asdfadsf.com/timesheet/view/save [vars represented by index])
	public static $_URI_STRUCT_ = array(
			0=>"module",
			1=>"view",
			2=>"action",
		);

	/**		END PROPS		**/


	/***************************
	 * C'TOR
	 * Constructs an application object
	 *
	 * @param config - array of defaults
	 * 					(defaultAction can be
	 * 					index or an empty string)
	 * @param debug  - bool true means debug mode
	 * @return void
	 ***************************/
	public function TSApp(array $config = array(), $debug = false) {
		$this->_debug_ = $debug;

		// set default configuration
		if(!isset($config) || !is_array($config) || count($config) != count(self::$_DEFAULT_CONFIG_)) {
			$this->_config_ = self::$_DEFAULT_CONFIG_;
		} else {
			$this->_config_ = $config;
		}

		foreach($this->_config_ as $prop => $val) {
			$tmp = "_".$prop;
			$this->$tmp = $val;
		}
		////// end setting up config

		// set up controller
		$this->_controller = null;
		// set up db adapter
		$this->_dbAdapter = new DBCon();
		if(!$this->_dbAdapter->Link()) {
			// TODO
				// kill the application because we cant connect to db
		}

		//////////////////////////////////////////
		////	END CONSTRUCTOR
		/////////////////////////////////////////
	}


	public function Boot() {
		/*	TODO
		 * 		figure out how to do this better!
		 * 		shouldnt have to repeat code with just var names
		 * 		changed...
		 */
		$module = $this->Isolate("module");
		if($module === false) {
			$module = $this->_defaultModule;
		}

		$view = $this->Isolate("view");
		if($view === false) {
			$view = $this->_defaultView;
		}

		$action = $this->Isolate("view");
		if($action === false) {
			$action = $this->_defaultAction;
		}
		/**	END SHIT TO DO	**/


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
	 * @return bool true if successfull
	 *************************************************/
	private function Isolate($name_of_uri_component = STR_EMP) {
		// get the index of the item in the uri struct
		$uri_index = array_flip(self::$_URI_STRUCT_)[$name_of_uri_component];


		// uri components to array
		$uri_cmpnts = explode("/", $_SERVER['REQUEST_URI']);

		// unset empty values
		foreach($uri_cmpnts as $idx => $cmpnt)
			if(!self::StringHasValue($cmpnt) || is_null($cmpnt))
				unset($uri_cmpnts[$idx]);

		// isolate accordingly
		if(count($uri_cmpnts) > $uri_index) {
			$tmp = $uri_cmpnts[array_keys($uri_cmpnts)[$uri_index]];
			// case insensitive module names (from url)
			return ucwords(strtolower($tmp));

		} else {
			return false;
		}
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
