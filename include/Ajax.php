<?php
/*
 * Base Ajax.php file
 *
 * will be used as the target for all jQuery Scripts
 */
if(!isset($_SESSION['module']) || empty($_SESSION['module']))
	exit;

$f = "../Modules/{$_SESSION['module']}/Include/Ajax.php";
if(file_exists($f)) {
	include_once($f);
} else
	die("-1:Unknown Path Or Script");

?>
