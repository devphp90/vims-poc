<h1>System Info</h1>

<h3>Memory Usage</h3>
<?php
exec("free -m", $value);

foreach($value as $id=>$task){
	echo $task;
	echo '<br/>';
}
?>
<h3>PHP & MySQL Proccess</h3>
<?php
exec("ps aux | grep -v root | grep -v dovecot | grep -v dbus | grep -v ntp | grep -v named | grep -v hald | grep -v mailnull | grep -v sshd | grep -v sftp-server", $value1);

foreach($value1 as $id=>$task){
	echo $task;
	echo '<br/>';
}
?>