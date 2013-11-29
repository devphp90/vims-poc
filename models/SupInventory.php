<?php

/**
 * This is the model class for table "{{sup_inventory}}".
 *
 * The followings are the available columns in table '{{sup_inventory}}':
 * @property integer $id
 * @property integer $ubs_id
 * @property integer $sup_id
 * @property string $sup_sku
 * @property string $sup_sku_name
 * @property string $sup_description
 * @property double $sup_price
 * @property string $sup_vsku
 * @property integer $sup_vqoh
 * @property integer $sup_status
 * @property string $mfg_sku
 * @property string $mfg_sku_plain
 * @property string $mfg_name
 * @property string $mfg_sku_name
 * @property string $mfg_upc
 * @property string $last_update
 * @property integer $create_by
 * @property integer $update_by
 * @property string $create_time
 * @property string $update_time
 */
class SupInventory extends CActiveRecord
{
	public $item_status = 1;
	public $priceFrom;
	public $priceTo;
	public $mpnFrom;
	public $mpnTo;
	public $qty_total;
	public $supplier_name;
	public $ubs_sku;

	public $iBuffer;
	public $sBuffer;
	public $gBuffer;

	public $validateSupModel;
	public $isCalculated;

  // Temporary field to hold imported seed sheet
  public $importFile;

  const STATUS_BACK_ORDER   = 0;
  const STATUS_IN_STOCK     = 1;
  const STATUS_DISCONTINUED = 2;
  const STATUS_MISSING      = 3;

  public static $statusToStringMap = array(
    self::STATUS_BACK_ORDER => 'BO',
    self::STATUS_IN_STOCK => 'INSTOCK',
    self::STATUS_DISCONTINUED => 'DISCO',
    self::STATUS_MISSING => 'MISSING',
  );

  const SCENARIO_OVERRIDE = 'override';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupInventory the static model class
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
		return '{{sup_inventory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('supplier_name','required'),

			array('supplier_name','exist','className'=>'Supplier','attributeName'=>'name'),
			array('ubs_id, sup_sku, sup_sku_name, sup_description, sup_vqoh,sup_bqoh, sup_status, mfg_sku, mfg_sku_plain, mfg_name, mfg_sku_name, mfg_upc, last_update', 'safe'),


			array('sup_sku, sup_sku_name, sup_description, mfg_sku, mfg_sku_plain, mfg_name, mfg_sku_name, mfg_upc', 'length', 'max'=>100),


			//done
			array('sup_status','validateSupstatus'),
			array('ubs_sku','validateUbsid'),
			array('sup_vsku','validateVsku'),
			array('qty_total_c, sup_price,sup_min_adv_price,cancel_rate_limit,uprice,umap,item_status','numerical'),
			array('sup_id, sup_vqoh, sup_status,sup_open_order, sup_drop,uqty', 'numerical', 'integerOnly'=>true),


