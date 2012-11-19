<?php

# init widgets
add_action('widgets_init', 'impresscart_cart_register_widget');

class impresscart_cart_widget extends WP_Widget
{
	function impresscart_cart_widget()
	{
		$widget_ops = array(
			'classname' =>  'impresscart_cart_widget',
			'description' =>  'Display cart widget.'
		);
		$this->WP_Widget( 'impresscart_cart_widget', 'Impress Shopping Cart',
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
		echo "<div id='impresscart_cart'></div>";
	}
}

function impresscart_cart_register_widget()
{
	register_widget('impresscart_cart_widget');
}

?>