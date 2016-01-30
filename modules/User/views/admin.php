<?php
/*
 * Admin view for user module
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
class admin extends TSView
{
	public function display() {
		$email = (isset($_POST["email"]) && !empty($_POST["email"])) ? $_POST["email"] : "";
		$fname = (isset($_POST["fname"]) && !empty($_POST["fname"])) ? $_POST["fname"] : "";
		$lname = (isset($_POST["lname"]) && !empty($_POST["lname"])) ? $_POST["lname"] : "";
		$User = new User();
		$this->_tplData = array("Email" => $email, "FName" => $fname, "LName" => $lname, "Users" => $User->LoadAllUserNames());
		$this->setOptions(array());
		$this->_viewTpl = "admin";
		$vwData = $this->LoadView();
	}
}