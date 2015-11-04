					<table class="table table-striped table-condensed">
						<thead>
						<tr>
							<th width="15%">Date</th>
							<th>Description</th>
							<th width="1%">Hours</th>
							<th width="1%">Travel</th>
							<th width="1%">Bill</th>
							<th class="text-center" colspan="2" width="1%">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if(!isset($TPLDATA["LineItems"]) || !is_array($TPLDATA["LineItems"]) || count($TPLDATA["LineItems"]) == 0) { ?>
							<tr>
								<td colspan="7">No entries found for this project.</td>
							</tr>
						<? } else {
							foreach($TPLDATA["LineItems"] as $id => $line) { ?>
								<tr id="listitem-<?php echo $id; ?>">
									<td><?php echo date('m/d/Y', strtotime(str_replace('-', '/', $line["EntryDate"]))); ?></td>
									<td><?php echo $line["Description"]; ?></td>
									<td><?php echo $line["Hours"]; ?></td>
									<td><?php echo $line["Travel"]; ?></td>
									<td><?php if ($line["Billable"] == true) { echo "Yes"; } else { echo "No"; }; ?></td>
									<td><button class="btn btn-warning" type="button" title="Edit">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</button></td>
									<td><button class="btn btn-danger pull-right" type="button" title="Remove">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</button></td>
								</tr>
							<?php }
						} ?>
						</tbody>
					</table>
<script>
	$('[id^=listitem] button span.glyphicon-remove').on('click',function(event) {
		var row = $(this).parents('tr');
		var id = $(row).attr('id').substr('listitem-'.length);
		RemoveLineEntryFromProject(id,row);
	});
</script>