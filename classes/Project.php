<?php

class ProjectArray extends ArrayClass {
    protected $db;

    function __construct(){
        parent::__construct("Project");
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

    function LoadByClientId($id) {
        $strSQL = $this->db->SStatement(array("id","Title","Rate"), self::getClass(), array("ClientId"=>$id) );
        $this->db->SetQueryStmt($strSQL);
        if($this->db->Query()) {
            $retArray = array();
            foreach ($this->db->GetAll() as $row) {
                $retArray[$row["id"]] = array("Name" => $row["Title"], "Rate" => $row["Rate"]);
            }
            return $retArray;
        } else {
            return false;
        }
    }
}

class Project extends BaseDB {
    protected $_id;
    protected $_UserId;
    protected $_ClientId;
    protected $_Title;
    protected $_Description;
    protected $_DateCreated;
    protected $_Rate;
    protected $columns = array("id","Email","FirstName","LastName","AccountType","Password",
        "DateAdded","LastModified","Phone","Active","Restriction","Online");
    protected $db;

    public function getId() { return $this->_id; }
    public function getUserId() { return $this->_UserId; }
    public function getClientId() { return $this->_ClientId; }
    public function getTitle() { return $this->_Title; }
    public function getDescription() { return $this->_Description; }
    public function getDateCreated() { return $this->_DateCreated; }
    public function getRate() { return $this->_Rate; }

    public function setId($value) { $this->_id = $value; }
    public function setUserId($value) { $this->_UserId = $value; }
    public function setClientId($value) { $this->_ClientId = $value; }
    public function setTitle($value) { $this->_Title = $value; }
    public function setDescription($value) { $this->_Description = $value; }
    public function setDateCreated($value) { $this->_DateCreated = $value; }
    public function setRate($value) { $this->_Rate = $value; }

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

    public function LoadByTitle($Title = null) {
        if(!$Title) return false;
        $strSQL = $this->db->SStatement(array(), get_class($this), array("Title" => array(0 => $Title)));
        $this->db->setQueryStmt($strSQL);
        if ($this->db->Query()) {
            $this->setVarsFromRow($this->db->GetRow());
            return true;
        } else {
            return false;
        }
    }

    public function save() {
        $this->setLastModified(base::now());
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