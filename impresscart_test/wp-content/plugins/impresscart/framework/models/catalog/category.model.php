<?php
class impresscart_catalog_category_model extends impresscart_model {

	public function getCategory($category_id) {
		return array(); #TODO
	}

	public function getCategories($parent_id = 0) {		
		//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
		$orderby 			= 'name';
		$show_count 		= 1; // 1 for yes, 0 for no
		$pad_counts 		= 0; // 1 for yes, 0 for no
		$hierarchical 		= true; // 1 for yes, 0 for no
		$taxonomy 			= 'product_cat';
		$title 				= '';
		$hideempty			= 0;

		$args = array(
		  'orderby' 		=> $orderby,
		  'show_count' 		=> $show_count,
		  'pad_counts' 		=> $pad_counts,
		  'hierarchical' 	=> $hierarchical,
		  'taxonomy' 		=> $taxonomy,
		  'title_li' 		=> $title,
		  'hide_empty' 		=> $hideempty,
		);
		
		$categories = get_categories( $args );
		$data = array();
		
		foreach ($categories as $category)
		{
			$data[] = array(
				'category_id' => $category->term_id,
				'name' => $category->name
			);
		}
		
		return $data;		
	}

	public function getCategoriesByParentId($category_id) {

		return array(); #TODO

	}

	public function getCategoryLayoutId($category_id) {

		return 0; #TODO

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_category');
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {

		return 100; #TODO

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}
}
?>