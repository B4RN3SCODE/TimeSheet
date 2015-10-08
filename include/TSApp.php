<?php
include_once("include/config.php");
include_once("include/glob.php");
include_once("include/TSView.php");
include_once("include/DBCon.php");

/**************************************************
 * TSApp
 *
 * Base class for the application.
 *
 * @author			CT Technologies
 * @contact			b4rn3scode@gmail.com
 * @version			1.0
 ***************************************************/
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/

class TSApp {

	/**		Properties		**/
	public $Module;
	public $View;
	public $Action;


	/**		Static Properties		**/
	public static $DFLT_MODULE = "Index";
	public static $DFLT_ACTION = "Index";
	public static $DFLT_VIEW = "index";


	/**		END PROPS		**/



	public function TSApp() {
		/*
		 * TODO
		 * 		make err handler function to alert us
		 * 		with code and sys errors
		 */
		 //set_error_handler(array($this, "FTErrorHandler"));

		date_default_timezone_set("America/Los_Angeles");
	}


	public function Boot() {
		$this->IsolateModule();
		$this->IsolateView();
		$this->IsolateAction();
		$this->Run();

	}


	private function Run() {
		// lets the app use these functions later without having everything static
		$GLOBALS["App"]["Instance"] = $this;

		die('havent gotten this far yet... figuring out importing scripts next');

		/*
		 * 	TODO
		 * 		run the app here...
		 * 		use the isolated items to import scripts and GO
		 */
	}



	/*********************************
	 * Isolates the target module
	 *********************************/
	public function IsolateModule() {
		// uri components to array
		$uri_cmpnts = explode("/", $_SERVER['REQUEST_URI']);

		// unset empty values
		foreach($uri_cmpnts as $idx => $cmpnt)
			if(!self::StringHasValue($cmpnt) || is_null($cmpnt))
				unset($uri_cmpnts[$idx]);

		// isolate accordingly
		if(count($uri_cmpnts) > 0) {
			$this->Module = $uri_cmpnts[array_keys($uri_cmpnts)[0]];
			// case insensitive module names (from url)
			$this->Module = ucwords(strtolower($this->Module));
		} else {
			$this->Module = self::$DFLT_MODULE;
		}

		// set application level shit
		$_SESSION['Module'] = $GLOBALS['App']['Module'] = $this->Module;

	}


	/********************************************
	 * Isolates the target view
	 * Default view is index.php (index)
	 *********************************************/
	public function IsolateView() {

		$uri_cmpnts = explode("/", $_SERVER['REQUEST_URI']);

		foreach($uri_cmpnts as $idx => $cmpnt)
			if(!self::StringHasValue($cmpnt) || is_null($cmpnt))
				unset($uri_cmpnts[$idx]);

		if(count($uri_cmpnts) > 1)
			$this->View = $uri_cmpnts[array_keys($uri_cmpnts)[1]];
		else
			$this->View = self::$DFLT_VIEW;

		// set application level shit
		$_SESSION['View'] = $GLOBALS['App']['View'] = $this->View;
	}



	/********************************************
	 * Isolates the target action
	 * default index
	 *********************************************/
	public function IsolateAction() {
		$uri_cmpnts = explode("/", $_SERVER['REQUEST_URI']);

		foreach($uri_cmpnts as $idx => $cmpnt)
			if(!self::StringHasValue($cmpnt) || is_null($cmpnt))
				unset($uri_cmpnts[$idx]);

		if(count($uri_cmpnts) > 2)
			$this->Action = $uri_cmpnts[array_keys($uri_cmpnts)[2]];
		else
			$this->Action = self::$DFLT_ACTION;

		// set application level shit
		$_SESSION['Action'] = $GLOBALS['App']['Action'] = $this->Action;
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
