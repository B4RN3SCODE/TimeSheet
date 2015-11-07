<?php
/*
 * index view for user module
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
class summary extends TSView {
	public function display() {
		$this->setOptions(array());
		$this->_viewTpl = "summary";

		foreach((new TimeSheetPeriodArray())->load()->getArray() as $TimeSheetPeriod) {
			$TimeSheetArray[] = (new LineItemArray())->LoadLineItemTotals($TimeSheetPeriod);
		}

		$this->_tplData["TimeSheets"] = $TimeSheetArray;

		$this->_tplData["UserEntries"] = (new User())->LoadAllUserEntries();
		$vwData = $this->LoadView();
	}
}
?>
