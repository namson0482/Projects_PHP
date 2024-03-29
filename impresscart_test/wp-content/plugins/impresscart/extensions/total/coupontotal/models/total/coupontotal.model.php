<?php

class impresscart_total_coupontotal_model extends impresscart_model {

	function update_setting( $data = array()) {
		
		$impresscart_totals = get_option('impresscart_totals', true);
		
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
		
		$impresscart_totals['impresscart']['total']['coupontotal'] = $data;
		
		$update = update_option('impresscart_totals', $impresscart_totals);
		
	}
	 
	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
			
		if(is_array($impresscart_totals) && @$impresscart_totals['impresscart']['total']['coupontotal']) {
			return @$impresscart_totals['impresscart']['total']['coupontotal'];	
		}
		
		return self::getDefaultValues();		
	}
	
	public static function getDefaultValues() {
		return (array(
				'name' =>  'coupon',
				'order' => '4',
				'status' => 'no',
				'code' => 'coupon',
				));
	}
	
	 
	public function getTotal(&$total_data, &$total, &$taxes) {
		
		if (isset($this->session->data['coupon'])) {
			
			$coupon_model = impresscart_framework::model('checkout/coupon');
			$coupon_info = $coupon_model->getCoupon($this->session->data['coupon'][0]['code']);
			
			if ($coupon_info) {
				
				//echo "<pre>"; var_dump($coupon_info);
				//echo var_dump($coupon_info['coupon_product']);
				$discount_total = 0;
				if (!$coupon_info['coupon_product']) {
					$sub_total = $this->cart->getSubTotal();
				} else {
					$sub_total = 0;
					foreach ($this->cart->getProducts() as $product) {
						if (in_array($product['product_id'], $coupon_info['coupon_product'])) {
							$sub_total += $product['total'];
						}
					}
				}

				if ($coupon_info['type'] == 'F') {
					$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
				}

				foreach ($this->cart->getProducts() as $product) {
					
					$discount = 0;
					if (!$coupon_info['coupon_product']) {
						$status = true;
					} else {
						if (in_array($product['product_id'], $coupon_info['coupon_product'])) {
							$status = true;
						} else {
							$status = false;
						}
					}
						
					if ($status) {
						if ($coupon_info['type'] == 'F') {
							$discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
						} elseif ($coupon_info['type'] == 'P') {
							$discount = $product['total'] / 100 * $coupon_info['discount'];
						}

						if ($product['tax_class_id']) {
							$tax_rates = $this->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);
							
							foreach ($tax_rates as $tax_rate) {
								if ($tax_rate['type'] == 'P') {
									$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								}
							}
						}
						
					}
						
					$discount_total += $discount;
				}

				if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

						foreach ($tax_rates as $tax_rate) {
							if ($tax_rate['type'] == 'P') {
								$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
							}
						}
					}
						
					$discount_total += $this->session->data['shipping_method']['cost'];
				}
				 
				$total_data[] = array(
					'code'       => 'coupon',
        			'title'      => sprintf(__('Coupon'), $this->session->data['coupon']),
	    			'text'       => $this->currency->format(-$discount_total),
        			'value'      => -$discount_total,
					'sort_order' => $this->config->get('coupon_sort_order')
				);
				
				$total -= $discount_total;
			}
		}
	}


	public function confirm($order_info, $order_total) {
		$code = '';
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$code = substr($order_total['title'], $start, $end - $start);
		}

		$coupon_info = $this->model_checkout_coupon->getCoupon($code);
			
		if ($coupon_info) {
			$this->model_checkout_coupon->redeem($coupon_info['coupon_id'], $order_info['order_id'], $order_info['customer_id'], $order_total['value']);
		}
	}
	 
}
?>