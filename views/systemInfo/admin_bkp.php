<?php
/* @var $this SystemInfoController */
/* @var $model SystemInfo */

$this->breadcrumbs=array(
	'System Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
);


?>

<h1>Manage System Infos</h1>





<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'system-info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
//		'global_cancel_rate_limit',
		'cancel_rate_limit',
		'percent_change',
//		'primary_email',
//		'secondary_email',
		array(
			'class'=>'CButtonColumn',
			 'template'=>'{view}{update}',

		),
	),
)); ?>

<script src="<?php echo Yii::app()->request->baseUrl?>/js/colResizable-1.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $("table").colResizable();
    $("table.items").removeClass("CRZ");
});
</script>
