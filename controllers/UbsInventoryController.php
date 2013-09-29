<?php

class UbsInventoryController extends Controller
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
                'actions' => array('freshUpdate', 'create', 'update', 'admin', 'delete', 'ajaxubs', 'cqohrelation', 'manual', 'importRemote', 'ubsItemOutBound', 'ubsItemOutBoundExpand', 'odbctest', 'writefront', 'reload', 'index', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users

                'users' => array('*'),
            ),
        );
    }

    public function actionReload($id)
    {
        $model = $this->loadModel($id);
        $model->save(false);
        echo 'Refreshed';
    }

    public function actionWriteFront()
    {
        $pageSize = 100;
        $criteria = new CDbCriteria;
        $dataProvider = new CActiveDataProvider('UBSData', array(
          'criteria' => $criteria,
          'pagination' => array(
            'pageSize' => $pageSize,
          ),
        ));

        $dataProvider->getData();

        for ($i = 0; $i < $dataProvider->pagination->pageCount; $i++) {

            $dataProvider_1 = new CActiveDataProvider('UBSData', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => $pageSize,
                    'currentPage' => $i,
                ),
            ));

            foreach ($dataProvider_1->getData() as $id => $vsheet):
                $model = UbsInventory::model()->findByAttributes(array('sku' => $vsheet->Sku));
                if ($model != null) {
                    if ($model->sale_price != $vsheet->PRICE || $model->getmQOH() != $vsheet->QTY) {
                        $vsheet->PRICE = $model->sale_price;
                        $vsheet->QTY = $model->getmQOH();
                        if ($vsheet->save())
                            echo $vsheet->Sku, 'ok';
                        else
                            var_dump($vsheet->getErrors());
                    }
                }
                echo '<br/>';
            // $sql = "update [dbo].[tmp_Axeo_Test_Products] set [QTY]='1' where [ProductID]='212213' ";
            // $command=Yii::app()->db->createCommand($sql);
            // $command->bindParam(":sup_id",$this->id,PDO::PARAM_INT);
            // $rowCount = $command->query();
            endforeach;
        }
    }

    public function actionOdbctest()
    {
        $model = new UBSData('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UBSData']))
            $model->attributes = $_GET['UBSData'];

        $this->render('odbctest', array(
            'model' => $model,
        ));
    }

    public function actionUbsItemOutBoundExpand()
    {

        $model = new UbsInventory('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UbsInventory']))
            $model->attributes = $_GET['UbsInventory'];
        $row = Yii::app()->db->createCommand(array(
                    'select' => array('max(id) as itemnumber'),
                    'from' => "vims_ubs_inventory",
                ))->queryRow();

        $this->render('ubsitemoutboundexpand', array(
            'model' => $model,
            'count' => $row['itemnumber'],
        ));
    }

    public function actionUbsItemOutBound()
    {
        $model = new UbsInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UbsInventory']))
            $model->attributes = $_GET['UbsInventory'];
        $row = Yii::app()->db->createCommand(array(
                    'select' => array('max(id) as itemnumber'),
                    'from' => "vims_ubs_inventory",
                ))->queryRow();
        $this->render('ubsitemoutbound', array(
            'model' => $model,
            'count' => $row['itemnumber'],
        ));
    }

    public function actionImportRemote()
    {
        session_write_close();
        ignore_user_abort();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $filename = Yii::app()->basePath . '/../UBS_SKUS.txt';
        echo '<pre>';
        $row = 1;
        if (file_exists($filename)) {
            if (($handle = fopen($filename, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                    if ($row == 1)
                        var_dump($data);
                    if ($row > 1) {
                        /*
                          echo $data[0];
                          $ubsRow = Yii::app()->db->createCommand(array(
                            'where'=>'sku=:sku',
                            'select'=>'id',
                            'from'=>'vims_ubs_inventory',
                            'params'=>array(
                              ':sku'=>$data[0],
                              ),
                            ))->queryRow();
                          $isDup = $ubsRow['id'];
                          if($isDup == NULL){
                        */
                        try {
                            $newUbsItem = new UbsInventory;
                            $newUbsItem->sku = $data[0];
                            $newUbsItem->sku_name = $data[1];
                            $newUbsItem->sku_description = isset($data[$model->sku_description - 1]) ? $data[$model->sku_description - 1] : NULL;
                            $newUbsItem->mfg_title = $data[3];
                            $newUbsItem->mfg_name = $data[4];
                            $newUbsItem->mfg_part_name = $data[6];
                            $newUbsItem->upc = $data[5];
                            $newUbsItem->price = $data[6];
                            $newUbsItem->vprice = $data[2];
                            if (!$newUbsItem->save(false)) {
                                echo '123';
                            }
                        } catch (Exception $e) {

                        }
                    }
                  $row++;
                }


                if ($row >= 1000) {

                }
            }
        }

        echo 'Runtime:' . Yii::getLogger()->getExecutionTime();
    }

    public function actionManual()
    {
        $model = new UbsManualUpdateForm;
        $ubsItem = new UbsInventory;
        //  $session = md5($importroutine->file_name.rand())
        //  $name = $importroutine->id.'-'.$session.'-'.$importroutine->file_name;
        $filename = Yii::app()->basePath . DIRECTORY_SEPARATOR . '../upload' . DIRECTORY_SEPARATOR . $name;
        if (!empty($_FILES['UbsManualUpdateForm']['tmp_name']['file'])) {
            //copy($_FILES['UbsManualUpdateForm']['tmp_name']['file'], $filename);
            $model->attributes = $_POST['UbsManualUpdateForm'];
            $row = 1;
            if (($handle = fopen($_FILES['UbsManualUpdateForm']['tmp_name']['file'], "r")) !== FALSE) {

                while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                    if ($model->start_at > $row++)
                        continue;
                    $newUbsItem = new UbsInventory;
                    $newUbsItem->sku = isset($data[$model->sku - 1]) ? $data[$model->sku - 1] : NULL;
                    $newUbsItem->sku_name = isset($data[$model->sku_name - 1]) ? $data[$model->sku_name - 1] : NULL;
                    $newUbsItem->sku_description = isset($data[$model->sku_description - 1]) ? $data[$model->sku_description - 1] : NULL;
                    $newUbsItem->mfg_title = isset($data[$model->mfg_title - 1]) ? $data[$model->mfg_title - 1] : NULL;
                    $newUbsItem->mfg_name = isset($data[$model->mfg_name - 1]) ? $data[$model->mfg_name - 1] : NULL;
                    $newUbsItem->mfg_part_name = isset($data[$model->mfg_part_name - 1]) ? $data[$model->mfg_part_name - 1] : NULL;
                    $newUbsItem->upc = isset($data[$model->upc - 1]) ? $data[$model->upc - 1] : NULL;
                    $newUbsItem->price = isset($data[$model->price - 1]) ? $data[$model->price - 1] : NULL;
                    $newUbsItem->vprice = isset($data[$model->vprice - 1]) ? $data[$model->vprice - 1] : NULL;
                    if (!$newUbsItem->save()) {
                        var_dump($newUbsItem->getErrors());
                    }
                }
                fclose($handle);
            }
            echo "Import Done!!<br/><a href='admin'>Back to Ubs Item</a>";
            exit;
        }
        $this->render('manual', compact('model'));
    }

    public function actionCqohrelation($id)
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
        $criteria = new CDbCriteria;
        $criteria->condition = 'ubs_id = :id';
        $criteria->with = 'supplier';
        $criteria->params = array(
            ':id' => $id,
        );
        $criteria->select = '*,(select sum(qty_on_hand) from vims_sup_warehouse_item as g where g.vims_id = t.id) as qty_total';
        $dataProvider = new CActiveDataProvider('SupInventory', array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
        $this->renderPartial('_ajaxitem', array(
            'dataProvider' => $dataProvider,
            // 'ubs_sku' => $ubs_sku,
                ), 0, 1);
    }

    public function actionAjaxUbs($id)
    {
        $model = UbsInventory::model()->find('id=?', array($id));
        $this->renderPartial('_ajaxubs', array(
            'model' => $model,
        ));
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
        $model = new UbsInventory;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UbsInventory'])) {
            $model->attributes = $_POST['UbsInventory'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }


    public function actionFreshUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_by = Yii::app()->user->id;
        $model->save(false);
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
        if (time() - strtotime($model->update_time) < 5 && $model->update_by != Yii::app()->user->id) {
            Yii::app()->user->setFlash('error', "Locked, you can read only");
            $this->redirect(array('admin'));
        }
        $this->performAjaxValidation($model);
        if (isset($_POST['UbsInventory']))
        {
            $model->attributes = $_POST['UbsInventory'];
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
     */
    public function actionDelete($id)
    {

        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

        $dataProvider = new CActiveDataProvider('UbsInventory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new UbsInventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UbsInventory']))
            $model->attributes = $_GET['UbsInventory'];
        $row = Yii::app()->db->createCommand(array(
                    'select' => array('max(id) as itemnumber'),
                    'from' => "vims_ubs_inventory",
                ))->queryRow();
        $this->render('admin', array(
            'model' => $model,
            'count' => $row['itemnumber'],
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
    */
    public function loadModel($id)
    {
        $model = UbsInventory::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ubs-inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}