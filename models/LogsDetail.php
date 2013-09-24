<?php

/**
 * This is the model class for table "{{logs_detail}}".
 *
 * The followings are the available columns in table '{{logs_detail}}':
 * @property integer $id
 * @property integer $log_id
 * @property string $step
 * @property string $message
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Logs $log
 */
class LogsDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogsDetail the static model class
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
		return '{{logs_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('log_id, step, message, type', 'required'),
			array('log_id, type', 'numerical', 'integerOnly'=>true),
			array('step', 'length', 'max'=>50),
			array('message', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, log_id, step, message, type', 'safe', 'on'=>'search'),
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
			'log' => array(self::BELONGS_TO, 'Logs', 'log_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'log_id' => 'Log',
			'step' => 'Step',
			'message' => 'Message',
			'type' => 'Type',
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
		$criteria->compare('log_id',$this->log_id);
		$criteria->compare('step',$this->step,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}