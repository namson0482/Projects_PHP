<?php
class Goscom {

	/**
	 * This value is used before customer confirm order => order.model.php
	 * public function create($data) :: Line 34
	 */
	const GOSCOM_ORDER_STATUS_ID_BEFORE_CONFIRM = -1;
	
	const GOSCOM_ORDER_STATUS_ID_AFTER_CONFIRM = 0;

	// Order_Status_Id : 0 and Order_Status_Name : Pending
	/**
	 * This value is used after customer confirm order => cod.model.php 
	 * $this->model_checkout_order->confirm($this->session->data['order_id'], Goscom::GOSCOM_ORDER_STATUS_ID_AFTER_CONFIRM); :: Line 15
	 * 
	 */
	
	const GOSCOM_ORDER_POSTTYPE = 'iorder';
	
	const GOSCOM_PERCENT = 'P';
	
	const GOSCOM_FIX_AMOUNT = 'F';
	
	const GOSCOM_INVOICE_PREFIX = 'INV';
	
	public static function debug($object, $output, $dieon = false) {
		$dieon == true ? die(get_class($object).' :: '.$output) : var_dump(get_class($object).' :: '.$output);  
	}

	public static function arrayPutLastPosition(&$array, $object, $name = null) {
		$position = count($array);
		Goscom::arrayPutCustomPosition($array, $object, $position, $name);
		return $array;
	}

	public static function arrayPutCustomPosition(&$array, $object, $position, $name = null) {

		$length = count($array);
		if($position == $length) {
			foreach ($array as $k => $v) {
				$return[$k] = $v;
			}
			if (!$name) $name = $length;
			$return[$name] = $object;
			$array = $return;
		} else if($position < $length) {
			$count = 0;
			$return = array();
			foreach ($array as $k => $v) {

				// insert new object
				if ($count == $position) {
					if (!$name) $name = $count;
					$return[$name] = $object;
					$inserted = true;
				}
				// insert old object
				$return[$k] = $v;
				$count++;
			}
			if (!$name) $name = $count;
			if (!$inserted) $return[$name];
			$array = $return;
		}
		return $array;

	}
	
	public static function dateIsValid($sql_start_date , $sql_expiration_date) {
		$todays_date = date("Y-m-d");
		$today = strtotime($todays_date);
		$expiration_date = strtotime($sql_expiration_date);
		$start_date = strtotime($sql_start_date);
		return ($expiration_date < $today || $start_date > $today) ? false : true;
			
	}
	
	
	public static function generateHeader($logo, $pages) {
		$html = '<div>';
		$html .= '<img src=' . $logo .'>'; 
		$html .= self::generateMenu($pages);
		$html .= '</div>';
		return $html; 
	}
	
	public static function generateMenu($pages, $breakDown = 3) {
		$html = '<ul class="sf-menu">';
		
		foreach($pages as $key => $urls) {
			$html .= Goscom::getMenuHtml($key, $urls);
		}
		$html .= '</ul>';
		for($i=0;$i<$breakDown;$i++) {
			//$html .= '<br/>';
		}
		return $html;
	}
	
	private static function getMenuHtml($menuItem, $childrens) {
		$html = '<li class="current"><a href="#a">'.$menuItem.'</a>';
		if(count($childrens) > 0) {
			$html .= '<ul>';
			foreach($childrens as $children) {
				$html .= '<li><a href="'.$children['href'].'">'.$children['title'].'</a>';
			}
			$html .= '</ul>';
		}
		$html .= '</li>';
		return $html; 		
	}
	
}





