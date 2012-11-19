<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
class impresscart_metaboxes {

  function __construct() {
    add_action('add_meta_boxes', array(&$this, 'impresscart_add_metaboxes'));
    add_action('save_post', array(&$this, 'impresscart_save_metaboxes'));
    add_filter('post_updated_messages', array(&$this, 'impresscart_admin_messages'), 1);
  }

  /**
   *
   */
  function impresscart_add_metaboxes() {

    //add_meta_box for product
    add_meta_box('itmarket-product-data', __('Product Data', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'product', 'normal', 'high', array('name' => 'product_data', 'class' => 'impresscart_product', 'tab' => true));
    add_meta_box('itmarket-product-image', __('Images', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'product', 'normal', 'high', array('name' => 'product_image', 'class' => 'impresscart_product'));

    //add_meta_box for extension
    add_meta_box('itmarket-extension-setting', __('Setting', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'extension', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_extension'));

    /*
     * metabox for orders
     */
    add_meta_box('itmarket-order-data', __('Order Data', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), Goscom::GOSCOM_ORDER_POSTTYPE, 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_order'));
    add_meta_box('itmarket-order-shipping', __('Order Shipping', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), Goscom::GOSCOM_ORDER_POSTTYPE, 'normal', 'high', array('name' => 'shipping', 'class' => 'impresscart_order'));
    add_meta_box('itmarket-order-payment', __('Order Payment', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), Goscom::GOSCOM_ORDER_POSTTYPE, 'normal', 'high', array('name' => 'payment', 'class' => 'impresscart_order'));
    add_meta_box('itmarket-order-items', __('Order Items', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), Goscom::GOSCOM_ORDER_POSTTYPE, 'normal', 'high', array('name' => 'items', 'class' => 'impresscart_order'));
    add_meta_box('itmarket-order-history', __('Order History', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), Goscom::GOSCOM_ORDER_POSTTYPE, 'normal', 'high', array('name' => 'history', 'class' => 'impresscart_order'));
    remove_meta_box('commentsdiv', Goscom::GOSCOM_ORDER_POSTTYPE, 'normal');
    remove_meta_box('commentstatusdiv', Goscom::GOSCOM_ORDER_POSTTYPE, 'normal');
    remove_meta_box('slugdiv', Goscom::GOSCOM_ORDER_POSTTYPE, 'normal');

    /*
     * metabox for return
     */
    add_meta_box('itmarket-return-data', __('Return Data', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'return', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_return'));
    add_meta_box('itmarket-return-items', __('Return Items', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'return', 'normal', 'high', array('name' => 'items', 'class' => 'impresscart_return'));
    add_meta_box('itmarket-return-history', __('Return History', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'return', 'normal', 'high', array('name' => 'history', 'class' => 'impresscart_return'));
    remove_meta_box('commentsdiv', 'return', 'normal');
    remove_meta_box('commentstatusdiv', 'return', 'normal');
    remove_meta_box('slugdiv', 'return', 'normal');

    /*
     *
     */
    add_meta_box('itmarket-country-data', __('Currency Setting', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'currency', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_currency'));
    add_meta_box('itmarket-country-data', __('Country Setting', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'country', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_country'));
    add_meta_box('itmarket-zone-data', __('Zone Setting', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'zone', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_zone'));
    add_meta_box('itmarket-geo-zone-data', __('Geo Zones', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'geo_zone', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_geo_zone'));
    add_meta_box('itmarket-tax-rate-data', __('Tax Rates', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'tax_rate', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_tax_rate'));
    add_meta_box('itmarket-tax-class-data', __('Tax Classes', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'tax_class', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_tax_class'));
    add_meta_box('itmarket-weight-class-data', __('Weight Classes', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'weight_class', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_weight_class'));
    add_meta_box('itmarket-length-class-data', __('Length Classes', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'length_class', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_length_class'));

    /**
     * metabox for coupon
     */
    add_meta_box('itmarket-coupon-data', __('Coupon Detail', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'coupon', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_coupon'));
    add_meta_box('itmarket-coupon-history', __('Coupon History', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'coupon', 'normal', 'high', array('name' => 'history', 'class' => 'impresscart_coupon'));
    remove_meta_box('commentsdiv', 'coupon', 'normal');
    remove_meta_box('commentstatusdiv', 'coupon', 'normal');
    remove_meta_box('slugdiv', 'coupon', 'normal');

    add_meta_box('itmarket-voucher-data', __('Voucher Detail', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'voucher', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_voucher'));
    add_meta_box('itmarket-voucher-history', __('Voucher History', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'voucher', 'normal', 'high', array('name' => 'history', 'class' => 'impresscart_voucher'));

    add_meta_box('itmarket-affiliate-data', __('Affiliate Details', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'im_affiliate', 'normal', 'high', array('name' => 'data', 'class' => 'impresscart_affiliate'));
    add_meta_box('itmarket-affiliate-payment', __('Payment Details', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'im_affiliate', 'normal', 'high', array('name' => 'payment', 'class' => 'impresscart_affiliate'));
    add_meta_box('itmarket-affiliate-transaction', __('Transactions', 'impressthemes'), array(&$this, 'impresscart_add_metabox'), 'im_affiliate', 'normal', 'high', array('name' => 'transaction', 'class' => 'impresscart_affiliate'));

    remove_meta_box('pageparentdiv', 'product_variation', 'side');
  }

  function impresscart_admin_messages($messages) {
    global $post_type_object;
    
    if (get_option('display_impresscart_admin_message')) { 
    	// check whether to display the message
      	$messages['post'][1] = get_option('impresscart_admin_message');
      	update_option('display_impresscart_admin_message', 0); // turn off the message
    }

    return $messages;
  }

  /**
   *
   */
  function impresscart_add_metabox($post, $metabox) {
    $class = $metabox['args']['class'];
    $obj = new $class($post->ID);
    $obj->show_metabox($metabox);
  }
  
  
  function saveProduct($post) {
  	
  		$product = new impresscart_product($post->ID);
        $product->save();
        $fw = impresscart_framework::getInstance(); 
        $fw->dispatch('/admin/options/product_options_metabox_save');
        $fw->dispatch('/admin/attributes/product_attributes_metabox_save');
        $fw->dispatch('/admin/attributes/product_general_metabox_save');
        $fw->dispatch('/admin/attributes/product_discount_metabox_save');
        $fw->dispatch('/admin/attributes/product_special_metabox_save');
        $fw->dispatch('/admin/attributes/product_reward_points_metabox_save');
        $fw->dispatch('/admin/attributes/product_related_products_metabox_save');
        $fw->dispatch('/admin/attributes/product_image_metabox_save');
        $fw->dispatch('/admin/catalog/product_metabox_download_save');
  }
  

  function impresscart_save_metaboxes() {
  	
    global $post;
    switch (@$post->post_type) {
      case 'product':
      	self::saveProduct($post);
        break;
      case 'extension':
        global $post;
        $extension = new impresscart_extension($post->ID);
        $extension->save();
        break;
      case Goscom::GOSCOM_ORDER_POSTTYPE:
        $obj = new impresscart_order($post->ID);
        $obj->save();
        break;
      case 'return':
        $obj = new impresscart_return($post->ID);
        $obj->save();
        break;
      case 'coupon':
        $obj = new impresscart_coupon($post->ID);
        $obj->save();
        break;
      case 'voucher':
        $obj = new impresscart_voucher($post->ID);
        $obj->save();
        break;
      case 'country':
        $obj = new impresscart_country($post->ID);
        $obj->save();
        break;
      case 'currency':
        $obj = new impresscart_currency($post->ID);
        $obj->save();
        break;
      case 'zone':
        $obj = new impresscart_zone($post->ID);
        $obj->save();
        break;
      case 'geo_zone':
        $obj = new impresscart_geo_zone($post->ID);
        $obj->save();
        break;
      case 'tax_rate':
        $obj = new impresscart_tax_rate($post->ID);
        $obj->save();
        break;
      case 'tax_class':
        $obj = new impresscart_tax_class($post->ID);
        $obj->save();
        break;
      case 'weight_class':
        $obj = new impress_weight_class($post->ID);
        $obj->save();
        break;
      case 'length_class':
        $obj = new impresscart_length_class($post->ID);
        $obj->save();
        break;
    }

    update_option('display_impresscart_admin_message', 1);
  }

  /**
   * drawing metabox
   * @param $metabox setting
   * @param $tab
   */
  function impresscart_draw_metabox($metabox, $tab = false) {
    global $post;
    $html = '';
    if (!$tab) {
      // Use nonce for verification
      $html .= '<div>';
      if ($metabox['fields'])
        foreach ($metabox['fields'] as $field) {
          $html .= $this->draw_field($field);
        }
      $html .= '</div>';
    } else {
      $tab_names = array();
      $tab_inner_html = '';
      foreach ($metabox['tabs'] as $tab_name => $tab) {
        $tab_name_id = str_replace(' ', '_', $tab_name);
        $tab_names[] = $tab_name;
        $tab_inner_html .= '<div id="' . $tab_name_id . '">';
        foreach ($tab as $field) {
          $tab_inner_html .= $this->draw_field($field);
        }
        $tab_inner_html .= "</div>";
      }

      $tabs_header = '<ul>';

      foreach ($tab_names as $tab) {
        $tabs_header .= '<li><a class="removetooltip" href="#' . str_replace(' ', '_', $tab) . '">' . $tab . '</a></li>';
      }

      $tabs_header .= '</ul>';

      $html .= '<div class="impresscart_tabs">' . $tabs_header . $tab_inner_html . '</div>';
    }

    echo $html;
  }

  /**
   * drawing metabox field
   * @param $field
   */
  function draw_field($field = array()) {
    
  	//var_dump($field);
  	
    global $post;
    
    $meta = get_post_meta($post->ID, $field['id'], true);
    $value = ($meta != "") ? $meta : @$field['std'];
    $html = '<div><label for="' . @$field['id'] . '">' . @$field['name'] . '</label>';
    
    $html .= apply_filters('impresscart_' . $field['type'], $field);
    
    $html .= '</div>';
    $html .= "<br/>";
    
    return $html;
  }

}

/**
 * text
 */
add_filter('impresscart_text', 'impresscart_text_metabox');

function impresscart_text_metabox($field = array()) {
  $html = '';
  $html .= '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" size="30" />' . '<br />' . $field['desc'];
  return $html;
}

/**
 * select 
 */
add_filter('impresscart_select', 'impresscart_select_metabox');

function impresscart_select_metabox($field = array()) {
  $html = '';
  $html .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
  foreach ($field['options'] as $option) {
    $selected = $value == $option['value'] ? ' selected="selected"' : '';
    $html .= '<option value="' . $option['value'] . '"' . $selected . '>' . $option['name'] . '</option>';
  }

  $html .= '</select>';
  return $html;
}

/**
 * radio
 */
add_filter('impresscart_radio', 'impresscart_radio_metabox');

function impresscart_radio_metabox($field = array()) {
  $html = '';
  foreach ($field['options'] as $option) {
    $checked = $meta == $option['value'] ? ' checked="checked"' : '';
    $html .= '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . $checked . ' >' . $option['name'] . '</input>';
  }
  return $html;
}

/**
 * checkbox
 */
add_filter('impresscart_checkbox', 'impresscart_checkbox_metabox');

function impresscart_checkbox_metabox($field = array()) {
  $html = '';
  $checked = $meta ? ' checked="checked"' : '';
  $html .= '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '"' . $checked . ' />';
  return $html;
}


/**
 * textarea
 */
add_filter('impresscart_textarea', 'impresscart_textarea_metabox');

function impresscart_textarea_metabox($field = array()) {
  $html = '';
  $html .= '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" >'.$field['std'].'</textarea>';
  return $html;
}