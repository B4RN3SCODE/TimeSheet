<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Create New User</h3>
		</div>
		<div class="panel-body">
			<form name="user-settings" action="/User/Database/AddUser" method="post">
				<input type="hidden" name="form" value="new-user">
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" placeholder="user@arbsol.com" value="<?php echo $TPLDATA["Email"]; ?>" autofocus>
					</div>
					<div class="form-group col-sm-6">
						<label for="password">Password</label>
						<input type="text" class="form-control" name="password">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="fname">First Name</label>
						<input type="text" class="form-control" name="fname" placeholder="First" value="<?php echo $TPLDATA["FName"]; ?>">
					</div>
					<div class="form-group col-sm-6">
						<label for="lname">Last Name</label>
						<input type="text" class="form-control" name="lname" placeholder="Last" value="<?php echo $TPLDATA["LName"]; ?>">
					</div>
				</div>
				<input type="submit" class="btn btn-block btn-secondary pull-right" value="Create User" />
			</form>
		</div>
	</div>
</div>