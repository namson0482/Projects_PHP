<?php

require_once IMPRESSCART_CLASSES . '/impresscart_attribute.php';

class impresscart_admin_attributes_controller extends impresscart_framework_controller {

	public function index(){
		// get attribute, ordered by group id
		$this->data['attributes'] = (array)impresscart_attribute::dbGetAllGrouped();
		
		$this->data['classes'] = impresscart_attribute::getSupportedAttributeClasses();
	}

	public function edit(){
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['ID'] = $ID;
			$_POST['group_id'] = (int)@$_POST['group_id'];
			unset($_POST['submit']);
			$_POST['meta'] = @$_POST['meta'] ? $_POST['meta'] : '';
			impresscart_attribute::dbSave($_POST);
			$this->redirect($this->url->link('/admin/attributes/index'));
			return;
		}
		if($ID){
			$obj = impresscart_attribute::dbGetByID($ID);
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
			$obj->class = $_GET['class'];
		}
		$this->data['attribute'] = $obj;
		$this->data['classes'] = impresscart_attribute::getSupportedAttributeClasses();
		$this->data['groups'] = $this->model_catalog_product->getProductGroups();
                
	}

	public function delete(){
		$this->autoRender = false;
		impresscart_attribute::dbDelete(@$_GET['ID']);
		$this->redirect($this->url->link('/admin/attributes/index'));
	}

	public function product_attributes_metabox(){
		global $post;
		$this->data['post'] = $post;
		$this->data['postmeta'] = (array)get_post_meta($post->ID, 'impresscart_product_attributes', true);
		$this->data['attributes'] = (array)impresscart_attribute::dbGetAllGrouped();
		$this->data['classes'] = impresscart_attribute::getSupportedAttributeClasses();
		$this->data['groups'] = $this->model_catalog_product->getProductGroups();
        $this->data['productgroups'] = $this->model_catalog_product->getGroupsByProduct($post->ID);                
	}

	public function product_attributes_metabox_save() {
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['productattributes'])){
			update_post_meta($post->ID, 'impresscart_product_attributes', $_POST['productattributes'] );
		}
	}

	public function product_general_metabox(){
		global $post;
		$this->data['post'] = $post;
		$this->data['postmeta'] = (array)get_post_meta($post->ID, 'impresscart_product_general_attributes', true);
		$this->data['attributes'] = impresscart_framework::model('catalog/product')->getGenerateAttributeClasses();
	}

	public function product_general_metabox_save(){
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['productgeneralattributes'])){
			update_post_meta($post->ID, 'impresscart_product_general_attributes', $_POST['productgeneralattributes'] );
		}
	}

	public function product_discount_metabox() {
		global $post, $wp_roles;
		$defaul_roles = array(
			'administrator', 
                        'editor', 'contributor','author','subscriber'
		);
		$groups = array();
		foreach($wp_roles->roles as $key => $role)
		{
			if(!in_array($key, $defaul_roles))
			{
				$groups[$key] = $role['name'];
			}			
		}
		$this->data['postmeta'] = get_post_meta($post->ID, 'impresscart_product_discounts', true);
		$this->data['postmeta'] = $this->data['postmeta'] ? (array)$this->data['postmeta'] : array();
		$this->data['groups'] = $groups;
	}
 
	public function product_discount_metabox_save() {		
		global $post;
		$this->autoRender = false; //render nothing
		if(@$_POST['productdiscounts'])
		update_post_meta($post->ID, 'impresscart_product_discounts', $_POST['productdiscounts'] );		
	}
   
  public function product_special_metabox() {
		global $post, $wp_roles;
		$defaul_roles = array(
			'administrator', 
			'editor', 'contributor','author','subscriber'
		);
		$groups = array();
		foreach($wp_roles->roles as $key => $role)
		{
			if(!in_array($key, $defaul_roles))
			{
				$groups[$key] = $role['name'];
			}			
		}
		$this->data['postmeta'] = get_post_meta($post->ID, 'impresscart_product_specials', true);
		$this->data['postmeta'] = $this->data['postmeta'] ? (array)$this->data['postmeta'] : array();
		$this->data['groups'] = $groups;
	}
  
  public function product_special_metabox_save() {
		global $post;
		$this->autoRender = false; // render nothing
		if(@$_POST['productspecials'])
		update_post_meta($post->ID, 'impresscart_product_specials', $_POST['productspecials'] );
		/* if(!empty($_POST['productspecials'])){
			update_post_meta($post->ID, 'impresscart_product_specials', $_POST['productspecials'] );
		}*/
	}

	public function product_reward_points_metabox() {
		global $post, $wp_roles;
		$defaul_roles = array(
			'administrator', 'editor', 'contributor','author','subscriber'
		);
		$groups = array();
		foreach($wp_roles->roles as $key => $role)
		{
			if(!in_array($key, $defaul_roles))
			{
				$groups[$key] = $role['name'];
			}			
		}
		
		$this->data['postmeta'] = get_post_meta($post->ID, 'impresscart_product_reward_points', true);
		$this->data['postmeta'] = $this->data['postmeta'] ? (array)$this->data['postmeta'] : array();
		$this->data['groups'] = $groups;
	}

	public function product_reward_points_metabox_save() {
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['productpoints'])){
			update_post_meta($post->ID, 'impresscart_product_reward_points', $_POST['productpoints'] );
		}
	}

	public function product_related_products_metabox() {
		global $post;
		$this->data['postmeta'] = get_post_meta($post->ID, 'impresscart_product_related_products', true);
		$this->data['postmeta'] = $this->data['postmeta'] ? (array)$this->data['postmeta'] : array();
		foreach($this->data['postmeta'] as &$var) {
			$var = get_post($var);
		}
		$this->data["ID"] = $post->ID;
				
	}

	public function product_related_products_metabox_save() {
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['related_products'])){
			update_post_meta($post->ID, 'impresscart_product_related_products', $_POST['related_products'] );
		}
	}
	
	public function product_image_metabox() {
			global $post;
			$images = get_post_meta($post->ID, 'product_image', true);
			$main_image = get_post_meta($post->ID, 'main_image', true);
			$html = '<div id="insert_images">';
			if(($images))
			foreach ($images as $src) {
				$html .= '<div><img width="32" height="32" src="' . $src .'" />';
				$html .= '<a class="product_image_remove" href="#">(remove)</a>';	
				$html .= '</div>';
			}
			$html .= '</div> <br/><div><input id="upload_image_button" type="button" value="Add images for your product" /></div>';
			$html .= '<input id="productPostId" type="hidden" value="'.$post->ID.'"/>';
			
			echo $html;	
			$this->autoRender = false;
	}
	
	public function product_image_metabox_save() {
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['product_image'])){
			update_post_meta($post->ID, 'product_image', $_POST['product_image']);			
		}
	}
}
