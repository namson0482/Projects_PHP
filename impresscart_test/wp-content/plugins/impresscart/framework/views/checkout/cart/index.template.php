<div id="impresscart">
<?php if ($weight) { ?>
        &nbsp;(<?php echo $weight; ?>)
        <?php } ?>

<?php if ($attention) { ?>
    <div class="attention"><?php echo $attention; ?></div>
    <?php } ?>    
<?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
<?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
<div class="success" id="coupon_success" ><?php echo _e('Coupon applied'); ?></div>

<form action="#" method="post" enctype="multipart/form-data" id="basket">
    <div class="cart-info">
        <input type="hidden" name="pagename" value="shop" />
        <input type="hidden" name="route" value="checkout/cart/update" />
        <div class="cart-info-top">        	
        	<div class="left"><h1><?php _e('Items in Your Cart'); ?></h1></div>
        	<div class="right">
        		<a href="<?php echo get_bloginfo('url');?>" class="button"><span>
        		<?php echo __('Continue Shopping'); ?></span></a>
        	</div>
		</div>
        
        
        <?php
            if(isset($products)) foreach ($products as $product) { ?>
                <?php 
                	//$tempProduct = explode(':', $product["key"]); 
                	//$product_id = $tempProduct[0];
                   	$product_id = $product["key"];
                    $img = the_post_thumbnail();
                    $img2 = get_post_thumbnail_id($product_id);
                    $post_thumbnail_img = wp_get_attachment_image_src($img2, 'thumbnail');
                ?>

                <div id="imc-cart-item-<?php echo $product_id;?>" class="imc-cart-item">
                    <div class="imc-cart-item-left">
                        <a href="<?php echo $product['href']; ?>"><img width="166px" height="166px" src="<?php echo $post_thumbnail_img[0]; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                    </div>
                    <div class="imc-cart-item-right">
                        <div class="imc-cart-right-top">
                            <div class="product_name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                            </div>
                            <div class="price"><span class="price"><?php echo $product['price']; ?></span>&nbsp; <input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" /></div>
                            <div class="item-total">
                                <span class="price_total"><?php echo $product['total']; ?></span>
                            </div>
                        </div>
                        <div class="imc-cart-right-bottom">
                            <div class="left">
                                <?php if (!$product['stock']) { ?>
                                    <span class="stock">In Stock</span>
                                    <?php } ?>
                                <span class="model"><?php echo $product['model']; ?></span>
                                <span class="date"></span>
                                <?php if ($product['points_to_buy']) { ?>
                                    <span class="reward"><?php echo $product['points_to_buy']; ?></span>
                                    <?php } ?>
                                    
                                <div>
                                	<?php foreach ($product['option'] as $option){                                		
                                		echo '<span class="option">' . $option['name'] . ':</span><span> ' . $option['value'] . '</span><br/>';
                                	}?>
                                </div>

                            </div>
                            <div class="right"><a href="#" onclick="removeCartItem('<?php echo $product_id; ?>');">Remove</a> | <a href="#" onclick="updateCart();" >Save</a></div>
                        </div>
                    </div>
                </div>
                <?php } ?>

    </div>    
</form>

<div class="imc-content" style="margin-top:3em">
	
    <div class="imc-cart-left">
        	<div><p><?php echo __('Enter shipping address to estimate your shopping cost'); ?></p></div>
        	<div class="imc-content-error"></div>        
        	<div class="col">
	        	<div class="col1" >
	        		<?php echo __('Ship To:');?>	        		
	        	</div>
	        	<div class="col2"><input type="text" name="shipto" value="<?php echo __('Postal Code');?>"></div>	            
	            <div class="col3" >
	            	<a class="button" onclick="calculateShipping();">
						<span><?php echo _e('Calculate'); ?></span>
					</a>
				</div>
			</div>
            <div class="col">
            	<div class="col1"><?php echo __('Coupon Code:');?></div>
	            <div class="col2" >	            	
	            	<input type="text" name="coupon" value="">
	            </div>	            
	            <div class="col3" ><a class="button" onclick="applyCoupon();"><span><?php echo _e('Apply'); ?></span></a>
				</div>
			</div>
			<div class="col">
				<div class="col1"><?php echo _e('Gift Voucher:'); ?></div>
	            <div class="col2">	            	
	            	<input type="text" name="voucher" value="">
	            </div>	            
	            <div class="col3" ><a class="button" onclick="applyVoucher();"><span><?php echo _e('Apply'); ?></span></a></div>
	        </div>
	        <div class="col">
				<div class="col1"><?php echo _e('Reward Points'); echo ' avaiable (' .$reward_points_avaliable . '): '?></div>
	            <div class="col2">	            	
	            	<input type="text" name="rewardpoints" value="">
	            </div>	            
	            <div class="col3" ><a class="button" onclick="applyRewardPoints();"><span><?php echo _e('Apply'); ?></span></a></div>
	        </div>      
    </div>
    
    <div class="imc-cart-right">
	    <div class="cart-total">
	      <table>
	        <?php if(isset($totals)) foreach ($totals as $total) { ?>
	        <tr>
	          <td colspan="5"></td>
	          <td class="right"><b><?php echo $total['title']; ?>:</b></td>
	          <td class="right"><?php echo $total['text']; ?></td>
	        </tr>
	        <?php } ?>
	      </table>
	    </div>
	    <div><a href="<?php echo $checkout; ?>" class="button"><span><?php echo $button_checkout; ?></span></a></div>
    </div>
