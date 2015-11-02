<?php

class ProjectItemArray extends ArrayClass {
	protected $db;

	function __construct(){
		parent::__construct("ProjectItem");
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
		$strSQL = $this->db->SStatement(null, self::getClass(), array("ProjectId"=>$id) );
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			$retArray = array();
			foreach ($this->db->GetAll() as $row) {
				$this->_arrObjects[$row["id"]] = new ProjectItem();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
			}
			return $retArray;
		} else {
			return false;
		}
	}
}

class ProjectItem extends BaseDB {
	protected $_id;
	protected $_ProjectId;
	protected $_UserId;
	protected $_Description;
	protected $_Hours;
	protected $_Billable;
	protected $_TimeStamp;
	protected $columns = array("id", "ProjectId", "UserId", "Description","Hours","Billable", "TimeStamp");
	protected $db;

	public function getId() { return $this->_id; }
	public function getProjectId() { return $this->_ProjectId; }
	public function getUserId() { return $this->_UserId; }
	public function getDescription() { return $this->_Description; }
	public function getHours() { return $this->_Hours; }
	public function getBillable() { return $this->_Billable; }
	public function getTimeStamp() { return $this->_TimeStamp; }

	public function setId($value) { $this->_id = $value; }
	public function setProjectId($value) { $this->_ProjectId = $value; }
	public function setUserId($value) { $this->_UserId = $value; }
	public function setDescription($value) { $this->_Description = $value; }
	public function setHours($value) { $this->_Hours = $value; }
	public function setBillable($value) { $this->_Billable = $value; }
	public function setTimeStamp($value) { $this->_TimeStamp = $value; }

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
		if($this->_id) {
			return self::update();
		} else {
			$this->setDateAdded(base::now());
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