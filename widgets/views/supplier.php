<!-- todo: move styling to css -->
<div class="pull-left" style="width: 220px;">
	<table class='table table-striped'>
		<thead style="background-color: #999">
			<tr><th colspan="2" style="text-align:center"><h4>Suppliers</h4></th></tr>
		</thead>
		<tbody>
			<tr>
				<th>Total</th>
				<td style="text-align: right;"><a class="link-suppliers" target="_blank" href="<?= Yii::app()->createUrl('tabs/admin'); ?>"><?= $total; ?></a></td>
			</tr>
			<tr>
				<th>Active</th>
				<td style="text-align: right;"><a class="link-suppliers" target="_blank" href="<?= Yii::app()->createUrl('tabs/admin', array('Tabs[status]' => 1)); ?>"><?= $active; ?></a></td>
			</tr>
			<tr>
				<th>InActive</th>
				<td style="text-align: right;"><a class="link-suppliers" target="_blank" href="<?= Yii::app()->createUrl('tabs/admin', array('Tabs[status]' => 0)); ?>"><?= $inactive; ?></a></td>
			</tr>
		</tbody>
	</table>
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
	'id' => 'list-suppliers',
)); ?>
	<!-- <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Modal header</h4>
    </div> -->

    <div class="modal-body">
    </div>
<?php $this->endWidget(); ?>
<!-- todo: move to a better place -->
<script type="text/javascript">
//	$('.link-suppliers').bind('click', function(){
//		// console.log($(this).attr('href'));
//		$('#list-suppliers > .modal-body').empty();
//		$('#list-suppliers').modal('show');
//		href = $(this).attr('href');
//		$('#list-suppliers > .modal-body').load(href);
//		return false;
//	});
</script>