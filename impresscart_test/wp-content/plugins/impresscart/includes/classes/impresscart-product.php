<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
/**
 *
 * @author giappv
 *
 */

add_filter('impresscart_post_types','impresscart_product_post_type');

function impresscart_product_post_type($posttypes) {
	
	$posttypes['product'] = array(
         'labels' => array(
        	'name' 					=> __( 'Products', 'impressthemes' ),
            'singular_name' 		=> __( 'Product', 'impressthemes' ),
            'add_new' 				=> __( 'Add Product', 'impressthemes' ),
            'add_new_item' 			=> __( 'Add New Product', 'impressthemes' ),
            'edit' 					=> __( 'Edit', 'impressthemes' ),
            'edit_item' 			=> __( 'Edit Product', 'impressthemes' ),
            'new_item' 				=> __( 'New Product', 'impressthemes' ),
            'view' 					=> __( 'View Product', 'impressthemes' ),
            'view_item' 			=> __( 'View Product', 'impressthemes' ),
            'search_items' 			=> __( 'Search Products', 'impressthemes' ),
            'not_found' 			=> __( 'No Products found', 'impressthemes' ),
            'not_found_in_trash' 	=> __( 'No Products found in trash', 'impressthemes' ),
            'parent' 				=> __( 'Parent Product', 'impressthemes' )
		),
        'description' 			=> __( 'This is where you can add new products to your store.', 'impressthemes' ),
        'public' 				=> true,
        'show_ui' 				=> true,
        'show_in_menu' => true,
        'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> false,
        'rewrite' 				=> array( 'slug' => @$product_base, 'with_front' => false ),
        'supports' 				=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
        'taxonomy' => array('category', 'post_tag')                
	);

	return $posttypes;
}


