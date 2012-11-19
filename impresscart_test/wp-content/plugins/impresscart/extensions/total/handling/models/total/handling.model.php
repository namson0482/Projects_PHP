<?php
class impresscart_total_handling_model extends impresscart_model {


	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		$impresscart_totals['impresscart']['total']['handling'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}

	function get_setting() {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		if(is_array($impresscart_totals) && @$impresscart_totals['impresscart']['total']['handling']) {
			return @$impresscart_totals['impresscart']['total']['handling'];
		}
		return self::getDefaultValues();
	}

	public static function getDefaultValues() {
		return (array(
				'name' =>  'handling',
				'order' => '10',
				'status' => 'no',
				'code' => 'handling',
		));
	}

	public function getTotal(&$total_data, &$total, &$taxes) {

		if (($this->cart->getSubTotal() < $this->config->get('handling_total')) && ($this->cart->getSubTotal() > 0)) {

			$total_data[] = array(
				'code'       => 'handling',
        		'title'      => __('Handling', 'impressthemes'),
        		'text'       => $this->currency->format($this->config->get('handling_fee')),
        		'value'      => $this->get('fee'),
				'sort_order' => $this->get('sort_order')
			);

			if ($this->config->get('handling_tax_class_id')) {
				$tax_rates = $this->tax->getRates($this->config->get('handling_fee'), $this->config->get('handling_tax_class_id'));

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}

			$total += $this->get('fee');
		}
	}

}