<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_table {

	var $table = ''; // table name

	var $alias = '';

	var $lastQuery = '';

	var $primaryKey = 'ID'; // primary key

	var $_advancedConditions = array(' like', ' in', '>', '<>', '<', '<=', '>=', '=', '!=');

	var $_initialized = false;

	var $_joined = array();

	var $_availableJoins = array();

	var $_db = null;

	public function init() {
		if (!$this->_initialized) {
			global $wpdb;
			$this->_db = & $wpdb;
			$this->table = $this->_db->prefix . $this->table;
		}
		$this->_initialized = true;
	}

	/**
	 * @param array() $table join
	 * 		type => left | right
	 * 		table =>
	 * 		alias =>
	 * 		fields =>
	 * 		conditions => array()
	 * */
	public function join($table , &$recursive = 0) {
		if(is_array($table)) {
			$table['table_name'] = impresscart_framework::table($table['table'])->table;
			if(empty($table['alias'])) {
				$table['alias'] = $table['table'];
			}
			$this->_joined[$table['alias']] = $table;
		} elseif (isset($this->_availableJoins[$table])) {
			$recursive++;
			if($recursive > 5) {
				$table = var_export($table, true);
				throw new Exception("Cannot join $table");
			}
			$this->join($this->_availableJoins[$table], $recursive);
		} else {
			$table = var_export($table, true);
			throw new Exception("Cannot join $table");
		}
	}

	public function breakJoin($alias) {
		unset($this->_joined[$alias]);
	}

	public function save($data) {
		
		// serialize meta before
		if (!empty($data[$this->primaryKey])) {
			// update
			$where = array($this->primaryKey => $data[$this->primaryKey]);
			unset($data[$this->primaryKey]);
			return $this->_db->update($this->table, $data, $where);
		} else {
			// insert
			unset($data[$this->primaryKey]);
			$this->_db->insert_id = null;
			$this->_db->insert($this->table, $data);
			$this->_db->show_errors();
			return $this->_db->insert_id;
		}
	}

	public function delete($ID){
		if(!is_array($ID)) {
			$ID = array(
				$this->primaryKey => $this->_db->_real_escape($ID . '')
			);
		}

		$where = $this->_buildWhereSql($ID, '1=0');
		$sql = "DELETE FROM `{$this->table}` WHERE {$where}";
		$this->_setLastQuery($sql);
		return $this->_db->query($sql);
	}

	public function fetchAll($options = array(), $output = OBJECT) {
		$sql = $this->_buildSelectSql($options);
		$this->_setLastQuery($sql);
		return $this->_db->get_results($sql, $output);
	}

	public function fetchOne($options = array(), $output = OBJECT){
		$sql = $this->_buildSelectSql($options);
		$this->_setLastQuery($sql);
		return $this->_db->get_row($sql, $output);
	}

	protected function _hasAdvancedCondition($key){
		$key = trim($key);
		foreach ($this->_advancedConditions as &$c) {
			if (stripos($key, $c) !== false) {
				return true;
			}
		}
		return false;
	}

	protected function _buildSelectSql($options){
		if(empty($options['fields'])) {
			$fields = '*';
		} else {
			$fields = implode(',' , $options['fields']);
		}

		$sql = "select $fields from {$this->table} ";
		if(!empty($this->alias)) {
			$sql .= " as `{$this->alias}` ";
		}
		foreach($this->_joined as $join) {
			if(strtolower($join['type']) == 'left') {
				$sql .= ' LEFT JOIN ';
			} else {
				$sql .= ' RIGHT JOIN ';
			}
			$sql .= '`' . $join['table_name'] . '` as `' . $join['alias'] . '` ';
			$sql .= ' ON ' . $this->_buildWhereSql(@$join['conditions']);
		}
		$sql .= " WHERE " . $this->_buildWhereSql(@$options['conditions']);
		if (!empty($options['order'])) {
			if(is_array($options['order'])) {
				$options['order'] = implode(',', $options['order']);
			}
			$sql .= " ORDER BY {$options['order']} ";
		}

		if(!empty($options['limit'])) {
			if(!empty($options['offset'])) {
				$sql .= " LIMIT {$options['offset']}, {$options['limit']} ";
			} else {
				$sql .= " LIMIT {$options['limit']}";
			}
		}

		return $sql;
	}

	protected function _buildWhereSql($conditions, $default = '1=1', $combine = ' AND ', $bracket = false){
		$where = array();
		if(!empty($conditions)) {
			foreach($conditions as $key => $value){
				if (is_numeric($key)) {
					$where[] = $value;
				} elseif ( in_array(strtolower($key), array('or', 'and')) ) {
					$where[] = $this->_buildWhereSql($value, $default, ' ' . $key . ' ', true);
				} else {
					if(!is_array($value)) {
						$value = $this->_db->_real_escape($value);
					} else {
						if(empty($value)){
							$value = '(NULL)';
						} else {
							foreach ($value as &$val) {
								if(!is_array($val))
								$val = "'" . $this->_db->_real_escape($val) . "'";
							}
							$value = '(' . implode(', ', $value) . ')';
						}
					}
					$key = trim($key);
					if ($this->_hasAdvancedCondition($key)) {
						$where[] = "$key '$value'";
					} else {
						if(strpos($key, '.') !== false) {
							$keyExtract = explode('.', $key);
							$keyExtract[0] = trim($keyExtract[0], '`');
							$keyExtract[1] = trim($keyExtract[1], '`');
							$key = '`' . $keyExtract[0] . '`.`' . $keyExtract[1] . '`';
						} else {
							$key = '`' . trim($key, '`') . '`';
						}
						$where[] = "$key = '$value'";
					}
				}
			}
		}
		if(empty($where)) {
			$where[] = $default;
		}
		if($bracket) {
			return '(' . implode($combine , $where) . ')';
		} else {
			return implode($combine , $where);
		}
	}

	protected function _setLastQuery($sql){
		$this->lastQuery = $sql;
	}

}