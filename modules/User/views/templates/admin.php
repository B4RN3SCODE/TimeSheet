<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Create New User</h3>
		</div>
		<div class="panel-body">
			<form name="user-settings" action="/User/Admin/AddUser" method="post">
				<input type="hidden" name="form" value="new-user">
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" placeholder="user@arbsol.com" value="<?php echo $TPLDATA["Email"]; ?>" autofocus>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="password">Password</label>
							<div class="input-group">
								<input type="text" class="form-control" id="password" name="password" placeholder="Password">
								<span class="input-group-btn">
									<button data-task="PWGen" data-target="#password" class="btn btn-primary" type="button">Generate</button>
								</span>
							</div>
						</div>
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
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Reset User Password</h3>
		</div>
		<div class="panel-body">
			<form name="reset-user-password" method="post" action="/User/Admin/ResetUserPassword">
				<div class="form-group">
					<label for="user">Select User</label>
					<select class="form-control" name="userid">
						<option value="">Select a user</option>
						<?php foreach($TPLDATA["Users"] as $userId => $userName) { ?>
						<option value="<?php echo $userId; ?>"><?php echo $userName; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="newpassword">New Password</label>
					<div class="input-group">
						<input type="text" id="newpassword" name="newpassword" class="form-control" placeholder="New Password" />
						<span class="input-group-btn">
							<button data-task="PWGen" data-target="#newpassword" class="btn btn-primary">Generate</button>
						</span>
					</div>
				</div>
				<input type="submit" class="btn btn-block btn-secondary" value="Reset Password" />
			</form>
		</div>
	</div>
</div>