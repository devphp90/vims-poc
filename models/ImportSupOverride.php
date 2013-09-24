<?php

/**
 * This is the model class for table "{{import_sup_override}}".
 *
 * The followings are the available columns in table '{{import_sup_override}}':
 * @property integer $id
 * @property integer $sup_id
 * @property double $from
 * @property double $to
 * @property string $start
 * @property string $end
 * @property integer $change
 * @property string $comment
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_by
 * @property integer $update_by
 */
class ImportSupOverride extends CActiveRecord
{
	public $supplier_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportSupOverride the static model class
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
		return '{{import_sup_override}}';
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
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array(' start, end', 'required'),
			array('sup_id, create_by, update_by, type', 'numerical', 'integerOnly'=>true),
			array('from, to, applies_to_all', 'numerical'),
			array('from, to','overlap'),
			array('comment','safe'),
            array('applies_to_group, applies_to_one_item, percent_adjust, dollar_adjust, dollar_fixed', 'safe'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_id, from, to, start, end, change, comment, create_time, update_time, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	// public function overlap($attribute,$params)
	// {
	// 	$model = ImportSupOverride::model()->find(':from>=`from` and :to<=`to` and sup_id=:sup_id',array(
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
/*
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
*/
	}


	public function afterFind()
	{
		$this->supplier_name = Supplier::model()->findByPk($this->sup_id)->name;
	}
	public function beforeSave()
	{
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
			'sup_id' => 'Sup',
			'from' => 'From Price',
			'to' => 'To Price',
			'start' => 'Start Date',
			'end' => 'End Date',
            'applies_to_all' => 'Applies to All',
            'applies_to_group' => 'Applies to group',
            'applies_to_one_item' => 'Applies to one item',
            'percent_adjust' => 'Percent Adjustment',
            'dollar_adjust' => 'Dollar Adjustment',
            'dollar_fixed' => 'Fixed Item Price',
			'change' => 'change',
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
    $criteria->with = 'supplier';
		$criteria->compare('id',$this->id);
		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('from',$this->from);
		$criteria->compare('to',$this->to);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('change',$this->change);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);

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
          'start',
          'end',
          'dollar_fixed',
        ),
      ),
    ));
	}
}