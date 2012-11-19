jQuery.noConflict();

jQuery(document).ready(function() {
	
	jQuery("a[rel=fancybox]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	/* loading cart */
	jQuery('#impresscart_cart').load(
		impresscart.ajaxurl,
		{ action : 'framework', fwurl : '/checkout/cart/show' }
	);
	
	jQuery('input[name=\'filter_name\']').keydown(function(e) {
		if (e.keyCode == 13) {
			url = 'index.php?route=product/search';
			var filter_name = jQuery('input[name=\'filter_name\']').attr('value')
			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}
			location = url;
		}
	});
	
	
	
	/* Ajax Cart */
	jQuery('#impresscart_cart > .heading a').live('click', function() {
		
		jQuery('#impresscart_cart').addClass('active');
		
		jQuery.ajax({
			url: impresscart.ajaxurl,
			data: { action : 'framework', fwurl : '/checkout/cart/update' },
			type: 'get',
			dataType: 'json',
			success: function(json) {
				if (json['output']) {
					jQuery('#impresscart_cart .content').html(json['output']);
				} else {
					jQuery('#impresscart_cart .content').html(json);
				}
			}
		});			
		
		jQuery('#impresscart_cart').live('mouseleave', function() {
			jQuery(this).removeClass('active');
		});
	});
	
	/* Mega Menu */
	jQuery('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if (jQuery.browser.msie && (jQuery.browser.version == 7 || jQuery.browser.version == 6)) {
			var category = jQuery(element).find('a');
			var columns = jQuery(element).find('ul').length;
			
			jQuery(element).css('width', (columns * 143) + 'px');
			jQuery(element).find('ul').css('float', 'left');
		}		
		
		var menu = jQuery('#menu').offset();
		var dropdown = jQuery(this).parent().offset();
		
		i = (dropdown.left + jQuery(this).outerWidth()) - (menu.left + jQuery('#menu').outerWidth());
		
		if (i > 0) {
			jQuery(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if (jQuery.browser.msie) {
		if (jQuery.browser.version <= 6) {
			jQuery('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			jQuery('#column-right + #content').css('margin-right', '195px');
		
			jQuery('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if (jQuery.browser.version <= 7) {
			jQuery('#menu > ul > li').bind('mouseover', function() {
				jQuery(this).addClass('active');
			});
				
			jQuery('#menu > ul > li').bind('mouseout', function() {
				jQuery(this).removeClass('active');
			});	
		}
	}
});

jQuery('.success img, .warning img, .attention img, .information img').live('click', function() {
	jQuery(this).parent().fadeOut('slow', function() {
		jQuery(this).remove();
	});
});

function addToCart(product_id) {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data: { action : 'framework', fwurl : '/checkout/cart/update', product_id : product_id },
		type: 'post',
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, .information, .error').remove();
			
			//return;
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['error']) {
				if (json['error']['warning']) {
					jQuery('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				}
			}	 
			if (json['success']) {
				jQuery('#notification').html('<div class="attention" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				jQuery('.attention').fadeIn('slow');
				
				jQuery('#cart_total').html(json['total']);
				
				jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

function removeCartItem(key) {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data: { action : 'framework', fwurl : '/checkout/cart/update', remove : key  },
		type: 'post',
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, .information').remove();
			location.reload();
			/*
			if (json['output']) {
				jQuery('#cart_total').html(json['total']);				
				jQuery('#impresscart_cart .content').html(json['output']);
				jQuery('#imc-cart-item-' + key).remove();
			}
			*/			
		}
	});
}


function updateCart() {
	jQuery('#basket').submit();
}

/*
function removeVoucher(key) {
	jQuery.ajax({
		url: 'index.php?route=checkout/cart/update',
		type: 'post',
		data: 'voucher=' + key,
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, .information').remove();
			
			if (json['output']) {
				jQuery('#cart_total').html(json['total']);
				
				jQuery('#cart .content').html(json['output']);
			}			
		}
	});
}*/

function addToWishList(product_id) {
	jQuery.ajax({		
		url: impresscart.ajaxurl,
		data: { action : 'framework', fwurl : '/account/wishlist/update', product_id : product_id  },	
		type: 'post',
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				jQuery('#notification').html('<div class="attention" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				jQuery('.attention').fadeIn('slow');
				
				jQuery('#wishlist_total').html(json['total']);
				
				jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 				
			}	
		}
	});
}

function addToCompare(product_id) { 
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data: { action : 'framework', fwurl : '/product/compare/add', product_id : product_id  },
		type: 'post',
		dataType: 'json',
		success: function(json) {
			jQuery('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				jQuery('#notification').html('<div class="attention" style="display: none;">' + json['success'] + '<img src="close.png" alt="" class="close" /></div>');
				
				jQuery('.attention').fadeIn('slow');
				
				jQuery('#compare_total').html(json['total']);
				
				jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

/*
jQuery(function() {
	jQuery("#tabs1").tabs();
});

*/