/**
 * product_type
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_product_type_taxonomies');

function impresscart_product_type_taxonomies($taxonomies) {
	$taxonomies['product_type'] = array(
			'product',
			array(
						'hierarchical' 			=> false,
						'show_ui' 				=> false,
						'show_in_nav_menus' 	=> false,
						'query_var' 			=> is_admin(),
						'rewrite'				=> false,
			)
	);
	return $taxonomies;
}

/**
 * product_manufacture
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_product_manufacture_taxonomies');

function impresscart_product_manufacture_taxonomies($taxonomies) {
	$taxonomies['product_manufacture'] = array (
			'product',
	array (
				'hierarchical' 			=> false,
		            'show_ui' 				=> true,
		            'show_in_nav_menus' 	=> false,
		            'query_var' 			=> is_admin(),
		            'rewrite'				=> false,
					'labels' => array(
	                    'name' 				=> __( 'Manufacture', 'impressthemes'),
	                    'singular_name' 	=> __( 'Product Manufacture', 'impressthemes'),
	                    'search_items' 		=>  __( 'Search Product Manufactures', 'impressthemes'),
	                    'all_items' 		=> __( 'All Product Manufactures', 'impressthemes'),	                   
	                    'edit_item' 		=> __( 'Edit Manufacture', 'impressthemes'),
	                    'update_item' 		=> __( 'Update Manufacture', 'impressthemes'),
	                    'add_new_item' 		=> __( 'Add New Manufacture', 'impressthemes'),
	                    'new_item_name' 	=> __( 'New Manufacture', 'impressthemes'),
						'separate_items_with_commas' => '',
						'choose_from_most_used' => 'Select a manufacture.'
						),
						)
						);
						return $taxonomies;
}


/**
 * product_cat
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_product_cat_taxonomies');

function impresscart_product_cat_taxonomies($taxonomies) {
	$taxonomies['product_cat'] = array(
				'product',
	array(
		            'hierarchical' 			=> true,
		            'update_count_callback' => '_update_post_term_count',
		            'label' 				=> __( 'Categories', 'impressthemes'),
		            'labels' => array(
		                    'name' 				=> __( 'Categories', 'impressthemes'),
		                    'singular_name' 	=> __( 'Product Category', 'impressthemes'),
		                    'search_items' 		=>  __( 'Search Product Categories', 'impressthemes'),
		                    'all_items' 		=> __( 'All Product Categories', 'impressthemes'),
		                    'parent_item' 		=> __( 'Parent Product Category', 'impressthemes'),
		                    'parent_item_colon' => __( 'Parent Product Category:', 'impressthemes'),
		                    'edit_item' 		=> __( 'Edit Product Category', 'impressthemes'),
		                    'update_item' 		=> __( 'Update Product Category', 'impressthemes'),
		                    'add_new_item' 		=> __( 'Add New Product Category', 'impressthemes'),
		                    'new_item_name' 	=> __( 'New Product Category Name', 'impressthemes')
	),
		            'show_ui' 				=> true,
		            'query_var' 			=> true,
		            'rewrite' 				=> array( 'slug' => @$category_base . _x('product-category', 'slug', 'impressthemes'), 'with_front' => false ),
	)
	);
	return $taxonomies;
}


/**
 * product_tag
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_product_tag_taxonomies');

function impresscart_product_tag_taxonomies($taxonomies) {
	$taxonomies['product_tag'] = array(
				'product',
	array(
                                    'hierarchical' 			=> false,
                                    'label' 				=> __( 'Tags', 'impressthemes'),
                                    'labels' => array(
                                    'name' 				=> __( 'Tags', 'impressthemes'),
                                    'singular_name' 	=> __( 'Product Tag', 'impressthemes'),
                                    'search_items' 		=>  __( 'Search Product Tags', 'impressthemes'),
                                    'all_items' 		=> __( 'All Product Tags', 'impressthemes'),
                                    'parent_item' 		=> __( 'Parent Product Tag', 'impressthemes'),
                                    'parent_item_colon' => __( 'Parent Product Tag:', 'impressthemes'),
                                    'edit_item' 		=> __( 'Edit Product Tag', 'impressthemes'),
                                    'update_item' 		=> __( 'Update Product Tag', 'impressthemes'),
                                    'add_new_item' 		=> __( 'Add New Product Tag', 'impressthemes'),
                                    'new_item_name' 	=> __( 'New Product Tag Name', 'impressthemes')
	),
                        'show_ui' 				=> true,
                        'query_var' 			=> true,
                        'rewrite' 				=> array( 'slug' => @$category_base . _x('product-tag', 'slug', 'impressthemes'), 'with_front' => false ),
	),

	);
	return $taxonomies;
}


/**
 * product_tag
 * @author : goscom
 */
add_filter('impresscart_taxonomies', 'impresscart_product_group_taxonomies');

function impresscart_product_group_taxonomies($taxonomies) {
	
	$taxonomies['product_group'] = array(
				'product',
	array (
                                    'hierarchical' 			=> false,
                                    'label' 				=> __( 'Tags', 'impressthemes'),
                                    'labels' => array (
                                    'name' 				=> __( 'Groups', 'impressthemes'),
                                    'singular_name' 	=> __( 'Product Group', 'impressthemes'),
                                    'search_items' 		=>  __( 'Search Product Groups', 'impressthemes'),
                                    'all_items' 		=> __( 'All Product Groups', 'impressthemes'),
                                    'parent_item' 		=> __( 'Parent Product Group', 'impressthemes'),
                                    'parent_item_colon' => __( 'Parent Product Group:', 'impressthemes'),
                                    'edit_item' 		=> __( 'Edit Product Group', 'impressthemes'),
                                    'update_item' 		=> __( 'Update Product Group', 'impressthemes'),
                                    'add_new_item' 		=> __( 'Add New Product Group', 'impressthemes'),
                                    'new_item_name' 	=> __( 'New Product Group Name', 'impressthemes')
	),
                        'show_ui' 				=> true,
                        'query_var' 			=> true,
                        'rewrite' 				=> array( 'slug' => @$category_base . _x('product-Group', 'slug', 'impressthemes'), 'with_front' => false ),
	),

	);
	return $taxonomies;
}


/**
 * related_products
 */
add_filter('impresscart_related_products', 'impresscart_related_products_metabox');

