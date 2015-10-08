<?php
include_once("include/config.php");
include_once("include/DBCon.php");
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT 1");
$db->Query();
var_dump($db->GetAll());
exit;
?>
