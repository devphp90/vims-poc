<?php

class ImportMarkupController extends Controller
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
				'actions'=>array('create','update','admin','delete','index','view', 'statusToggle','updateAll'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdateAll()
	{
		$command = Yii::app()->db->createCommand('UPDATE `vims_ubs_inventory` as t1 SET t1.gmarkup_c = NULL, t1.smarkup_c = NULL, t1.smarkupbreak_c = 0, markup_c = 0, markupprice_c = 0;');
		$command->execute();
		
		$command = Yii::app()->db->createCommand("UPDATE `vims_ubs_inventory` as t1, (SELECT `from`,`to`, `markup`, `type` from  `vims_import_markup` where STATUS =1) as t2 SET t1.gmarkup_c = concat(t2.markup, if(t2.type, '%', '$')) where t1.vprice >= t2.`from` AND t1.vprice <=  t2.`to`;");
		$command->execute();
		
		$command = Yii::app()->db->createCommand("UPDATE `vims_ubs_inventory` as t1, (SELECT `from`,`to`, `markup`, `type`, `sup_id`, `break_map` from  `vims_import_sup_markup` where STATUS =1) as t2 SET t1.smarkup_c = concat(t2.markup, if(t2.type, '%', '$')), t1.smarkupbreak_c = t2.break_map where t1.vprice >= t2.`from` AND t1.vprice <=  t2.`to` and t1.`primary_supplier_c` = t2.`sup_id`");
		$command->execute();
		
		$command = Yii::app()->db->createCommand("UPDATE `vims_ubs_inventory` SET `applymarkup_c` = CASE WHEN `smarkup_c` is not null THEN `smarkup_c` ELSE `gmarkup_c` END, `markup_c` =  ROUND(IF( RIGHT( applymarkup_c, 1 ) =  '%',  (
REPLACE( applymarkup_c, RIGHT( applymarkup_c, 1 ) ,  '' ) * 0.01 +1 ) * vprice , REPLACE( applymarkup_c, RIGHT( applymarkup_c, 1 ) ,  '' ) + vprice), 2 ),
markupprice_c = if(smarkupbreak_c,markup_c, if(markup_c > primary_supplier_map_c,primary_supplier_map_c, markup_c))");
		$command->execute();
	
		
		$this->redirect('admin');
/* 	UPDATE `vims_ubs_inventory` as t1 SET t1.gmarkup_c = NULL, t1.smarkup_c = NULL, t1.smarkupbreak_c = 0 where primary_supplier_c = 40;	 */

/* 	UPDATE `vims_ubs_inventory` as t1, (SELECT `from`,`to`, `markup`, `type` from  `vims_import_markup` where STATUS =1) as t2 SET t1.gmarkup_c = concat(t2.markup, if(t2.type, '%', '$')) where t1.vprice >= t2.`from` AND t1.vprice <=  t2.`to` and t1.primary_supplier_c = 40;	 */

/* 	UPDATE `vims_ubs_inventory` as t1, (SELECT `from`,`to`, `markup`, `type`, `sup_id`, `break_map` from  `vims_import_sup_markup` where STATUS =1) as t2 SET t1.smarkup_c = concat(t2.markup, if(t2.type, '%', '$')), t1.smarkupbreak_c = t2.break_map where t1.vprice >= t2.`from` AND t1.vprice <=  t2.`to` and t1.`primary_supplier_c` = t2.`sup_id` and t2.sup_id = 40;	 */
/* UPDATE `vims_ubs_inventory` SET `applymarkup_c` = CASE WHEN `smarkup_c` is not null THEN `smarkup_c` ELSE `gmarkup_c` END, `markup_c` =  ROUND(IF( RIGHT( applymarkup_c, 1 ) =  '%',  (
REPLACE( applymarkup_c, RIGHT( applymarkup_c, 1 ) ,  '' ) * 0.01 +1 ) * vprice , REPLACE( applymarkup_c, RIGHT( applymarkup_c, 1 ) ,  '' ) + vprice), 2 ),
markupprice_c = if(smarkupbreak_c,markup_c, if(markup_c > primary_supplier_map_c,primary_supplier_map_c, markup_c))

 where primary_supplier_c = 40	 */

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
		$model=new ImportMarkup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportMarkup']))
		{
			$model->attributes=$_POST['ImportMarkup'];
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

		if(isset($_POST['ImportMarkup']))
		{
			$model->attributes=$_POST['ImportMarkup'];
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
		$dataProvider=new CActiveDataProvider('ImportMarkup');
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

		$model=new ImportMarkup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportMarkup']))
			$model->attributes=$_GET['ImportMarkup'];

    if ($status = $r->getQuery('status')) {
      ImportMarkup::model()->updateAll(array('status' => $status == 'ON' ? 1 : 0));
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
		$model=ImportMarkup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-markup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
