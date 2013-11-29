<?php

/**
 * This is the model class for table "ubs_control_table".
 *
 * The followings are the available columns in table 'ubs_control_table':
 * @property integer $tableid
 * @property string $tablename
 * @property integer $lstatus
 * @property string $datelastupdate
 */
class UbsControlTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tablename()
	{
		return 'ubs_control_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tableid, tablename, lstatus, datelastupdate', 'required'),
			array('tableid, lstatus', 'numerical', 'integerOnly'=>true),
			array('tablename', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tableid, tablename, lstatus, datelastupdate', 'safe', 'on'=>'search'),
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
			'tableid' => 'Table',
			'tablename' => 'Table Name',
			'lstatus' => 'lstatus',
			'datelastupdate' => 'Date Last Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tableid',$this->tableid);
		$criteria->compare('tablename',$this->tablename,true);
		$criteria->compare('lstatus',$this->lstatus);
		$criteria->compare('datelastupdate',$this->datelastupdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UbsControlTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
