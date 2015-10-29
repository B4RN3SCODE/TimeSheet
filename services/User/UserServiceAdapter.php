<?php
include_once("services/User/UserServiceAdapterUI.php");
/*
 * user service
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 ***************************************************/
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/
class UserServiceAdapter implements UserServiceAdapterUI {

	private $_dbAdapter;

	public function UserServiceAdapter(DBCon $db) {
		$this->_dbAdapter = $db;
		if(!$this->_dbAdapter->getIsLinked()) {
			$this->_dbAdapter->Link();
		}

	}


	public function getUserData($userid) {
		$userid = $this->_dbAdapter->EscapeQueryStmt($userid);
		$this->_dbAdapter->SStatement(null,"User",array("id"=>$userid),null);
		$this->_dbAdapter->Query();
		return $this->_dbAdapter->GetRow();
	}
}
?>
