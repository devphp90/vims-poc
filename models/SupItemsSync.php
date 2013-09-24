<?php

/**
 * This is the model class for table "{{sup_items_sync}}".
 *
 * The followings are the available columns in table '{{sup_items_sync}}':
 * @property integer $id
 * @property string $UbsSupplierName
 * @property integer $UbsSupplierID
 * @property integer $Mpn
 * @property string $Upc
 * @property integer $SupplierSku
 * @property string $ItemName
 * @property string $UbsSku
 */
class SupItemsSync extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupItemsSync the static model class
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
		return '{{sup_items_sync}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SupplierSku, UbsSupplierID, ItemName, UbsSku, sup_id, sup_vsku', 'required'),
			array('UbsSupplierName, ItemName, Mpn, Upc', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, UbsSupplierName, UbsSupplierID, Mpn, Upc, SupplierSku, ItemName', 'safe', 'on'=>'search'),
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
			'UbsSupplierName' => 'Ubs Supplier Name',
			'UbsSupplierID' => 'Ubs Supplier',
			'Mpn' => 'Mpn',
			'Upc' => 'Upc',
			'SupplierSku' => 'Supplier Sku',
			'ItemName' => 'Item Name',
            'UbsSku' => 'Ubs Sku',
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
		$criteria->compare('UbsSupplierName',$this->UbsSupplierName,true);
		$criteria->compare('UbsSupplierID',$this->UbsSupplierID);
		$criteria->compare('Mpn',$this->Mpn);
		$criteria->compare('Upc',$this->Upc,true);
		$criteria->compare('SupplierSku',$this->SupplierSku);
		$criteria->compare('ItemName',$this->ItemName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}