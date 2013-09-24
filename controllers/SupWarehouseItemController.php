<?php

class SupWarehouseItemController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete','ajaxItem','index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAjaxItem($id)
	{
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
		Yii::app()->clientScript->scriptMap['pager.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-combined.min.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		$this->layout = 'ajax';
		$criteria=new CDbCriteria;
		
		$criteria->condition = 'vims_id = :vims_id';
		
		$criteria->params = array(
			':vims_id'=>$id,
		);
		

		$dataProvider = new CActiveDataProvider('SupWarehouseItem', array(
			'criteria'=>$criteria,
		));
		$this->renderPartial('_ajaxitem',array(
			'dataProvider'=>$dataProvider,
			'id'=>$id,
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
	public function actionCreate($id)
	{

		$supInventory = SupInventory::model()->findByPk($id);

		if($supInventory == null)
			throw new CHttpException(404,'The requested page does not exist.');
		$model=new SupWarehouseItem;
		$model->vims_id = $id;

		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SupWarehouseItem']))
		{
			$model->attributes=$_POST['SupWarehouseItem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'sup_id'=>$sup_id,
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

		if(isset($_POST['SupWarehouseItem']))
		{
			$model->attributes=$_POST['SupWarehouseItem'];
			if($model->save())
				$this->redirect(array('/supInventory/admin'));
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
		$dataProvider=new CActiveDataProvider('SupWarehouseItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SupWarehouseItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupWarehouseItem']))
			$model->attributes=$_GET['SupWarehouseItem'];

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
		$model=SupWarehouseItem::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sup-warehouse-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
