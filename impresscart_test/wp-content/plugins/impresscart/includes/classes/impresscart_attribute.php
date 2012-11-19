<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
global $wpdb;

define('IMPRESSCART_ATTRIBUTE_CLASS_DIR', dirname(__FILE__) . '/attribute_classes');
define('IMPRESSCART_ATTRIBUTE_DB_TABLE', $wpdb->prefix . 'impresscart_product_attributes');

class impresscart_attribute {

	protected static $_instances = array();

	// ************************
	// FACTORY
	// ************************
	public static function factory($class){
		if(isset(self::$_instances[$class])) {
			return self::$_instances[$class];
		}

		$classFile = IMPRESSCART_ATTRIBUTE_CLASS_DIR . '/' . $class . '.attribute.php';
		$className = 'impresscart_attribute_class_' . $class;
		if (file_exists($classFile) && !class_exists($classFile)) {
			require_once IMPRESSCART_ATTRIBUTE_CLASS_DIR . '/abstract.attribute.php';
			require_once $classFile;
		}

		if (class_exists($className)) {
			return self::$_instances[$class] = new $className;
		}

		throw new Exception("$className class could not be found in $classFile or $classFile does not exist");
	}

	// ************************
	// DATABASE BASIC
	// ************************
	public static function dbSave($attrib){
		global $wpdb;

		// serialize meta before
		if (!is_string($attrib['meta'])) {
			$attrib['meta'] = serialize($attrib['meta']);
		}

		if (!empty($attrib['ID'])) {
			// update
			$where = array('ID' => $attrib['ID']);
			unset($attrib['ID']);
			return $wpdb->update(IMPRESSCART_ATTRIBUTE_DB_TABLE, $attrib, $where);
		} else {
			// insert
			unset($attrib['ID']);
			$wpdb->insert_id = null;
			$wpdb->insert(IMPRESSCART_ATTRIBUTE_DB_TABLE, $attrib);
			return $wpdb->insert_id;
		}
	}

	public static function dbDelete($attribID){
		global $wpdb;
		$attribID = (int)$attribID;
		return $wpdb->query("DELETE FROM ".IMPRESSCART_ATTRIBUTE_DB_TABLE." WHERE ID={$attribID}");
	}

	public static function dbGetAll(){
			global $wpdb;
        	$results = $wpdb->get_results("SELECT * FROM ".IMPRESSCART_ATTRIBUTE_DB_TABLE."");    
			foreach($results as &$r){
			$r->meta = unserialize($r->meta);
		}
		return $results; 
	}

	public static function dbGetAllGrouped(){
		$attributes = self::dbGetAll();
		// null data
		if(empty($attributes)){
			return array();
		}

		// build the group
		$grouped = array(
			0 => array(
				'group' => new stdClass(),
				'attributes' => array()
			)
		);
		foreach($attributes as $attrib){
			if($attrib->class == 'group'){
				$grouped[$attrib->ID] = array();
				$grouped[$attrib->ID]['group'] = $attrib;
				$grouped[$attrib->ID]['attributes'] = array();
			} else {
				$term = get_term($attrib->group_id, 'product_group', OBJECT);
				if($term != null && !$term instanceof WP_Error) {
					$attrib->group_name = $term->name;
					$grouped[$attrib->group_id]['attributes'][] = $attrib;
				} 
																
			}
		}
		return $grouped;
	}

	public static function dbGetByID($ID){
		global $wpdb;
		$result = $wpdb->get_row("SELECT * FROM ". IMPRESSCART_ATTRIBUTE_DB_TABLE." WHERE ID = " . (int)$ID);
		$result->meta = unserialize($result->meta);
		return $result;
	}

	// *****************************************
	// Init data
	// *************************************************
	public static function getSupportedAttributeClasses(){
		return array(
			'group' => 'Group',
			'select' => 'Select',
			'text' => 'Text',
			'wysiwyg' => 'Html',
		);
	}

}