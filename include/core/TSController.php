<?php
include_once("include/core/TSViewFactory.php");

/*
 * TSController
 * Baes class for the application controllers
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
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/
class TSController {
	/*
	 * NOTE
	 * 		when we know more about what each module's controller
	 * 		requires to run... we can add tasks here (like
	 * 		pre_action, action, and post_action tasks) that execute
	 * 		when we need it.,.... for now this is a pretty simple
	 * 		process
	 */
	// module
	public $_module;
	// view
	public $_view;
	// action
	public $_action;
	// view processor object
	public $_viewProcessor;
	// service adapter for data manipulation
	public $_serviceAdapter;

	private $_hasAction;

	public function TSController(array $props_vals = array()) {
		$this->_viewProcessor = null;
		$this->_serviceAdapter = null;

		$this->setVars($props_vals);
		$this->_hasAction = (isset($this->_action) && !empty($this->_action) && strtolower($this->_action) != "index");
	}

  protected function Redirect($module, $view, $action="index") {
    $this->setVars(array("_module"=>strtolower($module),"_view"=>strtolower($view),"_action"=>strtolower($action)));
    $this->Init();
  }



	public function setVars(array $arr = array()) {
		foreach($arr as $prop => $val) {
			if(property_exists($this, $prop)) {
				$this->$prop = $val;
			}
		}
	}


	public function Init() {
		$this->_viewProcessor = TSViewFactory::getView($this->_module, $this->_view);
		$tmp = $GLOBALS["APP"]["MODULE_MAP"][strtolower($this->_module)];
		$srv_name = "{$tmp}ServiceAdapter";
		$srv_file = "services/{$tmp}/{$srv_name}.php";
		if(file_exists($srv_file)) {
			$this->_serviceAdapter = new $srv_name($GLOBALS["APP"]["INSTANCE"]->_dbAdapter);
		}

		$this->Proc($this->_hasAction);
//		if(!$this->_hasAction) {
//			$this->Proc(true);
//		}
		return true;
	}

	public function Proc($forceIndexAction = false) {
		ob_start(); // start considering saving display stuff to buffer

		if($forceIndexAction) {
			$this->index();
		} else {
			$this->_viewProcessor->SetUp(); // not sure what this should do yet... maybe look for extra js files to include or something
			$this->{$this->_action}();
			// end output buffering shit in the view
		}
	}

	public function GetModule() { return $this->_module; }
	public function GetView() { return $this->_view; }
	public function GetAction() { return $this->_action; }

	protected function EncodeAndSendJSON($arrayData) {
		$jsonData = json_encode($arrayData);
		header('Content-Type: application/json');
		echo $jsonData;
	}

}
?>
