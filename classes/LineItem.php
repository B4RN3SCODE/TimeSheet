<?php

class LineItemArray extends ArrayClass {
	protected $db;

	function __construct(){
		parent::__construct("LineItem");
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
				$this->_arrObjects[$row["id"]] = new ProjectItem();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
			}
			return true;
		} else {
			return false;
		}
	}

	function LoadLineItems($id, $CycleStart = null, $CycleEnd = null) {
		$CycleStart = ($CycleStart == null) ? $_SESSION["CurrentBillingPeriod"]["StartDate"] : $CycleStart;
		$CycleEnd = ($CycleEnd == null) ? $_SESSION["CurrentBillingPeriod"]["EndDate"] : $CycleEnd;
		$strSQL = $this->db->SStatement(null, self::getClass(), array("ProjectId"=>$id, "UserId"=>$_SESSION["User"]->getId()) );
		$strSQL .= " AND EntryDate BETWEEN '$CycleStart' AND '$CycleEnd'";
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			foreach ($this->db->GetAll() as $row) {
				$this->_arrObjects[$row["id"]] = new LineItem();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
				$this->_arrObjects[$row["id"]] = $this->_arrObjects[$row["id"]]->toArray();
			}
			return $this->_arrObjects;
		} else {
			return false;
		}
	}

	function LoadLineItemTotals(TimeSheetPeriod $TimeSheetPeriod, $UserId = null) {
		if(!isset($TimeSheetPeriod)) return false;
		$UserId = ($UserId == null) ? $_SESSION["User"]->getId() : $UserId;
		$TimeSheetPeriodId = $TimeSheetPeriod->getId();
		$strSQL = "SELECT CycleStart, CycleEnd, Processed, Billable, Total, Submitted, id AS PeriodId FROM
			(SELECT SUM(Hours) AS Billable, TP.*, TS.*,
				(CASE WHEN COUNT(TS.PeriodId) = 0 THEN FALSE ELSE TRUE END) AS Submitted
			 FROM TimeSheetPeriod TP LEFT OUTER JOIN
				TimeSheet.LineItem LI ON  LI.EntryDate BETWEEN TP.CycleStart AND TP.CycleEnd LEFT OUTER JOIN
				User U ON LI.UserId = U.id LEFT OUTER JOIN
				TimeSheetSubmit TS ON TS.UserId = U.id AND TS.PeriodId = TP.id
				WHERE U.id = $UserId AND TP.id = $TimeSheetPeriodId AND LI.Billable = TRUE) AS BILL,
			(SELECT UserId, SUM(Hours) AS Total
			 FROM TimeSheetPeriod TP LEFT OUTER JOIN
				 TimeSheet.LineItem LI ON  LI.EntryDate BETWEEN TP.CycleStart AND TP.CycleEnd LEFT OUTER JOIN
				 User U ON LI.UserId = U.id
			 WHERE U.id = $UserId AND TP.id = $TimeSheetPeriodId) AS TOTL";
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			foreach ($this->db->GetAll() as $row) {
				return $row;
			}
			return true;
		} else {
			return false;
		}
	}

	function LoadTotalHours($CycleStart, $CycleEnd, $UserId = null) {
		if($UserId == null) $UserId = $_SESSION["User"]->getId();
		if($CycleStart == null || $CycleEnd == null) return false;
		$strSQL = "SELECT
				User.id,
				(CASE WHEN BLI.Billable IS NULL THEN 0 ELSE BLI.Billable END) AS Billable,
				(CASE WHEN TLI.Total IS NULL THEN 0 ELSE TLI.Total END) AS Total,
				(CASE WHEN SUB.Submitted IS NULL THEN FALSE ELSE (CASE WHEN SUB.Submitted = '1B' THEN TRUE ELSE FALSE END) END) AS Submitted,
				(CASE WHEN SUB.Processed IS NULL THEN FALSE ELSE (CASE WHEN SUB.Processed = '1B' THEN TRUE ELSE FALSE END) END) AS Processed
			FROM
				(SELECT UserId, SUM(Hours) AS Billable
					FROM TimeSheet.LineItem
					WHERE UserId = '$UserId' AND Billable = TRUE AND EntryDate BETWEEN '$CycleStart' AND '$CycleEnd') AS BLI,
  			(SELECT SUM(Hours) AS Total
					FROM TimeSheet.LineItem
					WHERE UserId = '$UserId' AND EntryDate BETWEEN '$CycleStart' AND '$CycleEnd') AS TLI,
    		User
    			LEFT OUTER JOIN (SELECT UserId, Submitted, Processed
        		FROM TimeSheet.TimeSheet
        		WHERE CycleStart = '$CycleStart' AND CycleEnd = '$CycleEnd') AS SUB ON User.id = SUB.UserId
  		WHERE User.id = '$UserId'";
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			$retArr = array();
			foreach ($this->db->GetAll() as $row) {
				return $row;
			}
			return $retArr;
		} else {
			return false;
		}
	}
}

