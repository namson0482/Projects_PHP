<?php
class impresscart_url_service extends impresscart_service {

	public function link($route = '', $args = '', $ssl = false, $isPost = false) {
		
		global $post;
		# blogurl
		$blogUrl = get_bloginfo('url');

		if(is_admin())
		{
			if(!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
				/* special ajax here */
				return 'admin.php?page=catalog&fwurl=' . $route;
			}
		}

		# ssl support
		if($ssl && (!preg_match('/^https/i', $blogUrl))) {
			//$blogUrl = preg_replace('^http', 'https', $blogUrl);
		}

		$permalink = get_option('permalink_structure');
		$permalink = apply_filters('pre_post_link', $permalink, $post);
		//$id =
		$config = impresscart_framework::service('config');
		$page_id = $config->get($route);

		 
		if($permalink != '') {
			$blogUrl .= '/shop/' . $route;
		} else {
			//var_dump($page_id);
			if(@$page_id && !$isPost)
			{
				$blogUrl = get_permalink($page_id);

			} else {
				$blogUrl .= '?pagename=shop&route=' . urlencode($route) . '&';
			}
			 
		}

		return $blogUrl;
	}


}

?>