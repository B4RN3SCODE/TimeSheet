<div class="modal fade" id="modal-editclient">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update Client</h4>
			</div>
			<form name="editclient" action="/TimeSheet/Admin/UpdateClient" method="post"><!--onsubmit="return false;">-->
				<input type="hidden" name="id" value="" />
				<div class="modal-body">
					<div class="form-group">
						<label for="Name">Client Name</label>
						<input type="text" class="form-control" name="Name" placeholder="Client Name" value="<?php echo $name; ?>"/>
					</div>
					<div class="form-group">
						<label for="StreetAddress">Street Address</label>
						<input type="text" class="form-control" name="StreetAddress" placeholder="1345 Monroe Ave" value="<?php echo $street; ?>" />
					</div>
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label for="StateOrProv">State</label>
								<input type="text" class="form-control" name="StateOrProv" placeholder="MI" value="<?php echo $state; ?>"/>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label for="Zip">Zip Code</label>
								<input type="number" class="form-control" name="Zip" placeholder="49505" value="<?php echo $zip; ?>" />
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label for="Country">Country</label>
								<select class="form-control" name="Country">
									<option value="225">US</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Contact">Contact Name</label>
								<input type="text" class="form-control" name="Contact" placeholder="Scott Palma" value="<?php echo $contact; ?>"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Phone">Phone Number</label>
								<input type="number" class="form-control" name="Phone" placeholder="2489829600" value="<?php echo $phone; ?>" />
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