function impresscart_related_products_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/attributes/post_related_products_metabox');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}


/**
 * product_image
 */
add_filter('impresscart_product_image', 'impresscart_product_image_metabox');

function impresscart_product_image_metabox() {
	$html = '';
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/attributes/product_image_metabox');
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}


add_filter('impresscart_administration_pages', 'impresscart_administration_catalog_pages');

function impresscart_administration_catalog_pages($pages) {
		$pages['catalog'] = array(
		array(
			'href' => "edit-tags.php?taxonomy=product_group&post_type=product",
			'title' => __('Groups')
		),
		
		array(
			'href' => "edit-tags.php?taxonomy=product_manufacture&post_type=product",
			'title' => __('Manufactures')
		),
		
		array(
			'href' => "edit-tags.php?taxonomy=product_cat&post_type=product",
			'title' => __('Categories')
		),
		
		array(
			'href' => "edit-tags.php?taxonomy=product_tag&post_type=product",
			'title' => __('Tags')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/attributes/",
			'title' => __('Attributes')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/options/",
			'title' => __('Options')
		),
		
		array(
			'href' => "edit.php?post_type=product",
			'title' => __('Products')
		), 
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/catalog/download_index",
			'title' => __('Downloads')
		),
	
	);
	return $pages;
}


add_filter('impresscart_administration_pages', 'impresscart_administration_localisation_pages');

function impresscart_administration_localisation_pages($pages) {
	
	
	$pages['localisation'] = array(
	
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/currencies_index",
			'title' => __('Currencies')
		), 
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/countries_index",
			'title' => __('Countries')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/country_zones_index",
			'title' => __('Zones')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/geos_index",
			'title' => __('Geo Zones')
		),
		
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/taxes_rate_index",
			'title' => __('Tax Rates')
		),
		
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/taxes_index",
			'title' => __('Tax  Classes')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/admin/localization/units_index",
			'title' => __('Measurement Units')
		),
		
	);
	
	return $pages;
}



add_filter('impresscart_administration_pages', 'impresscart_administration_sale_pages');

function impresscart_administration_sale_pages($pages) {
	
	
	$pages['sale'] = array(
	
		array(
			'href' => "edit.php?post_type=" . Goscom::GOSCOM_ORDER_POSTTYPE,
			'title' => __('Orders')
		), 
		
		array(
			'href' => "edit.php?post_type=return",
			'title' => __('Returns')
		),
		
		array(
			'href' => "edit.php?post_type=coupon",
			'title' => __('Coupons')
		),
		
		array(
			'href' => "edit.php?post_type=voucher",
			'title' => __('Vouchers')
		),
		
		array(
			'href' => "users.php",
			'title' => __('Customer')
		),
	
	);
		
	return $pages;
}



add_filter('impresscart_administration_pages', 'impresscart_administration_extension_pages');

function impresscart_administration_extension_pages($pages) {
	
	
	$pages['extension'] = array(
	
		array(
			'href' => "admin.php?page=shipping",
			'title' => __('Shipping Methods')
		), 
		
		array(
			'href' => "admin.php?page=payment",
			'title' => __('Payment Methods')
		),
		
		array(
			'href' => "admin.php?page=total",
			'title' => __('Total Calculation')
		),
		
	
	);
       
	
	return $pages;
}



add_filter('impresscart_administration_pages', 'impresscart_administration_report_pages');

function impresscart_administration_report_pages($pages) {
	
	
	$pages['report'] = array(
	
		array(
			'href' => "admin.php?page=catalog&fwurl=/report/sale_tax",
			'title' => __('Sale Tax')
		), 
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/report/sale_order",
			'title' => __('Sale Order')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/report/sale_coupon",
			'title' => __('Sale Coupon')
		),
		
		
			array(
			'href' => "admin.php?page=catalog&fwurl=/report/sale_shipping",
			'title' => __('Sale Shipping')
		),
		
		
			array(
			'href' => "admin.php?page=catalog&fwurl=/report/sale_return",
			'title' => __('Sale Return')
		),
	
			array(
			'href' => "admin.php?page=catalog&fwurl=/report/product_viewed",
			'title' => __('Product Views')
		),
	
	
		
			array(
			'href' => "admin.php?page=catalog&fwurl=/report/customer_order",
			'title' => __('Customer Order')
		),
	
			array(
			'href' => "admin.php?page=catalog&fwurl=/report/customer_reward",
			'title' => __('Customer Reward Points')
		),
		
		array(
			'href' => "admin.php?page=catalog&fwurl=/report/customer_credit",
			'title' => __('Customer Credit')
		),
	);
	
	return $pages;
}

