<?php

/**
 * This is the model class for table "{{tabs_main_log}}".
 *
 * The followings are the available columns in table '{{tabs_main_log}}':
 * @property integer $id
 * @property integer $tabs_id
 * @property integer $sheet1_file_size
 * @property integer $sheet2_file_size
 * @property integer $sheet1_row
 * @property integer $sheet2_row
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TabsImportLog[] $tabsImportLogs
 * @property Tabs $tabs
 */
class TabsMainLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabsMainLog the static model class
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
		return '{{tabs_main_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabs_id, sheet1_file_size, sheet2_file_size, sheet1_row, sheet2_row, create_time, update_time, status', 'required'),
			array('tabs_id, sheet1_file_size, sheet2_file_size, sheet1_row, sheet2_row, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tabs_id, sheet1_file_size, sheet2_file_size, sheet1_row, sheet2_row, create_time, update_time, status', 'safe', 'on'=>'search'),
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
			'tabsImportLogs' => array(self::HAS_MANY, 'TabsImportLog', 'log_id'),
			'tabs' => array(self::BELONGS_TO, 'Tabs', 'tabs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tabs_id' => 'Tabs',
			'sheet1_file_size' => 'Sheet1 File Size',
			'sheet2_file_size' => 'Sheet2 File Size',
			'sheet1_row' => 'Sheet1 Row',
			'sheet2_row' => 'Sheet2 Row',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'status' => 'Status',
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
		$criteria->compare('tabs_id',$this->tabs_id);
		$criteria->compare('sheet1_file_size',$this->sheet1_file_size);
		$criteria->compare('sheet2_file_size',$this->sheet2_file_size);
		$criteria->compare('sheet1_row',$this->sheet1_row);
		$criteria->compare('sheet2_row',$this->sheet2_row);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}