<?php 
	echo Goscom::generateHeader($pages);
	echo "<br><br><br><br><br>";
?>
<div>
<form action="" method="post" >

<table style="border-spacing: 0; border-collapse: collapse;" class="wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<th colspan="2" style="border: 1px;">
							<h2>
								UPS Shipping Method
							</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">
						<input type="button" name="backtolist"
							id="backtolist" class="button" value="Back to list" /> 
							<input type="hidden" id="backaddress" name="backaddress"
						value="<?php echo(get_bloginfo('url') . '/wp-admin/' . 'admin.php?page=shipping');?>">
						</td>
					</tr>
					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_key; ?>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_key]" value="<?php echo $ups_key; ?>" />
							<?php if ($error_key) { ?>
							<span class="error"><?php echo $error_key; ?></span>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							
							<span class="required">*</span> <?php echo $entry_username; ?>
							
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_username]" value="<?php echo $ups_username; ?>" />
							<?php if ($error_username) { ?>
							<span class="error"><?php echo $error_username; ?></span>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_password; ?>
						</td>

						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_password]" value="<?php echo $ups_password; ?>" />
							<?php if ($error_password) { ?>
							<span class="error"><?php echo $error_password; ?></span>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_pickup; ?>
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][ups][ups_pickup]">
			                <?php foreach ($pickups as $pickup) { ?>
			                <?php if ($pickup['value'] == $ups_pickup) { ?>
			                <option value="<?php echo $pickup['value']; ?>" selected="selected"><?php echo $pickup['text']; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $pickup['value']; ?>"><?php echo $pickup['text']; ?></option>
			                <?php } ?>
			                <?php } ?>
			              </select>
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_packaging; ?>
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][ups][ups_packaging]">
			                <?php foreach ($packages as $package) { ?>
			                <?php if ($package['value'] == $ups_packaging) { ?>
			                <option value="<?php echo $package['value']; ?>" selected="selected"><?php echo $package['text']; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $package['value']; ?>"><?php echo $package['text']; ?></option>
			                <?php } ?>
			                <?php } ?>
			              </select>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_classification; ?>
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][ups][ups_classification]">
			                <?php foreach ($classifications as $classification) { ?>
			                <?php if ($classification['value'] == $ups_classification) { ?>
			                <option value="<?php echo $classification['value']; ?>" selected="selected"><?php echo $classification['text']; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $classification['value']; ?>"><?php echo $classification['text']; ?></option>
			                <?php } ?>
			                <?php } ?>
			              </select>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_origin; ?>
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][ups][ups_origin]">
			                <?php foreach ($origins as $origin) { ?>
			                <?php if ($origin['value'] == $ups_origin) { ?>
			                <option value="<?php echo $origin['value']; ?>" selected="selected"><?php echo $origin['text']; ?></option>
			                <?php } else { ?>
			                <option value="<?php echo $origin['value']; ?>"><?php echo $origin['text']; ?></option>
			                <?php } ?>
			                <?php } ?>
			              </select>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_city; ?>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_city]" value="<?php echo $ups_city; ?>" />
				              <?php if ($error_city) { ?>
				              <span class="error"><?php echo $error_city; ?></span>
				              <?php } ?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_state; ?>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_state]" value="<?php echo $ups_state; ?>" maxlength="2" size="4" />
				              <?php if ($error_state) { ?>
				              <span class="error"><?php echo $error_state; ?></span>
				              <?php } ?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_country; ?>
						</td>
						<td class='widefat_extend'>
							  <input type="text" name="impresscart[shipping_method][ups][ups_country]" value="<?php echo $ups_country; ?>" maxlength="2" size="4" />
				              <?php if ($error_country) { ?>
				              <span class="error"><?php echo $error_country; ?></span>
				              <?php } ?>
						</td>
					</tr>
					
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_postcode; ?>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_postcode]" value="<?php echo $ups_postcode; ?>" />
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_test; ?>
						</td>
						<td class='widefat_extend'>
							<?php if ($ups_test) { ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_test]" value="1" checked="checked" />
							<?php echo $text_yes; ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_test]" value="0" />
							<?php echo $text_no; ?>
							<?php } else { ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_test]" value="1" />
							<?php echo $text_yes; ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_test]" value="0" checked="checked" />
							<?php echo $text_no; ?>
							<?php } ?>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_quote_type; ?>
						</td>
						<td class='widefat_extend'>
							<select name="impresscart[shipping_method][ups][ups_quote_type]">
							<?php foreach ($quote_types as $quote_type) { ?>
							<?php if ($quote_type['value'] == $ups_quote_type) { ?>
							<option value="<?php echo $quote_type['value']; ?>" selected="selected"><?php echo $quote_type['text']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $quote_type['value']; ?>"><?php echo $quote_type['text']; ?></option>
							<?php } ?>
							<?php } ?>
							</select>
						</td>
					</tr>
					
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_service; ?>
						</td>
						<td class='widefat_extend' id="service">
							            	<div id="US">
			                <div class="scrollbox">
			                  <?php $class = 'odd'; ?>
			                  <div class="even">
			                    <?php if ($ups_us_01) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_01]" value="1" checked="checked" />
			                    <?php echo $text_next_day_air; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_01]" value="1" />
			                    <?php echo $text_next_day_air; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_us_02) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_02]" value="1" checked="checked" />
			                    <?php echo $text_2nd_day_air; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_02]" value="1" />
			                    <?php echo $text_2nd_day_air; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_03) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_03]" value="1" checked="checked" />
			                    <?php echo $text_ground; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_03]" value="1" />
			                    <?php echo $text_ground; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_us_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_07]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_07]" value="1" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_08]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_08]" value="1" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_us_11) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_11]" value="1" checked="checked" />
			                    <?php echo $text_standard; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_11]" value="1" />
			                    <?php echo $text_standard; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_12) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_12]" value="1" checked="checked" />
			                    <?php echo $text_3_day_select; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_12]" value="1" />
			                    <?php echo $text_3_day_select; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_13) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_13]" value="1" checked="checked" />
			                    <?php echo $text_next_day_air_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_13]" value="1" />
			                    <?php echo $text_next_day_air_saver; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_us_14) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_14]" value="1" checked="checked" />
			                    <?php echo $text_next_day_air_early_am; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_14]" value="1" />
			                    <?php echo $text_next_day_air_early_am; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_us_59) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_59]" value="1" checked="checked" />
			                    <?php echo $text_2nd_day_air_am; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_59]" value="1" />
			                    <?php echo $text_2nd_day_air_am; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_us_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_us_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <div id="PR">
			                <div class="scrollbox">
			                  <div class="even">
			                    <?php if ($ups_pr_01) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_01]" value="1" checked="checked" />
			                    <?php echo $text_next_day_air; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_01]" value="1" />
			                    <?php echo $text_next_day_air; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_pr_02) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_02]" value="1" checked="checked" />
			                    <?php echo $text_2nd_day_air; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_02]" value="1" />
			                    <?php echo $text_2nd_day_air; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_pr_03) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_03]" value="1" checked="checked" />
			                    <?php echo $text_ground; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_03]" value="1" />
			                    <?php echo $text_ground; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_pr_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_07]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_07]" value="1" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_pr_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_08]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_08]" value="1" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_pr_14) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_14]" value="1" checked="checked" />
			                    <?php echo $text_next_day_air_early_am; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_14]" value="1" />
			                    <?php echo $text_next_day_air_early_am; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_pr_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_pr_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_pr_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <div id="CA">
			                <div class="scrollbox">
			                  <div class="even">
			                    <?php if ($ups_ca_01) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_01]" value="1" checked="checked" />
			                    <?php echo $text_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_01]" value="1" />
			                    <?php echo $text_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_ca_02) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_02]" value="1" checked="checked" />
			                    <?php echo $text_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_02]" value="1" />
			                    <?php echo $text_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_ca_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_07]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_07]" value="1" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_ca_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_08]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_08]" value="1" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_ca_11) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_11]" value="1" checked="checked" />
			                    <?php echo $text_standard; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_11]" value="1" />
			                    <?php echo $text_standard; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_ca_12) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_12]" value="1" checked="checked" />
			                    <?php echo $text_3_day_select; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_12]" value="1" />
			                    <?php echo $text_3_day_select; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_ca_13) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_13]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_13]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_ca_14) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_14]" value="1" checked="checked" />
			                    <?php echo $text_express_early_am; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_14]" value="1" />
			                    <?php echo $text_express_early_am; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_ca_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_ca_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_ca_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <div id="MX">
			                <div class="scrollbox">
			                  <div class="even">
			                    <?php if ($ups_mx_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_07]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_07]" value="1" />
			                    <?php echo $text_worldwide_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_mx_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_08]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_08]" value="1" />
			                    <?php echo $text_worldwide_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_mx_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_mx_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_mx_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <div id="EU">
			                <div class="scrollbox">
			                  <div class="even">
			                    <?php if ($ups_eu_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_07]" value="1" checked="checked" />
			                    <?php echo $text_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_07]" value="1" />
			                    <?php echo $text_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_eu_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_08]" value="1" checked="checked" />
			                    <?php echo $text_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_08]" value="1" />
			                    <?php echo $text_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_eu_11) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_11]" value="1" checked="checked" />
			                    <?php echo $text_standard; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_11]" value="1" />
			                    <?php echo $text_standard; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_eu_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_eu_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_eu_82) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_82]" value="1" checked="checked" />
			                    <?php echo $text_today_standard; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_82]" value="1" />
			                    <?php echo $text_today_standard; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_eu_83) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_83]" value="1" checked="checked" />
			                    <?php echo $text_today_dedicated_courier; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_83]" value="1" />
			                    <?php echo $text_today_dedicated_courier; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_eu_84) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_84]" value="1" checked="checked" />
			                    <?php echo $text_today_intercity; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_84]" value="1" />
			                    <?php echo $text_today_intercity; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_eu_85) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_85]" value="1" checked="checked" />
			                    <?php echo $text_today_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_85]" value="1" />
			                    <?php echo $text_today_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_eu_86) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_86]" value="1" checked="checked" />
			                    <?php echo $text_today_express_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_eu_86]" value="1" />
			                    <?php echo $text_today_express_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <div id="other">
			                <div class="scrollbox">
			                  <div class="even">
			                    <?php if ($ups_other_07) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_07]" value="1" checked="checked" />
			                    <?php echo $text_express; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_07]" value="1" />
			                    <?php echo $text_express; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_other_08) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_08]" value="1" checked="checked" />
			                    <?php echo $text_expedited; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_08]" value="1" />
			                    <?php echo $text_expedited; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_other_11) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_11]" value="1" checked="checked" />
			                    <?php echo $text_standard; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_11]" value="1" />
			                    <?php echo $text_standard; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="odd">
			                    <?php if ($ups_other_54) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_54]" value="1" checked="checked" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_54]" value="1" />
			                    <?php echo $text_worldwide_express_plus; ?>
			                    <?php } ?>
			                  </div>
			                  <div class="even">
			                    <?php if ($ups_other_65) { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_65]" value="1" checked="checked" />
			                    <?php echo $text_saver; ?>
			                    <?php } else { ?>
			                    <input type="checkbox" name="impresscart[shipping_method][ups][ups_other_65]" value="1" />
			                    <?php echo $text_saver; ?>
			                    <?php } ?>
			                  </div>
			                </div>
			              </div>
			              <a onclick="jQuery(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="jQuery(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
              
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_insurance; ?>
						</td>
						<td class='widefat_extend'>
							<?php if ($ups_insurance) { ?>
				              <input type="radio" name="impresscart[shipping_method][ups][ups_insurance]" value="1" checked="checked" />
				              <?php echo $text_yes; ?>
				              <input type="radio" name="impresscart[shipping_method][ups][ups_insurance]" value="0" />
				              <?php echo $text_no; ?>
				              <?php } else { ?>
				              <input type="radio" name="impresscart[shipping_method][ups][ups_insurance]" value="1" />
				              <?php echo $text_yes; ?>
				              <input type="radio" name="impresscart[shipping_method][ups][ups_insurance]" value="0" checked="checked" />
				              <?php echo $text_no; ?>
				              <?php } ?>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_display_weight; ?>
						</td>
						<td class='widefat_extend'>
							<?php if ($ups_display_weight) { ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_display_weight]" value="1" checked="checked" />
							<?php echo $text_yes; ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_display_weight]" value="0" />
							<?php echo $text_no; ?>
							<?php } else { ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_display_weight]" value="1" />
							<?php echo $text_yes; ?>
							<input type="radio" name="impresscart[shipping_method][ups][ups_display_weight]" value="0" checked="checked" />
							<?php echo $text_no; ?>
							<?php } ?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_weight_class; ?>
						</td>
						<td class='widefat_extend'>
							<?php echo $weight_class_html;?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_length_class; ?>
						</td>
						<td class='widefat_extend'>
							<?php echo $length_class_html;?>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
							<span class="required">*</span> <?php echo $entry_dimension; ?>
						</td>
						<td class='widefat_extend'>
							<input type="text" name="impresscart[shipping_method][ups][ups_length]" value="<?php echo $ups_length; ?>" size="4" />
			              <input type="text" name="impresscart[shipping_method][ups][ups_width]" value="<?php echo $ups_width; ?>" size="4" />
			              <input type="text" name="impresscart[shipping_method][ups][ups_height]" value="<?php echo $ups_height; ?>" size="4" />
			              <?php if ($error_dimension) { ?>
			              <span class="error"><?php echo $error_dimension; ?></span>
			              <?php } ?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
							<?php echo $entry_tax_class; ?>
						</td>
						<td class='widefat_extend'>
						  <?php echo $tax_classes; ?>
						</td>
					</tr>
					
					
					<tr>
						<td class='widefat_extend'>
						  <?php echo $entry_geo_zone; ?>
						</td>
						<td class='widefat_extend'>
						  <?php echo $geo_zones;?>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
						  <?php echo $entry_status; ?>
						</td>
						<td class='widefat_extend'>
						  <select name="impresscart[shipping_method][ups][enabled]">
			                <?php if ($ups_status) { ?>
			                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			                <option value="0"><?php echo $text_disabled; ?></option>
			                <?php } else { ?>
			                <option value="1"><?php echo $text_enabled; ?></option>
			                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			                <?php } ?>
			              </select>
						</td>
					</tr>
					
					<tr>
						<td class='widefat_extend'>
						  <?php echo $entry_sort_order; ?>
						</td>
						<td class='widefat_extend'>
						  <input type="text" name="impresscart[shipping_method][ups][ups_sort_order]" value="<?php echo $ups_sort_order; ?>" size="1" />
						</td>
					</tr>

					<tr>
						<td class='widefat_extend'>
						  <?php echo $entry_debug; ?>
						</td>
						<td class='widefat_extend'>
						  <select name="impresscart[shipping_method][ups][ups_debug]">
			              <?php if ($ups_debug) { ?>
			              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			              <option value="0"><?php echo $text_disabled; ?></option>
			              <?php } else { ?>
			              <option value="1"><?php echo $text_enabled; ?></option>
			              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			              <?php } ?>
			            </select>
						</td>
					</tr>					
					<tr>
						<td colspan="2" class='widefat_extend'>
							<input type="submit" name="save" value="save" />
							<input type="hidden" name="impresscart[shipping_method][ups][code]" value="ups" />
						</td>
					</tr>
				</tbody>
			</table>

<!-- ********************************************************** -->

</form>
        
</div>

<script type="text/javascript"><!--

jQuery('#backtolist').bind('click', function() {
	  //alert('User clicked on "foo."');
	  //window.history.back(-1);
	  window.location.href = jQuery('#backaddress').val();
	  return false;
});


jQuery('select[name=\'ups_origin\']').bind('change', function() {
	jQuery('#service > div').hide();	
										 
	jQuery('#' + this.value).show();	
});

jQuery('select[name=\'ups_origin\']').trigger('change');
//-->
</script>


