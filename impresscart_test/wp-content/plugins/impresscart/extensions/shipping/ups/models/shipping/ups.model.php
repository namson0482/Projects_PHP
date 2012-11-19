<?php

class impresscart_shipping_ups_model extends impresscart_model {    
  function update_setting( $data = array())
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(!is_array($impresscart_shipping_methods)) $impresscart_shipping_methods =array();
  		
  		$impresscart_shipping_methods['impresscart']['shipping_method']['ups'] = $data['ups'];
		update_option('impresscart_shipping_methods', $impresscart_shipping_methods); 
  }
  
  function get_setting()
  {
  		$impresscart_shipping_methods = get_option('impresscart_shipping_methods', true);
  		if(is_array($impresscart_shipping_methods))
  		return @$impresscart_shipping_methods['impresscart']['shipping_method']['ups'];
  }
  
function getQuote($address) {
				
		$setting = $this->get_setting();
	
		$table = impresscart_framework::table('zone_to_geo_zone');
	  	$rows = $table->fetchAll( array(
  			'conditions' => array(
	  			'geo_zone_id' => $setting['ups_geo_zone_id'],
	  			'country_id' => $address['country_id'],
	  			'or' => array(
	  				'zone_id' => $address['zone_id'],
	  				'zone_id=0'
  			)
  			)
  		));
	
	
		
		
		if (!$setting['ups_geo_zone_id']) {
			$status = true;
		} elseif (count($rows)) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
				
		if ($status) {
			$weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('weight_class_id'), $setting['ups_weight_class_id']);
			$weight_code = strtoupper($this->weight->getUnit($setting['ups_weight_class_id']));
	
			if ($weight_code == 'KG') {
				$weight_code = 'KGS';
			} elseif ($weight_code == 'LB') {
				$weight_code = 'LBS';
			}
			
			$weight = ($weight < 0.1 ? 0.1 : $weight);
			
			$length = $this->length->convert($setting['ups_length'], $this->config->get('length_class_id'), $setting['ups_length_class_id']);
			$width = $this->length->convert($setting['ups_width'], $this->config->get('length_class_id'), $setting['ups_length_class_id']);
			$height = $this->length->convert($setting['ups_height'], $this->config->get('length_class_id'), $setting['ups_length_class_id']);

			$length_code = strtoupper($this->length->getUnit($setting['ups_length_class_id']));
						
			$service_code = array(
				// US Origin
				'US' => array(
					'01' => __('text_us_origin_01'),
					'02' => __('text_us_origin_02'),
					'03' => __('text_us_origin_03'),
					'07' => __('text_us_origin_07'),
					'08' => __('text_us_origin_08'),
					'11' => __('text_us_origin_11'),
					'12' => __('text_us_origin_12'),
					'13' => __('text_us_origin_13'),
					'14' => __('text_us_origin_14'),
					'54' => __('text_us_origin_54'),
					'59' => __('text_us_origin_59'),
					'65' => __('text_us_origin_65')
				),
				// Canada Origin
				'CA' => array(
					'01' => __('text_ca_origin_01'),
					'02' => __('text_ca_origin_02'),
					'07' => __('text_ca_origin_07'),
					'08' => __('text_ca_origin_08'),
					'11' => __('text_ca_origin_11'),
					'12' => __('text_ca_origin_12'),
					'13' => __('text_ca_origin_13'),
					'14' => __('text_ca_origin_14'),
					'54' => __('text_ca_origin_54'),
					'65' => __('text_ca_origin_65')
				),
				// European Union Origin
				'EU' => array(
					'07' => __('text_eu_origin_07'),
					'08' => __('text_eu_origin_08'),
					'11' => __('text_eu_origin_11'),
					'54' => __('text_eu_origin_54'),
					'65' => __('text_eu_origin_65'),
					// next five services Poland domestic only
					'82' => __('text_eu_origin_82'),
					'83' => __('text_eu_origin_83'),
					'84' => __('text_eu_origin_84'),
					'85' => __('text_eu_origin_85'),
					'86' => __('text_eu_origin_86')
				),
				// Puerto Rico Origin
				'PR' => array(
					'01' => __('text_pr_origin_01'),
					'02' => __('text_pr_origin_02'),
					'03' => __('text_pr_origin_03'),
					'07' => __('text_pr_origin_07'),
					'08' => __('text_pr_origin_08'),
					'14' => __('text_pr_origin_14'),
					'54' => __('text_pr_origin_54'),
					'65' => __('text_pr_origin_65')
				),
				// Mexico Origin
				'MX' => array(
					'07' => __('text_mx_origin_07'),
					'08' => __('text_mx_origin_08'),
					'54' => __('text_mx_origin_54'),
					'65' => __('text_mx_origin_65')
				),
				// All other origins
				'other' => array(
					// service code 7 seems to be gone after January 2, 2007
					'07' => __('text_other_origin_07'),
					'08' => __('text_other_origin_08'),
					'11' => __('text_other_origin_11'),
					'54' => __('text_other_origin_54'),
					'65' => __('text_other_origin_65')
				)
			);
			
			$xml  = '<?xml version="1.0"?>';  
			$xml .= '<AccessRequest xml:lang="en-US">';  
			$xml .= '	<AccessLicenseNumber>' . $setting['ups_key'] . '</AccessLicenseNumber>';
			$xml .= '	<UserId>' . $setting['ups_username'] . '</UserId>';
			$xml .= '	<Password>' . $setting['ups_password'] . '</Password>';
			$xml .= '</AccessRequest>';
			$xml .= '<?xml version="1.0"?>';
			$xml .= '<RatingServiceSelectionRequest xml:lang="en-US">';
			$xml .= '	<Request>';  
			$xml .= '		<TransactionReference>'; 
			$xml .= '			<CustomerContext>Bare Bones Rate Request</CustomerContext>';  
			$xml .= '			<XpciVersion>1.0001</XpciVersion>';  
			$xml .= '		</TransactionReference>'; 
			$xml .= '		<RequestAction>Rate</RequestAction>';  
			$xml .= '		<RequestOption>shop</RequestOption>';  
			$xml .= '	</Request>';  
			$xml .= '   <PickupType>';
			$xml .= '       <Code>' . $setting['ups_pickup'] . '</Code>';
			$xml .= '   </PickupType>';
				
			if ($setting['ups_country'] == 'US' && $setting['ups_pickup'] == '11') {	
				$xml .= '   <CustomerClassification>';
				$xml .= '       <Code>' . $setting['ups_classification'] . '</Code>';
				$xml .= '   </CustomerClassification>';		
			}
			
			$xml .= '	<Shipment>';  
			$xml .= '		<Shipper>';  
			$xml .= '			<Address>';  
			$xml .= '				<City>' . $setting['ups_city'] . '</City>';
			$xml .= '				<StateProvinceCode>'. $setting['ups_state'] . '</StateProvinceCode>';
			$xml .= '				<CountryCode>' . $setting['ups_country'] . '</CountryCode>';
			$xml .= '				<PostalCode>' . $setting['ups_postcode'] . '</PostalCode>';
			$xml .= '			</Address>'; 
			$xml .= '		</Shipper>'; 
			$xml .= '		<ShipTo>'; 
			$xml .= '			<Address>'; 
			$xml .= ' 				<City>' . @$address['city'] . '</City>';
			$xml .= '				<StateProvinceCode>' . @$address['zone_code'] . '</StateProvinceCode>';
			$xml .= '				<CountryCode>' . @$address['iso_code_2'] . '</CountryCode>';
			$xml .= '				<PostalCode>' . @$address['postcode'] . '</PostalCode>';
			
			if ($setting['ups_quote_type'] == 'residential') {
				 $xml .= '				<ResidentialAddressIndicator />';
			}
			
			$xml .= '			</Address>'; 
			$xml .= '		</ShipTo>';
			$xml .= '		<ShipFrom>'; 
			$xml .= '			<Address>'; 
			$xml .= '				<City>' . $setting['ups_city'] . '</City>';
			$xml .= '				<StateProvinceCode>'. $setting['ups_state'] . '</StateProvinceCode>';
			$xml .= '				<CountryCode>' . $setting['ups_country'] . '</CountryCode>';
			$xml .= '				<PostalCode>' . $setting['ups_postcode'] . '</PostalCode>';
			$xml .= '			</Address>'; 
			$xml .= '		</ShipFrom>'; 
	
			$xml .= '		<Package>';
			$xml .= '			<PackagingType>';
			$xml .= '				<Code>' . $setting['ups_packaging'] . '</Code>';
			$xml .= '			</PackagingType>';

			$xml .= '		    <Dimensions>';
    		$xml .= '				<UnitOfMeasurement>';
    		$xml .= '					<Code>' . $length_code . '</Code>';
    		$xml .= '				</UnitOfMeasurement>';
    		$xml .= '				<Length>' . $length . '</Length>';
    		$xml .= '				<Width>' . $width . '</Width>';
    		$xml .= '				<Height>' . $height . '</Height>';
    		$xml .= '			</Dimensions>';
			
			$xml .= '			<PackageWeight>';
			$xml .= '				<UnitOfMeasurement>';
			$xml .= '					<Code>' . $weight_code . '</Code>';
			$xml .= '				</UnitOfMeasurement>';
			$xml .= '				<Weight>' . $weight . '</Weight>';
			$xml .= '			</PackageWeight>';
			
			if ($setting['ups_insurance']) {
				$xml .= '           <PackageServiceOptions>';
				$xml .= '               <InsuredValue>';
				$xml .= '                   <CurrencyCode>' . $this->currency->getCode() . '</CurrencyCode>';
				$xml .= '                   <MonetaryValue>' . $this->currency->format($this->cart->getTotal(), false, false, false) . '</MonetaryValue>';
				$xml .= '               </InsuredValue>';
				$xml .= '           </PackageServiceOptions>';
			}
			
			$xml .= '		</Package>';
        	
			$xml .= '	</Shipment>';
			$xml .= '</RatingServiceSelectionRequest>';
			
			if (!$setting['ups_test']) {
				$url = 'https://www.ups.com/ups.app/xml/Rate';
			} else {
				$url = 'https://wwwcie.ups.com/ups.app/xml/Rate';
			}
			
			$ch = curl_init($url);  
			
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_POST, 1);  
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);  
			
			$result = curl_exec($ch);  
			
			curl_close($ch); 
					
			$error = '';
			
			$error_msg = '';
			
			$quote_data = array();
			
			if ($result) {
				if ($setting['ups_debug']) {
					$this->log->write("UPS DATA SENT: " . $xml);
					$this->log->write("UPS DATA RECV: " . $result);
				}
				
				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->loadXml($result);	
				
				$rating_service_selection_response = $dom->getElementsByTagName('RatingServiceSelectionResponse')->item(0);
				
				$response = $rating_service_selection_response->getElementsByTagName('Response')->item(0);
				
				$response_status_code = $response->getElementsByTagName('ResponseStatusCode');
				
				if ($response_status_code->item(0)->nodeValue != '1') {
					$error = $response->getElementsByTagName('Error')->item(0);
					
					$error_msg = $error->getElementsByTagName('ErrorCode')->item(0)->nodeValue;

					$error_msg .= ': ' . $error->getElementsByTagName('ErrorDescription')->item(0)->nodeValue;
				} else {
					$rated_shipments = $rating_service_selection_response->getElementsByTagName('RatedShipment');
	
					foreach ($rated_shipments as $rated_shipment) {
						$service = $rated_shipment->getElementsByTagName('Service')->item(0);
							
						$code = $service->getElementsByTagName('Code')->item(0)->nodeValue;

						$total_charges = $rated_shipment->getElementsByTagName('TotalCharges')->item(0);
							
						$cost = $total_charges->getElementsByTagName('MonetaryValue')->item(0)->nodeValue;	
						
						$currency = $total_charges->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
						
						if (!($code && $cost)) {
							continue;
						}
													
						if ($setting['ups_' . strtolower($setting['ups_origin']) . '_' . $code]) {
							$quote_data[$code] = array(
								'code'         => 'ups.' . $code,
								'title'        => $service_code[$setting['ups_origin']][$code],
								'cost'         => $this->currency->convert($cost, $currency, $this->config->get('config_currency')),
								'tax_class_id' => $setting['ups_tax_class_id'],
								'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($cost, $currency, $this->currency->getCode()), $setting['ups_tax_class_id'], $this->config->get('tax')), $this->currency->getCode(), 1.0000000)
							);
						}
					}
				}
			}
			
			$title = __('United Parcel Service');
			
			if ($setting['ups_display_weight']) {	  
				$title .= ' (' . __('Weight:') . ' ' . $this->weight->format($weight, $setting['ups_weight_class_id']) . ')';
			}
		
			$method_data = array(
				'code'       => 'ups',
				'title'      => $title,
				'quote'      => $quote_data,
				'sort_order' => $setting['ups_sort_order'],
				'error'      => $error_msg
			);
		}
		
		return $method_data;
	}
  
}
?>