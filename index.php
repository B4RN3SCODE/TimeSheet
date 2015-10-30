<?php
/* FOR DEBUG PURPOSES... comment out when ready */
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
ini_set("log_errors", 1);
ini_set("ignore_repeated_errors", 0);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
/* END DEBUG SHIT */

/**********************************
 * only entry point for application
 *********************************/
include_once("include/app/initialize.php");
$app = new TSApp(array(),0,false);
$app->SessionActivate();
$app->Boot();

?>
