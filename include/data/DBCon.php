<?php
/******************************************
 * DBCON
 * Main class for database connections;
 * primarily a MySQL(I) db class
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 ***************************************************/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*
 * Change Log                                                     *
 *                                                                *
 * 10/28/2015 Chris Schaefer: Added UStatement for updating DB    *
 *                                                                *
 *++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*
 * TODO
 * 		+ make a UStatement function to do update functions (follow SSTatement and UStatement function)
 * 		+
 */


class DBCon {

    /**		Properties		**/

    // hostname
    private $HOST;

    // database user to access as
    private $USER;

    // password for the user
    private $PWD;

    // database name
    private $DB;

    //table name
    private $TBL;

    // link reference
    private $LinkRef;

    // query statement
    private $QueryStmt;

    // query result
    private	$QueryRslt;

    // error message
    private $Error;

    // tracks the status for linked reference
    private $IsLinked;


    /**		End Properties		**/


    /************************************
     * Constructor
     ************************************/
    public function DBCon($host = DB_HOST, $user = DB_USER, $password = DB_PASS, $dbname = DB_NAME, $tablename = null, $qstmt = null) {
        $this->HOST = $host;
        $this->USER = $user;
        $this->PWD = $password;
        $this->DB = $dbname;
        $this->TBL = $tablename;
        $this->LinkRef = null;
        $this->QueryStmt = $qstmt;
        $this->QueryRslt = null;
        $this->Error = "";
        $this->IsLinked = false;
    }



    /**************************************
     * Creates a connection reference
     *
     * @return	boolean true for succeess
     *************************************/
    public function Link() {

        // if already linked, return
        if($this->getIsLinked()) return true;

        $this->LinkRef = null;
        $this->Error = "";
        $this->LinkRef = new mysqli("p:".$this->HOST, $this->USER, $this->PWD, $this->DB);

        if($this->LinkRef->connect_errno) {

            $this->LinkRef = null;
            $this->Error = "Could not connect";
            $this->setIsLinked(false);

        } else $this->setIsLinked(true);

        return $this->getIsLinked();
    }



    /********************************
     * Unsets all object propertys &
     * values
     ********************************/
    public function Kill() {

        foreach(get_class_vars("DBCon") as $prop => $val)
            unset($this->$prop);

    }


    /**		ACCESSORS		**/

    // get property values
    public function getHOST() { return $this->HOST; }
    public function getUSER() { return $this->USER; }
    public function getPWD() { return $this->PWD; }
    public function getDB() { return $this->DB; }
    public function getTBL() { return $this->TBL; }
    public function getLinkRef() { return $this->LinkRef; }
    public function getQueryStmt() { return $this->QueryStmt; }
    public function getQueryRslt() { return $this->QueryRslt; }
    public function getError() { return $this->Error; }
    public function getIsLinked() { return $this->IsLinked; }

    // set property values
    public function setTBL($tbl = null) {
        if(!isset($tbl) || strlen($tbl) < 1)
            return false;
        else $this->TBL = $tbl;
    }

    private function setLinkRef($ref = null) {
        $this->LinkRef = $ref;
    }

    public function setQueryStmt($stmt = null) {
        if(!isset($stmt) || strlen($stmt) < 1)
            return false;
        else $this->QueryStmt = $stmt;
    }

    public function setQueryRslt($rslt = null) {
        $this->QueryRslt = $rslt;
    }

    private function setError($err = null) {
        $this->Error = $err;
    }

    private function setIsLinked($bool = false) {
        $this->IsLinked = $bool;
    }



    /**			END ACCESSORS		**/


    /****************************
     * select a databse
     *****************************/
    public function SelectDb($db) {
        if($this->LinkRef->select_db($db))
            return true;

        return false;
    }


    /*********************************
     * Resets the query info
     ********************************/
    public function ResetQueryAndResult() {
        $this->QueryStmt = "";
        $this->QueryRslt = null;
    }

    public function GetAffectedRows() {
        if(!isset($this->LinkRef))
            return false;
        return $this->LinkRef->affected_rows;
    }

    /******************************
     * Fetches all query result
     * data
     *
     * @return	assoc array of data
     *********************************/
    public function GetAll() {
        if(!isset($this->QueryRslt))
            return false;

        $dat = array();
        while($tmp = $this->QueryRslt->fetch_array(MYSQLI_ASSOC)) {
            $dat[] = $tmp;
        }
        if(count($dat) > 0)
            return $dat;

        return array();
    }


    /*************************************
     * Fetches a row of query result data
     *
     * @return an assoc array of data
     *************************************/
    public function GetRow() {
        if($row = $this->QueryRslt->fetch_assoc())
            return $row;
        return false;
    }


