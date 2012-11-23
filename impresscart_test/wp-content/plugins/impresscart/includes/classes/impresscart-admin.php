<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 
Contact: support@impressdev.com
*/

define('IMPRESSCART_MAINPAGE_PHP', basename(__FILE__));
include 'impresscart_options.php';
if (!defined('IMPRESSCART_OPTIONS_NAME')) define('IMPRESSCART_OPTIONS_NAME', 'impresscart_settings');

class impresscart_admin {

	protected static $_instance = null;
	var $options_name = IMPRESSCART_OPTIONS_NAME;
	var $options_values = array();
	var $options_settings = array();

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function impresscart_admin() {
		
		$this->options_values = $this->get_options();
		$data = array();
		$data['stock_statuses'] = $this->get_option('stock_status_data');	
		$data['order_statuses'] = $this->get_option('order_status_data');
		$data['return_statuses'] = $this->get_option('return_status_data');
		$data['length_class'] = impresscart_framework::table('unit')->fetchAll(array('conditions' => array('type' => 'length')));
		
		$data['weight_class'] = impresscart_framework::table('unit')->fetchAll(array('conditions' => array('type' => 'weight')));
		
		$data['curencies'] = impresscart_framework::table('currency')->fetchAll();
		$data['zones'] = impresscart_framework::table('zone')->fetchAll(array('conditions' => array(
            'country_id' => $this->get_option('country')
		)));
		$data['countries'] = impresscart_framework::table('country')->fetchAll();

		$pages = get_pages();
		foreach ($pages as $page) {
			$stdObject = new stdClass();
			$stdObject->ID = $page->ID;
			$stdObject->name = $page->post_title;
			$data['pages'][] = $stdObject;
		}
		
		impresscart_options::set_default_data($data);
		$this->options_settings = impresscart_options::get_impresscart_settings();
		
		add_action('admin_menu', array(&$this, 'admin_menu'), 9);
		add_action('admin_init', array(&$this, 'admin_init'));
		
		add_action('admin_print_styles', array(&$this, 'admin_global_print_styles'));
		add_action('admin_print_scripts', array(&$this, 'admin_global_print_scripts'));

	}

	function admin_menu() {
		
		$pages = array();
		$pages[] = add_menu_page(__('Impress Cart Setting'), __('ImpressCart', 'impresscart'), 'manage_categories', basename(__FILE__), array(&$this, 'impresscart_settings_page'), IMPRESSCART_IMAGES . '/mini-logo.png', 25);
		$pages[] = add_submenu_page(basename(__FILE__), __('Administration', 'impresscart'), __('Administration', 'impresscart'), 'manage_options', 'catalog', array(&$this, 'catalog_page'));		
		$pages[] = add_submenu_page(basename(__FILE__), __('Payments'), __('Payments', 'impresscart'), 'manage_options', 'payment', array(&$this, 'payment_page'));
		$pages[] = add_submenu_page(basename(__FILE__), __('Shippings'), __('Shippings','impresscart'), 'manage_options', 'shipping', array(&$this, 'shipping_page'));
		$pages[] = add_submenu_page(basename(__FILE__), __('Totals'), __('Totals','impresscart'), 'manage_options', 'total', array(&$this, 'total_page'));

		foreach ($pages as $page) {
			add_action('admin_print_scripts-' . $page, array(&$this, 'admin_print_scripts'));
			add_action('admin_print_styles-' . $page, array(&$this, 'admin_print_styles'));
		}

		//post-types
		add_action('admin_print_scripts-post-new.php', array(&$this, 'admin_print_scripts'));
		add_action('admin_print_styles-post-new.php', array(&$this, 'admin_print_styles'));

		add_action('admin_print_scripts-post.php', array(&$this, 'admin_print_scripts'));
		add_action('admin_print_styles-post.php', array(&$this, 'admin_print_styles'));
		
	}

