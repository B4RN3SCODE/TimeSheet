<?php

class UserArray extends ArrayClass {
    protected $db;

    function __construct(){
        parent::__construct("User");
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

class User extends BaseDB {
    protected $_id;             //int(11) NOT NULL AUTO_INCREMENT
    protected $_Email;          //varchar(100) NOT NULL
    protected $_FirstName;      //varchar(30) DEFAULT NULL
    protected $_LastName;       //varchar(30) DEFAULT NULL
    protected $_AccountType;    //int(10) NOT NULL DEFAULT '0'
    protected $_Password;       //varchar(150) DEFAULT NULL
    protected $_DateAdded;      //datetime DEFAULT NULL
    protected $_LastModified;   //datetime DEFAULT NULL
    protected $_Phone;          //varchar(17) DEFAULT NULL
    protected $_Active;         //tinyint(1) NOT NULL DEFAULT '0'
    protected $_Restriction;    //int(10) NOT NULL DEFAULT '0'
    protected $_Online;         //tinyint(1) DEFAULT '0'

    protected $columns = array("id","Email","FirstName","LastName","AccountType","Password",
        "DateAdded","LastModified","Phone","Active","Restriction","Online");
    protected $db;

    public function getId() { return $this->_id; }
    public function getEmail() { return $this->_Email; }
    public function getFirstName() { return $this->_FirstName; }
    public function getLastName() { return $this->_LastName; }
    public function getAccountType() { return $this->_AccountType; }
    public function getPassword() { return $this->_Password; }
    public function getDateAdded() { return $this->_DateAdded; }
    public function getLastModified() { return $this->_LastModified; }
    public function getPhone() { return $this->_Phone; }
    public function getActive() { return $this->_Active; }
    public function getRestriction() { return $this->_Restriction; }
    public function getOnline() { return $this->_Online; }

    private function setId($value) { $this->_id = $value; }
    public function setEmail($value) { $this->_Email = strtolower(trim($value)); }
    public function setFirstName($value) { $this->_FirstName = $value; }
    public function setLastName($value) { $this->_LastName = $value; }
    public function setAccountType($value) { $this->_AccountType = $value; }
    public function setPassword($value) { $this->_Password = $value; }
    public function setDateAdded($value) { $this->_DateAdded = $value; }
    public function setLastModified($value) { $this->_LastModified = $value; }
    public function setPhone($value) { $this->_Phone = $value; }
    public function setActive($value) { $this->_Active = $value; }
    public function setRestriction($value) { $this->_Restriction = $value; }
    public function setOnline($value) { $this->_Online = $value; }

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

    public function LoadByEmail($email = null) {
        if(!$email) return false;
        $strSQL = $this->db->SStatement(array(), get_class($this), array("Email" => $email));
        $this->db->setQueryStmt($strSQL);
        if ($this->db->Query()) {
            $this->setVarsFromRow($this->db->GetRow());
            return true;
        } else {
            return false;
        }
    }

	public function PrepNewUser() {
		$this->setAccountType(0);
		$this->setActive(1);
		$this->setRestriction(0);
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
            return ($this->db->GetAffectedRows() > -1);
        return false;
    }

	public function setDB(DBCon $db) {
		$this->db = $db;
	}
}
?>