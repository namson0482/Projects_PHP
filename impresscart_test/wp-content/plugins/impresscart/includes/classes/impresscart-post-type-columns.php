<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_post_type_columns {
	
	function init_columns()	{
		$obj = new impresscart_post_types();		
		$posttypes = $obj->get_posttypes();
		foreach($posttypes as $name => $arr) {		
			add_filter('manage_edit-' . $name . '_columns',  array(&$this, 'impresscart_edit_' . $name . '_columns'));
			add_action('manage_' . $name . '_posts_custom_column',  array(&$this, 'impresscart_' . $name . '_custom_columns'));
		}
	}
	
	function impresscart_edit_iorder_columns($columns) {
		// Line: 263
		$columns = array();
		$columns['cb'] = __('<input type="checkbox">');		
		$columns['order_id'] = __('Order ID');
		$columns['customer'] = __('Customer');
		$columns['status'] = __('Status');
		$columns['total'] = __('Total');		
		$columns['date'] = __('Date');
		return $columns;
	}
	
	function impresscart_iorder_custom_columns($column) {
		global $post;
		$data = get_post_meta($post->ID, 'data', true);
		$data_order_total = get_post_meta($post->ID, 'order_total', true);
        $status = get_post_meta($post->ID, 'order_status', true);
		switch($column){
			case 'order_id':
				edit_post_link('#' . $post->ID);
				break;
			case 'customer':
				echo $data['firstname'] . " " . $data['lastname'];
				break;
			case 'status':
				$order_status = impresscart_framework::table('order_status')->fetchOne(
					array(
						'conditions' => array(
						'order_status_id' => $status
						)
					)
				);
						
				if($status == "1") {
					echo __('Pending');
				} else {
					echo @$order_status->name;
				}
				break;
			case 'total':
				$c_service = impresscart_framework::service('currency');
				//echo $c_service->format($data['order_total'], $data['currency_code'], $data['currency_value']);
				echo $c_service->format($data_order_total, $data['currency_code'], $data['currency_value']);
				break;
			case 'date_added':
				break;
		}
	}
	
	
	/**
	 * custom columns for products page
	 **/
	function impresscart_edit_product_columns($columns){
		
		$columns = array();		
		$columns["cb"] = "<input type=\"checkbox\" />";
		$columns["thumb"] = __("Image", 'impressthemes');
		
		$columns["title"] = __("Name", 'impressthemes');
		if( get_option('impresscart_enable_sku', true) == 'yes' ) $columns["sku"] = __("ID", 'impressthemes');
		$columns["product_type"] = __("Type", 'impressthemes');
		
		$columns["product_cat"] = __("Categories", 'impressthemes');
		$columns["product_tags"] = __("Tags", 'impressthemes');
		$columns["featured"] = __("Featured", 'impressthemes');

		$columns["price"] = __("Price", 'impressthemes');
		$columns["product_date"] = __("Date", 'impressthemes');
		
		return $columns;
	}
	
	
	/**
	 * custom columns data for products page
	 * @param $column
	 */
	function impresscart_product_custom_columns($column) {
		
		global $post;
		$product = &new impresscart_product($post->ID);		
		
		switch ($column) {
			case "thumb" :
				if (has_post_thumbnail($post->ID)) :
					echo get_the_post_thumbnail($post->ID, 'thumbnail', array('60', '60'));
				endif;
			break;
			case "price":
				//echo $product->get('price');
			break;
			case "product_cat" :
				if (!$terms = get_the_term_list($post->ID, 'product_cat', '', ', ','')) echo '<span class="na">&ndash;</span>'; else echo $terms;
			break;
			case "product_tags" :
				if (!$terms = get_the_term_list($post->ID, 'product_tag', '', ', ','')) echo '<span class="na">&ndash;</span>'; else echo $terms;
			break;
			case "sku" :
				if ( $sku = get_post_meta( $post->ID, 'sku', true )) :
					echo '#'.$post->ID.' - SKU: ' . $sku;	
				else :
					echo '#'.$post->ID;
				endif;
			break;
			case "featured" :
            	//bug not fix
				$url = wp_nonce_url( admin_url('admin-ajax.php?action=woocommerce-feature-product&product_id=' . $post->ID) );
				echo '<a href="'.$url.'" title="'.__('Change', 'woothemes') .'">';
				if ($product->is_featured()) echo '<a href="'.$url.'"><img src="'.$woocommerce->plugin_url().'/assets/images/success.gif" alt="yes" />';
				else echo '<img src="'.IMPRESSCART_URL.'/assets/images/success-off.gif" alt="no" />';
				echo '</a>';
			break;
			case "is_in_stock" :
				if ( !$product->is_type( 'grouped' ) && $product->is_in_stock() ) :
					echo '<img src="'.IMPRESSCART_URL.'/assets/images/success.gif" alt="yes" /> ';
				else :
					echo '<img src="'.IMPRESSCART_URL.'/assets/images/success-off.gif" alt="no" /> ';
				endif;
				if ( $product->managing_stock() ) :
					echo $product->stock.__(' in stock', 'woothemes');
				endif;
			break;
			case "product_type" :
				//echo ucwords($product->product_type);
			break;
			case "product_date" :
				/* if ( '0000-00-00 00:00:00' == $post->post_date ) :
					$t_time = $h_time = __( 'Unpublished' );
					$time_diff = 0;
				else :
					$t_time = get_the_time( __( 'Y/m/d g:i:s A' ) );
					$m_time = $post->post_date;
					$time = get_post_time( 'G', true, $post );
	
					$time_diff = time() - $time;
	
					if ( $time_diff > 0 && $time_diff < 24*60*60 )
						$h_time = sprintf( __( '%s ago' ), human_time_diff( $time ) );
					else
						$h_time = mysql2date( __( 'Y/m/d' ), $m_time );
				endif;
	
				echo '<abbr title="' . $t_time . '">' . apply_filters( 'post_date_column_time', $h_time, $post ) . '</abbr><br />';
				
				if ( 'publish' == $post->post_status ) :
					_e( 'Published' );
				elseif ( 'future' == $post->post_status ) :
					if ( $time_diff > 0 ) :
						echo '<strong class="attention">' . __( 'Missed schedule' ) . '</strong>';
					else :
						_e( 'Scheduled' );
					endif;
				else :
					_e( 'Last Modified' );
				endif;
	
				if ( $this_data = $product->visibility ) :
					echo '<br />' . ucfirst($this_data);	
				endif;
				*/
			break;
		}
	}
	
	function impresscart_edit_extension_columns($columns) {

		$type = $_GET['type'];
		//insert data for extension posttype
		$extensions = impresscart_extension::get_installed_extension($type);
		foreach($extensions as $ext)
		{
			$type = get_post_meta($ext->ID, 'type', true);
			$class = get_post_meta($ext->ID, 'class', true);
			if(empty($type) || empty($class) ) impresscart_extension::uninstall($ext->ID); 
			
			if (!file_exists(ITMARKET_EXTENSION . '/' . $type . '/' . $class . '.php')) {
				impresscart_extension::uninstall( $ext->ID );
			}
		}
		
		$types = array('payment','shipping', 'total');
		
		foreach($types as $type)
		{		
			//installed all payments methods
			$files = glob(ITMARKET_EXTENSION . '/'.$type.'/*.php');
			
			if ($files) {
				foreach ($files as $file) {
					$extension = basename($file, '.php');
					if(!impresscart_extension::is_installed($type, $extension))
					{
						impresscart_extension::install($type, $extension);
					} 
				}
			}		
		}
		
		$columns = array();
		$columns["title"] = __("Name", 'impressthemes');		
		$columns['type'] = __('Type', 'impressthemes');
		$columns['class'] = __('Class', 'impressthemes');
		$columns['status'] = __('Enabled', 'impressthemes');	
		return $columns;
	}
	
	/**
	 * column data for extensions page
	 * @param $column
	 */
	function impresscart_extension_custom_columns($column)
	{
		global $post;
		switch($column)
		{
			case 'type':
				echo get_post_meta($post->ID, 'type', true);
				break;
			case 'class':
				echo get_post_meta($post->ID, 'class', true);
				break;
		
			case 'status':
				$ext = new impresscart_extension($post->ID);				
				if(($ext->get_meta('status')) != "0")
				{
					echo __("Enabled");
										
				} else {
					echo __("Disabled");
				}
				break;
		}
	}
	
	function impresscart_edit_coupon_columns($columns)	{
		$columns = array();
		$columns['cb'] = __('<input type="checkbox">');		
		$columns['coupon_id'] = __('Coupon ID');
		$columns['name'] = __('Name:');
		$columns['code'] = __('Code:');
		$columns['discount'] = __('Discount');		
		$columns['date_start'] = __('Date Start');
		$columns['date_end'] = __('Date End');
		$columns['status'] = __('Status');
		return $columns;
	}
	
	function impresscart_coupon_custom_columns($column)	{
		global $post;
		
		$data = get_post_meta($post->ID, 'data', true);		
            
		switch($column){
			case 'coupon_id':
				edit_post_link('#' . $post->ID);
				break;
			case 'name':
				echo $post->post_title;
				break;
			case 'code':
				//die(get_post_meta($post->ID, 'coupon_code', true));
				echo get_post_meta($post->ID, 'coupon_code', true);	
				break;
			case 'discount':
				if($data['type'] == 'P') echo $data['discount'];
				else echo impresscart_framework::service('currency')->format($data['discount'], @$data['currency_code'], @$data['currency_value']); 
				break;
			case 'date_start':
				echo $data['date_start'];
				break;
			case 'date_end':
				echo $data['date_end'];
				break;
			case 'status':
				echo $post->post_status;
				break;
		}
	}
	
	function impresscart_edit_voucher_columns($columns)
	{
		$columns = array();
		$columns['cb'] = __('<input type="checkbox">');		
		$columns['voucher_id'] = __('Coupon ID');		
		$columns['code'] = __('Code:');
		$columns['from_name'] = __('From name:');		
		$columns['from_email'] = __('From Email:');
		$columns['to_name'] = __('To name:');		
		$columns['to_email'] = __('To Email:');		
		$columns['status'] = __('Status');
		return $columns;
	}
	
	function impresscart_voucher_custom_columns($column)
	{
		global $post;
		$data = get_post_meta($post->ID, 'data', true);		
		switch($column){
			case 'voucher_id':
				edit_post_link('#' . $post->ID);
				break;			
			case 'code':
				echo get_post_meta($post->ID, 'voucher_code', true);	
				break;
			case 'from_name':
				echo $data['from_name'];
				break;
				
			case 'from_name':
				echo $data['from_email'];
				break;
				
			case 'to_name':
				echo $data['to_name'];
				break;
			case 'to_email':
				echo $data['to_email'];
				break;
			case 'theme':
				//echo $data['theme'];
				break;
			case 'status':
				echo $post->post_status;
				break;
		}
	}
	
	
	function impresscart_edit_im_affiliate_columns($columns)
	{
		$columns = array();
		$columns['cb'] = __('<input type="checkbox">');		
		$columns['affiliate_id'] = __('Coupon ID');		
		$columns['name'] = __('Affiliate Name:');
		$columns['email'] = __('Email:');		
		$columns['balance'] = __('Balance:');
		$columns['approved'] = __('Approved:');		
		$columns['date_added'] = __('Date Added:');
		$columns['status'] = __('Status');
		return $columns;
	}
	
	function impresscart_im_affiliate_custom_columns($column)
	{
		global $post;
		$data = get_post_meta($post->ID, 'data', true);		
		switch($column){
			case 'affiliate_id':
				edit_post_link('#' . $post->ID);
				break;			
			case 'name':
				echo $data['firstname'] . ' ' . $data['lastname'];
				break;
			case 'email':
				echo $data['email'];
				break;				
			case 'balance':
				echo $data['balance'];
				break;				
			case 'Approved':
				echo $data['approved'];
				break;
			case 'Date Added':
				echo $data['date_added'];
				break;			
			case 'status':
				echo $post->post_status;
				break;
		}
	}
	
	
	
	function impresscart_edit_return_columns($columns)
	{
		$columns = array();
		$columns["title"] = __("Name", 'impressthemes');
		return $columns;
	}
	
	function impresscart_return_custom_columns($column)
	{
		global $post;
	}
}

?>