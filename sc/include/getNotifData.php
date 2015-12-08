<?php
include("config.php");
include("glob.php");
include("DBCon.php");

/************************************************************
 * getNotifData
 * Gets event, notification, page data
 *
 * EXPECTS:
 *  - license (string license number)
 *  - page (string page uri to verify against page/event)
 *
 * @author			Tyler J Barnes
 * @contact			b4rn3scode@gmail.com
 * @version			0.0.0.0.1
 * @doc				TBD
 *************************************************************/

/*
 * TODO
 * 		add a check that verifies the license number to the
 * 		registered domain for the account....
 */

// request origin -- url components for validation
$_ORIGIN_ = array();
if(isset($_SERVER["HTTP_ORIGIN"]) && validUrl($_SERVER["HTTP_ORIGIN"])) {
	$_ORIGIN_ = getDomain($_SERVER["HTTP_ORIGIN"]);
} elseif(isset($_SERVER["HTTP_HOST"]) && validUrl($_SERVER["HTTP_HOST"])) {
	$_ORIGIN_ = getDomain($_SERVER["HTTP_HOST"]);
} elseif(isset($_SERVER["HTTP_REFERER"]) && validUrl($_SERVER["HTTP_REFERER"])) {
	$_ORIGIN_ = getDomain($_SERVER["HTTP_REFERER"]);
}
die($_ORIGIN_);
// license number
$_LICENSE_ = (isset($_REQUEST["license"]) && !empty($_REQUEST["license"]) && strlen($_REQUEST["license"]) > 0) ? $_REQUEST["license"] : STR_EMP;
// page uri
$_PAGE_ = (isset($_REQUEST["page"]) && !empty($_REQUEST["page"]) && strlen($_REQUEST["page"]) > 0) ? $_REQUEST["page"] : STR_EMP;

if(empty($_LICENSE_) || $_LICENSE_ == STR_EMP) {
	end_proc("Bad License");
}

if(empty($_PAGE_) || $_PAGE_ == STR_EMP) {
	end_proc("Bad Page");
}

// database object
$db = new DBCon();
if(!$db->Link()) {
	end_proc("Failed to connect to database");
}


// return data
$_DATA_ = array();
// event ids
$tmp_eids = array();

$tmp_page_event_data = getPageEventData($db, $_LICENSE_, $_PAGE_);
$has_data = false;

foreach($tmp_page_event_data as $idx => $tmp_data) {

	$has_data = true; // theres at least one record

	$tmp_eids[] = $tmp_data["EID"];
	unset($tmp_data);

}


// no need to continue if there isnt data
if(!$has_data) {
	end_proc("No Data");
}

// actions
$tmp_actions = getEventActions($db, $tmp_eids);
// make sure theres at least on action
if(count($tmp_actions) < 1 || !isset($tmp_actions[0]["EAction"])) {
	end_proc("No Actions Set Up For Event");
}

$tmp_notifications = getNotifications($db, $_LICENSE_, $tmp_eids);
$tmp_nids = array();

// clean up unused stuff
unset($tmp_eids, $has_data);

// check for notifs
$has_notifications = false;
// store the ids temporarily
foreach($tmp_notifications as $idx => $tmp_data) {

	$has_notifications = true;

	$tmp_nids[] = $tmp_data["NID"];
	unset($tmp_data);

}

$tmp_links = getNotificationLinks($db, $_LICENSE_, $tmp_nids);

if($has_notifications) {
	$_DATA_ = array(
		"page_event"	=>	$tmp_page_event_data,
		"actions"		=>	$tmp_actions,
		"notifications"	=>	$tmp_notifications,
		"links"			=>	$tmp_links,
	);
}

// clean up unused shit
unset($tmp_page_event_data, $tmp_actions, $tmp_notifications, $tmp_links, $has_notifications, $tmp_nids);

header("Content-Type: application/json");

// echo the results
echo json_encode($_DATA_, JSON_NUMERIC_CHECK);
// bye bye
exit;



//////////////////////////////////////////////////////////////
/////////////// functions ////////////////////////////////////
//////////////////////////////////////////////////////////////


function validLicense(DBCon $db, $lic, $dom) {

	$lic = $db->EscapeQueryStmt($lic);
	$dom = $db->EscapeQueryStmt($dom);

	$db->setQueryStmt("SELECT COUNT(*) AS tot FROM Account WHERE Domain = '{$dom}' AND License = '{$lic}'");
	$db->Query();
	$isValid = $db->GetRow();
	return (intval($isValid["tot"]) > 0);
}

/*
 * getThemeSkin
 * gets the page event data
 *
 * @param db (DBCon) Database object used to query
 * @param lic (string) the license number
 * @param pg (string) the page
 * @return array of theme data
 */
