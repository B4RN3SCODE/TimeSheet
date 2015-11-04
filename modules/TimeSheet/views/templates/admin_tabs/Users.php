<div role="tabpanel" class="tab-pane" id="users">
	<form name="timesheet-active-users" action="" method="post">
		<table class="table table-striped table-hover table-condensed">
			<thead>
			<tr>
				<th width="1%">User ID</th>
				<th width="15%">User Name</th>
				<th width="10%" class="text-center">Enabled</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($TPLDATA["Users"] as $User) { ?>
				<tr>
					<td class="text-center"><? echo $User->getId(); ?><input type="hidden" name="userid[]" value="<? echo $User->getId(); ?>" /></td>
					<td><? echo $User->getFirstName() . ' ' . $User->getLastName(); ?></td>
					<td class="text-center"><input type="checkbox" name="active[]"<?php if($User->getActive()) echo " checked"; ?> /></td>
				</tr>
			<? } ?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="3"><button class="btn btn-primary btn-block">Save</button></td>
			</tr>
			</tfoot>
		</table>
	</form>
</div>