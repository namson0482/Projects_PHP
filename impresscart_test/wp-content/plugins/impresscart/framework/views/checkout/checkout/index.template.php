<div class="imc">
  <div class="checkout">
    <div id="checkout">
      <div class="checkout-heading"><?php echo $text_checkout_option; ?></div>
      <div class="checkout-content"></div>
    </div>
    <?php if (!$logged) { ?>
    <div id="payment-address">
      <div class="checkout-heading"><span><?php echo $text_checkout_account; ?></span></div>
      <div class="checkout-content"></div>
    </div>
    <?php } else { ?>
    <div id="payment-address">
      <div class="checkout-heading"><span><?php echo $text_checkout_payment_address; ?></span></div>
      <div class="checkout-content"></div>
    </div>
    <?php } ?>
    <?php if ($shipping_required) { ?>
    <div id="shipping-address">
      <div class="checkout-heading"><?php echo $text_checkout_shipping_address; ?></div>
      <div class="checkout-content"></div>
    </div>
    <div id="shipping-method">
      <div class="checkout-heading"><?php echo $text_checkout_shipping_method; ?></div>
      <div class="checkout-content"></div>
    </div>
    <?php } ?>
    <div id="payment-method">
      <div class="checkout-heading"><?php echo $text_checkout_payment_method; ?></div>
      <div class="checkout-content"></div>
    </div>
    <div id="confirm">
      <div class="checkout-heading"><?php echo $text_checkout_confirm; ?></div>
      <div class="checkout-content"></div>
    </div>
  </div>
</div>
<script type="text/javascript">

<!--
var jQuery = jQuery.noConflict();

jQuery('#checkout .checkout-content input[name=\'account\']').live('change', function() {
	//alert('==> Radio ==> Register New Customer || Guest ==> Checkout');
	if (jQuery(this).attr('value') == 'register') {
		jQuery('#payment-address .checkout-heading span').html('<?php echo $text_checkout_account; ?>');
	} else {
		jQuery('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
	}
});

jQuery('.checkout-heading a').live('click', function() {
	jQuery('.checkout-content').slideUp('slow');
	jQuery(this).parent().parent().find('.checkout-content').slideDown('slow');
	
});


<?php if (!$logged) {?> 

// Run this statement if customer is not login
jQuery(document).ready(function() {
	var data = {
		action : 'framework', 
		fwurl : '/checkout/login/index'				
	};
	
	jQuery.getJSON(impresscart.ajaxurl, data, function(json) {
		if (json['output']) {
			jQuery('#checkout .checkout-content').html(json['output']);				
			jQuery('#checkout .checkout-content').slideDown('slow');
		}
		
	});

	//jQuery.get(impresscart.ajaxurl, data, function(json) 
	
});		
<?php } else { ?>

//Begin: Run this statement if customer is login
jQuery(document).ready(function() {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data : { action : 'framework', fwurl : '/checkout/address/payment' },
		type: 'get',
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['output']) {
				jQuery('#payment-address .checkout-content').html(json['output']);				
				jQuery('#payment-address .checkout-content').slideDown('slow');
			}
		}
	});	
});
<?php } ?>
// Checkout
jQuery('#button-account').live('click', function() {

	//Run if user select register new customer after click on button ==> Continue
	//Run if user select guest that is checked out
	
	var data = {
		action: 'framework',
		fwurl:  '/checkout/' + jQuery('input[name=\'account\']:checked').attr('value')
	};
		
	jQuery.ajax({
		url: impresscart.ajaxurl,
		data: data,
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-account').attr('disabled', true);
			jQuery('#button-account').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES;?>/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			jQuery('#button-account').attr('disabled', false);
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.warning').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['error']) {
				jQuery('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<a id="button-logout" class="button" href="<?php echo wp_logout_url();?>"><span>Log Out</span></a>' + '</div>');
				jQuery('.warning').fadeIn('slow');
			} else {
				if (json['output']) {
					
					jQuery('#payment-address .checkout-content').html(json['output']);

					jQuery('#checkout .checkout-content').slideUp('slow');
					
					jQuery('#payment-address .checkout-content').slideDown('slow');
					
					jQuery('.checkout-heading a').remove();
					
					jQuery('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
				}
			}
			
		}
	});
});

