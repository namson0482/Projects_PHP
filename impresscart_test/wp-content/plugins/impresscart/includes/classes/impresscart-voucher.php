<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
/**
 *
 * @author giappv
 *
 */
class impresscart_voucher extends impresscart_posttype {

	var $id;
	var $metaboxes;
	/**
	 * Loads all order data from custom fields
	 * @param  int	$id	 
	 */
	function impresscart_voucher( $id ) {

		$this->metaboxes = array(
			'data' => array(
				'id' => 'voucher-data-meta-box',
				'title' => __('Order Data'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'name' => '',
						'desc' => 'voucher data box',
						'id'   => @$prefix . 'voucher_data',
						'type' => 'voucher_data',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
			
			
			'history' => array(
				'id' => 'voucher-history-meta-box',
				'title' => __('Voucher History'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'name' => '',
						'desc' => 'history data box',
						'id'   => @$prefix . 'voucher_history',
						'type' => 'voucher_history',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
		);					
	}

	function get($key)
	{
		return $this->$key;
	}
	
	function save()
	{
		global $post;
		
		if(isset($_POST['data']))
		{
			update_post_meta($post->ID, 'voucher_code', $_POST['voucher_code']);
			update_post_meta($post->ID, 'data', $_POST['data']);                        
		}
	}
}


add_filter('impresscart_post_types','impresscart_voucher_post_type');

function impresscart_voucher_post_type($posttypes)
{
	$posttypes['voucher'] = array(
    			'public' => true,    			    			
    			'show_ui' => true,
				'show_in_menu' => false, 	
				'exclude_from_search' => true,	
    			'labels' => array(
    				'name' => 'Voucher',
    				'singular_name' => 'Voucher',
    				'add_new' => 'Add Voucher',
    				'add_new_item' => 'Add Voucher',
    				'new_item' => 'New Voucher',
    			),
    			'supports' => array( '' )
        );
    
        return $posttypes;    
}



/**
 * voucher_data
 */
add_filter('impresscart_voucher_data', 'impresscart_voucher_data_metabox');

function impresscart_voucher_data_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/voucher/data');
  $html .= ob_get_contents();
  var_dump($html);
  ob_end_clean();
  return $html;
}

/**
 * voucher_history
 */
add_filter('impresscart_voucher_history', 'impresscart_voucher_history_metabox');

function impresscart_voucher_history_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/voucher/history');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}










/**
 * product_tag
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_voucher_theme_taxonomies');

function impresscart_voucher_theme_taxonomies($taxonomies) {
	$taxonomies['voucher_theme'] = array(
        	    'voucher',
				array(
		            'hierarchical' 			=> false,
		            'update_count_callback' => '_update_post_term_count',
		            'label' 				=> __( 'Voucher Theme', 'impressthemes'),
		            'labels' => array(
		                    'name' 				=> __( 'Voucher Themes', 'impressthemes'),
		                    'singular_name' 	=> __( 'Voucher Theme', 'impressthemes'),
		                    'search_items' 		=>  __( 'Search Voucher Themes', 'impressthemes'),
		                    'all_items' 		=> __( 'All Voucher Themes', 'impressthemes'),
		                    'edit_item' 		=> __( 'Edit Voucher Theme', 'impressthemes'),
		                    'update_item' 		=> __( 'Update Voucher Theme', 'impressthemes'),
		                    'add_new_item' 		=> __( 'Add New Voucher Theme', 'impressthemes'),
		                    'new_item_name' 	=> __( 'New Voucher Theme', 'impressthemes')
						),
		            'show_ui' 				=> true,
		            'query_var' 			=> true,		            
						)
						);
	return $taxonomies;
}

