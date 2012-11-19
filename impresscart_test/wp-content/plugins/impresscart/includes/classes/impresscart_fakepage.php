<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_fakepage {
	public static $defaultRoute = '/catalog/product/index';
	public static $_rules = array(
			'shop' => array(
			'post_title' => '',
			'post_content' => '[itmarket action="/catalog/product/index"/]'			
		),
	);
	public static function init(){	
		
		$self = new self();
		add_rewrite_rule('^shop/([^/]*)/([^/]*)/?','index.php?pagename=shop&route=$matches[1]/$matches[2]','top');
		add_filter('rewrite_rules_array', array($self, 'rewrite_rules_array'));
		add_filter('query_vars', array($self, 'query_vars'));
		add_action('wp_enqueue_scripts', array($self,'add_impresscart_scripts'));
		add_action('wp_enqueue_scripts', array($self,'add_impresscart_styles'));
		
	}
	
	public static function getPage(){
		
		global $slug;
		
		$pagename 	= get_query_var('pagename');
		$route 		= get_query_var('route');
				
		if($pagename == 'shop') {
			global $post;
			if(!$post) {
				$post = new stdClass();
			}
			$post->post_author = 1;
			$post->post_name = $slug;
			$post->guid = md5($pagename . $route);
			$post->ID = -1;
			$post->post_parent = null;
			$post->post_status = 'static';
			$post->comment_status = 'closed';
			$post->comment_count = 0;
			$post->post_date = current_time('mysql');
			$post->post_date_gmt = current_time('mysql', 1);
			$post->ping_status = isset($post->ping_status) ? $post->ping_status : false;
			$post->post_type = isset($post->post_type) ? $post->post_type : 'impresscart_shoppage';
			$post->post_title = '';
			ob_start();
			impresscart_framework::getInstance()
				->dispatch($route);
			$post->post_content = ob_get_contents();
			ob_end_clean();
			return $post;
		}
		return null;
	}

	public function rewrite_rules_array($rules){
		return $rules;
	}

	public function query_vars($vars){
		
		$vars[] = 'route';
		return $vars;
	}

	function add_impresscart_scripts()	{

	}

	function add_impresscart_styles() {

	}
}