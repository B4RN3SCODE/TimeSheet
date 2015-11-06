<?php

class TimeSheetSubmitArray extends ArrayClass {
	protected $db;

	function __construct(){
		parent::__construct("TimeSheetSubmit");
		if(!isset($GLOBALS["APP"]["INSTANCE"])) {
			$GLOBALS["APP"]["INSTANCE"]->_dbAdapter = new DBCon();
			$GLOBALS["APP"]["INSTANCE"]->_dbAdapter->Link();
		}
		$this->db = $GLOBALS["APP"]["INSTANCE"]->_dbAdapter;
		$this->db->setTBL(self::getClass()); // ArrayClass function
	}

	function load() {
		$strSQL = $this->db->SStatement(array(), self::getClass());
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			foreach ($this->db->GetAll() as $row) {
				$this->_arrObjects[$row["id"]] = new TimeSheetPeriod();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
			}
			return true;
		} else {
			return false;
		}
	}
}

class TimeSheetSubmit extends BaseDB {

	protected $_UserId;
	protected $_PeriodId;

	public function getUserId() { return $this->_UserId; }
	public function getPeriodId() { return $this->_PeriodId; }

	public function setUserId($value) { $this->_UserId = $value; }
	public function setPeriodId($value) { $this->_PeriodId = $value; }

	protected $columns = array("UserId", "PeriodId");
	protected $db;


	public function __construct() {
		$this->db = new DBCon();
		$this->db->Link();
		$this->db->setTBL(get_class($this));
	}

	public function delete() {
		if($this->_id) {
			$strSQL = "DELETE FROM " . DB_NAME . "." . get_class($this) . "
				WHERE UserId = $this->_UserId AND PeriodId = $this->_PeriodId";
			$this->db->setQueryStmt($strSQL);
			return $this->db->Query();
		}
	}

	private function insert() {
		$strSQL = $this->db->IStatement(get_class($this),self::prepare_data());
		$this->db->setQueryStmt($strSQL);
		if($this->db->Query()) {
			return true;
		} else {
			return false;
		}
	}

	public function save() {
		return self::insert();
	}

	public function setDB(DBCon $db) {
		$this->db = $db;
	}

	static function Submitted($UserId, $CycleStart, $CycleEnd) {
		if(!isset($UserId) || !isset($CycleStart) || !isset($CycleEnd)) return false;
		$strSQL = "SELECT * FROM TimeSheetSubmit s INNER JOIN
				TimeSheetPeriod p ON s.PeriodId = p.id
			WHERE p.CycleStart = '$CycleStart' AND p.CycleEnd = '$CycleEnd' AND s.UserId = $UserId;";
		$db = $GLOBALS["APP"]["INSTANCE"]->_dbAdapter;
		$db->setQueryStmt($strSQL);
		if($db->Query()) {
			foreach ($db->GetAll() as $row) {
				return true;
			}
			return false;
		} else {
			return false;
		}
	}

}
?>