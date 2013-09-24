<?php

/**
 * A widget to display Supplier Items summary stats
 *
 * @author jovani
 */
class SupplierItemsWidget extends \CWidget
{
	/**
	* {@inheritdoc}
	*/
	public function run()
	{
		$total = SupInventory::model()->count();
		$active = SupInventory::model()->count('item_status = 1');
		$inactive = SupInventory::model()->count('item_status = 0');
		$this->render('items', array(
			'total'    => $total,
			'active'   => $active,
			'inactive' => $inactive,
		));
	}
}