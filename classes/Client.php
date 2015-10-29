<?php
include_once "include/app/config.php";
include_once "classes/BaseDB.php";
include_once "classes/ArrayClass.php";

class ClientArray extends ArrayClass {
    protected $db;

    function __construct(){
        parent::__construct("Client");
        if(!isset($GLOBALS["App"]["DBAdapter"])) {
            include_once "include/data/DBCon.php";
            $GLOBALS["App"]["DBAdapter"] = new DBCon();
            $GLOBALS["App"]["DBAdapter"]->Link();
        }
        $this->db = $GLOBALS["App"]["DBAdapter"];
        $this->db->setTBL(self::getClass());
    }

    function load() {
        $strSQL = $this->db->SStatement(array(), self::getClass());
        $this->db->SetQueryStmt($strSQL);
        if($this->db->Query()) {
            foreach ($this->db->GetAll() as $row) {
                $this->_arrObjects[$row["id"]] = new Client();
                $this->_arrObjects[$row["id"]]->setVarsFromRow($row);
            }
            return true;
        } else {
            return false;
        }
    }
}

class Client extends BaseDB {
    protected $_id;              //INT
    protected $_Name;            //VARCHAR(50)
    protected $_Country;         //INT
    protected $_StateOrProv;     //VARCHAR(100)
    protected $_Zip;             //VARCHAR(8)
    protected $_Priority;        //INT
    protected $_Phone;           //VARCHAR(17)
    protected $_Contact;         //VARCHAR(60)
    protected $_StreetAddress;   //VARCHAR(100)
    protected $columns = array("id","Name","Country","StateOrProv","Zip",
        "Priority","Phone","Contact","StreetAddress");
    private $db;

    public function getId() { return $this->_id; }
    public function getName() { return $this->_Name; }
    public function getCountry() { return $this->_Country; }
    public function getStateOrProv() { return $this->_StateOrProv; }
    public function getZip() { return $this->_Zip; }
    public function getPriority() { return $this->_Priority; }
    public function getPhone() { return $this->_Phone; }
    public function getContact() { return $this->_Contact; }
    public function getStreetAddress() { return $this->_StreetAddress; }

    private function setId($value) { $this->_id = $value; }
    public function setName($value) { $this->_Name = $value; }
    public function setCountry($value) { $this->_Country = $value; }
    public function setStateOrProv($value) { $this->_StateOrProv = $value; }
    public function setZip($value) { $this->_Zip = $value; }
    public function setPriority($value) { $this->_Priority = $value; }
    public function setPhone($value) { $this->_Phone = $value; }
    public function setContact($value) { $this->_Contact = $value; }
    public function setStreetAddress($value) { $this->_StreetAddress = $value; }

    public function __construct($id=null) {
        if(!isset($GLOBALS["App"]["DBAdapter"])) {
            include_once "include/data/DBCon.php";
            $GLOBALS["App"]["DBAdapter"] = new DBCon();
            $GLOBALS["App"]["DBAdapter"]->Link();
        }
        $this->db = $GLOBALS["App"]["DBAdapter"];
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
}
?>