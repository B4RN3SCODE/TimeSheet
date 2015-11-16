<?php
/*
 * UserController
 * Controller for the user module
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 ***************************************************/
/*+++++++++++++++++++++++++++++++++++++++++++++++++*
 * 				Change Log
 *
 *+++++++++++++++++++++++++++++++++++++++++++++++++*/
class AppController extends TSController {

	protected $Orders;
	protected $Current;
	protected $Menu = array(
		"Food" => array(
			"Pizza" => array("Cheese Pizza"=>6.5,"Pepperoni Pizza"=>9,"Vegetarian Pizza"=>8,"Bleu Cheese & Walnut Pizza"=>9,"Italian Pizza"=>9,"Meat Lover Pizza"=>10,"Pinapple Pizza"=>9),
			"Soup" => array("Tomato Soup"=>4,"Chicken Noodle Soup"=>4,"Vegetable Soup"=>4,"Miso Soup"=>4),
			"Salad" => array("Chef Salad"=>4,"Caesar Salad"=>4,"Fruit Salad"=>4)
		),
		"Drink" => array(
			"Alcohol"=>array("Bud Light"=>4,"Stella Artois"=>5,"Bell's Two Hearted"=>6,"Labatt's Blue"=>4,"Labatt's Blue Light"=>4),
			"Soda"=>array("Coca-Cola"=>1,"Diet Coke"=>1,"Sprite"=>1,"Root Beer"=>1),
			"Other"=>array("Hot Cocoa"=>2,"Iced Tea"=>2,"Green Tea"=>2,"Coffee"=>2)
		),
		"Dessert" => array(
			"Chocolate Cake" => 8, "Fudge Brownie" => 8, "Fondu Fountain" => 15, "Ice Cream" => 6, "Cheesecake" => 7
		)
	);

	public function __construct() {
		if(isset($_SESSION["User"])) {
			$this->User = $_SESSION["User"];
		}
		if(isset($_SESSION["APP"]["ORDERS"])) {
			$this->Orders = $_SESSION["APP"]["ORDERS"];
		} else {
			$this->Orders = array();
		}
		if(isset($_SESSION["APP"]["CURRENT"])) {
			$this->Current = $_SESSION["APP"]["CURRENT"];
		} else {
			$this->Current = array();
		}
	}

	public function index() {
		$_SESSION["APP"]["ORDERS"] = $this->Orders;
		$_SESSION["APP"]["CURRENT"] = $this->Current;
		$_SESSION["APP"]["MENU"] = $this->Menu;
		$this->_viewProcessor->_viewTpl = "index";
		$this->_viewProcessor->_tplData = $_SESSION["APP"];
		$this->_viewProcessor->display();
	}

	public function AddCustomer() {
		$Customer = new Customer();
		$Customer->SetId(count($this->Current->GetCustomerList()) + 1);
		$this->Current->AddCustomer($Customer);
	}

	public function AddItems() {
		$OrderId = $_POST["OrderId"];
		$CustomerId = $_POST["CustomerId"];
		foreach($this->Current->GetCustomerList() as $Customer) {
			if ($Customer->GetId() == $CustomerId) {
				for ($index = 0; $index < count($_POST["item"]); $index++) {
					$Item = new Item();
					$Item->SetId(count($Customer->GetItemList()) + 1);
					$Item->SetName($_POST["item"][$index]);
					$Item->SetPrice($_POST["price"][$index]);
					$Customer->AddItem($Item);
				}
				break;
			}
		}
	}
	public function CustomOrder() {
		foreach($_POST as $key => $value) $$key = $value;
		foreach($this->Current->GetCustomerList() as $Customer) {
			if ($Customer->GetId() == $CustomerId) {
				foreach($Customer->GetItemList() as $Item) {
					if($Item->GetId() == $ItemId) {
						$Item->SetCustom($customized);
					}
				}
			}
		}
	}
	public function NewOrder() {
		$Order = new Order();
		$Order->SetId(time());
		if(isset($_POST["table"]) && !empty($_POST["table"])) {
			$Order->SetTable($_POST["table"]);
		}
		if(isset($_POST["customers"]) && !empty($_POST["customers"])) {
			$count = $_POST["customers"];
		} else {
			$count = 1;
		}
		if($_POST["customers"] < 1) {
			$GLOBALS["APP"]["MSG"]["ERROR"][] = "How can you have negative customers?";
			return $this->index();
		}
		for($index = 0; $index < $count; $index++) {
			$Customer = new Customer();
			$Customer->SetId($index + 1);
			$Order->AddCustomer($Customer);
		}
		$this->Current = $Order;
	}

	public function RemoveItem() {
		foreach($this->Current->GetCustomerList() as $Customer) {
			if($Customer->GetId() == $_POST["CustomerId"]) {
				$Customer->RemoveItem($_POST["ItemId"]);
			}
		}
	}

	public function SetDelivered() {
		if(isset($_POST["OrderId"]) && !empty($_POST["OrderId"])) {
			$this->Orders[$_POST["OrderId"]]->SetStatus("Delivered");
		}
	}

	public function SubmitOrder() {
		if(isset($_POST["valid"]) && $_POST["valid"] == "true") {
			$Total = 0;
			foreach($this->Current->GetCustomerList() as $Customer) {
				foreach($Customer->GetItemList() as $Item) {
					$Total += $Item->GetPrice();
				}
			}
			$this->Current->SetTotal($Total);
			$this->Current->SetStatus("Cooking");
			foreach($this->Orders as $Order) {
				if($Order->GetStatus() == "Cooking") {
					$Order->SetStatus("Waiting On Delivery");
				} else if($Order->GetStatus() == "Delivered") {
					unset($this->Orders[$Order->GetId()]);
				}
			}
			$this->Orders[$this->Current->GetId()] = $this->Current;
			$this->Current = array();
		}
	}
}
?>
