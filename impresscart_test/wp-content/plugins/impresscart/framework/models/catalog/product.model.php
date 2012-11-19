<?php

class impresscart_catalog_product_model extends impresscart_model {

	const PRODUCT_OUT_OF_STOCK = 'Out Of Stock';
	const PRODUCT_PRE_ORDER = 'Pre-Order';
	const PRODUCT_2_3_DAYS = '2-3 Days';
	const PRODUCT_IN_STOCK = 'In Stock';

	var $_cached = array();
	var $_cachedPosts = array();

	/**
	 * @var impresscart_cache_service
	 * */
	protected $cache = null;

	public function __construct() {
		$this->cache = impresscart_framework::service('cache');
	}

	public function updateViewed($product_id) {
		# TODO: update product view by adding 1 in database
	}

	protected function _getGeneralAttributes($post, $key = null) {
		if(!is_object($post)) {
			$ID = $post;
			$post = new stdClass();
			$post->ID = $ID;
		}
		if (!isset($this->_cachedPosts[$post->ID]['getGeneralAttributes'])) {
			$this->_cachedPosts[$post->ID]['getGeneralAttributes'] = get_post_meta($post->ID, 'impresscart_product_general_attributes', true);
		}
		return $key ? $this->_cachedPosts[$post->ID]['getGeneralAttributes'][$key] : $this->_cachedPosts[$post->ID]['getGeneralAttributes'];
	}

	protected function _getAttributes($post) {
		if(!is_object($post)) {
			$ID = $post;
			$post = new stdClass();
			$post->ID = $ID;
		}
		if(!isset($this->_cachedPosts[$post->ID]['getAttributes'])) {
			$this->_cachedPosts[$post->ID]['getAttributes'] = (array)get_post_meta($post->ID, 'impresscart_product_attributes', true);
		}
		return $this->_cachedPosts[$post->ID]['getAttributes'];
	}

	protected function _getAvailableGroupedAttributes() {
		if (!isset($this->_cached['getAvailableGroupedAttributes'])) {
			require_once IMPRESSCART_CLASSES . '/impresscart_attribute.php';
			$this->_cached['getAvailableGroupedAttributes'] = impresscart_attribute::dbGetAllGrouped();
		}
		return $this->_cached['getAvailableGroupedAttributes'];
	}

	protected function _getOptions($post) {
		if(!is_object($post)) {
			$ID = $post;
			$post = new stdClass();
			$post->ID = $ID;
		}
		if(!isset($this->_cachedPosts[$post->ID]['getOptions'])) {
			$this->_cachedPosts[$post->ID]['getOptions'] = (array)get_post_meta($post->ID, 'impresscart_product_options', true);
		}
		return $this->_cachedPosts[$post->ID]['getOptions'];
	}

	protected function _getAvailableOptions(){
		if (!isset($this->_cached['getAvailableOptions'])) {
			require_once IMPRESSCART_CLASSES . '/impresscart_option.php';
			$this->_cached['getAvailableOptions'] = impresscart_option::dbGetAll();
		}
		return $this->_cached['getAvailableOptions'];
	}

	public function getProduct($product_id) {
		$product = new stdClass();

		# get post first
		$product->post = get_post($product_id);

		# wp get_post return null on no data
		if( null !== $product->post) {

			# product general attributes
			$attributes = $this->_getGeneralAttributes($product->post);
			# @see getGenerateAttributeClasses()
			# $key is the general attribute ID
			if(is_array($attributes)) {

				foreach( $attributes as $key => $attribute) {
					$product->$key = $attribute['value'];
				}
			}
				
			# map to opencart name
			$product->id					= @$product_id;
			$product->product_id			= @$product_id;
			$product->model 				= @$product->MODEL;
			$product->price					= @$product->PRICE;
			$product->name					= @$product->post->post_title;
			$product->length_class_id		= @$product->LENGTH_CLASS;
			$product->weight_class_id		= @$product->WEIGHT_CLASS;
			$product->tax_class_id			= @$product->TAX_CLASS;
			$product->weight				= @$product->WEIGHT;
			$product->length				= @$product->LENGTH;
			$product->width					= @$product->WIDTH;
			$product->height				= @$product->HEIGHT;
			$product->shipping				= @$product->REQUIRE_SHIPPING == '1';
			$product->image					= array();
			$product->minimum				= (int)@$product->MINIMUM_QUANTITY;
			$product->points				= 2; #TODO
			$product->quantity				= (int)@$product->QUANTITY;
			$product->minimum				= (int)@$product->MININUM_QUANTITY;
			$product->subtrack				= @$product->SUBTRACK_STOCK == 'Yes';
			$product->sku					= @$product->SKU;
			$product->upc					= @$product->UPC;
			$product->location				= @$product->LOCATION;
			$product->status				= @$product->STATUS != 'Disabled';
			$product->discount 				= 0; // TODO: update discount price
			$product->special				= 0; // TODO: update special price
			$product->stock_status			= 0; // TODO: update
			$product->rating				= 0; // TODO
			$product->sort_order			= 0; // TODO
			$product->reviews				= array(); // TODO: use wp comments maybe
			$product->availability			= @$product->OUT_OF_STOCK_STATUS;
			return $product;

		} else {
			return false;
		}
	}

