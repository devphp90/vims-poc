<?php

/**
 * This is the model class for table "{{import_multisup_buffer_rule}}".
 *
 * The followings are the available columns in table '{{import_multisup_buffer_rule}}':
 * @property integer $id
 * @property integer $sup_qty
 * @property integer $start_qty
 * @property integer $end_qty
 * @property integer $to
 * @property integer $from
 * @property integer $qty
 */
class ImportMultisupBufferRule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportMultisupBufferRule the static model class
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
		return '{{import_multisup_buffer_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sup_qty, start_qty, end_qty, to, from, qty', 'required'),
			array('start_qty,end_qty,sup_qty,qty','numerical', 'integerOnly'=>true),
			array('to, from, qty', 'numerical'),
			// array('start_qty, end_qty', 'overlapQty'),
			array('start_qty', 'compare', 'compareAttribute' => 'end_qty', 'operator' => '<='),
			array('from', 'compare', 'compareAttribute' => 'to', 'operator' => '<='),
			// array('to, from', 'overlap'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sup_qty, start_qty, end_qty, to, from, qty', 'safe', 'on'=>'search'),
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

		if (!$this->isNewRecord)
			$criteria->addCondition('id <> ' . $this->id);

		$criteria->params = array(':value' => $this->$attribute);

		if(self::model()->find($criteria))
	    	$this->addError($attribute, $attribute.' can not be overlapped.');
	}

	/**
	 * Validates possible overlapping on existing range
	 */
	public function overlapQty($attribute,$params)
	{
		if ($this->hasErrors())
			return;

		$criteria = new CDbCriteria;
		$criteria->addCondition(':value BETWEEN `start_qty` AND `end_qty`');

		if (!$this->isNewRecord)
			$criteria->addCondition('id <> ' . $this->id);

		$criteria->params = array(':value' => $this->$attribute);

		if(self::model()->find($criteria))
	    	$this->addError($attribute, $attribute.' can not be overlapped.');
	}

	/**
	 * check if the user password is strong enough
	 * check the password against the pattern requested
	 * by the strength parameter
	 * This is the 'passwordStrength' validator as declared in rules().
	 */
	// public function overlap($attribute,$params)
	// {

	// 	$model = ImportMultisupBufferRule::model()->find('(:from>=`from` and :to<=`to`) and sup_qty=:sup_qty and (:start_qty>=`start_qty` and :end_qty<=`end_qty`)',array(
	// 		':from'=>$this->from,
	// 		':to'=>$this->to,
	// 		':start_qty'=>$this->start_qty,
	// 		':end_qty'=>$this->end_qty,
	// 		':sup_qty'=>$this->sup_qty,
	// 	));

	// 	if($model !=null)
	//     	$this->addError($attribute, $attribute.' can not be overlapped.');
	// }


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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sup_qty' => 'Sup Qty',
			'start_qty' => 'Start Qty',
			'end_qty' => 'End Qty',
			'to' => 'To Price',
			'from' => 'From Price',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('sup_qty',$this->sup_qty);
		$criteria->compare('start_qty',$this->start_qty);
		$criteria->compare('end_qty',$this->end_qty);
		$criteria->compare('to',$this->to);
		$criteria->compare('from',$this->from);
		$criteria->compare('qty',$this->qty);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}