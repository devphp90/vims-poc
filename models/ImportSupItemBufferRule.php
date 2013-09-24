<?php

/**
 * This is the model class for table "{{import_sup_item_buffer_rule}}".
 *
 * The followings are the available columns in table '{{import_sup_item_buffer_rule}}':
 * @property integer $id
 * @property integer $sup_id
 * @property integer $ubs_id
 * @property integer $from
 * @property integer $to
 * @property integer $qty
 */
class ImportSupItemBufferRule extends CActiveRecord
{
	public $supplier_name;
	public $ubs_sku;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportSupItemBufferRule the static model class
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
		return '{{import_sup_item_buffer_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name,ubs_sku','required'),
			array('ubs_sku','exist','className'=>'UbsInventory','attributeName'=>'sku'),
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array(' from, to, qty', 'required'),
			array('sup_id, ubs_id, qty', 'numerical', 'integerOnly'=>true),
			array(' from, to', 'numerical'),
			array('from, to','overlap'),
            array('status','default','setOnEmpty'=>false,'value'=>1, 'on' => 'insert'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
            array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, ubs_id, from, to, qty', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Validates possible overlapping on existing range
	 */
	public function overlap($attribute,$params)
	{
		if ($this->hasErrors())
			return;

		$criteria = new CDbCriteria;
		$criteria->addCondition(':value BETWEEN `from` AND `to`');
		$criteria->addCondition('sup_id = ' . $this->sup_id);

		if (!$this->isNewRecord)
			$criteria->addCondition('id <> ' . $this->id);

		$criteria->params = array(':value' => $this->$attribute);

		if(self::model()->find($criteria))
	    	$this->addError($attribute, $attribute.' can not be overlapped.');
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),
			'ubs_inventory' => array(self::BELONGS_TO, 'UbsInventory', 'ubs_id'),
		);
	}

	public function afterFind()
	{
		$this->supplier_name = Supplier::model()->findByPk($this->sup_id)->name;
//		$this->supitem_vsku = SupInventory::model()->findByPk($this->supitem_id)->sup_vsku;
		$this->ubs_sku = $this->ubs_inventory->sku;

	}
	public function beforeValidate()
	{
		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
		$this->ubs_id = UbsInventory::model()->findByAttributes(array('sku'=>$this->ubs_sku))->id;

		return parent::beforeValidate();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_id' => 'Sup',
			'ubs_id' => 'Ubs',
			'from' => 'From Price',
			'to' => 'To Price',
			'qty' => 'Qty',
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
    $criteria->with = 'supplier';
		$criteria->compare('id',$this->id);
		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('ubs_id',$this->ubs_id);
		$criteria->compare('from',$this->from);
		$criteria->compare('to',$this->to);
		$criteria->compare('qty',$this->qty);

    if (strpos($this->supplier_name, '*') !== false) {
      $supplierName = str_replace('*', '%', $this->supplier_name);
      $criteria->addCondition("supplier.name LIKE '{$supplierName}'");
    } else {
      $criteria->compare('supplier.name',$this->supplier_name);
    }

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'sort'=>array(
        'defaultOrder'=>'supplier.name',
        'attributes' => array(
          'supplier_name' => array(
            'asc'  => 'supplier.name',
            'desc' => 'supplier.name DESC',
          ),
          'status',
          'from',
          'to',
          'ubs_id',
//          'qty',
        ),
      ),
    ));
	}
}