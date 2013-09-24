<?php

/**
 * This is the model class for table "{{import_sup_buffer_rule}}".
 *
 * The followings are the available columns in table '{{import_sup_buffer_rule}}':
 * @property integer $id
 * @property integer $sup_id
 * @property double $from
 * @property double $to
 * @property integer $qty
 */
class ImportSupBufferRule extends CActiveRecord
{
	public $supplier_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportSupBufferRule the static model class
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
		return '{{import_sup_buffer_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name, from, to, qty', 'required'),
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array('sup_id, qty,from, to', 'numerical'),
			array('from, to','overlap'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, from, to, qty', 'safe', 'on'=>'search'),
		);
	}

	public function afterFind()
	{
		$this->supplier_name = Supplier::model()->findByPk($this->sup_id)->name;

	}
    public function beforeValidate()
	{
		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;

		return parent::beforeValidate();
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

		// $model = ImportSupBufferRule::model()->find(':from>=`from` and :to<=`to` and sup_id=:sup_id',array(
		// 	':from'=>$this->$attribute,
		// 	':to'=>$this->$attribute,
		// 	':sup_id'=>Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id,
		// ));
		// if($model !=null)
		if(ImportSupBufferRule::model()->find($criteria))
	    	$this->addError($attribute, $attribute.' can not be overlapped.');
	}

	public function beforeSave()
	{
		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
		// $this->ubs_id = UbsInventory::model()->findByAttributes(array('sku'=>$this->ubs_sku))->id;
		return true;
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_id' => 'Sup',
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
//          'qty',
        ),
      ),
    ));
	}
}