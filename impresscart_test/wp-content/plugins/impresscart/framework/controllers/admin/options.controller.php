<?php

require_once IMPRESSCART_CLASSES . '/impresscart_option.php';

class impresscart_admin_options_controller extends impresscart_framework_controller {

	public function index(){
		$this->data['options'] = (array)impresscart_option::dbGetAll();
		$this->data['classes'] = impresscart_option::getSupportedOptionClasses();
	}

	public function edit(){
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['ID'] = $ID;
			unset($_POST['submit']);
			$_POST['meta'] = @$_POST['meta'] ? $_POST['meta'] : '';
			impresscart_option::dbSave($_POST);
			$this->redirect($this->url->link('/admin/options/index'));
		}
		if($ID){
			$obj = impresscart_option::dbGetByID($ID);
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
			$obj->class = $_GET['class'];
		}
		$this->data['option'] = $obj;
		$this->data['classes'] = impresscart_option::getSupportedOptionClasses();
		$this->data['groups'] = $this->model_catalog_product->getProductGroups();
	}

	public function delete(){
		$this->autoRender = false;
		impresscart_option::dbDelete(@$_GET['ID']);
		$this->redirect($this->url->link('/admin/options/index'));
	}

	public function product_options_metabox(){
		global $post;
		$this->data['post'] = $post;
		$this->data['postmeta'] = (array)get_post_meta($post->ID, 'impresscart_product_options', true);
		$this->data['options'] = (array)impresscart_option::dbGetAll();
		$this->data['classes'] = impresscart_option::getSupportedOptionClasses();
		$this->data['productgroups'] = $this->model_catalog_product->getGroupsByProduct($post->ID);
	}

	public function product_options_metabox_save(){
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['productoptions'])) {
			update_post_meta($post->ID, 'impresscart_product_options', $_POST['productoptions'] );
		}
	}
}