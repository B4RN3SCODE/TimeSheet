<?php
/*
 * Line Item Table view for Ajax module
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
class lineitemtable extends TSView {
	public function display() {
		$this->setOptions(array("head"=>false,"foot"=>false,"nav"=>false));
		$this->_viewTpl = "lineitemtable";
		if(!isset($_POST["ProjectId"])) die("Error: No ProjectId provided");
		$CycleStart = (isset($_POST["BillingPeriod"])) ? date("Y/m/d",substr($_POST["BillingPeriod"],0,strpos($_POST["BillingPeriod"],"-"))) : null;
		$CycleEnd = (isset($_POST["BillingPeriod"])) ? date("Y/m/d",substr($_POST["BillingPeriod"],strpos($_POST["BillingPeriod"],"-") + 1)) : null;
		$LineItems = new LineItemArray();
		$this->_tplData["LineItems"] = $LineItems->LoadLineItems($_POST["ProjectId"],$CycleStart,$CycleEnd);
		$this->_tplData["Submitted"] = TimeSheetSubmit::Submitted($_SESSION["User"]->getId(),$_SESSION["CurrentBillingPeriod"]["StartDate"],$_SESSION["CurrentBillingPeriod"]["EndDate"]); //$TimeSheet->CheckSubmitted($CycleStart,$CycleEnd);
		$vwData = $this->LoadView();
	}
}
?>
