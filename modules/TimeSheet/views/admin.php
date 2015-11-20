<?php
/*
 * admin view for user module
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
class admin extends TSView {
	public function display() {
		$this->setOptions(array());
		$this->_viewTpl = "admin";
		$UserArray = new UserArray();
		$UserArray->load();
		foreach($UserArray->getArray() as $User) {
			$this->_tplData["UserNames"][] = array("value"=>$User->getId(),"label"=>$User->GetName());
		}
		unset($UserArray);
		$PeriodArray = new TimeSheetPeriodArray();
		$PeriodArray->load();
		$this->_tplData["Periods"] = $PeriodArray->GetLoadedCycles();
		$vwData = $this->LoadView();
	}
}
?>
