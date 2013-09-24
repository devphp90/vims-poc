<?php

/**
 * This is the model class for table "{{update_qa_supplier}}".
 *
 * The followings are the available columns in table '{{update_qa_supplier}}':
 * @property integer $id
 * @property integer $sup_id
 * @property integer $item_percent
 * @property integer $instock_percent
 * @property integer $qoh_percent
 * @property integer $price_percent
 * @property integer $create_by
 * @property integer $update_by
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Supplier $sup
 * @property Supplier $createBy
 * @property Supplier $updateBy
 */
class UpdateQaSupplier extends CActiveRecord
{
	public $supplier_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UpdateQaSupplier the static model class
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
		return '{{update_qa_supplier}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name, item_percent, instock_percent, qoh_percent, price_percent, di_qoh_percent, di_price_percent', 'required'),
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array('sup_id, item_percent, instock_percent, qoh_percent, price_percent ', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('id, sup_id, item_percent, instock_percent, qoh_percent, price_percent, create_by, update_by, create_time, update_time', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function afterFind()
	{
		$this->supplier_name = $this->supplier->name;	
		
	}
	
	public function beforeSave()
	{
		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;

		return true;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_id' => 'Sup',
			'item_percent' => 'Row Count Change',
			'instock_percent' => 'InStock Items Change',
			'qoh_percent' => 'QOH Percent',
			'price_percent' => 'Price Percent',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'di_price_percent'=>'DI Price Percent',
			'di_qoh_percent'=>'DI QOH Percent',
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
		$criteria->compare('item_percent',$this->item_percent);
		$criteria->compare('instock_percent',$this->instock_percent);
		$criteria->compare('qoh_percent',$this->qoh_percent);
		$criteria->compare('price_percent',$this->price_percent);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}