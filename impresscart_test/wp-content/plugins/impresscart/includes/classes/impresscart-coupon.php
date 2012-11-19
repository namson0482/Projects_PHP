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
class impresscart_coupon extends impresscart_posttype {

	var $id;
	var $metaboxes;
	/**
	 * Loads all order data from custom fields
	 * @param  int	$id	 
	 */
	function impresscart_coupon( $id ) {

		$this->metaboxes = array(
			'data' => array(
				'id' => 'coupon-data-meta-box',
				'title' => __('Coupon Detail'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(

                                        array(
						'name' => '',
						'desc' => 'coupon data box',
						'id'   => @$prefix . 'coupon_data',
						'type' => 'coupon_data',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
			
			'history' => array(
			'id' => 'coupon-history-meta-box',
			'title' => __('History'),
			'page' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name' => '',
					'desc' => 'coupon history box',
					'id'   => @$prefix . 'coupon_history',
					'type' => 'coupon_history',
					'std'  => ''
				),
         
			),
			'tabs' => '',
			),
			
		);		
	}

	function get($key) {
		return $this->$key;
	}
	
	function save()	{
		
		global $post;
		
		if(isset($_POST['data'])) {
			
			update_post_meta($post->ID, 'coupon_code', $_POST['coupon_code']);
			
            update_post_meta($post->ID, 'data', $_POST['data']);
            
            
		}
		
	}
}


add_filter('impresscart_post_types','impresscart_coupon_post_type');
function impresscart_coupon_post_type($posttypes)
{
	$posttypes['coupon'] = array( 
             
            'public' => true,    			    			
            'show_ui' => true,
                    'show_in_menu' => false, 	
                    'exclude_from_search' => true,	
            'labels' => array(
                    'name' => 'Coupon',
                    'singular_name' => 'Coupon',
                    'add_new' => 'Add Coupon',
                    'add_new_item' => 'Add Coupon',
                    'new_item' => 'New Coupon',
            ),
            'supports' => array( 'title' )
        );
        
        return $posttypes;    
}


/**
 * coupon_data
 */
add_filter('impresscart_coupon_data', 'impresscart_coupon_data_metabox');

function impresscart_coupon_data_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/coupon/data');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * coupon_history
 */
add_filter('impresscart_coupon_history', 'impresscart_coupon_history_metabox');

function impresscart_coupon_history_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/coupon/history');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}