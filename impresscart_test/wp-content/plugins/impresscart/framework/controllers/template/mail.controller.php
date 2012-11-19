<?php 
class impresscart_template_mail_controller extends impresscart_framework_controller {
	 
	public function order()
        {
                        
                $order_id = (int)$this->session->data['order_id'];
                $order_info = $this->model_checkout_order->getOrder($order_id);
                $comment = $order_info['comment'];
                $notify = $order_infor['notify'];
                if ($comment && $notify) {
                        $this->data['comment'] = nl2br($comment);
                } else {
                        $this->data['comment'] = '';
                }

                if ($order_info['shipping_address_format']) {
                        $format = $order_info['shipping_address_format'];
                } else {
                        $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }

                $find = array(
                        '{firstname}',
                        '{lastname}',
                        '{company}',
                        '{address_1}',
                        '{address_2}',
                        '{city}',
                        '{postcode}',
                        '{zone}',
                        '{zone_code}',
                        '{country}'
                );

                $replace = array(
                        'firstname' => $order_info['shipping_firstname'],
                        'lastname'  => $order_info['shipping_lastname'],
                        'company'   => $order_info['shipping_company'],
                        'address_1' => $order_info['shipping_address_1'],
                        'address_2' => $order_info['shipping_address_2'],
                        'city'      => $order_info['shipping_city'],
                        'postcode'  => $order_info['shipping_postcode'],
                        'zone'      => $order_info['shipping_zone'],
                        'zone_code' => $order_info['shipping_zone_code'],
                        'country'   => $order_info['shipping_country']  
                );

                $this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                if ($order_info['payment_address_format']) {
                        $format = $order_info['payment_address_format'];
                } else {
                        $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }

                $find = array(
                        '{firstname}',
                        '{lastname}',
                        '{company}',
                        '{address_1}',
                        '{address_2}',
                        '{city}',
                        '{postcode}',
                        '{zone}',
                        '{zone_code}',
                        '{country}'
                );

                $replace = array(
                        'firstname' => $order_info['payment_firstname'],
                        'lastname'  => $order_info['payment_lastname'],
                        'company'   => $order_info['payment_company'],
                        'address_1' => $order_info['payment_address_1'],
                        'address_2' => $order_info['payment_address_2'],
                        'city'      => $order_info['payment_city'],
                        'postcode'  => $order_info['payment_postcode'],
                        'zone'      => $order_info['payment_zone'],
                        'zone_code' => $order_info['payment_zone_code'],
                        'country'   => $order_info['payment_country']  
                );
                
                $this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
            
            
                $this->data['text_greeting'] = sprintf(__('Thank you for your interest in %s products. Your order has been received and will be processed once payment has been confirmed.'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                $this->data['text_link'] = __('To view your order click on the link below:');
                $this->data['text_download'] = __('Once your payment has been confirmed you can click on the link below to access your downloadable products:');
                $this->data['text_order_detail'] = __('Order Details');
                $this->data['text_instruction'] = __('Instructions');
                $this->data['text_order_id'] = __('Order ID:');
                $this->data['text_date_added'] = __('Date Added');
                $this->data['text_payment_method'] = __('Payment Method:');	
                $this->data['text_shipping_method'] = __('Shipping Method');
                $this->data['text_email'] = __('Email');
                $this->data['text_telephone'] = __('Telephone');
                $this->data['text_ip'] = __('IP');
                $this->data['text_payment_address'] = __('Payment Address');
                $this->data['text_shipping_address'] = __('Shipping Address');
                $this->data['text_product'] = __('Product:');
                $this->data['text_model'] = __('Model');
                $this->data['text_quantity'] = __('Quantity');
                $this->data['text_price'] = __('Price');
                $this->data['text_total'] = __('Total');
                $this->data['text_footer'] = __('Please reply to this email if you have any questions.');
                $this->data['text_powered'] = __('Powered By <a href="http://www.impressthemes.com">ImpressCart</a>.');                
                
               
                $this->data['order_id'] = $order_id;
                $this->data['date_added'] = date(__('y-m-d'), strtotime($order_info['date_added']));    	
                $this->data['payment_method'] = $order_info['payment_method'];
                $this->data['shipping_method'] = $order_info['shipping_method'];
                $this->data['email'] = $order_info['email'];
                $this->data['telephone'] = $order_info['telephone'];
                $this->data['ip'] = $order_info['ip'];
                $this->data['products'] = get_post_meta($order_id, 'products', true);
                $this->data['totals'] = get_post_meta($order_id,'totals', true);
        }
        
        function voucher()
        {
            $this->data['title'] = sprintf(__('text_subject'), $voucher['from_name']);

            $this->data['text_greeting'] = sprintf(__('text_greeting'), $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']));
            $this->data['text_from'] = sprintf(__('text_from'), $voucher['from_name']);
            $this->data['text_message'] = __('text_message');
            $this->data['text_redeem'] = sprintf(__('text_redeem'), $voucher['code']);
            $this->data['text_footer'] = __('text_footer');

//            if (file_exists(DIR_IMAGE . $voucher['image'])) {
//                    $this->data['image'] = 'cid:' . md5(basename($voucher['image']));
//            } else {
//                    $this->data['image'] = '';
//            }

            $this->data['store_name'] = get_bloginfo('name');
            $this->data['store_url'] = get_bloginfo('url');
            $this->data['message'] = nl2br($voucher['message']);

        }
}
?>