// Login
jQuery('#button-login').live('click', function() {
	doLogin();
});


function doLogin() {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#checkout #login :input'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-login').attr('disabled', true);
			jQuery('#button-login').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES;?>loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-login').attr('disabled', false);
			jQuery('.wait').remove();
		},				
		success: function(json) {
			jQuery('.warning').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
						
			if (json['error']) {
				if (json['error']['type'] == 0) {
					jQuery('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
				} else {
					jQuery('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<a id="button-logout" class="button" href="<?php echo wp_logout_url();?>"><span>Log Out</span></a>' + '</div>');
				}
				
				jQuery('.warning').fadeIn('slow');
			} else {	
				//alert('checkout/address/payment + Line : 171');							
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data: { action : 'framework' , fwurl: '/checkout/address/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}						
						if (json['output']) {
							jQuery('#payment-address .checkout-content').html(json['output']);
							
							jQuery('#checkout .checkout-content').slideUp('slow');
							
							jQuery('#payment-address .checkout-content').slideDown('slow');
							
							jQuery('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
							
							jQuery('.checkout-heading a').remove();
						}
					}
				});	
			}
		}
	});	
	
}

/////////////////////////////////////////////
//////////////// Register /////////////////// 
/////////////////////////////////////////////
jQuery('#button-register').live('click', function() {

	//alert('-->Register');
	
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address select, #payment-address input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-register').attr('disabled', true);
			jQuery('#button-register').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-register').attr('disabled', false); 
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.warning').remove();
			jQuery('.error').remove();
						
			if (json['redirect']) {
				location = json['redirect'];
			}
						
			if (json['error']) {
				if (json['error']['warning']) {
					jQuery('#payment-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
					
					jQuery('.warning').fadeIn('slow');
				}
				
				if (json['error']['firstname']) {
					jQuery('#payment-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					jQuery('#payment-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					jQuery('#payment-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					jQuery('#payment-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					jQuery('#payment-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					jQuery('#payment-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					jQuery('#payment-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					jQuery('#payment-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					jQuery('#payment-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['password']) {
					jQuery('#payment-address input[name=\'password\'] + br').after('<span class="error">' + json['error']['password'] + '</span>');
				}	
				
				if (json['error']['confirm']) {
					jQuery('#payment-address input[name=\'confirm\'] + br').after('<span class="error">' + json['error']['confirm'] + '</span>');
				}																																	
			} else {
				<?php if ($shipping_required) { ?>				
				var shipping_address = jQuery('#payment-address input[name=\'shipping_address\']:checked').attr('value');
				if (shipping_address) {
					var data = {
						action: 'framework',
						fwurl: '/checkout/shipping'
					};
					jQuery.ajax({
						url: impresscart.ajaxurl,
						data: data,
						dataType: 'json',
						success: function(json) {
							if (json['redirect']) {
								location = json['redirect'];
							}
														
							if (json['output']) {
								jQuery('#shipping-method .checkout-content').html(json['output']);
								
								jQuery('#payment-address .checkout-content').slideUp('slow');
								
								jQuery('#shipping-method .checkout-content').slideDown('slow');
								
								jQuery('#checkout .checkout-heading a').remove();
								jQuery('#payment-address .checkout-heading a').remove();
								jQuery('#shipping-address .checkout-heading a').remove();
								jQuery('#shipping-method .checkout-heading a').remove();
								jQuery('#payment-method .checkout-heading a').remove();											
								
								jQuery('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');									
								jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
								
								var data = { action: 'framework', fwurl : '/checkout/address/shipping' };
								jQuery.ajax({
									url: impresscart.ajaxurl,
									data : data,
									dataType: 'json',
									success: function(json) {
										if (json['redirect']) {
											location = json['redirect'];
										}										
										
										if (json['output']) {
											jQuery('#shipping-address .checkout-content').html(json['output']);
										}
									}
								});	
							}
						}
					});	
				} else {
					var data = { action : 'framework', fwurl:'/checkout/address/shipping' };
					jQuery.ajax({
						url: impresscart.ajaxurl,
						data : data,
						dataType: 'json',
						success: function(json) {
							if (json['redirect']) {
								location = json['redirect'];
							}
										
							if (json['output']) {
								jQuery('#shipping-address .checkout-content').html(json['output']);
								
								jQuery('#payment-address .checkout-content').slideUp('slow');
								
								jQuery('#shipping-address .checkout-content').slideDown('slow');
								
								jQuery('#checkout .checkout-heading a').remove();
								jQuery('#payment-address .checkout-heading a').remove();
								jQuery('#shipping-address .checkout-heading a').remove();
								jQuery('#shipping-method .checkout-heading a').remove();
								jQuery('#payment-method .checkout-heading a').remove();							

								jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
							}
						}
					});			
				}
				<?php } else { ?>
				//alert('/checkout/payment + Line 357');
				jQuery.ajax({					
					url: impresscart.ajaxurl,					
					data : { action : 'framework', fwurl:'/checkout/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}	
											
						if (json['output']) {
							jQuery('#payment-method .checkout-content').html(json['output']);
							
							jQuery('#payment-address .checkout-content').slideUp('slow');
							
							jQuery('#payment-method .checkout-content').slideDown('slow');
							
							jQuery('#checkout .checkout-heading a').remove();
							jQuery('#payment-address .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();								
							
							jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						}
					}
				});					
				<?php } ?>
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl:'/checkout/address/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							jQuery('#payment-address .checkout-content').html(json['output']);
							
							jQuery('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
						}
					}
				});
			}	 
		}
	});	
});

