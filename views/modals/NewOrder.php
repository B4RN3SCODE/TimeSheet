<div class="modal fade" id="NewOrderModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="RemoveItem" action="<?php echo SUBDIR; ?>/App/Index/NewOrder" method="post" onsubmit="return validate(this);">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Start A New Order</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="table">Table Number</label>
						<input name="table" type="number" class="form-control" />
					</div>
					<div class="form-group">
						<label for="customers">Customers</label>
						<input name="customers" type="number" class="form-control" />
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-6">
							<button id="cancel" type="button" class="btn btn-block btn-danger pull-left" data-dismiss="modal" aria-label="Close">Cancel</button>
						</div>
						<div class="col-xs-6">
							<button type="submit" class="btn btn-block btn-secondary pull-right">Create</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>