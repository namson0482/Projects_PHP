<?php

class impresscart_length_class_table extends impresscart_table {
	
	function fetchAll($options = array(), $output = OBJECT)
	{
		$posts = get_posts(array('post_type' => 'length_class'));
		$length_classes = array();
		foreach($posts as $post)
		{
			$obj = new impresscart_length_class($post->ID);
			$std = new stdClass();
			$std->length_class_id = $post->ID;
			$std->name = $post->post_title;
			$std->unit = $obj->get('unit');
			$std->value = $obj->get('value');
			$length_classes[] = $std;			
		}
		
		return  $length_classes;
	}
	
	function fetchOne($options = array(), $output = OBJECT)
	{
		if(isset($options['conditions']['length_class_id']))
		{
			
			$id = $options['conditions']['length_class_id'];
			
			$post = get_post($id);
			$obj = new impresscart_length_class($post->ID);
			$std = new stdClass();
			$std->length_class_id = $post->ID;
			$std->name = $post->post_title;
			$std->unit = $obj->get('unit');
			$std->value = $obj->get('value');
			return $std;			
		}
		return false;
	}
}