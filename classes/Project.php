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

    /**
     * Returns an array of client information [id, name, rate]
     * @param $id
     * @return array|bool
     */
    function LoadProjectsByClientId($id) {
        $strSQL = $this->db->SStatement(array("id","Title","Rate"), self::getClass(), array("ClientId"=>$id, "Active"=>"1") );
        $this->db->SetQueryStmt($strSQL);
        if($this->db->Query()) {
            $retArray = array();
            foreach ($this->db->GetAll() as $row) {
                $retArray[$row["id"]] = array("Name" => $row["Title"], "Rate" => $row["Rate"]);
            }
            uasort($retArray,array("ProjectArray","CompareByTitle"));
            return $retArray;
        } else {
            return false;
        }
    }

    function LoadActiveProjects() {
        $startDate = date_sub(new DateTime($_SESSION["CurrentBillingPeriod"]["StartDate"]),new DateInterval("P2W"))->format("Y-m-d");
        $endDate = $_SESSION["CurrentBillingPeriod"]["EndDate"];
        $strSQL = "SELECT Project.Title, COUNT(Project.Title) AS Count
                    FROM LineItem
                      INNER JOIN Project ON LineItem.ProjectId = Project.id
                        AND LineItem.UserId = '2'
                    WHERE EntryDate BETWEEN '$startDate' AND '$endDate'
                    ORDER BY Count
                    LIMIT 10;";
        $this->db->SetQueryStmt($strSQL);
        if($this->db->Query()) {
            $retArray = array();
            foreach ($this->db->GetAll() as $row)
                $retArray[] = $row;
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
    protected $_Active;
    protected $_InternalReference;
    protected $_CustomerReference;
    protected $columns = array("id","UserId","ClientId","Title","Description","DateCreated","Rate", "Active", "InternalReference", "CustomerReference");
    protected $db;

    public function getId() { return $this->_id; }
    public function getUserId() { return $this->_UserId; }
    public function getClientId() { return $this->_ClientId; }
    public function getTitle() { return $this->_Title; }
    public function getDescription() { return $this->_Description; }
    public function getDateCreated() { return $this->_DateCreated; }
    public function getRate() { return $this->_Rate; }
    public function getActive() { return $this->_Active; }
    public function getInternalReference() { return $this->_InternalReference; }
    public function getCustomerReference() { return $this->_CustomerReference; }

    public function setId($value) { $this->_id = $value; }
    public function setUserId($value) { $this->_UserId = $value; }
    public function setClientId($value) { $this->_ClientId = $value; }
    public function setTitle($value) { $this->_Title = $value; }
    public function setDescription($value) { $this->_Description = $value; }
    public function setDateCreated($value) { $this->_DateCreated = $value; }
    public function setRate($value) { $this->_Rate = $value; }
    public function setActive($value) { $this->_Active = $value; }
    public function setInternalReference($value) { $this->_InternalReference = $value; }
    public function setCustomerReference($value) { $this->_CustomerReference = $value; }

    public function __construct($id=null) {
        $this->db = $GLOBALS["APP"]["INSTANCE"]->_dbAdapter;
        $this->db->setTBL(get_class($this));
        $this->_Description = "General description of project.";
        if($id) {
            $this->load($id);
        } else {
            $this->_Active = true;
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
        if($this->_id) {
            return self::update();
        } else {
            $this->setDateCreated(base::now());
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