			array('create_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'insert'),
			array('create_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_by','default','setOnEmpty'=>false,'value'=>Yii::app()->user->id,'on'=>'update'),
			array('update_time','default','setOnEmpty'=>false,'value'=>date("Y-m-d H:i:s"),'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ubs_id, sup_id,supplier_name, sup_sku, sup_sku_name, sup_description, ubs_sku,sup_price, sup_vsku, sup_vqoh, sup_status, mfg_sku, mfg_sku_plain, mfg_name, mfg_sku_name, mfg_upc, last_update, create_by, update_by, create_time, update_time, priceFrom, priceTo, mpnFrom, mpnTo', 'safe', 'on'=>'search'),
		);
	}


	public function getValidateSupModel()
	{
		
			
		if(!isset($this->validateSupModel)){
			
			$row = Yii::app()->db->createCommand(array(
			    'where'=>'name=:name',
				'select'=>'*',
				'from'=>'vims_supplier',
				'params'=>array(
					':name'=>$this->supplier_name,
				),
			))->queryRow();

			$this->validateSupModel = $row;

		}

		return $this->validateSupModel;

	}
	/**
	 * check if the user password is strong enough
	 * check the password against the pattern requested
	 * by the strength parameter
	 * This is the 'passwordStrength' validator as declared in rules().
	 */
	public function validateSupstatus($attribute,$params)
	{
		if($this->supplier != null)
		if($this->supplier_name != $this->supplier->name){
		$supplierRow = $this->getValidateSupModel();

		$active = $supplierRow['active'];


		if(!$active && $this->sup_status!=2)
	    	$this->addError($attribute, 'Supplier is Inactive, Sup item can only be BO');
	    }
	}

	public function validateUbsid($attribute,$params)
	{
		$supplierRow = $this->getValidateSupModel();


		$sup_id = $supplierRow['id'];

		$ubsInventory = UbsInventory::model()->findByAttributes(array('sku'=>$this->ubs_sku));

		if($ubsInventory == null)
			$this->addError($attribute, 'UBS SKU not exist in Ubs Items.');
		else{
			$SupInventory = SupInventory::model()->findByAttributes(array('ubs_id'=>$ubsInventory->id,'sup_id'=>$sup_id));
			if($SupInventory != null){
				if($SupInventory->id != $this->id)
					$this->addError($attribute, 'UBS SKU already in use in Supplier Items table, can\'t have duplicates.');
			}
		}
		

		if( $sup_id == null)
			$this->addError($attribute, 'Supplier not found.'.$this->ubs_id.'%'.$SupInventory->ubs_id);
	}

	public function validateVsku($attribute,$params)
	{
		//$sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;

		$supplierRow = $this->getValidateSupModel();

		$sup_id = $supplierRow['id'];


		$SupInventory = SupInventory::model()->findByAttributes(array('sup_vsku'=>$this->sup_vsku,'sup_id'=>$sup_id));

		if($SupInventory != null){
			if($SupInventory->id != $this->id)
				$this->addError($attribute, 'Sup vSKU already exist.');

		}
		if($sup_id == null)
			$this->addError($attribute, 'Supplier not found.');
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
			'create_user' => array(self::BELONGS_TO, 'User', 'create_by'),
			'update_user' => array(self::BELONGS_TO, 'User', 'update_by'),
			'warehouse1' => array(self::HAS_ONE, 'SupWarehouse', array('sup_id'=>'sup_id')),

			'warehouseitems' => array(self::HAS_MANY, 'SupWarehouseItem', array('vims_id')),

		);
	}

	public function beforeSave()
	{
		if(!isset($this->supplier_name) || !isset($this->ubs_sku))
			return false;
		if(!$this->isNewRecord){
			if($this->supplier_name != $this->supplier->name)
				$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;
			if($this->ubs_sku != $this->ubs_inventory->sku)
				$this->ubs_id = UbsInventory::model()->findByAttributes(array('sku'=>$this->ubs_sku))->id;
		}else{
			$this->sup_id = Supplier::model()->findByAttributes(array('name'=>$this->supplier_name))->id;

			$this->ubs_id = UbsInventory::model()->findByAttributes(array('sku'=>$this->ubs_sku))->id;
		}
		$this->sup_vsku = strtolower($this->sup_vsku);
		return true;
	}
	public function afterDelete()
	{

		SupWarehouseItem::model()->deleteAll('vims_id=?',array($this->id));
	}

	public function saveBO($botime)
	{

    $this->last_update = date("Y-m-d H:i:s");

//		if($this->sup_status == self::STATUS_IN_STOCK){
			$this->last_bo_update = date("Y-m-d H:i:s");
			$this->sup_status = self::STATUS_BACK_ORDER;

//		}
    // Missing to Discontinued
//		if($this->sup_drop == 1){
	    	$timeDiff = time() - strtotime($this->last_bo_update);
	    	$boday = floor($timeDiff / (60 * 60 * 24));

	    	if($boday >= $botime)
	    		$this->sup_status = self::STATUS_DISCONTINUED;
//		}
		$this->save(false);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Vims ID',
			'ubs_id' => 'UBS SKU#',
			'sup_id' => 'Supplier',
			'sup_sku' => 'Supplier SKU',
			'sup_sku_name' => 'Supplier SKU Name',
			'sup_description' => 'Supplier Description',
			'sup_price' => 'VIMS Supplier Price',
			'sup_min_adv_price'=>'VIMS MAP',
			'qty_total'=>'sQOH',
			'sup_vsku' => 'vSKU',
			'sup_vqoh' => 'vQOH',
			'sup_bqoh' => 'bQOH',
			'sup_vqoh_c' => 'vQTY',
			'sup_bqoh_c' => 'bQTY',
			'sup_status' => 'Status',
			'sup_open_order'=>'Open Orders',
			'mfg_sku' => 'MPN',
			'mfg_sku_plain' => 'Manufacturer Part # (Plain)',
			'mfg_name' => 'Manufacturer Name',
			'mfg_sku_name' => 'Manufacturer Part Name',
			'mfg_upc' => 'UPC',
			'last_update' => 'Last Update',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'iBuffer'=>'iBuffer',
			'sBuffer'=>'sBuffer',
			'gBuffer'=>'gBuffer',
			'ibuffer_c'=>'iBuffer',
			'sbuffer_c'=>'sBuffer',
			'gbuffer_c'=>'gBuffer',
			'uprice'=>'User Price',
			'umap'=>'User MAP',
			'uqty'=>'User Qty',
		);
	}

	public function afterFind()
	{
		if($this->supplier != null)
			$this->supplier_name = $this->supplier->name;
		/**
		 * Updated query to apply `status`
		 *
		 * @since 07.15.2013
		 * @author jovani
		 */
/*
		$row = Yii::app()->db->createCommand(array(

				'select'=>'(SELECT COALESCE(qty,0) as iBuffer FROM `vims_import_sup_item_buffer_rule` WHERE `status` = 1 AND `to`>:ito and `from` <=:ifrom and sup_id=:isid and ubs_id=:iusid limit 1) as iBuffer,
									 (SELECT COALESCE(qty,0) as sBuffer FROM `vims_import_sup_buffer_rule` WHERE `status` = 1 AND `to`>:sto and `from` <=:sfrom and sup_id=:ssid limit 1) as sBuffer,
									 (SELECT COALESCE(qty,0) as gBuffer FROM `vims_import_buffer_rule` WHERE `status` = 1 AND `to`>:gto and `from` <=:gfrom) as gBuffer,
									 (select COALESCE(sum(qty_on_hand),0) as qty from vims_sup_warehouse_item where vims_id = :vims_id) as qty,
									 (select sku from vims_ubs_inventory where id=:ubs_id) as ubs_sku',
				'from'=>'vims_system_info',
				'params'=>array(
					':ito'=>$this->sup_price,
					':ifrom'=>$this->sup_price,
					':isid'=>$this->sup_id,
					':iusid'=>$this->ubs_id,
					':sto'=>$this->sup_price,
					':sfrom'=>$this->sup_price,
					':ssid'=>$this->sup_id,
					':gto'=>$this->sup_price,
					':gfrom'=>$this->sup_price,
					':vims_id'=>$this->id,
					':ubs_id'=>$this->ubs_id,

				),
		))->queryRow();
		$this->qty_total = $row['qty'];
		$this->sBuffer = $row['sBuffer'];
		$this->iBuffer = $row['iBuffer'];
		$this->gBuffer = $row['gBuffer'];
		$this->sup_bqoh = $this->qty_total - $this->getBuffer();
		$this->sup_vqoh = $this->sup_bqoh - $this->sup_open_order;
*/
		if($this->ubs_inventory != null)
			$this->ubs_sku = $this->ubs_inventory->sku;

	}
	public function getBuffer()
	{
		if($this->iBuffer != 0)
			return $this->iBuffer;
		else if($this->sBuffer != 0)
			return $this->sBuffer;
		else if($this->gBuffer != 0)
			return $this->gBuffer;

	}
	public function getiBuffer()
	{
		/**
		 * Updated query to apply `status`
		 *
		 * @since 07.15.2013
		 * @author jovani
		 */
		$row = Yii::app()->db->createCommand(array(

			    'where'=>'`status` = 1 AND `to`>=:to and `from` <=:from and sup_id=:sup_id and ubs_id=:ubs_id',
				'select'=>'COALESCE(qty,0) as qty',
				'from'=>'vims_import_sup_item_buffer_rule',
				'params'=>array(
					':sup_id'=>$this->sup_id,
					':to'=>$this->sup_price,
					':from'=>$this->sup_price,
					':ubs_id'=>$this->ubs_id,
				),
		))->queryRow();

		return $row['qty'];
	}

	public function afterSave()
	{
    if (in_array($this->sup_status, array(self::STATUS_MISSING, self::STATUS_DISCONTINUED))) {
      parent::afterSave();
      return;
    }

		$warehouse = SupWarehouse::model()->findAll('sup_id=?',array($this->sup_id));

		$warehouseitem = SupWarehouseItem::model()->findAll('vims_id=?',array($this->id));
		if(count($warehouseitem) != count($warehouse)){
			foreach($warehouse as $id=>$name){

				$a = SupWarehouseItem::model()->find('vims_id=? and ware_id=?',array($this->id,$name->id));
				if($a == null){

					$model = new SupWarehouseItem;
					$model->vims_id = $this->id;
					$model->ware_id = $name->id;
					if(!$model->save()){
            var_dump($model->getErrors());
					}
				}
			}

		}
		if(!$this->isCalculated){
			$this->calculate();
			$this->isNewRecord = false;
			$this->isCalculated = 1;
			$this->save(false);
		}

	}

	public function calculate()
	{
    if (in_array($this->sup_status, array(self::STATUS_MISSING, self::STATUS_DISCONTINUED))
        || $this->getScenario() == self::SCENARIO_OVERRIDE)
      return;

		/**
		 * Updated query to apply `status`
		 *
		 * @since 07.15.2013
		 * @author jovani
		 */
		$this->supplier_name = $this->supplier->name;
		$row = Yii::app()->db->createCommand(array(

				'select'=>'(SELECT COALESCE(qty,0) as iBuffer FROM `vims_import_sup_item_buffer_rule` WHERE `status` = 1 AND `to`>:ito and `from` <=:ifrom and sup_id=:isid and ubs_id=:iusid limit 1) as iBuffer,
									 (SELECT COALESCE(qty,0) as sBuffer FROM `vims_import_sup_buffer_rule` WHERE `status` = 1 AND `to`>:sto and `from` <=:sfrom and sup_id=:ssid limit 1) as sBuffer,
									 (SELECT COALESCE(qty,0) as gBuffer FROM `vims_import_buffer_rule` WHERE `status` = 1 AND `to`>:gto and `from` <=:gfrom) as gBuffer,
									 (select COALESCE(sum(qty_on_hand),0) as qty from vims_sup_warehouse_item where vims_id = :vims_id) as qty,
									 (select sku from vims_ubs_inventory where id=:ubs_id) as ubs_sku',
				'from'=>'vims_system_info',
				'params'=>array(
					':ito'=>$this->sup_price,
					':ifrom'=>$this->sup_price,
					':isid'=>$this->sup_id,
					':iusid'=>$this->ubs_id,
					':sto'=>$this->sup_price,
					':sfrom'=>$this->sup_price,
					':ssid'=>$this->sup_id,
					':gto'=>$this->sup_price,
					':gfrom'=>$this->sup_price,
					':vims_id'=>$this->id,
					':ubs_id'=>$this->ubs_id,

				),
		))->queryRow();

		$this->qty_total_c = $row['qty'];
		$this->sbuffer_c = $row['sBuffer'];
		$this->ibuffer_c = $row['iBuffer'];
		$this->gbuffer_c = $row['gBuffer'];

		if($this->ibuffer_c != 0)
			$this->buffer_c = $this->ibuffer_c;
		else if($this->sbuffer_c != 0)
			$this->buffer_c = $this->sbuffer_c;
		else
			$this->buffer_c = $this->gbuffer_c;

		$this->sup_bqoh_c = $this->qty_total_c - $this->buffer_c;
		$this->sup_vqoh_c = $this->sup_bqoh_c - $this->sup_open_order;
        //echo $this->getOverRideRules();die('here');
		$this->uprice = $this->getOverRideRules(); //
		$this->primary_price_c = $this->uprice != 0 ? $this->uprice : $this->sup_price;
        //$this->sup_status = 1;
        if ($this->qty_total_c == 0) {
            $this->sup_status = self::STATUS_BACK_ORDER;//Back Order
        }
        elseif ($this->qty_total_c > 0) {
            $this->sup_status = self::STATUS_IN_STOCK;//In Stock
        }


	}

	public function getoverRideRules()
	{
		$price = 0;

		if($this->getORApplyToAll() != 0) {
            $price =  $this->getORApplyToAll();
        }
		elseif($this->getORApplyToPrice() != 0)
			$price = $this->getORApplyToPrice();

		elseif($this->getORApplyToGroup() != 0)
			$price = $this->getORApplyToGroup();

		elseif($this->getORApplyToVSKU() != 0)
			$price = $this->getORApplyToVSKU();

        return $price;
	}

	public function getORApplyToVSKU()
	{
		$rules = ImportSupOverride::model()->findByAttributes(array(
				"sup_id"=>$this->sup_id
			),
			'applies_to_one_item=:sup_vsku',
			array(
				':sup_vsku'=>$this->sup_vsku,
			));

		if($rules!= null)
			return $this->getOverRideValue($rules);
		else
			return 0;
	}

	public function getORApplyToGroup()
	{
		$rules = ImportSupOverride::model()->findByAttributes(array(
				"sup_id"=>$this->sup_id
			),
			'applies_to_group=:mfg_name',
			array(
				':mfg_name'=>$this->mfg_name,
			));

		if($rules!= null)
			return $this->getOverRideValue($rules);
		else
			return 0;
	}

	public function getORApplyToPrice()
	{
		$rules = ImportSupOverride::model()->findByAttributes(array(
				"sup_id"=>$this->sup_id
			),
			'`from`<=:price and `to`>=:price1',
			array(
				':price'=>$this->sup_price,
				':price1'=>$this->sup_price,
			));

		if($rules!= null)
			return $this->getOverRideValue($rules);
		else
			return 0;
	}

	public function getORApplyToAll()
	{
		$rules = ImportSupOverride::model()->findByAttributes(array(
				"sup_id"=>$this->sup_id
			),
			'start<=:date1 and end>=:date2 and applies_to_all=1',
			array(
				':date1'=>date("Y-m-d H:i:s"),
				':date2'=>date("Y-m-d H:i:s"),
			));
		if($rules!= null){
			return $this->getOverRideValue($rules);
		}else
			return 0;
	}

	public function getOverRideValue($rules)
	{
		if($rules->percent_adjust != 0){
			return $this->sup_price + ($rules->percent_adjust*0.01*$this->sup_price);
		}else if($rules->dollar_adjust !=0){
			return $this->sup_price + ($rules->dollar_adjust);
		}else{
			return $this->dollar_fixed;
		}
	}
	public function getsBuffer()
	{
		$row = Yii::app()->db->createCommand(array(

			    'where'=>'`to`>=:to and `from` <=:from and sup_id=:sup_id',
				'select'=>'COALESCE(qty,0) as qty',
				'from'=>'vims_import_sup_buffer_rule',
				'params'=>array(
					':sup_id'=>$this->sup_id,
					':to'=>$this->sup_price,
					':from'=>$this->sup_price,
				),
		))->queryRow();
		return $row['qty'];

	}
	public function getuBuffer()
	{

		$row = Yii::app()->db->createCommand(array(

			    'where'=>'`to`>=:to and `from` <=:from',
				'select'=>'COALESCE(qty,0) as qty',
				'from'=>'vims_import_buffer_rule',
				'params'=>array(
					':to'=>$this->sup_price,
					':from'=>$this->sup_price,
				),
		))->queryRow();
		return $row['qty'];
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

		$criteria->select = '*';
		$criteria->with= array('supplier');
		$criteria->together = true;
		$criteria->params = array();
//		$criteria->condition = 'sup_drop=0';
		if(!empty($this->mfg_sku)){
			$criteria->addCondition('mfg_sku like :mfg_sku');
			$criteria->params[':mfg_sku'] = str_replace('*', '%', $this->mfg_sku);
		}

		if(!empty($this->priceFrom)){
			$criteria->addCondition('sup_price >= :priceFrom');
			$criteria->params[':priceFrom'] = $this->priceFrom;

		}
		if(!empty($this->priceTo)){
			$criteria->addCondition('sup_price <= :priceTo');
			$criteria->params[':priceTo'] = $this->priceTo;
		}

		if(!empty($this->mpnFrom)){
			$criteria->addCondition('SUBSTRING(mfg_sku,1,1) >= :mpnFrom');
			$criteria->params[':mpnFrom'] = $this->mpnFrom;

		}
		if(!empty($this->mpnTo)){
			$criteria->addCondition('SUBSTRING(mfg_sku,1,1) <= :mpnTo');
			$criteria->params[':mpnTo'] = $this->mpnTo;
		}



		$criteria->join = 'left join vims_ubs_inventory as ubs on t.ubs_id= ubs.id';

		$criteria->compare('t.id',$this->id);
		$criteria->compare('ubs.sku',$this->ubs_sku,true);

		$criteria->compare('supplier.name',$this->supplier_name,true);
		$criteria->compare('sup_sku',$this->sup_sku,true);
		$criteria->compare('sup_sku_name',$this->sup_sku_name,true);
		$criteria->compare('sup_description',$this->sup_description,true);
		$criteria->compare('sup_price',$this->sup_price);
		$criteria->compare('sup_vsku',$this->sup_vsku,true);
		$criteria->compare('sup_vqoh',$this->sup_vqoh);
		$criteria->compare('sup_status',$this->sup_status);
//		$criteria->compare('mfg_sku',$this->mfg_sku,true);
		$criteria->compare('mfg_sku_plain',$this->mfg_sku_plain,true);
		$criteria->compare('t.mfg_name',$this->mfg_name,true);
//		$criteria->compare('mfg_sku_name',$this->mfg_sku_name,true);
		$criteria->compare('mfg_upc',$this->mfg_upc,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>10),
			'sort'=>array(
				'defaultOrder'=>'supplier.name',
			),
		));
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dropitem()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = '*';
		$criteria->with= array('supplier');
		$criteria->together = true;
		$criteria->condition = 'sup_drop=1';
		$criteria->join = 'left join vims_ubs_inventory as ubs on t.ubs_id= ubs.id';

		$criteria->compare('t.id',$this->id);
		$criteria->compare('ubs.sku',$this->ubs_sku,true);

		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('sup_sku',$this->sup_sku,true);
		$criteria->compare('sup_sku_name',$this->sup_sku_name,true);
		$criteria->compare('sup_description',$this->sup_description,true);
		$criteria->compare('sup_price',$this->sup_price);
		$criteria->compare('sup_vsku',$this->sup_vsku,true);
		$criteria->compare('sup_vqoh',$this->sup_vqoh);
		$criteria->compare('sup_status',$this->sup_status);
		$criteria->compare('mfg_sku',$this->mfg_sku,true);
		$criteria->compare('mfg_sku_plain',$this->mfg_sku_plain,true);
		$criteria->compare('t.mfg_name',$this->mfg_name,true);
		$criteria->compare('mfg_sku_name',$this->mfg_sku_name,true);
		$criteria->compare('mfg_upc',$this->mfg_upc,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>100),
			'sort'=>array(
				'defaultOrder'=>'supplier.name',
			),
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function supdropitem($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = '*';
		$criteria->with= array('supplier');
		$criteria->together = true;
		$criteria->condition = 'sup_drop=1';
		$criteria->join = 'left join vims_ubs_inventory as ubs on t.ubs_id= ubs.id';

		$criteria->compare('t.id',$this->id);
		$criteria->compare('ubs.sku',$this->ubs_sku,true);

		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('sup_sku',$this->sup_sku,true);
		$criteria->compare('sup_sku_name',$this->sup_sku_name,true);
		$criteria->compare('sup_description',$this->sup_description,true);
		$criteria->compare('sup_price',$this->sup_price);
		$criteria->compare('sup_vsku',$this->sup_vsku,true);
		$criteria->compare('sup_vqoh',$this->sup_vqoh);
		$criteria->compare('sup_status',$this->sup_status);
		$criteria->compare('mfg_sku',$this->mfg_sku,true);
		$criteria->compare('mfg_sku_plain',$this->mfg_sku_plain,true);
		$criteria->compare('mfg_name',$this->mfg_name,true);
		$criteria->compare('mfg_sku_name',$this->mfg_sku_name,true);
		$criteria->compare('mfg_upc',$this->mfg_upc,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>100),
			'sort'=>array(
				'defaultOrder'=>'supplier.name',
			),
		));
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function supview($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = '*';

		$criteria->with= array('supplier','ubs_inventory');

		$criteria->together = true;
		$criteria->condition = 'sup_id=:sup_id';
		$criteria->params = array(
			':sup_id'=>$id,
		);

//		$criteria->join = 'left join vims_ubs_inventory as ubs on t.ubs_id= ubs.id';

		$criteria->compare('t.id',$this->id);
		$criteria->compare('ubs_inventory.sku',$this->ubs_sku,true);




		$criteria->compare('sup_id',$this->sup_id);
		$criteria->compare('sup_sku',$this->sup_sku,true);
		$criteria->compare('sup_sku_name',$this->sup_sku_name,true);
		$criteria->compare('sup_description',$this->sup_description,true);
		$criteria->compare('sup_price',$this->sup_price);
		$criteria->compare('sup_vsku',$this->sup_vsku,true);
		$criteria->compare('sup_vqoh',$this->sup_vqoh);
		$criteria->compare('sup_status',$this->sup_status);
		$criteria->compare('mfg_sku',$this->mfg_sku,true);
		$criteria->compare('mfg_sku_plain',$this->mfg_sku_plain,true);
		$criteria->compare('t.mfg_name',$this->mfg_name,true);
		$criteria->compare('mfg_sku_name',$this->mfg_sku_name,true);
		$criteria->compare('mfg_upc',$this->mfg_upc,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>100),
			'sort'=>array(
				'defaultOrder'=>'sup_vsku',
			),
		));
	}
}