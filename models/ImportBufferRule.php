<?php

/**
 * This is the model class for table "{{import_buffer_rule4}}".
 *
 * The followings are the available columns in table '{{import_buffer_rule4}}':
 * @property integer $id
 * @property double $from
 * @property double $to
 * @property integer $qty
 */
class ImportBufferRule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImportBufferRule4 the static model class
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
		return '{{import_buffer_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, qty', 'required'),
			array('from, to','overlap'),
			array('from, to', 'numerical'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, qty', 'safe', 'on'=>'search'),
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

		// $model = ImportBufferRule::model()->find(':from>=`from` and :to<=`to`',array(
		// 	':from'=>$this->$attribute,
		// 	':to'=>$this->$attribute,
		// ));
		if(ImportBufferRule::model()->find($criteria))
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
		);
	}

	public function afterFind()
	{

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('from',$this->from);
		$criteria->compare('to',$this->to);
		$criteria->compare('qty',$this->qty);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}