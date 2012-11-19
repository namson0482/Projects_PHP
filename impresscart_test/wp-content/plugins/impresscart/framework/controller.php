<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_framework_controller {

	var $data = array();
	var $controller = null;
	var $action = null;
	var $autoRender = true;

	function __construct() {

	}

	private function isAdminController() {

		$params = explode('_', get_class($this));

		return $params[1] == 'admin' ? true : false;

	}

	public function render($path = null, $return = false) {
		
		//disable auto p
		remove_filter('the_content', 'wpautop');
		remove_filter('comment_text', 'wpautop');
		remove_filter('the_excerpt', 'wpautop');
			
		// Remove auto formatting
		remove_filter('the_content', 'wptexturize');
		remove_filter('comment_text', 'wptexturize');
		remove_filter('the_title', 'wptexturize');

		$app_paths = apply_filters('impresscart_application_path', array());
		$count = count($app_paths);
		
		$exists = false;
		
		$tempPath = '/views/' . $this->controller . '/'. $this->action . '.template.php';
		if(null !== $path) {
			$tempPath = '/views/' . $path . '.template.php';	
		}
				
		if($this->isAdminController() || (!$this->isAdminController() && $this->config->get('themedir') == '') ) {
			for($i=0; $i<$count; $i++) {
				$viewpath = $app_paths[$i];
				$viewFile = $viewpath . $tempPath;
				
				if(!file_exists($viewFile)){
					$exists = false;
				} else {
					$exists = true;
					$i= $count;
				}
				
			}
		} else if(!$this->isAdminController()) {
			if($this->config->get('themedir') != '') {
				$viewpath =  WP_CONTENT_DIR . '/'. $this->config->get('themedir');
				$viewFile = $viewpath . $tempPath;
				$exists = true;
			}
		} 

		if(!$exists) {
			throw new Exception("$viewFile view not found");
		}
		
		extract($this->data);
		$framework = impresscart_framework::getInstance();
	
		ob_start();
		require $viewFile;
		$content = ob_get_contents();
		ob_end_clean();
	
		if(!$this->autoRender) {		
			return $content;			
		} else {
			echo $content;
		}
	}
	
	public function isPost(){
		return !empty($_POST);
	}

	public function redirect($url){
		$this->autoRender = false;
		if( substr($url, -1, 1) == '&') $url = substr($url,0,-1) ;
		echo '<meta http-equiv="REFRESH" content="0;'.$url.'" />';
	}

	public function __get($key) {
		if(isset($this->{$key})) {
			return $this->{$key};
		}
		try {
			if(strpos($key, 'model_') === 0) {
				$this->{$key} = impresscart_framework::model(str_replace('_', '/', substr($key, 6)));
			} elseif (strpos($key, 'table_') === 0) {
				$this->{$key} = impresscart_framework::table(substr($key, 6));
			} else {
				$this->{$key} = impresscart_framework::service($key);
			}
			return $this->{$key};
		} catch (Exception $e){
			
			/*if($key == 'model_total_vouchertotal') {
				var_dump('aaaaaaaa');
				die();
			}
			*/
			return null;
		}
	}

	public function __set($key, $value) {
		$this->{$key} = $value;
	}
}