function showValues() {
    var fields = jQuery(":input").serializeArray();
    var results = '';
    jQuery.each(fields, function(i, field){
  	  results += field.value + " @ ";
    });
    //alert(results);
  }

//Payment Address	
jQuery('#payment-address #button-address').live('click', function() {
	
	//Kiem  tra dieu kien neu chon new address thi goi address va add new address.
	
	//var temp = jQuery('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address select, #payment-address input[type=\'hidden\']'); 
	
	//var paymentaddress = jQuery('input[name=\'payment_address\']:checked').attr('value');
	
	//alert(paymentaddress);
	//return ;
	//payment_address=existing&address_id=1&firstname=&lastname=&company=&address_1=&address_2=&city=
	//&postcode=&country_id=4201&zone_id=&action=framework&fwurl=%2Fcheckout%2Faddress%2Fpayment
	
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data : jQuery('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address select, #payment-address input[type=\'hidden\']'),			
		dataType: 'json',
		beforeSend: function() {
			jQuery('#payment-address #button-address').attr('disabled', true);
			jQuery('#payment-address #button-address').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('#payment-address #button-address').attr('disabled', false);
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.error').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['firstname']) {
					jQuery('#payment-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					jQuery('#payment-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['telephone']) {
					jQuery('#payment-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					jQuery('#payment-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					jQuery('#payment-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					jQuery('#payment-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					jQuery('#payment-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					jQuery('#payment-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
			} else {
				<?php if ($shipping_required) { ?>
				
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl:'/checkout/address/shipping' },
					dataType: 'json',
					success: function(json) {
						//alert(json);
						if (json['redirect']) {
							location = json['redirect'];
						}
						if (json['output']) {
							jQuery('#shipping-address .checkout-content').html(json['output']);						
							jQuery('#payment-address .checkout-content').slideUp('slow');
							jQuery('#shipping-address .checkout-content').slideDown('slow');
							jQuery('#payment-address .checkout-heading a').remove();
							jQuery('#shipping-address .checkout-heading a').remove();
							jQuery('#shipping-method .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
							jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						}
					}
				});
				<?php } else { ?>
				//alert('not shipping_required');
				//alert('/checkout/payment + Line 505' );
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl:'/checkout/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}	
											
						if (json['output']) {
							jQuery('#payment-method .checkout-content').html(json['output']);
							jQuery('#payment-address .checkout-content').slideUp('slow');
							jQuery('#payment-method .checkout-content').slideDown('slow');
							jQuery('#payment-address .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
							jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						}
					}
				});	
				<?php } ?>
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl:'/checkout/address/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							jQuery('#payment-address .checkout-content').html(json['output']);
							
							jQuery('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
						}
					}
				});
			}	  
		}

		
	});	
});

