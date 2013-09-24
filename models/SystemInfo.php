<?php

/**
 * This is the model class for table "{{system_info}}".
 *
 * The followings are the available columns in table '{{system_info}}':
 * @property integer $id
 * @property double $cancel_rate_limit
 */
class SystemInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SystemInfo the static model class
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
		return '{{system_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cancel_rate_limit', 'required'),
			array('cancel_rate_limit', 'numerical'),
			array('global_cancel_rate_limit', 'numerical'),
			array('percent_change', 'numerical', 'integerOnly'=>true),
			array('primary_email,secondary_email','email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cancel_rate_limit', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cancel_rate_limit' => 'Cancel Rate Limit',
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
		$criteria->compare('cancel_rate_limit',$this->cancel_rate_limit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}