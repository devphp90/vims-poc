<!-- todo: move styling to css -->
<div class="pull-left" style="width: 220px;">
	<table class='table table-striped'>
		<thead style="background-color: #999">
			<tr><th colspan="2" style="text-align:center"><h4>Updates for Today</h4></th></tr>
		</thead>
		<tbody>
			<tr>
				<th>Total</th>
				<td style="text-align: right;"><?= $total; ?></td>
			</tr>
			<tr>
				<th>Pass</th>
				<td style="text-align: right;"><?= $pass; ?></td>
			</tr>
			<tr>
				<th>Fail</th>
				<td style="text-align: right;"><?= $fail; ?></td>
			</tr>
		</tbody>
	</table>
</div>