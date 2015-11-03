<?php

class UserProjectsArray extends ArrayClass {
	protected $db;

	function __construct(){
		parent::__construct("UserProjects");
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
				$this->_arrObjects[$row["id"]] = new Project();
				$this->_arrObjects[$row["id"]]->setVarsFromRow($row);
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns an array of projects for a given user
	 * @param $id
	 * @return array|bool
	 */
	function LoadByUserId($id) {
		$strSQL = $this->db->SStatement(array("ProjectId"), self::getClass(), array("UserId"=>$id) );
		$this->db->SetQueryStmt($strSQL);
		if($this->db->Query()) {
			$retArray = array();
			foreach ($this->db->GetAll() as $row) {
				$Project = new Project($row["projectId"]);
				$retArray[$Project->getClientId()][] = $row["projectId"];
			}
			return $retArray;
		} else {
			return false;
		}
	}
}

class UserProjects extends BaseDB {
//	protected $_id;
	protected $_UserId;
	protected $_ProjectId;
	protected $columns = array("UserId","ProjectId");
	protected $db;

//	public function getId() { return $this->_id; }
	public function getUserId() { return $this->_UserId; }
	public function getProjectId() { return $this->_ProjectId; }

//	public function setId($value) { $this->_id = $value; }
	public function setUserId($value) { $this->_UserId = $value; }
	public function setProjectId($value) { $this->_ProjectId = $value; }

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

//	public function load($id)
//	{
//		if (!$id) return false;
//		$strSQL = $this->db->SStatement(array(), get_class($this), array("id" => strval($id)));
//		$this->db->setQueryStmt($strSQL);
//		if ($this->db->Query()) {
//			$this->setVarsFromRow($this->db->getRow());
//			return true;
//		} else {
//			return false;
//		}
//	}

	public function save() {
//		if($this->_ProjectId) {
//			return self::update();
//		} else {
			return self::insert();
//		}
	}

//	private function update() {
//		$strSQL = $this->db->UStatement(self::prepare_data(),get_class($this),array("id" => array(0 => $this->getId())));
//		$this->db->setQueryStmt($strSQL);
//		if($this->db->Query())
//			return ($this->db->GetAffectedRows() > -1);
//		return false;
//	}

	public function setDB(DBCon $db) {
		$this->db = $db;
	}
}
?>