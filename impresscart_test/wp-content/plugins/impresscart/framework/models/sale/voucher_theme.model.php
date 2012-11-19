<?php
class impresscart_sale_voucher_theme_model extends impresscart_model {
	
	function getThemes()
	{
		$orderby 			= 'name';
		$show_count 		= 1; // 1 for yes, 0 for no
		$pad_counts 		= 0; // 1 for yes, 0 for no
		$hierarchical 		= true; // 1 for yes, 0 for no
		$taxonomy 			= 'voucher_theme';
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
				'vocher_theme_id' => $category->term_id,
				'name' => $category->name
			);
		}
		
		return $data;	
	}	
}
?>