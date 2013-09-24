<style type="text/css">
.grid-view table.items th
{
	background: #333333;
}

.grid-view
{
	padding: 0 0;
}
</style>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'logs-detail-grid',
	'enablePagination'=>false,
	'summaryText'=>'',
	'dataProvider'=>$dataProvider,
	'columns'=>array(

		'log_id',
		'step',
		'message',
	),
)); ?>
