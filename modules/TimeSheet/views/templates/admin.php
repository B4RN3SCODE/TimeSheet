<?php
$Users = $TPLDATA["UserNames"];
$Periods = $TPLDATA["Periods"];
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">User and Period</h3>
			</div>
			<div class="panel-body">
				<form name="UserAndPeriod" method="post" action="/services/UserCycle.php">
				<div class="row">
					<div class="col-sm-6">
						<label for="uid">User</label>
						<select name="uid" class="form-control">
							<option value="-1">-- Select --</option>
							<?php foreach($Users as $tmpUser) { ?>
							<option value="<?php echo $tmpUser["value"];?>"><?php echo $tmpUser["label"]; ?></option>
							<? } ?>
						</select>
					</div>
					<div class="col-sm-6">
						<label for="pid">Period</label>
						<select name="pid" class="form-control">
							<option value="-1">-- Select --</option>
							<?php foreach($Periods as $tmpPeriod) { ?>
								<option value="<?php echo $tmpPeriod["value"];?>"><?php echo $tmpPeriod["label"]; ?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" id="DLUserCycle" class="btn btn-secondary btn-block">Download Spreadsheet</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>