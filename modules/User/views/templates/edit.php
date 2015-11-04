<?php
$MyClients = ($TPLDATA["MyClients"] == false) ? array() : $TPLDATA["MyClients"];
$MyProjects = array();
?>
<div id="edit-account">
	<div id="user-edit" class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">User Settings</h3>
			</div>
			<div class="panel-body">
				<form name="user-settings" action="/User/Edit/Update" method="post">
					<input type="hidden" name="form" value="user-settings">
						<div class="row">
							<div class="form-group col-sm-6">
							  <label for="first-name">First Name</label>
							  <input type="text" class="form-control" name="first-name" placeholder="First Name" value="<? echo $TPLDATA["FirstName"]; ?>" autofocus>
							</div>
							<div class="form-group col-sm-6">
							  <label for="last-name">Last Name</label>
							  <input type="text" class="form-control" name="last-name" placeholder="Last Name" value="<? echo $TPLDATA["LastName"]; ?>">
							</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-6">
							  <label for="email">Email</label>
							  <input type="email" class="form-control" name="email" placeholder="user@arbsol.com" value="<? echo $TPLDATA["Email"]; ?>">
							</div>
							<div class="form-group col-sm-6">
							  <label for="phone">Phone Number</label>
							  <input type="number" class="form-control" name="phone" placeholder="6165551234" value="<? echo $TPLDATA["Phone"]; ?>">
							</div>
						</div>
					<a href="/User/ChangePassword" class="btn btn-primary">Change Password</a>
					<input type="submit" class="btn btn-secondary pull-right" value="Save Changes" />
				</form>
				<!--            <div class="row"><hr></div>-->
			</div>
		</div>
	</div>
	<div id="timesheet-edit" class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Timesheet Settings</h3>
			</div>
			<div class="panel-body">
				<form name="timesheet-settings" action="/User/Edit/UpdateDefault" method="post">
					<input type="hidden" name="form" value="timesheet-settings">
					<div class="form-group">
						<label for="default-client">Default Client</label>
						<select name="default-client" class="form-control">
							<option value="0">-- Select Client --</option>
							<?php foreach($MyClients as $cid => $client) { ?>
								<option value="<?php echo $cid ?>"<?php if($client["Default"] == true) { $MyProjects = $client["Projects"]; echo " selected"; }?>><?php echo $client["Name"]; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="default-project">Default Project</label>
						<select name="default-project" class="form-control">
							<option value="0" selected>-- Select Project --</option>
							<?php foreach($MyProjects as $pid => $project) { ?>
								<option value="<?php echo $pid ?>"<?php if($project["Default"] == true) echo " selected";?>><?php echo $project["Name"] ?></option>
							<?php } ?>
						</select>
					</div>
					<input type="submit" class="btn btn-secondary pull-right" value="Save Changes" />
				</form>
			</div>
		</div>
	</div>
</div>