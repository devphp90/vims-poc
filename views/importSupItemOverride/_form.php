<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'import-sup-item-override-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'supplier_name',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php

		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'ImportSupItemOverride[supplier_name]',
			'value'=>$model->supplier_name,
			'model'=>$model,
			'source'=>$this->createUrl('/supplier/autocompleteSup'),
			'options'=>array(
				//'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
			),

		));

		?>
		</div>
		<?php echo $form->error($model,'supplier_name'); ?>
	</div>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'supitem_vsku',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php

		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'ImportSupItemOverride[supitem_vsku]',
			'value'=>$model->supitem_vsku,
			'model'=>$model,
//			'source'=>$this->createUrl('/supplier/autocompleteSupVsku'),
			'options'=>array(
				//'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
				
			),
			'source'=> 'js:function(request, response) {$.ajax({url: "'.$this->createUrl('/supplier/autocompleteSupVsku').'",dataType: "json",data: {term : request.term,supplier : $("#ImportSupItemOverride_supplier_name").val()},success: function(data) {response(data);}});}',

		));

		?>
		</div>
		<?php echo $form->error($model,'supitem_vsku'); ?>
	</div>
	


	<?php echo $form->datepickerRow($model,'start',array('class'=>'span5')); ?>

	<?php echo $form->datepickerRow($model,'end',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'qty',array('class'=>'span5')); ?>
	
	<?php echo $form->textAreaRow($model,'comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
