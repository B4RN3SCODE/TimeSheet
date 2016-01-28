<?php
if(!isset($_POST["Hours"]) || count($_POST["Hours"]) == 0) {
	$_POST["EntryDate"][0] = date("m/d/Y", time());
	$_POST["Hours"][0] = "0";
	$_POST["Travel"][0] = "0";
	$_POST["Billable"][0] = "on";
	$_POST["Description"][0] = "";
	$_POST["Error"][0] = false;
}
foreach($_POST["Hours"] as $index => $value) {
?>
<div class="panel panel-default" style="<?php if($_POST["Error"][$index]) echo "border-color: #f00;";?>">
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="EntryDate">Date</label>
					<input class="form-control datepicker text-center<?php if(isset($_POST["Error"]["EntryDate"][$index])) echo " alert-danger"; ?>" name="EntryDate[]" placeholder="<?php echo date("m/d/Y", time())?>" value="<?php echo $_POST["EntryDate"][$index]; ?>" />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="Hours">Hours</label>
					<input class="form-control text-center<?php if(isset($_POST["Error"]["Hours"][$index])) echo " alert-danger"; ?>" type="text" name="Hours[]" placeholder="2.5" value="<?php echo $_POST["Hours"][$index]; ?>" />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="Travel">Travel (miles)</label>
					<input class="form-control text-center<?php if(isset($_POST["Error"]["Travel"][$index])) echo " alert-danger"; ?>" type="text" name="Travel[]" placeholder="15" value="<?php echo $_POST["Travel"][$index]; ?>" />
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="form-group">
					<label for="Billable">Billable</label>
					<input<?php if(isset($_POST["Error"]["Billable"][$index])) echo " class=\"alert-danger\""; ?> type="checkbox" name="Billable[]" <?php if(isset($_POST["Billable"][$index])) echo "checked"; ?> />
				</div>
			</div>
			<div class="col-xs-12">
				<div class="form-group">
					<label for="Description">Description</label>
					<input class="form-control<?php if(isset($_POST["Error"]["Description"][$index])) echo " alert-danger"; ?>" type="text" name="Description[]" placeholder="Created database" maxlength="500" value="<?php echo $_POST["Description"][$index]; ?>" />
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>