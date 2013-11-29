<?php

/**
 * This is the model class for table "ubs_suppliers".
 *
 * The followings are the available columns in table 'ubs_suppliers':
 * @property integer $SupplierID
 * @property string $SupplierName
 * @property string $Address1
 * @property string $Address2
 * @property string $City
 * @property string $State
 * @property string $Zip
 * @property string $Country
 * @property string $Email
 * @property string $Fax
 * @property string $Phone
 * @property string $TollFreePhone
 * @property string $MainContact
 * @property string $MainContactPhone
 * @property string $Phone_2
 * @property string $TimeStamp
 * @property string $Phone2
 */
class UbsSupplier extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UbsSupplier the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ubs_suppliers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('SupplierName', 'length', 'max' => 200),
            array('Address1, Address2, City, State, Zip, Country, Email, Fax, Phone, TollFreePhone, MainContact, MainContactPhone, Phone_2, Phone2', 'length', 'max' => 50),
            //array('TimeStamp', 'safe'),
            array('SupplierID', 'numerical', 'integerOnly'=>true),
            array('Email', 'email'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('SupplierID, SupplierName, Address1, Address2, City, State, Zip, Country, Email, Fax, Phone, TollFreePhone, MainContact, MainContactPhone, Phone_2, TimeStamp, Phone2', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'SupplierID' => 'UBS Supplier ID',
            'SupplierName' => 'Supplier Name',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'City' => 'City',
            'State' => 'State',
            'Zip' => 'Zip',
            'Country' => 'Country',
            'Email' => 'Email',
            'Fax' => 'Fax',
            'Phone' => 'Phone',
            'TollFreePhone' => 'Toll Free Phone',
            'MainContact' => 'Main Contact',
            'MainContactPhone' => 'Main Contact Phone',
            'Phone_2' => 'Phone 2',
            //'TimeStamp' => 'Time Stamp',
            'Phone2' => 'Phone2',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('SupplierID', $this->SupplierID);
        $criteria->compare('SupplierName', $this->SupplierName, true);
        $criteria->compare('Address1', $this->Address1, true);
        $criteria->compare('Address2', $this->Address2, true);
        $criteria->compare('City', $this->City, true);
        $criteria->compare('State', $this->State, true);
        $criteria->compare('Zip', $this->Zip, true);
        $criteria->compare('Country', $this->Country, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->compare('Fax', $this->Fax, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('TollFreePhone', $this->TollFreePhone, true);
        $criteria->compare('MainContact', $this->MainContact, true);
        $criteria->compare('MainContactPhone', $this->MainContactPhone, true);
        $criteria->compare('Phone_2', $this->Phone_2, true);
        //$criteria->compare('TimeStamp',$this->TimeStamp,true);
        $criteria->compare('Phone2', $this->Phone2, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}