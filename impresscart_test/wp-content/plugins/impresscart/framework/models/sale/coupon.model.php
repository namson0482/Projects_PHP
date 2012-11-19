<?php
class impresscart_sale_coupon_model extends impresscart_model {
	
	function genCouponCode()
	{
		$v_code = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,999999)),0,10);
		return $v_code;		
	}
  
  function getAllCouponPosts() {
    global $wpdb;
    $coupon_posts = $wpdb->get_results("
      SELECT post_id
      FROM $wpdb->postmeta
      WHERE $wpdb->postmeta.meta_key LIKE 'coupon_code'
     ");
    return $coupon_posts;
  }
  
  /*
  function isInCategory( $product_id, $category_id ) {
    global $wpdb;
    $query = 
      "SELECT *
      FROM $wpdb->term_relationships
      WHERE $wpdb->term_relationships.object_id =" . $product_id .
      " AND $wpdb->term_relationships.term_taxonomy_id =" . $category_id;
   // var_dump($query);
    $belong_check = $wpdb->get_results($query);
    if( count($belong_check) > 0 ){
      return true;
    } else {
      return false;
    }
  }
  */
  
    
  function getCouponPostId( $coupon_code ) {
    global $wpdb;
    $coupon_post = $wpdb->get_results("
      SELECT post_id
      FROM $wpdb->postmeta
      WHERE $wpdb->postmeta.meta_key LIKE 'coupon_code'
      AND $wpdb->postmeta.meta_value LIKE '" . $coupon_code . "'"
     );
    return $coupon_post;
  }
  
}
?>