<div role="tabpanel" class="tab-pane fade in active" id="allclients">
	<div class="panel-group" id="client-list">
		<?php foreach ($clients as $cid => $client) { ?>
			<div class="panel panel-default">
				<h4 class="panel-title">
					<a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#client<?php echo $cid; ?>"><?php echo trim($client["Name"]); ?><span class="pull-right glyphicon glyphicon-pencil" data-edit-client="<?php echo $cid; ?>"></span><span class="badge"><?php echo count($client["Projects"]); ?></span></a>
				</h4>

				<div id="client<?php echo $cid; ?>" class="panel-collapse collapse">
					<?php if(count($client["Projects"]) > 0) {
						foreach($client["Projects"] as $pid => $project) { ?>
							<div class="list-group">
							<a class="list-group-item">
								<span class="pull-right glyphicon glyphicon-pencil" data-edit-id="<?php echo $pid; ?>" title="Edit Project"></span>
								<!-- TODO check if it is already in mylist and replace with a remove from mylist option -->
								<?php if(!isset($MyClients[$cid]["Projects"][$pid])) {
									?><span class="pull-right glyphicon glyphicon-plus" data-addtomylist="<?php echo $pid; ?>" title="Add project to my list"></span><?php } ?>
								<span class="pull-right glyphicon glyphicon-remove" data-del-id="<?php echo $pid; ?>" title="Delete Project"></span>
								<span class="rate">$<?php echo $project["Rate"]; ?></span>
								<h4 class="list-group-item-heading"><?php echo $project["Name"]; ?></h4>
							</a>
							</div><?php
						}
					}?>
					<form name="add-project" action="/TimeSheet/Database/AddProject" method="post" onsubmit="return AddProject(this);">
						<input type="hidden" name="clientId" value="<?php echo $cid; ?>" />
						<div class="list-group">
							<a class="list-group-item">
								<div class="row">
									<div class="col-sm-7">
										<input name="name" type="text" class="form-control" placeholder="Add a new project to <?php echo $client["Name"]; ?>">
									</div>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">$</span>
											<input name="rate" type="number" class="form-control" placeholder="50" aria-label="Amount (to the nearest dollar)">
										</div>
									</div>
									<div class="col-sm-2">
										<button class="btn btn-block btn-default" type="button" onclick="this.form.submit()" disabled>&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;</button>
									</div>
								</div>
							</a>
						</div>
					</form>
				</div>
			</div>
		<?php } ?>
	</div>
</div>