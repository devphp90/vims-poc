<?php

/**
 * This is the model class for table "vims_email_suppliers".
 *
 * The followings are the available columns in table 'vims_email_suppliers':
 * @property integer $id
 * @property string $supplier_id
 * @property string $content
 */
class EmailSuppliers extends CActiveRecord {

    public $supplier_name;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmailSuppliers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'vims_email_suppliers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplier_name, content', 'required'),
			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
            array('supplier_id', 'length', 'max' => 10),
            array('supplier_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, supplier_id, content', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'supplier_id' => 'Supplier',
            'content' => 'Content',
        );
    }

    public function beforeSave()
	{
		$this->supplier_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;

		return true;
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('supplier_id', $this->supplier_id, true);
        $criteria->compare('content', $this->content, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    // for parsing the html data

    public function parseTemplate($content) {

        $data_count = 0;
        $result = array();

        $rows = EmailSuppliers::domParser($content, 'tr');

        if ($rows->length == 0)
            return;
        // for table data
        foreach ($rows as $row) {

            if ($data_count == 0) {
                $header = $row->getElementsByTagName('th');
                $row_count = $header->length;
            } else {
                $cols = '';
                $cols = $row->getElementsByTagName('td');

                # for table heading
                $data = '';

                for ($i = 0; $i < $row_count; $i++) {

                    $add_data = array($header->item($i)->nodeValue => $cols->item($i)->nodeValue);
                    $data = array_merge((array) $data, (array) $add_data);
                }
                $result[] = array_merge($result, (array) $data);
            }

            $data_count++;
        }

        return $result;
    }

    public function domParser($content, $element = 'tr') {

        $dom = new domDocument;

        @$dom->loadHTML($content);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');

        //print_r($tables);die();
        if ($tables->length == 0)
            return;

        $rows = $tables->item(0)->getElementsByTagName('tr');

        if ($rows->length == 0) {
            return;
        }

        if ($element == 'tr') {
            return $rows; // return $rows
        } elseif ($element == 'th') {// return table heading
            return $rows->item(0)->getElementsByTagName('th');
        } else {
            return;
        }
    }

}