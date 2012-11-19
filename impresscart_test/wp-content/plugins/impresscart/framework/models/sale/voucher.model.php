<?php
class impresscart_sale_voucher_model extends impresscart_model {
	
	function genVoucherCode()
	{
		$v_code = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,999999)),0,10);
		return $v_code;		
	}
  
  function getAllVoucherPosts() {
    global $wpdb;
    $voucher_posts = $wpdb->get_results("
      SELECT post_id
      FROM $wpdb->postmeta
      WHERE $wpdb->postmeta.meta_key LIKE 'voucher_code'
     ");
    return $voucher_posts;
  }
  
  function getVoucherPostId( $voucher_code ) {
    global $wpdb;
    $voucher_post = $wpdb->get_results("
      SELECT post_id
      FROM $wpdb->postmeta
      WHERE $wpdb->postmeta.meta_key LIKE 'voucher_code'
      AND $wpdb->postmeta.meta_value LIKE '" . $voucher_code . "'"
     );
    return $voucher_post;
  }
  
}
?>