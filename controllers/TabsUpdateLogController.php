<?php

class TabsUpdateLogController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','logview','supdelall','supreset','admin','delete','failroutine','index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSupdelall($id)
	{
		TabsUpdateLog::model()->deleteAll('tabs_id=?',array($id));
			
		$this->redirect(array('logview','id'=>$id));
		
	}
	public function actionSupreset($id)
	{
		ImportRoutineUpdate::model()->deleteAll('import_id=?',array($id));
		$model = Tabs::model()->findByPk($id);
		
		$model->instock_item = 0;
		$model->save(false);
		$command = Yii::app()->db->createCommand();
		$command->delete('vims_import_vsheet_last', 'import_id=:import_id', array(':import_id'=>$model->import_routine_id));	
		$this->redirect(array('logview','id'=>$id));
		
	}
	public function actionLogview($id)
	{
		$model=new TabsUpdateLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TabsUpdateLog']))
			$model->attributes=$_GET['TabsUpdateLog'];

		$this->render('logview',array(
			'model'=>$model,
			'tabs_id'=>$id,
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
		$model=new TabsUpdateLog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TabsUpdateLog']))
		{
			$model->attributes=$_POST['TabsUpdateLog'];
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

		if(isset($_POST['TabsUpdateLog']))
		{
			$model->attributes=$_POST['TabsUpdateLog'];
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
		$dataProvider=new CActiveDataProvider('TabsUpdateLog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TabsUpdateLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TabsUpdateLog']))
			$model->attributes=$_GET['TabsUpdateLog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionFailroutine()
	{
		$model=new TabsUpdateLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TabsUpdateLog']))
			$model->attributes=$_GET['TabsUpdateLog'];

		$this->render('failroutine',array(
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
		$model=TabsUpdateLog::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tabs-update-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