/**
 * options
 */
add_filter('impresscart_product_options', 'impresscart_product_options_metabox');

function impresscart_product_options_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/options/product_options_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * attributes
 */
add_filter('impresscart_product_attributes', 'impresscart_product_attributes_metabox');

function impresscart_product_attributes_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_attributes_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * general
 */
add_filter('impresscart_product_general', 'impresscart_product_general_metabox');

function impresscart_product_general_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_general_metabox');
  impresscart_framework::getInstance()->dispatch('/admin/catalog/product_metabox_download');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * discount
 */
add_filter('impresscart_product_discount', 'impresscart_product_discount_metabox');

function impresscart_product_discount_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_discount_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * special
 */
add_filter('impresscart_product_special', 'impresscart_product_special_metabox');

function impresscart_product_special_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_special_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

/**
 * points
 */
add_filter('impresscart_product_points', 'impresscart_product_points_metabox');

function impresscart_product_points_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_reward_points_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  
  
  return $html;
}

/**
 * related
 */
  
add_filter('impresscart_product_related_products', 'impresscart_product_related_products_metabox');

function impresscart_product_related_products_metabox($field = array()) {
  $html = '';
  ob_start();
  impresscart_framework::getInstance()->dispatch('/admin/attributes/product_related_products_metabox');
  $html .= ob_get_contents();
  ob_end_clean();
  return $html;
}

class impresscart_product extends impresscart_posttype {

	var $id;
	var $model;
	var $product_custom_fields;
	var $metaboxes;

	
	private function defineProductData() {

		$productData = array(
				'id' => 'product-data-meta-box',
				'title' => __('Product data'),
				'page' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => '',
				'tabs' => array(
						__('Data') => array(
								array(
										'name' => '',
										'desc' => 'general box',
										'id'   => @$prefix . 'general',
										'type' => 'product_general',
										'std'  => 'default'
								),
						),
				
						__('Attributes') => array(
				
								array(
										'name' => '',
										'desc' => 'attributes box',
										'id'   => @$prefix . 'option',
										'type' => 'product_attributes',
										'std'  => 'default'
								),
						),
				
						//similar to attributes tab of woocommerce
						__('Options') => array(
				
								array(
										'name' => '',
										'desc' => 'options box',
										'id'   => @$prefix . 'option',
										'type' => 'product_options',
										'std'  => 'default'
								),
				
						),
				
						__('Discount') => array(
				
								array(
										'name' => '',
										'desc' => 'discount box',
										'id'   => @$prefix . 'discount',
										'type' => 'product_discount',
										'std'  => 'default'
								),
				
						),
				
						__('Special') => array(
				
								array(
										'name' => '',
										'desc' => 'special box',
										'id'   => @$prefix . 'special',
										'type' => 'product_special',
										'std'  => 'default'
								),
				
						),
				
						__('Related Products') => array(
				
								array(
										'name' => '',
										'desc' => 'related_product box',
										'id'   => @$prefix . 'related_products',
										'type' => 'product_related_products',
										'std'  => 'default'
								),
				
						),
				
						__('Reward Points') => array(
				
								array(
										'name' => '',
										'desc' => 'points box',
										'id'   => @$prefix . 'points',
										'type' => 'product_points',
										'std'  => 'default'
								),
				
						)
				
				)
				);			
		return $productData;
	}
	
	
	private function defineProductImage() {
		$productImage = array(
				'id' => 'product-data-meta-box',
				'title' => __('Images'),
				'fields' => array(
						array(
								'name' => '',
								'desc' => '',
								'id'   => @$prefix . 'product_image',
								'type' => 'product_image',
								'std'  => ''
						),
				)
				) ;
		return $productImage;
	}
	
	
	private function defineProductGroup() {
		$productGroup = array(
				'id' => 'product-data-meta-box',
				'title' => __('Group'),
				'fields' => array(
						array(
								'name' => '',
								'desc' => 'attributes box',
								'id'   => @$prefix . 'option',
								'type' => 'product_attributes',
								'std'  => 'default'
						),
				)
		) ;
		return $productImage;
	}
	
