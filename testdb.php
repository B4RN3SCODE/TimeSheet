<?php
include_once("include/config.php");
include_once("include/DBCon.php");
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT * FROM Country");
if(!$db->Query()) {
	echo $db->GetLastErrorMsg();
	exit;
}
var_dump($db->GetAll());
exit;
?>
