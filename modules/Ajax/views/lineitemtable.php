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
		$LineItems = new LineItemArray();
		$this->_tplData["LineItems"] = $LineItems->LoadByProjectId($_POST["ProjectId"]);
		$vwData = $this->LoadView();
	}
}
?>
