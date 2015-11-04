<div role="tabpanel" class="tab-pane" id="myclients">
	<div class="row">
		<div class="col-sm-8">
			<div class="input-group">
				<span class="input-group-addon" id="sizing-addon2">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
				</span>
				<input id="my-search-box" type="text" value="<?php echo $TPLDATA["SearchText"]; ?>" class="form-control" placeholder="Search for a client..." aria-describedby="sizing-addon2">
			</div>
		</div>
		<div class="col-sm-4">
			<button class="btn btn-block btn-default btn-primary" data-toggle="modal" data-target="#modal-newclient"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add a new client</button>
		</div>
	</div>
	<br />
	<div class="panel-group" id="my-client-list">
		<?php foreach ($MyClients as $cid => $client) { ?>
			<div class="panel panel-default">
				<h4 class="panel-title">
					<a class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#accordion" href="#myclient<?php echo $cid; ?>"><?php echo trim($client["Name"]); ?><span class="badge"><? echo count($client["Projects"]); ?></span></a>
				</h4>
				<div id="myclient<?php echo $cid; ?>" class="panel-collapse collapse">
					<?php if(count($client["Projects"]) > 0) {
//                                  print_r($client)
						foreach($client["Projects"] as $pid => $project) { ?>
							<div class="list-group">
							<a class="list-group-item">
								<span class="pull-right glyphicon glyphicon-remove" data-rem-mylist="<?php echo $pid; ?>" title="Remove from my list"></span>
								<span class="rate">$<?php echo $project["Rate"]; ?></span>
								<h4 class="list-group-item-heading"><?php echo $project["Name"]; ?></h4>
							</a>
							</div><?
						}}?>
					<form name="add-project" action="/TimeSheet/Admin/AddProject" method="post" onsubmit="return AddProject(this);">
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
		<? } ?>
	</div>
</div>