<?php

/**
 * A widget to display Suppliers summary stats
 *
 * @author jovani
 */
class SuppliersWidget extends \CWidget
{
	/**
	* {@inheritdoc}
	*/
	public function run()
	{
		$total = Supplier::model()->count();
		$active = Supplier::model()->count('active = 1');
		$inactive = Supplier::model()->count('active = 0');
		$this->render('supplier', array(
			'total'    => $total,
			'active'   => $active,
			'inactive' => $inactive,
		));
	}
}