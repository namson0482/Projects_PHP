<?php
if(!class_exists('extension')) include impresscart_EXTENSION . '/extension.php';

class flat extends extension {	function __construct(){
	
		parent::__construct();
		$this->type = 'shipping';
		$this->class = 'flat';
		$this->status = 0;
		$this->order = 1;
		$this->prefix = 'impresscart_shipping_flat_';
		
		$this->metaboxes = array(
			
			'setting' => array(
				'id' => 'flat-settings-meta-box',
				'title' => __('Settings'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'tabs' => '',
				'fields' => array(
		
						array (
						    'name' => __('Cost'),
						    'desc' => __('Cost'),
						    'id' => $this->prefix . 'cost',
						    'type' => 'text',
						    'std' => '5.00'
						),
						
						array(
						    'name' => __('Tax classes:'),
						    'desc' => '',		
						    'id' => $this->prefix . 'geo_zone',
						    'type' => 'select',
						    'options' =>  $this->get_all_tax_classes()
						),
						
						array(
						    'name' => __('Geo Zones:'),
						    'desc' => '',		
						    'id' => $this->prefix . 'geo_zone',
						    'type' => 'select',
						    'options' =>  $this->get_all_geo_zones()
						),
		
						array (
						    'name' => __('Sort order'),
						    'desc' => __('Sort order'),
						    'id' => $this->prefix . 'sort_order',
						    'type' => 'text',
						    'std' => '1'
						),
						array(
						    'name' => __('Status:'),
						    'desc' => '',		
						    'id' => $this->prefix . 'status',
						    'type' => 'select',
						    'options' =>  array(
								array( 'name' => 'Enabled' , 'value' => '1' ),
								array( 'name' => 'Disabled' , 'value' => '0' )
						    ),
						    'std' => '0'			
						)

					)

				)

			);
		
	}		
	
	
	public function getTotal(&$total_data, &$total, &$taxes)
	{
		
	}
	
}
?>