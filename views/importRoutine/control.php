<div style="height:50px;">
</div>
<h1>Automatic Update Routine</h1>
<form method="post">
    <pre>
        <?php
        $serverModel = ImportRoutineServer::model()->findALl('status=1');
        foreach ($serverModel as $server) {
            $list = $server->crontab;
            echo 'Server:', str_ireplace('http://', '', $server->domain);
            echo "\tStatus:", strlen($list) ? '<font color="green">Start</font>' : '<font color="red">Stop</font>';
            echo "\t";
            if (strlen($list)) {

                echo CHtml::button('Stop', array(
                    'onClick' => 'js:location.href="' . $server->domain . '/index.php/Crontab/stop"',
                ));
            } else {
                echo CHtml::button('Start', array(
                    'onClick' => 'js:location.href="' . $server->domain . '/index.php/Crontab/start"',
                ));
            }
            echo '<hr>';

            echo $list;

            echo '<br/>';
            echo '<br/>';
        }
        ?>
    </pre>
</form>