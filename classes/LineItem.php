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

	function LoadByProjectId($id) {
		$strSQL = $this->db->SStatement(null, self::getClass(), array("ProjectId"=>$id, "UserId"=>$_SESSION["User"]->getId()) );
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
			return ($this->db->GetAffectedRows() > 0);
		return false;
	}

	public function setDB(DBCon $db) {
		$this->db = $db;
	}
}
?>