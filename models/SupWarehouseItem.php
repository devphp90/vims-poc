<?php

/**
 * This is the model class for table "{{sup_warehouse_item}}".
 *
 * The followings are the available columns in table '{{sup_warehouse_item}}':
 * @property integer $id
 * @property integer $ware_id
 * @property integer $qty_on_hand
 * @property double $price
 */
class SupWarehouseItem extends CActiveRecord
{
	public $ware_id = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupWarehouseItem the static model class
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
		return '{{sup_warehouse_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ware_id, qty_on_hand,vims_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('vims_id', 'unsafe'),
			array('ware_id','unique','allowEmpty'=>false,'criteria'=>array(
				'condition'=>'vims_id=:vims_id',
				'params'=>array(
					':vims_id'=>$this->vims_id,
				),
			
			)),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ware_id,  qty_on_hand, price', 'safe', 'on'=>'search'),
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
			'sup_inventory'=>array(self::BELONGS_TO,'SupInventory','vims_id'),
			'warehouse'=>array(self::BELONGS_TO,'SupWarehouse','ware_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ware_id' => 'Ware',
			'qty_on_hand' => 'Qty On Hand',
			'price' => 'Price',
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
		$criteria->compare('ware_id',$this->ware_id);
		$criteria->compare('qty_on_hand',$this->qty_on_hand);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}