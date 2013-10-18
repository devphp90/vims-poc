<?php

/**
 * This is the model class for table "{{supp_vsheet_dups}}".
 *
 * The followings are the available columns in table '{{supp_vsheet_dups}}':
 * @property integer $id
 * @property integer $import_id
 * @property integer $sup_id
 * @property integer $sheet_type
 * @property integer $update_type
 * @property string $sup_vsku
 * @property double $price
 * @property double $map
 * @property integer $ware_1
 * @property integer $ware_2
 * @property integer $ware_3
 * @property integer $ware_4
 * @property integer $ware_5
 * @property integer $ware_6
 * @property string $mfg_sku
 * @property string $mfg_name
 * @property string $mfg_part_name
 * @property string $upc
 * @property string $sup_sku
 * @property string $sup_sku_name
 */
class SuppVsheetDup extends CActiveRecord {

    public $supplierName;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{supp_vsheet_dups}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('import_id, sup_id, sheet_type, update_type, sup_vsku, price, map, ware_1, ware_2, ware_3, ware_4, ware_5, ware_6, mfg_sku, mfg_name, mfg_part_name, upc, sup_sku, sup_sku_name', 'required'),
            array('import_id, sup_id, sheet_type, update_type, ware_1, ware_2, ware_3, ware_4, ware_5, ware_6', 'numerical', 'integerOnly' => true),
            array('price, map', 'numerical'),
            array('sup_vsku, mfg_sku, mfg_name, mfg_part_name, upc, sup_sku, sup_sku_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, import_id, supplierName, sup_id, sheet_type, update_type, sup_vsku, price, map, ware_1, ware_2, ware_3, ware_4, ware_5, ware_6, mfg_sku, mfg_name, mfg_part_name, upc, sup_sku, sup_sku_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'import_id' => 'Import',
            'sup_id' => 'Sup',
            'sheet_type' => 'Sheet Type',
            'update_type' => 'Update Type',
            'sup_vsku' => 'Sup Vsku',
            'price' => 'Price',
            'map' => 'Map',
            'ware_1' => 'Ware 1',
            'ware_2' => 'Ware 2',
            'ware_3' => 'Ware 3',
            'ware_4' => 'Ware 4',
            'ware_5' => 'Ware 5',
            'ware_6' => 'Ware 6',
            'mfg_sku' => 'Mfg Sku',
            'mfg_name' => 'Mfg Name',
            'mfg_part_name' => 'Mfg Part Name',
            'upc' => 'Upc',
            'sup_sku' => 'Sup Sku',
            'sup_sku_name' => 'Sup Sku Name',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->with = 'supplier';
        $criteria->compare('sup_id', $this->sup_id);

        $criteria->compare('id', $this->id);
        $criteria->compare('import_id', $this->import_id);
        if (strpos($this->supplierName, '*') !== false) {
            $supplierName = str_replace('*', '%', $this->supplierName);
            $criteria->addCondition("supplier.name LIKE '{$supplierName}'");
        } else {
            $criteria->compare('supplier.name', $this->supplierName);
        }
        $criteria->compare('sheet_type', $this->sheet_type);
        $criteria->compare('update_type', $this->update_type);
        $criteria->compare('sup_vsku', $this->sup_vsku, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('map', $this->map);
        $criteria->compare('ware_1', $this->ware_1);
        $criteria->compare('ware_2', $this->ware_2);
        $criteria->compare('ware_3', $this->ware_3);
        $criteria->compare('ware_4', $this->ware_4);
        $criteria->compare('ware_5', $this->ware_5);
        $criteria->compare('ware_6', $this->ware_6);
        $criteria->compare('mfg_sku', $this->mfg_sku, true);
        $criteria->compare('mfg_name', $this->mfg_name, true);
        $criteria->compare('mfg_part_name', $this->mfg_part_name, true);
        $criteria->compare('upc', $this->upc, true);
        $criteria->compare('sup_sku', $this->sup_sku, true);
        $criteria->compare('sup_sku_name', $this->sup_sku_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
            'sort' => array(
                'defaultOrder' => 'supplier.name',
                'attributes' => array(
                    'supplierName' => array(
                        'asc' => 'supplier.name',
                        'desc' => 'supplier.name DESC',
                    ),
                    '*'
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SuppVsheetDup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
