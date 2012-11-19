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
 
add_action('restrict_manage_posts','restrict_reuturn');

function restrict_reuturn() {
        global $typenow;        
        global $wp_query;    
        if ($typenow=='return') {
	        $taxonomy = 'business';
	        $status = @$_REQUEST['return_status'];
	        if($status != 'all' && !empty($status)) {
	            $test = array(      
	            'meta_key' => 'data[return_status_id]',
	            'meta_value' => $status,
	            );    
	        } else {
	            $test = array(        
	                              
	            );    
	        }
	        $args = $wp_query->query;
	        $args = array_merge($args, $test);
	        $return_status = impresscart_framework::service('config')->get('return_status_data');
	        if(count($return_status) > 0) {
	        	$return_status_dropdown = '<select name="return_status"><option value="all">'.__('All Statuses').'</option>';
		        foreach($return_status as $key => $value) {
		          if($key  ==  $status)  $return_status_dropdown .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
		          else $return_status_dropdown .= '<option value="'.$key.'">'.$value.'</option>'; 
		        }
		        $return_status_dropdown .= '</select>';
		        echo $return_status_dropdown;
		        $wp_query->query($args);
	        } 
    	}
}

class impresscart_return extends impresscart_posttype {

	var $id;
	var $metaboxes;
	/**
	 * Loads all order data from custom fields
	 * @param  int	$id	 
	 */
	function impresscart_return( $id ) {

		$this->metaboxes = array(
			'data' => array(
				'id' => 'return-data-meta-box',
				'title' => __('Return Data'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'name' => '',
						'desc' => 'return data box',
						'id'   => @$prefix . 'data',
						'type' => 'return_data',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
			
			'items' => array(
				'id' => 'return-items-meta-box',
				'title' => __('Products'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'name' => '',
						'desc' => '',
						'id'   => @$prefix . 'return_items',
						'type' => 'return_items',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
			
			'history' => array(
				'id' => 'return-history-meta-box',
				'title' => __('Return History'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'name' => '',
						'desc' => '',
						'id'   => @$prefix . 'return_history',
						'type' => 'return_history',
						'std'  => ''
					),
				),
				'tabs' => '',
			),
		);

		$this->id = $id;		
	}

	function get($key)
	{
		return $this->$key;
	}
	
	function save()
	{
		global $post;
		$post = get_post($this->id);
		//save detail & items
		update_post_meta($post->ID, 'data', $_POST['data']);
	
		//save history
		$histories = get_post_meta($post->ID, 'histories', true);
		
		if(!$histories) $histories = array();
		$history = $_POST['history'];
		
		if($history) 
		{
			$history['date_added'] = date(__('d-m-y'));
		}

		if(!empty($history['comment']))
		{
			$histories[] = $history;
			update_post_meta($post->ID, 'histories', $histories);
			if(!$history['notify'] && $history['notify'] != "0" )
			{
				impresscart_framework::model('account/return')->notify();
			}
		}
	}
}


add_filter('impresscart_post_types','impresscart_return_post_type');

function impresscart_return_post_type($posttypes)
{
		$posttypes['return'] = array( 
                'public' => true,    			    			
                'show_ui' => true,
                        'show_in_menu' => false, 	
                        'exclude_from_search' => true,	
                'labels' => array(
                        'name' => 'Return',
                        'singular_name' => 'Return',
                        'add_new' => 'Add Return',
                        'add_new_item' => 'Add Return',
                        'new_item' => 'New Return',
                ),
                'supports' => array( 'title' )
        );
    
        return $posttypes;    
}


/**
 * return_data
 */
add_filter('impresscart_return_data', 'impresscart_return_data_metabox');

function impresscart_return_data_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/return/data');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * return_items
 */
add_filter('impresscart_return_items', 'impresscart_return_items_metabox');

function impresscart_return_items_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/return/items');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * return_history
 */
add_filter('impresscart_return_history', 'impresscart_return_history_metabox');

function impresscart_return_history_metabox() {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/return/history');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}
