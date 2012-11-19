<?php

require_once dirname(__FILE__) . '/abstract.model.php';

class impresscart_local_unit_model extends impresscart_local_abstract_model {
	var $table = 'impresscart_units';
	var $primaryKey = 'ID';
}