<?php

class SupNewItemController extends Controller
{
	public $tempCounter = 1;
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
				'actions'=>array('update','admin','delete','deleteAll','import','newitemlink','updateMatch','nomatchitem','importedItem','updateStatus','importpage','supchecker','groupsupchecker','calculate','updatePageY','index','view','updatePageN'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionGroupSupChecker($supid)
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

		$this->render('groupsupchecker',array(
			'model'=>$model,
			'supid'=>$supid,
		));
		
	}
	
	public function actionCalculate()
	{
		$time =  time();
		$models = SupNewItem::model()->findAll(array(
			'offset'=>'66000',
			'limit'=>'3000',
			
		));
		
		foreach($models as $id=>$model){
			$model->save(false);
		}
		echo time()-$time;
	}
	public function actionSupChecker($supid)
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

		$this->render('supchecker',array(
			'model'=>$model,
			'supid'=>$supid,
		));
		
	}
	
	
	public function actionUpdateStatus($id,$value)
	{
		$newModel = SupNewItem::model()->findByPk($id);
		$newModel->item_status = $value;
		$newModel->save();
		
	}
	
	public function actionUpdatePageY($checkers)
	{
		$checkers = explode(',',rtrim($checkers,','));
		foreach($checkers as $value){
			$newModel = SupNewItem::model()->findByPk($value);
			$newModel->match = 1;
			$newModel->save(false);
		}
	}
	
	public function actionUpdatePageN($checkers)
	{
		$checkers = explode(',',rtrim($checkers,','));
		foreach($checkers as $value){
			$newModel = SupNewItem::model()->findByPk($value);
			$newModel->match = 0;
			$newModel->save(false);
		}
	}
	
	public function actionUpdateMatch($id,$value)
	{
		$newModel = SupNewItem::model()->findByPk($id);
		$newModel->match = $value;
		$newModel->save();
		
	}
	
	
	public function actionDeleteAll($id)
	{
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('vims_sup_newitem');
		$this->redirect(array('supChecker','supid'=>$id));
	}
	
	
	public function actionNewItemLink()
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

		$this->render('newitemlink',array(
			'model'=>$model,
		));
		
	}
	
	public function actionNoMatchItem()
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

		$this->render('nomatchitem',array(
			'model'=>$model,
		));
		
	}
	
	public function actionImportedItem()
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

		$this->render('importeditem',array(
			'model'=>$model,
		));
		
	}
	
	public function actionImportpage($checkers)
	{
		session_write_close();
		

		   // Do some time-expensive stuff here...
		   	echo '<h1>New Items Transfer Status</h1><pre>';
			echo "id\t\tStatus\t\tReason\n";
			echo "-------------------------------------\n";

			$checkers = explode(',',rtrim($checkers,','));

			$modelAll = SupNewItem::model()->findAllByAttributes(array('id'=>$checkers));
			$i=1;
			foreach($modelAll as $id=>$newModel){
				


				$model = new SupInventory;
				//$model->ubs_id = $newModel->ubsinventory->id;
				$model->ubs_sku = $newModel->ubsinventory->sku;
				$model->sup_id = $newModel->import_routine->sup_id;
				$model->supplier_name = Supplier::model()->findByPk($model->sup_id)->name;
				$model->sup_vsku = $newModel->sup_vsku;
				$model->mfg_sku = $newModel->mfg_sku;
				$model->mfg_upc = $newModel->upc;
				$model->mfg_name = $newModel->mfg_name;
				$model->mfg_sku_name = $newModel->mfg_part_name;
				$model->sup_sku = $newModel->sup_sku;
				$model->sup_sku_name = $newModel->sup_sku_name;
				$model->sup_description = $newModel->sup_description;
				$model->sup_status = 1;
				$model->sup_price = $newModel->sup_price;

        // No Match
				if($newModel->match == 0){
					$newModel->item_status = 2;
					if($newModel->save())
						printf("%d\t\t%s\t\t%s",$newModel->id,"success",'Transferred to No Match table.');
					else
						printf("%d\t\t%s\t\t%s",$newModel->id,"<font color='red'>Failed</font>",'Item remain!');
				}else if($newModel->match == 1){
					// Matched
					if($model->save()){
						$newModel->item_status = 1;
						//if($newModel->save())
						if($newModel->delete())
							printf("%d\t\t%s\t\t%s",$newModel->id,"Success",'Imported, Item deleted!');
						else
							echo 'fatal error';
					}else{
						$error = '';
						foreach($model->getErrors() as $attribute=>$reason)
							$error .= $i++.'. '.$attribute.' => '.implode(',', $reason).'     ';
						printf("%d\t\t%s\t\t%s",$newModel->id,"<font color='red'>Failed</font>",$error);
					}
					
				}

				echo '<br/>';
			}
		 
		   // and after that release the lock...
		  
		
	}
	
	public function actionImport()
	{

		session_write_close();

		   // Do some time-expensive stuff here...
		   	echo '<h1>New Items Transfer Status</h1><pre>';
			echo "id\t\tStatus\t\tReason\n";
			echo "-------------------------------------\n";
			$modelAll = SupNewItem::model()->findAll(array(
				'condition'=>'item_status=0 and `match`!=2',
			));
			$i = 1;
			foreach($modelAll as $id=>$newModel){

				$model = new SupInventory;
				//$model->ubs_id = $newModel->ubsinventory->id;
				$model->ubs_sku = $newModel->ubsinventory->sku;
				$model->sup_id = $newModel->import_routine->sup_id;
				$model->supplier_name = Supplier::model()->findByPk($model->sup_id)->name;
				$model->sup_vsku = $newModel->sup_vsku;
				$model->mfg_sku = $newModel->mfg_sku;
				$model->mfg_upc = $newModel->upc;
				$model->mfg_name = $newModel->mfg_name;
				$model->mfg_sku_name = $newModel->mfg_part_name;
				$model->sup_sku = $newModel->sup_sku;
				$model->sup_sku_name = $newModel->sup_sku_name;
				$model->sup_description = $newModel->sup_description;
				$model->sup_status = 1;
				$model->sup_price = $newModel->sup_price;
				if($newModel->match == 0){
					$newModel->item_status = 2;
					if($newModel->save())
						printf("%d\t\t%s\t\t%s",$newModel->id,"success",'No Import!');
					else
						printf("%d\t\t%s\t\t%s",$newModel->id,"<font color='red'>Failed</font>",'Item remain!');
				}else if($newModel->match == 1){
					
					if($model->save()){
						$newModel->item_status = 1;
						if($newModel->save())
							printf("%d\t\t%s\t\t%s",$newModel->id,"Success",'Imported, Item deleted!');

					}else{
						$error = '';
						foreach($model->getErrors() as $attribute=>$reason)
							$error .= $i++.'. '.$attribute.' => '.implode(',', $reason).'     ';
						printf("%d\t\t%s\t\t%s",$newModel->id,"<font color='red'>Failed</font>",$error);
					}
					
				}
				echo '<br/>';
			}
		 

		
		echo '<a href="newItemLink">Back to Checkers<a/>';
		//$this->redirect('newItemLink');

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
		$model=new SupNewItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SupNewItem']))
		{
			$model->attributes=$_POST['SupNewItem'];
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

		if(isset($_POST['SupNewItem']))
		{
			$model->attributes=$_POST['SupNewItem'];
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
		$dataProvider=new CActiveDataProvider('SupNewItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SupNewItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupNewItem']))
			$model->attributes=$_GET['SupNewItem'];

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
		$model=SupNewItem::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sup-new-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
