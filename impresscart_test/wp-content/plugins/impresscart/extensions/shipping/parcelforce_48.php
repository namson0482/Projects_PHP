<?php
if(!class_exists('extension')) include impresscart_EXTENSION . '/extension.php';

class parcelforce_48 extends extension {	function __construct(){
	
		parent::__construct();
		$this->type = 'shipping';
		$this->class = 'parcelforce_48';
		$this->status = 0;
		$this->order = 1;
		$this->prefix = 'impresscart_shipping_parcelforce_48_';
		
		$this->metaboxes = array(
			
			'setting' => array(
				'id' => 'parcelforce_48-settings-meta-box',
				'title' => __('Settings'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'tabs' => '',
				'fields' => array(
		
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