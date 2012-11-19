<div><?php echo __('Select product: '); ?> <input type="text" name="related_products" value="" size="30" /></div><br/>
<div id="product-related" class="scrollbox">
<?php
	$count = 1; 
?>
<?php foreach($postmeta as $related) : ?>
		<?php $count++; ?>
		<div class="<?php echo ($count % 2) > 0 ? 'even' : 'odd';?>" id="product-related<?php echo $related->ID;?>"><?php echo $related->post_title;?>
        	<input type="hidden" value="<?php echo $related->ID;?>" name="related_products[]"><img src="<?php echo IMPRESSCART_IMAGES?>/delete.png">
		</div>					
		<?php endforeach;?>
</div>

<script type="text/javascript">
<!--
jQuery(document).ready(function() {
	var fwurl = '/catalog/product/autocomplete';
	
	jQuery('input[name=\'related_products\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			jQuery.ajax({
				url: 'admin-ajax.php',
				data : { action : 'framework', fwurl : '/admin/catalog/product_autocomplete',  'filter_name' : encodeURIComponent(request.term), 'product_id' : '<?php echo $ID;?>' },
				dataType: 'json',
				success: function(json) {		
					response(jQuery.map(json, function(item) {
						return {
							label: item.name,
							value: item.id
						}
					}));
				}
			});		
		}, 
		select: function(event, ui) {
			jQuery('#product-related' + ui.item.value).remove();
			jQuery('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="<?php echo IMPRESSCART_IMAGES;?>/delete.png" /><input type="hidden" name="related_products[]" value="' + ui.item.value + '" /></div>');
			jQuery('#product-related div:odd').attr('class', 'odd');
			jQuery('#product-related div:even').attr('class', 'even');
					
			return false;
		}
	});
	
	jQuery('#product-related div img').live('click', function() {
		jQuery(this).parent().remove();	
		jQuery('#product-related div:odd').attr('class', 'odd');
		jQuery('#product-related div:even').attr('class', 'even');	
	});
});
//-->
</script>