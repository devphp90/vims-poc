<?php

/**
 * This is the model class for table "{{sup_new_item4}}".
 *
 * The followings are the available columns in table '{{sup_new_item4}}':
 * @property integer $id
 * @property integer $import_id
 * @property string $data
 */
class SupItemsNew extends CActiveRecord
{
	public $testvalue = 0,$testvalue1 = 0,$testvalue2 = 0;
	public $match_by_status = array(
    SupItemsNew::MATCH_VSKU=>'vSKU',
    SupItemsNew::MATCH_MPN_UPC_NAME=>'MPN+UPC+Nam',
    SupItemsNew::MATCH_MPN_UPC=>'MPN+UPC',
    SupItemsNew::MATCH_MPN_NAME=>'MPN+Nam',
    SupItemsNew::MATCH_UPC=>'UPC',
    SupItemsNew::MATCH_MPN=>'MPN'
  );
	public $showData = array();
	public $showColumn = array();
	public $sup_id;
	public $statusList = array('Undecide','Imported','No Import');
	public $price_diff;
	public $match = 2;
	public $percent_diff;
	public $match_by;
	public $importStatus = 'Will Import';
	public $isCalculated = 0;
	public $ubs_sku;

  const MATCH_VSKU     = 1;
  const MATCH_MPN_UPC_NAME = 6;
  const MATCH_MPN_UPC  = 2;
  const MATCH_MPN_NAME = 3;
  const MATCH_UPC      = 5;
  const MATCH_MPN      = 4;

  const MATCH_STATUS_YES       = 1;
  const MATCH_STATUS_NO        = 0;
  const MATCH_STATUS_MISMATCH  = 3;
  const MATCH_STATUS_UNDECIDED = 2;

  public $supplierName;

