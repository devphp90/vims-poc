

<h1>Setup <?php echo $event->sender->getStepLabel($event->step)?></h1><hr/><br/>
<?php
echo $event->sender->menu->run();
echo '<br/>';

echo $result;
?>
