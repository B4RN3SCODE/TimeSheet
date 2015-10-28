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
class index extends TSView {
	public function display() {
		include_once("views/header.php");
		include_once("modules/User/views/login.php");
		include_once("views/footer.php");
	}
}
?>
