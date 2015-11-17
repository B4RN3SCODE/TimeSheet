<div class="modal fade" id="modal-editlineitem">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Line Item</h4>
			</div>
			<form name="editlineitem" action="/TimeSheet/Database/UpdateLineItem" method="post" onsubmit="return UpdateLineItem(event);">
			<input type="hidden" name="id" value="" />
				<div class="modal-body">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="EntryDate">Date</label>
									<input class="form-control datepicker text-center" name="EntryDate" placeholder="<? echo date("m/d/Y", time())?>" value="<?php echo $_POST["EntryDate"][$index]; ?>" />
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="Hours">Hours</label>
									<input class="form-control text-center" type="text" name="Hours" placeholder="2.5" value="<?php echo $_POST["Hours"][$index]; ?>" />
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="Travel">Travel (miles)</label>
									<input class="form-control text-center" type="text" name="Travel" placeholder="15" value="<?php echo $_POST["Travel"][$index]; ?>" />
								</div>
							</div>
							<div class="col-sm-3 text-center">
								<div class="form-group">
									<label for="Billable">Billable</label>
									<input type="checkbox" name="Billable" <?php if(isset($_POST["Billable"][$index])) echo "checked"; ?> />
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label for="Description">Description</label>
									<input class="form-control" type="text" name="Description" placeholder="Created database" maxlength="500" value="<?php echo $_POST["Description"][$index]; ?>" />
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>