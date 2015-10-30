<?php
echo "<ul>";
foreach($_POST as $key => $value)
	echo "<li>$key => $value</li>";
echo "</ul>";
?>
<div id="edit-account">
	<div id="user-edit" class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">User Settings</h3>
			</div>
			<div class="panel-body">
				<form name="user-settings" action="" method="post">
					<input type="hidden" name="form" value="user-settings">
					<div class="form-group">
						<label for="first-name">First Name</label>
						<input type="text" class="form-control" name="first-name" placeholder="First Name" value="<? echo $TPLDATA["FirstName"]; ?>">
					</div>
					<div class="form-group">
						<label for="last-name">Last Name</label>
						<input type="text" class="form-control" name="last-name" placeholder="Last Name" value="<? echo $TPLDATA["LastName"]; ?>">
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
				<form name="timesheet-settings" action="" method="post">
					<input type="hidden" name="form" value="timesheet-settings">
					<div class="form-group">
						<label for="default-client">Default Client</label>
						<select name="default-client" class="form-control">
							<option value="-1" selected>-- Select Client --</option>
							<option value="0">Flex-N-Gate</option>
							<option value="1">GRAR</option>
						</select>
					</div>
					<div class="form-group">
						<label for="default-project">Default Project</label>
						<select name="default-project" class="form-control">
							<option value="-1" selected>-- Select Project --</option>
							<option value="0">Vendor Portal</option>
						</select>
					</div>
					<input type="submit" class="btn btn-secondary pull-right" value="Save Changes" />
				</form>
			</div>
		</div>
	</div>
</div>

<!--<div class="col-md-4" align="center">-->
<!--	<table>-->
<!--		<tr>-->
<!--			<td>First</td>-->
<!--			<td>Last</td>-->
<!--			<td>Email</td>-->
<!--		</tr>-->
<!--		<tr>-->
<!--			<td>--><?php //echo $TPLDATA["FirstName"]; ?><!--</td>-->
<!--			<td>--><?php //echo $TPLDATA["LastName"]; ?><!--</td>-->
<!--			<td>--><?php //echo $TPLDATA["Email"]; ?><!--</td>-->
<!--		</tr>-->
<!--	</table>-->
<!--</div>-->
