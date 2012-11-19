<?php

# init widgets
add_action('widgets_init', 'impresscart_category_register_widget');

class impresscart_category_widget extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'classname' =>  'impresscart_category_widget',
			'description' =>  'Display category widget.'
		);
		parent::__construct( 'categories', 'Impress Cart Product Categories',
			$widget_ops );
	}

	function form($instance)
	{

	}

	function update($new_instance, $old_instance)
	{

	}

	function widget($args, $instance)
	{
		//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
		$orderby 			= 'name';
		$show_count 		= 1; // 1 for yes, 0 for no
		$pad_counts 		= 0; // 1 for yes, 0 for no
		$hierarchical 		= true; // 1 for yes, 0 for no
		$taxonomy 			= 'product_cat';
		$title 				= '';
		$hideempty			= 0;
        $tag_ID            = 5;
		$args = array(
		  'orderby' 		=> $orderby,
		  'show_count' 		=> $show_count,
		  'pad_counts' 		=> $pad_counts,
		  'hierarchical' 	=> $hierarchical,
		  'taxonomy' 		=> $taxonomy,
		  'title_li' 		=> $title,
		  'hide_empty' 		=> $hideempty,
          'tag_ID'         => $tag_ID,
          'post_type'         => 'product',
		);
		echo '<h3 style="font-family:Century Gothic;font-size:14px;color:#616163;padding-left:15px;">CATEGORIES</h3>';
		echo '<ul>';
      
		wp_list_categories($args);
        
		echo '</ul>';
        
        $posts_array = get_posts( $args ); 
        
  
  }
}

function impresscart_category_register_widget()
{
	register_widget('impresscart_category_widget');
}

?>