    /********************************
     * Executes a query
     *
     * @return boolean true for success
     ***********************************/
    public function Query() {
//      echo "<pre>";
//      debug_print_backtrace();
//      echo "</pre>";
        if($sent = $this->LinkRef->query($this->QueryStmt)) {
            $this->setQueryRslt($sent);
            return true;
        }
        $this->Error = "Query Failure: -- {$this->QueryStmt} --";
        return false;
    }

    /*****************************
     * Gets last inserted Id
     ****************************/
    public function GetLastInsertedId() {
        return $this->LinkRef->insert_id;
    }


    /*******************************
     * Gets Last Error Msg
     *******************************/
    public function GetLastErrorMsg() {
        return $this->LinkRef->error;
    }


    /***************************
     * Escapes the current query
     * String
     ***************************/
    public function EscapeQueryStmt($stmt = "") {
        $sqlStmt = stripslashes($stmt);
        $sqlStmt = $this->LinkRef->real_escape_string($sqlStmt);
        return $sqlStmt;
    }


    /****************************
     * Gets num rows
     *****************************/
    public function NumRows() {
        return $this->QueryRslt->num_rows;
    }


    /***************************************
     * Gets Columns Names of a Table
     ****************************************/
    public function Cols() {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$this->DB}' AND TABLE_NAME='{$this->TBL}'";
        $this->setQueryStmt($sql);
        $this->Query();
        return $this->GetAll();
    }



    /*********************************************************************************************************************
     * SStatement
     * Builds simple select statement
     *
     * @param	select	:	array with
     *							- EMPTY = ALL or *
     *							- Columns to select
     * @param	fromTbl	:	table from which to select
     * @param	where	:	array with
     * 							- first index column value to check
     * 							- second index array with
     * 								0 index is the value being compared the column/value
     * 								1 index uses word for the next comparison (AND, OR), keep
     * 									NULL if no further comparisons desired.
     * @param	limit	:	array with
     * 							- first index row number
     * 							- second index row numbers to limit
     * @return	string full query
     *
     * EXAMPLE:
     * 		select	=	array('Name', 'Age', 'BirthDay')
     * 		fromTbl	=	'StudentCourseList'
     * 		where	=	array(
     * 						'CourseID'	=>	array(45, 'AND'),
     * 						'Gender'	=>	array('Male')
     * 					)
     * 		limit	=	(0, 30)
     * 		Resulting Query: SELECT Name, Age, BirthDay FROM StudentCourseList WHERE CourseID = 45 AND Gender = 'Male' LIMIT 0, 30
     *********************************************************************************************************************/
    public function SStatement($select = array(), $fromTbl = null, $where = array(), $limit = array()) {

        if(!isset($fromTbl) || empty($fromTbl) || is_null($fromTbl))
            return false;


        // build SELECT portion
        $str = "SELECT";

        // if empty select ALL
        if(count($select) == 0)
            $str .= " *";
        else {

            $pos = -1;
            foreach($select as $clmn) {

                $str .= " ${clmn}";
                $pos++;

                if(isset($select[$pos]) && isset($select[$pos + 1]) &&
                    ($pos < (count($select) - 1)))
                    $str .= ",";

            } //end foreach

        } // end else

        // build FROM portion
        $str .= " FROM ${fromTbl}";

        // make sure there is a condition
        if(isset($where) && count($where) > 0) {
            // build WHERE portion
            $str .= " WHERE";
            $pos = -1;
            foreach($where as $key => $value) {
                $pos++;
                if(isset($value)) {
                    if(is_string($value)) { $value = trim($value); }
                    if($pos == 0) {
                        $str .= " $key=";
                    } else {
                        $str .= " AND $key=";
                    }
                    if(gettype($value) == "string") {
                        $str .= "'$value'";
                    } else {
                        $str .= " $value";
                    }
                }

            } //end foreach
//
//            foreach($where as $metaA => $arrDetails) {
//                $str .= " ${metaA} =";
//
//                if(gettype($arrDetails[0]) == "string" && $arrDetails[0] != "?")
//                    $str .= " '${arrDetails[0]}'";
//                else $str .= " ${arrDetails[0]}";
//
//                if(isset($arrDetails[1]) && !is_null($arrDetails[1]) && !empty($arrDetails[1]))
//                    $str .= " ${arrDetails[1]}";
//            }
        } // end IF

        if(isset($limit) && count($limit) == 2)
            $str .= " LIMIT {$limit[0]}, {$limit[1]};";


        $this->QueryStmt = $str;
        return $str;
    }



    /*********************************************************************************************************************
     * IStatement
     * Builds simple insert statement
     *
     * @param	intoTbl	:	table to insert data into
     * @param	valsArr	:	array with
     * 							- values paired following (ColumnName, ValueToInsert)
     *
     * @return	string full query
     *
     * EXAMPLE:
     * 		intoTbl	=	'StudentList'
     * 		valsArr	=	array('FirstName'=> 'Joe', 'Age'=> 15, 'RidesBus'=> true)
     *
     * 		Resulting Query: INSERT INTO StudentList (FirstName, Age, RidesBus) VALUES ('Joe', 15, true)
     *********************************************************************************************************************/
    public function IStatement($intoTbl = null, $valsArr = array()) {

        if(!isset($intoTbl) || empty($intoTbl) || !isset($valsArr) || count($valsArr) < 1)
            return false;

        foreach($valsArr as $key => $value) {
            $valsArr[$key] = $this->LinkRef->real_escape_string($value);
        }

        // begin statement
        $str = "INSERT INTO ${intoTbl}";

        // array for the column names
        $tblColmnLst = array();

        // array for the corresponding values
        $valLst = array();


        // iterate through valsArr and separate to the
        //	appropriate array above
        foreach($valsArr as $TBLCOL => $INVAL) {
            $tblColmnLst[] = $TBLCOL;

            if(isset($INVAL)) {
                $INVAL = trim($INVAL);
                if(gettype($INVAL) == "string") {
                    $valLst[] = "'$INVAL'";
                } else {
                    $valLst[] = "$INVAL";
                }
            }
//            // determine type of data
//            if(gettype($INVAL) == "NULL" || strtoupper($INVAL) == "NULL" || (empty($INVAL) && gettype($INVAL) == "string"))
//                $valLst[] = "NULL";
//            elseif($INVAL == false)
//                $valLst[] = 0;
//            else
//                $valLst[] = (gettype($INVAL) == "string" && $INVAL != "?") ? "'${INVAL}'" : "${INVAL}";
        } //end foreach

        $tmpA = "(" . implode(", ", $tblColmnLst) . ")";
        $tmpB = "(" . implode(", ", $valLst) . ")";
        $str = "${str} ${tmpA} VALUES ${tmpB}";
        $this->QueryStmt = $str;
        return $str;
    }

    /*********************************************************************************************************************
     * UStatement
     * Builds an update statement
     *
     * @param array $update     : array of data to update
     * @param null $Tbl         : table to update data
     * @param array $where      : where array
     * @return bool|null|string
     *
     * EXAMPLE:
     * 		$update     =	array('Email' => 'dn@gmail.com', 'FirstName'=> 'Deez')
     * 		$Tbl        =	'User'
     *      $where      =   array('LastName' => array(0 => 'Nuts'))
     *
     *      $return     =
     * UPDATE User SET Email = 'dn@gmail.com', FirstName = 'Deez' WHERE LastName = 'Nuts'
     *********************************************************************************************************************/
    public function UStatement($update = array(), $Tbl = null, $where = array()) {

        if(!isset($Tbl) || empty($Tbl) || is_null($Tbl))
            return false;

        foreach($update as $key => $value) {
            $update[$key] = $this->LinkRef->real_escape_string($value);
        }
        // build SELECT portion
        $str = "UPDATE {$Tbl} SET";

        // if empty select ALL
        if(count($update) == 0)
            return false;
        else {

            $pos = -1;
            foreach($update as $key => $value) {
                $pos++;
                if(isset($value)) {
                    $value = trim($value);
                    if($pos == 0) {
                        $str .= " $key=";
                    } else {
                        $str .= ", $key=";
                    }
                    if(gettype($value) == "string") {
                        $str .= "'$value'";
                    } else {
                        $str .= " $value";
                    }
                }

            } //end foreach

        } // end else

        // make sure there is a condition
        if(isset($where) && count($where) > 0) {

            // build WHERE portion
            $str .= " WHERE";
            foreach($where as $metaA => $arrDetails) {
                $str .= " ${metaA} =";

                if(gettype($arrDetails[0]) == "string" && $arrDetails[0] != "?")
                    $str .= " '${arrDetails[0]}'";
                else $str .= " ${arrDetails[0]}";

                if(isset($arrDetails[1]) && !is_null($arrDetails[1]) && !empty($arrDetails[1]))
                    $str .= " ${arrDetails[1]}";
            }
        } // end IF

        $this->QueryStmt = "$str;";
        return $this->QueryStmt;
    }


}
?>
