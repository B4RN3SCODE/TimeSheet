<?php

class ArrayClass extends BaseDB {

    protected $_strClass;
    protected $_arrObjects = array();
    protected $_intFoundRows;

    function __construct($strClass) {
        $this->_strClass = $strClass;
    }

    function getClass() {
        return $this->_strClass;
    }

    function getArray(){
        return $this->_arrObjects;
    }
    function setArray($arrObjects) {
        $this->_arrObjects = $arrObjects;
    }

    function getObject($intID, $blnCreate=false) {
        if(isset($this->_arrObjects[$intID])) {
            return $this->_arrObjects[$intID];
        } elseif($blnCreate) {
            return $this->_arrObjects[$intID] = new $this->_strClass();
        }
        return null;
    }
    function setObject($intID, $objObject) {
        $this->_arrObjects[$intID] = $objObject;
    }
    function removeObject($intID) {
        if(isset($this->_arrObjects[$intID])){
            unset($this->_arrObjects[$intID]);
        }
    }
    function objectIsSet($intID){
        return isset($this->_arrObjects[$intID])?$this->_arrObjects[$intID]:false;
    }
    // TODO: Could probably make a getObjectsByField function too, where it doesn't just grab the FIRST object found
    function getObjectByField($strFieldFunction, $strValue) {
        if($this->getArray()) {
            foreach($this->getArray() as $objObject) {
                if($objObject->$strFieldFunction() == $strValue) {
                    return $objObject;
                }
            }
        }
    }

    function addNew($objObject) {
        $this->_arrObjects[] = $objObject;
    }
    function createNew($intID=null) {
        $strClass = $this->_strClass;
        if($intID || $intID === 0 || $intID === "0")
            return $this->_arrObjects[$intID] = new $strClass();
        else
            return $this->_arrObjects[] = new $strClass();
    }

    function addFromRow($arrRow, $strIndexColumn=null, $strType=null) {
        $objObject = new $this->_strClass();
        $objObject->setVarsFromRow($arrRow, $strType);
        if($strIndexColumn && $arrRow[$strIndexColumn]) {
            $this->setObject($arrRow[$strIndexColumn], $objObject);
        } else {
            $this->addNew($objObject);
        }
        return $objObject;
    }

    function clear(){
        $this->_arrObjects = array();
    }

    function save($blnSaveChildren=false) {
        if($this->_arrObjects) {
            foreach($this->_arrObjects as $objObject) {
                $objObject->save($blnSaveChildren);
            }
        }
    }
    function delete() {
        if($this->_arrObjects) {
            foreach($this->_arrObjects as $objObject) {
                $objObject->delete();
            }
        }
    }

    function validate() {
        if($this->getArray()) {
            foreach($this->getArray() as $objObject) {
                $objObject->validate();
            }
        }
    }

    function toJSON(){
        if(!$this->getArray())
            return;

        $arrObjects = array();
        foreach($this->getArray() as $objObject) {
            $arrObjects[] = $objObject->toJSON();
        }
        return $arrObjects;
    }

    function toDDJSON(){
        $arrReturn = array();
        if(!$this->getArray())
            return toJSON($arrReturn);

        foreach($this->getArray() as $objObject) {
            $arrReturn[$objObject->getID()] = $objObject->getName();
        }
        return toJSON($arrReturn);
    }

    function getFoundRows(){
        return $this->_intFoundRows;
    }
    function setFoundRows($value){
        $this->_intFoundRows = $value;
    }

    function aggregrate($strFunction, $strFieldFunction){
        if($this->getArray()) {
            foreach($this->getArray() as $objObject) {
                $arrFields[] = $objObject->$strFieldFunction();
            }
        }
        return $strFunction($arrFields);
    }

    function setAllFields($strSetFieldFunction, $strValue) {
        if(!$this->getArray())
            return;

        foreach($this->getArray() as $strKey => $objObject) {
            if(method_exists($objObject, $strSetFieldFunction)) {
                $objObject->$strSetFieldFunction($strValue);
            }
        }
    }

    function getAllFields($strGetFieldFunction) {
        $arrArray = array();
        if(!$this->getArray())
            return $arrArray;

        foreach($this->getArray() as $objObject) {
            $arrArray[] = $objObject->$strGetFieldFunction();
        }
        return $arrArray;
    }

    static function CompareByName(Client $a,Client $b)
    {
        return strcmp(strtolower($a->GetName()), strtolower($b->GetName()));
    }

    static function CompareByTitle(Array $a, Array $b)
    {
        return strcmp(strtolower($a["Name"]), strtolower($b["Name"]));
    }

    static function CompareClientsWithProjects(Array $a, Array $b) {
        return strcmp(strtolower($a["Name"]), strtolower($b["Name"]));
    }
}


?>