<?php
//include_once("include/app/config.php");
//include_once("include/data/DBCon.php");
//$db=new DBCon();
//$db->Link();
//$db->setQueryStmt($db->SStatement(array("id","Title","Rate"), "Project", array("ClientId"=>2, "Active"=>"1") ));
////$db->setQueryStmt("SELECT * FROM User");
//if(!$db->Query()) {
//	echo $db->GetLastErrorMsg();
//	exit;
//}
//echo "<pre>";
//print_r($db->GetAll());
//echo "</pre>";
//exit;


$columns = array("id", "CycleStart", "CycleEnd");
foreach($columns as $column) {
    echo "protected \$_$column;<br />";
}
echo "<br />";
foreach($columns as $column) {
    echo "public function get";
    echo ucwords($column);
    echo "() { return \$this->_$column; }<br />";
}
echo "<br />";
foreach($columns as $column) {
    echo "public function set";
    echo ucwords($column);
    echo "(\$value) { \$this->_$column = \$value; }<br />";
}
?>
