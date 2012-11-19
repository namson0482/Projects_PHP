<?php
class impresscart_localisation_language_model extends impresscart_model {
	public function getLanguage($language_id) {
		#$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE language_id = '" . (int)$language_id . "'");

		return impresscart_table::table('language')
				->fetchOne(array(
					'conditions' => array(
						'language_id' 	=> $language_id,
					)
				));
	}

	public function getLanguages() {
		$language_data = $this->cache->get('language');

		if (!$language_data) {
			$language_data = array();

			#$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

			$rows = impresscart_table::table('language')
				->fetchAll(array(
					'order' => 'sort_order, name'
				));

    		foreach ($rows as $result) {
      			$language_data[$result['language_id']] = array(
        			'language_id' => $result['language_id'],
        			'name'        => $result['name'],
        			'code'        => $result['code'],
					'locale'      => $result['locale'],
					'image'       => $result['image'],
					'directory'   => $result['directory'],
					'filename'    => $result['filename'],
					'sort_order'  => $result['sort_order'],
					'status'      => $result['status']
      			);
    		}

			$this->cache->set('language', $language_data);
		}

		return $language_data;
	}
}
?>