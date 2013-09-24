<?php

class SupItemsSyncController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array('create', 'update', 'index', 'view', 'delete', 'import','deleteAll','sync'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SupItemsSync;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SupItemsSync'])) {
            $model->attributes = $_POST['SupItemsSync'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SupItemsSync'])) {
            $model->attributes = $_POST['SupItemsSync'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
	/**
     * delete all records from database
     */
    public function actionDeleteAll() {
        SupItemsSync::model()->deleteAll();

        $this->redirect(array('index'));
    }
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new SupItemsSync('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SupItemsSync']))
            $model->attributes = $_GET['SupItemsSync'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SupItemsSync('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SupItemsSync']))
            $model->attributes = $_GET['SupItemsSync'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = SupItemsSync::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sup-items-sync-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

	public function actionSync() {

		set_time_limit(0);

		ini_set("memory_limit",-1);
		
		session_write_close();

		$pageSize = 1000;
		$criteria = new CDbCriteria;
		$criteria->select = '1';
		$newCount = 0;
        $updateCount = 0;

		$dataProvider=new CActiveDataProvider('SupItemsSync', array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>$pageSize,
		    ),
		));

		$dataProvider->getData();
		
		
		$pageCount = $dataProvider->pagination->pageCount;
		//	$pageCount = 1;//remove this
		for($i=0;$i<$pageCount;$i++){


			$dataProvider_1=new CActiveDataProvider('SupItemsSync', array(
			    'pagination'=>array(
			    	'pageSize'=>$pageSize,
			    	'currentPage'=>$i,
			    ),
			));

			foreach($dataProvider_1->getData() as $id=>$data):
				$model = SupInventory::model()->findByAttributes(array(
					'sup_id'=>$data['sup_id'],
					'sup_vsku'=>$data['sup_vsku']
				));
				if($model == null){
					$inventory_model = new SupInventory;
					$inventory_model->sup_vsku = $data['sup_vsku'];
					$inventory_model->supplier_name = Supplier::model()->findByPk($data['sup_id'])->name;
					$inventory_model->ubs_sku = $data['UbsSku'];
					$inventory_model->mfg_sku = $data['Mpn'];
					$inventory_model->mfg_upc = $data['Upc'];
					$inventory_model->sup_sku = $data['SupplierSku'];
					$inventory_model->sup_sku_name = $data['ItemName'];
					$inventory_model->item_status = 0;
					if ($inventory_model->save(false)){
                       echo $id.' - '.$data->sup_vsku.' - '.$inventory_model->id.' Created.<br/>';
                       $newCount++;
                    }else
                    	var_dump($inventory_model->getErrors());
				}else
					$updateCount++;	                    
			endforeach;

              echo $pageCount*$pageSize.' done'.'<br/>';
		}
		echo "{$newCount} new Record Inserted and {$updateCount} record skipped. In ".Yii::getLogger()->getExecutionTime()."seconds";
	}
	
    public function actionImport()
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $file = 'bradley-seed.csv';
        $path = Yii::getPathOfAlias('webroot') . '/' . $file;
        $startRow = 2;
        $endRow = 0;
        $delimiter = ',';
        $enclosure = '"';
        $mode = 'save';
        $exec = exec('wc -l ' . $path, $result);

        echo '<pre>';
        echo '------------Import Seed Sheet Info------------' . '<br/>';
        echo 'Sheet path: ' . $path . '<br/>';
        echo 'Sheet size: ' . filesize($path) . '<br/>';
        echo 'Start row: ' . $startRow . '<br/>';
        echo 'End row: ' . ($endRow == 0 ? 'Unlimit' : $endRow) . '<br/>';
        //echo 'Total rows: ' . (int)$result[0] . '<br/>';
        echo 'Delimiter: ' . $delimiter . '<br/>';
        echo 'Enclosure: ' . $enclosure . '<br/>';
        echo 'Mode:' . $mode . '<br/>';
        echo '----------------------------------------------' . '<br/>';
        if (($handle = fopen($path, "r")) !== FALSE) {
            $id = 0;
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {
                if ($endRow != 0 && $id >= $endRow)
                    break;
                if ($id + 1 >= $startRow) {
                	$vsku = $row[3].$row[4];
                	$sup_id = 155;
                    $attributes = array(
                        'UbsSupplierName' => $row[0],
                        'UbsSupplierID' => $row[1],
                        'UbsSku' => $row[2],
                        'Mpn' => $row[3],
                        'Upc' => $row[4],
                        'SupplierSku' => $row[5],
                        'ItemName' => $row[6],
                        'sup_vsku'=> $vsku,
                        'sup_id'=> $sup_id,
                    );
                    $model = SupItemsSync::model()->findByAttributes(array(
                    	'sup_vsku'=>$vsku,
                    	'sup_id'=>$sup_id,
                    ));
                    if($model == null) {
                        $model = new SupItemsSync();
                        $model->attributes = $attributes;
                        if($model->save()) {
                            echo "Success - {$model->id} <br>";
                        } else {
                            var_dump($model->errors);
                        }
                    }
                    else {
                        echo "Item existed. {$model->id} <br> ";
                    }
                }
                $id++;
            }
            fclose($handle);
        } else {
            echo "Can't open file";
        }
    }
}
