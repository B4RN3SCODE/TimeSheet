<?php
include_once("include/config.php");
include_once("include/DBCon.php");
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT * FROM Country");
$db->Query();
var_dump($db);
exit;
?>
