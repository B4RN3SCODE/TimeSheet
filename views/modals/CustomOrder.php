<div class="modal fade" id="CustomOrder">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="CustomOrder" action="<?php echo SUBDIR; ?>/App/Index/CustomOrder" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Customize Item</h4>
				</div>
				<input type="hidden" name="CustomerId" value="" />
				<input type="hidden" name="ItemId" value="" />
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<textarea class="form-control" name="customized" placeholder="Enter custom details for this item..."></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-6">
							<button id="cancel" type="button" class="btn btn-block btn-danger pull-left" data-dismiss="modal" aria-label="Close">Cancel</button>
						</div>
						<div class="col-xs-6">
							<button type="submit" class="btn btn-block btn-secondary pull-right">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>