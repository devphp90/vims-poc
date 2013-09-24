<?php

/**
 * This is the model class for table "{{import_sup_item_override}}".
 *
 * The followings are the available columns in table '{{import_sup_item_override}}':
 * @property integer $id
 * @property integer $sup_id
 * @property integer $supitem_id
 * @property double $from
 * @property double $to
 * @property string $start
 * @property string $end
 * @property integer $change
 * @property integer $type
 * @property string $comment
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_by
 * @property integer $update_by
 */
class ImportSupItemOverride extends CActiveRecord
{
	public $supplier_name;
	public $supitem_vsku;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportSupItemOverride the static model class
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
		return '{{import_sup_item_override}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('start, end, supitem_vsku, supplier_name, qty', 'required'),
//			array('from, to','overlap'),
			array('supitem_vsku','validatevsku'),
			array('supitem_vsku','exist','className'=>'SupInventory','attributeName'=>'sup_vsku'),
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array('sup_id, supitem_id, change, create_by, update_by', 'numerical', 'integerOnly'=>true),
//			array('from, to', 'numerical'),
			array('comment','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, supitem_id, from, to, start, end, change, type, comment, create_time, update_time, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function validatevsku($attribute, $params)
	{
		$model = SupInventory::model()->findByAttributes(array(
			'sup_vsku'=>$this->supitem_vsku,
			'sup_id'=>Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id
		));

		if( $model == null )
			$this->addError($attribute, 'Supplier item vSKU not found.');


	}

	// public function overlap($attribute,$params)
	// {

	// 	$model = ImportSupItemOverride::model()->find(':from>=`from` and :to<=`to` and sup_id=:sup_id and supitem_id=:supitem_id',array(
	// 		':from'=>$this->$attribute,
	// 		':to'=>$this->$attribute,
	// 		':sup_id'=>Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id,
	// 		':supitem_id'=>SupInventory::model()->findByAttributes(array('sup_vsku'=>$this->supitem_vsku))->id,
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
		$criteria->addCondition('supitem_id = ' . $this->supitem_id);

		if (!$this->isNewRecord)
			$criteria->addCondition('id <> ' . $this->id);

		$criteria->params = array(':value' => $this->$attribute);

		if(self::model()->find($criteria))
	    	$this->addError($attribute, $attribute.' can not be overlapped.');
	}

	public function afterFind()
	{
		$this->supplier_name = Supplier::model()->findByPk($this->sup_id)->name;
		$this->supitem_vsku = SupInventory::model()->findByPk($this->supitem_id)->sup_vsku;

	}
	public function beforeSave()
	{
		$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
		$this->supitem_id = SupInventory::model()->findByAttributes(array('sup_vsku'=>$this->supitem_vsku))->id;

    $this->start = date('Y-m-d', strtotime($this->start));
    $this->end = date('Y-m-d', strtotime($this->end));
    $this->applies_to_one_item = $this->supitem_vsku;
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
			'sup_id' => 'Sup',
			'supitem_id' => 'Supitem',
			'from' => 'From',
			'to' => 'To',
			'start' => 'Start',
			'end' => 'End',
			'change' => 'change',
			'type' => 'Type',
			'comment' => 'Comment',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('supitem_id',$this->supitem_id);
//		$criteria->compare('from',$this->from);
//		$criteria->compare('to',$this->to);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
//		$criteria->compare('change',$this->change);
//		$criteria->compare('type',$this->type);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}