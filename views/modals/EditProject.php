<div class="modal fade" id="modal-editproject">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Project</h4>
			</div>
			<form name="editproject" action="/TimeSheet/Admin/UpdateProject" method="post"><!--onsubmit="return false;">-->
				<input type="hidden" name="id" value="" />
				<div class="modal-body">
					<div class="form-group">
						<label for="Title">Project Title (50 characters)</label>
						<input type="text" class="form-control" name="Title" placeholder="Project Title" maxlength="50"/>
					</div>
					<div class="form-group">
						<label for="Rate">Rate ($)</label>
						<input type="number" class="form-control" name="Rate" placeholder="50" />
					</div>
					<div class="form-group">
						<label for="Description">Description (100 characters)</label>
						<input type="text" class="form-control" name="Description" maxlength="100" placeholder="Project Description" />
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="InternalReference">Internal Reference #</label>
								<input type="text" class="form-control" name="InternalReference" placeholder="12345" maxlength="50"/>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label for="CustomerReference">Customer Reference #</label>
								<input type="text" class="form-control" name="CustomerReference" placeholder="12345" maxlength="50"/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>