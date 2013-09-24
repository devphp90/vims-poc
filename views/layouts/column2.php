<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">

	

			<?php
			if(!empty($this->helpText)){
			?>
			<div class="alert">
			<?php echo $this->helpText;?>
			</div>
			<?php
			}
			?>

			<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'htmlOptions'=>array(
					'class'=>'well',
					'style'=>'height:10px;padding-top:0px;padding-bottom:15px;position:relative;top:60px;',
				)
			));
		$this->widget('bootstrap.widgets.TbMenu', array(
				'type'=>'pills',
				'items'=>$this->menu,
				'htmlOptions'=>array(
					'style'=>'margin-bottom:0px;',
				),
			));
		$this->endWidget();
			?>
		
			<?php echo $content; ?>

	
</div>
<?php $this->endContent(); ?>