	function admin_init() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_REQUEST['page'] == basename(__FILE__)) {
			if (!empty($_REQUEST['clear-settings'])) {
				$this->reset_setting();
			} else {
				// get options value
				$this->options_values = $_REQUEST[IMPRESSCART_OPTIONS_NAME];
			}
			// check if empty, redirect failure save
			if (empty($this->options_values)) {
				wp_redirect('admin.php?page=' . IMPRESSCART_MAINPAGE_PHP . '&saved_options=false');
			}
			// save options
			if (!empty($_REQUEST['save_settings'])) {
				// files handle				
				$this->save_options();
				wp_redirect('admin.php?page=' . IMPRESSCART_MAINPAGE_PHP . '&saved_options=true');
			}
		}
	}

	function admin_global_print_scripts() {

	}

	function admin_global_print_styles() {
		wp_enqueue_style('ip-options', IMPRESSCART_CSS . '/theme-options.css', array(), "1.01");
	}

	function admin_print_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core', array('jquery'));
		wp_enqueue_script('jquery-ui-autocomplete', array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'));
		wp_enqueue_script('jquery-ui-datepicker', array('jquery-ui-core'));
		wp_enqueue_script('jquery-ui-position', array('jquery'));
		wp_enqueue_script('jquery-ui-tabs', array('jquery-ui-core', 'jquery-ui-widget'));
		wp_enqueue_script('jquery-ui-widget', array('jquery'));
		wp_register_script('atooltip', IMPRESSCART_JS . '/jquery.atooltip.js', array('jquery'));
		wp_enqueue_script('atooltip', array('jquery'));
	    wp_enqueue_script('thickbox', array('jquery'));
	    wp_register_script('ip-options', IMPRESSCART_JS . '/theme-options.js', array('jquery'), "1.07");
		wp_enqueue_script('ip-options', array('jquery'));
	    wp_register_script('ip-color', IMPRESSCART_JS . '/jscolor/jscolor.js', array('jquery'));
		wp_enqueue_script('ip-color', array('jquery'));
		wp_enqueue_script(array('editor', 'media-upload'));
		
		//Menu
		wp_register_script('hoverIntent', IMPRESSCART_JS . '/admin/hoverIntent.js', array('jquery'));
		wp_register_script('superfish', IMPRESSCART_JS . '/admin/superfish.js', array('jquery'));
	?>
     <?php	
	}

	function admin_print_styles() {
		
		wp_enqueue_style('thickbox');
		wp_enqueue_style('ip-ui', IMPRESSCART_CSS . '/ui/smoothness/jquery-ui-1.8.21.custom.css');
		wp_enqueue_style('ip-file-uploader', IMPRESSCART_JS . '/fileuploader/fileuploader.css', array(), "1.01");
		wp_enqueue_style('ip-jcrop', IMPRESSCART_JS . '/jcrop/jcrop.css', array(), "1.01");		
		wp_enqueue_style('im-admin', IMPRESSCART_CSS . '/admin/style.css');
		
		
		//This css is used for Admin -> Administrator
		wp_enqueue_style('superfish', IMPRESSCART_CSS . '/admin/superfish.css');
		//wp_enqueue_style('tooltipcss', IMPRESSCART_CSS . '/admin/atooltip.css');
		
	}

	/**
	 *
	 */
	function impresscart_settings_page() {
		echo $this->draw_options($this->options_settings, 'save settings');
	}

	/**
	 *
	 * Enter description here ...
	 */
	function catalog_page() {
		$fwurl = @$_GET['fwurl'];
		if (empty($fwurl))
		$fwurl = '/admin/catalog/';
		ob_start();
		impresscart_framework::getInstance()->dispatch($fwurl);
		$html .= ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	/**
	 * extenison page
	 */
	function extension_page() {
		$fwurl = '/admin/extension/';
		ob_start();
		impresscart_framework::getInstance()->dispatch($fwurl);
		$html .= ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	/**
	 * payment gatways settings page
	 * @return unknown_type
	 */
	function payment_page(){
		$fwurl = @$_GET['fwurl'];
		if (empty($fwurl))
		$fwurl = '/admin/payment/';

		ob_start();
		impresscart_framework::getInstance()->dispatch($fwurl);
		$html .= ob_get_contents();
		ob_end_clean();

		echo $html;
	}


	/**
	 * payment gatways settings page
	 * @return unknown_type
	 */
	function total_page(){
		$fwurl = @$_GET['fwurl'];
		if (empty($fwurl))
		$fwurl = '/admin/total/';

		ob_start();
		impresscart_framework::getInstance()->dispatch($fwurl);
		$html .= ob_get_contents();
		ob_end_clean();

		echo $html;
	}

	/**
	 * payment gatways settings page
	 * @return unknown_type
	 */
	function shipping_page(){
		$fwurl = @$_GET['fwurl'];
		if (empty($fwurl))
		$fwurl = '/admin/shipping/';

		ob_start();
		impresscart_framework::getInstance()->dispatch($fwurl);
		$html .= ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	/**
	 * Build Backend Options
	 * @param array $options
	 * @return string
	 */
	function draw_options($options, $save_button_name = 'save_settings') {

		// fix
		$fix_clear = "<div class=\"fix-clear\">&nbsp;</div>";
		
		// save button
		if ($save_button_name) {
			$save_html = "<div class=\"form-button\" style=\"margin: 15px 0;\">";
			$save_html .= "<input type=\"submit\" name=\"{$save_button_name}\" id=\"{$save_button_name}\" value=\"Save Settings\" />";
			$save_html .= "</div>";
			$save_html_fixed = "<input type=\"submit\" name=\"{$save_button_name}\" id=\"{$save_button_name}_fixed\" value=\"Save Settings\" />";
		}

		// Message Box
		$message = "";
		
		// theme options html
		$tab_names = array();
		$html = "";
		foreach ($options as $tab_label => $tab_options) {
			$tab_name = $this->convert_name($tab_label);
			$tab_names[$tab_name] = $tab_label;

			$html .= "<div class=\"option-tab\" id=\"tab-{$tab_name}\">";
			foreach ($tab_options as $group_label => $options) {
				$html .= "<h3 class=\"group_option\"><span class=\"group_label\">{$group_label}</span><a class=\"removetooltip\" href=\"#\">+</a></h3>";
				$html .= "<div class=\"group_options\">";
				foreach ($options as $name => $option) {
					$html .= $this->draw_option(@$option['type'], @$option['name'], @$option['description'], $name, array(
              'data' => isset($option['data']) ? $option['data'] : '',
              'default' => isset($option['default']) ? $option['default'] : '',
              'default_custom' => isset($option['default_custom']) ? $option['default_custom'] : '',
              'attributes' => isset($option['attributes']) ? $option['attributes'] : '',
              'input' => isset($option['input']) ? $option['input'] : '',
              'helper' => isset($option['helper']) ? $option['helper'] : '',
              'param' => isset($option['param']) ? $option['param'] : '',
              'parent' => isset($option['parent']) ? $option['parent'] : '',
					));
				}
				$html .= "</div>";
			}
			$html .= $fix_clear;
			$html .= $save_html;
			$html .= "</div>";
		}

		// theme tabs html
		
		$tabs_html = "<ul>";
		foreach ($tab_names as $tab_name => $tab_label) {
			$tabs_html .= "<li><a class=\"removetooltip\" href=\"#tab-{$tab_name}\">{$tab_label}</a></li>";
		}
		$tabs_html .= "</ul>";

		// menu
		$pages = apply_filters('impresscart_administration_pages', array());
		$temp_menu = Goscom::generateHeader($pages);
		
		$final_html = '';
		
		$final_html .= "" . $temp_menu . "<br> <h2>ImpressCart Settings</h2>" ;
		$final_html .= "<form action=\"\" method=\"post\" name=\"theme_options_form\" id=\"theme_options_form\" enctype=\"multipart/form-data\">";
		
		$final_html .= $message;
		$final_html .= "<div id=\"im_option_loading\">Loading options...</div>";
		$final_html .= "<div id=\"im_option_wrapper\">";
		$final_html .= "<div id=\"theme-options\">";
		$final_html .= $tabs_html . $html . $fix_clear;
		$final_html .= "</div>";
		$final_html .= "</div>";

		$final_html .= "</form>";
		?>
		<script>
			jQuery.noConflict();
			jQuery(function($){ 
				$('a.imcart_tooltip').aToolTip({
		    		clickIt: true,
		    		tipContent: 'Hello I am aToolTip with content from the "tipContent" param'
				});
				$("li a.removetooltip").bind('click', function() {
					$(this).parents('body').find('#aToolTip').css("display", "none");
				});
				$("h3.group_option a.removetooltip").bind('click', function() {
					$(this).parents('body').find('#aToolTip').css("display", "none");
				});		
			});(jQuery);
			
        </script>
        
		<?php
		return $final_html;
		
	}

	function convert_name($string) {
		return implode("_", explode(" ", strtolower($string)));
	}

	/**
	 * Draw option input
	 * @param string $type
	 * @param string $label
	 * @param string $name
	 * @param array $attr
	 * @param string $description
	 */
	function draw_option($type, $label, $description, $name, $extras = array()) {
		global $post;

		if ($type == "seperator") {
			$html = "<div class=\"form-field\" style=\"border-top: 1px dashed #DDD; width: 620px; height: 5px; min-height: 5px; margin: 5px 0;\">&nbsp;</div>";
			return $html;
		}

		$value = $this->get_option($name);
		$custom_value = $this->get_option($name . '_custom');


		if (!empty($extras['helper'])) {
			if (!empty($extras['param'])) {
				list($extras['data'], $extras_more['default']) = call_user_func($extras['helper'], $extras['param']);
			} else {
				list($extras['data'], $extras_more['default']) = call_user_func($extras['helper']);
			}
			if (empty($extras['default']) && !empty($extras_more['default'])) {
				$extras['default'] = $extras_more['default'];
			}
		}

		// default value
		if ($value === false && isset($extras['default'])) {
			$value = $extras['default'];
		}
		if ($custom_value === false && isset($extras['default_custom'])) {
			$custom_value = $extras['default_custom'];
		}

		// save theme default value
		if (empty($post)) {
			$this->set_option($name, $value);
		}

		// if still empty $value, get post value
		if (empty($value)) {
			if (isset($_POST[IMPRESSCART_OPTIONS_NAME][$name])) {
				$value = $_POST[IMPRESSCART_OPTIONS_NAME][$name];
			}
		}

		// get option input attribute
		$attributes = "";
		if ($type == 'color') {
			$extras['attributes']['class'] .= ' color-picker';
		}

		if (!empty($extras['attributes'])) {
			foreach ($extras['attributes'] as $attribute_key => $attributes_value) {
				$attributes .= "{$attribute_key}=\"{$attributes_value}\" ";
			}
		}
		
		$args = array();
		
		$args['type'] = $type;
		$args['description'] = $description;
		$args['attributes'] = $attributes;
		$args['value'] = $value;
		$args['custom_value'] = $custom_value;
		$args['name'] = $name;
		$args['extras'] = $extras;
		
		// draw option input
		$input = apply_filters('impresscart_option_' . $type, $args);

		// finally build output
		if ($type != 'hidden') {
			$html = "<div class=\"form-field\">";
		}
		if (!empty($label) && $type != 'child-theme' && $type != 'hidden') {
			$html .= "<label for=\"{$name}\">" . str_replace('&amp;', '&', htmlspecialchars($label)) . "</label>";
		}
		$html .= $input;
		if (!empty($description) && $type != 'child-theme' && $type != 'hidden') {
			$html .= "<a class=\"imcart_tooltip\" title=\"".$description."\"></a>";
		}
		if ($type != 'hidden') {
			$html .= "</div>";
		}

		return $html;
	}

	/**
	 * Get theme options
	 * @return array
	 */
	function get_options() {
		return get_option(IMPRESSCART_OPTIONS_NAME);
	}

	/**
	 * Save plugin options
	 */
	function save_options() {
		
		update_option(IMPRESSCART_OPTIONS_NAME, $this->options_values);
	}

	/**
	 * Get option value
	 * @param string $name
	 * @param mixed $value
	 */
	function set_option($name, $value) {
		$this->options_values[$name] = $value;
	}

	/**
	 * Get option value
	 * @param string $name
	 * @return mixed
	 */
	function get_option($name, $check_image = false) {
		 
		if (isset($this->options_values[$name])) {
			if ($check_image && $this->is_resize_field($name)) {
				return $this->resize_image($name, $this->get_option_helper($this->options_values[$name]));
			} else {
				return $this->get_option_helper($this->options_values[$name]);
			}
		} else {
			return false;
		}
	}

	function get_post_option($post_id, $name) {
		static $post_options;

		if (empty($post_options[$post_id])) {
			$post_options[$post_id] = get_post_meta($post_id, IMPRESSCART_OPTIONS_NAME, true);
		}

		return $post_options[$post_id][$name];
	}

	function get_option_helper($value) {
		if (is_array($value)) {
			foreach ($value as $key => $val) {
				$value[$key] = $this->get_option_helper($value[$key]);
			}
		} else {
			$value = stripslashes($value);
		}
		return $value;
	}

	function resize_image($setting_name, $image_file) {

		// resize images
		if ($this->is_resize_field($setting_name)) {
			if ($setting_name == 'header_image') {
				$max_w = (int) ip_site_width();
				$max_h = (int) ip_option('header_height');
				$crop = true;
			} elseif ($setting_name == 'menu_bg_img') {
				$max_w = (int) ip_site_width();
				$max_h = (int) ip_size(ip_option('menu_height')) + ip_size(ip_option('menu_item_vertical_margin'));
				$crop = true;
			} elseif ($setting_name == 'container_bg_img') {
				$max_w = (int) ip_site_width();
				$max_h = 32000;
				$crop = false;
			}

			if ($max_w && $max_h) {
				@mkdir(THEME_CROP_PATH);

				// convert url to path
				$site_url = trim(get_option('siteurl'), "/\\");
				$file_path = WP_CONTENT_DIR . str_replace($site_url . "/wp-content", "", $image_file);

				// resize
				$result = @image_resize($file_path, $max_w, $max_h, $crop, null, THEME_CROP_PATH, 100);

				// return value
				if ($result instanceof WP_Error || !$result) {
					return $image_file;
				} else {
					// convert path to url
					$result = $site_url . "/wp-content/" . str_replace(WP_CONTENT_DIR, "", $result);
					return $result;
				}
			}
		}

		return $image_file;
	}

	function reset_setting() {
		// empty options values
		$this->options_values = array();
		// reset to default
		foreach ($this->options_settings as $tab_label => $tab_options) {
			foreach ($tab_options as $group_label => $options) {
				foreach ($options as $name => $option) {
					$this->options_values[$name] = $option['default'];
				}
			}
		}
	}
}

/* checkbox */
add_filter('impresscart_option_check', 'impresscart_option_check_html');

function impresscart_option_checkbox_html($args)
{
	
	$input = "";
	if (empty($extras['data'])) {
		$input .= "<input type=\"hidden\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" value=\"N\" />";
		$input .= "<input type=\"checkbox\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" value=\"Y\" " . ($args['value'] == "Y" ? "checked=\"checked\"" : "") . " />";
	} else {
		foreach ((array) $extras['data'] as $check_key => $check_value) {
			$input .= "<input type=\"hidden\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}][{$check_key}]") . "\" value=\"N\" />";
			$input .= "<input type=\"checkbox\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}][{$check_key}]") . "\" id=\"{$args['name']}_{$check_key}\" value=\"Y\" " . ($args['value'][$check_key] == "Y" ? "checked=\"checked\"" : "") . " style=\"float: left;\" /><label for=\"{$args['name']}_{$check_key}\" style=\"float: left; width: auto; margin-right: 10px;\">&nbsp;{$check_value}</label>";
		}
	}	
	
	return $input;
}

