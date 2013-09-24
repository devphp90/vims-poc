<?php
class PartialUpdate
{
	public $data = array();
	public $importRoutineModel;
	public $_match = array();
	public $_warehouse = array();
	public $_newField = array();
	public $_countData = 0;
	
	public function __construct($import_id, $data)
	{
		$this->data = $data;	
		$this->importRoutineModel = ImportRoutine::model()->findByPk($import_id);
	}
	
	public function run()
	{
		$this->prepareMatch();
		
		foreach($this->data as $id=>$data){
			$this->genPureData($data);
		}

	}
	
	public function genPureData($row)
	{
		$this->_countData++;
		$result = array();
		$result['sup_vsku'] = strtolower($row[$this->_match['match1']].
									$row[$this->_match['match2']].
									$row[$this->_match['match3']]);
		
		$supItem = SupInventory::model()->findByAttributes(array(
			'sup_id'=>$this->importRoutineModel->supplier->id,
			'sup_vsku'=>$result['sup_vsku'],
		));
		
		if($supItem != null){
			$totalQOH = 0;
			
			foreach($this->_warehouse as $ware_id=>$ware_value) 
				if(!empty($row[$ware_value])){
					$result['ware_'.$ware_id] = $row[$ware_value];
					$totalQOH += $result['ware_'.$ware_id];
				}

			$supbQOH = $totalQOH + $supItem->getBuffer();
			$supvQOH = $supbQOH  - $supItem->sup_open_order;
			
			for($a=1;$a<=6;$a++)
				if($this->importRoutineModel->{'ware_'.$a}){
					$supWareItem = SupWarehouseItem::model()->findByAttributes(array(
						'vims_id'=>$supItem->id,
						'ware_id'=>$this->importRoutineModel->{'ware_id_'.$a},
					));
					
					if($supWareItem != null){
						$supWareItem->qty_on_hand = $result['ware_'.$a];
						$supWareItem->save();
					}
				}
			$supItem->last_update = date("Y-m-d H:i:s");
			
			if(!empty($row[$this->_match['price']]))
				$supItem->sup_price = $row[$this->_match['price']];

			if(!empty($row[$this->_match['map']]))
				$supItem->sup_min_adv_price = $row[$this->_match['map']];
								
//			$supItem->mfg_sku_name = $vsheet->mfg_part_name;

			$supItem->sup_bqoh = $supbQOH;
			$supItem->sup_vqoh = $supvQOH;
			
			if($supvQOH > 0)
				$supItem->sup_status = 1;
			else
				$supItem->saveBO($this->importRoutineModel->days_to_disco);
				
			if($supItem->save()){
				echo 'update success';
			}
		}
		
		return;
		echo $result['sup_vsku'];
		return;							
		if(!empty($result['sup_vsku'])){

			
					

			
				
			foreach($this->_newField as $newfield_id => $newfield_value)
				$result[$newfield_id] = $row[$newfield_value];
				
			
			//update 
		}
		
		return false;
	}
	
	public function prepareMatch()
	{
		$this->prepareField();
		
		$this->_match = array(
			'match1'=>$this->getMatchValue($this->importRoutineModel->sup_match_column),
			'match2'=>$this->getMatchValue($this->importRoutineModel->sup_match_column_1),
			'match3'=>$this->getMatchValue($this->importRoutineModel->sup_match_column_2),
			'price'=>$this->getMatchValue($this->importRoutineModel->price),
			'map'=>$this->getMatchValue($this->importRoutineModel->min_adv_price),
		);

		foreach($this->_warehouse as $target => &$field)
			if(($field = $this->getMatchValue($this->importRoutineModel->$field)) === NULL)
				unset($this->_warehouse[$target]);
		
		foreach($this->_newField as $target => &$field)
			if(($field = $this->getMatchValue($this->importRoutineModel->$field)) === NULL)
				unset($this->_newField[$target]);
	}
	
	public function prepareField()
	{
		$this->_warehouse = array(
			'1'=>'ware_1',
			'2'=>'ware_2',
			'3'=>'ware_3',
			'4'=>'ware_4',
			'5'=>'ware_5',
			'6'=>'ware_6',
		);
		$this->_newField = array(
			'mfg_sku'=>'new_mfg_sku',
			'upc'=>'new_upc',
			'mfg_name'=>'new_mfg_name',
			'mfg_part_name'=>'new_mfg_part_name',
			'sup_sku'=>'new_sup_sku',
			'sup_sku_name'=>'new_sup_sku_name',
			'sup_description'=>'new_sup_description',
		);
		
	}
	
	public function getMatchValue($field)
	{
		return empty($field) ? NULL : $field-1;
	}
}
?>