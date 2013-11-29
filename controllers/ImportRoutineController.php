<?php

class ImportRoutineController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('start','get','updateFile','import'),

				'ips'=>array('64.202.107.200','64.202.107.201','64.202.107.202','108.168.227.66','192.168.129.77','23.92.21.101','192.168.128.246','23.92.20.154','162.216.18.6'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('ajaxStatus','create','update','admin','delete','start','fetchColumn','ajaxsup','ajaxsheet','routineControl','get','manual','dashboard','importsheet','manualImport','importRoutine','updateroutine','getPartialSheet','testconnection','retrieveSheet','test','getimportUrl','getcsv','index','view','updateFile','newUpdateFile','import','triggleIU'),



				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionTest()
	{
		ignore_user_abort();
		set_time_limit(0);
		ini_set("memory_limit",-1);
		$pageSize=10000;
		$count = SupInventory::model()->count('sup_id=270');
		
		$page = ceil($count/$pageSize);
		
		for($i=0;$i<$page;$i++){
			
			$dataProvider_1=new CActiveDataProvider('SupInventory', array(
			    'criteria'=>array(
			    	'condition'=>'sup_id=270',
			    	'with'=>array(
			    		'supplier'=>array(
							'select'=>'id,name',
						),
						'ubs_inventory'=>array(
							'select'=>'id,sku',
						),
			    	),
			    ),
			    'pagination'=>array(
			        'pageSize'=>$pageSize,
			        'currentPage'=>$i,
			    ),
			    'totalItemCount'=>$count,
			));
	
			foreach($dataProvider_1->getData() as $id=>$vsheet):
				$vsheet->save();
			endforeach;
		}

/*
		$model = ImportVsheet::model()->with(array('supInventory'))->findByPk(53084);
		
		echo $model->id."<br/>";
		if($model->supInventory != null){
			var_dump( $model->supInventory->warehouseitem);
		}
		echo '<br/>';
		$supWareItem = SupWarehouseItem::model()->findByAttributes(array(
			'vims_id'=>$model->supInventory->id,
		));
		
		var_dump($supWareItem);
*/
		$this->render('test');
	}
	


	public function actionGetcsv($id, $delimiter, $qualifer)
	{
		$sheet = new GetOriginSheet($id);
		
		foreach($sheet->getData() as $id=>$data){
			echo implode("\t",str_getcsv($data, $delimiter, $qualifer))."<br/>";
			
		}
		
		
	}
	public function actionGetImportUrl($id)
	{
		echo ImportRoutine::model()->findByPk($id)->getImportModel()->import_file_url;
	}
	public function actionRetrieveSheet($id)
	{

		
		session_write_close();
		ignore_user_abort();
		set_time_limit(0);
		ini_set("memory_limit",-1);
		
		$importHelp = new Retrieve($id);
//		$importUrl = 'http://download.axeo.net/index.php/crontab/retrieveSheet?id='.$id;

//		echo $importUrl;
//		exec('wget --delete-after -q '.$importUrl.' > /dev/null ;');
		
	}
	
	public function actionTestconnection($ImportRoutine_id,
		$ImportRoutine_method_id,
		$ImportRoutine_ftp_server,
		$ImportRoutine_ftp_port,
		$ImportRoutine_ftp_username, 
		$ImportRoutine_ftp_password, 
		$ImportRoutine_http_url, 
		$ImportRoutine_http_username, $ImportRoutine_http_password)
	{
		$import = ImportRoutine::model()->findByPk($ImportRoutine_id);
		$import->method_id = $ImportRoutine_method_id;
		$import->ftp_server = $ImportRoutine_ftp_server;
		$import->ftp_port = $ImportRoutine_ftp_port;
		$import->ftp_username = $ImportRoutine_ftp_username;
		$import->ftp_password = $ImportRoutine_ftp_password;
		$import->http_url = $ImportRoutine_http_url;
		$import->http_username = $ImportRoutine_http_username;
		$import->http_password = $ImportRoutine_http_password;
		$import->save(false);

		switch($ImportRoutine_method_id){
		
			case 1:

				$import = ImportRoutine::model()->findByPk($ImportRoutine_id);
				$url = parse_url($ImportRoutine_ftp_server);

				$ip = gethostbyname($url['host']);
				if($ip == '108.168.227.66' && !preg_match("/axeo\.net$/", $url['host'])){
					echo 'Server not found';
					exit;
				}
				$file = $ImportRoutine_ftp_server.$import->ftp_path.'/'.$import->file_name;

				$curl = curl_init($file);

				curl_setopt($curl, CURLOPT_USERPWD, $ImportRoutine_ftp_username.':'.$ImportRoutine_ftp_password);
				//don't fetch the actual page, you only want headers
				curl_setopt($curl, CURLOPT_NOBODY, true);
				
				//stop it from outputting stuff to stdout
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

				$result = curl_exec($curl);
				$timestamp = curl_getinfo($curl);
				switch($timestamp['http_code']){
					case 0:
						echo 'Server Not Found.';
						exit;
						break;
					case 530:
						echo 'Invalid username/password';
						exit;
						break;
					case 350:
						echo 'Connection Success.';
						exit;
						break;
					case 257:
						echo 'File name is blank.';
						break;
				}
				
				break;
			case 3:
				$url = parse_url($ImportRoutine_http_url);
				$ImportRoutine_http_url = $url['scheme'].'://'.$ImportRoutine_http_username.':'.$ImportRoutine_http_password.'@'.$url['host'];
				$status = get_headers($ImportRoutine_http_url);

				if(!preg_match("/OK$/", $status[0])){
					echo 'Connection failed.';
					exit;
				}
					
				break;
			
		}
		echo 'Success.';
		exit;
		

		


		/*
var_dump(get_headers('http://google.com'));
		
		$file = $importRoutineModel->http_url.'/'.$this->_downloadName;

		$curl = curl_init($file);

		//don't fetch the actual page, you only want headers
		curl_setopt($curl, CURLOPT_NOBODY, true);
		
		//stop it from outputting stuff to stdout
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// attempt to retrieve the modification date
		curl_setopt($curl, CURLOPT_FILETIME, true);
		
		$result = curl_exec($curl);
		
		if ($result === false) {
		    die (curl_error($curl)); 
		}
		
		$timestamp = curl_getinfo($curl);

		var_dump($timestamp);
		
		
		echo $ImportRoutine_ftp_server;
*/
	}
	public function actionTriggleIU($id)
	{
		session_write_close();
		ignore_user_abort();
		set_time_limit(0);
		ini_set("memory_limit",-1);
		$tabsModel = Tabs::model()->findByPk($id);

		$importUrl = $this->createAbsoluteUrl("/importRoutine/get",array(
				'id'=>$tabsModel->import_routine_id,
				'id2'=>$tabsModel->import_routine_id_2,
			));

		$supplier = Supplier::model()->findByPk($tabsModel->supplier_id);
		if($supplier != null ) {
			if($supplier->setup_status =="I") {
				//Yii::app()->user->setFlash('error', 'Setup status is Incomplete.');
				//$this->redirect($this->createUrl('tabs/admin'));
				
			}
			if($tabsModel->importRoutine->sup_match_column <1){
				echo "<br><br><br><h3 style='color:red'>vSKU 1 should has integer > 0 in field1.</h3>";
				 echo '<br/><br/><br/><br/><br/><a href="#" onclick="window.close();">Close this window<a/>';
				 die();
					
				}
			$supplier->user_ran_iu = date('Y-m-d H:i:s');
			$supplier->save(false);
		}
		echo '<a href="'.$importUrl.'">Import Link(debug only)</a>';
		echo '<br/>';
		$updateUrl = $this->createUrl("/importRoutine/updateFile",array(
				'id'=>$tabsModel->import_routine_id,
			));
		
		

		$url = parse_url($tabsModel->importRoutine->import_server->update_url);
		$updateUrl = $url['scheme'].'://'.$url['host'].$this->createUrl("/importRoutine/updateFile",array(
			'id'=>$tabsModel->import_routine_id,
		));
		// --delete-after

		echo '<a href="'.$updateUrl.'">Update Link(debug only)</a>';
		$command = 'cd /tmp;wget --delete-after -q '.$importUrl.' > /dev/null ;';//.
       //     'wget --delete-after -q '.$updateUrl.' > /dev/null &';
		
		
		exec($command);

		echo $command;
		
	
		$backUrl = $this->createAbsoluteUrl("/tabs/admin",array());
		echo '<br/><br/><br/><br/><br/><a href="#" onclick="window.close();">Close this window<a/>';
	}


	public function actionImportRoutine()
	{
		$model=new ImportRoutine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportRoutine']))
			$model->attributes=$_GET['ImportRoutine'];

		$this->render('importroutine',array(
				'model'=>$model,
			));

	}

	public function actionUpdateRoutine()
	{
		$model=new ImportRoutine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportRoutine']))
			$model->attributes=$_GET['ImportRoutine'];

		$this->render('updateroutine',array(
				'model'=>$model,
			));

	}


	public function actionUpdateFile($id)
	{
		session_write_close();
		ignore_user_abort();
		set_time_limit(0);
		ini_set("memory_limit",-1);


		$model = Tabs::model()->findByAttributes(array(
				'import_routine_id'=>$id,
			));

		$update = new Update($model->id);

		$this->render('control');
	}


	public function actionManual($id)
	{
		$this->layout = 'ajax';
		$model = new ManualUpdateForm;

		$importroutine = ImportRoutine::model()->findByPk($id);


		if($importroutine->supplier->active == 0)
			throw new CHttpException(404,'The supplier is inactive.');

		$importroutineImport = $importroutine->getImportModel();
		$session = md5($importroutine->file_name.rand());
		$name = $importroutine->id.'-'.$session.'-'.$importroutine->file_name;
		$filename = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload'.DIRECTORY_SEPARATOR.$name;


		if($importroutine == null)
			throw new CHttpException(404,'The requested page does not exist.');


		if(!empty($_FILES['ManualUpdateForm']['tmp_name']['file'])){
			var_dump($_FILES['ManualUpdateForm']);
			$data = array();
			if($_FILES['ManualUpdateForm']['type']['file'] == 'text/csv'){
				$delimiter = empty($importroutine->delimiter)?',':$importroutine->delimiter;
				$enclosure = empty($importroutine->enclosure)?'':$importroutine->enclosure;

				if($delimiter == '\t')
					$delimiter = "\t";

				if (($handle = fopen($this->_importFile, "r")) !== FALSE)
					while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE)
						$data[] = $row;
					fclose($handle);
			}else if($_FILES['ManualUpdateForm']['type']['file'] == 'application/vnd.ms-excel' ||
					$_FILES['ManualUpdateForm']['type']['file'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
					Yii::import('application.vendors.PHPExcel',true);

					$objPHPExcel = PHPExcel_IOFactory::load($_FILES['ManualUpdateForm']['tmp_name']['file']);
					$objWorksheet = $objPHPExcel->getActiveSheet();
					foreach ($objWorksheet->getRowIterator() as $row_id=>$row){
						foreach ($row->getCellIterator() as $cell_id=>$cell)
							$column[$cell_id] = trim($cell->getValue());
						$data[] = $column;
					}

				}else{
				throw new CHttpException(400,'File type not supported');
			}

			$update = new PartialUpdate($id,$data);
			$update->run();


			echo 'update success';
			exit;

		}
		$this->render('manual',compact('model'));
	}


	public function actionRoutineControl()
	{


		$this->render('control',array(

			));
	}
	public function actionAjaxSheet($sup_id,$file_id,$id)
	{
		$result = array();
		$result['duplicate'] = true;

		$model = ImportRoutine::model()->count('sup_id=? and file_id=? and id!=?',array($sup_id,$file_id,$id));

		if($model > 0){
			$result['duplicate'] = true;

		}else{
			$result['duplicate'] = false;

		}
		echo CJSON::encode($result);

	}
	public function actionAjaxsup($sup_id,$id)
	{

		$result = array();
		$result['duplicate'] = true;

		$model = ImportRoutine::model()->count('sup_id=? and id!=?',array($sup_id,$id));

		if($model > 0){
			$result['duplicate'] = true;

		}else{
			$result['duplicate'] = false;

		}
		echo CJSON::encode($result);

	}


	public function actionImport($id,$importSheet2)
	{
		session_write_close();
		ignore_user_abort();
		set_time_limit(0);
		ini_set("memory_limit",-1);


		echo '123';
		$import = new Import($id, $importSheet2);

		//  $tabs = Tabs::model()->findByAttributes(array('import_routine_id'=>$id));

		//  if($tabs != null)
		//   $import = new ImportSheet2($tabs->import_routine_id_2, $session);


	}

	public function actionGetPartialSheet($id)
	{
		$sheet = ImportRoutine::model()->findByPk($id);
		
		if($sheet != null){
			$rows = unserialize(base64_decode($sheet->{'8rows'}))?unserialize(base64_decode($sheet->{'8rows'})):array();
			echo '<table class="table table-bordered" style="border-spacing:0px;">';
			
			foreach($rows as $id=>$value){
				echo '<tr >';
				foreach($value as $id2=>$value2){
	
					echo '<td style="padding:10px 5px;width:auto;">';

					if($id==0){
						echo '<span :sheet_field='.$value2.' :sheet_num='.($id2+1).' style="padding:10px 0px;" class="draggable">';
						echo substr($value2,0,14);
						echo '<span>';	
					}else{
						if(strlen($value2)>16)
							echo '<a class="toolong" title="'.CHtml::encode($value2).'" href="#" data-toggle="tooltip">'.substr($value2,0,16).'</a>';
						else
							echo $value2;
					}

						
					
					echo '</td>';
				}
	
				
				echo '<tr>';
			}
			echo '</table>';
			echo '<script>$(".toolong").tooltip();$(function(){$( ".draggable" ).draggable({ revert: "valid" });});</script>';
		}
		
		//var_dump($sheet->getSheet());
	}

	public function actionImportSheet($id)
	{
		$sheet = new GetImportSheet($id);


		$this->renderPartial('importsheet',array('column'=> unserialize($sheet->getColumn())),0,0);

	}

	public function actionFetchColumn($id)
	{

		$model=$this->loadModel($id);
		$column = array();
		$column = unserialize(base64_decode($model->fetch_column));

		if($_POST['yt0']){
			if(!empty($_FILES['file']['tmp_name'])){
				//   var_dump($_FILES);
				$model=$this->loadModel($id);
				$file_id = 1;


				Yii::import('application.vendors.PHPExcel',true);


				if($_FILES['file']['type'] == 'text/csv'){

					if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
						$column = fgetcsv($handle, 1000, ",");
					}

				}else if($_FILES['file']['type'] == 'application/vnd.ms-excel' ||
						$_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){

						$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
						$objWorksheet = $objPHPExcel->getActiveSheet();
						foreach ($objWorksheet->getRowIterator() as $row_id=>$row){


							foreach ($row->getCellIterator() as $cell_id=>$cell)
								$column[$cell_id] = trim($cell->getValue());
							break;
						}
						$file_id = 3;

					}else{
					throw new CHttpException(400,'File type not supported');
				}

				$model->file_id = $file_id;
				$model->file_name = $_FILES['file']['name'];
				$model->fetch_column = base64_encode(serialize($column));
				$model->save();


			}
		}

		if($_POST['yt1']){

			echo '123';
			exit;
		}
		$this->renderPartial('fetchcolumn',array(
				'model'=>$model,
				'column'=>$column,
			),0,1);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ImportRoutine;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportRoutine']))
		{
			$model->attributes=$_POST['ImportRoutine'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
				'model'=>$model,
			));
	}



	public function actionGet($id,$id2)
	{
		$model = $this->loadModel($id);
		$url = $model->import_server->domain.'/index.php/crontab/get?id='.$model->id.'&id2='.$id2;
		$this->redirect($url);

	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportRoutine']))
		{
			$model->attributes=$_POST['ImportRoutine'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
				'model'=>$model,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ImportRoutine');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
	}

	/**
	 * Manages all models.
	 */
	public function actionDashboard()
	{
		$model=new ImportRoutine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportRoutine']))
			$model->attributes=$_GET['ImportRoutine'];

		$this->render('dashboard',array(
				'model'=>$model,
			));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ImportRoutine('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportRoutine']))
			$model->attributes=$_GET['ImportRoutine'];

		$this->render('admin',array(
				'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ImportRoutine::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionAjaxStatus($id)
	{
		$model = $this->loadModel($id);
		if(empty($model->frequency)){
			$model->status = 0;
			echo 'Off';
			$model->save();
			exit;
		}

		if($model->status == 1){
			$model->status = 0;
			echo 'Off';
		}else{
			$model->status = 1;
			if($model->supplier->active == 0){
				echo 'Off (sup inactive)';
				$model->status=0;
			}else
				echo 'On';
		}

		$model->save();

	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-routine4-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
