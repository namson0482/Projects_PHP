<?php
/*
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 

Contact: support@impressdev.com
*/
add_action('restrict_manage_posts', 'restrict_extensions_by_type');

function restrict_extensions_by_type() {
  global $typenow;
  global $wp_query;
  if ($typenow == 'extension') {
    $taxonomy = 'business';
    $type = $_REQUEST['type'];
    $args = array(
        'post_type' => 'extension',
        'meta_key' => 'type',
        'meta_value' => $type,
    );
    $wp_query->query($args);
  }
}

class impresscart_extension extends impresscart_posttype {

  public $extension;

  function impresscart_extension($id) {
    if (isset($id)) {
      $class = get_post_meta($id, 'class', true);
      $type = get_post_meta($id, 'type', true);

      //echo $class;
      if (!file_exists(ITMARKET_EXTENSION . '/' . $type . '/' . $class . '.php')) {
        $this->uninstall($id);
        return;
      }

      require_once ITMARKET_EXTENSION . '/' . $type . '/' . $class . '.php';
      $this->extension = new $class();
      $this->extension->setId($id);
    }
  }

  public function get_installed_extension($type = null) {
    if (!is_null($type)) {
      $args = array(
          'post_type' => 'extension',
          'meta_key' => 'type',
          'meta_value' => $type
      );
    } else {
      $args = array(
          'post_type' => 'extension'
      );
    }

    return get_posts($args);
  }

  public function install($type, $name) {
    $extension = array(
        'id' => '',
        'post_type' => 'extension',
        'post_title' => $name,
        'post_status' => 'publish'
    );

    $post_id = wp_insert_post($extension);

    add_post_meta($post_id, 'type', $type, true);
    add_post_meta($post_id, 'class', $name, true);
  }

  public function uninstall($id) {
    wp_delete_post($id);
  }

  function is_installed($type, $name) {
    $args = array(
        'post_type' => 'extension',
        'post_status' => array('draft', 'publish'),
        'meta_key' => 'class',
        'meta_value' => $name
    );

    $methods = get_posts($args);

    if (!count($methods))
      return false;

    foreach ($methods as $method) {
      if (get_post_meta($method->ID, 'type', true) == $type) {
        return true;
      }
    }

    return false;
  }

  function show_metabox($metabox) {
    if (isset($this->extension))
      $this->extension->draw_metabox();
  }

  function save() {
    if (!is_null($this->extension))
      $this->extension->save();
  }

  function get_meta($key) {
    return get_post_meta($this->extension->id, $this->extension->prefix . $key, true);
  }

  public function getTotal(&$total_data, &$total, &$taxes) {
    $this->extension->getTotal($total_data, $total, $taxes);
  }

}

add_filter('impresscart_post_types', 'impresscart_extension_post_type');

function impresscart_extension_post_type($posttypes) {
	return $posttypes;
  $posttypes['extension'] = array(
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => false,
      'exclude_from_search' => true,
      'supports' => array(
          'title',
          'thumbnail'
      ),
      'labels' => array(
          'name' => 'Extensions',
          'singular_name' => 'Extension',
          'edit_item' => 'Edit Extension',
          'view_item' => 'View Extension',
          'search_items' => 'Search Extensions',
          'not_found' => 'No Extension Found',
          'not_found_in_trash' => 'No Extension Found In Trash'
      )
  );

  return $posttypes;
}