

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(

	'id'=>'tabs-form',

	'enableAjaxValidation'=>false,

	'type'=>'horizontal',

)); ?>

	<?php echo $form->errorSummary($supplierModel); ?>



	<?php echo $form->errorSummary($importRoutineModel); ?>



	<?php echo $form->errorSummary($importRoutineModel2); ?>



	<?php

  $tabs = array();
  if ($emailTabOnly) {
    $tabs = array(
      array(

        'id'=>'tabs_14',

        'label'=>'Email Supplier',

        'content'=>$this->renderPartial('tabs/_emailsupplier',compact('supplierModel','model','form'),1),

      )
    );
  } else {
  $tabs = array(



    array(

      'id'=>'tabs_0',

      'label'=>'Supplier<br/>Info',

      'content'=>$this->renderPartial('tabs/_supplier',compact('supplierModel','model','form'),1),

      'active'=>1,

    ),





    /*

            array(

              'id'=>'tabs_1',

              'label'=>'Step 2<br/>Warehouse',

              'content'=>$this->renderPartial('tabs/_warehouse',compact('model','form'),1),



            ),

    */

    array(

      'id'=>'tabs_2',

      'label'=>'Sheet<br/>Info',

      'content'=>$this->renderPartial('tabs/_importRoutine',compact('importRoutineModel','importRoutineModel2','form'),1),

    ),

    /*

            array(

              'id'=>'tabs_13',

              'label'=>'Browse<br/>Server v.1',

              'content'=>$this->renderPartial('tabs/_browse',compact('model','form'),1),

            ),

    */

    array(

      'id'=>'tabs_12',

      'label'=>'Map Items<br/>DD Columns',

      'content'=>$this->renderPartial('tabs/_preview',compact('importRoutineModel2','importRoutineModel','form'),1),

    ),



    array(

      'id'=>'tabs_13',

      'label'=>'Map Items<br/>DD Columns2',

      'content'=>$this->renderPartial('tabs/_preview2',compact('importRoutineModel2','importRoutineModel','form'),1),

    ),



    /*

            array(

              'id'=>'tabs_6',

              'label'=>'Map Items<br/>DD Header',

              'content'=>$this->renderPartial('tabs/_fetch',compact('importRoutineModel2','importRoutineModel','form'),1),

            ),

    */

    array(

      'id'=>'tabs_3',

      'label'=>'Map Items<br/>Fill-in Form',

      'content'=>$this->renderPartial('tabs/_mapitem',compact('importRoutineModel2','importRoutineModel','form','columns'),1),

    ),

    array(

      'id'=>'tabs_4',

      'label'=>'Map<br/>Warehouses',

      'content'=>$this->renderPartial('tabs/_mapqoh',compact('importRoutineModel','form'),1),

    ),

    array(

      'id'=>'tabs_5',

      'label'=>'Manage<br/>vSKU',

      'content'=>$this->renderPartial('tabs/_match',compact('importRoutineModel2','importRoutineModel','form'),1),

    ),

    array(

      'id'=>'tabs_7',

      'label'=>'Run<br/>Import/Update',

      'content'=>$this->renderPartial('tabs/_runiu',compact('model'),1),

    ),



    array(

      'id'=>'tabs_8',

      'label'=>'Warehouse<br/>Locations',

      'content'=>$this->renderPartial('tabs/_warehouse',compact('model','form'),1),

    ),

    /*

            array(

              'id'=>'tabs_9',

              'label'=>'Partial Update<br/>File',

              'content'=>$this->renderPartial('tabs/_partialupdate',compact('model','form'),1),

            ),



            array(

              'id'=>'tabs_11',

              'label'=>'Partial Update<br/>Fragment',

              'content'=>'',

            ),

    */

    array(

      'id'=>'tabs_10',

      'label'=>'User OverRide<br/>(wireframe)',

      'content'=>$this->renderPartial('tabs/_override',compact('model','form'),1),

    ),

    array(

      'id'=>'tabs_14',

      'label'=>'Email Supplier',

      'content'=>$this->renderPartial('tabs/_emailsupplier',compact('supplierModel','model','form'),1),

    ),

    array(

      'id'=>'tabs_15',

      'label'=>'Nav Steps',

      'content'=>$this->renderPartial('tabs/_navSteps',  compact('navsup_model', 'form', 'model'),1),

    ),



  );
  }

	$this->widget('bootstrap.widgets.TbWizard', array(

		'type'=>'tabs', // 'tabs' or 'pills'

		'encodeLabel'=>false,

	    'tabs'=> $tabs,

	    'pagerContent' => '

	    <div class="pull-left" style=" clear: both;">

	    	<input type="button" class="btn button-previous" name="previous" value="Previous" />

		</div>

		<div class="pull-right">

			<input type="button" class="btn button-next" name="next" value="Next" />

		</div>

		',

		'options' => array(

			'nextSelector' => '.button-next',

			'previousSelector' => '.button-previous',

			'onTabClick' => 'js:function(tab, navigation, index) {



			}',

		),



    // additional javascript options for the tabs plugin



));

?>

<br/>





	<div class="form-actions">

		<?php

		$this->widget('bootstrap.widgets.TbButton', array(

			'buttonType'=>'submit',

			'type'=>'primary',

			'label'=>$model->isNewRecord ? 'Create' : 'Save',

			'htmlOptions'=>array(

			),

		));



		$this->widget('bootstrap.widgets.TbButton',array(

			'label' => 'Cancel',

			'htmlOptions'=>array(

				'onclick'=>'js:location.href="../admin";',

			),

		));

		?>

		</div>



<?php $this->endWidget(); ?>