<?php
class pdf extends CAction
{
	public $model;
	public function run()
	{
		echo '123';
		echo $this->model;
		Yii::import('application.vendors.*');
		require_once('tcpdf/tcpdf.php');
		require_once('tcpdf/config/lang/eng.php');
		
		$dataProvider = new CActiveDataProvider($this->model);
		$html = Yii::app()->controller->renderPartial('/export/pdfreport', array(
				'dataProvider'=>$dataProvider
			), true);
		
	}


}
?>