	/**
	 * Loads all product data from custom fields
	 *
	 * @param   int	$id	ID of the product to load
	 */
	function impresscart_product($id) {

		$this->metaboxes = array(
				'product_data' => $this->defineProductData(),
				'product_image' => $this->defineProductImage() 
		);
		$this->id = $id;
		$this->product_custom_fields = get_post_custom( $this->id );
		$default = array(
				'model' => '',
				'sku' => '',
				'price' => '',
				'regular_price' => '',
				'sale_price' => '',
				'regular_price' => '',
				'manage_stock' => 'yes',
				'stock' => 'yes',
				'stock_status' => 'yes',
				'total_stock' => '5',
				'weight' => '',
				'weight_class' => 'cm',
				'length' => '',
				'width' => '',
				'height' => '',
				'length_class' => '',
				'tax_status' => '',
				'tax_class' => '',
				'require_shipping' => '',
				'sku' => '',
				'upc' => '',
				'featured' => 'no',
				'downloadable' => 'no',
				'virtual' => 'no',
				'enabled' => 'yes'
		);
			
		foreach($default as $key => $value) {
			$this->$key = (isset($this->product_custom_fields[$key][0]) && $this->product_custom_fields[$key][0]!=='') ? 
							$this->product_custom_fields[$key][0] : $value;
		}
	}

	function get($key)
	{
		return $this->$key;
	}

	/**
	 * Get SKU (Stock-keeping unit) - product uniqe ID
	 *
	 * @return mixed
	 */
	function get_sku() {
		return $this->sku;
	}

	/**
	 * Get total stock
	 * This is the stock of parent and children combined
	 */
	function get_total_stock() {


	}

	/** Returns the product's children */
	function get_children() {

	}

	function get_child( $child_id ) {

	}

	/**
	 * Reduce stock level of the product
	 *
	 * @param   int		$by		Amount to reduce by
	 */
	function reduce_stock( $by = 1 ) {

	}

	/**
	 * Increase stock level of the product
	 *
	 * @param   int		$by		Amount to increase by
	 */
	function increase_stock( $by = 1 ) {

	}

	/**
	 * Checks the product type
	 *
	 * Backwards compat with downloadable/virtual
	 */
	function is_type( $type ) {

	}

	/**
	 * Checks if a product is downloadable
	 */
	function is_downloadable() {
		if ( $this->downloadable=='yes' ) return true; else return false;
	}

	/**
	 * Checks if a product is virtual (has no shipping)
	 */
	function is_virtual() {
		if ( $this->virtual=='yes' ) return true; else return false;
	}

	/**
	 * Checks if a product needs shipping
	 */
	function needs_shipping() {
		if ($this->is_virtual()) return false; else return true;
	}

	/** Returns whether or not the product has any child product */
	function has_child() {
		return sizeof($this->get_children()) ? true : false;
	}

	/** Returns whether or not the product post exists */
	function exists() {
		if ($this->exists) return true;
		return false;
	}

	/** Returns whether or not the product is taxable */
	function is_taxable() {
		if ($this->tax_status=='taxable') return true;
		return false;
	}

	/** Returns whether or not the product shipping is taxable */
	function is_shipping_taxable() {
		if ($this->tax_status=='taxable' || $this->tax_status=='shipping') return true;
		return false;
	}

	/** Get the product's post data */
	function get_post_data() {
		if (empty($this->post)) :
		$this->post = get_post( $this->id );
		endif;
		return $this->post;
	}

