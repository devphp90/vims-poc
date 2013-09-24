<?php

/**
 * This is the model class for table "{{ubs_items_sync}}".
 *
 * The followings are the available columns in table '{{ubs_items_sync}}':
 * @property integer $id
 * @property string $sku
 * @property string $name
 * @property string $manufacturer
 * @property string $manufacturer_part_number
 * @property string $upc
 * @property string $our_cost
 */
class UbsItemsSync extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbsItemsSync the static model class
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
		return '{{ubs_items_sync}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sku, name, manufacturer, manufacturer_part_number, upc, our_cost', 'required'),
			array('sku, manufacturer_part_number', 'length', 'max'=>32),
			array('name, manufacturer', 'length', 'max'=>255),
			array('upc', 'length', 'max'=>20),
			array('our_cost', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sku, name, manufacturer, manufacturer_part_number, upc, our_cost', 'safe', 'on'=>'search'),
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
			'sku' => 'Sku',
			'name' => 'Name',
			'manufacturer' => 'Manufacturer',
			'manufacturer_part_number' => 'Manufacturer Part Number',
			'upc' => 'Upc',
			'our_cost' => 'Our Cost',
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
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('manufacturer_part_number',$this->manufacturer_part_number,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('our_cost',$this->our_cost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}