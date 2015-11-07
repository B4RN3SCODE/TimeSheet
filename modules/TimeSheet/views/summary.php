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

		$LineItemArray = new LineItemArray();
		foreach((new TimeSheetPeriodArray())->load()->getArray() as $TimeSheetPeriod) {
			$TimeSheetArray[] = $LineItemArray->LoadLineItemTotals($TimeSheetPeriod);
		}
		unset($LineItemArray);

		$this->_tplData["TimeSheets"] = $TimeSheetArray;
		$vwData = $this->LoadView();
	}
}
?>
