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

	private $_hasAction;

	public function TSController(array $props_vals = array()) {
		$this->_viewProcessor = null;

		$this->setVars($props_vals);
		$this->_hasAction = (isset($this->_action) && !empty($this->_action) && strtolower($this->_action) != "index");
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
		if(!$this->_hasAction) {
			$this->index();
			return false;
		}
		return true;
	}

	public function Proc() {
		// TODO introduce output buffering shit when needed
		$this->_viewProcessor->SetUp(); // not sure what this should do yet... maybe look for extra js files to include or something
		$this->{$this->_action}();
		// end output buffering shit in the view
	}

}
?>
