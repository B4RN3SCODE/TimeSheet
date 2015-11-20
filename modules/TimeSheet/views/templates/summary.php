<div id="TimeSheetSummary" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">TimeSheet Summary</h3>
		</div>
		<div class="panel-body table-responsive">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Cycle Start</th>
						<th>Cycle End</th>
						<th>Total Hours</th>
						<th>Billable Hours</th>
						<th>Action</th>
						<th>Download</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($TPLDATA["TimeSheets"] as $TimeSheet) { ?>
					<tr data-period="<?php echo $TimeSheet["PeriodId"]; ?>">
						<td><?php echo (new DateTime($TimeSheet["CycleStart"]))->format("m/d/Y"); ?></td>
						<td><?php echo (new DateTime($TimeSheet["CycleEnd"]))->format("m/d/Y"); ?></td>
						<td><?php echo $TimeSheet["Total"]; ?></td>
						<td><?php echo $TimeSheet["Billable"]; ?></td>
						<td><?php
						if($TimeSheet["Processed"]) {
							echo "<label><em>Processed</em></label>";
						} else if($TimeSheet["Total"] == 0) {
							echo "<label><em>No time recorded</em></label>";
						} else {
							$text = $TimeSheet["Submitted"] ? "Un-Submit" : "Submit";
							echo "<button type=\"button\" class=\"btn btn-secondary\" data-action=\"toggle-submit\">$text</button>";
						}?></td>
						<td><a href="/PHPExcelTest/UserCycle.php?pid=<?php echo $TimeSheet["PeriodId"]; ?>" class="btn btn-primary">Download</a></td>
					</tr>
				<? } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div id="DetailedSummary" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Detailed Summary
			</h3>
		</div>
		<div class="panel-body">
			<div class="list-group panel">
				<?php foreach($TPLDATA["UserEntries"] as $PeriodId => $Period) { ?>
					<a href="#period<?php echo $PeriodId; ?>" class="period list-group-item-info list-group-item" data-toggle="collapse"><?php
						if($Period["CycleStart"] == $_SESSION["CurrentBillingPeriod"]["StartDate"]) {
							echo "Current Cycle";
						} else {
							echo date("m/d/Y",strtotime($Period["CycleStart"])) . " to " . date("m/d/Y",strtotime($Period["CycleEnd"]));
						}
						?></a>
					<div class="collapse" id="period<?php echo $PeriodId; ?>">
						<?php foreach($Period["Client"] as $ClientId => $Client) { ?>
							<a href="#<?php echo "p{$PeriodId}c{$ClientId}"; ?>" class="client list-group-item list-group-item-warning" data-toggle="collapse"><?php echo $Client["Name"]; ?></a>
							<div class="collapse" id="<?php echo "p{$PeriodId}c{$ClientId}"; ?>">
								<?php foreach($Client["Project"] as $ProjectId => $Project) { ?>
									<a href="#<?php echo "p{$PeriodId}p{$ProjectId}"; ?>" class="project list-group-item list-group-item-text" data-toggle="collapse"><?php echo $Project["Name"]; ?></a>
									<div id="<?php echo "p{$PeriodId}p{$ProjectId}"; ?>" class="collapse table-responsive">
										<table class="table table-condensed table-striped table-bordered">
											<thead>
											<tr>
												<th>Date</th>
												<th>Description</th>
												<th>Hours</th>
												<th>Travel</th>
												<th>Billable</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach($Project["Entry"] as $EntryId => $Entry) { ?>
												<tr>
													<td><?php echo date("m/d/Y",strtotime($Entry["Date"])); ?></td>
													<td><?php echo $Entry["Description"]; ?></td>
													<td><?php echo $Entry["Hours"]; ?></td>
													<td><?php echo $Entry["Travel"]; ?></td>
													<td><?php echo ($Entry["Billable"] == 1) ? "Yes" : "No"; ?></td>
												</tr>
											<? } ?>
											</tbody>
										</table>
									</div>
								<? } ?>
							</div>
						<? } ?>
					</div>
				<? } ?>
			</div>
		</div>
	</div>
</div>