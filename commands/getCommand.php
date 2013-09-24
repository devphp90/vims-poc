<?php

class GetCommand extends CConsoleCommand {



	public function actionGet($option,$frequency,$server_id){
		session_write_close(); 
		set_time_limit(0);
		
		file_get_contents( 'http://localhost:61380/vims/index.php/importRoutine4/start?option='.$option.'&frequency='.$frequency);
		$model = ImportRoutine::model()->findByAttributes(array(
			't.status'=>1,
			'frequency_option'=>$option
			'frequency'=>$frequency
		);
		
		foreach($model as $importRoutine){
			echo '123';
			
		}
		//0 = hour
		//1 = day
		//2 = Min
		return 1;
	}

}

?>