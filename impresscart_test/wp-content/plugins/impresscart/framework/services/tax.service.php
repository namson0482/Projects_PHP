<?php
class impresscart_tax_service extends impresscart_service {

	private $shipping_address;
	private $payment_address;
	private $store_address;

	public function __construct() {

		$this->config = impresscart_framework::service('config');
		$this->session = impresscart_framework::service('session');
		$this->customer = impresscart_framework::service('customer');

		// If shipping address is being used
		if (isset($this->session->data['shipping_address_id'])) {
			
			$address_model = impresscart_framework::model('account/address');
			$address = $address_model->getAddress($this->session->data['shipping_address_id']);			
			$this->setShippingAddress($address['country_id'], $address['zone_id']);
		} elseif (isset($this->session->data['guest']['shipping'])) {

			$this->setShippingAddress($this->session->data['guest']['shipping']['country_id'], $this->session->data['guest']['shipping']['zone_id']);
		} elseif ($this->customer->isLogged() && ($this->config->get('tax_customer') == 'shipping')) {
			$address_query = array() ; #$this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$this->customer->getAddressId() . "'");

			$this->setShippingAddress($address_query->row['country_id'], $address_query->row['zone_id']);
		} elseif ($this->config->get('tax_default') == 'shipping') {
			
			$this->setShippingAddress($this->config->get('country'), $this->config->get('zone'));
		}

		if (isset($this->session->data['payment_address_id'])) {
			
			$address = $this->customer->getAddress();
			$address = @$address[$this->session->data['payment_address_id']];
			$this->setPaymentAddress($address['country_id'], $address['zone_id']);
			
		} elseif (isset($this->session->data['guest']['payment'])) {
			
			$this->setPaymentAddress($this->session->data['guest']['payment']['country_id'], $this->session->data['guest']['payment']['zone_id']);
			
		} elseif ($this->customer->isLogged() && ($this->config->get('tax_customer') == 'payment')) {
			
			$address = $this->customer->getAddress();
			$address = @$address[$this->session->data['payment_address_id']];
			$this->setPaymentAddress($address['country_id'], $address['zone_id']);
			//$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$this->customer->getAddressId() . "'");
			//$this->setPaymentAddress($address_query->row['country_id'], $address_query->row['zone_id']);
			
		} elseif ($this->config->get('tax_default') == 'payment') {
			$this->setPaymentAddress($this->config->get('country_id'), $this->config->get('zone_id'));
		}

		$this->setStoreAddress($this->config->get('country'), $this->config->get('region'));
  	}

	public function setShippingAddress($country_id, $zone_id) {
		$this->shipping_address = array(
			'country_id' => $country_id,
			'zone_id'    => $zone_id
		);
	}

	public function setPaymentAddress($country_id, $zone_id) {
		$this->payment_address = array(
			'country_id' => $country_id,
			'zone_id'    => $zone_id
		);
	}

	public function setStoreAddress($country_id, $zone_id) {
		$this->store_address = array(
			'country_id' => $country_id,
			'zone_id'    => $zone_id
		);
	}

  	public function calculate($value, $tax_class_id, $calculate = true) {
  		
		if ($tax_class_id && $calculate) {
			
			$amount = $this->getTax($value, $tax_class_id);
			
			return $value + $amount;
			
		} else {
      		return $value;
    	}
  	}

  	public function getTax($value, $tax_class_id) {
		$amount = 0;

		$tax_rates = $this->getRates($value, $tax_class_id);

		foreach ($tax_rates as $tax_rate) {
			$amount += $tax_rate['amount'];
		}
		
		return $amount;
  	}

	public function getRateName($tax_rate_id) {
		//$tax_query = array() ; #$this->db->query("SELECT name FROM " . DB_PREFIX . "tax_rate WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");
		$tax_rate = impresscart_framework::table('tax_rate');
		$row = $tax_rate->fetchOne( array( 'conditions' => array('tax_rate_id' => $tax_rate_id) ) );
		if (isset($row)) {
			return $row->name;
		} else {
			return false;
		}
	}

    public function getRates($value, $tax_class_id) {
    	
    	$tax_rule_table = impresscart_framework::table('tax_rule');
    	$rules = $tax_rule_table->fetchAll(array('conditions' => array('tax_class_id' => $tax_class_id)));
    	
		$tax_rates = array();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('customer_group_id');
		}

		if ($this->shipping_address) {
			$tax_query = (object)array('rows' => array()) ; 
			foreach ($tax_query->rows as $result) {
				$tax_rates[$result['tax_rate_id']] = array(
					'tax_rate_id' => $result['tax_rate_id'],
					'name'        => $result['name'],
					'rate'        => $result['rate'],
					'type'        => $result['type'],
					'priority'    => $result['priority']
				);
			}
		}
		
		if ($this->payment_address) {
			$tax_query = (object)array('rows' => array()) ;
			foreach ($tax_query->rows as $result) {
				$tax_rates[$result['tax_rate_id']] = array(
					'tax_rate_id' => $result['tax_rate_id'],
					'name'        => $result['name'],
					'rate'        => $result['rate'],
					'type'        => $result['type'],
					'priority'    => $result['priority']
				);
			}
		}

		if ($this->store_address) {
			foreach ($rules as $result) {
				$obj = impresscart_framework::table('tax_rate')->fetchOne(
					array(
						'conditions' => array(
							'tax_rate_id' => $result->tax_rate_id
						)
					)
				);
				
				$obj = (array)$obj;
				$tax_rates[$result->tax_rate_id] = array(
					'tax_rate_id' => $obj['tax_rate_id'],
					'name'        => $obj['name'],
					'rate'        => $obj['rate'],
					'type'        => $obj['type'],
					//'priority'    => $obj['priority']
				);
			}
		}
		
		$tax_rate_data = array();

		foreach ($tax_rates as $tax_rate) {
			if (isset($tax_rate_data[$tax_rate['tax_rate_id']])) {
				$amount = $tax_rate_data[$tax_rate['tax_rate_id']]['amount'];
			} else {
				$amount = 0;
			}

			if ($tax_rate['type'] == 'F') {
				$amount += $tax_rate['rate'];
			} elseif ($tax_rate['type'] == 'P') {
				$amount += ($value / 100 * $tax_rate['rate']);
			}

			$tax_rate_data[$tax_rate['tax_rate_id']] = array(
				'tax_rate_id' => $tax_rate['tax_rate_id'],
				'name'        => $tax_rate['name'],
				'type'        => $tax_rate['type'],
				'amount'      => $amount
			);
		}		
				
		return $tax_rate_data;
	}

  	public function has($tax_class_id) {
		return isset($this->taxes[$tax_class_id]);
  	}

}
?>