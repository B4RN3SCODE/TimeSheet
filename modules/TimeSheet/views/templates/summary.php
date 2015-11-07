<!--<pre>--><?php //print_r($TPLDATA["UserEntries"]); ?><!--</pre>-->
<?php foreach($TPLDATA["UserEntries"] as $PeriodId => $Period) { ?>
<table class="table table-condensed">
	<thead>
		<tr>
			<th><?=$PeriodId?> - <?=$Period["CycleStart"]?> to <?=$Period["CycleEnd"]?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($Period["Client"] as $ClientId => $Client) { ?>
		<tr>
			<td>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th><?=$ClientId?> - <?=$Client["Name"]?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($Client["Project"] as $ProjectId => $Project) { ?>
						<tr>
							<td>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th><?=$ProjectId?> - <?=$Project["Name"]?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($Project["Entry"] as $EntryId => $Entry) {
									echo "<tr>";
									foreach($Entry as $key => $value) { ?>
										<td><?=$key?> - <?=$value?></td>
									<? }
									echo "</tr>";
								} ?>
								</tbody>
							</table>
							</td>
						</tr>
				<? } ?>
				</tbody>
			</table>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>
<? }?>
<div class="col-md-12">
	<div class="alert alert-danger">
		<strong>SUM of hours does not include travel miles...</strong>
	</div>
</div>
<div class="col-md-12">
	<div class="alert alert-warning">
		<pre>SELECT * FROM (SELECT tsp.id AS PeriodId, CycleStart, CycleEnd, cl.id As ClientId, cl.Name as ClientName, pr.id As ProjectId, pr.Title As ProjectName, li.Description, EntryDate, Hours, Travel, Billable
FROM TimeSheetPeriod tsp
  INNER JOIN LineItem li ON li.EntryDate BETWEEN tsp.CycleStart AND tsp.CycleEnd
  INNER JOIN Project pr ON li.ProjectId = pr.id
  INNER JOIN Client cl ON cl.id = pr.ClientId) AS SUM
ORDER BY CycleStart DESC, CycleEnd DESC</pre>
	Load that into an array and create a detailed summary page.<br />
		<h4>Heirarchy</h4>
		<ul>
			<li>
				PeriodId
				<ul>
					<li>
						ClientId
						<ul>
							<li>
								ProjectId
								<ul>
									<li>
										EntryDate
										<ul>
											<li>Description</li>
											<li>Hours</li>
											<li>Travel</li>
											<li>Billable</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
		<h4>We could add user to the top of the heirarchy.</h4>
	</div>
</div>
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
					</tr>
				<? } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>