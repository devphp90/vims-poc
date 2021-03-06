<?php

class TabsController extends Controller
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
                'actions' => array('create','saveSesson', 'supplierSetupStatus', 'supplierNotScheduled', 'freshUpdate', 'update', 'admin', 'delete', 'warehouseadd', 'updatewarehouse', 'setup', 'deletewarehouse', 'supitemstatus', 'dashboard', 'index', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
	
	public function actionSaveSesson()
	{
		if(isset($_POST['tabs_id'])) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$user->tabs_id = $_POST['tabs_id'];
			$user->supplier_filter_text = $_POST['text'];
			$user->save(false);
		}
	}
	
	public function actionSupplierNotScheduled()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];

		$this->render('//dashboard/supplierNotScheduled',array(
			'model'=>$model,
		));
	}
	
	public function actionSupplierSetupStatus()
	{
		$model=new Supplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Supplier']))
			$model->attributes=$_GET['Supplier'];

		$this->render('//dashboard/supplierSetupStatus',array(
			'model'=>$model,
		));
	}

    public function actionUpdatewarehouse($ware_id, $zip_code, $name, $state)
    {
        $warehouse = SupWarehouse::model()->findByPk($ware_id);

        $warehouse->zip_code = $zip_code;
        $warehouse->name = $name;
        $warehouse->state = $state;

        $warehouse->save();
    }

    public function actionDeletewarehouse($ware_id)
    {
        $warehouse = SupWarehouse::model()->findByPk($ware_id)->delete();
    }

    public function actionWarehouseadd($name, $state, $zipcode, $tabs_id)
    {
        $model = $this->loadModel($tabs_id);
        $warehouseModel = new SupWarehouse;
        $warehouseModel->sup_id = $model->supplier_id;
        $warehouseModel->name = $name;
        $warehouseModel->state = $state;
        $warehouseModel->zip_code = $zipcode;

        if (!$warehouseModel->save()) {
            foreach ($warehouseModel->getErrors() as $name => $reason) {
                echo $name . ': ' . $reason[0];

            }
            exit;
        }

        $warehouse = new TabsWarehouse;
        $warehouse->tabs_id = $model->id;
        $warehouse->ware_id = $warehouseModel->id;

        if ($warehouse->save()) {

            echo '<div class="control-group warehouse-group">';
            echo '<label>Name</label>';
            echo '<input class="span2 update-name" type="text" maxlength="50" value="' . $name . '" />';
            echo '<label>State</label>';
            echo '<input class="span2 update-state" type="text" maxlength="50" value="' . $state . '" />';
            echo '<label>Zipcode</label>';
            echo '<input class="span2 update-zipcode" type="text" maxlength="50" value="' . $zipcode . '" />';
            echo '<a class="update update-warehouse" :ware_id="' . $warehouseModel->id . '" href="#"><i class="icon-arrow-down"></i>Save</a>';
            echo '</div>';
            echo '<div class="row" id="warehouse-section"></div>';
        } else
            var_dump($warehouse->getErrors());
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
        $model = new Tabs;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Tabs'])) {
            $model->attributes = $_POST['Tabs'];
            if ($model->validate()) {


                $supplierModel = new Supplier;
                $supplierModel->name = $model->supplier_name;
                $supplierModel->save();

                $importRoutineModel = new ImportRoutine;
                $importRoutineModel->supplier_name = $model->supplier_name;
                if (!$importRoutineModel->save()) {
                    var_dump($importRoutineModel->getErrors());
                    exit;
                }

                $importRoutineModel_2 = new ImportRoutine;
                $importRoutineModel_2->supplier_name = $model->supplier_name;
                if (!$importRoutineModel_2->save()) {
                    var_dump($importRoutineModel_2->getErrors());
                    exit;
                }

                $warehouseModel = new SupWarehouse;
                $warehouseModel->sup_id = $supplierModel->id;
                $warehouseModel->name = 'default warehouse';
                $warehouseModel->save();

                $model->supplier_id = $supplierModel->id;
                $model->import_routine_id = $importRoutineModel->id;
                $model->import_routine_id_2 = $importRoutineModel_2->id;

                if ($model->save(false)) {

                    $warehouse = new TabsWarehouse;
                    $warehouse->tabs_id = $model->id;
                    $warehouse->ware_id = $warehouseModel->id;


                    if ($warehouse->save())
                        $this->redirect(array('admin'));
                    else {
                        $supplierModel->delete();
                        $importRoutineModel->delete();
                        $warehouseModel->delete();
                        $model->delete();
                    }

                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionSetup($id)
    {

        $this->render('setup');
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $request = Yii::app()->request;
        /** @var Tabs $model  */
        $model = $this->loadModel($id);
		/*$user = User::model()->findByPk(Yii::app()->user->id);
		if($user != null) {
			$user->tabs_id = $id;
			if(isset($_GET['Tabs']['supplier_name'])) {
				$user->supplier_filter_text = $_GET['Tabs']['supplier_name'];
			}
			$user->save(false);
		}
		*/
        if (time() - strtotime($model->update_time) < 5 && $model->update_by != Yii::app()->user->id) {
            Yii::app()->user->setFlash('error', "Locked, you can read only");
            $this->redirect(array('admin'));
        }
        if (!$navsup_model = NavSupplier::model()->bySupplierId($model->supplier->id)->find()) {
            $navsup_model = new NavSupplier;
        }

        $navsup_model->supplier_name = $model->supplier->name;

        $steps = array(
            'suppiler', 'warehouse', 'importroutine', 'mapitem', 'mapqoh', 'match', 'fetch'
        );
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

// This cannot be updated with the larger parent "form"
//        if (isset($_POST['NavSupplier'])) {
//
//            Yii::import('ext.simpletest.browser', true);
//
//            $navsup_model->attributes = $_POST['NavSupplier'];
//
//            $navsup_model->save();
//
//            $browser = &new SimpleBrowser();
//
//            $browser->get($navsup_model->url);
//
//
//
//            $browser->setField($navsup_model->username_label, $navsup_model->username);
//
//            $browser->setField($navsup_model->password_label, $navsup_model->password);
//
//            $browser->click($navsup_model->logon_label);
//
//            print $browser->click($navsup_model->step2_label);
//
//        }


        $fetch_column = array();
        if (!empty($model->importRoutine->fetch_column))
            $fetch_column = unserialize(base64_decode($model->importRoutine->fetch_column));
        if (!is_array($fetch_column))
            $fetch_column = array();
        $columns = array('0 - Not Select');

        foreach ($fetch_column as $id => $column)
            $columns[$id + 1] = ($id + 1) . ' - ' . $column;

        if (isset($_POST['Supplier'])) {
            //$model->attributes=$_POST['Tabs'];
			$oldSetupStatus = $model->supplier->setup_status;
            $model->supplier->attributes = $_POST['Supplier'];
            $model->importRoutine->scenario = 'sup1';
            $model->importRoutine->attributes = $_POST['ImportRoutine'];
            $model->importRoutine2->attributes = $_POST['ImportRoutine2'];
			$hasError = false;
			
			if($oldSetupStatus == 'I' && $_POST['Supplier']['setup_status'] == 'C') {
				$reason = "";


				if(empty($model->supplier->user_ran_iu) || $model->supplier->user_ran_iu == '0000-00-00 00:00:00') {
					$hasError = true;
					$reason = "I/U must be run.";
					
				} elseif(empty($model->importRoutine->frequency)) {
					$hasError = true;
					$reason = "Frequency must not empty.";
				}
				
				if($model->importRoutine->sup_match_column <1){
					
					
					$hasError = true;
					$reason = "vSKU 1 should has integer > 0 in field1.";
				}

				if($hasError) {
					$model->supplier->addError('setup_status', "Can't change Setup Status to complete. {$reason}");
					$model->supplier->setup_status = 'I';
				}
			}
			
            if ( !$hasError && $model->supplier->save()) {
                $model->importRoutine->supplier_name = $model->supplier->name;
                $model->importRoutine2->supplier_name = $model->supplier->name;
                if ($model->importRoutine->save() && $model->importRoutine2->save() && $model->save(false)) {

//                    var_dump($_POST['ImportRoutine']);
//                    var_dump($model->importRoutine->attributes); die();

                    Yii::app()->user->setFlash('success', "Successfully updated.");
                   // $this->redirect(array('admin'));
                } else {
//                    var_dump($model->errors);
 //                   var_dump($model->importRoutine->errors);
 //                   var_dump($model->importRoutine2->errors);
//                    var_dump($model->importRoutine->attributes);
//                    var_dump($_POST['ImportRoutine']); die();
                }
                // $this->redirect(array('update', 'id' => $model->id));
            }

            //
        }


        $this->render('update', array(
            'model' => $model,
            'supplierModel' => $model->supplier,
            'importRoutineModel' => $model->importRoutine,
            'importRoutineModel2' => $model->importRoutine2,
            'columns' => $columns,
            'steps' => $steps,
            'navsup_model' => $navsup_model,
            'emailTabOnly' => $request->getQuery('type') == 'dashboard' ? true : false,
        ));
    }

    public function actionFreshUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->save(false);
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Tabs');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $request = Yii::app()->request;
        $model = new Tabs('search');
        $model->unsetAttributes(); // clear any default values
		
		
		
        if (isset($_GET['Tabs']))
            $model->attributes = $_GET['Tabs'];
		else {
			$user = User::model()->findByPk(Yii::app()->user->id);
			if(!empty($user->tabs_id)) {
				$tabs = Tabs::model()->findByPk($user->tabs_id);
				if(empty($user->supplier_filter_text))
					$model->supplier_name = $tabs->supplier->name;
				else {
					$model->supplier_name = $user->supplier_filter_text;
				}
			}
		}
		
        $type = $request->getQuery('type');

        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_suppliers', array('model' => $model), false, true);
        else
            $this->render('//dashboard/tabs_admin', array(
                'model' => $model,
                'supplierOnly' => $type == 'dashboard' ? true : false,
            ));
    }

    /**
     * Manages all models.
     */
    public function actionDashboard()
    {
        $model = new Tabs('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Tabs']))
            $model->attributes = $_GET['Tabs'];

        $this->render('//dashboard/tabs_dashboard', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionSupitemstatus()
    {
        $model = new Tabs('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Tabs']))
            $model->attributes = $_GET['Tabs'];

        $this->render('//dashboard/supitemstatus', array(
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
        $model = Tabs::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tabs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
