<div style="width: 100%; overflow-x: auto;overflow-y:hidden;">
          <table id="product" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_product; ?></td>
                <td class="left"><?php echo $entry_model; ?></td>
                <td class="right"><?php echo $entry_quantity; ?></td>
                <td class="left"><?php echo $entry_reason; ?></td>
                <td class="left"><?php echo $entry_opened; ?></td>
                <td class="left"><?php echo $entry_comment; ?></td>
                <td class="left"><?php echo $entry_action; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $product_row = 0; ?>
            <?php foreach ($return_products as $return_product) { ?>
            <tbody id="product-row<?php echo $product_row; ?>">
              <tr>
                <td class="left"><input type="text" name="data[return_product][<?php echo $product_row; ?>][name]" value="<?php echo $return_product['name']; ?>" />
                  <input type="hidden" name="data[return_product][<?php echo $product_row; ?>][product_id]" value="<?php echo $return_product['product_id']; ?>" /></td>
                <td class="left"><input type="text" name="data[return_product][<?php echo $product_row; ?>][model]" value="<?php echo $return_product['model']; ?>" /></td>
                <td class="right"><input type="text" name="data[return_product][<?php echo $product_row; ?>][quantity]" value="<?php echo $return_product['quantity']; ?>" size="3" /></td>
                <td class="left"><select name="data[return_product][<?php echo $product_row; ?>][return_reason_id]">
                    <?php foreach ($return_reasons as $return_reason) { ?>
                    <?php if ($return_reason['return_reason_id'] == $return_product['return_reason_id']) { ?>
                    <option value="<?php echo $return_reason['return_reason_id']; ?>" selected="selected"><?php echo $return_reason['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="left"><select name="data[return_product][<?php echo $product_row; ?>][opened]">
                    <?php if ($return_product['opened']) { ?>
                    <option value="1" selected="selected"><?php echo $text_opened; ?></option>
                    <option value="0"><?php echo $text_unopened; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_opened; ?></option>
                    <option value="0" selected="selected"><?php echo $text_unopened; ?></option>
                    <?php } ?>
                  </select></td>
                <td class="left"><textarea name="data[return_product][<?php echo $product_row; ?>][comment]" cols="30" rows="5"><?php echo $return_product['comment']; ?></textarea></td>
                <td class="left"><select name="data[return_product][<?php echo $product_row; ?>][return_action_id]">
                    <option value="0"></option>
                    <?php foreach ($return_actions as $return_action) { ?>
                    <?php if ($return_action['return_action_id'] == $return_product['return_action_id']) { ?>
                    <option value="<?php echo $return_action['return_action_id']; ?>" selected="selected"> <?php echo $return_action['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $return_action['return_action_id']; ?>"><?php echo $return_action['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="left"><a onclick="jQuery('#product-row<?php echo $product_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $product_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="7"></td>
                <td class="left"><a onclick="addProduct();" class="button"><?php echo $button_add_product; ?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        

<script type="text/javascript"><!--
jQuery.widget('custom.catcomplete', jQuery.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		jQuery.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

jQuery('input[name=\'customer\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		jQuery.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {	
				response(jQuery.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id,
						firstname: item.firstname,
						lastname: item.lastname,
						email: item.email,
						telephone: item.telephone
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		jQuery('input[name=\'customer\']').attr('value', ui.item.label);
		jQuery('input[name=\'customer_id\']').attr('value', ui.item.value);
		jQuery('input[name=\'firstname\']').attr('value', ui.item.firstname);
		jQuery('input[name=\'lastname\']').attr('value', ui.item.lastname);
		jQuery('input[name=\'email\']').attr('value', ui.item.email);
		jQuery('input[name=\'telephone\']').attr('value', ui.item.telephone);

		return false;
	}
});
//--></script> 
<script type="text/javascript"><!--
var product_row = <?php echo $product_row; ?>;

function addProduct() {
    html  = '<tbody id="product-row' + product_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><input type="text" name="data[return_product][' + product_row + '][name]" value="" /><input type="hidden" name="data[return_product][' + product_row + '][product_id]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="data[return_product][' + product_row + '][model]" value="" /></td>';
	html += '    <td class="right"><input type="text" name="data[return_product][' + product_row + '][quantity]" value="1" size="3" /></td>';
    html += '    <td class="left"><select name="data[return_product][' + product_row + '][return_reason_id]">';
    <?php foreach ($return_reasons as $return_reason) { ?>
    html += '		<option value="<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><select name="data[return_product][' + product_row + '][opened]">';
    html += '      <option value="1"><?php echo $text_opened; ?></option>';
	html += '      <option value="0"><?php echo $text_unopened; ?></option>';
    html += '    </select></td>';	
	html += '    <td class="left"><textarea name="data[return_product][' + product_row + '][comment]" cols="30" rows="3"></textarea></td>';
	html += '    <td class="left"><select name="data[return_product][' + product_row + '][return_action_id]">';
    <?php foreach ($return_actions as $return_action) { ?>
    html += '      <option value="<?php echo $return_action['return_action_id']; ?>"><?php echo $return_action['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';	
    html += '    <td class="left"><a onclick="jQuery(\'#product-row' + product_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
	html += '</tbody>';
	
	jQuery('#product tfoot').before(html);

	productautocomplete(product_row)

	product_row++;
}

function productautocomplete(product_row) {
	jQuery('input[name=\'data[return_product][' + product_row + '][name]\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			jQuery.ajax({
				url: 'admin-ajax.php',
				data : { action : 'framework', fwurl : '/admin/catalog/product_autocomplete',  'filter_name' : encodeURIComponent(request.term) },
				dataType: 'json',
				success: function(json) {	
					response(jQuery.map(json, function(item) {
						return {
							label: item.name,
							value: item.product_id,
							model: item.model
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			jQuery('input[name=\'data[return_product][' + product_row + '][product_id]\']').attr('value', ui.item.value);
			jQuery('input[name=\'data[return_product][' + product_row + '][name]\']').attr('value', ui.item.label);
			jQuery('input[name=\'data[return_product][' + product_row + '][model]\']').attr('value', ui.item.model);
			
			return false;
		}
	});
}

jQuery('#product tbody').each(function(index, element) {
	productautocomplete(index);
});		
//--></script> 
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<script type="text/javascript"><!--
jQuery('.vtabs a').tabs(); 
//--></script> 
        