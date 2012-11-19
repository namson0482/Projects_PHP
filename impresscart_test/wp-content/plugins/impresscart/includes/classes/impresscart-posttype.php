<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_posttype
{
	protected $id;
	protected $metaboxes;
	public static $error;
	
	function __construct()
	{
		$this->metaboxes = array();
	}
	
	function get($key)
	{
		return get_post_meta($this->id, @$prefix . $key, true);
	}
	
	function show_metabox($metabox)
	{
		$obj = new impresscart_metaboxes();		
		if(isset($metabox['args']['tab']))
		{
			echo '<script language="javascript">
		    		jQuery(document).ready(function(){
						jQuery(".impresscart_tabs").tabs();
						jQuery("#TB_window,#TB_overlay,#TB_HideSelect").unbind("unload");
					});
		    	</script>';
			$obj->impresscart_draw_metabox( $this->metaboxes[$metabox['args']['name']] , true);
		} else {
			
			$obj->impresscart_draw_metabox( $this->metaboxes[$metabox['args']['name']] , false);
		}
	}
	
	function save()
	{
		if($this->validate())
		{
			$post_id = $this->id;		
		    // check autosave
		    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		        return $post_id;
		    }
		
			if (!current_user_can('edit_page', $post_id)) {
		    	return $post_id;
		    }
		    
		    
		    	       	
		    foreach ($this->metaboxes['data']['fields'] as $field) {
		    	update_post_meta($post_id, $field['id'],$_POST[$field['id']]);
		    }		
		} 
	}	
	
	function validate()
	{
		return true;
	}
}

?>