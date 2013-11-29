<?php

/**
 * This is the model class for table "ubs_open_orders".
 *
 * The followings are the available columns in table 'ubs_open_orders':
 * @property integer $id
 * @property integer $Cancelled
 * @property string $ItemNumber
 * @property string $Product
 * @property string $QuantityOrdered
 * @property integer $Approved
 * @property string $ApprovalDate
 * @property string $OrderNumber
 * @property string $OrderDate
 * @property string $Name
 * @property string $SupplierName
 * @property string $Phone
 * @property string $Email
 * @property string $SKU
 * @property string $SupplierID
 * @property string $CartID
 */
class UbsOpenOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbsOpenOrder the static model class
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
		return 'ubs_open_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ItemNumber, Product, QuantityOrdered, OrderNumber, OrderDate, Name, SupplierName, Phone, Email, SKU, SupplierID, CartID', 'required'),
			array('Cancelled, Approved', 'numerical', 'integerOnly'=>true),
			array('ItemNumber, QuantityOrdered, OrderNumber, SupplierID, CartID', 'length', 'max'=>20),
			array('Product, Name, SKU', 'length', 'max'=>255),
			array('SupplierName', 'length', 'max'=>200),
			array('Phone, Email', 'length', 'max'=>50),
            array('Email', 'email'),
            array('ApprovalDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, Cancelled, ItemNumber, Product, QuantityOrdered, Approved, ApprovalDate, OrderNumber, OrderDate, Name, SupplierName, Phone, Email, SKU, SupplierID, CartID', 'safe', 'on'=>'search'),
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
			'Cancelled' => 'Cancelled',
			'ItemNumber' => 'Item Number',
			'Product' => 'Product',
			'QuantityOrdered' => 'Quantity Ordered',
			'Approved' => 'Approved',
			'ApprovalDate' => 'Approval Date',
			'OrderNumber' => 'Order Number',
			'OrderDate' => 'Order Date',
			'Name' => 'Name',
			'SupplierName' => 'Supplier Name',
			'Phone' => 'Phone',
			'Email' => 'Email',
			'SKU' => 'Sku',
			'SupplierID' => 'Suppliers Supplier',
			'CartID' => 'Cart',
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
		$criteria->compare('Cancelled',$this->Cancelled);
		$criteria->compare('ItemNumber',$this->ItemNumber,true);
		$criteria->compare('Product',$this->Product,true);
		$criteria->compare('QuantityOrdered',$this->QuantityOrdered,true);
		$criteria->compare('Approved',$this->Approved);
		$criteria->compare('ApprovalDate',$this->ApprovalDate,true);
		$criteria->compare('OrderNumber',$this->OrderNumber,true);
		$criteria->compare('OrderDate',$this->OrderDate,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('SupplierName',$this->SupplierName,true);
		$criteria->compare('Phone',$this->Phone,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('SKU',$this->SKU,true);
		$criteria->compare('SupplierID',$this->SupplierID,true);
		$criteria->compare('CartID',$this->CartID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}