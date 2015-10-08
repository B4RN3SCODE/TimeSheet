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
include_once("include/TSApp.php");
$app = new TSApp();
$app->Boot();


/* this code will go somewhere else.... the index is only an entry point to boot the app
include_once "include/functions.php";


if(isset($_REQUEST["module"]) and !empty($_REQUEST["module"])) {
  $module = $_REQUEST["module"];
} else {
  $module = "timesheet";
}

if(isset($_REQUEST["view"]) and !empty($_REQUEST["view"])) {
  $view = $_REQUEST["view"];
} else {
  $view = "home";
}

$modules = array();
foreach (new DirectoryIterator("modules") as $fileinfo) {
  if ($fileinfo->isDir() && !$fileinfo->isDot()) {
    $modules[$fileinfo->getFilename()] = $fileinfo->getFilename();
    if(!file_exists("modules/$module/views/$view.php")) {
      if (file_exists("modules/" . $fileinfo->getFilename() . "/views/$view.php")) {
        $module = $fileinfo->getFilename();
      }
    }
  }
}

include_once "modules/header.php";
include_once "modules/$module/views/$view.php";
include_once "modules/footer.php";
*/


?>
