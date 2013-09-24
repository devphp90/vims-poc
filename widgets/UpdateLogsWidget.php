<?php

/**
 * A widget to display Update Pass/Fail logs summary stats
 *
 * @author jovani
 */
class UpdateLogsWidget extends \CWidget
{
	/**
	* {@inheritdoc}
	*/
	public function run()
	{
		$total = TabsUpdateLog::model()->count('DATE(create_time) = :today', array(':today' => date('Y-m-d')));
		$pass = TabsUpdateLog::model()->count('DATE(create_time) = :today AND data_integrity_status = :pass', array(':pass' => TabsUpdateLog::STATUS_PASS, ':today' => date('Y-m-d')));
		$fail = TabsUpdateLog::model()->count('DATE(create_time) = :today AND data_integrity_status = :pass', array(':pass' => TabsUpdateLog::STATUS_FAIL, ':today' => date('Y-m-d')));
		$this->render('updateLogs', array(
			'total'    => $total,
			'pass'   => $pass,
			'fail' => $fail,
		));
	}
}