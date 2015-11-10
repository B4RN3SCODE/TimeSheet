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
</div>