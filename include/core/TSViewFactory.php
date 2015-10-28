<?php
include_once("include/core/TSView.php");
/*
 * TSViewFactory
 * A class to build views and determine if
 * the view object should include action files
 * by passing the action to the view object...
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
class TSViewFactory {

	public static function getView($module, $view) {
		$module = $GLOBALS["APP"]["MODULE_MAP"][$module];
		$vw_pth = "modules/{$module}/views/{$view}.php";

		if(!file_exists($vw_pth)) {
			die("Cant find view: {$vw_pth}");
		}
		include_once($vw_pth);
		return new $view();
	}
}
?>

