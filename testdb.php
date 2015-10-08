<?php
include('include/DBCon.php');
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT * FROM Country");
$db->Query();
var_dump($db->GetAll());
exit;
?>
