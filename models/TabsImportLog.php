<?php

/**
 * This is the model class for table "{{tabs_import_log}}".
 *
 * The followings are the available columns in table '{{tabs_import_log}}':
 * @property integer $id
 * @property integer $tabs_id
 * @property integer $download_sheet1_status
 * @property string $download_sheet1_reason
 * @property integer $download_sheet2_status
 * @property string $download_sheet2_reason
 * @property integer $data_integrity_status
 * @property string $data_integrity_reason
 * @property integer $overall_item_status
 * @property string $overall_item_reason
 *
 * The followings are the available model relations:
 * @property TabsMainLog $log
 */
class TabsImportLog extends CActiveRecord
{
	const STATUS_FAIL = 2;
	const STATUS_PASS = 3;

	public $_status = array(
		'',
		'PROCESSING',
		'<font color="red">FAIL</font>',
		'<font color="green">PASS</font>',
		'<font color="orange">WARNING</font>'
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabsImportLog the static model class
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
		return '{{tabs_import_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabs_id, download_sheet1_status, download_sheet1_reason, download_sheet2_status, download_sheet2_reason, data_integrity_status, data_integrity_reason, download_finish_time, overall_item_status, overall_item_reason,item, note, status,data_integrity_type_reason,data_integrity_type_status, data_integrity_count_status, data_integrity_count_reason, column_count', 'safe'),
			array('tabs_id, download_sheet1_status, download_sheet2_status, data_integrity_status, overall_item_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tabs_id, download_sheet1_status, download_sheet1_reason, download_sheet2_status, download_sheet2_reason, data_integrity_status, data_integrity_reason, overall_item_status, overall_item_reason', 'safe', 'on'=>'search'),
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
			'tab' => array(self::BELONGS_TO, 'Tabs', 'tabs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'download_sheet1_status' => 'Download Sheet1 Status',
			'download_sheet1_reason' => 'Download Sheet1 Reason',
			'download_sheet2_status' => 'Download Sheet2 Status',
			'download_sheet2_reason' => 'Download Sheet2 Reason',
			'data_integrity_status' => 'Data Integrity Status',
			'data_integrity_reason' => 'Data Integrity Reason',
			'overall_item_status' => 'Overall Item Status',
			'overall_item_reason' => 'Overall Item Reason',
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
		$criteria->compare('download_sheet1_status',$this->download_sheet1_status);
		$criteria->compare('download_sheet1_reason',$this->download_sheet1_reason,true);
		$criteria->compare('download_sheet2_status',$this->download_sheet2_status);
		$criteria->compare('download_sheet2_reason',$this->download_sheet2_reason,true);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('overall_item_status',$this->overall_item_status);
		$criteria->compare('overall_item_reason',$this->overall_item_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function supsearch($id)
	{

		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'tabs_id=:tabs_id';
		$criteria->params = array(
			'tabs_id'=>$id,
		);
		$criteria->compare('id',$this->id);
		$criteria->compare('download_sheet1_status',$this->download_sheet1_status);
		$criteria->compare('download_sheet1_reason',$this->download_sheet1_reason,true);
		$criteria->compare('download_sheet2_status',$this->download_sheet2_status);
		$criteria->compare('download_sheet2_reason',$this->download_sheet2_reason,true);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('overall_item_status',$this->overall_item_status);
		$criteria->compare('overall_item_reason',$this->overall_item_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'id desc'),
		));
	}

	public function failsearch()
	{

		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = 'download_sheet1_status = 2 or download_sheet2_status =2 or data_integrity_status=2 or overall_item_status = 2';
		$criteria->compare('id',$this->id);
		$criteria->compare('download_sheet1_status',$this->download_sheet1_status);
		$criteria->compare('download_sheet1_reason',$this->download_sheet1_reason,true);
		$criteria->compare('download_sheet2_status',$this->download_sheet2_status);
		$criteria->compare('download_sheet2_reason',$this->download_sheet2_reason,true);
		$criteria->compare('data_integrity_status',$this->data_integrity_status);
		$criteria->compare('data_integrity_reason',$this->data_integrity_reason,true);
		$criteria->compare('overall_item_status',$this->overall_item_status);
		$criteria->compare('overall_item_reason',$this->overall_item_reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'id desc'),
		));
	}

    public static function countFailImportUpdate()
    {
        $sql = self::getFailImportUpdateSql();

        $count = Yii::app()->db->createCommand("select count(a.tabs_id) count from ($sql) a")->queryScalar();
        return $count;
    }
    public static function getFailImportUpdateSql()
    {
        return "
            SELECT create_time, i.id as tabs_import_log_id, filetime, filetime2, overall_item_reason, overall_item_status, item, data_integrity_type_status,data_integrity_count_reason, column_count, data_integrity_type_reason, data_integrity_count_status,  sheet1_url, sheet2_url, i.tabs_id as tabs_id, download_sheet1_status, download_sheet2_status, download_sheet1_reason, data_integrity_status, data_integrity_reason, 'instock_item_status' = '', 'instock_item_reason' = ''
            FROM `vims_tabs_import_log` `i`
            WHERE (download_sheet1_status = 2 or download_sheet2_status =2 or i.data_integrity_status=2 or overall_item_status = 2)
            AND download_sheet1_reason NOT LIKE '%Supplier is Inactive%'
            AND create_time IN (
                SELECT max( create_time )
                FROM vims_tabs_import_log i2
                GROUP BY tabs_id )
            UNION
            SELECT 'create_time' = '', 'tabs_import_log_id' ='', 'filetime'='', 'filetime2' = '', 'overall_item_reason'='', 'overall_item_status'='', item, 'data_integrity_type_status' = '','data_integrity_count_reason' = '', 'column_count' = '', 'data_integrity_type_reason' = '', 'data_integrity_count_status'='', 'sheet1_url' ='', 'sheet2_url' ='', tabs_id, 'download_sheet1_status' = '', 'download_sheet2_status' = '', 'download_sheet1_reason' = '', data_integrity_status, data_integrity_reason , instock_item_status, instock_item_reason
            FROM `vims_tabs_update_log` `u`
            WHERE (data_integrity_status = 2 or instock_item_status =2)

        ";
    }
}