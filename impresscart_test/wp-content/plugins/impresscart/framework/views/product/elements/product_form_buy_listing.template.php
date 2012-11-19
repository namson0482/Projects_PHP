<div class="wrap_cate_left" style="position:relative;overflow:hidden; float:right;">
	<div style="margin: 0px;" class="cate_left"><?php the_post_thumbnail('thumbnail');?></div>
		<div style="margin: 0px;" class="cate_right">
		<div>Price : <?php echo $main_price?></div>
		<br/>
		<?php if(count($product_options)) {?>
		<div>
			<a href="<?php echo get_permalink($ID);?>" id="button-cart" class="button">
				<span>Add to Cart</span>
			</a>
		</div>
		<?php } else { ?>
		<div>
			<a onclick="addToCart('<?php echo $ID;?>')" id="button-cart" class="button"><span><?php echo __('Add to Cart');?></span></a>
		</div>
		<?php } ?>
		<br/>
		<div class="wc">
			<a href="#wishlist" class="wishlist" onclick="addToWishList('<?php echo $ID; ?>');"><span><?php echo __('Add to wishlist')?></span></a>
			<a href="#compare" class="compare" onclick="addToCompare('<?php echo $ID; ?>');"><span><?php echo __('Add to compare')?></span></a>
		</div>	
	</div>
</div>