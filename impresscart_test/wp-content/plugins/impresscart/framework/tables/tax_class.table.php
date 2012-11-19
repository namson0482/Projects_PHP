<?php

class impresscart_tax_class_table extends impresscart_table {
	
	var $table = 'impresscart_tax_class';
	var $primaryKey = 'tax_class_id';	
	
	public function saveTax($tax, $rules) {
		# save tax class first
		$ID = $this->save($tax);
		if(isset($tax['tax_class_id'])) {
			$ID = $tax['tax_class_id'];
		}
		# save zones of this geo
		$table = impresscart_framework::table('tax_rule');
		$table->delete(array('tax_class_id' => $ID));
		foreach ($rules as $rule) {
			$rule['tax_class_id'] = $ID;
			unset($rule['tax_rule_id']);
			$table->save($rule);
		}
		return $ID;
	}
}