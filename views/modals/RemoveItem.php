<div class="modal fade" id="RemoveItem">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="RemoveItem" action="<?php echo SUBDIR; ?>/App/Index/RemoveItem" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Remove Item</h4>
				</div>
				<input type="hidden" name="CustomerId" value="" />
				<input type="hidden" name="ItemId" value="" />
				<div class="modal-body">
					<label>Do you want to remove the <span id="ItemToRemove"></span> from this customer?</label>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-6">
							<button id="cancel" type="button" class="btn btn-block btn-danger pull-left" data-dismiss="modal" aria-label="Close">Cancel</button>
						</div>
						<div class="col-xs-6">
							<button type="submit" class="btn btn-block btn-secondary pull-right">Remove</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>