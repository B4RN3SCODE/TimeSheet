<?php
class BaseDB {

    public function __get($key)
    {
        if ($key == "columns" && !isset($$key))
            throw new Exception("Child class " . get_called_class() . " failed to define static $key property. Please define the property $key as a string array of all columns in the " . get_called_class() . " table.");
        return $$key;
    }

    /**
     * prepare_data() returns an array formatted
     * for DBCon's insert and update functions
     * @return array
     */
    protected function prepare_data() {
        $retData = array();
        foreach($this->columns as $column) {
            $var = "_$column";
            $retData[$column] = $this->$var;
        }
        return $retData;
    }

    /**
     * Sets a classes variables from an associative
     * row fetched from mysql.
     * @param $arrRow
     */
    protected function setVarsFromRow($arrRow) {
        foreach($this->columns as $column) {
            if(isset($arrRow[$column])) {
                $var = "_$column";
                $this->$var = $arrRow[$column];
            }
        }
    }

    /**
     * Returns an array of the pertinent data
     * @return array
     */
    public function toArray() {
        return $this->prepare_data();
    }

    public function GetDBError() {
        if(isset($this->db)) {
            return $this->db->GetLastErrorMsg();
        } else {
            return "No DB Connection";
        }
    }
}
?>