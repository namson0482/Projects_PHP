<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
// init fakepage handler
require_once IMPRESSCART_CLASSES . '/impresscart_fakepage.php';


add_shortcode('impresscart', 'impresscart_shortcode');

if(!is_admin()) add_filter('the_posts', 'impresscart_the_posts_filter');

function impresscart_shortcode($args) {
	
	#TODO: more default short code here
	$alias = array(
		'checkout' => '/shortcode/checkout'
	);
	if(isset($args['action'])) {
		$action = $args['action'];
	}
	if(isset($alias[$action])) {
		$action = $alias[$action];
	}
	if(empty($action)) {
		return '';
	}

	// do the main
	ob_start();	
	impresscart_framework::getInstance()
		->setDefaultUrl($action)
		->dispatch();
	$content = ob_get_contents();
	ob_end_clean();
	return $content;	
}

function impresscart_the_posts_filter($posts) {
	
	global $wp;
	
    global $wp_query;

    # find if fakepage is requested
	$post3 = impresscart_fakepage::getPage();

   	if(!empty($post3)) {
		$posts = array($post3);
   	}
   	global $post;
   	
	foreach($posts as &$post2) {
		if($post2->post_type == 'product') {
			
			// special for product posttype
			if (itmartket_is_product_detail()) {				
				$post = $post2;
                setProductView($post->ID);
				$post->post_content = impresscart_extension_template_render($post->post_content, 'product_detail');
				
			} elseif (itmartket_is_product_listing() && !is_admin()) {
				$post = $post2;
				$post->post_excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
				$post->post_content = do_shortcode(impresscart_extension_template_render($post->post_content, 'product_listing_item'));
				$post->post_excerpt = do_shortcode(impresscart_extension_template_render($post->post_excerpt, 'product_listing_item'));
			}
		}
		
		
		if($post2->post_type == Goscom::GOSCOM_ORDER_POSTTYPE) {
			$post = $post2;
			$post->post_content = do_shortcode(impresscart_extension_template_render($post->post_content, 'order_info'));
		}
   	}

	return $posts;
}

function itmartket_is_product_listing(){
	// TODO: shop configurable
	$array = array('category', 'tag', 'search');
	foreach($array as $func){
		$funcName = 'is_' . $func;
		if ($funcName()) {
			return true;
		}
	}
	if(is_tax('product_cat')){
		return true;
	}
	return false;
}

function itmartket_is_product_detail() {
	// TODO: shop configurable
	$array = array('single');
	foreach($array as $func){
		$funcName = 'is_' . $func;
		if ($funcName()) {
			return true;
		}
	}
	return false;
}

function impresscart_extension_template_render($content, $template, $directory = 'default') {
	ob_start();
	// TODO: default template
	$file = IMPRESSCART_PATH . '/extensions/templates/'.$directory.'/'. $template . '.php';
	if(file_exists($file)) {
		include $file;
	} else {
		$file = IMPRESSCART_PATH . '/extensions/templates/default/'. $template . '.php';
		if(file_exists($file)) {
			include $file;
		} else {
			echo $content;
		}
	}
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

function setProductView($ID) {
    $count_key = 'product_view';
    $count = get_post_meta($ID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($ID, $count_key);
        add_post_meta($ID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($ID, $count_key, $count);
    }
}