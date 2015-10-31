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
		$this->_tplData = array("Email" => $email);
		$this->setOptions(array());
		$this->_viewTpl = "admin";
		$vwData = $this->LoadView();
	}
}