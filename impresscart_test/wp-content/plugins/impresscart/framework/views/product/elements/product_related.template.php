<?php
	if(@$related_products)
	foreach($related_products as $product)
	{
?>
		
		<div  >
			<a href="<?php echo $product["url"];?>"><?php echo $product["name"]; ?></a>
			<br/>
			<?php if(@$product["image"]): ?>			
			<img width="<?php echo $width;?>" height="<?php echo $height;?>" alt="<?php echo $product->name;?>" src="<?php echo @$product["image"];?>">
			<br/>
			<?php endif; ?>
			<a class="button" onclick="addToCart('<?php echo $product["product_id"];?>'); return false;" class="buy"><span>Add To Cart</span></a>		
		</div>		
<?php 	
	}
?>