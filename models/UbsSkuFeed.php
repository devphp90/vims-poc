<?php

/**
 * This is the model class for table "ubs_sku_feed".
 *
 * The followings are the available columns in table 'ubs_sku_feed':
 * @property string $dtCreated
 * @property string $Action
 * @property string $Completed
 * @property string $SKU
 * @property string $name
 * @property string $salePrice
 * @property string $manufacturer
 * @property string $MPN
 * @property string $upc
 * @property string $ourCost
 */
class UbsSkuFeed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ubs_sku_feed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Action, SKU', 'required'),
			array('Action, Completed', 'length', 'max'=>1),
			array('SKU, manufacturer, MPN', 'length', 'max'=>100),
			array('name', 'length', 'max'=>500),
			array('salePrice, ourCost', 'length', 'max'=>29),
			array('upc', 'length', 'max'=>50),
			array('dtCreated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dtCreated, Action, Completed, SKU, name, salePrice, manufacturer, MPN, upc, ourCost', 'safe', 'on'=>'search'),
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
	
	protected function beforeSave() {
		if($this->isNewRecord) {
			$this->dtCreated = date('Y-m-d H:i:s');
			
		}
		return parent::beforeSave();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dtCreated' => 'Dt Created',
			'Action' => 'Action',
			'Completed' => 'Completed',
			'SKU' => 'Sku',
			'name' => 'Name',
			'salePrice' => 'Sale Price',
			'manufacturer' => 'Manufacturer',
			'MPN' => 'Mpn',
			'upc' => 'Upc',
			'ourCost' => 'Our Cost',
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

		$criteria->compare('dtCreated',$this->dtCreated,true);
		$criteria->compare('Action',$this->Action,true);
		$criteria->compare('Completed',$this->Completed,true);
		$criteria->compare('SKU',$this->SKU,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('salePrice',$this->salePrice,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('MPN',$this->MPN,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('ourCost',$this->ourCost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UbsSkuFeed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