/* text */
add_filter('impresscart_option_text', 'impresscart_option_text_html');
function impresscart_option_text_html($args){
	$input = "<input type=\"text\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" value=\"{$args['value']}\" {$args['attributes']} />";
	return $input;
}

/* hidden */
add_filter('impresscart_option_hidden', 'impresscart_option_hidden_html' );
function impresscart_option_hidden_html($args)
{
	$input = "<input type=\"hidden\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" value=\"{$args['value']}\" />";	
}

/* multi-text */
add_filter('impresscart_option_multitext', 'impresscart_option_multitext_html' );
function impresscart_option_multitext_html($args)
{
	$input = "<input type=\"text\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" value=\"{$args['value']}\" {$args['attributes']} />";
	return $input;	
}

/* select */
add_filter('impresscart_option_select', 'impresscart_option_select_html' );
function impresscart_option_select_html($args)
{
	$input = "<div class=\"styled-select\"><select class=\"add_selectmenu\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" {$args['attributes']} >";
	foreach ((array) $args['extras']['data'] as $option_key => $option_value) {
		$input .= "<option value='{$option_key}' " . (($option_key == $args['value'] || $option_key == htmlspecialchars_decode($args['value'])) ? "selected=\"selected\"" : "") . " >{$option_value}</option>";
	}
	$input .= "</select></div>";
	return $input;
}