function getPageEventData(DBCon $db, $lic = "", $pg = "") {

	$lic = $db->EscapeQueryStmt($lic);
	$pg = $db->EscapeQueryStmt($pg);

	$sql = "SELECT
	e.Id AS EID, et.Type AS EType, e.SubjectAttr AS EIdentifier, e.SubjectVal AS EAttrVal,
	p.Uri AS PageUri, 'false' as HasTriggered
		FROM Event AS e
		INNER JOIN EventType AS et
		ON e.EventTypeId = et.Id
		INNER JOIN PageEvent AS pe
		ON e.Id = pe.EventId
		INNER JOIN Page AS p
		ON pe.PageId = p.Id
		INNER JOIN Account AS a
		ON e.AccId = a.Id
		WHERE e.Active = 1 AND e.Del <> 1 AND et.Del <> 1 AND p.Active = 1 AND p.Del <> 1 AND a.Active = 1 AND a.Del <> 1 AND p.Uri = '{$pg}' AND a.License = '{$lic}'";

	$db->setQueryStmt($sql);
	if(!$db->Query()) {
		// TODO HANDLE ERROR
		return array();
	}

	return $db->GetAll();
}


/*
 * getElmAttributes
 * Gets the event actions
 *
 * @param db (DBCon) database obj to use
 * @param eIds (array) list of event record ids
 * @return array of the attributes
 */
function getEventActions(DBCon $db, array $eIds = array("0")) {
	$str = implode(",",$eIds);

	$sql = "SELECT a.Name AS EAction, ea.EventId AS EID FROM Action AS a INNER JOIN EventAction AS ea ON a.Id = ea.ActionId WHERE a.Del <> 1 AND ea.EventId IN ({$str});";
	$db->setQueryStmt($sql);
	$db->Query();
	return $db->GetAll();
}



/*
 * getNotifications
 * Gets notifications
 *
 * @param db (DBCon) database obj to use
 * @param lic (string) the license number
 * @param eIds array of event ids
 * @return array of notifications
 */
function getNotifications(DBCon $db, $lic = "", array $eIds = array("0")) {

	$lic = $db->EscapeQueryStmt($lic);
	$str = implode(",", $eIds);

	$sql = "SELECT n.Id AS NID, n.Title AS NTitle, n.Media AS NMedia, n.Body AS NBody, e.Id AS EID, 'false' AS HasSeen
		FROM Notification AS n
		INNER JOIN EventNotification AS en
		ON n.Id = en.NotificationId
		INNER JOIN Event AS e
		ON en.EventId = e.Id
		INNER JOIN Account AS a
		ON e.AccId = a.Id
		WHERE n.Active = 1 AND n.Del <> 1 AND e.Active = 1 AND e.Del <> 1 AND a.Active = 1 AND a.Del <> 1 AND a.License = '{$lic}' AND e.Id IN ({$str})";

	$db->setQueryStmt($sql);
	if(!$db->Query()) {
		// TODO something
		return array();
	}
	return $db->GetAll();
}



/*
 * getNotificationLinks
 * Gets links for notifications
 *
 * @param db (DBCon) database obj to use
 * @param lic (string) the license number
 * @param nids array of notification ids
 * @return array of links
 */
function getNotificationLinks(DBCon $db, $lic = "", array $nids = array("0")) {

	$lic = $db->EscapeQueryStmt($lic);
	$str = implode(",", $nids);

	$sql = "SELECT l.Uri AS LinkUri, nl.NotificationId AS NID FROM Link AS l INNER JOIN Account AS a ON l.AccId = a.Id INNER JOIN NotificationLink AS nl ON l.Id = nl.LinkId WHERE a.Active = 1 AND a.Del <> 1 AND l.Active = 1 AND l.Del <> 1 AND a.License = '{$lic}' AND nl.NotificationId IN ({$str});";

	$db->setQueryStmt($sql);
	if(!$db->Query()) {
		// TODO something
		return array();
	}
	return $db->GetAll();
}



/*
 * validUrl
 * checks that param is valid url
 *
 * @param str: url
 * @return true if valid
 */
function validUrl($str = STR_EMP) {
	$str = trim(preg_replace("~http\:\/\/|https\:\/\/|www\.~", "", $str));
	return preg_match("~[-a-zA-Z0-9\:\%\.\_\+\~\#\=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9\:\%\_\+\.\~\#\?\&\/\/\=]*)~", $str);
}


/*
 * getDomain
 * gets the domain
 *
 * @param url to get domain from
 * @return string domain
 */
function getDomain($url = STR_EMP) {
	preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($url, PHP_URL_HOST), $_domain_tld);
	return $_domain_tld[0];
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
