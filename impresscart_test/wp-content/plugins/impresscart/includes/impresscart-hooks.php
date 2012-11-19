<?php

/* 
Copyright 2010-2011 Impress Dev LLC. This software is distributed under the GNU General Public License version 2. 
Contact: support@impressdev.com
This filter allows impress market extensions to define its own
where to load controller, models, views and services
*/

add_filter('impresscart_application_path', 'impresscart_application_path');
function impresscart_application_path ($paths) {
	$paths[] = IMPRESSCART_FRAMEWORK_APP_DIR;
	return $paths;
}


add_action('wp_logout', 'impresscart_logout');
function impresscart_logout(){
	$customer = impresscart_framework::service('customer');
	$customer->logout();
	$cart = impresscart_framework::service('cart');
	$cart->clear();

}

add_action('wp_login', 'impresscart_login');
function impresscart_login(){
	$customer = impresscart_framework::service('customer');
	if($customer->isLogged() == null) {
		//Only run first time to initialize properties of goscom and then never run  
		$customer->login(null, null, true);
		$cart = impresscart_framework::service('cart');
		$cart->clear();	
		
	}
}

/**
 * This filter allows impress market extensions can
 * add sub menu to administration page
 */
add_filter('impresscart_admin_menus', 'impresscart_admin_menus');
function impresscart_admin_menus($admin_menus) {
	$admin_url = get_admin_url();
	$admin_menus['catalog'][] = array(
        'title' => __('Products'),
        'url' => $admin_url . 'edit.php?post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Manufactures'),
        'url' => $admin_url . 'edit-tags.php?taxonomy=product_manufacture&post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Categories'),
        'url' => $admin_url . 'edit-tags.php?taxonomy=product_cat&post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Tags'),
        'url' => $admin_url . 'edit-tags.php?taxonomy=product_tag&post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Categories'),
        'url' => $admin_url . 'edit-tags.php?taxonomy=product_cat&post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Option\Attribute Group'),
        'url' => $admin_url . 'edit-tags.php?taxonomy=product_group&post_type=product'
        );

        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Attributes'),
        'url' => $admin_url . 'admin.php?page=catalog&fwurl=/admin/attributes/'
        );


        $admin_menus['catalog'][] = array(
        'title' => __('impresscart', 'Options'),
        'url' => $admin_url . 'admin.php?page=catalog&fwurl=/admin/options/'
        );

      	$admin_menus['sale'][] = array(
        'title' => __('imprescart', 'Orders'),
        'url' => $admin_url . 'edit.php?post_type=' . Goscom::GOSCOM_ORDER_POSTTYPE
        );

        $admin_menus['sale'][] = array(
        'title' => __('impresscart','Returns'),
        'url' => $admin_url . 'edit.php?post_type=return'
        );

        $admin_menus['sale'][] = array(
        'title' => __('impresscart','Coupons'),
        'url' => $admin_url . 'edit.php?post_type=coupon'
        );

        $admin_menus['sale'][] = array(
        'title' => __('impresscart','Vouchers'),
        'url' => $admin_url . 'edit.php?post_type=voucher'
        );
        
        return $admin_menus;
}

/**
 * This filter allows impress market extend its frontend pages
 */

add_filter('impresscart_front_pages', 'impresscart_front_pages');
function impresscart_front_pages()
{
	$actions = array();

	$actions['account'][] = array(
        'title' => __('Account'),
        'action' => __('account/account')        
	);

	$actions['account'][] = array(
        'title' => __('Customer Address'),
        'action' => __('account/address')        
	);

	$actions['account'][] = array(
        'title' => __('Download'),
        'action' => __('account/download')        
	);

	$actions['account'][] = array(
        'title' => __('Customer Edit'),
        'action' => __('account/edit')        
	);

	$actions['account'][] = array(
        'title' => __('Forgot Password'),
        'action' => __('account/forgotten')        
	);

	$actions['account'][] = array(
        'title' => __('Login'),
        'action' => __('account/login')        
	);

	$actions['account'][] = array(
        'title' => __('Logout'),
        'action' => __('account/logout')        
	);

	$actions['account'][] = array(
        'title' => __('Newsletter'),
        'action' => __('account/newsletter')        
	);

	$actions['account'][] = array(
        'title' => __('Customer Orders'),
        'action' => __('account/order')        
	);

	$actions['account'][] = array(
        'title' => __('Password'),
        'action' => __('account/password')        
	);

	$actions['account'][] = array(
        'title' => __('Register'),
        'action' => __('account/register')        
	);


	$actions['account'][] = array(
        'title' => __('Product Return'),
        'action' => __('account/return')        
	);

	$actions['account'][] = array(
        'title' => __('Reward'),
        'action' => __('account/reward')        
	);

	$actions['account'][] = array(
        'title' => __('Transaction'),
        'action' => __('account/transaction')        
	);

	$actions['account'][] = array(
        'title' => __('Wish List'),
        'action' => __('account/wishlist')        
	);

	$actions['checkout'][] = array(
        'title' => __('Cart'),
        'action' => __('checkout/cart')        
	);

	$actions['checkout'][] = array(
        'title' => __('Checkout'),
        'action' => __('checkout/checkout')        
	);
	return $actions;
}

