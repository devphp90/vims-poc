<?php

/**
 * This is the model class for table "{{tabs_warehouse}}".
 *
 * The followings are the available columns in table '{{tabs_warehouse}}':
 * @property integer $id
 * @property integer $tabs_id
 * @property integer $ware_id
 *
 * The followings are the available model relations:
 * @property Tabs $tabs
 */
class TabsWarehouse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabsWarehouse the static model class
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
		return '{{tabs_warehouse}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabs_id, ware_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tabs_id, ware_id', 'safe', 'on'=>'search'),
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
			'tabs' => array(self::BELONGS_TO, 'Tabs', 'tabs_id'),
			'warehouse' => array(self::BELONGS_TO, 'SupWarehouse', 'ware_id')
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
			'ware_id' => 'Ware',
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
		$criteria->compare('ware_id',$this->ware_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}