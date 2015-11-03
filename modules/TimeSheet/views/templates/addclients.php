<?php $Name = $Contact = $Phone = $StreetAddress = $StreetAddress2 = $StateOrProv = $Zip = ""; $Country = 225; ?>
<form name="newclient" action="/TimeSheet/Admin/AddClient" method="post"><!--onsubmit="return false;">-->
	<input type="hidden" name="id" value="" />
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="Name">Client Name</label>
				<input type="text" class="form-control" name="Name[]" placeholder="Client Name" value="<?php echo $Name; ?>" maxlength="50"/>
			</div>
			<div class="form-group">
				<label for="StreetAddress">Street Address</label>
				<input type="text" class="form-control" name="StreetAddress[]" placeholder="Attn: John Smith" value="<?php echo $StreetAddress; ?>" maxlength="100"/>
				<input type="text" class="form-control" name="StreetAddress2[]" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxlength="100"/>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="StateOrProv">State</label>
						<input type="text" class="form-control" name="StateOrProv[]" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Zip">Zip Code</label>
						<input type="number" class="form-control" name="Zip[]" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Country">Country</label>
						<select class="form-control" name="Country[]">
							<?php $Countries = array(35=>"CA",225=>"US");
							foreach($Countries as $key => $value) { ?>
								<option value="<?php echo $key; ?>"<?php if($key == $Country) echo " selected"; ?>><?php echo $value; ?></option>
							<? } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Contact">Contact Name</label>
						<input type="text" class="form-control" name="Contact[]" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Phone">Phone Number</label>
						<input type="text" class="form-control" name="Phone[]" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="Name">Client Name</label>
				<input type="text" class="form-control" name="Name[]" placeholder="Client Name" value="<?php echo $Name; ?>" maxlength="50"/>
			</div>
			<div class="form-group">
				<label for="StreetAddress">Street Address</label>
				<input type="text" class="form-control" name="StreetAddress[]" placeholder="Attn: John Smith" value="<?php echo $StreetAddress; ?>" maxlength="100"/>
				<input type="text" class="form-control" name="StreetAddress2[]" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxlength="100"/>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="StateOrProv">State</label>
						<input type="text" class="form-control" name="StateOrProv[]" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Zip">Zip Code</label>
						<input type="number" class="form-control" name="Zip[]" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Country">Country</label>
						<select class="form-control" name="Country[]">
							<?php $Countries = array(35=>"CA",225=>"US");
							foreach($Countries as $key => $value) { ?>
								<option value="<?php echo $key; ?>"<?php if($key == $Country) echo " selected"; ?>><?php echo $value; ?></option>
							<? } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Contact">Contact Name</label>
						<input type="text" class="form-control" name="Contact[]" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Phone">Phone Number</label>
						<input type="text" class="form-control" name="Phone[]" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row"><hr style="border-color: #002a80;"/></div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="Name">Client Name</label>
				<input type="text" class="form-control" name="Name[]" placeholder="Client Name" value="<?php echo $Name; ?>" maxlength="50"/>
			</div>
			<div class="form-group">
				<label for="StreetAddress">Street Address</label>
				<input type="text" class="form-control" name="StreetAddress[]" placeholder="Attn: John Smith" value="<?php echo $StreetAddress; ?>" maxlength="100"/>
				<input type="text" class="form-control" name="StreetAddress2[]" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxlength="100"/>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="StateOrProv">State</label>
						<input type="text" class="form-control" name="StateOrProv[]" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Zip">Zip Code</label>
						<input type="number" class="form-control" name="Zip[]" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Country">Country</label>
						<select class="form-control" name="Country[]">
							<?php $Countries = array(35=>"CA",225=>"US");
							foreach($Countries as $key => $value) { ?>
								<option value="<?php echo $key; ?>"<?php if($key == $Country) echo " selected"; ?>><?php echo $value; ?></option>
							<? } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Contact">Contact Name</label>
						<input type="text" class="form-control" name="Contact[]" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Phone">Phone Number</label>
						<input type="text" class="form-control" name="Phone[]" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="Name">Client Name</label>
				<input type="text" class="form-control" name="Name[]" placeholder="Client Name" value="<?php echo $Name; ?>" maxlength="50"/>
			</div>
			<div class="form-group">
				<label for="StreetAddress">Street Address</label>
				<input type="text" class="form-control" name="StreetAddress[]" placeholder="Attn: John Smith" value="<?php echo $StreetAddress; ?>" maxlength="100"/>
				<input type="text" class="form-control" name="StreetAddress2[]" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxlength="100"/>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="StateOrProv">State</label>
						<input type="text" class="form-control" name="StateOrProv[]" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Zip">Zip Code</label>
						<input type="number" class="form-control" name="Zip[]" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="Country">Country</label>
						<select class="form-control" name="Country[]">
							<?php $Countries = array(35=>"CA",225=>"US");
							foreach($Countries as $key => $value) { ?>
								<option value="<?php echo $key; ?>"<?php if($key == $Country) echo " selected"; ?>><?php echo $value; ?></option>
							<? } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Contact">Contact Name</label>
						<input type="text" class="form-control" name="Contact[]" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="Phone">Phone Number</label>
						<input type="text" class="form-control" name="Phone[]" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row"><hr style="border-color: #002a80;"/></div>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<button type="submit" class="btn btn-block btn-secondary">Add Clients</button>
		</div>
	</div>
</form>