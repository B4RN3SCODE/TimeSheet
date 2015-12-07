<?php
include("config.php");
include("glob.php");
include("DBCon.php");

/************************************************************
 * getTheme
 * Gets theme data
 *
 * EXPECTS:
 *  - license (string license number)
 *  - theme (integer theme id to render)
 *
 * @author			Tyler J Barnes
 * @contact			b4rn3scode@gmail.com
 * @version			0.0.0.0.1 (not even tested yet)
 * @doc				TBD
 *************************************************************/
/*
 * TODO
 * 		add a check that verifies the license number to the
 * 		registered domain for the account....
 */


// theme id
$_THEME_ = (isset($_REQUEST["theme"]) && is_numeric($_REQUEST["theme"])) ? $_REQUEST["theme"] : 0;
// license number
$_LICENSE_ = (isset($_REQUEST["license"]) && !empty($_REQUEST["license"]) && strlen($_REQUEST["license"]) > 0) ? $_REQUEST["license"] : STR_EMP;

if($_THEME_ < 1) {
	end_proc("Bad Theme Id");
}

if(empty($_LICENSE_) || $_LICENSE_ == STR_EMP) {
	end_proc("Bad License");
}

// database object
$db = new DBCon();
if(!$db->Link()) {
	end_proc("Failed to connect to database");
}

// skin data (theme to load)
$_SKIN_ = array();

// elm ids
$elm_ids = array();

// get the skin data
$tmp_skin = getThemeSkin($db, $_LICENSE_, $_THEME_);

foreach($tmp_skin as $idx => $elm_data) {
	$elm_ids[] = (int)$elm_data["ElmRecordId"];
	unset($elm_data);
}


// get attributes
$tmp_attr = getElmAttributes($db, $elm_ids);

$_SKIN_ = array(
	"elements"	=>	$tmp_skin,
	"attributes"	=>	$tmp_attr,
);

// clean up
unset($tmp_attr, $tmp_skin, $elm_ids);

// echo the results
echo json_encode($_SKIN_, JSON_NUMERIC_CHECK);
// bye bye
exit;

//////////////////////////////////////////////////////////////
/////////////// functions ////////////////////////////////////
//////////////////////////////////////////////////////////////


/*
 * getThemeSkin
 * Gets the skin for all elements set up to render
 * for the given theme
 *
 * @param db (DBCon) Database object used to query
 * @param lic (string) the license number
 * @param thm (int) the theme id to query for
 * @return array of theme data
 */
function getThemeSkin(DBCon $db, $lic = "", $thm = 0) {

	$lic = $db->EscapeQueryStmt($lic);
	$thm = $db->EscapeQueryStmt($thm);

	$sql = "SELECT ne.Id AS ElmRecordId, ne.Name AS ElmName, ne.ElmId, ne.Height AS ElmH, ne.Width AS ElmW, ne.Style AS ElmStyle, ne.DisplayOrder AS ElmDO, ne.InnerHtml AS ElmInnerHtml, ne.DisplayNotifCount AS ElmShowCount,
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
			WHERE ns.ThemeId = {$thm} AND a.License = '{$lic}'
			ORDER BY ne.DisplayOrder;";

	$db->setQueryStmt($sql);
	if(!$db->Query()) {
		// TODO HANDLE ERROR
		return array();
	}

	return $db->GetAll();
}


/*
 * getElmAttributes
 * Gets the attributes for all the elements required for the theme
 *
 * @param db (DBCon) database obj to use
 * @param elmIds (array) list of element record ids
 * @return array of the attributes
 */
function getElmAttributes(DBCon $db, array $elmIds = array("0")) {
	$str = implode(",",$elmIds);

	$sql = "SELECT nea.NotificationElmId AS ElmRecordId, nea.Attribute AS ElmAttribute, nea.Value AS ElmAttributeValue FROM NotificationElmAttribute AS nea WHERE nea.NotificationElmId IN ({$str});";

	$db->setQueryStmt($sql);
	$db->Query();
	return $db->GetAll();
}

/*
 * end_proc
 * ends the process with a message for the user
 * used on failure
 *
 * @param msg (string) message to echo
 * @return void
 */
function end_proc($msg) {
	echo $msg;
	exit;
}


?>