	/** Get the title of the post */
	function get_title() {
		$this->get_post_data();
		return apply_filters('impresscart_product_title', apply_filters('the_title', $this->post->post_title), $this);
	}


	/** Get the add to url */
	function add_to_cart_url() {

	}

	/** Returns whether or not the product is stock managed */
	function managing_stock() {
		if (get_option('impresscart_manage_stock')=='yes') :
		if (isset($this->manage_stock) && $this->manage_stock=='yes') return true;
		endif;
		return false;
	}

	/** Returns whether or not the product is in stock */
	function is_in_stock() {
		return true;
	}

	/** Returns whether or not the product can be backordered */
	function backorders_allowed() {
		if ($this->backorders=='yes' || $this->backorders=='notify') return true;
		return false;
	}

	/** Returns whether or not the product needs to notify the customer on backorder */
	function backorders_require_notification() {
		if ($this->backorders=='notify') return true;
		return false;
	}

	/**
	 * Returns number of items available for sale.
	 *
	 * @return int
	 */
	function get_stock_quantity() {
		return (int) $this->stock;
	}

	/** Returns whether or not the product has enough stock for the order */
	function has_enough_stock( $quantity ) {

		if (!$this->managing_stock()) return true;

		if ($this->backorders_allowed()) return true;

		if ($this->stock >= $quantity) :
		return true;
		endif;

		return false;

	}

	/** Returns the availability of the product */
	function get_availability() {

		$availability = "";
		$class = "";

		if (!$this->managing_stock()) :
		if ($this->is_in_stock()) :
		//$availability = __('In stock', 'woothemes'); /* Lets not bother showing stock if its not managed and is available */
		else :
		$availability = __('Out of stock', 'woothemes');
		$class = 'out-of-stock';
		endif;
		else :
		if ($this->is_in_stock()) :
		if ($this->get_total_stock() > 0) :
		$availability = __('In stock', 'woothemes');

		if ($this->backorders_allowed()) :
		if ($this->backorders_require_notification()) :
		$availability .= ' &ndash; '.$this->stock.' ';
		$availability .= __('available', 'woothemes');
		$availability .= __(' (backorders allowed)', 'woothemes');
		endif;
		else :
		$availability .= ' &ndash; '.$this->stock.' ';
		$availability .= __('available', 'woothemes');
		endif;

		else :

		if ($this->backorders_allowed()) :
		if ($this->backorders_require_notification()) :
		$availability = __('Available on backorder', 'woothemes');
		else :
		$availability = __('In stock', 'woothemes');
		endif;
		else :
		$availability = __('Out of stock', 'woothemes');
		$class = 'out-of-stock';
		endif;

		endif;
		else :
		if ($this->backorders_allowed()) :
		$availability = __('Available on backorder', 'woothemes');
		else :
		$availability = __('Out of stock', 'woothemes');
		$class = 'out-of-stock';
		endif;
		endif;
		endif;

		return array( 'availability' => $availability, 'class' => $class);
	}

	/** Returns whether or not the product is featured */
	function is_featured() {
		if ($this->featured=='yes') return true; else return false;
	}

	/** Returns whether or not the product is visible */
	function is_visible() {

		// Out of stock visibility
		if (get_option('impresscart_hide_out_of_stock_items')=='yes') :
		if (!$this->is_in_stock()) return false;
		endif;

		// visibility setting
		if ($this->visibility=='hidden') return false;
		if ($this->visibility=='visible') return true;
		if ($this->visibility=='search' && is_search()) return true;
		if ($this->visibility=='search' && !is_search()) return false;
		if ($this->visibility=='catalog' && is_search()) return false;
		if ($this->visibility=='catalog' && !is_search()) return true;
	}

	/** Returns whether or not the product is on sale */
	function is_on_sale() {
		if ( $this->has_child() ) :

		foreach ($this->get_children() as $child_id) :
		$sale_price 	= get_post_meta( $child_id, 'sale_price', true );
		$regular_price 	= get_post_meta( $child_id, 'price', true );
		if ( $sale_price > 0 && $sale_price < $regular_price ) return true;
		endforeach;

		else :

		if ( $this->sale_price && $this->sale_price==$this->price ) return true;

		endif;
		return false;
	}

