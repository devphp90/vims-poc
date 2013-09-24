<?php

class MessageController extends SecurityController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * update the delete status of particular message
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $updateArr = array();
            if ($model->sender_id == Yii::app()->user->id)
                $updateArr = array('sender_deleted' => 1);
            elseif ($model->receiver_id == Yii::app()->user->id)
                $updateArr = array('receiver_deleted' => 1);

            if ($model->updateByPk($model->id, $updateArr))
                echo $id;
            Yii::app()->end();
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * $ids is array of message id
     * delete the ids
     */
    public function actionDeleteInbox($ids) {
        if (Yii::app()->request->isAjaxRequest) {
            $user_id = Yii::app()->user->id;
            $ids = explode(',', $ids);
            foreach ($ids as $mid) {
                $model = $this->loadModel($mid);
                if ($model->sender_id == Yii::app()->user->id)
                    $id = $model->receiver_id;
                else
                    $id = $model->sender_id;
                $model->updateAll(array('sender_deleted' => 1), "(sender_id={$user_id} AND receiver_id={$id} AND sender_deleted=0 AND advert_id={$model->advert_id})");
                $model->updateAll(array('receiver_deleted' => 1), "(sender_id={$id} AND receiver_id={$user_id} AND receiver_deleted=0 AND advert_id={$model->advert_id})");
            }
            echo 'success';
            Yii::app()->end();
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     * $id is sender id
     */
    public function actionRead($id, $advert_id) {
        //$username = User::UserDetails('username', $id)->username;
        $user_id = Yii::app()->user->id;
        //if($id==Yii::app()->user->id)
          //  $this->redirect(array('inbox'));

        $model = new Message;
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js']=false;
            Yii::app()->clientScript->scriptMap['jquery.js']=true;
            $model->attributes = $_POST['Message'];
            $model->advert_id = $advert_id;
            $model->message = $model->filter_email_phone($model->message);//filter message
            $model->sender_id = $user_id;
            $model->receiver_id = $id;
            if ($model->validate()) {
                if ($model->save()) {
                    if ($model->receiver->settings->email_notif == 1) {
                        $email = new Email;
                        $email->sendMail(Yii::app()->params['noreplyEmail'], $model->receiver->email, 11, array("#RECEIVER_USERNAME#" => $model->receiver->username, "#SENDER_USERNAME#" => $model->sender->username, "#MESSAGE_LINK#" => Yii::app()->createAbsoluteUrl("/message/read/", array('id'=>$id, 'advert_id'=>$advert_id))));
                    }
                    $this->renderPartial('_view', array('data' => $model), false, true);
                }
            }
            Yii::app()->end();
        }
        /* unread the message from the passed id */
        $model->updateAll(array('is_read' => 1), "sender_id={$id} AND receiver_id={$user_id} AND advert_id={$advert_id}");
        $criteria = new CDbCriteria();
        $criteria->addCondition("(sender_id={$user_id} AND receiver_id={$id} AND sender_deleted=0 AND advert_id={$advert_id}) OR (sender_id={$id} AND receiver_id={$user_id} AND receiver_deleted=0 and advert_id={$advert_id})");
        //$criteria->addCondition('id>=(select max(id) from tbl_message)-20');
        $criteria->order = 'id ASC';
        $criteria->limit=3;
        $dataProvider = new CActiveDataProvider('Message', array('criteria' => $criteria, 'pagination' => false));
        $this->render('read', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'receiver_id' => $id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Message::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionIndex() {
        $user_id = Yii::app()->user->id;
        if (isset($_GET['unread']))
            $condition = 'receiver_id='.$user_id.' AND receiver_deleted=0 AND is_read=0';
        elseif(isset($_GET['outbox'])){
            $condition = 'sender_id='.$user_id.' AND sender_deleted=0';
        }
        else
            $condition = 'receiver_id='.$user_id.' AND receiver_deleted=0';

        $c = new CDbCriteria();
        $c->addCondition($condition);
        $c->order = 'add_date DESC';
        $c->group = 'sender_id,advert_id';

        $dataProvider = new CActiveDataProvider('Message', array(
                    'criteria'=>$c,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        //print_r($dataProvider);die();
        //$dataProvider = new CActiveDataProvider('Message', array('criteria' => $criteria));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

}
