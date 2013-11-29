<?php

$this->breadcrumbs=array(

	'Import Logs'=>array('index'),

	'Manage',

);



$this->menu=array(



	array('label'=>'Clear Import log', 'url'=>array('supdelall','id'=>$tabs_id)),

	array('label'=>'Reset Import log', 'url'=>array('supreset','id'=>$tabs_id)),

	array(

		'label'=>'Search',

		'url'=>'#',

		'linkOptions'=>array(

			'class'=>'search-button',

		),

	),

);



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('tabs-import-log-grid', {

		data: $(this).serialize()

	});

	return false;

});

");



?>



<h1>Supplier Sheet Import Log: <?php echo Tabs::model()->findByPk($tabs_id)->supplier->name;?></h1>



<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>

</div><!-- search-form -->



<?php $this->renderPartial('_logs', array('model' => $model, 'dataProvider' => $dataProvider)) ?>

