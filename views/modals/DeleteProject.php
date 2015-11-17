<div class="modal fade" id="modal-delproject">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete Project</h4>
			</div>
			<form name="delproject" action="/TimeSheet/Database/DeleteProject" method="post"><!--onsubmit="return false;">-->
				<input type="hidden" name="id" value="" />
				<div class="modal-body">
					<p>Are you sure you want to delete this project?</p>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Delete</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>