<?php

class impresscart_weight_class_table extends impresscart_table {
	function fetchAll($options = array(), $output = OBJECT)
	{
		$posts = get_posts(array('post_type' => 'weight_class'));
		$weight_classes = array();
		foreach($posts as $post)
		{
			$obj = new impresscart_weight_class($post->ID);
			$std = new stdClass();
			$std->weight_class_id = $post->ID;
			$std->name = $post->post_title;
			$std->unit = $obj->get('unit');
			$std->value = $obj->get('value');
			$weight_classes[] = $std;			
		}
		
		return  $weight_classes;
	}
	
	function fetchOne($options = array(), $output = OBJECT)
	{
		if(isset($options['conditions']['weight_class_id']))		{
			
			$id = $options['conditions']['weight_class_id'];
			
			$post = get_post($id);
			$std = new stdClass();
			$std->weight_class_id = $post->ID;
			$std->name = $post->post_title;
			$std->unit = $obj->get('unit');
			$std->value = $obj->get('value');
			$std->name = $post->post_title;
			return $std;			
		}
		return false;
	}
	
}