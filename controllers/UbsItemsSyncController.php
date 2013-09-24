<?php

class UbsItemsSyncController extends Controller
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
				'actions'=>array('create','update', 'index', 'view', 'delete', 'importCSV', 'deleteAll', 'sync'),
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
		$model=new UbsItemsSync;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UbsItemsSync']))
		{
			$model->attributes=$_POST['UbsItemsSync'];
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

		if(isset($_POST['UbsItemsSync']))
		{
			$model->attributes=$_POST['UbsItemsSync'];
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new UbsItemsSync('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UbsItemsSync']))
			$model->attributes=$_GET['UbsItemsSync'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

    /**
     * import csv file from external server
     */
    public function actionImportCSV() {

        //session_write_close();

		ignore_user_abort();

		set_time_limit(0);

		ini_set("memory_limit",-1);

        $model = new UbsItemsSync();

        $row = 1;
        if (($handle = fopen(Yii::app()->basePath."/../ubs_skus.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $model->isNewRecord = true;
                $model->primaryKey = Null;

                if ($row != 1) {
                    $model->sku = $data[0];
                    $model->name = $data[1];
                    $model->sale_price = $data[2];
                    $model->manufacturer = $data[3];
                    $model->manufacturer_part_number = $data[4];
                    $model->upc = $data[5];
                    $model->our_cost = $data[6];
                    $model->save(false);

                    /*for ($c=0; $c < $num; $c++) {
                        echo $data[$c] . "<br />\n";
                    }*/
                }

                $row++;
            }
            fclose($handle);
            echo 'Import success';die();
        } else
        {
            die('The file is not readable');
        }
    }

    /**
     * delete all records from database
     */
    public function actionDeleteAll() {
        UbsItemsSync::model()->deleteAll();

        $this->redirect(array('index'));
    }

    /**
     * sync from UBsItemsSync => Ubs Inventory
     */
    public function actionSync() {

		set_time_limit(0);

		ini_set("memory_limit",-1);
		
		session_write_close();

		$pageSize = 1000;
		$criteria = new CDbCriteria;
		$criteria->select = '1';
		$criteria->condition = 't.sku NOT IN (SELECT z.sku FROM vims_ubs_inventory as z)';
		$newCount = 0;
        $updateCount = 0;

		$dataProvider=new CActiveDataProvider('UbsItemsSync', array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>$pageSize,
		    ),
		));

		$dataProvider->getData();
		$inventory_model = new UbsInventory;
		$pageCount = $dataProvider->pagination->pageCount;
//		$pageCount = 1;//remove this
		for($i=0;$i<$pageCount;$i++){

			$dataProvider_1=new CActiveDataProvider('UbsItemsSync', array(
			    'criteria'=>array(
			    	'with'=>array('ubs_inventory'),
			    	'condition'=>'t.sku NOT IN (SELECT z.sku FROM vims_ubs_inventory as z)',
			    ),
			    'pagination'=>array(
			    	'pageSize'=>$pageSize,
			    	'currentPage'=>$i,
			    ),
			));

			foreach($dataProvider_1->getData() as $id=>$data):

//				$model = UbsInventory::model()->find('sku=:SKU', array(':SKU' => $data->sku));
//				echo $model->sku;
				if($data->ubs_inventory == null){
				
					$inventory_model->isNewRecord = true;
                    $inventory_model->primaryKey = NULL;
                    $inventory_model->sku = $data->sku;
                    $inventory_model->sku_name = $data->name;
                    $inventory_model->mfg_title = $data->manufacturer;
                    $inventory_model->mfg_name = $data->manufacturer_part_number;
                    $inventory_model->upc = $data->upc;
                    $inventory_model->price = $data->our_cost;
                    $inventory_model->create_time = new CDbExpression('NOW()');
                    $inventory_model->update_time = new CDbExpression('NOW()');

                    if ($inventory_model->save(false)){
                       echo $id.' - '.$data->sku.' - '.$model->id.' Created.';
                       $newCount++;
                        
                    }
					
				}else
					$updateCount++;	                    

            echo '<br/>';
			endforeach;
              echo $pageCount*$pageSize.' done'.'<br/>';
		}
		echo "{$newCount} new Record Inserted and {$updateCount} record skipped. In ".Yii::getLogger()->getExecutionTime()."seconds";


    }


    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=UbsItemsSync::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ubs-items-sync-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
