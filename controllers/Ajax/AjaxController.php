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
}
?>