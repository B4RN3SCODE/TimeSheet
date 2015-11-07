<div id="TimeSheetSummary" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">TimeSheet Summary</h3>
		</div>
		<div class="panel-body">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Cycle Start</th>
						<th>Cycle End</th>
						<th>Total Hours</th>
						<th>Billable Hours</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($TPLDATA["TimeSheets"] as $TimeSheet) { ?>
					<tr data-period="<?php echo $TimeSheet["PeriodId"]; ?>">
						<td><?php echo (new DateTime($TimeSheet["CycleStart"]))->format("m/d/Y"); ?></td>
						<td><?php echo (new DateTime($TimeSheet["CycleEnd"]))->format("m/d/Y"); ?></td>
						<td><?php echo $TimeSheet["Total"]; ?></td>
						<td><?php echo $TimeSheet["Billable"]; ?></td><?php
						if($TimeSheet["Processed"] || $TimeSheet["Total"] == 0) {
							echo "<td><label><em>Processed</em></label></td>";
						} else {
							$text = $TimeSheet["Submitted"] ? "Un-Submit" : "Submit";
							echo "<td><button type=\"button\" class=\"btn btn-secondary\" data-action=\"toggle-submit\">$text</button></td>";
						}?>
					</tr>
				<? } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>