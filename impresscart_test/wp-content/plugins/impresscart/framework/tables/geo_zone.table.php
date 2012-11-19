<?php

class impresscart_geo_zone_table extends impresscart_table {
	var $table = 'impresscart_geo_zone';
	var $primaryKey = 'geo_zone_id';

	public function saveGeo($geo, $zones){

		# save geo first
		$ID = $this->save($geo);
		if(isset($geo['geo_zone_id'])) {
			$ID = $geo['geo_zone_id'];
		}

		# save zones of this geo
		$table = impresscart_framework::table('zone_to_geo_zone');
		$table->delete(array('geo_zone_id' => $ID));

		foreach ($zones as $zone) {
			$zone['geo_zone_id'] = $ID;
			unset($zone['zone_to_geo_zone_id']);
			$table->save($zone);
		}

		return $ID;
	}

	public function deleteGeo($ID){

		$zoneTable = impresscart_framework::table('zone_to_geo_zone');

		$geos = $this->fetchAll(array('conditions' => array(
			$this->primaryKey => $ID
		))); // find all first

		foreach($geos as $geo) {
			# delete geo and all geo zones
			$this->delete($geo->geo_zone_id);
			$zoneTable->delete(array('geo_zone_id' => $geo->geo_zone_id));
		}

	}
}