</div>

<div class="cart-module" style="margin: 16px auto">
	<?php if($coupon_enable == true) { ?>
    <div class="content additional-discount" id="coupon" style="display:none">
        <form id="coupon-form" enctype="multipart/form-data" method="post" action="#">
            Enter your coupon here:&nbsp;
            <input type="text" value="" name="coupon">
            <!--        <input type="hidden" value="coupon" name="next">-->
            &nbsp;
            <!--          <a onclick="jQuery('#coupon-form').submit();" class="button"><span><?php //echo $button_coupon; ?></span></a>-->
            <a onclick="applyCoupon(); return false;" class="button"><span><?php echo $button_coupon; ?></span></a>
            <input type="hidden" name="action" value="framework" />
            <input type="hidden" name="fwurl" value="/checkout/cart/applycoupon" />
        </form>
    </div>
    <?php } if($voucher_enable == true) {   ?>
    <div class="content additional-discount" id="voucher" style="display:none">
        <form id="voucher-form" enctype="multipart/form-data" method="post" action="#">
            Enter your gift voucher code here:&nbsp;
            <input type="text" value="" name="voucher">
            <!--        <input type="hidden" value="voucher" name="next">-->
            &nbsp;
            <a onclick="applyVoucher(); return false;" class="button"><span><?php echo $button_voucher; ?></span></a>
        </form>
    </div>
    <?php } ?>
</div>

</div>

<script type="text/javascript"><!--

    jQuery('.cart-module .cart-heading').bind('click', function() {
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).addClass('active');
        }
        jQuery(this).parent().find('.cart-content').slideToggle('slow');
    });


    jQuery("input[name$='next-dis']").change(function() {
        var test = jQuery(this).val();
        jQuery("div.additional-discount").hide();
        jQuery("#"+test).show();
    }); 

    jQuery('#coupon_success').hide();

    function applyCoupon() {
        var coupon_value = jQuery("input[name$='coupon']").val();
        jQuery.ajax({
            url: impresscart.ajaxurl,
            data: { action : 'framework', fwurl : '/checkout/cart/applycoupon', coupon_code : coupon_value },
            type: 'post',
            dataType: 'json',
            success: function(json) {
                if (json['success']) {
                    jQuery('#coupon_success').show();
                    jQuery('#basket').submit();
                }
                if( json['fail'] ){
                	jQuery('.imc-content-error').html(json['fail']);
                }
            }
        });
    } 

    function applyVoucher() {
        var voucher_value = jQuery("input[name$='voucher']").val();
        jQuery.ajax({
            url: impresscart.ajaxurl,
            data: { action : 'framework', fwurl : '/checkout/cart/applyvoucher', voucher_code : voucher_value },
            type: 'post',
            dataType: 'json',
            success: function(json) {   

                if (json['success']) {
                    jQuery('#coupon_success').html('Voucher applied.');
                    jQuery('#coupon_success').show();
                    jQuery('#basket').submit();
                }
                
                if( json['fail'] ){
                	jQuery('.imc-content-error').html(json['fail']);
                }
            }
        });
    }

    function applyRewardPoints() {
        var reward_value = jQuery("input[name$='rewardpoints']").val();
        jQuery.ajax({
            url: impresscart.ajaxurl,
            data: { action : 'framework', fwurl : '/checkout/cart/applyrewardpoints', reward_points : reward_value },
            type: 'post',
            dataType: 'json',
            success: function(json) {   
                if (json['success']) {
                    jQuery('#coupon_success').html('Reward applied.');
                    jQuery('#coupon_success').show();
                    jQuery('#basket').submit();
                }
                
                if( json['fail'] ){
                	jQuery('.imc-content-error').html(json['fail']);
                }
            }
        });
    }

	function calculateShipping() {
		
	}
    
    //--></script>