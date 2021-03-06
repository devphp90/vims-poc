<?php

class ImportSupMarkupController extends Controller
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
				'actions'=>array('create','update','admin','delete','index','view', 'statusToggle'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
		$model=new ImportSupMarkup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportSupMarkup']))
		{
			$model->attributes=$_POST['ImportSupMarkup'];
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

		if(isset($_POST['ImportSupMarkup']))
		{
			$model->attributes=$_POST['ImportSupMarkup'];
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
		$dataProvider=new CActiveDataProvider('ImportSupMarkup');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$r = Yii::app()->getRequest();
		// we can check whether is comming from a specific grid id too
		// avoided for the sake of the example
		if($r->getParam('editable'))
		{
			$model = $this->loadModel($r->getParam('id'));
			$attribute = $r->getParam('attribute');
			$model->$attribute = $r->getParam('value');
			if($model->save())
				echo $r->getParam('value');
			else
				echo 'Error occur!';
				// echo serialize($model->errors);
			Yii::app()->end();
		}

		$model=new ImportSupMarkup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportSupMarkup']))
			$model->attributes=$_GET['ImportSupMarkup'];

		if ($status = $r->getQuery('status')) {
			ImportSupMarkup::model()->updateAll(array('status' => $status == 'ON' ? 1 : 0));
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * For in grid status toggle
	 */
	public function actionStatusToggle($id)
	{
    if (Yii::app()->request->isAjaxRequest) {
        $model = $this->loadModel($id);
        $model->status = $model->status^1;
        $model->save();
        echo $model->status?"On":"Off";
        Yii::app()->end();
    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ImportSupMarkup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-sup-markup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
