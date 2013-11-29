<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="language" content="en" />



	<!-- blueprint CSS framework -->



	<!--[if lt IE 8]>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />

	<![endif]-->



	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />



	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>



<body>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/vims.css" />



<?php

	$this->widget('bootstrap.widgets.TbNavbar', array(

		'type'=>'inverse', // null or 'inverse'

	    'brand'=>Yii::app()->name,

	    'fixed' => 'top',

	    'collapse'=>true, // requires bootstrap-responsive.css

	    'items'=>array(

	        array(

	            'class'=>'bootstrap.widgets.TbMenu',

	            'encodeLabel'=>false,

	            'items'=>array(

	            	array(

	            		'label'=>'Home',

	            		'url'=>array('/site/inventory'),

	            		'visible'=>!Yii::app()->user->isGuest

	            	),

					array(

						'label'=>'DashBoard<br/>& Reports',

						'url'=>array('/site/dashboard'),

						'visible'=>!Yii::app()->user->isGuest

					),

					array(

						'label'=>'Suppliers<br/>& Items',

						'url'=>array('/tabs/admin'),

						'visible'=>!Yii::app()->user->isGuest

					),

/*

					array(

						'label'=>'Import<br/>Sheets',

						'url'=>array('/importRoutine/importRoutine'),

						'visible'=>!Yii::app()->user->isGuest

					),

					array(

						'label'=>'View<br/>vSheets',

						'url'=>array('/importVsheet/admin'),

						'visible'=>!Yii::app()->user->isGuest

					),

					array(

						'label'=>'Update<br/>Supp/UBS Items',

						'url'=>array('/importRoutine/updateRoutine'),

						'visible'=>!Yii::app()->user->isGuest

					),

*/

					/*array(

						'label'=>'Supplier Items<br/>BIG TABLE',

						'url'=>'#', //array('/supInventory/admin'),
                        'linkOptions' => array('title' => 'Under Construction'),
						'visible'=>!Yii::app()->user->isGuest

					),*/

					array(

						'label'=>'UBS <br/>Items',

						'url'=>array('/ubsInventory/admin'),

						'visible'=>!Yii::app()->user->isGuest,

					),

					array(

						'label'=>'Rules &<br/>OverRides',

						'url'=>array('/site/rules'),

						'visible'=>!Yii::app()->user->isGuest,

					),

/*
					array(

						'label'=>'Quality Assurance<br/>Rules',

						'url'=>array('/#qa_section'),

						'visible'=>!Yii::app()->user->isGuest,

					),

					array(

						'label'=>'Buffer Qty<br/>Rules',

						'url'=>array('/#buff_section'),

						'visible'=>!Yii::app()->user->isGuest,

					),

					array(

						'label'=>'Price<br/>Rules',

						'url'=>array('/#price_section'),

						'visible'=>!Yii::app()->user->isGuest,

					),
*/




					array(

						'label'=>'Data<br/>Feeds',

						'url'=>array('/site/datafeed'),

						'visible'=>!Yii::app()->user->isGuest,

					),



					array(

						'label'=>'Start/Stop Auto<br/>Import/Update',

						'url'=>array('/importRoutine/routinecontrol'),

						'visible'=>!Yii::app()->user->isGuest,

					),



	            ),

	        ),



	        array(

	            'class'=>'bootstrap.widgets.TbMenu',

                'encodeLabel'=>false,

	            'htmlOptions'=>array('class'=>'pull-right'),

	            'items'=>array(
					array(

						'label'=>'System<br/>Info', 'url'=>array('/site/systeminfo', 'view'=>'help')),
	            	array(

						'label'=>'Help', 'url'=>array('/site/page', 'view'=>'help')),

					array(

						'label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),


	                array('label'=>Yii::t('app','Logout ('.Yii::app()->user->name.')'), 'url'=>array('/site/logout'),'visible'=>!Yii::app()->user->isGuest),


	                array('label'=>Yii::t('app','Login'), 'url'=>array('/site/login'),'visible'=>Yii::app()->user->isGuest),

	            ),

	        ),

	    ),

	)); ?>

<style type="text/css">

.container-fluid > h1:nth-of-type(1)
{
	position:relative;
	top:-50px;
}

h1{

	font-size: 26px;



}

.container, .navbar-static-top .container, .navbar-fixed-top .container, .navbar-fixed-bottom .container{



	width:auto;

	padding-left: 20px;

	padding-right: 20px;

}

</style>

<div class="container-fluid" id="page" style="margin-top:80px;">





	<?php /*

if(isset($this->breadcrumbs)):?>

		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(

			'links'=>$this->breadcrumbs,

		)); ?><!-- breadcrumbs -->

	<?php endif

*/?>



	<div class="container-fluid">

		<div id="content">

			<?php echo $content; ?>

		</div><!-- content -->

	</div>



	<div id="footer">

		Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.axeo.com" target="_blank">AXEO</a>.<br/>

		All Rights Reserved. Powered by <a href="http://www.axeo.com" target="_blank">AXEO</a>.<br/>

		<?php echo date("Y-m-d H:i:s");?>

		Runtime:<?php echo Yii::getLogger()->getExecutionTime()?>

	</div><!-- footer -->
	



</div><!-- page -->

<?php if(!Yii::app()->user->isGuest) {?>
<script>
	
	function sendOnlineTime() {
		$.ajax({
			url: '<?php echo Yii::app()->createUrl('site/updateOnlineTime') ?>',
			type: 'POST',
			success: function (response) {},
		});
	}
	sendOnlineTime();
	var interval = setInterval(sendOnlineTime, 11000);

</script>

<?php }?>
</body>

</html>