	/**
	 * Returns the static model of the specified AR class.
	 * @return SupNewItem4 the static model class
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
		return '{{sup_items_new}}';
	}
	
	public function unserializeData()
	{
		
		$this->showData = unserialize( base64_decode($this->data));
		$this->showColumn = unserialize($this->column);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
    return array(
      array('id, ubs_id, sup_id,supplierName, sup_sku, sup_sku_name, sup_description, ubs_sku,sup_price, sup_vsku, sup_vqoh, sup_status, mfg_sku, mfg_sku_plain, mfg_name, mfg_sku_name, mfg_upc, last_update, create_by, update_by, create_time, update_time, priceFrom, priceTo, mpnFrom, mpnTo', 'safe'),
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
      'supplier' => array(self::BELONGS_TO, 'Supplier', 'sup_id'),
      'ubs_inventory' => array(self::BELONGS_TO, 'UbsInventory', 'ubs_id'),
      // coz i dont like the naming above. :D
      'ubsInventory' => array(self::BELONGS_TO, 'UbsInventory', 'ubs_id'),
      'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
      'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
      'warehouse1' => array(self::HAS_ONE, 'SupWarehouse', array('sup_id' => 'sup_id')),
    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'import_id' => 'Import',
			'data' => 'Data',
			'mfg_sku'=>'MPN',
			'upc'=>'UPC',
			'sup_sku'=>'Sup SKU',
			'sup_vsku'=>'Sup vSKU',
			'sup_sku_name'=>'Sup Item Name',
		);
	}

	public function afterSave()
	{
		if(!$this->isCalculated){
			$this->isNewRecord = false;
			$this->calculate();
			$this->isCalculated = 1;
			$this->save();
		}
	}
	
	public function calculate()
	{
    // Moved to Update script since we need to insert new item per "match"
    /**
		$this->match_by = 0;
		$vsku = SupInventory::model()->find('lower(sup_vsku)=?',array(strtolower(trim($this->sup_vsku))));
		if($vsku != null && !empty($vsku->sup_vsku) && isset($vsku->ubs_inventory->id)){
			$this->match_by = self::MATCH_VSKU;
			$this->match_ubs_id = $vsku->ubs_inventory->id;
		}
		
		
		if(!$this->match_by){
			$mpnupc = UbsInventory::model()->find(array(
				'condition'=>'upc=:upc and mfg_name=:mfg_sku',
				'params'=>array(
					':upc'=>$this->upc,
					':mfg_sku'=>$this->mfg_sku,
				),
			));
			if($mpnupc != null){
				$this->match_by = self::MATCH_MPN_UPC;
				$this->match_ubs_id = $mpnupc->id;
			}
		}
		
		if(!$this->match_by){
//			$mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku,'mfg_title'=>$this->mfg_name));
//			if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name) && !empty($mpnmfgtitle->mfg_title))){
      if ($model = UbsInventory::model()->find(array(
            'condition' => 'mfg_name=:name AND mfg_title=:title',
            'params'    => array(':name' => $this->mfg_sku, ':title' => $this->mfg_name)
          ))) {
				if (!empty($model->mfg_name) && !empty($model->mfg_title)) {
          $this->match_by = self::MATCH_MPN_NAME;
          $this->match_ubs_id = $model->id;
        }
			}
		}

    if(!$this->match_by){
      $mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku));
      if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name))){
        $this->match_by = self::MATCH_MPN;
        $this->match_ubs_id = $mpnmfgtitle->id;
      }
    }
		
		if(!$this->match_by){
			$mpnupc = UbsInventory::model()->find(array(
				'condition'=>'upc=:upc',
				'params'=>array(
					':upc'=>$this->upc
				),
			));
			if($mpnupc != null && !empty($mpnupc->upc)){
				$this->match_by = self::MATCH_UPC;
				$this->match_ubs_id = $mpnupc->id;
			}
		}

//		if($this->match_by == ''){
//			$mpnmfgtitle = UbsInventory::model()->findByAttributes(array('mfg_name'=>$this->mfg_sku));
//			if($mpnmfgtitle != null && (!empty($mpnmfgtitle->mfg_name))){
//				$this->match_by = 4;
//				$this->match_ubs_id = $mpnmfgtitle->id;
//			}
//		}
    **/
	}
	
	public function afterFind()
	{
		
		switch($this->match_by){
			case 0:
				break;
			case 1:
				break;
			case 2:
				break;
			case 3:
				break;
			default:
		}
		if(Yii::app()->controller->action->id == 'newItemLink'){
			if($this->match_by != ''){
				$model = new SupInventory;
				$model->sup_vsku = $this->sup_vsku;
				$model->mfg_sku = $this->mfg_sku;
				$model->mfg_upc = $this->upc;
				$model->mfg_name = $this->mfg_name;
				$model->mfg_sku_name = $this->mfg_part_name;
				$model->sup_sku = $this->sup_sku;
				$model->sup_sku_name = $this->sup_sku_name;
				$model->sup_description = $this->sup_description;
				$model->sup_id = $this->import_routine->sup_id;
				$model->ubs_id = $this->ubsinventory->id;
				$model->sup_status = 1;
				$model->supplier_name = $this->import_routine->supplier->name;
				if(!$model->validate()){
					$this->importStatus = '';
					$i=1;
					foreach($model->getErrors() as $attribute=>$reason)
						$this->importStatus .= $i++.'. '.$attribute.'=>'.implode(',', $reason).'     ';
					
				}
			}else
				$this->importStatus = 'No Match will not import!';

		}
		



	}
	
	
	public function showData()
	{
		$this->unserializeData();
		foreach($this->showData as $id=>$value){
			if($id > 2){
				echo '...';
				break;
				
			}
				
			echo $this->showColumn[$id],': ';
			echo $value;
			echo '<br/>';
			
		}

	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
  public function search() {
    $criteria = new CDbCriteria;

    $criteria->with = 'supplier';
    $criteria->compare('sup_id', $this->sup_id);

    if (strpos($this->supplierName, '*') !== false) {
      $supplierName = str_replace('*', '%', $this->supplierName);
      $criteria->addCondition("supplier.name LIKE '{$supplierName}'");
    } else {
      $criteria->compare('supplier.name', $this->supplierName);
    }

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'pagination' => array('pageSize' => 10),
      'sort'=>array(
        'defaultOrder'=>'supplier.name',
        'attributes' => array(
          'supplierName' => array(
            'asc'  => 'supplier.name',
            'desc' => 'supplier.name DESC',
          ),
          '*'
        ),
      ),
    ));
  }
}