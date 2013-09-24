<h1>Setup New <?php echo $event->sender->getStepLabel($event->step)?></h1><hr/><br/>
<?php
echo $event->sender->menu->run();
echo '<br/>';
echo CHtml::tag('div',array('class'=>'form'),$form);

?>