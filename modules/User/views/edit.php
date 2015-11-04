<?php
/*
 * edit view for user module
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
class edit extends TSView {

	function __constructor() {
		$forceLogin = false;
	}
	public function display() {
		$this->setOptions(array());
		if($GLOBALS["APP"]["FORCE_LOGIN"]) {
			$this->_viewTpl = "login";
		} else {
			$this->_viewTpl = "edit";
			$client = isset($_POST["client"]) ? $_POST["client"] : -1;
			$project = isset($_POST["project"]) ? $_POST["project"] : -1;
			$this->_tplData["MyClients"] = $_SESSION["User"]->GetClientProjectArray($client,$project);
		}
		$vwData = $this->LoadView();
	}
}
?>

