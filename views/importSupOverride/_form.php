<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 'id'=>'import-sup-override-form', 'enableAjaxValidation'=>false, 'type'=>'horizontal',)); ?><?php echo $form->errorSummary($model); ?>

    <div class="control-group ">
        <?php echo $form->labelEx($model,'supplier_name',array('class'=>'control-label')); ?>

        <div class="controls">
            <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(   'name'=>'ImportSupOverride[supplier_name]',   'value'=>$model->supplier_name,   'model'=>$model,   'source'=>$this->createUrl('/supplier/autocompleteSup'),   'options'=>array(/*'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}'*/),  ));  ?>
        </div><?php echo $form->error($model,'supplier_name'); ?>
    </div><?php echo $form->datepickerRow($model,'start',array('class'=>'span5')); ?><?php echo $form->datepickerRow($model,'end',array('class'=>'span5')); ?>

    <div class="control-group ">
        <?php echo $form->labelEx($model,'applies_to_all', array('class' => 'control-label')); ?>

        <div class="controls">
            <?php echo $form->checkBox($model,'applies_to_all'); ?><?php echo $form->error($model,'applies_to_all'); ?>
        </div>
    </div>
    	<?php echo $form->textFieldRow($model,'from',array('class'=>'span5')); ?>
    	<?php echo $form->textFieldRow($model,'to',array('class'=>'span5')); ?>
    	<?php echo $form->textFieldRow($model,'applies_to_group',array('class'=>'span5')); ?>
    	<div class="control-group ">
		<?php echo $form->labelEx($model,'applies_to_one_item',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php

		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'ImportSupOverride[applies_to_one_item]',
			'value'=>$model->applies_to_one_item,
			'model'=>$model,
			'source'=>$this->createUrl('/supplier/autocompleteSupVsku'),
			'options'=>array(
				//'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
			),

		));

		?>
		</div>
		<?php echo $form->error($model,'applies_to_one_item'); ?>
	</div>
    	<?php echo $form->textFieldRow($model,'percent_adjust',array('class'=>'span5')); ?>
    	<?php echo $form->textFieldRow($model,'dollar_adjust',array('class'=>'span5')); ?>
    	<?php echo $form->textFieldRow($model,'dollar_fixed',array('class'=>'span5')); ?>
    	<?php //echo $form->textFieldRow($model,'change',array('class'=>'span5')); ?>
    	<?php //echo $form->radioButtonListInlineRow($model, 'type', array('$','%')); ?>
    	<?php echo $form->textAreaRow($model,'comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(   'buttonType'=>'submit',   'type'=>'primary',   'label'=>$model->isNewRecord ? 'Create' : 'Save',  )); ?>
    </div><?php $this->endWidget(); ?>

