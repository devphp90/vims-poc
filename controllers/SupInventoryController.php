<?php

class SupInventoryController extends Controller
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

	public function actionClean()
	{
		$models = SupInventory::model()->findAll();

		foreach($models as $id=>$model){

			if(!isset($model->ubs_inventory->id)){
				echo $model->id;
			}
		}
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
				'actions'=>array('importSeedSheet','import','create','update','admin','delete','dashboard','dropItem','supview','openOrderInbound','ajaxSupstatus','supStat','supupdate','ajaxMultiItemStatus','index','view','clean'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAjaxMultiItemStatus($ids, $action)
	{
		$ids = explode(',', $ids);

		foreach($ids as $id=>$value){
			SupInventory::model()->updateByPk($value,array('item_status'=>$action));
		}
/*
		$models = SupInventory::model()->findAllByAttributes(array('id'=>$ids));

		if($models != null){

			foreach($models as $id=>$model){
				$model->item_status = $action;
				if(!$model->save())
					var_dump($model->getErrors());
			}
		}
*/


	}
	public function actionSupStat()
	{
		$model=new SupInventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupInventory']))
			$model->attributes=$_GET['SupInventory'];

		$this->render('supstat',array(
			'model'=>$model,
		));
	}
	public function actionAjaxSupstatus($id, $value)
	{
		$model = $this->loadModel($id);
		$model->sup_status = $value;
    $model->setScenario(SupInventory::SCENARIO_OVERRIDE);
		if(!$model->save())
			throw new CHttpException('500','supplier inactive.');

	}

	public function actionOpenOrderInbound()
	{
		$model=new SupInventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupInventory']))
			$model->attributes=$_GET['SupInventory'];

		$this->render('openorderinbound',array(
			'model'=>$model,
		));

	}

	public function actionDropItem()
	{
    $request = Yii::app()->request;

		$model=new SupItemsMissing('search');
    $model->sup_id = $request->getQuery('supplierId');

		$this->render('dropitem',array(
			'model'=>$model,
		));

	}

	public function actionSupview($id)
	{
		$model=new SupInventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupInventory']))
			$model->attributes=$_GET['SupInventory'];

		$this->render('supview',array(
			'model'=>$model,
			'id'=>Tabs::model()->findByPk($id)->supplier_id,
      'tabId' => $id,
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
		$model=new SupInventory;

		$newModel = SupItemsNewManage::model()->findByPk(Yii::app()->request->getQuery('new_id',''));
		if($newModel != null){
			$model->sup_vsku = $newModel->sup_vsku;
			$model->mfg_sku = $newModel->mfg_sku;
			$model->mfg_upc = $newModel->upc;
			$model->mfg_name = $newModel->mfg_name;
			$model->mfg_sku_name = $newModel->mfg_part_name;
			$model->sup_sku = $newModel->sup_sku;
			$model->sup_sku_name = $newModel->sup_sku_name;
			$model->sup_description = $newModel->sup_description;
			$model->sup_id = $newModel->import_routine->sup_id;
			$model->ubs_id = $newModel->ubsinventory->id;
			//$model->sup_status = 1;

		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SupInventory']))
		{

			$model->sup_id = $_POST['SupInventory']['sup_id'];
			$model->supplier_name = Supplier::model()->findByPk($model->sup_id)->name;
			$model->attributes=$_POST['SupInventory'];

			if($model->save()){
				if($newModel !== null){
					$newModel->item_status = 2;
					$newModel->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    /**
     * Imports seed sheet ver 2.0
     * @author jovani
     */
    public function actionImportSeedSheet()
    {
    	set_time_limit(0);
        ini_set("memory_limit", -1);
    	$file = 'bradley-seed.csv';
		$path = Yii::getPathOfAlias('webroot').'/'.$file;
		$startRow = 2;
		$endRow = 1000;
		$delimiter = ',';
		$enclosure = '"';
		$mode = 'save';
    	$column = array(
    		'sup_name'=>0,
    		'sup_id'=>1,
    		'ubs_sku'=>2,
    		'mfg_sku'=>3,
    		'mfg_upc'=>4,
    		'sup_sku'=>5,
    		'sup_sku_name'=>5
    	);
    	$exec = exec('wc -l ' . $path, $result);

    	echo '<pre>';
    	echo '------------Import Seed Sheet Info------------'.'<br/>';
    	echo 'Sheet path: '.$path.'<br/>';
    	echo 'Sheet size: '.filesize($path).'<br/>';
    	echo 'Start row: '.$startRow.'<br/>';
    	echo 'End row: '.($endRow == 0? 'Unlimit':$endRow).'<br/>';
    	echo 'Total rows: '.(int)$result[0].'<br/>';
    	echo 'Delimiter: '.$delimiter.'<br/>';
    	echo 'Enclosure: '.$enclosure.'<br/>';
    	echo 'Mode:'. $mode.'<br/>';
    	echo '----------------------------------------------'.'<br/>';
    	
		


		

		if (($handle = fopen($path, "r")) !== FALSE) {
			$id = 0;
		    while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {
		    	$row[$column['sup_name']] = 'LT - BCI (Bradley Caldwell)';
				if($endRow !=0 && $id >= $endRow)
					break;
				if($id+1 >= $startRow){
					$SupplierModel = Supplier::model()->findAll(array(
						'condition'=>'name like :name',
						'params'=>array(
							':name'=>'%'.$row[$column['sup_name']].'%',
						),
					));
					if($SupplierModel != null){
						if(count($SupplierModel) > 1){
							$suppliers = array();
							foreach($SupplierModel as $i=>$a){
								$suppliers[] = '"'.$a->name.'"';
							}
							echo '<font color="red">Error: Line:'.($id+1).' Which Supplier do you mean? '. implode(',',$suppliers).'</font>';
						}else{
							$sup_id = $SupplierModel[0]->id;
							$sup_name = $SupplierModel[0]->name;
							
							$ubsModel = UbsInventory::model()->findByAttributes(array(
								'sku'=>$row[$column['ubs_sku']],
							));
							
							if($ubsModel != null){
								
								$model = SupInventory::model()->find(array(
									'condition'=>'sup_id=:sup_id and ubs_id=:ubs_id',
									'params'=>array(
										':sup_id'=>$sup_id,
										':ubs_id'=>$ubsModel->id,
									),
								));

								if($model == null){
									$model = new SupInventory;
									$model->sup_id = $sup_id;
									$model->ubs_id = $ubsModel->id;
									$model->mfg_sku = $row[$column['mfg_sku']];
									$model->mfg_upc = $row[$column['mfg_upc']];
									$model->sup_sku = $row[$column['sup_sku']];
									$model->sup_sku_name = $row[$column['sup_sku_name']];
									$model->sup_status = 2;// set to bo;
									$model->supplier_name = $sup_name;
									$model->ubs_sku = $ubsModel->sku;
									if($model->$mode())
										echo '<font color="green">Success: Line:'.($id+1).' Sup Item('.$model->id.') created.'.'</font>';
									else{
										var_dump($model->getErrors());
										echo '<font color="red">Error: Line:'.($id+1).' Unexpected Error'.'</font>';
									}
								}else{
									if(empty($model->sup_vsku)){
										echo '<font color="red">Error: Line:'.($id+1).' No SKU('.$model->id.') already there.'.'</font>';
										}else
										echo '<font color="red">Error: Line:'.($id+1).' Sup Item('.$model->id.') already there.'.'</font>';
		
								}

							}else
								echo '<font color="red">Error: Line:'.($id+1).' SKU('.$row[$column['ubs_sku']].') Not Found.'.'</font>';

							
						}
						
					}else
						echo '<font color="red">Error: Line:'.($id+1).' Supplier('.$row[$column['sup_name']].') Not Found.'.'</font>';
						
					echo '<br/>';
					
				}
					

				$id++;
		    }
		    fclose($handle);
		}

    }

    /**
     * Imports seed sheet ver 1.0
     * @param $id
     * @author jovani
     */
    public function actionImport($id)
    {
    $request = Yii::app()->request;

    if ($request->isPostRequest) {
      set_time_limit(0);
      if ($file = CUploadedFile::getInstanceByName('SupInventory[importFile]')) {
        // var_dump($file);die('done');
        Yii::import('application.vendors.PHPExcel',true);

        $objPHPExcel = PHPExcel_IOFactory::load($file->tempName);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        // $records = array();
        foreach ($objWorksheet->getRowIterator() as $i => $row){
          if ($i == 1) continue;

          $item = array();
          foreach ($row->getCellIterator() as $key => $cell)
            $item[$key] = trim($cell->getValue());

          //$records[] = $item;

          // Skip existing vsku
          $sup_vsku = $item[3] . $item[4];
          if (SupInventory::model()->findByAttributes(array('sup_vsku' => $sup_vsku)))
            continue;

          $ubs_sku = $item[2];
          if (!UbsInventory::model()->bySku($ubs_sku)->find())
            continue;

          $model = new SupInventory;
          $model->supplier_name = Tabs::model()->findByPk($id)->supplier->name;
//          $model->ubs_id       = UbsInventory::model()->bySku($item[2])->find()->id;
          $model->ubs_sku      = $ubs_sku;
          $model->sup_vsku     = $sup_vsku;
          $model->sup_sku      = $item[5];
          $model->mfg_upc      = $item[4];
          $model->mfg_sku      = $item[3];
          $model->mfg_sku_name = strlen($item[6]) > 100 ? substr($item[6], 0, 100) : $item[6];

          if (!$model->save()) {
            var_dump($model->errors); die();
          }
        }

      }

    } // isPosRequest

    $this->redirect($this->createUrl('supInventory/supview', array('id' => $id)));
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

		if(isset($_POST['SupInventory']))
		{
			$model->attributes=$_POST['SupInventory'];
			if($model->save())
				$this->redirect(array('view','id'=>$id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSupUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SupInventory']))
		{
			$model->attributes=$_POST['SupInventory'];
			if($model->save())
				$this->redirect(array('supview','id'=>Tabs::model()->findByAttributes(array('supplier_id'=>$model->sup_id))->id));
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
		$dataProvider=new CActiveDataProvider('SupInventory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionDashboard()
	{
		$model=new SupInventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupInventory']))
			$model->attributes=$_GET['SupInventory'];

		$this->render('dashboard',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SupInventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupInventory']))
			$model->attributes=$_GET['SupInventory'];

		$this->render('admin',array(
			'model'=>$model,
			'total'=>SupInventory::model()->count(),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SupInventory::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sup-inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
