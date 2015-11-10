<?php
$Menu = $TPLDATA["MENU"];
?>
<div class="modal fade" id="Menu">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="AddItems" action="<?php echo SUBDIR; ?>/App/Index/AddItems" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Items to Customer</h4>
			</div>
			<input type="hidden" name="OrderId" value="" />
			<input type="hidden" name="CustomerId" value="" />
			<div class="modal-body">
				<div class="list-group">
					<?php
					foreach($Menu as $Item => $SubItem) { ?>
					<div class="list-group-item list-group-item-heading" <?php if(is_array($SubItem)) { ?>data-toggle="collapse" href="#<?php echo $Item; ?>"<?php }?>><?php echo $Item; ?></div>
						<div class="collapse" id="<?php echo $Item; ?>">
							<div class="list-group">
							<?php foreach($SubItem as $SubItem2 => $SubItemGroup) {
								if(is_array($SubItemGroup)) {?>
									<div class="list-group-item list-group-item-info" <?php if(is_array($SubItemGroup)) { ?>data-toggle="collapse" href="#<?php echo $SubItem2; ?>"<?php }?>><?php echo $SubItem2; ?></div>
									<div class="collapse" id="<?php echo $SubItem2; ?>">
										<div class="list-group">
										<?php foreach($SubItemGroup as $SubItem3 => $SubGroup3) { ?>
											<div class="list-group-item list-group-item-warning"><?php echo $SubItem3; ?>
												<span class="glyphicon glyphicon-plus-sign pull-right"></span>
												<span class="rate pull-right"><?php echo $SubGroup3; ?></span>
											</div>
										<? } ?>
										</div>
									</div>
								<? } else { ?>
									<div class="list-group-item list-group-item-info"><?php echo $SubItem2; ?>
										<span class="glyphicon glyphicon-plus-sign pull-right"></span>
										<span class="rate pull-right"><?php echo $SubItemGroup; ?></span>
									</div>
							<? }
							} ?>
							</div>
						</div>
				<? } ?>
				</div>
			</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col-xs-6">
					<button id="cancel" type="button" class="btn btn-block btn-danger pull-left" data-dismiss="modal" aria-label="Close">Cancel</button>
				</div>
				<div class="col-xs-6">
					<button type="submit" class="btn btn-block btn-secondary pull-right">Submit</button>
				</div>
			</div>
		</div>
		</form>
		</div>
	</div>
</div>
