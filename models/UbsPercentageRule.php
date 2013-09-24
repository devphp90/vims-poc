<?php

/**
 * This is the model class for table "{{ubs_percentage_rule}}".
 *
 * The followings are the available columns in table '{{ubs_percentage_rule}}':
 * @property integer $id
 * @property double $start_price
 * @property double $end_price
 * @property integer $percent
 */
class UbsPercentageRule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbsPercentageRule the static model class
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
		return '{{ubs_percentage_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_price, end_price, percent', 'required'),
			array('percent', 'numerical', 'integerOnly'=>true),
			array('start_price, end_price', 'numerical'),
			array('start_price, end_price','overlap'),
			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start_price, end_price, percent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * check if the user password is strong enough
	 * check the password against the pattern requested
	 * by the strength parameter
	 * This is the 'passwordStrength' validator as declared in rules().
	 */
	// public function overlap($attribute,$params)
	// {
	// 	$model = UbsPercentageRule::model()->find(':start_price>=`start_price` and :end_price<=`end_price`',array(
	// 		':start_price'=>$this->$attribute,
	// 		':end_price'=>$this->$attribute,
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
		$criteria->addCondition(':value BETWEEN `start_price` AND `end_price`');

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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'start_price' => 'Start Price',
			'end_price' => 'End Price',
			'percent' => 'Percent',
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
		$criteria->compare('start_price',$this->start_price);
		$criteria->compare('end_price',$this->end_price);
		$criteria->compare('percent',$this->percent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}