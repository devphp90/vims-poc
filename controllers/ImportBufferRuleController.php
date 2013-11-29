<?php

class ImportBufferRuleController extends Controller

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

			'accessControl' // perform access control for CRUD operations

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
		$command = Yii::app()->db->createCommand('UPDATE `vims_sup_inventory` as t1 SET t1.gbuffer_c = 0, t1.sbuffer_c = 0, t1.ibuffer_c = 0, t1.buffer_c = 0;');
		$command->execute();
		
		$command = Yii::app()->db->createCommand('UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty` from  `vims_import_buffer_rule` where STATUS =1) as t2 SET t1.gbuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to`;');
		$command->execute();
		
		$command = Yii::app()->db->createCommand('UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty`, `sup_id` from  `vims_import_sup_buffer_rule` where STATUS =1) as t2 SET t1.sbuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to` and t1.sup_id = t2.sup_id;');
		$command->execute();
		
		$command = Yii::app()->db->createCommand('UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty`, `sup_id`, `ubs_id` from  `vims_import_sup_item_buffer_rule` where STATUS =1) as t2 SET t1.ibuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to` and t1.sup_id = t2.sup_id and t1.ubs_id = t2.ubs_id;');
		$command->execute();
		
		$command = Yii::app()->db->createCommand('UPDATE `vims_sup_inventory` SET `buffer_c` = CASE WHEN ibuffer_c != 0 THEN `ibuffer_c` WHEN sbuffer_c != 0 THEN `sbuffer_c` ELSE `gbuffer_c` END, `sup_bqoh_c` = `qty_total_c` + `buffer_c`,
 `sup_vqoh_c` = `sup_bqoh_c` + `sup_open_order` where (gbuffer_c+ibuffer_c+sbuffer_c) !=0;');
		$command->execute();
		
		$this->redirect('admin');
		
		
		
		
/* 
UPDATE `vims_sup_inventory` as t1 SET t1.gbuffer_c = 0, t1.sbuffer_c = 0, t1.ibuffer_c = 0, t1.buffer_c = 0;# set all to 0
#50k rows 1.x secs

#update global rules
UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty` from  `vims_import_buffer_rule` where STATUS =1) as t2 SET t1.gbuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to`;
#2.1	 

#update supplier qty rules
UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty`, `sup_id` from  `vims_import_sup_buffer_rule` where STATUS =1) as t2 SET t1.sbuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to` and t1.sup_id = t2.sup_id;

#update item rules
UPDATE `vims_sup_inventory` as t1, (SELECT `from`,`to`, `qty`, `sup_id`, `ubs_id` from  `vims_import_sup_item_buffer_rule` where STATUS =1) as t2 SET t1.ibuffer_c = t2.qty where t1.sup_price >= t2.`from` AND t1.sup_price <=  t2.`to` and t1.sup_id = t2.sup_id and t1.ubs_id = t2.ubs_id;

#update final buffer
UPDATE `vims_sup_inventory` SET `buffer_c` = CASE
    WHEN ibuffer_c != 0 THEN `ibuffer_c`
    WHEN sbuffer_c != 0 THEN `sbuffer_c`
    ELSE `gbuffer_c`
    END,
    `sup_bqoh_c` = `qty_total_c` + `buffer_c`,
    `sup_vqoh_c` = `sup_bqoh_c` + `sup_open_order`
   where (gbuffer_c+ibuffer_c+sbuffer_c) !=0;
*/
		
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

		$model=new ImportBufferRule;



		// Uncomment the following line if AJAX validation is needed

		// $this->performAjaxValidation($model);



		if(isset($_POST['ImportBufferRule']))

		{

			$model->attributes=$_POST['ImportBufferRule'];

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



		if(isset($_POST['ImportBufferRule']))

		{

			$model->attributes=$_POST['ImportBufferRule'];

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

		$dataProvider=new CActiveDataProvider('ImportBufferRule');

		$this->render('index',array(

			'dataProvider'=>$dataProvider

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

			Yii::app()->end();

		}



		$model=new ImportBufferRule('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['ImportBufferRule']))

			$model->attributes=$_GET['ImportBufferRule'];

    if ($status = $r->getQuery('status')) {
      ImportBufferRule::model()->updateAll(array('status' => $status == 'ON' ? 1 : 0));
    }


    $this->render('admin',array(

			'model'=>$model,

		));

	}

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

		$model=ImportBufferRule::model()->findByPk($id);

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

		if(isset($_POST['ajax']) && $_POST['ajax']==='import-buffer-rule-form')

		{

			echo CActiveForm::validate($model);

			Yii::app()->end();

		}

	}

}

