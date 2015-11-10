<?php

class Customer
{
	protected $_id;
	protected $_ItemList;

	public function GetId() { return $this->_id; }
	public function GetItemList() {
		return isset($this->_ItemList) ? $this->_ItemList : array();
	}

	public function SetId($value) { $this->_id = $value; }
	public function SetItemList($value) { $this->_ItemList = $value; }

	public function AddItem(Item $item) {
		$this->_ItemList[$item->GetId()] = $item;
	}

	public function RemoveItem($id) {
		unset($this->_ItemList[$id]);
	}
}