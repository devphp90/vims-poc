<?php

class SupplierController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/main';
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			'pdf' => array(
				'class'=>'application.controllers.export.pdf',
				'model'=>'Supplier',
			),

		);


	}

	public function actionFtpbrowser($id, $dir = '')
	{
		$this->layout = '//layouts/ajax';
		$dir = $dir? base64_decode($dir):'';
		$importModel = ImportRoutine::model()->findByPk($id);

		$ftp = new FtpHelper(str_replace('ftp://','',$importModel->ftp_server), $importModel->ftp_username, $importModel->ftp_password/* , $ssl=false, $port=21, $timeout=90 */);
		$ftp->connect();
		$directory = $ftp->listFiles($dir);
		$this->render('ftpbrowser',compact('importModel','directory','ftp','dir'));
	}

	public function actionStatusToggle($id)
	{
		$model = $this->loadModel($id);

		$model->active = $model->active^1;
		$model->save();
		// echo serialize($model->attributes);
		// echo $model->active;
		echo $model->active?"Active":"Inactive";

	}

	public function actionSupStat()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];
		$this->render('supstat',array(
			'model'=>$model,
		));
	}
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
				'actions'=>array('statusChangeInfo','create','update','admin','delete','pdf','autocompleteSup','autocompleteSupVsku','dashboard','ajaxStatus','supstat','importBound','statusToggle','ftpbrowser','index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionImportBound()
	{
		$model=new ImportRoutine;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportRoutine']))
		{
			$model->attributes=$_POST['ImportRoutine'];
			//if($model->save())
			//	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('importbound',array(
				'model'=>$model,
			));
	}

	public function actionAjaxStatus($id)
	{
		$model = $this->loadModel($id);

		if($model->active == 1){
			$model->active = 0;
			echo 'InActive';
		}else{
			$model->active = 1;
			echo 'Active';
		}

		$model->save(false);

	}

	public function actionDashboard()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];

		$this->render('dashboard',array(
			'model'=>$model,
		));
	}


	public function actionAutocompleteSup() {
		$res =array();

		if (isset($_GET['term'])) {
			// http://www.yiiframework.com/doc/guide/database.dao order by cast(name as char) asc, binary name desc;
			$qtxt ="SELECT name as name FROM {{supplier}} WHERE name LIKE :name order by cast(name as char) asc,binary name limit 10";
			$command =Yii::app()->db->createCommand($qtxt);
			$command->bindValue(":name", $_GET['term'].'%', PDO::PARAM_STR);
			$res =$command->queryColumn();
		}

		echo CJSON::encode($res);
		Yii::app()->end();
	}

  /**
   * sup_vsku autocomplete
   */
  public function actionAutocompleteSupVsku() {
    $res =array();

    if (isset($_GET['term'])) {
      // http://www.yiiframework.com/doc/guide/database.dao order by cast(name as char) asc, binary name desc;
      $qtxt ="SELECT sup_vsku as name FROM {{sup_inventory}} WHERE sup_vsku LIKE :name order by cast(name as char) asc,binary name limit 10";
      $command =Yii::app()->db->createCommand($qtxt);
      $command->bindValue(":name", $_GET['term'].'%', PDO::PARAM_STR);
      $res =$command->queryColumn();
    }

    echo CJSON::encode($res);
    Yii::app()->end();
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
		$model=new Supplier;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Supplier']))
		{
			$model->attributes=$_POST['Supplier'];
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
		$this->performAjaxValidation($model);

		if(isset($_POST['Supplier']))
		{
			$model->attributes=$_POST['Supplier'];
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
		$dataProvider=new CActiveDataProvider('Supplier');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];
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
		$model=Supplier::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  public function actionNavSteps()
  {
    $request = Yii::app()->request;

    $model = new NavSupplier;
    if ($supplier = Supplier::model()->findByPk($request->getQuery('id'))) {
      if (!$model = NavSupplier::model()->bySupplierId($supplier->id)->find()) {
        $model = new NavSupplier;
        $model->supplier_name = $supplier->name;
      }
    }

    if ($request->isPostRequest) {
      Yii::import('ext.simpletest.browser', true);
      $model->attributes = $request->getPOST('NavSupplier');
      $model->save();

      if ($request->getQuery('save-only'))
        Yii::app()->end();

      $browser = &new SimpleBrowser();
      $browser->get($model->url);

      if ($model->username && $model->password) {
        $browser->setField($model->username_label, $model->username);
        $browser->setField($model->password_label, $model->password);
        $browser->click($model->logon_label);
      }
      for ($i=2; $i<=10; $i++) {
        $step = "step{$i}_label";
        $clickableLink = $model->{$step};
        \Yii::log($clickableLink, CLogger::LEVEL_ERROR, __CLASS__);
        if ($clickableLink)
          $browser->click($clickableLink);
      }
      $link = $browser->getLink($model->download_link);
      if ($link == false)
        throw new CHttpException(404, 'Unable to browse link.');
      $downloadLink = $link->getScheme() . '://' . $link->getHost() . $link->getPath();
      Yii::log($downloadLink, CLogger::LEVEL_ERROR, __CLASS__);
      $uploadedFileName = md5($downloadLink.uniqid("test"));
      Yii::log($uploadedFileName, CLogger::LEVEL_ERROR, __CLASS__);
      $uploadedFilePath = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload'.DIRECTORY_SEPARATOR.$uploadedFileName;
      $result = file_put_contents($uploadedFilePath, fopen($downloadLink, 'r'));

      if ($result == false)
        throw new CHttpException(404, 'Unable to download file.');

      echo Yii::app()->getBaseUrl(true) . '/upload/' . $uploadedFileName;

      Yii::app()->end();
    } else {
      $this->render('navSteps', array('model' => $model));
    }
  }

  /**
   * Queries for the supplier id given name
   */
  public function actionQueryId()
  {
    $request = Yii::app()->request;
    $name = $request->getQuery('name');
    $model = Supplier::model()->findByAttributes(array('name' => $name));

    echo $model->id;
    Yii::app()->end();
  }

  /**
   * Renders info from {{supplier_status_change}}
   */
  public function actionStatusChangeInfo()
  {
    $req = Yii::app()->request;

    $id = $req->getQuery('id');
    $editOnly = $req->getQuery('edit-only');

    if ($req->isPostRequest) {
      $data = $req->getPost(SupplierStatusChange::className());
      $id = $data['supplier_id'];
    }

    if (($id && !$supplier = Supplier::model()->findByPk($id)) || !$id)
      throw new CHttpException(404, 'Supplier not found.');

    if (!$model = SupplierStatusChange::model()->bySupplierId($id)->find())
      $model = new SupplierStatusChange;

    $model->supplier_id = $id;
    $model->created_by = Yii::app()->user->id;
    $model->edit_only = $editOnly;

    if ($req->isPostRequest) {
      if (!$data['edit_only']) {
        $supplier->active = $supplier->active^1;
        $supplier->save();
      }

      $model->attributes = $req->getPost($model::className());
      $model->current_status = $supplier->active == Supplier::STATUS_ACTIVE ? SupplierStatusChange::STATUS_ACTIVE : SupplierStatusChange::STATUS_INACTVE;
      $model->save();
      echo json_encode(array('supplier_id' => $supplier->id, 'status' => ucfirst($model->current_status)));
      Yii::app()->end();
    }

    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
    Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
    Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
    Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
    Yii::app()->clientScript->scriptMap['bootstrap-combined.min.css'] = false;

    $this->renderPartial('_statusChangeInfo', array('model' => $model), false, true);
  }
}
