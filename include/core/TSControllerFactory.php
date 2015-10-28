<?php
include_once("include/core/TSController.php");
/*
 * TSControllerFactory
 * A class to build controllers
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
class TSControllerFactory {

	public static function getController($module) {
		$pth = CONTROLLER_PATH;
		$module = $GLOBALS["APP"]["MODULE_MAP"][$module];

		$newController = "{$pth}{$module}/{$module}Controller.php";
		if(!file_exists($newController)) {
			die("Cant find controller");
		}
		include_once($newController);
		return new $newController();
	}

}
?>
