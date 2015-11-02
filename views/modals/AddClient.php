<?php if(isset($TPLDATA["addclient"]) && !empty($TPLDATA["addclient"])) {
	foreach($TPLDATA["addclient"] as $key => $value) {
		$$key = $value;
	}
} else {
	$name = $street = $state = $zip = $contact = $phone = "";
}?>
<div class="modal fade" id="modal-newclient">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add a new client</h4>
			</div>
			<form name="newclient" action="/TimeSheet/Admin/AddClient" method="post"><!--onsubmit="return false;">-->
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Client Name</label>
						<input type="text" class="form-control" name="name" placeholder="Client Name" value="<?php echo $name; ?>"/>
					</div>
					<div class="form-group">
						<label for="street">Street Address</label>
						<input type="text" class="form-control" name="street" placeholder="1345 Monroe Ave" value="<?php echo $street; ?>" />
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label for="state">State</label>
								<input type="text" class="form-control" name="state" placeholder="MI" value="<?php echo $state; ?>"/>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label for="zip">Zip Code</label>
								<input type="number" class="form-control" name="zip" placeholder="49505" value="<?php echo $zip; ?>" />
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label for="country">Country</label>
								<select class="form-control" name="country">
									<option value="225">US</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="contact">Contact Name</label>
								<input type="text" class="form-control" name="contact" placeholder="Scott Palma" value="<?php echo $contact; ?>"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="phone">Phone Number</label>
								<input type="number" class="form-control" name="phone" placeholder="2489829600" value="<?php echo $phone; ?>" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>