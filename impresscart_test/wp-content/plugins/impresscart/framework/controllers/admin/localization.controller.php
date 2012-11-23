<?php

class impresscart_admin_localization_controller extends impresscart_framework_controller {

	# #########################
	# manage countries
	# #########################
	public function countries_index(){
		$this->data['countries'] = $this->paginate->query($this->table_country, array(), 10);
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function countries_edit(){
		
		$ID = @$_GET['ID'];
		
		if ($this->isPost()) {
			
			$postcode_required = @$_POST['postcode_required']; 
			$status = @$_POST['status'];
			if($postcode_required == null) {
				$_POST['postcode_required'] = '0';
			}
			if($status == null) {
				$_POST['status'] = '0';
			}
			
			$_POST['country_id'] = $ID;
			unset($_POST['submit']);

			// check duplicate
			$errors = array();
			$countryModel = impresscart_framework::table('country');
			$country = $countryModel->fetchOne(array('conditions' => array(
				'name' => $_POST['name'],
				'country_id <>' => $ID
			)));
			if(!empty($country)){
				$errors[] = 'Country name already exists';
			}

			$country = $countryModel->fetchOne(array('conditions' =>array(
				'iso_code_2' => $_POST['iso_code_2'],
				'country_id <>' => $ID
			)));
			if(!empty($country)){
				$errors[] = 'ISO2 code already exists';
			}

			$country = $countryModel->fetchOne(array('conditions' =>array(
				'iso_code_3' => $_POST['iso_code_3'],
				'country_id <>' => $ID
			)));
			if(!empty($country)){
				$errors[] = 'ISO3 code already exists';
			}

			if (empty($errors)) {
				$temp = $countryModel->save($_POST);
				$this->redirect($this->url->link('/admin/localization/countries_index'));
			}
		}
		if ($ID) {
			$obj = impresscart_framework::table('country')->fetchOne(array('conditions' => array('country_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['country'] = $obj;
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function countries_delete(){
		$this->autoRender = false;
		impresscart_framework::table('country')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('admin/localization/countries_index'));
	}

	# #########################
	# manage countries zones
	# #########################
	public function country_zones_index() {
		$this->data['country_zones'] = $this->paginate->query($this->table_zone, array(), 10);
		$tmp = impresscart_framework::table('country')->fetchAll(array('order' => 'name ASC'));
		$countries = array();
		foreach($tmp as &$c){
			$countries[$c->country_id] = $c;
		}
		$this->data['countries'] = $countries;
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function country_zones_edit(){
		
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['zone_id'] = $ID;
			$status = @$_POST['status'];
			if($status == null) {
				$_POST['status'] = '0';
			}
			
			unset($_POST['submit']);

			// check duplicate
			$errors = array();

			$zoneTable = impresscart_framework::table('zone');
			
			$country = $zoneTable->fetchOne(array('conditions' => array(
				'name' => $_POST['name'],
				'country_id' => $_POST['country_id'],
				'zone_id <>' => $ID
			)));
			if(!empty($country)){
				$errors[] = 'Zone name already exists for selected country';
			}
			
			if (empty($errors)) {
				$zoneTable->save($_POST);
				$this->redirect($this->url->link('admin/localization/country_zones_index'));
			}
		}
		if ($ID) {
			$obj = impresscart_framework::table('zone')->fetchOne(array('conditions' => array('zone_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		
		$this->data['zone'] = $obj;
		$this->data['countries'] = impresscart_framework::table('country')->fetchAll(array('order' => 'name ASC'));		
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function country_zones_delete(){
		$this->autoRender = false;
		impresscart_framework::table('zone')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('admin/localization/country_zones_index'));
	}

	// ajax call
	public function country_zones_html_options(){
		$countryID = @$_GET['country_id'];
		$zones = impresscart_framework::table('zone')
					->fetchAll(array('conditions' => array('country_id' => $countryID), 'order' => 'name ASC'));					
		echo '<option value="0">All Zones</option>';
		foreach($zones as $zone){
			echo '<option value="' . $zone->zone_id . '">'.$zone->name.'</option>';
		}
		$this->autoRender = false;
		exit(0);
	}

	# #########################
	# manage geos
	# #########################
	public function geos_index(){
		$this->data['geos'] = impresscart_framework::table('geo_zone')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function geos_edit(){

		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['geo_zone_id'] = $ID;
			unset($_POST['submit']);

			// check duplicate
			$errors = array();

			$table = impresscart_framework::table('geo_zone');
			$geo = $table->fetchOne(array('conditions' => array(
				'name' => $_POST['name'],
				'geo_zone_id <>' => $ID
			)));
			if(!empty($geo)){
				$errors[] = 'Geo zone name already exists';
			}

			if (empty($errors)) {
				$geo = $_POST;
				$zones = @$_POST['zones'] ? $_POST['zones'] : array();
				unset($geo['zones']);
				$table->saveGeo($geo, $zones);
				$this->redirect($this->url->link('/admin/localization/geos_index'));
			}
		}
		if ($ID) {
			$obj = impresscart_framework::table('geo_zone')->fetchOne(array('conditions' => array('geo_zone_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['geo'] = $obj;
		if (empty($ID)) {
			$this->data['zones'] = array();
		} else {
			$this->data['zones'] = impresscart_framework::table('zone_to_geo_zone')->fetchAll(array('conditions' => array('geo_zone_id' => $ID)));
		}
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['countries'] = impresscart_framework::table('country')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
	
	
	public function geo_zones(){
	
		global $post;
		
		$obj = new impresscart_geo_zone($post->ID);
		$zones = $obj->get('zones');
		if (!($zones)) {
			$this->data['zones'] = array();
		} else {
			$this->data['zones'] = $zones;
		}
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['countries'] = impresscart_framework::table('country')->fetchAll();
	}
	

	public function geos_delete(){
		$this->autoRender = false;
		impresscart_framework::table('geo_zone')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('admin/localization/geos_index'));
	}

	# #########################
	# manage tax rates
	# #########################
	public function taxes_rate_index(){
		$rateTable = impresscart_framework::table('tax_rate');
		$rateTable->join(array(
			'table' => 'geo_zone',
			'alias'	=> 'GeoZone',
			'type' => 'left',
			'conditions' => array('GeoZone.geo_zone_id = TaxRate.geo_zone_id')
		));
		$this->data['taxes'] = $rateTable->fetchAll(array(
			'fields' => array('TaxRate.*', 'GeoZone.geo_zone_id as GeoZone_geo_zone_id', 'GeoZone.name as GeoZone_name'),
		));
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function taxes_rate_edit(){
		
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['tax_rate_id'] = $ID;
			unset($_POST['submit']);

			// check duplicate
			$errors = array();
			$taxModel = impresscart_framework::table('tax_rate');
			if (empty($errors)) {
				$tax = $_POST;
				$taxModel->save($tax);
				$this->redirect($this->url->link('/admin/localization/taxes_rate_index'));
			}
		}
		if ($ID) {
			$obj = impresscart_framework::table('tax_rate')
				->fetchOne(array('conditions' => array('tax_rate_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['tax'] = $obj;
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['geos'] = impresscart_framework::table('geo_zone')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function taxes_rate_delete() {
		$this->autoRender = false;
		impresscart_framework::table('tax_rate')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('/admin/localization/taxes_rate_index'));
	}

	# #########################
	# manage tax classes
	# #########################
	public function taxes_index() {
		$this->data['taxes'] = impresscart_framework::table('tax_class')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	public function taxes_edit(){
		
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['tax_class_id'] = $ID;
			unset($_POST['submit']);
			// check duplicate
			$errors = array();
			$taxModel = impresscart_framework::table('tax_class');
			
			$tax = $taxModel->fetchOne(array('conditions' => array(
										'title' => $_POST['title'],
										'tax_class_id <>' => $ID
									)));
			if(!empty($tax)) $errors[] = 'Tax class already exists'; 
			if (empty($errors)) {
				$tax = $_POST;
				$rules = @$_POST['rules'] ? $_POST['rules'] : array();
				unset($tax['rules']);
				$taxModel->saveTax($tax, $rules);
				$this->redirect($this->url->link('/admin/localization/taxes_index'));
				return;
			}
		}
		if ($ID) {
			$obj = impresscart_framework::table('tax_class')->fetchOne(array('conditions' => array('tax_class_id' => $ID)));
				
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['tax'] = $obj;
		if (empty($ID)) {
			$this->data['rules'] = array();
		} else {
			$this->data['rules'] = impresscart_framework::table('tax_rule')->fetchAll(array('conditions' => array('tax_class_id' => $ID)));
		}
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['rates']	= impresscart_framework::table('tax_rate')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
		
	}
	
	
	public function tax_rules(){
		global $post;		
		$posttype = new impresscart_tax_class($post->ID);
		$rules = $posttype->get('rules');
		$this->data['tax'] = $obj;
		if (!($rules)) {
			$this->data['rules'] = array();
		} else {
			$this->data['rules'] = $rules;
		}
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['rates']	= impresscart_framework::table('tax_rate')->fetchAll();
	}

	public function taxes_delete() {
		$this->autoRender = false;
		impresscart_framework::table('tax_class')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('/admin/localization/taxes_index'));
	}

	/**
	 *
	 * Enter description here ...
	 */
	public function units_index() {
		$this->data['list'] = impresscart_framework::table('unit')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}

	/**
	 *
	 * Enter description here ...
	 */

	public function units_edit() {

		$model = impresscart_framework::table('unit');

		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['unit_id'] = $ID;
			unset($_POST['submit']);

			// check duplicate
			$errors = array();
				
			$unit = $model->fetchOne(array('conditions' => array(
				'title' => $_POST['title'],
				'unit_id <>' => $ID
			)));
			if(!empty($country)){
				$errors[] = __('Unit name already exists','impressthemes');
			}

			$unit = $model->fetchOne(array('conditions' =>array(
				'unit' => $_POST['unit'],
				'unit_id <>' => $ID
			)));
			if(!empty($unit)){
				$errors[] = __('Unit unit already exists','impressthemes');
			}

			if (empty($errors)) {
				$model->save($_POST);
				$this->redirect($this->url->link('/admin/localization/units_index'));
			}
		}

		if ($ID) {
			$obj = $model->fetchOne(array('conditions' => array('unit_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['row'] = $obj;
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
	
	/**
	 *
	 * Enter description here ...
	 */
	public function units_delete() {
		$this->autoRender = false;
		impresscart_framework::table('unit')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('/admin/localization/units_index'));
	}
	/**
	 *
	 * Enter description here ...
	 */
	function currencies_index() {
		$this->data['list'] = impresscart_framework::table('currency')->fetchAll();
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
	
	function currencies_delete() {
		$this->autoRender = false;
		impresscart_framework::table('currency')->delete(@$_GET['ID']);
		$this->redirect($this->url->link('admin/localization/currencies_index'));
	}

	function currencies_edit() {
		$ID = @$_GET['ID'];
		$table = impresscart_framework::table('currency');
		if ($this->isPost()) {
			$_POST['currency_id'] = $ID;
			unset($_POST['submit']);

			// check duplicate
			$errors = array();

			$object = $table->fetchOne(array('conditions' => array(
				'title' => $_POST['title'],
				'currency_id <>' => $ID
			)));
			if(!empty($object)){
				$errors[] = __('Currency name already exists','impressthemes');
			}

			$unit = $table->fetchOne(array('conditions' =>array(
				'code' => $_POST['code'],
				'currency_id <>' => $ID
			)));
			if(!empty($unit)){
				$errors[] = __('Currency code already exists','impressthemes');
			}

			if (empty($errors)) {
				$data = $_POST;
				$data['date_modified'] = strftime('%Y-%m-%d %H:%M:%S',time());				
				$table->save($data);
				
				$this->redirect($this->url->link('/admin/localization/currencies_index'));
			}
		}

		if ($ID) {
			$obj = $table->fetchOne(array('conditions' => array('currency_id' => $ID)));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['row'] = $obj;
		$this->data['errors'] = @implode('<br/>', $errors);
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());
	}
	
	
	function order_status_index($params)
	{
		$order_statuses = $this->config->get('order_status_data');
		if(!$order_statuses)
		{
			$order_statuses = unserialize($params);
		} 
		foreach ($order_statuses as $key => $value) {
			$this->data['order_statuses'][] = array(
				'id' => $key,
				'name' => $value,
			);
		}				
	}
	
	
	function stock_status_index($params)
	{
		$stock_statuses = $this->config->get('stock_status_data');
		if(!$stock_statuses)
		{
			$stock_statuses = unserialize($params);
		}
		foreach ($stock_statuses as $key => $value) {
			$this->data['stock_statuses'][] = array(
				'id' => $key,
				'name' => $value,
			);
		}				
	}
	
	
	function return_status_index($params)
	{
		$return_statuses = $this->config->get('return_status_data');
		if(!$return_statuses)
		{
			$return_statuses = unserialize($params);
		} 
		foreach ($return_statuses as $key => $value) {
			$this->data['return_statuses'][] = array(
				'id' => $key,
				'name' => $value,
			);
		}				
	}
	
	
	function return_action_index($params)
	{
		$return_actions = $this->config->get('return_action_data');
		if(!$return_actions)
		{
			$return_actions = unserialize($params);
		} 
		foreach ($return_actions as $key => $value) {
			$this->data['return_actions'][] = array(
				'id' => $key,
				'name' => $value,
			);
		}				
	}
	
	
	function return_reason_index($params)
	{
		$return_reasons = $this->config->get('return_reason_data');
		if(!$return_reasons)
		{
			$return_reasons = unserialize($params);
		} 
		foreach ($return_reasons as $key => $value) {
			$this->data['return_reasons'][] = array(
				'id' => $key,
				'name' => $value,
			);
		}				
	}
	
}