/* select custom */
add_filter('impresscart_option_select_custom', 'impresscart_option_select_custom_html' );
function impresscart_option_select_custom_html($args)
{
	
	$input .= "<select  name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" {$args['attributes']} >";
	foreach ((array) $args['extras']['data'] as $option_key => $option_value) {
		$input .= "<option value='{$option_key}' " . (($option_key == $value || $option_key == htmlspecialchars_decode($value)) ? "selected=\"selected\"" : "") . " >{$option_value}</option>";
	}
	$input .= "</select>";
	$input .= " or your custom value <input type=\"text\" name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}_custom]") . "\" id=\"{$args['name']}_custom\" value=\"{$args['custom_value']}\" /> <span class=\"note-text\">(if custom value is empty, theme will use selected value)</span>";
	return $input;
}


/* radio */
add_filter('impresscart_option_radio', 'impresscart_option_radio_html' );
function impresscart_option_radio_html($args)
{
	return "";
}


/* textarea */
add_filter('impresscart_option_textarea', 'impresscart_option_textarea_html' );
function impresscart_option_textarea_html($args)
{
	$input = "<textarea name=\"" . (IMPRESSCART_OPTIONS_NAME . "[{$args['name']}]") . "\" id=\"{$args['name']}\" {$args['attributes']} >{$args['value']}</textarea>";
	return $input;
}


