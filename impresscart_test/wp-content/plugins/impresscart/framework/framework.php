<?php
/**
@author: impressthemes
@email: giapps@gmail.com
@author URI: http://impressthemes.com
@copyright (C) 2012 impressthemes.com. All rights reserved.
@license: GPLv2
*/
require_once IMPRESSCART_FRAMEWORK_APP_DIR . '/table.php';
require_once IMPRESSCART_FRAMEWORK_APP_DIR . '/model.php';
require_once IMPRESSCART_FRAMEWORK_APP_DIR . '/service.php';
require_once IMPRESSCART_FRAMEWORK_APP_DIR . '/controller.php';


class impresscart_framework {

	protected static $_instance = null;
	protected static $_models = array();
	protected static $_services = array();
	protected static $_tables = array();

	// WHY base URL, PARAMS? because
	// baseURL = admin base , domain.com/admin.php
	// baseParams = base params to this dispatcher (ex page=impresscart_options)
	// ===> very good to build the route
	protected $_baseUrl = null;
	protected $_baseParams = array();
	protected $_defaultUrl = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function setBaseUrl($url) {
		$this->_baseUrl = $url;
		return $this;
	}

	public function setBaseParams($params) {
		$this->_baseParams = $params;
		return $this;
	}

	public function setDefaultUrl($url) {
		$this->_defaultUrl = $url;
		return $this;
	}

	public function dispatch($url = null) {

		$millitime_1 = round(microtime(true) * 1000);
		$orginal = $url;
		if (empty($url)) {
			$url = @$_REQUEST['fwurl'] ? $_REQUEST['fwurl'] : $this->_defaultUrl;
		}
		$url = trim($url, '/');
		if (null == $this->_baseUrl) {
				
			$pageURL = 'http';
			if (@$_SERVER["HTTPS"] == "on") {
				$pageURL .= "s";
			}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]. ($_SERVER["SCRIPT_NAME"]);
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"]. ($_SERVER["SCRIPT_NAME"]);
			}
			$this->_baseUrl = $pageURL;
				
		}

		if (empty($this->_baseParams)) {
			$this->_baseParams = $_GET;
		}

		$params 	= explode('/', $url);
		$nParams 	= count($params);

		if($nParams == 1) {
			$controller 	= $params[0];
			$action 		= 'index';
			$params 		= array();
		} elseif ($nParams == 2) {
			$controller 	= implode('/', array($params[0], $params[1]));
			$action 		= 'index';
			$params 		= array();
		} elseif ($nParams > 2) {
			$controller 	= implode('/', array($params[0], $params[1]));
			$action 		= $params[2];
			# remove 3 first params
			array_shift($params);array_shift($params);array_shift($params);
		}

		if($orginal == '/admin/user') {
			var_dump($controller);
			var_dump($params);
			
		}
		
		$app_paths = apply_filters('impresscart_application_path', array());

		if(!count($app_paths)) {
			echo __('not found!!!').' -- '.$app_paths;
			return;
		}

		$controller2 = str_replace('/', '_', $controller);
		$controllerClass = '';

		foreach($app_paths as $app_path) {
				
			$controllerFile = $app_path . '/controllers/' . $controller. '.controller.php';
			$controllerClass = 'impresscart_' . $controller2 . '_controller';
				
			if (file_exists($controllerFile) && !class_exists($controllerClass)) {
				require_once $controllerFile;
				break;
			}
				
		}

		if (class_exists($controllerClass)) {
				
			// call action
			$controllerObj = new $controllerClass;
			$controllerObj->controller = $controller;
			$controllerObj->action = $action;
			call_user_func_array(array($controllerObj, $action), $params);
			if ($controllerObj->autoRender) {
				$controllerObj->render();
			}
		}
	}




	public function buildURL($url, $params = array()) {
		$params = array_merge($this->_baseParams, $params);
		$params['fwurl'] = $url;
		if(empty($this->_baseUrl)) {
			$this->_baseUrl == $_SERVER['PHP_SELF'];
		}
		$ret = $this->_baseUrl . '?';
		foreach ($params as $key => $value) {
			$ret .= $key . '=' . urlencode($value) . '&';
		}
		return $ret;
	}

	/**
	 * @example impresscart_framework::model('account/transaction')
	 * */
	public static function model($model) {

		# remove / at first and end
		$model = trim($model, '/');

		# return if existed
		if(isset(self::$_models[$model])) {
			return self::$_models[$model];
		}

		# try to load

		$app_paths = apply_filters('impresscart_application_path', array());
		foreach($app_paths as $app_path)
		{
			$modelFile = $app_path . '/models/' . $model . '.model.php';
			$modelClass = 'impresscart_' . str_replace('/', '_', $model) . '_model';
			if(file_exists($modelFile)) {
				require_once $modelFile;
				break;
			}
				
		}

		if(class_exists($modelClass)) {
			self::$_models[$model] = new $modelClass;
			return self::$_models[$model];
		}

		throw new Exception("Model $model is not exist");
	}

	public static function service($service) {

		# return if existed
		if(isset(self::$_services[$service])) {
			return self::$_services[$service];
		}

		# try to load
		$app_paths = apply_filters('impresscart_application_path', array());
		foreach($app_paths as $app_path)
		{
			$srvFile = $app_path . '/services/' . $service . '.service.php';
			$srvClass = 'impresscart_' . $service . '_service';

			if (file_exists($srvFile)) {
				require_once $srvFile;
				break;
			}
		}

		if(class_exists($srvClass)) {
			self::$_services[$service] = new $srvClass;
			return self::$_services[$service];
		}

		throw new Exception("Service $service is not exist");
	}

	public static function table($table) {
		# return if existed
		if(isset(self::$_tables[$table])) {
			return self::$_tables[$table];
		}

		# try to load
		$srvFile = IMPRESSCART_FRAMEWORK_APP_DIR . '/tables/' . $table . '.table.php';
		$srvClass = 'impresscart_' . $table . '_table';

		if(file_exists($srvFile)) {
			require_once $srvFile;
		}

		if(class_exists($srvClass)) {
			self::$_tables[$table] = new $srvClass;
			self::$_tables[$table]->init();
			return self::$_tables[$table];
		}

		throw new Exception("Table $table is not exist");
	}

	public static function msgBox($msg) {
		echo '<script>alert("'. $msg .'");</script>';
	}

}