class LineItem extends BaseDB {
	protected $_id;
	protected $_UserId;
	protected $_ClientId;
	protected $_ProjectId;
	protected $_Description;
	protected $_EntryDate;
	protected $_Hours;
	protected $_Travel;
	protected $_Billable;
	protected $columns = array("id", "UserId", "ClientId", "ProjectId", "Description", "EntryDate", "Hours", "Travel", "Billable");
	protected $db;

	public function getId() { return $this->_id; }
	public function getUserId() { return $this->_UserId; }
	public function getClientId() { return $this->_ClientId; }
	public function getProjectId() { return $this->_ProjectId; }
	public function getDescription() { return $this->_Description; }
	public function getEntryDate() { return strtotime(str_replace('-', '/', $this->_EntryDate)) ;}
	public function getHours() { return $this->_Hours; }
	public function getTravel() { return $this->_Travel; }
	public function getBillable() { return $this->_Billable; }

	public function setId($value) { $this->_id = $value; }
	public function setUserId($value) { $this->_UserId = $value; }
	public function setClientId($value) { $this->_ClientId = $value; }
	public function setProjectId($value) { $this->_ProjectId = $value; }
	public function setDescription($value) { $this->_Description = $value; }
	public function setEntryDate($value) { if($value != "") { $this->_EntryDate = date('Y-m-d', strtotime(str_replace('-', '/', $value))); }}
	public function setHours($value) { $this->_Hours = floatval($value); }
	public function setTravel($value) { $this->_Travel = floatval($value); }
	public function setBillable($value) { $this->_Billable = $value; }

	public function __construct($id=null) {
		$this->db = $GLOBALS["APP"]["INSTANCE"]->_dbAdapter;
		$this->db->setTBL(get_class($this));
		if($id) {
			$this->load($id);
		}
	}

	public function delete() {
		if($this->_UserId != $_SESSION["User"]->getId()) return false;
		if($this->_id) {
			$strSQL = "DELETE FROM " . DB_NAME . "." . get_class($this) . "
				WHERE id = $this->_id";
			$this->db->setQueryStmt($strSQL);
			return $this->db->Query();
		}
	}

	private function insert() {
		$strSQL = $this->db->IStatement(get_class($this),self::prepare_data());
		$this->db->setQueryStmt($strSQL);
		if($this->db->Query()) {
			$this->_id = $this->db->GetLastInsertedId();
			return $this->_id;
		} else {
			return false;
		}
	}

	public function load($id)
	{
		if (!$id) return false;
		$strSQL = $this->db->SStatement(array(), get_class($this), array("id" => strval($id)));
		$this->db->setQueryStmt($strSQL);
		if ($this->db->Query()) {
			$this->setVarsFromRow($this->db->getRow());
			return true;
		} else {
			return false;
		}
	}

	public function save() {
		if($this->_UserId != $_SESSION["User"]->getId()) return false;
		if(trim($this->_Description) == "" || empty($this->_EntryDate) || !is_numeric($this->_Hours)) return false;
		if($this->_id) {
			return self::update();
		} else {
			return self::insert();
		}
	}

	private function update() {
		$strSQL = $this->db->UStatement(self::prepare_data(),get_class($this),array("id" => array(0 => $this->getId())));
		$this->db->setQueryStmt($strSQL);
		if($this->db->Query())
			return true; //($this->db->GetAffectedRows() > 0);
		return false;
	}

	public function setDB(DBCon $db) {
		$this->db = $db;
	}
}
?>