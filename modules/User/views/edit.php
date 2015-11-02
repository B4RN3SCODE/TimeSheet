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
		}
		$vwData = $this->LoadView();
	}
}
?>

