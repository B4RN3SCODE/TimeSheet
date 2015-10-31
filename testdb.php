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


$columns = array("id","UserId","ClientId","Title","Description","DateCreated",
    "Rate");
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
