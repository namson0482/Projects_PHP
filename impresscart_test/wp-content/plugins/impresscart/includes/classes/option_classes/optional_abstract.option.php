<?php

require_once dirname(__FILE__) . '/abstract.option.php';

abstract class impresscart_option_class_optional_abstract extends impresscart_option_class_abstract {

	public function displayAdminMetaInList($option){
		?>
			<?php if(!empty($option->meta['options'])) : ?>
				<b>Options:</b>
				<?php $options = ''?>
				<?php foreach($option->meta['options'] as $op) : ?>
					<?php $options .= $op['name'] . ', '?>
				<?php endforeach;?>
				<?php echo trim($options,' ,')?>
			<?php else:?>
				No options
			<?php endif;?>
		<?php
	}

	public function displayAdminMetaInForm($option){
		?>
			<script language="javascript">
				var row_index = <?php echo @$option->meta['options'] ? count($option->meta['options']) : '0';?>;
				jQuery(function(){
					jQuery('#admin-option-select-wrapper')
						.delegate('.add', 'click', function(){
							row_index++;
							var html = '<tr>';
								html += '<td>';
								html += '<input size="50" name="meta[options][' + row_index + '][code]" type="text" />';
								html += '</td>';
								html += '<td>';
								html += '<input size="50" name="meta[options][' + row_index + '][name]" type="text" />';
								html += '</td>';
								html += '<td>';
								html += '<a class="remove">Remove</a>';
								html += '</td>';
								html += '</tr>;'
								jQuery('#admin_option_select').append(html);
						})
						.delegate('.remove', 'click', function(){
							jQuery(this).closest('tr').remove();
						})
				});
			</script>
			<div id="admin-option-select-wrapper">
				<table id="admin_option_select" class="wp-list-table widefat fixed pages" >
					<thead>
						<tr>
							<th>Code </th>
							<th>Value </th>
							<th width="150"><a class="add" href="#randomize">Add New Value</a></th>
						</tr>
					</thead>
					<tbody>
					<?php if(!empty($option->meta['options'])) : ?>
						<?php $i = 0;?>
						<?php foreach($option->meta['options'] as $op) : ?>
						<?php $i++;?>
							<tr>
								<td>
									<input type="text" size="50" name="meta[options][<?php echo $i?>][code]" value="<?php echo @$op['code']?>"/>
								</td>
								<td>
									<input type="text" size="50" name="meta[options][<?php echo $i?>][name]" value="<?php echo $op['name']?>"/>
								</td>
								<td>
									<a class="remove" href="#randomize">Remove</a>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
					</tbody>
					<tfoot>
						<tr>
							<th>Code </th>
							<th>Value </th>
							<th><a class="add" href="#randomize">Add New Value</a></th>
						</tr>
					</tfoot>
				</table>

			</div>
		<?php
	}

	public function displayPostMetaInMetaBox($postmeta, $option) {
		?>
			<?php if(!empty($option->meta['options'])) : ?>
				<table class="wp-list-table widefat fixed pages" cellspacing="0">
					<thead>
						<tr>
							<th width="60">Display</th>
							<th width="150">Value</th>
							<th width="70">Quantity</th>
							<th>Price Change</th>
							<th width="70">Weight</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($option->meta['options'] as $op) : ?>
						<?php empty($op['code']) ? $op['code'] = $op['name'] : ''?>
						<tr>
							<td>
								<input
									class="productoptions_<?php echo $option->ID;?>"
									type="checkbox"
									name="productoptions[<?php echo $option->ID?>][options][<?php echo $op['code']?>][display]"
									<?php echo @$postmeta[$option->ID]['options'][$op['code']]['display'] ? 'checked="checked"' : '';?>
								/>
							</td>
							<td>
								<?php echo $op['name']?>
							</td>
							<td>
								<input
									type="text"
									size="4"
									name="productoptions[<?php echo $option->ID?>][options][<?php echo $op['code']?>][quantity]"
									value="<?php echo @$postmeta[$option->ID]['options'][$op['code']]['quantity']?>"
								/>
							</td>
							<td>
								<input
									type="text"
									size="15"
									name="productoptions[<?php echo $option->ID?>][options][<?php echo $op['code']?>][pricechange]"
									value="<?php echo @$postmeta[$option->ID]['options'][$op['code']]['pricechange']?>"
								/>

								<select
									name="productoptions[<?php echo $option->ID?>][options][<?php echo $op['code']?>][pricechangeby]"
								>
									<option value="amount" <?php echo @$postmeta[$option->ID]['options'][$op['code']]['pricechangeby'] == 'amount' ? 'selected="selected"' : ''?>>Amount</option>
									<option value="percentage" <?php echo @$postmeta[$option->ID]['options'][$op['code']]['pricechangeby'] == 'percentage' ? 'selected="selected"' : ''?>>Percentage</option>
								</select>

							</td>
							<td>
								<input
									type="text"
									size="4"
									name="productoptions[<?php echo $option->ID?>][options][<?php echo $op['code']?>][weight]"
									value="<?php echo @$postmeta[$option->ID]['options'][$op['code']]['weight']?>"
								/>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<th>Display</th>
							<th>Value</th>
							<th>Quantity</th>
							<th>Price Change</th>
							<th>Weight</th>
						</tr>
					</tfoot>
				</table>
			<?php endif;?>
		<?php
	}

	public function calculateBuyOptionPrice($basePrice, $postmeta, $option, $buyOptions){
		foreach($option->meta['options'] as $op) {
			# this option is used at buy
			$op['code'] = @$op['code'] ? $op['code'] : $op['name'];
			if(@$buyOptions[$option->ID] == $op['code']) {
				# find the settings in postmeta
				$changeBy = @$postmeta[$option->ID]['options'][$op['code']]['pricechangeby'];
				$change = @$postmeta[$option->ID]['options'][$op['code']]['pricechange'];
				if($changeBy == 'amount') {
					return $change;
				} else {
					return round($basePrice * $change / 100, 2);
				}
			}
		}
		return 0;
	}

	public function getOptionValue($basePrice, $postmeta, $option) {
		$return = array();
		if(!empty($option->meta['options'])) {
			foreach($option->meta['options'] as $op) {
				empty($op['code']) ? $op['code'] = $op['name'] : '';
				if(empty($postmeta[$option->ID]['options'][$op['code']]['display'])) {
					continue;
				}

				$changeBy = @$postmeta[$option->ID]['options'][$op['code']]['pricechangeby'];
				$change = @$postmeta[$option->ID]['options'][$op['code']]['pricechange'];
				if ($changeBy != 'amount' ) {
					$change = $basePrice * $change / 100;
				}

				$weight = @$postmeta[$option->ID]['options'][$op['code']]['weight'];
				$return[] = array(
					'product_option_value_id' => $op['code'],
					'option_value_id'         => $op['code'],
					'name'                    => @$op['name'],
					'image'                   => null, # no for optional value
					'quantity'                => @$postmeta[$option->ID]['options'][$op['code']]['quantity'],
					'subtract'                => false, # not supported yet TODO,
					'price'                   => $change,
					'price_prefix'            => $change >= 0 ? '+' : '-',
					'weight'                  => $weight,
					'weight_prefix'           => $weight >= 0 ? '+' : '-'
				);
			}
		}
		return $return;
	}
}


