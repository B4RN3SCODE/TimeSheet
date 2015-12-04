<?php
include("config.php");
include("glob.php");
include("DBCon.php");


$db = new DBCon();
$db->Link();

$db->setQueryStmt("SELECT * FROM Action");
$db->Query();

echo "<html><body><pre><code>";
var_dump($db->GetAll());
echo "</code></pre></body></html>";
?>
