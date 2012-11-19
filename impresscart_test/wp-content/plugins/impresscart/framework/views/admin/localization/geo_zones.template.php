<div class="impresscart_header">
<h1 class="theme-title"><?php echo __('Geo Zones');?></h1>
</div>
<?php $country_options = '';?>
<?php foreach($countries as $country) : ?>
<?php $country_options .= '<option value="' . $country->country_id . '">' . $country->name . '</option>';?>
<?php endforeach;?>

<script language="javascript">
	// script data
	var country_options = <?php echo json_encode($country_options);?>;
	var countries = <?php echo json_encode($countries);?>;
	var country_zones = {};
	var zone_index = <?php echo !empty($zones) ? count($zones) : 1?>;

	function getCountryZones(countryID){
		if(typeof country_zones[countryID] != 'undefined'){
			return country_zones[countryID];
		}
		jQuery.ajax({
			url : 'admin-ajax.php',
			async : false,
			data : {
				action : 'framework',
				fwurl : '/admin/localization/country_zones_html_options',
				country_id : countryID
			},
			success : function(html){
				country_zones[countryID] = html;
			}
		});
		return country_zones[countryID];
	}
</script>

<div class="wrap">
	<?php if(!empty($errors)) : ?>
	<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required" id="country_and_zone">
							<label for="name">Add Zones to geo zone</label>
							<p></p>
							<table class="wp-list-table widefat fixed pages" cellspacing="0">
								<thead>
									<th>
										Country
									</th>
									<th>
										Zone
									</th>
									<th width="150">
										&nbsp;
									</th>
								</thead>
								<tbody id="country_and_zone_list">
									<?php $i = 0;?>
									<?php if(!empty($zones)) : ?>
										<?php foreach($zones as $zone) : ?>
											<?php $i++;?>
											<tr>
												<td>
													<select class="country" name="zones[<?php echo $i?>][country_id]" valuez="<?php echo $zone["country_id"];?>">
													</select>
												</td>
												<td>
													<select class="zone" name="zones[<?php echo $i?>][zone_id]" valuez="<?php echo $zone["zone_id"];?>">
													</select>
												</td>
												<td><a class="remove" href="#randomize">Remove</a></td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
								<tfoot>
									<th>
										Country
									</th>
									<th >
										Zone
									</th>
									<th >
										<a class="add right" href="#randomize">Add Country/Zone</a>
									</th>
								</tfoot>
							</table>

							<p>The countries and zones covered by this geo zone.</p>
						</div>
					</td>
				</tr>
			</table>
	</div>
</div>

<script language="javascript">
		jQuery(function(){

			jQuery('#country_and_zone')
				.delegate('.add', 'click', function(){
					zone_index++;
					var zone_options = countries.length > 0 ? getCountryZones(countries[0].country_id) : '';
					var html = '<tr>';
						html += '<td>';
						html += '<select class="country" name="zones[' + zone_index + '][country_id]">';
						html += country_options;
						html += '</select>';
						html += '</td>';
						html += '<td>';
						html += '<select class="zone" name="zones[' + zone_index + '][zone_id]">';
						html += zone_options;
						html += '</select>';
						html += '</td>';
						html += '<td>';
						html += '<a class="remove" href="#randomize">Remove</a>';
						html += '</td>';
						html += '</tr>;'
						jQuery('#country_and_zone_list').append(html);
				})
				.delegate('.remove', 'click', function(){
					jQuery(this).closest('tr').remove();
				})
				.delegate('select.country', 'change', function(){
					var countryID = jQuery(this).val();
					var zone_options = countries.length > 0 ? getCountryZones(countryID) : '';
					var $zoneSel = jQuery(this).closest('tr').find('select.zone:eq(0)');
					var val = $zoneSel.attr('valuez');
					$zoneSel.html(zone_options).val(val);
				});

			jQuery('#country_and_zone_list').find('select.country').each(function(){
				var countryID = jQuery(this).attr('valuez');
				var zone_options = countries.length > 0 ? getCountryZones(countryID) : '';
				jQuery(this).html(country_options).val(countryID).change();
			});
		});
	</script>
