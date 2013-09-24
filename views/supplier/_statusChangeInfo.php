<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  'id' => 'frm-status-change-info',
  'type' => 'horizontal',
)); ?>
  <fieldset>
    <?= $form->hiddenField($model, 'supplier_id'); ?>
    <?= $form->hiddenField($model, 'edit_only'); ?>
    <?= $form->datepickerRow($model, 'from_on'); ?>
    <?= $form->datepickerRow($model, 'to_on'); ?>
    <?= $form->textFieldRow($model, 'comments'); ?>
  </fieldset>
<?php $this->endWidget(); ?>