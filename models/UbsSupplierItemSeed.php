<?php

/**
 * This is the model class for table "ubs_supplier_item_seed".
 *
 * The followings are the available columns in table 'ubs_supplier_item_seed':
 * @property string $SupplierName
 * @property integer $SupplierID
 * @property string $SKU
 * @property string $MPN
 * @property string $upc
 * @property string $SupplierSKU
 * @property string $ItemName
 */
class UbsSupplierItemSeed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ubs_supplier_item_seed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SupplierID', 'required'),
			array('SupplierID', 'numerical', 'integerOnly'=>true),
			array('SupplierName, ItemName', 'length', 'max'=>500),
			array('SKU, SupplierSKU', 'length', 'max'=>250),
			array('MPN', 'length', 'max'=>100),
			array('upc', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('SupplierName, SupplierID, SKU, MPN, upc, SupplierSKU, ItemName', 'safe', 'on'=>'search'),
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
			'SupplierName' => 'Supplier Name',
			'SupplierID' => 'Supplier',
			'SKU' => 'Sku',
			'MPN' => 'Mpn',
			'upc' => 'Upc',
			'SupplierSKU' => 'Supplier Sku',
			'ItemName' => 'Item Name',
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

		$criteria->compare('SupplierName',$this->SupplierName,true);
		$criteria->compare('SupplierID',$this->SupplierID);
		$criteria->compare('SKU',$this->SKU,true);
		$criteria->compare('MPN',$this->MPN,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('SupplierSKU',$this->SupplierSKU,true);
		$criteria->compare('ItemName',$this->ItemName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UbsSupplierItemSeed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
