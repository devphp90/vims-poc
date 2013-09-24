<?php

class WizardsController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','delete','wizard','update','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionWizard($id)
	{
		

		$warehouseModel = new SupWarehouse;
		
		$model = $this->loadModel($id);
		if($model !== NULL){
		   $data = unserialize($model->data);
		}else
			$model = new Wizards;
		
		
		$supplierModel = Supplier::model()->findByPk($model->sup_id);
		if($supplierModel == null){
			$supplierModel = new Supplier;
			$supplierModel->attributes = $data['supplier'];
		}
		
		$importroutineModel = ImportRoutine::model()->findByPk($model->importroutine_id);
		if($importroutineModel == null){
			$importroutineModel = new ImportRoutine;
			$importroutineModel->attributes = $data['importroutine'];
		}
		
		$warehouseModel->wizardMultiWarehouse = $data['warehouse'];
		
		for($i=1;$i<=6;$i++){
			$supwarehouseModel = SupWarehouse::model()->findByPk($model->{'ware_'.$i});
			if($supwarehouseModel != null){
					$warehouseModel->wizardMultiWarehouse[$i][1] = $supwarehouseModel->name;
					$warehouseModel->wizardMultiWarehouse[$i][2] = $supwarehouseModel->state;
	
			}
			
		}

		if(isset($_POST['yt0'])){

			$supplierModel->attributes = $_POST['Supplier'];
			if($supplierModel->save()){
				$message = 'Supplier Record Saved!';
				$model->sup_id = $supplierModel->id;
				$model->save();
			}
		}
		
		if(isset($_POST['yt1'])){
			$message = 'Supplier Warehouse Record Saved!';	
			$warehouseModel->wizardMultiWarehouse = $_POST['ware'];
			if(!$supplierModel->isNewRecord){
				foreach($_POST['ware'] as $id=>$warehouse){
					if(!empty($warehouse[1])){
						$supWarehouseModel = new SupWarehouse;
						$supWarehouseModel->sup_id = $supplierModel->id;
						$supWarehouseModel->name = $warehouse[1];
						$supWarehouseModel->state = $warehouse[2];
						if($supWarehouseModel->save())
							$model->{'ware_'.$id} = $supWarehouseModel->id;
					}
				}
				$model->save();
			}else
				$message = 'Supplier Warehouse Record Save Failed!';	
		}
		
		if(isset($_POST['yt2']) || isset($_POST['yt3']) || isset($_POST['yt4']) || isset($_POST['yt5'])){
			$importroutineModel->supplier_name = $supplierModel->name;
			$importroutineModel->attributes = $_POST['ImportRoutine'];

			if($importroutineModel->validate() && !$supplierModel->isNewRecord){
				
//				$importroutineModel->sup_id = $supplierModel->id;
				
				if($importroutineModel->save()){

					$message = 'Import Routine Record Saved!';		
					
				}
				$model->importroutine_id = $importroutineModel->id;
				$model->save();
			}else
				$message = 'Import Routine Record Save Failed!';	
		}
		
		
		if(isset($_POST['yt5'])){
			$supplierModel->attributes = $_POST['Supplier'];
			$importroutineModel->attributes = $_POST['ImportRoutine'];

			if($supplierModel->validate() && $importroutineModel->validate()){

				$data = array(
					'supplier'=>$_POST['Supplier'],
					'importroutine'=>$_POST['ImportRoutine'],
					'warehouse'=>$_POST['ware'],
				);
				$model->data = serialize($data);
				$model->data_md5 = md5($model->data);
				$model->save();
				
			}
			
		}

		$this->render('wizard',compact(
			'message',
			'supplierModel',
			'importroutineModel',
			'warehouseModel'
		));
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

		$model=new Wizards;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wizards']))
		{
			$model->attributes=$_POST['Wizards'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Wizards']))
		{
			$model->attributes=$_POST['Wizards'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Wizards');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Wizards('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Wizards']))
			$model->attributes=$_GET['Wizards'];

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
		$model=Wizards::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wizards-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
