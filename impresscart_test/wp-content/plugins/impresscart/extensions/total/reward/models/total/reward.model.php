<?php

class impresscart_total_reward_model extends impresscart_model {


	function update_setting( $data = array()) {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(!is_array($impresscart_totals)) {
			$impresscart_totals =array();
		}
			
		$impresscart_totals['impresscart']['total']['reward'] = $data;
		update_option('impresscart_totals', $impresscart_totals);
	}

	function get_setting() {
		$impresscart_totals = get_option('impresscart_totals', true);
		if(@$impresscart_totals['impresscart']['total']['reward'] && is_array($impresscart_totals)) {
			return @$impresscart_totals['impresscart']['total']['reward'];
		}
		return self::getDefaultValues();

	}

	public static function getDefaultValues() {
		return (array(
				'name' =>  'reward',
				'order' => '2',
				'status' => 'no',
				'code' => 'reward',
		));
	}

	public function getTotal(&$total_data, &$total, &$taxes) {


		if (isset($this->session->data['reward'])) {

			$points_avaiable = $this->customer->getRewardPoints(); //points avaiable
				
			if ($this->session->data['reward'] <= $points_avaiable) {
				$discount_total = 0;
				$points_total = 0;
				foreach ($this->cart->getProducts() as $product) {
					if ($product['points_to_buy']) {
						$points_total += $product['points_to_buy'];
					}
				}
				$points_avaiable = min($points_avaiable, $points_total);
				foreach ($this->cart->getProducts() as $product) {
					$discount = 0;

					if ($product['points_to_buy']) {
						$discount = $product['total'] * ($this->session->data['reward'] / $points_total);
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
					
				//'title'      => sprintf($this->language->get('text_reward'), $this->session->data['reward']),
				$total_data[] = array(
                                    'code'       => 'reward',
									'title'      => __('Reward', 'impressthemes'),
                                    'text'       => $this->currency->format(-$discount_total),
                                    'value'      => -$discount_total,
                                    'sort_order' => $this->config->get('reward_sort_order')
				);

				$total -= $discount_total;

			}
		}
	}

	public function confirm($order_info, $order_total) {

		$points = 0;

		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$points = substr($order_total['title'], $start, $end - $start);
		}
		//this is not correct
		if ($points) {
			$old_points = get_user_meta($this->customer->getId(), 'points',true );
			$new_points = $old_points - $points;
			update_user_meta($this->customer->getId(), 'points', $new_points);
		}
	}

}
?>