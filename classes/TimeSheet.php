<?php

class TimeSheetArray extends ArrayClass {
	protected $db;

	function __construct(){
		parent::__construct("TimeSheet");
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
				$this->_arrObjects[$row["id"]] = new User();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
			}
			return true;
		} else {
			return false;
		}
	}
}

class TimeSheet extends BaseDB {
	protected $_id;
	protected $_UserId;
	protected $_CycleStart;
	protected $_CycleEnd;
	protected $_IsSubmitted;

	protected $columns = array("id", "UserId", "CycleStart", "CycleEnd", "IsSubmitted");
	protected $db;

	public function getId() { return $this->_id; }
	public function getUserId() { return $this->_UserId; }
	public function getCycleStart() { return $this->_CycleStart; }
	public function getCycleEnd() { return $this->_CycleEnd; }
	public function getIsSubmitted() { return $this->_IsSubmitted; }

	public function setId($value) { $this->_id = $value; }
	public function setUserId($value) { $this->_UserId = $value; }
	public function setCycleStart($value) { $this->_CycleStart = $value; }
	public function setCycleEnd($value) { $this->_CycleEnd = $value; }
	public function setIsSubmitted($value) { $this->_IsSubmitted = $value; }


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
		if($this->getUserId() == "") {
			$this->setUserId($_SESSION["User"]->getId());
		}
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
			return ($this->db->GetAffectedRows() > -1);
		return false;
	}

	public function setDB(DBCon $db) {
		$this->db = $db;
	}

	public function CheckSubmitted($CycleStart = null,$CycleEnd = null,$UserId = null) {
		if($CycleStart == null || $CycleEnd == null) return false;
		if($UserId == null) $UserId = $_SESSION["User"]->getId();
		$strSQL = $this->db->SStatement(array(), get_class($this), array("UserId"=>$UserId,"CycleStart"=>$CycleStart,"CycleEnd"=>$CycleEnd));
		$this->db->setQueryStmt($strSQL);
		if ($this->db->Query()) {
			$count = 0;
			while($row = $this->db->getRow())
				$count++;
			return $count > 0;
		} else {
			return false;
		}
	}
}
?>