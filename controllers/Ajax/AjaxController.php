<?php
/*
 * UserController
 * Controller for the user module
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
class AjaxController extends TSController
{

	/**
	 * UserController constructor
	 */
	public function __construct()
	{
		if (isset($_SESSION["User"])) {
			$this->User = $_SESSION["User"];
		}
	}

	public function index()
	{
		$this->_viewProcessor->display();
	}

	public function DisplayLineItemsByProject() {
		if(!isset($_POST["ProjectId"]) || empty($_POST["ProjectId"])) die();
		$this->_viewProcessor->_tplData["woah"] = "yeah";
		$this->Redirect("ajax","lineitemtable");
	}

	public function RemoveLineEntry() {
		if(!isset($_POST["LineEntryId"]) || empty($_POST["LineEntryId"])) die();
		$LineItem = new LineItem($_POST["LineEntryId"]);
		if($LineItem->delete()) {
			$this->EncodeAndSendJSON(array("Status" => "Project added to your list!"));
		} else {
			$this->EncodeAndSendJSON(array("Status" => "Error: " . $LineItem->GetDBError()));
		}
	}

	public function GetLineEntry() {
		if(!isset($_POST["LineEntryId"]) || empty($_POST["LineEntryId"])) die();
		$LineItem = new LineItem($_POST["LineEntryId"]);
		$this->EncodeAndSendJSON($LineItem->toArray());
	}

	public function UpdateLineItem() {
		if(!isset($_POST) || empty($_POST)) die();
		$LineItem = new LineItem($_POST["id"]);
		foreach($_POST as $key => $value) {
			$fn = "set$key";
			$LineItem->$fn($value);
		}
		// Need to convert Billable to a boolean otherwise it is always set to Yes.
		$LineItem->setBillable((boolval($_POST["Billable"])));
		if($LineItem->save()) {
			$this->EncodeAndSendJSON(array("Status" => "Line item updated!"));
		} else {
			die('Something went wrong: ' . $LineItem->GetDBError());
		}
	}
}
?>