	/** Returns the product's weight */
	function get_weight() {
		if ($this->weight) return $this->weight;
	}

	/** Adjust a products price dynamically */
	function adjust_price( $price ) {
		if ($price>0) :
		$this->price += $price;
		endif;
	}

	/** Returns the product's price */
	function get_price() {
		return $this->price;
	}

	/** Returns the price (excluding tax) - ignores tax_class filters since the price may *include* tax and thus needs subtracting */
	function get_price_excluding_tax() {

		$price = $this->price;

		if (get_option('impresscart_prices_include_tax')=='yes') :

		if ( $rate = $this->get_tax_base_rate() ) :

		if ( $rate>0 ) :

		$_tax = &new impresscart_tax();

		$tax_amount = $_tax->calc_tax( $price, $rate, true );

		$price = $price - $tax_amount;

		// Round
		$price = round( $price * 100 ) / 100;

		// Format
		$price = number_format($price, 2, '.', '');

		endif;

		endif;

		endif;

		return $price;
	}

	/** Returns the tax class */
	function get_tax_class() {
		return apply_filters('impresscart_product_tax_class', $this->tax_class, $this);
	}

	/** Returns the base tax rate */
	function get_tax_base_rate() {

		if ( $this->is_taxable() && get_option('impresscart_calc_taxes')=='yes') :

		$_tax = &new impresscart_tax();
		$rate = $_tax->get_shop_base_rate( $this->tax_class ); // Get tax class directly - ignore filters

		return $rate;

		endif;

	}

	/** Returns the price in html format */
	function get_price_html() {
		$price = '';
		if ($this->is_type('grouped')) :

		$min_price = '';
		$max_price = '';

		foreach ($this->get_children() as $child_id) :
		$child_price = get_post_meta( $child_id, 'price', true);
		if ($child_price<$min_price || $min_price == '') $min_price = $child_price;
		if ($child_price>$max_price || $max_price == '') $max_price = $child_price;
		endforeach;

		$price .= '<span class="from">' . __('From:', 'woothemes') . ' </span>' . impresscart_price($min_price);

		$price = apply_filters('impresscart_grouped_price_html', $price, $this);

		elseif ($this->is_type('variable')) :

		if ( !$this->min_variation_price || $this->min_variation_price !== $this->max_variation_price ) $price .= '<span class="from">' . __('From:', 'woothemes') . ' </span>';

		$price .= impresscart_price($this->get_price());

		$price = apply_filters('impresscart_variable_price_html', $price, $this);

		else :
		if ($this->price) :
		if ($this->is_on_sale() && isset($this->regular_price)) :

		$price .= '<del>'.impresscart_price( $this->regular_price ).'</del> <ins>'.impresscart_price($this->get_price()).'</ins>';

		$price = apply_filters('impresscart_sale_price_html', $price, $this);

		else :

		$price .= impresscart_price($this->get_price());

		$price = apply_filters('impresscart_price_html', $price, $this);

		endif;
		elseif ($this->price === '' ) :

		$price = apply_filters('impresscart_empty_price_html', '', $this);

		elseif ($this->price === '0' ) :

		$price = __('Free!', 'woothemes');

		$price = apply_filters('impresscart_free_price_html', $price, $this);

		endif;
		endif;

		return $price;
	}

	/** Returns the product rating in html format - ratings are stored in transient cache */
	function get_rating_html( $location = '' ) {


	}

	/** Returns the upsell product ids */
	function get_upsells() {
		return (array) maybe_unserialize( $this->upsell_ids );
	}

	/** Returns the crosssell product ids */
	function get_cross_sells() {
		return (array) maybe_unserialize( $this->crosssell_ids );
	}

	/** Returns the product categories */
	function get_categories( $sep = ', ', $before = '', $after = '' ) {
		return get_the_term_list($this->id, 'product_cat', $before, $sep, $after);
	}

