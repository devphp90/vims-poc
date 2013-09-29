<?php

/**
 * @property Tabs $tabs
 */
class TabsImportLogController extends Controller
{

    public $_status = array(
        '',
        'PROCESSING',
        '<font color="red">FAIL</font>',
        '<font color="green">PASS</font>',
        '<font color="orange">WARNING</font>'
    );

    public $tabs = null;
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
                'actions' => array('test','failImportAndUpdate', 'create', 'update', 'admin', 'delete', 'logview', 'supdelall', 'supreset', 'failRoutine', 'index', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionFailImportAndUpdate()
    {
        $sql = TabsImportLog::getFailImportUpdateSql();
        $count = Yii::app()->db->createCommand("select count(a.tabs_id) count from ($sql) a")->queryScalar();
        $provider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $count,
            'keyField' => 'tabs_id',
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        $this->render('fail_import_update', array('dataProvider' => $provider));

    }
    public function actionTest()
    {
        $sql = TabsImportLog::getFailImportUpdateSql();
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        var_dump($data);
    }

    public function actionFailRoutine()
    {
        $model = new TabsImportLog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['TabsImportLog']))
            $model->attributes = $_GET['TabsImportLog'];

        if (isset($_POST['action']) && isset($_POST['tabs_id']) && isset($_POST['reason'])) {
            $action = $_POST['action'];
            $reason = $_POST['reason'];
            $tabs_id = $_POST['tabs_id'];

            $actions = $this->getUserActions();
            $reasons = $this->getUserReasons();
            $log = new ImportLogFailAction();
            $log->action = $actions[$action];
            $log->reason = $reasons[$reason];
            $log->created_time = time();
            $log->user_id = Yii::app()->user->id;
            $log->tabs_import_log_id = $_POST['tabs_import_log_id'];
            $log->notes = $_POST['notes'];
            $log->save(false);

            if ($action == '0') {
                $this->doResetLog($tabs_id);
                $this->doChangeStatus($tabs_id);
                $this->runIU($tabs_id);
            } elseif ($action == '1') {
                $this->doResetLog($tabs_id);
                $this->doChangeStatus($tabs_id);
                $this->runIU($tabs_id, true);
            }

        }

        $this->render('failroutine', array(
            'model' => $model,
            'dataProvider' => $model->failsearch(),
        ));
    }

    public function actionSupdelall($id)
    {
        TabsImportLog::model()->deleteAll('tabs_id=?', array($id));
        $this->redirect(array('logview', 'id' => $id));

    }

    public function doResetLog($tab_id)
    {
        ImportRoutineUpdate::model()->deleteAll('import_id=?', array($tab_id));
        $model = Tabs::model()->findByPk($tab_id);
        $model->column_number = 0;
        $model->overall_item = 0;
        $model->filetime = 0;
        $model->save(false);
        $command = Yii::app()->db->createCommand();
        $command->delete('vims_import_vsheet_last', 'import_id=:import_id', array(':import_id' => $model->import_routine_id));

    }


    public function doChangeStatus($tab_id, $status = Supplier::STATUS_ACTIVE)
    {
        $model = Tabs::model()->findByPk($tab_id);
        /** @var Supplier $supplier */
        $supplier = $model->supplier;
        $supplier->active = $status;
        $supplier->save(false);
    }

    public function actionSupreset($id)
    {
        $this->doResetLog($id);
        $redirect = Yii::app()->request->getParam('redirect', 'logview');
        $this->redirect(array($redirect, 'id' => $id));
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
        $model = new TabsImportLog;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TabsImportLog'])) {
            $model->attributes = $_POST['TabsImportLog'];
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

        if (isset($_POST['TabsImportLog'])) {
            $model->attributes = $_POST['TabsImportLog'];
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TabsImportLog');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new TabsImportLog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['TabsImportLog']))
            $model->attributes = $_GET['TabsImportLog'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionLogview($id)
    {
        $model = new TabsImportLog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['TabsImportLog']))
            $model->attributes = $_GET['TabsImportLog'];

        $this->render('logview', array(
            'model' => $model,
            'tabs_id' => $id,
            'dataProvider' => $model->supsearch($id),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = TabsImportLog::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tabs-import-log-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function getUserActions()
    {
        return array("Try Again", "Accept the failed import sheet1", "Accept the failed import sheet2 and reactivate", "Accept failed importsheet BOTH and reactivate", "REJECT and Reset/requeu to the previous GOOD inventory sheet and reactivate", "REJECT and keep on Inactive");
    }

    public function getUserReasons()
    {
        $array = SupFailedImportReasons::model()->findAll();
        $result = array();
        foreach ($array as $item) {
            $result[$item->id] = $item->reason;
        }
        return $result;
        // return array("Remapped sheet", "Change QA rule", "Other");
    }

    /**
     * @param $id tabs_id
     */
    public function runIU($id, $updateOnly = false)
    {

        session_write_close();
        ignore_user_abort();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $tabsModel = Tabs::model()->findByPk($id);

        $importUrl = $this->createAbsoluteUrl("/importRoutine/get", array(
            'id' => $tabsModel->import_routine_id,
            'id2' => $tabsModel->import_routine_id_2,
        ));


        // echo '<a href="'.$importUrl.'">Import Link(debug only)</a>';
        // echo '<br/>';
        $updateUrl = $this->createAbsoluteUrl("/importRoutine/updateFile", array(
            'id' => $tabsModel->import_routine_id,
        ));

        // echo '<a href="'.$updateUrl.'">Update Link(debug only)</a>';
        if ($updateOnly) {
            exec('wget --delete-after -q ' . $updateUrl . ' > /dev/null &');
        } else {
            exec('wget --delete-after -q ' . $importUrl . ' > /dev/null ;' . 'wget --delete-after -q ' . $updateUrl . ' > /dev/null &');
        }
    }

    public function getTabs($tabs_id)
    {
        if ($this->tabs == null || $this->tabs->id != $tabs_id)
            $this->tabs = Tabs::model()->findByPk($tabs_id);
        return $this->tabs;
    }
}
