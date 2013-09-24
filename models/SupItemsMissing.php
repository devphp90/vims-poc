<?php
/**
 * SupItemsMissing
 *
 * @author jovani
 */
class SupItemsMissing extends CActiveRecord
{
  const STATUS_BACK_ORDER   = 0;
  const STATUS_IN_STOCK     = 1;
  const STATUS_DISCONTINUED = 2;
  const STATUS_MISSING      = 3;

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
		return '{{sup_items_missing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, ubs_id, sup_id,supplier_name, sup_sku, sup_sku_name, sup_description, ubs_sku,sup_price, sup_vsku, sup_vqoh, sup_status, mfg_sku, mfg_sku_plain, mfg_name, mfg_sku_name, mfg_upc, last_update, create_by, update_by, create_time, update_time, priceFrom, priceTo, mpnFrom, mpnTo', 'safe'),
		);
	}

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
    );
  }

  public function afterFind()
  {
    $this->supplier_name = $this->supplier->name;
    /**
     * Updated query to apply `status`
     *
     * @since 07.15.2013
     * @author jovani
     */
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

    $this->ubs_sku = $row['ubs_sku'];

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
  
  public function search()
  {
    $criteria = new CDbCriteria;
    $criteria->compare('sup_id', $this->sup_id);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination'=>array('pageSize'=>10),
    ));
  }
}