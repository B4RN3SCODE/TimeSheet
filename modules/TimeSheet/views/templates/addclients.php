<?php
die();
$clients = array('ACG Corporate Disbursements',
'Agile Technology Architects, LLC',
'Al-Par Peat Co',
'American Home Fitness',
'American Seating',
'Behler-Young Company',
'Braxton-Reed, Inc',
'Center Manufacturing',
'Cole\'s Quality Foods, Inc.',
'Commercial Appraisal Services, LLC',
'Corvac Composites, LLC',
'Coveris - Battle Creek',
'Credentials, Inc.',
'Dave Miedema',
'EPI Printers, Inc.',
'ES Financial',
'Family Christian Stores',
'Five Star Real Estate',
'Flex & Gate Seeburn',
'Flex N Gate -  Warren',
'Flex N Gate -Urbana',
'Franken i Technologies',
'FRS, Inc.',
'G R Housing Commission',
'Grand Rapids Association of Realtors',
'Grand Rapids Label Company',
'GRASP',
'H & L Advantage',
'Hadley Products Corp',
'Hadley Transit',
'Hastings Manufacturing, Co.',
'Henry A. Fox Sales',
'Hines Corporation',
'Hitachi Cable America Inc',
'Hope Health',
'Hougen Manufacturing, Inc.',
'Howard Miller Clock',
'Humphrey Products, Inc.',
'IBM Corporation MN',
'iIn The Cloud LLC',
'Integrated Distribution, Inc.',
'iTech Solutions Group, LLC',
'J M Wilson Corp',
'JB Poindexter & Co.',
'Johnston Boiler',
'Kolene Corp',
'Mahle Engine Components USA',
'MarkSys',
'Master Finish Company',
'MedData',
'Meddirect LLC',
'Michigan Blood',
'Michigan Wheel Corp',
'National Land Agency, Jamaica',
'Nova Wildcat Amerock, LLC',
'Novitex',
'Nu-Wool Inc',
'Ottawa County Central Dispatch',
'Ottawa County MIS',
'Packaging Corp Of America',
'Per-fit Company',
'Precision Metal Products',
'PRIME Research',
'Quality Edge',
'Richmond Reformed Church',
'Rietberg',
'Sidney State Bank',
'Signworks',
'Statewide Windows',
'Suspa Incorporated',
'Teamsters Union Local 406',
'Topcraft Metal Products Inc',
'Trelleborg Automotive USA, Inc.',
'Ventra - Evert LLC',
'Ventra - Salem',
'Ventra Plastics - Spain',
'West Michigan Rheumatology',
'WL Molding Company',
'Wolverine World Wide Inc');
$cities = array(
'Dearborn',
'New Berlin',
'Elsie',
'Sterling Hts',
'Grand Rapids',
'Grand Rapids',
'Mt.Prospect',
'Byron Center',
'Grand Rapids',
'Grand Rapids',
'Kentwood',
'Battle Creek',
'Northfield',
'Grandville',
'Battle Creek',
'Grand Rapids',
'Grand Rapids',
'Grand Rapids',
'Tottenham',
'Warren',
'Urbana',
'Middleville',
'North Charleston',
'Grand Rapids',
'Grand Rapids',
'Grand Rapids',
'Grand Rapids',
'Grandville',
'Grandville',
'Elkhart',
'Hastings',
'Grand Rapids',
'Spring Lake',
'Pensacola',
'Kalamazoo',
'Swartz Creek',
'Zeeland',
'Kalamazoo',
'Rochester',
'Middleville',
'Comstock Park',
'Danbury',
'Portage',
'Houston',
'Ferrysburg',
'Detroit',
'Muskegon',
'Grand Rapids',
'Grand Rapids',
'Brecksville',
'Grand Rapids',
'Grand Rapids',
'Grand Rapids',
'West Indies',
'Mooresville',
'Grand Rapids',
'Jenison',
'West Olive',
'West Olive',
'Filer City',
'Grand Rapids',
'Holland',
'Ann Arbor',
'Walker',
'Grand Rapids',
'Grandville',
'Sidney MI',
'Grand Rapids',
'Elkhart',
'Grand Rapids',
'Grand Rapids',
'Hudsonville',
'South Haven',
'Evert',
'Salem',
'Kitchener',
'Grand Rapids',
'Portage',
'Portland'
);
for($index = 0; $index < count($clients); $index++) {
	$client = $clients[$index];
	$Client = new Client();
	$Client->LoadByName($client);
	$Client->setCity($cities[$index]);
	if(!$Client->save()) {
		echo "Failure updating city for [{$Client->getName()}]<br />";
	}
}
foreach($_POST as $key => $value) {
	$$key = $value;
}
if(isset($Name)) {
	for ($index = 0; $index < 1; $index++) {
		if(!empty($Name) && $Name != "") {
			$Client = new Client();
			$Client->setName($Name[$index]);
			$Client->setStreetAddress($StreetAddress[$index]);
			$Client->setStreetAddress2($StreetAddress2[$index]);
			$Client->setStateOrProv($StateOrProv[$index]);
			$Client->setZip($Zip[$index]);
			$Client->setCountry($Country[$index]);
			$Client->setContact($Contact[$index]);
			$Client->setPhone($Phone[$index]);
			$Client->setPriority(1);
			if (!$Client->save()) {
				$errors[] = "Failed to save {$Client->getName()}";
			}
		}
	}
}
$Name = $Contact = $Phone = $StreetAddress = $StreetAddress2 = $StateOrProv = $Zip = ""; $Country = 225;?>
<form name="newclient" action="/TimeSheet/AddClients/" method="post">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Name</th>
				<th>Street Address</th>
				<th>Street Address 2</th>
				<th>StateOrProv</th>
				<th>Zip</th>
				<th>Country</th>
				<th>Contact</th>
				<th>Phone</th>
			</tr>
		</thead>
		<tbody>
		<?php for($index = 0; $index < 1; $index++) { ?>
			<tr>
				<td><input type="text" class="form-control" name="Name[]" placeholder="Client Name" value="<?php echo $Name; ?>" maxlength="50"/></td>
				<td><input type="text" class="form-control" name="StreetAddress[]" placeholder="Attn: John Smith" value="<?php echo $StreetAddress; ?>" maxlength="100"/></td>
				<td><input type="text" class="form-control" name="StreetAddress2[]" placeholder="1345 Monroe Ave" value="<?php echo $StreetAddress2; ?>" maxlength="100"/></td>
				<td><input type="text" class="form-control" name="StateOrProv[]" placeholder="MI" value="<?php echo $StateOrProv; ?>" maxlength="100"/></td>
				<td><input type="text" class="form-control" name="Zip[]" placeholder="49505" value="<?php echo $Zip; ?>" maxlength="10"/></td>
				<td>
					<select class="form-control" name="Country[]">
						<option value="35">CA</option>
						<option value="225" selected>US</option>
					</select>
				</td>
				<td><input type="text" class="form-control" name="Contact[]" placeholder="Scott Palma" value="<?php echo $Contact; ?>" maxlength="60"/></td>
				<td><input type="text" class="form-control" name="Phone[]" placeholder="2489829600" value="<?php echo $Phone; ?>" maxlength="17"/></td>
			</tr>
		<? } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
					<button type="submit" class="btn btn-block btn-secondary">Add Clients</button>
				</td>
			</tr>
		</tfoot>
	</table>
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