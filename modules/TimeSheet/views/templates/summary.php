<?php
$TPLDATA["TimeSheets"] = array();
$end_date = new DateTime($_SESSION["CurrentBillingPeriod"]["StartDate"]);
$start_date = clone($end_date);
date_sub($start_date,new DateInterval("P16W"));

$DatePeriod = new DatePeriod($start_date, new DateInterval('P2W'), $end_date);
foreach($DatePeriod as $date) {
	$end_date = clone($date);
	$end_date = $end_date->modify("+13 days");
	$TimeSheetArray[] = array("Start"=>$date->format("m/d/Y"),
		"End"=>$end_date->format("m/d/Y"),
		"Total"=>rand(0,8),
		"Billable"=>rand(0,8));
}
$start_date = new DateTime($_SESSION["CurrentBillingPeriod"]["StartDate"]);
$end_date = new DateTime($_SESSION["CurrentBillingPeriod"]["EndDate"]);
$TimeSheetArray[] = array("Start"=>$start_date->format("m/d/Y"),
	"End"=>$end_date->format("m/d/Y"),
	"Total"=>rand(0,8),
	"Billable"=>rand(0,8));
$TimeSheetArray = array_reverse($TimeSheetArray);
?>
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
				<?php foreach($TimeSheetArray as $TimeSheet) { ?>
					<tr>
						<td><?php echo $TimeSheet["Start"]; ?></td>
						<td><?php echo $TimeSheet["End"]; ?></td>
						<td><?php echo $TimeSheet["Total"]; ?></td>
						<td><?php echo $TimeSheet["Billable"]; ?></td>
						<td><button type="button" class="btn btn-secondary">Submit</button></td>
					</tr>
				<? } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>