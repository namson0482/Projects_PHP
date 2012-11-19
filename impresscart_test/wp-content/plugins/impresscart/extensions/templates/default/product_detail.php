<div class="product_detail">
<div class="form_buy">
[impresscart action="/product/elements/product_form_buy"]
</div>

<div id="tabs1">
	<ul>
		<li><a href="#description"><?php echo __('Description', 'impressthemes');?></a></li>
		<li><a href="#specification"><?php echo __('Specification', 'impressthemes');?></a></li>
		<li><a href="#related"><?php echo __('Related Products', 'impressthemes'); ?></a></li>
	</ul>
	<div id="description">
		<?php echo $content; ?>
	</div>
	<div id="specification">
		[impresscart action="/product/elements/product_attributes"]
	</div>
	<div id="related">
		[impresscart action="/product/elements/product_related"]		
	</div>
</div>


</div>	
	<script type="text/javascript">jQuery('#button-cart').bind('click', function(){ 
	var quantity = jQuery("#impresscart_form input:text[name=\'quantity\']").val(); 
	if(quantity < 1) {
		alert("The quality must be greater than zero !");
		return;
	} 
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data: jQuery('#impresscart_form input:text[name=\'quantity\'],#impresscart_form input[type=\'text\'], #impresscart_form input[type=\'hidden\'], #impresscart_form input[type=\'radio\']:checked, #impresscart_form input[type=\'checkbox\']:checked, #impresscart_form select, #impresscart_form textarea'),
		type: 'post',
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, information, .error').remove();
			if (json['error']) {
				if (json['error']['warning']) {
					jQuery('.warning').fadeIn('slow');
				}
				for (i in json['error']) {
					jQuery('#option-' + i).after('<span class="error">' + json['error'][i] + '</span>');
				}
			}
			if (json['success']) {
				jQuery('.success').fadeIn('slow');
				jQuery('#cart_total').html(json['total']);
				jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
});</script>