	/** Returns the product tags */
	function get_tags( $sep = ', ', $before = '', $after = '' ) {
		return get_the_term_list($this->id, 'product_tag', $before, $sep, $after);
	}

	/** Get and return related products */
	function get_related( $limit = 5 ) {
		global $itmarket;

		// Related products are found from category and tag
		$tags_array = array(0);
		$cats_array = array(0);

		// Get tags
		$terms = wp_get_post_terms($this->id, 'product_tag');
		foreach ($terms as $term) $tags_array[] = $term->term_id;

		// Get categories
		$terms = wp_get_post_terms($this->id, 'product_cat');
		foreach ($terms as $term) $cats_array[] = $term->term_id;

		// Don't bother if none are set
		if ( sizeof($cats_array)==1 && sizeof($tags_array)==1 ) return array();

		// Meta query
		$meta_query = array();
		$meta_query[] = $itmarket->query->visibility_meta_query();
		$meta_query[] = $itmarket->query->stock_status_meta_query();

		// Get the posts
		$related_posts = get_posts(array(
				'orderby' 		=> 'rand',
				'posts_per_page'=> $limit,
				'post_type' 	=> 'product',
				'fields' 		=> 'ids',
				'meta_query' 	=> $meta_query,
				'tax_query' 	=> array(
						'relation' => 'OR',
						array(
								'taxonomy' 	=> 'product_cat',
								'field' 	=> 'id',
								'terms' 	=> $cats_array
						),
						array(
								'taxonomy' 	=> 'product_tag',
								'field' 	=> 'id',
								'terms' 	=> $tags_array
						)
				)
		));

		$related_posts = array_diff( $related_posts, array($this->id) );

		return $related_posts;
	}

	/** Returns product attributes */
	function get_attributes() {

		if (!is_array($this->attributes)) :

		if (isset($this->product_custom_fields['product_attributes'][0]))
			$this->attributes = maybe_unserialize( maybe_unserialize( $this->product_custom_fields['product_attributes'][0] ));
		else
			$this->attributes = array();

		endif;

		return (array) $this->attributes;
	}

	/** Returns whether or not the product has any attributes set */
	function has_attributes() {
		if (sizeof($this->get_attributes())>0) :
		foreach ($this->get_attributes() as $attribute) :
		if (isset($attribute['is_visible']) && $attribute['is_visible']) return true;
		endforeach;
		endif;
		return false;
	}

	/** Lists a table of attributes for the product page */
	function list_attributes() {
		global $itmarket;
	}

	/**
	 * Return an array of attributes used for variations, as well as their possible values
	 *
	 * @return two dimensional array of attributes and their available values
	 */
	function get_available_attribute_variations() {

	}

	/**
	 * Gets the main product image
	 */
	function get_image( $size = 'shop_thumbnail' ) {
		global $itmarket;

		if (has_post_thumbnail($this->id)) :
		echo get_the_post_thumbnail($this->id, $size);
		elseif (($parent_id = wp_get_post_parent_id( $this->id )) && has_post_thumbnail($parent_id)) :
		echo get_the_post_thumbnail($parent_id, $size);
		else :
		echo '<img src="'. IMPRESSCART_URL . '/assets/images/placeholder.png" alt="Placeholder" width="'.$itmarket->get_image_size('shop_thumbnail_image_width').'" height="'.$itmarket->get_image_size('shop_thumbnail_image_height').'" />';
		endif;
	}

	/**
	 * Checks sale data to see if the product is due to go on sale/sale has expired, and updates the main price
	 */
	function check_sale_price() {

	}

	/**
	 * Sync grouped products with the childs lowest price (so they can be sorted by price accurately)
	 **/
	function grouped_product_sync() {


	}

	function save()
	{
		//to make sure the terms IDs is integers:
		if(@$_POST['product_group']) {
			$cat_ids = array_map('intval', @$_POST['product_group']);
			$cat_ids = array_unique( $cat_ids );
			wp_set_object_terms( $this->id, $cat_ids, 'product_group' );
		}
	}
}

