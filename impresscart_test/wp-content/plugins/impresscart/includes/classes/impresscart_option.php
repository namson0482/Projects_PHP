<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
global $wpdb;

define('IMPRESSCART_OPTION_CLASS_DIR', dirname(__FILE__) . '/option_classes');
define('IMPRESSCART_OPTION_DB_TABLE', $wpdb->prefix . 'impresscart_product_options');

class impresscart_option {

	// ************************
	// FACTORY
	// ************************
	public static function factory($class){
		$classFile = IMPRESSCART_OPTION_CLASS_DIR . '/' . $class . '.option.php';
		$className = 'impresscart_option_class_' . $class;
		if (file_exists($classFile) && !class_exists($classFile)) {
			require_once IMPRESSCART_OPTION_CLASS_DIR . '/abstract.option.php';
			require_once $classFile;
		}

		if (class_exists($className)) {
			return new $className;
		}

		throw new Exception("$className class could not be found in $classFile or $classFile does not exist");
	}

	// ************************
	// DATABASE BASIC
	// ************************
	public static function dbSave($option){
            
		global $wpdb;

		// serialize meta before
		if(!is_string($option['meta'])){
			$option['meta'] = serialize($option['meta']);
		}

		if (!empty($option['ID'])) {
			// update
			$where = array('ID' => $option['ID']);
			unset($option['ID']);
			return $wpdb->update(IMPRESSCART_OPTION_DB_TABLE, $option, $where);
		} else {
			// insert
			unset($option['ID']);
			$wpdb->insert_id = null;
			$wpdb->insert(IMPRESSCART_OPTION_DB_TABLE, $option);      
			return $wpdb->insert_id;
		}
		
	}

	public static function dbDelete($optionID){
		global $wpdb;
		$optionID = (int)$optionID;
		return $wpdb->query("DELETE FROM ".IMPRESSCART_OPTION_DB_TABLE." WHERE ID={$optionID}");
	}

	public static function dbGetAll(){
		global $wpdb, $post;
        $results = $wpdb->get_results("SELECT * FROM ".IMPRESSCART_OPTION_DB_TABLE."");
        
		foreach($results as &$r){
			$r->meta = unserialize($r->meta);
			$term = get_term($r->group, 'product_group', OBJECT);
			$r->group_name = $term->name;
		}
		
		return $results;
	}

	public static function dbGetByID($ID){
		global $wpdb;
		$result = $wpdb->get_row("SELECT * FROM ".IMPRESSCART_OPTION_DB_TABLE." WHERE ID = " . (int)$ID);
		$result->meta = unserialize($result->meta);
		return $result;
	}

	// *****************************************
	// Init data
	// *************************************************
	public static function getSupportedOptionClasses(){
		return array(
			'checkbox' => 'Checkbox',
			'radio' => 'Radio',
			'select' => 'Select',
			'text' => 'Text',
		);
	}
        
        
}