// Shipping Address			
jQuery('#shipping-address #button-address').live('click', function() {

	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#shipping-address input[type=\'text\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select, #shipping-address input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#shipping-address #button-address').attr('disabled', true);
			jQuery('#shipping-address #button-address').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#shipping-address #button-address').attr('disabled', false);
			jQuery('.wait').remove();
		},			
		success: function(json) {
			
			
			jQuery('.error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				
				if (json['error']['firstname']) {
					jQuery('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					jQuery('#shipping-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					jQuery('#shipping-address input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					jQuery('#shipping-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					jQuery('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					jQuery('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					jQuery('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					jQuery('#shipping-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					jQuery('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl : '/checkout/shipping' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							jQuery('#shipping-method .checkout-content').html(json['output']);
							
							jQuery('#shipping-address .checkout-content').slideUp('slow');
							
							jQuery('#shipping-method .checkout-content').slideDown('slow');
							
							jQuery('#shipping-address .checkout-heading a').remove();
							jQuery('#shipping-method .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
							
							jQuery('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');							
						}
						
						jQuery.ajax({ 	
							url: impresscart.ajaxurl, 
							data : { action : 'framework', fwurl:'/checkout/address/shipping' },
							dataType: 'json',
							success: function(json) { 
								if (json['redirect']) { 
							 		location = json['redirect']; 
							 	}	
											
							 	if (json['output']) { 
							 		jQuery('#shipping-address .checkout-content').html(json['output']); 
							 	} 
							 } 
					 	});
					 	
					}
				});	
						
										
			}  
		}
	});	
});

// Guest
jQuery('#button-guest').live('click', function() {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#payment-address input[type=\'text\'], #payment-address input[type=\'checkbox\']:checked, #payment-address select, #payment-address input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-guest').attr('disabled', true);
			jQuery('#button-guest').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-guest').attr('disabled', false); 
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.error').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['firstname']) {
					jQuery('#payment-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					jQuery('#payment-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					jQuery('#payment-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					jQuery('#payment-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					jQuery('#payment-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					jQuery('#payment-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					jQuery('#payment-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					jQuery('#payment-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					jQuery('#payment-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				<?php if ($shipping_required) { ?>	
				var shipping_address = jQuery('#payment-address input[name=\'shipping_address\']:checked').attr('value');
				
				if (shipping_address) {
					jQuery.ajax({
						url: impresscart.ajaxurl,
						data : { action : 'framework', fwurl: '/checkout/shipping' },
						dataType: 'json',
						success: function(json) {
							if (json['redirect']) {
								location = json['redirect'];
							}
										
							if (json['output']) {
								jQuery('#shipping-method .checkout-content').html(json['output']);
								
								jQuery('#payment-address .checkout-content').slideUp('slow');
								
								jQuery('#shipping-method .checkout-content').slideDown('slow');
								
								jQuery('#payment-address .checkout-heading a').remove();
								jQuery('#shipping-address .checkout-heading a').remove();
								jQuery('#shipping-method .checkout-heading a').remove();
								jQuery('#payment-method .checkout-heading a').remove();		
																
								jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
								jQuery('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');									
							}
							
							jQuery.ajax({
								url: impresscart.ajaxurl,
								data : { action : 'framework', fwurl:  '/checkout/guestshipping'},
								dataType: 'json',
								success: function(json) {
									if (json['redirect']) {
										location = json['redirect'];
									}
												
									if (json['output']) {
										jQuery('#shipping-address .checkout-content').html(json['output']);
									}
								}
							});
						}
					});					
				} else {
					jQuery.ajax({
						url: impresscart.ajaxurl,
						data : { action : 'framework', fwurl:  '/checkout/guestshipping'},
						dataType: 'json',
						success: function(json) {
							if (json['redirect']) {
								location = json['redirect'];
							}	
													
							if (json['output']) {
								jQuery('#shipping-address .checkout-content').html(json['output']);
								
								jQuery('#payment-address .checkout-content').slideUp('slow');
								
								jQuery('#shipping-address .checkout-content').slideDown('slow');
								
								jQuery('#payment-address .checkout-heading a').remove();
								jQuery('#shipping-address .checkout-heading a').remove();
								jQuery('#shipping-method .checkout-heading a').remove();
								jQuery('#payment-method .checkout-heading a').remove();
								
								jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
							}
						}
					});
				}
				<?php } else { ?>				
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl : '/checkout/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}		
										
						if (json['output']) {
							jQuery('#payment-method .checkout-content').html(json['output']);
							
							jQuery('#payment-address .checkout-content').slideUp('slow');
								
							jQuery('#payment-method .checkout-content').slideDown('slow');
								
							jQuery('#payment-address .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
															
							jQuery('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
						}
					}
				});				
				<?php } ?>
			}	 
		}
	});	
});

