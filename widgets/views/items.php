<!-- todo: move styling to css -->
<div class="pull-left" style="width: 220px;">
	<table class='table table-striped'>
		<thead style="background-color: #999">
			<tr><th colspan="2" style="text-align:center"><h4>Supplier Items</h4></th></tr>
		</thead>
		<tbody>
			<tr>
				<th>Total</th>
				<td style="text-align: right;"><?= $total; ?></td>
			</tr>
			<tr>
				<th>Active</th>
				<td style="text-align: right;"><?= $active; ?></td>
			</tr>
			<tr>
				<th>InActive</th>
				<td style="text-align: right;"><?= $inactive; ?></td>
			</tr>
		</tbody>
	</table>
</div>