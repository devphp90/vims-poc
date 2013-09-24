<?php

/**
 * This is the model class for table "{{import_log_fail_actions}}".
 *
 * The followings are the available columns in table '{{import_log_fail_actions}}':
 * @property integer $id
 * @property integer $tabs_import_log_id
 * @property string $action
 * @property string $reason
 * @property integer $user_id
 * @property integer $created_time
 */
class ImportLogFailAction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportLogFailAction the static model class
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
		return '{{import_log_fail_actions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabs_import_log_id, action, reason, user_id', 'required'),
			array('tabs_import_log_id, user_id, created_time', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>255),
            array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tabs_import_log_id, action, reason, user_id, created_time', 'safe', 'on'=>'search'),
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
			'tabs_import_log_id' => 'Tabs Import Log',
			'action' => 'Action',
			'reason' => 'Reason',
			'user_id' => 'User',
			'created_time' => 'Created Time',
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
		$criteria->compare('tabs_import_log_id',$this->tabs_import_log_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_time',$this->created_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}