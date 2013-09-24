<?php

/**
 * This is the model class for table "ubs_supplier_stats".
 *
 * The followings are the available columns in table 'ubs_supplier_stats':
 * @property string $SupplierId
 * @property string $SupplierName
 * @property integer $OrderCount
 * @property integer $OrderCount_Last30Days
 * @property integer $Shipdays_OrderCount
 * @property string $ShipDays
 * @property string $ShipDays_AllUnder30
 * @property string $BusinessShipDays
 * @property string $BusinessShipDays_allunder30
 * @property string $ShipDays_Last30Days
 * @property integer $CancelOrderCount
 * @property string $CancelRate
 * @property string $CancelRate_Last30Days
 */
class UbsSupplierStat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbsSupplierStat the static model class
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
		return 'ubs_supplier_stats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SupplierId', 'required'),
			array('OrderCount, OrderCount_Last30Days, Shipdays_OrderCount, CancelOrderCount', 'numerical', 'integerOnly'=>true),
			array('SupplierId', 'length', 'max'=>10),
			array('SupplierName', 'length', 'max'=>200),
			array('ShipDays, ShipDays_AllUnder30, BusinessShipDays, BusinessShipDays_allunder30, ShipDays_Last30Days', 'length', 'max'=>38),
			array('CancelRate, CancelRate_Last30Days', 'length', 'max'=>37),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SupplierId, SupplierName, OrderCount, OrderCount_Last30Days, Shipdays_OrderCount, ShipDays, ShipDays_AllUnder30, BusinessShipDays, BusinessShipDays_allunder30, ShipDays_Last30Days, CancelOrderCount, CancelRate, CancelRate_Last30Days', 'safe', 'on'=>'search'),
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
			'SupplierId' => 'Supplier',
			'SupplierName' => 'Supplier Name',
			'OrderCount' => 'Order Count',
			'OrderCount_Last30Days' => 'Order Count Last30 Days',
			'Shipdays_OrderCount' => 'Shipdays Order Count',
			'ShipDays' => 'Ship Days',
			'ShipDays_AllUnder30' => 'Ship Days All Under30',
			'BusinessShipDays' => 'Business Ship Days',
			'BusinessShipDays_allunder30' => 'Business Ship Days Allunder30',
			'ShipDays_Last30Days' => 'Ship Days Last30 Days',
			'CancelOrderCount' => 'Cancel Order Count',
			'CancelRate' => 'Cancel Rate',
			'CancelRate_Last30Days' => 'Cancel Rate Last30 Days',
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

		$criteria->compare('SupplierId',$this->SupplierId,true);
		$criteria->compare('SupplierName',$this->SupplierName,true);
		$criteria->compare('OrderCount',$this->OrderCount);
		$criteria->compare('OrderCount_Last30Days',$this->OrderCount_Last30Days);
		$criteria->compare('Shipdays_OrderCount',$this->Shipdays_OrderCount);
		$criteria->compare('ShipDays',$this->ShipDays,true);
		$criteria->compare('ShipDays_AllUnder30',$this->ShipDays_AllUnder30,true);
		$criteria->compare('BusinessShipDays',$this->BusinessShipDays,true);
		$criteria->compare('BusinessShipDays_allunder30',$this->BusinessShipDays_allunder30,true);
		$criteria->compare('ShipDays_Last30Days',$this->ShipDays_Last30Days,true);
		$criteria->compare('CancelOrderCount',$this->CancelOrderCount);
		$criteria->compare('CancelRate',$this->CancelRate,true);
		$criteria->compare('CancelRate_Last30Days',$this->CancelRate_Last30Days,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}