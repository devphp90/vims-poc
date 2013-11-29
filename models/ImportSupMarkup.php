<?php

/**
 * This is the model class for table "{{import_sup_markup}}".
 *
 * The followings are the available columns in table '{{import_sup_markup}}':
 * @property integer $id
 * @property integer $sup_id
 * @property double $from
 * @property double $to
 * @property double $markup
 * @property integer $type
 * @property integer $break_map
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $create_by
 * @property integer $update_by
 */
class ImportSupMarkup extends CActiveRecord
{
	public $supplier_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportSupMarkup the static model class
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
		return '{{import_sup_markup}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name','required'),
			// array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array('from, to, type, break_map', 'required'),
			array('sup_id, type, break_map', 'numerical', 'integerOnly'=>true),
			array('from, to, markup', 'numerical'),
			array('from, to','overlap'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			array('status', 'default', 'value' => 1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, from, to, markup, type, break_map, create_time, update_time, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	// /**
	//  * check if the user password is strong enough
	//  * check the password against the pattern requested
	//  * by the strength parameter
	//  * This is the 'passwordStrength' validator as declared in rules().
	//  */
	// public function overlap($attribute,$params)
	// {
	// 	$model = ImportSupMarkup::model()->find(':from>=`from` and :to<=`to` and sup_id=:sup_id',array(
	// 		':from'=>$this->$attribute,
	// 		':to'=>$this->$attribute,
	// 		':sup_id'=>Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id,
	// 	));
	// 	if($model !=null)
	//     	$this->addError($attribute, $attribute.' can not be overlapped.');
	// }

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

	public function afterFind()
	{
		$supModel = Supplier::model()->findByPk($this->sup_id);
		if($supModel != null)
			$this->supplier_name = $supModel->name;
		else
			$this->supplier_name = '';
	}

	public function beforeValidate()
	{
		if (!$this->sup_id)
			$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
		return true;
	}

	public function beforeSave()
	{
		if (!$this->sup_id)
			$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_id' => 'Supplier Id',
			'from' => 'From Price',
			'to' => 'To Price',
			'markup' => 'Markup % or $ amount',
			'type' => 'Markup Type',
			'break_map' => 'Break Map',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
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
		$criteria->compare('markup',$this->markup);
		$criteria->compare('type',$this->type);
		$criteria->compare('break_map',$this->break_map);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		// $criteria->compare('supplier.name', $this->supplier_name);

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
					'markup',
				),
			),
		));
	}
}