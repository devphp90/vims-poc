<?php

/**
 * A widget to display Import/Update Pass/Fail logs summary stats
 *
 * @author jovani
 */
class ImportLogsWidget extends \CWidget
{
	/**
	* {@inheritdoc}
	*/
	public function run()
	{
		$total = TabsImportLog::model()->count('DATE(create_time) = :today', array(':today' => date('Y-m-d')));
		$pass = TabsImportLog::model()->count('DATE(create_time) = :today AND download_sheet1_status = :pass', array(':pass' => TabsImportLog::STATUS_PASS, ':today' => date('Y-m-d')));
		$fail = TabsImportLog::model()->count('DATE(create_time) = :today AND download_sheet1_status = :pass', array(':pass' => TabsImportLog::STATUS_FAIL, ':today' => date('Y-m-d')));
		$this->render('importLogs', array(
			'total'    => $total,
			'pass'   => $pass,
			'fail' => $fail,
		));
	}
}