<h1>Supplier Setup - DAVIDSTEST</h1>
<?php
$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Create','url'=>array('create')),
	array('label'=>'View','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage','url'=>array('admin')),
);

$this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills',
	'encodeLabel'=>false,
	'items'=>array(
		array(
			'label'=>'Step 1<br/>Supplier',
			'url'=>'supplierStep',
			'active'=>true,
		),
    	array(
    		'label'=>'Step 3<br/>Import Info',
    		'url'=>'importStep',
    	),
    	array(
    		'label'=>'Step 4<br/>Import & Fetch',
    		'url'=>'fetchStep',
    	),
    	array(
    		'label'=>'Step 5<br/>Map Item',
    		'url'=>'mapitemStep',
    	),
    	array(
    		'label'=>'Step 6<br/>Map QOH',
    		'url'=>'mapqohStep',
    	),
    	array(
    		'label'=>'Step 7<br/>Match',
    		'url'=>'matchStep',
    	),
	),
	'htmlOptions'=>array(
		'style'=>'margin-bottom:0px;',
	),
));
			
?>