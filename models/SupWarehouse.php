<?php

/**
 * This is the model class for table "{{sup_warehouse}}".
 *
 * The followings are the available columns in table '{{sup_warehouse}}':
 * @property integer $id
 * @property integer $sup_id
 * @property string $state
 * @property string $zip_code
 */
class SupWarehouse extends CActiveRecord
{
	public $wizardMultiWarehouse = array();
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupWarehouse the static model class
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
		return '{{sup_warehouse}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sup_id','required'),
			array('sup_id','exist','className'=>'Supplier','attributeName'=>'id'),
			array('name','unique','allowEmpty'=>false,'criteria'=>array(
				'condition'=>'sup_id=:sup_id',
				'params'=>array(
					':sup_id'=>$this->sup_id,
				),
			
			)),
			array('sup_id', 'numerical', 'integerOnly'=>true),
			array('state, zip_code,name', 'safe'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, state, zip_code', 'safe', 'on'=>'search'),
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
			'supplier'=>array(self::BELONGS_TO,'Supplier','sup_id'),
			'item'=>array(self::HAS_ONE, 'SupWarehouseItem', 'ware_id'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_id' => 'Supplier',
			'state' => 'State',
			'zip_code' => 'Zip Code',
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
		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip_code',$this->zip_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}