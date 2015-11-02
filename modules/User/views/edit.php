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
			$ClientArray = new ClientArray();
			$ClientArray->load();
			foreach($ClientArray->getArray() as $Client) {
				$this->_tplData["Clients"][$Client->getId()] = $Client->getName();
			}
			$TSsettings = new TimeSheetSettings();
			if($TSsettings->load($_SESSION["User"]->getId())) {
				$DefaultClient = $TSsettings->getDefaultClient();
				$DefaultProject = $TSsettings->getDefaultProject();
			} else {
				$DefaultClient = 0;
				$DefaultProject = 0;
			}
			$this->_tplData["DefaultClient"] = $DefaultClient;
			$this->_tplData["DefaultProject"] = $DefaultProject;
			if(isset($DefaultClient)) {
				$ProjectArray = new ProjectArray();
				foreach($ProjectArray->LoadByClientId($DefaultClient) as $id => $vals) {
					$this->_tplData["Projects"][$id] = $vals["Name"];
				}
			} else {
				$this->_tplData["Projects"] = null;
			}
		}
		$vwData = $this->LoadView();
	}
}
?>