add_filter('impresscart_settings', 'impresscart_default_settings');

function impresscart_default_settings($settings = array())
{
			$settings['Local'] = array(
					'Localisation' => array(
						'country' => array(
							"name" => 'Country',
							"type" => "select",
							"data" => impresscart_options::$countries,
							"description" => __('These are countries that you are willing to shop.', 'impresscart'),
		                    "default" => "222"
						),

						'region' => array(
							'name' => 'Region/State',
							'type' => 'select',
							'data' => impresscart_options::$zones,
							"description" => __('These are region/state that you are willing to shop.', 'impresscart'),
							'default' => '3563'
							),

						'language' => array(
							'name' => 'Language',
							'type' => 'select',
							"description" => __('These are language that you are willing to shop.', 'impresscart'),
							'data' => array(
								'1' => 'English'
								)
								),

						'admin_language' => array(
							'name' => 'Administration Language',
							'type' => 'select',
							"description" => __('These are administration language that you are willing to shop.', 'impresscart'),
							'data' => array(
								'1' => 'English'
								)
								),


						'currency' => array(
							'name' => 'Currency',
							'type' => 'select',
							'data' => impresscart_options::$curencies,
							"description" => __('Change the default currency. Clear your browser cache to see the change and reset your existing cookie.', 'impresscart'),
							'default' => '1'
							),

						'decimal_point' => array(
							'name' => 'Decimal Point',
							'type' => 'select',
							"description" => __('These are decimal point.', 'impresscart'),
							'data' => array(
								'.' => '.',
								',' => ','
								)
								),


						'thousand_point' => array(
							'name' => 'Thousand Point',
							'type' => 'select',
							"description" => __('These are decimal point.', 'impresscart'),
							'data' => array(
								'' => 'Select',
								'.' => '.',
								',' => ','
								)
								),

						'auto_update_currency' => array(
							'name' => 'Auto Update Currency',
							'type' => 'select',
							"description" => __('These are auto update currency.', 'impresscart'),
							'data' => array(
								'0' => 'No',
								'1' => 'Yes'
								),

							'default' => '0'
							),

						'length_class' => array(
							'name' => 'Length Class',
							'type' => 'select',
							'data' => impresscart_options::$length_class,
							"description" => __('These are length class.', 'impresscart'),
							),

						'weight_class' => array(
							'name' => 'Weight Class',
							'type' => 'select',
							'data' => impresscart_options::$weight_class,
							"description" => __('These are weight class.', 'impresscart')
							)

							)

							);
							
	$settings['Catalog Options'] = array(

					'Options' => array(

						'catalog_item_per_page' => array(
							'name' => 'Default item per page(Catalog)',
							'type' => 'text',
							"description" => __('These are default item per page(Catalog).', 'impresscart')
							),

						'admin_item_per_page' => array(
							'name' => 'Default item per page(Admin)',
							'type' => 'text',
							"description" => __('These are default item per page(Admin).', 'impresscart')
							),

						'display_price_with_tax' => array(
							'name' => 'Display price with tax',
							'type' => 'select',
							"description" => __('These are display price with tax.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'invoice_prefix' => array(
							'name' => 'Invoice Prefix',
							'type' => 'text',
							"description" => __('These are invoice prefix.', 'impresscart')
							),

						'login_display_price' => array(
							'name' => 'Login display price',
							'type' => 'select',
							"description" => __('These are login display price.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'guest_checkout' => array(
							'name' => 'Guest checkout',
							'type' => 'select',
							"description" => __('These are guest checkout.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)

								),

						'account_terms' => array(
							'name' => 'Account Terms:',
							'type' => 'select',
							"description" => __('These are account terms.', 'impresscart'),
							'data' => array(
								'none' => 'none'
								)
								),

						'checkout_terms' => array(
							'name' => 'Checkout Terms:',
							'type' => 'select',
							"description" => __('These are checkout terms.', 'impresscart'),
							'data' => array(
								'none' => 'none'
								)
								),

						'affiliate_terms' => array(
							'name' => 'Affiliate Terms:',
							'type' => 'select',
							"description" => __('These are affiliate terms.', 'impresscart'),
							'data' => array(
								'none' => 'none'
								)
								),

						'affiliate_commission' => array(
							'name' => 'Affiliate Commission (%):',
							'type' => 'select',
							"description" => __('These are affiliate commission (%).', 'impresscart'),
							'data' => array(
								'none' => 'none'
								)
								),


						'display_stock' => array(
							'name' => 'Display Stock Quantity:',
							'type' => 'select',
							"description" => __('These are display stock quantity.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),


						'show_out_of_stock' => array(
							'name' => 'Show out of stock warning:',
							'type' => 'select',
							"description" => __('These are show out of stock warning.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'show_out_of_stock' => array(
							'name' => 'Show out of stock warning:',
							'type' => 'select',
							"description" => __('These are show out of stock warning.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'out_of_stock_checkout' => array(
							'name' => 'Out of stock checkout:',
							'type' => 'select',
							"description" => __('These are out of stock checkout.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
							)
						),

						'out_of_stock_status' => array (
							'name' => 'Out of stock status:',
							'type' => 'select',
							"description" => __('These are out of stock status.', 'impresscart'),
							'data' => impresscart_options::$stock_statuses,
						),

						'order_status' => array(
							'name' => 'Order status:',
							'type' => 'select',
							'data' => impresscart_options::$order_statuses,
							"description" => __('These are order status.', 'impresscart'),
							'default' => '1'
							),

						'complete_order_status' => array(
							'name' => 'Complete Order status:',
							'type' => 'select',
							'data' => impresscart_options::$order_statuses,
							"description" => __('These are complete order status.', 'impresscart'),
							'default' => '4'
							),


						'return_status' => array(
							'name' => 'Return status:',
							'type' => 'select',
							'data' => impresscart_options::$return_statuses,
							"description" => __('These are return status.', 'impresscart'),			
							'default' => '1'
							),

						'allow_reviews' => array(
							'name' => 'Allow Reviews:',
							'type' => 'select',
							"description" => __('These are allow reviews.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'allow_downloads' => array(
							'name' => 'Allow Downloads:',
							'type' => 'select',
							"description" => __('These are allow downloads.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'allow_upload_file_types' => array(
							'name' => 'Allow upload file extensions:',
							'type' => 'textarea',
							"description" => __('These are allow upload file extensions.', 'impresscart'),
							'data' => 'jpg,png,txt'
							),

                                                'themedir' => array(
							'name' => 'Impresscart Theme Directory:',
							'type' => 'text',
							"description" => __('These are Impresscart theme directory.', 'impresscart'),
							'data' => ''
							),

						'display_weight_on_cart_page' => array(
							'name' => 'Display Weight on Cart Page:',
							'type' => 'select',
							"description" => __('These are display weight on Cart Page.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								)
								)

								);
                               
								
	$settings['Mail'] = array(
					'Mail Protocol' => array(
						'mail_method' => array(
							'name' => 'Mail sending method:',
							'type' => 'select',
							"description" => __('These are mail sending method.', 'impresscart'),
							'data' => array(
								'phpmail' => 'PHP Mail',
								'smtp' => 'SMTP'
								)
								),
						'sender_email' => array(
							'name' => 'Mail Sender',
							'type' => 'text',
							"description" => __('These are mail sender.', 'impresscart')
							)
							),

					'SMTP Settings' => array(

						'smtp_host' => array(
							'name' => 'SMTP Host',
							'type' => 'text',
							"description" => __('These are SMTP host.', 'impresscart')
							),

						'smtp_username' => array(
							'name' => 'SMTP Username',
							'type' => 'text',
							"description" => __('These are SMTP username.', 'impresscart')
							),

						'smtp_password' => array(
							'name' => 'SMTP Password',
							'type' => 'text',
							"description" => __('These are SMTP passwaord.', 'impresscart')
							),

						'smtp_port' => array(
							'name' => 'SMTP Port',
							'type' => 'text',
							"description" => __('These are SMTP port.', 'impresscart')
							)
							),

					'Others' => array(
						'new_order_alert_email' => array(
							'name' => 'New Order Alert Email:',
							'type' => 'select',
							"description" => __('These are new order alert email.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)

								),

						'new_account_alert_email' => array(
							'name' => 'New Account Alert Email:',
							'type' => 'select',
							"description" => __('These are new account alert email.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)

								),

						'additionals_alert_email' => array(
							'name' => 'New Order Alert Email:',
							"description" => __('These are new order alert email.', 'impresscart'),
							'type' => 'textarea',
							)

							)

							);

	
	$settings['Server'] = array(

					'SSL' => array(
						'enable_ssl' => array(
							'name' => 'Enable SSL',
							'type' => 'select',
							"description" => __('These are enable ssl.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								)
								),

					'SEO' => array(

						'enable_sef' => array(
							'name' => 'Enable SEF URL',
							"description" => __('These are enable sef url.', 'impresscart'),
							'type' => 'select',
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'google_analytics_code' => array(
							'name' => 'Google Analytics Code:',
							"description" => __('These are google analytics code.', 'impresscart'),
							'type' => 'textarea'
							)

							),

					'Encryption' => array(

						'encryption_key' => array(

							'name' => 'Encryption key:',
							'type' => 'text',
							"description" => __('These are encryption key.', 'impresscart'),
							)


							),

					'Error Log' => array(
						'display_errors' => array(
							'name' => 'Display Errors',
							'type' => 'select',
							"description" => __('These are display errors.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'log_errors' => array(
							'name' => 'Log Errors',
							'type' => 'select',
							"description" => __('These are log errors.', 'impresscart'),
							'data' => array(
								'1' => 'Yes',
								'0' => 'No'
								)
								),

						'error_log_filename' => array(
							'name' => 'Error log filename:',
							'type' => 'text',
							"description" => __('These are error log filename.', 'impresscart'),
							'default' => 'error.txt'
							)

							)

							);
	$settings['Statuses'] = array(
					'Order Statuses' => array(
						'Order status list' => array(
							'name' => 'Order Statuses',
							'type' => 'order_status_list',
							'data' => array(
								'1' => __('Pending'),
								'2' => __('Processing'),
								'3' => __('Shipped'),
								'4' => __('Complete'),
								'5' => __('Canceled'),
								'6' => __('Denied'),
								'7' => __('Canceled Reversal'),
								'8' => __('Failed'),
								'9' => __('Refunded'),
								'10' => __('Reversed'),
								'11' => __('Chargeback'),
								'12' => __('Expired'),
								'13' => __('Processed'),
								'14' => __('Voided'),								
							)
							),
							),
								
					'Stock Statuses' => array(
						'Stock status list' => array(
							'name' => 'Stock Statuses',
							'type' => 'stock_status_list',
							'data' => array(
								'1' => __('2 - 3 Days'),
								'2' => __('In Stock'),
								'3' => __('Out Of Stock (Default)'),
								'4' => __('Pre-Order'),															
							)
							),
							),
								
					'Return Statuses' => array(
						'Return status list' => array(
							'name' => 'Return Statuses',
							'type' => 'return_status_list',
							'data' => array(
								'1' => 'Awaiting Products (Default)',
								'2' => 'Complete',
								'3' => 'Pending',
							)
							),
							),
								
					'Return actions' => array(
						'Return action list' => array(
							'name' => 'Return actions',
							'type' => 'return_action_list',
							'data' => array(
								'1' => 'Credit Issued',
								'2' => 'Refunded',
								'3' => 'Replacement Sent',
							)
							),
							),
								
					'Return reasons' => array(
						'Return reason list' => array(
							'name' => 'Return reasons',
							'type' => 'return_reason_list',
							'data' => array(
								'1' => 'Dead On Arrival',
								'2' => 'Faulty, please supply details',
								'3' => 'Order Error',
								'4' => 'Other, please supply details',
								'5' => 'Received Wrong Item',
							)
							),
							),
								
							
							);
			
			$settings['Pages'] = array(
                                    'pages' => array(                                        
                                        'checkout/checkout' => array(
                                            'name' => 'Checkout',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are checkout.', 'impresscart')
								),
								
								'common/contact' => array(
                                            'name' => 'Contact',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are checkout.', 'impresscart')
								),
								

                                        'checkout/cart' => array(
                                            'name' => 'Shopping Cart',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are checkout page.', 'impresscart')
								),

                                'common/term' => array(
                                            'name' => 'Terms & Conditions',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are checkout page agian.', 'impresscart')
								),

                                'common/thanks' => array(
                                            'name' => 'Thanks',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are thanks.', 'impresscart')
								),

                                'account/account' => array(
                                            'name' => 'My Account Page',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are my account page.', 'impresscart')
								),


                                'account/affiliate' => array(
                                            'name' => 'Affiliate Page',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are affiliate page.', 'impresscart')
								),

                                        'account/register' => array(
                                            'name' => 'Register',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are register.', 'impresscart')
								),

                                        'account/whishlist' => array(
                                            'name' => 'Whish List',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are whish list.', 'impresscart')
								),

                                        'account/order' => array(
                                            'name' => 'Order',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are order.', 'impresscart')
								),

                                        'account/download' => array(
                                            'name' => 'Downloads',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are downloads.', 'impresscart')
								),

                                        'account/return' => array(
                                            'name' => 'Returns',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are returns.', 'impresscart')
								),


                                        'account/transaction' => array(
                                            'name' => 'Transactions',
                                            'type' => 'select',
                                            'data' => impresscart_options::$pages,
											"description" => __('These are transactions.', 'impresscart')
								),

								)
								);
	
			return $settings;
}

?>
