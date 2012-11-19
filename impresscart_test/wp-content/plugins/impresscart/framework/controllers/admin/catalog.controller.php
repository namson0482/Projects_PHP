<?php

class impresscart_admin_catalog_controller extends impresscart_framework_controller {
	
	public function index() {	
		$this->data['pages'] = apply_filters('impresscart_administration_pages', array());		
	}

	public function download_index(){
		$this->data['downloads'] = $this->table_download->fetchAll();
	}

	public function download_edit(){
		$ID = @$_GET['ID'];
		if ($this->isPost()) {
			$_POST['download_id'] = $ID;
			unset($_POST['submit']);
			unset($_POST['file']);

			$dirs 		= wp_upload_dir();
			$basedir 	= $dirs['basedir'];
			$file = wp_handle_upload($_FILES['file'], array('test_form' => FALSE));
			$errors = array();

			if(empty($file)) {
				$errors[] = __('File upload error, please try again');
			} else {
				$_POST['filename'] = str_replace($basedir, '', $_FILES['file']);
				$_POST['mask'] = $_FILES['file']['name'];

				# remove old file
				$download = $this->table_download->fetchOne(array(
					'conditions' => array(
						'download_id' => $ID
					)
				));

				if(!empty($download->filename)) {
					@unlink($basedir . $download->filename);
				}
			}

			$this->table_download->save($_POST);
			$this->redirect('admin.php?page=catalog&fwurl=/admin/catalog/download_index');
		}
		if($ID){
			$obj = $this->table_download->fetchOne(array(
				'conditions' => array(
					'download_id' => $ID,
				)
			));
		} elseif($this->isPost()) {
			$obj = (object)$_POST;
		} else {
			$obj = new stdClass();
		}
		$this->data['download'] = $obj;
	}

	public function download_delete() {
		
		$this->autoRender = false;
		$this->table_download->delete(array(
			'download_id' => $_GET['ID'],
		));
		
		$this->redirect('admin.php?page=catalog&fwurl=/admin/catalog/download_index');
	}

	public function product_metabox_download(){
		global $post;
		$this->data['post'] 		= $post;
		$this->data['postmeta'] 	= (array)get_post_meta($post->ID, 'impresscart_product_downloads', true);
		$this->data['downloads']	= $this->table_download->fetchAll();
	}
	
	public function product_metabox_download_save(){
		global $post;
		$this->autoRender = false; // render nothing
		if(!empty($_POST['productdownloads'])) {
			update_post_meta($post->ID, 'impresscart_product_downloads', $_POST['productdownloads'] );
		}
	}
	
	function product_autocomplete_1()	{
		
		if (isset($_GET['filter_category_id'])) {
			$filter_category_id = $_GET['filter_category_id'];
		} else {
			$filter_category_id = '';
		}
		global $wpdb;
		$objects = get_objects_in_term($filter_category_id, 'product_cat');
		$args = array(
			'post_type'=> 'product',
			'term' => 'product_cat',
						
		);
		
		$json = array();
		
		foreach ($objects as $id)
		{
			$json[] = (array) $this->model_catalog_product->getProduct($id);				
		}
		
		echo json_encode($json);
        exit(0);
	}
		
	function product_autocomplete()	{
		
		$this->autoRender = false;

		
		if (isset($_GET['filter_name'])) {
			$filter_name = $_GET['filter_name'];
		} else {
			$filter_name = '';
		}
		
		if (isset($_GET['product_id'])) {
			$product_id = $_GET['product_id'];
		} else {
			$product_id = '';
		}
		
		global $wpdb, $post;
		$querystr  = " SELECT $wpdb->posts.*  FROM $wpdb->posts ";
		$querystr .= " WHERE $wpdb->posts.post_title LIKE '%" . $filter_name . "%'";
		$querystr .= " AND $wpdb->posts.post_type = 'product' ";
		$querystr .= " AND $wpdb->posts.post_status = 'publish' ";
		$querystr .= " AND $wpdb->posts.post_date < NOW() AND $wpdb->posts.ID != '" . $product_id . "'";
		$querystr .= " ORDER BY $wpdb->posts.post_title DESC ";
		
		$posts = $wpdb->get_results($querystr, OBJECT);
		
		
		$json = array();
		
		foreach ($posts as $post)
		{
			$json[] = (array) $this->model_catalog_product->getProduct($post->ID);				
		}
		
		echo json_encode($json);
        exit(0);
	}
}