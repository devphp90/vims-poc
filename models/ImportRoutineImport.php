<?php

/**
 * This is the model class for table "{{import_routine_import}}".
 *
 * The followings are the available columns in table '{{import_routine_import}}':
 * @property integer $id
 * @property integer $import_id
 * @property string $import_file_url
 * @property string $last_import_time
 */
class ImportRoutineImport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImportRoutineImport the static model class
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
		return '{{import_routine_import}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('import_id', 'numerical', 'integerOnly'=>true),
			array('import_file_url', 'length', 'max'=>200),
			array('last_import_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, import_id, import_file_url, last_import_time', 'safe', 'on'=>'search'),
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
			'import_id' => 'Import',
			'import_file_url' => 'Update Url',
			'last_import_time' => 'Last Import Time',
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
		$criteria->compare('import_id',$this->import_id);
		$criteria->compare('import_file_url',$this->import_file_url,true);
		$criteria->compare('last_import_time',$this->last_import_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}