/* order_status_list */
add_filter('impresscart_option_order_status_list', 'impresscart_option_order_status_list_html' );
function impresscart_option_order_status_list_html($args)
{
	$params = serialize($args['extras']['data']);
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/localization/order_status_index/' . $params . '/');
	$input .= ob_get_contents();
	ob_end_clean();
	return $input;
}


/* stock_status_list */
add_filter('impresscart_option_stock_status_list', 'impresscart_option_stock_status_list_html' );
function impresscart_option_stock_status_list_html($args)
{
	$params = serialize($args['extras']['data']);
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/localization/stock_status_index/' . $params . '/');
	$input .= ob_get_contents();
	ob_end_clean();
	return $input;	
}

/* return_status_list */
add_filter('impresscart_option_return_status_list', 'impresscart_option_return_status_list_html' );
function impresscart_option_return_status_list_html($args)
{
	$params = serialize($args['extras']['data']);
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/localization/return_status_index/' . $params . '/');
	$input .= ob_get_contents();
	ob_end_clean();
	return $input;	
}

/* return_action_list */
add_filter('impresscart_option_return_action_list', 'impresscart_option_return_action_list_html' );
function impresscart_option_return_action_list_html($args)
{
	$params = serialize($args['extras']['data']);
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/localization/return_action_index/' . $params . '/');
	$input .= ob_get_contents();
	ob_end_clean();
	return $input;
}

/* return_reason_list */
add_filter('impresscart_option_return_reason_list', 'impresscart_option_return_reason_list_html' );
function impresscart_option_return_reason_list_html($args)
{
	$params = serialize($args['extras']['data']);
	ob_start();
	impresscart_framework::getInstance()->dispatch('/admin/localization/return_reason_index/' . $params . '/');
	$input .= ob_get_contents();
	ob_end_clean();
	return $input;
}

