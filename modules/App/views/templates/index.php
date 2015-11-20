<?php $submitOrder = false; $total = 0; ?>
<div class="col-sm-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Orders</h3>
		</div>
		<div class="panel-body">
			<?php if(count($TPLDATA["ORDERS"]) < 1) { ?>
			<label>No orders active.</label>
			<? } else { ?>
			<div class="list-group">
				<?php foreach($TPLDATA["ORDERS"] as $Order) { ?>
				<div class="list-group-item">
					<?php if($Order->GetStatus() == "Waiting On Delivery") { ?>
					<form action="<?php echo SUBDIR; ?>/App/Index/SetDelivered" method="post">
						<input type="hidden" name="OrderId" value="<?php echo $Order->GetId(); ?>" />
						<span class="glyphicon glyphicon-unchecked pull-right" onclick="$(this).parent().submit();"></span>
					</form>
					<? } else if($Order->GetStatus() == "Cooking") { ?>
						<span class="glyphicon glyphicon-record pull-right"></span>
					<? } else if($Order->GetStatus() == "Delivered") { ?>
						<span class="glyphicon glyphicon-ok-sign pull-right"></span>
					<? } ?>
					<span class="rate pull-right">$<?php echo $Order->GetTotal(); ?></span>
					<label>Table #<?php echo $Order->GetTable() . " - " . $Order->GetStatus(); ?></label>
				</div>
				<? } ?>
			</div>
			<? } ?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Current Order</h3>
		</div>
		<div class="panel-body">
			<?php if(isset($TPLDATA["CURRENT"]) && !empty($TPLDATA["CURRENT"])) {?>
				<div class="list-group" data-order-id="<?php echo $TPLDATA["CURRENT"]->GetId(); ?>">
				<?php foreach($TPLDATA["CURRENT"]->GetCustomerList() as $customer) { ?>
					<div id="Customer<?php echo $customer->GetId();?>" class="list-group-item list-group-item-info">
						<span class="glyphicon glyphicon-plus pull-right text-success">&nbsp;</span>
						<label>Customer #<?php echo $customer->GetId(); ?></label>
					</div>
					<?php foreach($customer->GetItemList() as $item) {
						if(count($item) > 0 && !$submitOrder) $submitOrder = true;
						$total += $item->GetPrice(); ?>
						<div class="list-group-item list-group-item-warning" data-customer-id="<?php echo $customer->GetId();?>" data-item-id="<?php echo $item->GetId();?>">
							<span class="glyphicon glyphicon-info-sign pull-right"></span>
							<span class="glyphicon glyphicon-edit pull-right">&nbsp;</span>
							<span class="glyphicon glyphicon-remove-circle"></span>&nbsp;<label class="item-name"><?php echo $item->GetName() . " <span class=\"price\">[$" . $item->GetPrice() . "]</span>"; if(!empty($item->GetCustom())) echo " - " . $item->GetCustom(); ?></label>
						</div>
					<? } ?>
				<? } ?>
				<a href="/App/Index/AddCustomer"><div class="list-group-item">Add a customer to order.</div></a>
			</div>
			<?php if($submitOrder) { ?>
			<form action="<?php echo SUBDIR; ?>/App/Index/SubmitOrder" method="post">
				<input type="hidden" name="valid" value="true" />
				<button type="submit" class="btn btn-primary btn-block">Submit Order To Kitchen</button>
				<br />
				<h3>Subtotal:&nbsp;<span class="price">$<?php echo $total; ?></span></h3>
			</form>
			<? } ?>
			<? } else { ?>
				<button id="NewOrder" type="button" class="btn btn-primary btn-block">Start New Order</button>
			<? } ?>
		</div>
	</div>
</div>
<?php include_once "views/modals/Menu.php";
include_once "views/modals/RemoveItem.php";
include_once "views/modals/NewOrder.php";
include_once "views/modals/CustomOrder.php";
include_once "views/modals/ItemInfo.php"; ?>