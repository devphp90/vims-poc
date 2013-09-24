<?php

/**
 * This is the model class for table "{{tabs}}".
 *
 * The followings are the available columns in table '{{tabs}}':
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $import_routine_id
 * @property integer $create_by
 * @property integer $update_by
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TabsWarehouse[] $tabsWarehouses
 */
class UBSData extends UBSActiveRecord
{

	public function getDbConnection()
    {
        return self::getdb2Connection();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tabs the static model class
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
		return 'tmp_Axeo_Test_Products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ProductID, Sku', 'safe', 'on'=>'search'),
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
		
		$criteria->compare('ProductID',$this->ProductID);
		$criteria->compare('Sku',$this->Sku,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
}