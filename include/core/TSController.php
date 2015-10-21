<?php
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
	public $_module;
	public $_view;
	public $_action;
	private $_hasAction;

	public function TSController(array $props_vals = array()) {
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


	public function Ini() {

	}

	private function Proc() {

	}
}
?>
