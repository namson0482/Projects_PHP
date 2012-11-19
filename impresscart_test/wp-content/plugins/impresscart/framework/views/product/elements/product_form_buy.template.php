<script>
    var k = jQuery.noConflict();
    k(function() {
        k( "#tabs1" ).tabs();
    });
</script>
<script>
    var t = jQuery.noConflict();
    t(document).ready(function(){
        t(".fancybox img").click(function(){
            var parent=t(this).attr('src');
        });
    });


</script>
<div id="notification"></div>

<form id="impresscart_form" method="post" action="?pagename=randomize&shoppage=impresscart_cart">
    <div class="left">
        <div style="margin: 5px;"><a rel="fancybox" class="fancybox" title="" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($ID) ); ?>"><?php the_post_thumbnail('300');?></a></div>
        <div class="additional_images">
            <?php if($images) foreach($images as $src) {?>
                    <a rel="fancybox" class="fancybox" title="<?php ?>" href="<?php echo $src;?>" >			
                        <img alt="" title="" width="<?php echo $thumb_width ? $thumb_width : '80';?>" height="<?php echo $thumb_height ? '64' : $thumb_height;?>" src="<?php echo $src;?>" />
                    </a>
                    <?php }?>
        </div>
    </div>

    <div class="right">
        <div><span class="name"><?php echo __('Brand: ');?></span><?php echo $brand;?></div>
        <div><span class="name"><?php echo __('Model: ');?></span><?php echo $model;?></div>
        <div><span class="name"><?php echo __('Reward Points: ');?></span><?php echo $point;?></div>
        <div><span class="available"><?php echo __(' ');?></span><span class="available_info"><?php echo $availability;?></span></div>
        <hr>
        <div class="price"><span class="price"><?php echo __('Price: '); ?></span><?php echo $main_price?></div>
        <?php if(@$tax): ?>
        <div class="tax"><span><?php echo __('Ex Tax: '); ?></span><?php echo $tax; ?></div>
        <?php endif;?>
        <div class="reward"><span><?php echo __('Price in Reward points');?>: </span><?php echo $reward_points; ?></div>
        <div><?php 
                // if there are any discounts, print them 
                if( count($discounts) > 0 ){
                    echo __('Discount(s) for ' . $discounts[0]['customer'] . ' : '); 
                    // if there are more than one discount, print them in seperate lines.
                    if( count($discounts) > 1 ){
                        foreach( $discounts as $discount ){
                            echo '</br>';
                            echo impresscart_framework::service('currency')->format($discount['price']);
                            echo ' <i>start from: ' . $discount['start_date'] . ' to ' . $discount['end_date'] . '</i>';
                        }
                    } else {
                        foreach( $discounts as $discount ){
                            echo impresscart_framework::service('currency')->format($discount['price']);
                            echo '</br><i> start from: ' . $discount['start_date'] . ' to ' . $discount['end_date'] . '</i>';
                        }   
                    }
                }
        ?></div>
        <div><?php 
                // if there are any specials, print them 
                if( count($specials) > 0 ){
                    echo __('Special(s) for ' . $specials[0]['customer'] . ' : '); 
                    // if there are more than one special, print them in seperate lines.
                    if( count($specials) > 1 ){
                        foreach( $specials as $special ){
                            echo '</br>';
                            echo impresscart_framework::service('currency')->format($special['price']);
                            echo ' <i>start from: ' . $special['start_date'] . ' to ' . $special['end_date'] . '</i>';
                        }
                    } else {
                        foreach( $specials as $special ){
                            echo impresscart_framework::service('currency')->format($special['price']);
                            echo '</br><i> start from: ' . $special['start_date'] . ' to ' . $special['end_date'] . '</i>';
                        }   
                    }
                }
        ?></div>
        
        <?php if($options) : ?>
            <div>
                <div>
                    <h3>Available Options:</h3><br/>
                    <?php foreach($options as $option) : ?>
                        <div>
                            <?php echo $option->name?>:
                        <?php impresscart_option::factory($option->class)->displayAtBuyForm($price, $product_options, $option);?></div><br/>
                        <?php endforeach;?>
                </div>
                <div>
                    <span class="name">Qty: </span><input class="qty" name="quantity" value="1" size="3" id="quantity"/>
                    <br/><a id="button-cart" class="button">
                        <span>Add to Cart</span>
                    </a>
                </div>
            </div>
            <?php else:?>
            <div class="qty">
                <span class="name">Qty: </span><input class="qty" name="quantity" size="3" value="1" id="quantity" />
                <br/>
                <a id="button-cart" class="button">
                    <span>Add to Cart</span>
                </a>
            </div>
            <div class="wc">
                <a href="#wishlist" class="wishlist" onclick="addToWishList('<?php echo $ID; ?>');"><span><?php echo __('Add to wishlist')?></span></a>
                <a href="#compare" class="compare" onclick="addToCompare('<?php echo $ID; ?>');"><span><?php echo __('Add to compare')?></span></a>
            </div>		
            <?php endif;?>
    </div>
	
    <input type="hidden" name="do" value="add" />
    <input type="hidden" name="product_id" value="<?php echo $ID; ?>" />
    <input type="hidden" name="action" value="framework" />
    <input type="hidden" name="fwurl" value="/checkout/cart/update" />
</form>