<?php

/**
 * This is the model class for table "{{supplier}}".
 *
 * The followings are the available columns in table '{{supplier}}':
 * @property integer $id
 * @property string $name
 * @property integer $loc_id
 * @property integer $rating
 * @property string $ubs_act_exec
 * @property string $crtn_date
 * @property integer $active
 * @property string $term_date
 */
class Supplier extends CActiveRecord
{
	public $active=1;

  const STATUS_ACTIVE = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Supplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{supplier}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('name', 'required'),
			array('name','unique'),
			array('loc_id, rating, active, percent_change,timestamp,email_ubs_if_fail,email_supplier_if_fail, ignore_from, ignore_to', 'numerical', 'integerOnly'=>true),
			array('cancel_rate, cancel_rate_limit', 'numerical'),
			array('name, ubs_act_exec', 'length', 'max'=>50),
			array('fail_message', 'length', 'max'=>255),

			array('term_date,note, from_email', 'safe'),
			/////////////////////////////////
			array('phone','length','max'=>20),
			array('email','length','max'=>100),
			array('email','email'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('contact','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, loc_id, rating, ubs_act_exec , active', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
			'supinventory' => array(self::HAS_MANY, 'SupInventory', 'sup_id'),

			'importRoutine' => array(self::HAS_ONE, 'ImportRoutine', 'sup_id'),

//			'import'=>array(self::HAS_MANY, 'supColMap', 'id'),
//			'map4'=>array(self::HAS_ONE,'SupMap4','id'),
		);
	}

	public function afterSave()
	{
		// if($this->active == 0){
		// 	//UPDATE persondata SET ageage=age+1;
		// 	$sql = "update vims_sup_inventory set sup_status=0 where sup_id=:sup_id";
		// 	$command=Yii::app()->db->createCommand($sql);
		// 	$command->bindParam(":sup_id",$this->id,PDO::PARAM_INT);
		// 	//$rowCount = $command->query();

		// 	//UPDATE persondata SET ageage=age+1;
		// 	$sql = "update vims_import_routine set status=0 where sup_id=:sup_id";
		// 	$command=Yii::app()->db->createCommand($sql);
		// 	$command->bindParam(":sup_id",$this->id,PDO::PARAM_INT);
		// 	//$rowCount = $command->query();

		// }

		// $models = UbsInventory::model()->findAllByAttributes(array('primary_supplier_c'=>$this->id));

		// if($models != null)
		// {
		// 	foreach($models as $id=> $model){
		// 		$model->save(false);
		// 	}
		// }
	}
	public function beforeDelete()
	{

		if($this->supinventory != null)
			$this->supinventory->deleteAll();
		return true;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Sup',
			'name' => 'Supplier Name',
			'contact' => 'Contact',
			'loc_id' => 'Loc',
			'rating' => 'Sup Rating',
			'ubs_act_exec' => 'Ubs Act Exec',
			'crtn_date' => 'Sup Crtn Date',
			'active' => 'Status',
			'term_date' => 'Sup Term Date',
			'email_server'=>'email address',
			'email_username'=>'email subject',
			'email_password'=>'Http Url',
			'phone'=>'Supplier Phone',
			'email'=>'Supplier Email',
			'timestamp'=>'Check Sheet Date/Time Stamp',
		);
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

		$criteria->compare('loc_id',$this->loc_id);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('ubs_act_exec',$this->ubs_act_exec,true);

		$criteria->compare('active',$this->active);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

}