	/**
	 * TODO: this function is not necessary to implement, it's based on wp get_posts
	 * */
	public function getProducts($data = array()) {
		$filer_name = $data['filter_name'];
		$args = array(
				'post_type' => 'product',
				'post_title' => ' like %'.$filer_name,
		);
		$result = array();
		$the_query = new WP_Query( $args );
		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
			
		$temp = array (
							'name' => the_title('', '', false),
							'link' => get_permalink(get_the_ID()));
		$result[count($result)] = $temp;
			
		endwhile;
		return $result;
	}

	/**
	 * TODO: later
	 * */
	public function getProductSpecials($data = array()) {

		# TODO: harded code
		return array();

		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$product_data = array();

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			return $product_data;
	}

	/*code addedd by Nganbtt*/
	public function getSpecialsByUserRole( $product_id ) {
		global $current_user;
		// get user role of current user
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		// get all specials for product
		$specials = get_post_meta($product_id, 'impresscart_product_specials', true);
		$specials = $specials ? (array)$specials : array();

		// get specials for the current user by user role
		$user_specials = array();
		if( count($specials) > 0 ){ // if there are specials
			$todays_date = date("Y-m-d");
			$today = strtotime($todays_date);
			foreach( $specials as $special ){
				// if special for current user role
				if( $special['customer'] == (string)$user_role ){
					// if special is not expired
					$expiration_date = strtotime($special['end_date']);
					if ($expiration_date > $today) {
						$user_specials[] = $special;
					}
				}
			}
		}

		return $user_specials;
	}

