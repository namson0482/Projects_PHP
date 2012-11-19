<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_post_types {

	var $post_types;
	var $taxonomies;

	function impresscart_post_types() {

		$this->post_types = apply_filters('impresscart_post_types', array());
		$this->taxonomies = apply_filters('impresscart_taxonomies', array());
		
	}

	/*
	 * register post types
	 */
	function register_post_types() {
		foreach ($this->post_types as $key => $args) {
			$test = register_post_type( $key, $args );
		}
	}

	/**
	 * register taxonomies
	 */
	function register_taxonomies() {
		foreach ($this->taxonomies as $key => $item) {
			register_taxonomy($key, $item[0], $item[1]);
		}
	}

	function get_posttypes() {
		return $this->post_types;
	}
}