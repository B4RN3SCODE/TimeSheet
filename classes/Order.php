<?php

class Order
{
	protected $_id;
	protected $_Table;
	// In-Progress, Ready, Delivered
	protected $_Status;
	//Array of Customers
	protected $_CustomerList;
	protected $_Total;

	public function GetId() { return $this->_id; }
	public function GetTable() { return $this->_Table; }
	public function GetStatus() { return $this->_Status; }
	public function GetCustomerList() { return $this->_CustomerList; }
	public function GetTotal() { return $this->_Total; }

	public function SetId($value) { $this->_id = $value; }
	public function SetTable($value) { $this->_Table = $value; }
	public function SetStatus($value) { $this->_Status = $value; }
	public function SetCustomerList($value) { $this->_CustomerList = $value; }
	public function SetTotal($value) { $this->_Total = $value; }

	public function AddCustomer(Customer $Customer) {
		$this->_CustomerList[$Customer->GetId()] = $Customer;
	}

	public function RemoveCustomer($id) {
		unset($this->_CustomerList[$id]);
	}
}