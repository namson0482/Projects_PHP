<?php

/** * abstract class for all type of shipping & payment extensions  */

abstract class extension {  
	public $metaboxes;  public $id;  
	public $type;  
	public $class;  
	public $enabled;  
	public $order;  
	public $settings;  
	public $prefix;  
	public $cart;  
	public $session;  
	public $currency;  
	public $config;  
	public $customer; 
	 public $tax;  
	 function __construct() {    
	 	$this->cart = impresscart_framework::service('cart');    
	 	$this->session = impresscart_framework::service('session');    
	 	$this->currency = impresscart_framework::service('currency');    
	 	$this->config = impresscart_framework::service('config');    
	 	$this->customer = impresscart_framework::service('customer');    
	 	$this->tax = impresscart_framework::service('tax');  
	 }  
	 
	 function get_metaboxes() {    return $this->metaboxes;  } 
	 function get_type() {    return $this->type;  }  
	 function is_enabled() {    return $enabled;  }  
	 function get($name) {    global $post;    
	 	return get_post_meta($post->ID, $this->prefix . $name, true);  
	 }  
	 
	 function get_all_geo_zones() {    
	 	
	 	$table = impresscart_framework::table('geo_zone');    
	 	$rows = $table->fetchAll();    $geo_zones = array();    
	 	$geo_zones[] = array('name' => 'All', 'value' => '');    
	 	foreach ($rows as $row) {      
	 		$geo_zones[] = array('name' => $row->name, 'value' => $row->geo_zone_id);    
	 	}    
	 	
	 	return $geo_zones;  
	 }  
	 	
	 function get_all_tax_classes() {    
	 	
	 	$table = impresscart_framework::table('tax_class');    
	 	$rows = $table->fetchAll();    $tax_classes = array();    
	 	$tax_classes[] = array('name' => '--None--', 'value' => '');    
	 	foreach ($rows as $row) {      
	 		$tax_classes[] = array('name' => $row->name, 'value' => $row->tax_class_id);   
	 	}    
	 	
	 	return $tax_classes;  
	 }  
	 	
	 function get_all_order_statuses() {	
	 	$table = impresscart_framework::table('order_status');    
	 	$rows = $table->fetchAll();    $order_statuses = array();    
	 	foreach ($rows as $row) {      
	 		$order_statuses[] = array('name' => $row->name, 'value' => $row->order_status_id);    
	 	}    
	 	return $order_statuses;  
	 }  
	 
	 function draw_metabox() {    
	 	$obj = new impresscart_metaboxes();    
	 	$obj->impresscart_draw_metabox($this->metaboxes['setting']);  
	 }  
	 
	 function save() {    
	 	global $post;    $post_id = $post->ID;    
	 	//check autosave    
	 	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {      return $post_id;    }    
		//check permissions    
		if ('extension' == $_POST['post_type']) {      
			if (!current_user_can('edit_page', $post_id)) 
			{        
				return $post_id;      
			}    
		} elseif (!current_user_can('edit_post', $post_id)) {   
			return $post_id;   
		}    
		 
		 foreach ($this->metaboxes['setting']['fields'] as $field) {      
		 	update_post_meta($post_id, $field['id'], $_POST[$field['id']]);    
		 }  
	 }  
		 	
	 function getTotal(&$total_data, &$total, &$taxes) {}  
	 
	 public function getPrefix() {    
	 	return $this->prefix;  
	 }  
	 
	 public function setId($id) {    $this->id = $id;  }

}

?>