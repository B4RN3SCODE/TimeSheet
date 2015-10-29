<?php
include_once("include/app/config.php");
include_once("include/data/DBCon.php");
$db=new DBCon();
$db->Link();
$db->setQueryStmt("SELECT * FROM User");
if(!$db->Query()) {
	echo $db->GetLastErrorMsg();
	exit;
}
echo "<pre>";
print_r($db->GetAll());
echo "</pre>";
exit;
?>