	public function getLatestProducts($limit) {

		# TODO: harded code
		return array();

		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getPopularProducts($limit) {

		# TODO: harded code
		return array();

		$product_data = array();

		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getBestSellerProducts($limit) {

		# TODO: harded code
		return array();

		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductAttributes($product_id) {

		$product_attribute_group_data = array();

		# $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		$productAttributes 		= $this->_getAttributes($product_id);
		$availableAttributes 	= $this->_getAvailableGroupedAttributes();


		foreach ($availableAttributes as $group) {

			if(!empty($group['attributes'])) {

				$grp = @$group['group'];

				$product_attribute_data = array();

				$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

				foreach ($group['attributes'] as $option) {
					$product_attribute_data[] = array(
						'attribute_id' => $option->ID,
						'name'         => $option->name,
						'text'         => impresscart_attribute::factory($option->class)->displayPostMetaInProductDetail($productAttributes, $option, true /* return result */)
					);
				}

				$product_attribute_group_data[] = array(
					'attribute_group_id' => @$grp->ID,
					'name'               => @$option->name,
					'attribute'          => $product_attribute_data
				);
			}
		}

		return $product_attribute_group_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		# $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		$product			= $this->getProduct($product_id);
		$options			= $this->_getAvailableOptions();
		$postmeta 			= $this->_getOptions($product_id);


		foreach ($options as $option) {

			if(empty($postmeta[$option->ID]['used'])) {
				continue; # options is not used
			}

			$required 	= @$postmeta[$option->ID]['required'];
			$type 		= $option->class;

			$product_option_value_data = array();

			#$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			$product_option_data[] = array(
				'product_option_id' => $product_id . '_' . $option->ID, # no for current database structure
				'option_id'         => $option->ID,
				'name'              => $option->name,
				'type'              => $option->class,
				'option_value'      => impresscart_option::factory($option->class)->getOptionValue($product->price, $postmeta, $option),
				'required'          => $required
			);
		}

		return $product_option_data;
	}

	public function getProductDiscounts( $product_id ){
		$product_discounts = get_post_meta($product_id, 'impresscart_product_discounts', true);
		return $product_discounts;
	}

	public function setProductDiscounts( $product_id, $product_discounts ){
		update_post_meta($product_id, 'impresscart_product_discounts', $product_discounts);
	}

	public function getDiscountsByUserRole( $product_id ) {

		global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		// get all discounts for product
		$discounts = get_post_meta($product_id, 'impresscart_product_discounts', true);
		$discounts = $discounts ? (array)$discounts : array();

		// get discounts for the current user by user role
		$user_discounts = array();
		if( count($discounts) > 0 ){ // if there are discounts
			$todays_date = date("Y-m-d");
			$today = strtotime($todays_date);
			foreach( $discounts as $discount ){
				//$firephp->log($discount, 'discount');
				$expiration_date = strtotime($discount['end_date']);
				// if discount for current user role
				// and discount is not expired
				// and discount is not exhausted
				if( $discount['customer'] == (string)$user_role && $expiration_date > $today
				&& $discount['used_times'] < $discount['quantity'] ){
					$user_discounts[] = $discount;
				}
			}
		}

		return $user_discounts;
	}


	public function getProductImages($product_id) {
		return get_post_meta($product_id, 'product_image', true);
	}

	public function getProductImage($product_id)
	{
		$thumbnail_id = (get_post_thumbnail_id($product_id));
	}

	public function getProductRelated($product_id) {
		$post =get_post($product_id);
		$related_products = get_post_meta($post->ID, 'impresscart_product_related_products', true);
		$temp = array();
		if (is_array($related_products))
		{
			foreach ($related_products as $id)
			{
				$product = get_post($id);
				$temp[] = array(
					'product_id' => $id,
					'name' => $product->post_title,
					'image' => $this->model_catalog_product->getProductImage($id),
					'url' => get_permalink($id) 
				);
			}
		}
		return $temp;
	}

	public function getProductTags($product_id) {

		return array();
		#TODO: later

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tag WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}

	public function getProductLayoutId($product_id) {

		return 0;
		#TODO: later

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_product');
		}
	}

	public function getCategories($product_id) {

		return array();
		#TODO: later

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {

		return 1000;
		#TODO: later

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		if (!empty($data['filter_tag'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', $data['filter_name']);

				foreach ($words as $word) {
					if (!empty($data['filter_description'])) {
						$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					} else {
						$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					}
				}

				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', $data['filter_tag']);

				foreach ($words as $word) {
					$implode[] = "LCASE(pt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				}

				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}

			$sql .= ")";
		}

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();

				$implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";

				$this->load->model('catalog/category');

				$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);

				foreach ($categories as $category_id) {
					$implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
				}

				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalProductSpecials() {

		return array();
		#TODO: later

		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

	function getGenerateAttributeClasses() {

		# taxes options
		$taxOptions = array();
		$lengthOptions = array();
		$weightOptions = array();
		$outofstockOptions = array();

		$taxes = impresscart_framework::table('tax_class')->fetchAll();

		foreach ($taxes as $tax) {
			$tax->ID		= $tax->tax_class_id;
			$taxOptions[] 	= (array)$tax;
		}

		# units options
		$rows = impresscart_framework::table('unit')->fetchAll(array('conditions' => array( 'type' => 'length')));
		foreach ($rows as $row)
		{
			$row->ID = $row->unit_id;
			$lengthOptions[] = (array)$row;
		}

		$rows = impresscart_framework::table('unit')->fetchAll(array('conditions' => array( 'type' => 'weight')));
		foreach ($rows as $row)
		{
			$row->ID = $row->unit_id;
			$weightOptions[] = (array)$row;
		}

		$rows = $this->config->get('stock_status_data');
		foreach($rows as $key => $value)
		{
			$row = array();
			$row['stock_status_id'] = $key + 1;
			$row['name'] = $value;
			$outofstockOptions[] = $row;
		}
		 
		return array(
		0 => array(
				'group' => new stdClass(),
				'attributes' => array(
		(object) array(
						'ID' => 'MODEL',
						'name' => 'Model',
						'class' => 'text_general',
						"description" => __('These are transactions.', 'impresscart'),
						'meta' => array(),
		),
		(object) array(
						'ID' => 'PRICE',
						'name' => 'Price',
						'class' => 'text_general',
						"description" => __('These are transactions.', 'impresscart'),
						'meta' => array(),
		),
		(object) array(
						'ID' => 'TAX_CLASS',
						'name' => 'Tax Class',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => $taxOptions
		)
		),
		(object) array(
						'ID' => 'QUANTITY',
						'name' => 'Quantity',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'MININUM_QUANTITY',
						'name' => 'Minimum Quantity',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'SUBTRACK_STOCK',
						'name' => 'Subtrack Stock',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => array(
		array('ID' => 'Yes', 'name' => 'Yes'),
		array('ID' => 'Yes', 'name' => 'No'),
		)
		)
		),
		(object) array(
						'ID' => 'OUT_OF_STOCK_STATUS',
						'name' => 'Out Of Stock Status',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => $outofstockOptions,
		)
		),
		(object) array(
						'ID' => 'REQUIRE_SHIPPING',
						'name' => 'Require Shipping',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => array(
		array('ID' => '1', 'name' => 'Yes'),
		array('ID' => '0', 'name' => 'No'),
		)
		)
		),
		(object) array(
						'ID' => 'SKU',
						'name' => 'SKU',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'UPC',
						'name' => 'UPC',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'LOCATION',
						'name' => 'Location',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'DATE_AVAILABLE',
						'name' => 'Date Available',
						'class' => 'date_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'WEIGHT',
						'name' => 'Weight',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		),
		(object) array(
						'ID' => 'WEIGHT_CLASS',
						'name' => 'Weight Class',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => $weightOptions
		)
		),
		(object) array(
						'ID' => 'LENGTH',
						'name' => 'Length',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(),
		)
		,
		(object) array(
						'ID' => 'WIDTH',
						'name' => 'Width',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.'
						)
						,
						(object) array(
						'ID' => 'HEIGHT',
						'name' => 'Height',
						'class' => 'text_general',
						"description" => 'These are countries that you are willing to shop.'
						)
						,
						(object) array(
						'ID' => 'LENGTH_CLASS',
						'name' => 'Length Class',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => $lengthOptions
						)
						),
						(object) array(
						'ID' => 'STATUS',
						'name' => 'Featured',
						'class' => 'select_general',
						"description" => 'These are countries that you are willing to shop.',
						'meta' => array(
							'options' => array(
						array('ID' => 'Enabled', 'name' => 'Enabled'),
						array('ID' => 'Disabled', 'name' => 'Disabled'),
						)
						)
						)
						)
						)
						);
	}

	function getGeneralAttributesMap() {
		return array(
			'model' 		=> 'MODEL',
			'price'			=> 'PRICE',
			'quantity'		=> 'QUANTITY',
		);
	}

	function getPrice($product_id)
	{
		$product = $this->getProduct($product_id);
		return @$product->PRICE;
	}

	function getBrand($product_id)
	{
		$term = wp_get_post_terms( $product_id, 'product_manufacture');
		return @$term[0]->name;
	}

	function getDiscountPrice($product_id)
	{
		return $this->getPrice($product_id);
	}

	function getSpecialPrice($product_id)
	{
		return $this->getPrice($product_id);
	}

	function getRewardPointsCustomerRole($product_id)  {
		if(!$this->customer->isLogged()) return 0;
		$user_role = $this->customer->getUserRole();
		$temp_reward = 0;
		if($user_role) {
			$meta = get_post_meta($product_id, 'impresscart_product_reward_points', true);
			foreach($meta['reward'] as $key => $reward) {
				$reward = (int) $reward;
				if($key == $user_role) {
					return $reward;
				}
			}
		}

	}

	function getRewardPoints($product_id) {
		$meta = get_post_meta($product_id, 'impresscart_product_reward_points', true);
		return $meta['point'];
	}

	function getUserRewardPoints($product_id) {
		$user_id = $this->customer->getId();
		$point = 0;
		if($user_id) {
			$meta = get_post_meta($product_id, 'impresscart_product_reward_points', true);
			$user_data = get_userdata($user_id);
			foreach($meta['reward'] as $key => $reward)
			{
				$reward = (int) $reward;
				if(current_user_can($key)){
					$point = max($reward, $point);
				}
			}
		}
		return $point;
	}

	function getDownloadableProducts()
	{
		return array();
	}

	public function getGeneralAttributes($post, $key = null) {
		return $this->_getGeneralAttributes($post, $key);
	}

	public function getAttributes($post) {
		return $this->_getAttributes($post);
	}

	public function getAvailableAttributes() {
		return $this->getAvailableAttributes();
	}

	public function getOptions($post) {
		return $this->_getOptions($post);
	}

	public function getAvailableOptions(){
		return $this->_getAvailableOptions();
	}

	public function getUsedOptions($post) {
		if(!isset($this->_cachedPosts[$post->ID]['getUsedOptions'])) {
			$alloptions = $this->getAvailableOptions();
			$postmeta = $this->getOptions($post);
			$used = array();
			require_once IMPRESSCART_CLASSES . '/impresscart_option.php';
			foreach($alloptions as $option){
				if(impresscart_option::factory($option->class)->isUsed($postmeta, $option)){
					$used[] = $option;
				}
			}
			$this->_cachedPosts[$post->ID]['getUsedOptions'] = $used;
		}
		return $this->_cachedPosts[$post->ID]['getUsedOptions'];
	}

	public function getRequiredOptions($post) {
		if(!isset($this->_cachedPosts[$post->ID]['getUsedOptions'])) {
			$alloptions = $this->getAvailableOptions();
			$postmeta = $this->getOptions($post);
			$used = array();
			require_once IMPRESSCART_CLASSES . '/impresscart_option.php';
			foreach($alloptions as $option){
				if(impresscart_option::factory($option->class)->isUsed($postmeta, $option)){
					$used[] = $option;
				}
			}
			$this->_cachedPosts[$post->ID]['getUsedOptions'] = $option;
		}
		return $this->_cachedPosts[$post->ID]['getUsedOptions'];
	}

	public function calculatePrice($post, $buyOptions) {
		$postmeta = $this->getOptions($post);
		require_once IMPRESSCART_CLASSES . '/impresscart_option.php';

		# base price
		$gAttributes 	= $this->getGeneralAttributes($post);
		$price 			= $gAttributes['PRICE']['value'];

		# all options
		$alloptions = $this->getAvailableOptions();
		$changeAmt = 0;
		foreach($alloptions as $option) {
			$changeAmt = impresscart_option::factory($option->class)->calculateBuyOptionPrice($price, $postmeta, $option, $buyOptions);
		}

		return $price + $changeAmt;
	}

	public function saveGeneralAttribute($product_id, $key, $value) {
		$maps 		= $this->getGeneralAttributesMap();
		$key		= @$maps[$key];
		if(empty($key)) {
			return false;
		} else {
			$data = get_post_meta($product_id, 'impresscart_product_general_attributes', true);
			$data[$key] = $value;
			update_post_meta($product_id, 'impresscart_product_general_attributes', $data );
			return true;
		}
	}

	/**
	 * Save product option
	 *
	 * @param int $product_id
	 * @param int $option_id
	 * @param string $option_code
	 * @param string $key display|pricechangeby|pricechange|weight|quantity
	 * @param mixed $value
	 */
	public function saveOption($product_id, $option_id, $option_code, $key, $value) {
		$data = get_post_meta($product_id, 'impresscart_product_options', true);
		$data[$option_id]['options'][$option_code][$key] = $value;
		update_post_meta($product_id, 'impresscart_product_options', $data );
	}

	public function getProductGroups()
	{
		$groups = get_terms( 'product_group', 'orderby=count&hide_empty=0' );
		return $groups;
	}

	public function getGroupsByProduct($product_id)
	{
		$term_list = wp_get_post_terms($product_id, 'product_group', array("fields" => "ids"));
		return count($term_list) ? $term_list : array();
	}
}
?>
