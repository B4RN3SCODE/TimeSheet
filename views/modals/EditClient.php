<div class="modal fade" id="modal-editclient">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Client</h4>
			</div>
			<form name="editclient" action="/TimeSheet/Database/UpdateClient" method="post"><!--onsubmit="return false;">-->
				<input type="hidden" name="id" value="" />
				<div class="modal-body">
					<div class="form-group">
						<label for="Name">Client Name</label>
						<input type="text" class="form-control" name="Name" placeholder="Client Name" value="<?php echo $Name; ?>"/>
					</div>
					<div class="form-group">
						<label for="StreetAddress">Street Address</label>
						<input type="text" class="form-control" name="StreetAddress" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress; ?>" maxlength="100"/>
						<input type="text" class="form-control" name="StreetAddress2" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxl/>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="City">City</label>
								<input type="text" class="form-control" name="City" placeholder="Grand Rapids" value="<?php echo $City; ?>" maxlength="50"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="StateOrProv">State</label>
								<input type="text" class="form-control" name="StateOrProv" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Zip">Zip Code</label>
								<input type="number" class="form-control" name="Zip" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Country">Country</label>
								<select class="form-control" name="Country">
									<?php $Countries = array(35=>"CA",225=>"US");
									foreach($Countries as $key => $value) { ?>
										<option value="<?php echo $key; ?>"<?php if($key == $Country) echo " selected"; ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Contact">Contact Name</label>
								<input type="text" class="form-control" name="Contact" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="Phone">Phone Number</label>
								<input type="text" class="form-control" name="Phone" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/>
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