// Guest Shipping
jQuery('#button-guest-shipping').live('click', function() {
	jQuery.ajax({
		url: impresscart.ajaxurl ,
		type: 'post',
		data: jQuery('#shipping-address input[type=\'text\'], #shipping-address select, #shipping-address input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-guest-shipping').attr('disabled', true);
			jQuery('#button-guest-shipping').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-guest-shipping').attr('disabled', false); 
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['firstname']) {
					jQuery('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					jQuery('#shipping-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
										
				if (json['error']['address_1']) {
					jQuery('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					jQuery('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					jQuery('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					jQuery('#shipping-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					jQuery('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl:'/checkout/shipping' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							jQuery('#shipping-method .checkout-content').html(json['output']);
							
							jQuery('#shipping-address .checkout-content').slideUp('slow');
							
							jQuery('#shipping-method .checkout-content').slideDown('slow');
							
							jQuery('#shipping-address .checkout-heading a').remove();
							jQuery('#shipping-method .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
								
							jQuery('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
						}
					}
				});				
			}	 
		}
	});	
});

jQuery('#button-shipping').live('click', function() {
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#shipping-method input[type=\'radio\']:checked, #shipping-method textarea, #shipping-method input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-shipping').attr('disabled', true);
			jQuery('#button-shipping').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-shipping').attr('disabled', false);
			jQuery('.wait').remove();
		},			
		success: function(json) {

			jQuery('.warning').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			if (json['error']) {
				if (json['error']['warning']) {
					jQuery('#shipping-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
					
					jQuery('.warning').fadeIn('slow');
				}			
			} else {
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl : '/checkout/payment' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
												
						if (json['output']) {
							jQuery('#payment-method .checkout-content').html(json['output']);
							
							jQuery('#shipping-method .checkout-content').slideUp('slow');
							
							jQuery('#payment-method .checkout-content').slideDown('slow');

							jQuery('#shipping-method .checkout-heading a').remove();
							jQuery('#payment-method .checkout-heading a').remove();
							
							jQuery('#shipping-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError);
					}
				});					
			}
		}
	});	
});

jQuery('#button-payment').live('click', function() {

	//alert('button-payment');
	
	jQuery.ajax({
		url: impresscart.ajaxurl,
		type: 'post',
		data: jQuery('#payment-method input[type=\'radio\']:checked, #payment-method input[type=\'checkbox\']:checked, #payment-method textarea, #payment-method input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			jQuery('#button-payment').attr('disabled', true);
			jQuery('#button-payment').after('<span class="wait">&nbsp;<img src="<?php echo IMPRESSCART_IMAGES; ?>/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			jQuery('#button-payment').attr('disabled', false);
			jQuery('.wait').remove();
		},			
		success: function(json) {
			jQuery('.warning').remove();
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['warning']) {
					jQuery('#payment-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
					
					jQuery('.warning').fadeIn('slow');
				}			
			} else {
				jQuery.ajax({
					url: impresscart.ajaxurl,
					data : { action : 'framework', fwurl :  '/checkout/confirm' },
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}	
					
						if (json['output']) {
							jQuery('#confirm .checkout-content').html(json['output']);
							
							jQuery('#payment-method .checkout-content').slideUp('slow');
							
							jQuery('#confirm .checkout-content').slideDown('slow');
							
							jQuery('#payment-method .checkout-heading a').remove();
							
							jQuery('#payment-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						//alert(thrownError);
					}
				});					
			}
		}
	});	
});
//--></script>