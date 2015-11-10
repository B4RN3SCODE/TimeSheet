<?php

class Item
{
	protected $_id;
	protected $_Name;
	protected $_Price;
	protected $_Custom;

	public function GetId() { return $this->_id; }
	public function GetName() { return $this->_Name; }
	public function GetPrice() { return $this->_Price; }
	public function GetCustom() { return $this->_Custom; }

	public function SetId($value) { $this->_id = $value; }
	public function SetName($value) { $this->_Name = $value; }
	public function SetPrice($value) { $this->_Price = $value; }
	public function SetCustom($value) { $this->_Custom = $value; }
}