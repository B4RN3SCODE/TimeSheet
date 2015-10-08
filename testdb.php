<?php
var_dump(function_exists("mysqli_query"));
include_once("include/config.php");
include_once("include/DBCon.php");
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT * FROM Country");
$db->Query();
var_dump($db->GetAll());
exit;
?>
