<?php
class impresscart_currency_service extends impresscart_service {

	private $code;
	private $currencies = array();

  	public function __construct() {

  		global $wpdb;

  		$this->config = impresscart_framework::service('config');
		$this->session = impresscart_framework::service('session');

		$rows = impresscart_framework::table('currency')->fetchAll();
				
		# get all active currencies, map by code
		foreach ($rows as $result) {
			$result = (array)$result;
			$this->currencies[$result['code']] = array(
			'currency_id'   => $result['currency_id'],
			'title'         => $result['title'],
			'symbol_left'   => $result['symbol_left'],
			'symbol_right'  => $result['symbol_right'],
			'decimal_place' => $result['decimal_place'],
			'value'         => $result['value']
			);
		}
		

		# set base currency (get from config)
		# harded code the first currency
		$baseCurrency = $this->config->get('currency');
				
		$this->set($baseCurrency ? $baseCurrency : @$rows[0]['code']);
	}

  	public function set($currency) {

    	$this->code = $currency;

    	# set currency into session
    	if ((!isset($this->session->data['currency'])) || ($this->session->data['currency'] != $currency)) {
      		$this->session->data['currency'] = $currency;
    	}

    	# set currency from cookie (user change manually)
    	if(!isset($_COOKIE['currency']) || $_COOKIE['currency'] != $currency) {
    		
    		//setcookie('currency', $currency, time() + 3600 * 24 * 1000, '/');
    		//setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/',$_SERVER['HTTP_HOST']);
    	}
  	}

	public function format($number, $currency = '', $value = '', $format = true) {

		if (!($currency && $this->has($currency))) {
			$currency = $this->code;
    	}

		$symbol_left   = $this->currencies[$currency]['symbol_left'];
		$symbol_right  = $this->currencies[$currency]['symbol_right'];
		$decimal_place = $this->currencies[$currency]['decimal_place'];

    	if (!$value) {
      		$value = $this->currencies[$currency]['value'];
    	}

    	if ($value) {
      		$value = $number * $value;
    	} else {
      		$value = $number;
    	}


    	$string = '';

    	if (($symbol_left) && ($format)) {
      		$string .= $symbol_left;
    	}

		if ($format) {
			$decimal_point = $this->config->get('decimal_point');
		} else {
			$decimal_point = '.';
		}

		if ($format) {
			$thousand_point = $this->config->get('thousand_point');
		} else {
			$thousand_point = '';
		}

    	$string .= number_format(round($value, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);

    	if (($symbol_right) && ($format)) {
      		$string .= $symbol_right;
    	}
    	
    	return $string;
  	}

  	public function convert($value, $from, $to) {
		if (isset($this->currencies[$from])) {
			$from = $this->currencies[$from]['value'];
		} else {
			$from = 0;
		}

		if (isset($this->currencies[$to])) {
			$to = $this->currencies[$to]['value'];
		} else {
			$to = 0;
		}

		return $value * ($to / $from);
  	}

  	public function getId($currency = '') {
		if (!$currency) {
			return $this->currencies[$this->code]['currency_id'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['currency_id'];
		} else {
			return 0;
		}
  	}

	public function getSymbolLeft($currency = '') {
		if (!$currency) {
			return $this->currencies[$this->code]['symbol_left'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_left'];
		} else {
			return '';
		}
	}

	public function getSymbolRight($currency = '') {
		if (!$currency) {
			return $this->currencies[$this->code]['symbol_right'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_right'];
		} else {
			return '';
		}
  	}

	public function getDecimalPlace($currency = '') {
		if (!$currency) {
			return $this->currencies[$this->code]['decimal_place'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['decimal_place'];
		} else {
			return 0;
		}
  	}

	public function getCode() {
		return $this->code;
	}

  	public function getValue($currency = '') {
		if (!$currency) {
			return $this->currencies[$this->code]['value'];
		} elseif ($currency && isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['value'];
		} else {
			return 0;
		}
  	}

	public function has($currency) {
		return isset($this->currencies[$currency]);
	}
}
?>