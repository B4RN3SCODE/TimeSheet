<?php
include("config.php");
include("glob.php");
include("DBCon.php");

/************************************************************
 * SnakeCharmer AJAX / API handler
 * Right now this is very basic shit so I can get a widget
 * rendered correctly and go from there...
 *
 * This script will eventually be broken into 2 parts
 *  - getting themes and notification elements to render
 *  - getting event, page, notification data to execute
 *
 * Right now, both processes will be included here for
 * development.
 *
 *
 * EXPECTS:
 *
 *
 * @author			Tyler J Barnes
 * @contact			b4rn3scode@gmail.com
 * @version			0.0.0.0.1
 * @doc				TBD
 *************************************************************/

$db = new DBCon();
$db->Link();

echo "<html><body><pre><code>";
var_dump(getElmAttributes($db,array("1","2")));
echo "</code></pre></body></html>";

/*********		GETTING THEME DATA (SKIN STUFF)		*****************/
function getThemeSkin(DBCon $db, $lic = "", $thm = 0) {
	if(empty($lic) || strlen($lic) < 1) {
		echo "BAD LICENSE";
		exit;
	}
	if($thm < 1) {
		echo "BAD THEME ID";
		exit;
	}
	$sql = "SELECT
	ne.Id AS ElmRecordId, ne.Name AS ElmName, ne.ElmId, ne.Height AS ElmH, ne.Width AS ElmW, ne.Style AS ElmStyle, ne.DisplayOrder AS ElmDO, ne.InnerHtml AS ElmInnerHtml, ne.DisplayNotifCount AS ElmShowCount,
	ns.ThemeId AS ThemeId,
	net.Type AS ElmType, net.HtmlTag AS ElmTag, net.CloseTag AS ElmUseCloseTag,
	a.Id AS AccountId
FROM NotificationElm AS ne

	INNER JOIN NotificationSet AS ns
		ON ne.Id = ns.NotificationElmId

	INNER JOIN NotificationElmType AS net
		ON ne.TypeId = net.Id


	INNER JOIN Account AS a
		ON ne.AccId = a.Id


	INNER JOIN Theme AS t
		ON a.Id = t.AccId

WHERE ns.ThemeId = {$thm} AND a.License = '{$lic}'";

	$db->setQueryStmt($sql);
	$db->Query();
	return $db->GetAll();
}
function getElmAttributes(DBCon $db, array $elmIds = array("0")) {
	$str = implode(",",$elmIds);

	$sql = "SELECT
	nea.NotificationElmId AS ElmRecordId, nea.Attribute AS ElmAttribute, nea.Value AS ElmAttributeValue
FROM NotificationElmAttribute AS nea
WHERE nea.NotificationElmId IN ({$str});";

	$db->setQueryStmt($sql);
	$db->Query();
	return $db->GetAll();
}
/*********		END GETTING THEME DATA (SKIN STUFF)		*****************/


/*********		GETTING THE DATA		*****************/


/*********		END GETTING THE DATA		*****************/

?>
