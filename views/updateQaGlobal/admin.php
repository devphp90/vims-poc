<?php
/* @var $this UpdateQaGlobalController */
/* @var $model UpdateQaGlobal */

$this->breadcrumbs=array(
	'Update QA Globals'=>array('index'),
	'Manage',
);
$this->helpText = 'calculations are >= %';

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
    array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('update-qa-global-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
		Text here....
	</div>

	<div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'type'=>'primary',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<h1>Manage Update QA Globals</h1>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'update-qa-global-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'columns'=>array(
		'id',
		array(
            'name'=>'item_percent',
            'header'=>'Row Count Change<br/>PASS/FAIL (Import phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
			//'headerHtmlOptions' => array('style' => 'width:50px')
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'item_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),
		array(
            'name'=>'instock_percent',
            'header'=>'InStock Items Change<br/>PASS/FAIL (Update phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
			//'headerHtmlOptions' => array('style' => 'width:50px')
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'instock_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),
        array(
            'name'=>'di_price_percent',
			//'headerHtmlOptions' => array('style' => 'width:50px')
			'header'=>'Row Price Change<br/>PASS/FAIL (Update phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',

				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'di_price_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),
        array(
            'name'=>'di_qoh_percent',
			//'headerHtmlOptions' => array('style' => 'width:50px')
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'header'=>'Row QOH Change<br/>PASS/FAIL (Update phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'di_qoh_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),

        array(
            'name'=>'price_percent',
			//'headerHtmlOptions' => array('style' => 'width:50px')
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'header'=>'Item Price Changes<br/>WARNING (Update phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'price_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),
        array(
            'name'=>'qoh_percent',
			//'headerHtmlOptions' => array('style' => 'width:50px')
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'header'=>'Item QOH Changes<br/>WARNING (Update phase) <a href="#" rel="tooltip" title="The percentage of rows on the sheet that were added or removed from the previous sheet. Based upon the previous import log." style="display:inline;">(?)</a>',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'qoh_percent'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
