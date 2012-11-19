  <?php if (isset($error_warning)) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
        <div id="tab-general">
          <table class="form">            
            <tr>
              <td><span class="required">*</span> <?php echo $entry_code; ?></td>
              <td><input type="text" name="coupon_code" value="<?php echo $code; ?>" readonly="readonly" />
                <?php if (isset($error_code)) { ?>
                <span class="error"><?php echo $error_code; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_type; ?></td>
              <td><select name="data[type]">
                  <?php if ($type == 'P') { ?>
                  <option value="P" selected="selected"><?php echo $text_percent; ?></option>
                  <?php } else { ?>
                  <option value="P"><?php echo $text_percent; ?></option>
                  <?php } ?>
                  <?php if ($type == 'F') { ?>
                  <option value="F" selected="selected"><?php echo $text_amount; ?></option>
                  <?php } else { ?>
                  <option value="F"><?php echo $text_amount; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_discount; ?></td>
              <td><input type="text" name="data[discount]" value="<?php echo @$discount; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_total; ?></td>
              <td><input type="text" name="data[total]" value="<?php echo @$total; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_logged; ?></td>
              <td><?php if (isset($logged)) { ?>
                <input type="radio" name="data[logged]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="data[logged]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="data[logged]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="data[logged]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_shipping; ?></td>
              <td><?php if (isset($shipping)) { ?>
                <input type="radio" name="data[shipping]" value="1" checked="checked" />
                <?php echo @$text_yes; ?>
                <input type="radio" name="data[shipping]" value="0" />
                <?php echo @$text_no; ?>
                <?php } else { ?>
                <input type="radio" name="data[shipping]" value="1" />
                <?php echo @$text_yes; ?>
                <input type="radio" name="data[shipping]" value="0" checked="checked" />
                <?php echo @$text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $cat) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" <?php if(in_array($cat['category_id'], $category)) echo 'checked="checked"' ; ?> name="data[category][]" 
                    value="<?php echo $cat['category_id']; ?>" />
                    <?php echo $cat['name']; ?> </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_product; ?></td>
              <td><input type="text" name="product" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div class="scrollbox" id="coupon-product">
                  <?php $class = 'odd'; ?>
                  <?php if(isset($coupon_product)) foreach ($coupon_product as $coupon_product) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="coupon-product<?php echo $coupon_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $coupon_product['name']; ?><img src="<?php echo IMPRESSCART_IMAGES;?>/delete.png" />
                    <input type="hidden" name="data[coupon_product][]" value="<?php echo $coupon_product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo @$entry_date_start; ?></td>
              <td><input type="text" name="data[date_start]" value="<?php echo @$date_start; ?>" size="12" id="date-start" /></td>
            </tr>
            <tr>
              <td><?php echo @$entry_date_end; ?></td>
              <td><input type="text" name="data[date_end]" value="<?php echo @$date_end; ?>" size="12" id="date-end" /></td>
            </tr>
            <tr>
              <td><?php echo @$entry_uses_total; ?></td>
              <td><input type="text" name="data[uses_total]" value="<?php echo @$uses_total; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo @$entry_uses_customer; ?></td>
              <td><input type="text" name="data[uses_customer]" value="<?php echo @$uses_customer; ?>" /></td>
            </tr>
          </table>
        </div>
        
        

<script type="text/javascript">

jQuery(document).ready(function(){
jQuery('input[name=\'data[category][]\']').bind('change', function() {

	var filter_category_id = this;
	jQuery.ajax({
		url: 'admin-ajax.php',
		data: { action : 'framework', fwurl : '/admin/catalog/product_autocomplete_1', filter_category_id : filter_category_id.value }, 
		dataType: 'json',
		success: function(json) {
			
			for (var i = 0; i < json.length; i++) {
				if (jQuery(filter_category_id).attr('checked') == 'checked') {
					jQuery('#coupon-product' + json[i]['product_id']).remove();
					
					jQuery('#coupon-product').append('<div id="coupon-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="<?php echo IMPRESSCART_IMAGES;?>/delete.png" /><input type="hidden" name="data[coupon_product][]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					jQuery('#coupon-product' + json[i]['product_id']).remove();
				}			
			}
			
			jQuery('#coupon-product div:odd').attr('class', 'odd');
			jQuery('#coupon-product div:even').attr('class', 'even');			
		}
	});
});

jQuery('input[name=\'product\']').autocomplete({
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
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		jQuery('#coupon-product' + ui.item.value).remove();
		jQuery('#coupon-product').append('<div id="coupon-product' + ui.item.value + '">' + ui.item.label + '<img src="<?php echo IMPRESSCART_IMAGES;?>/delete.png" /><input type="hidden" name="data[coupon_product][]" value="' + ui.item.value + '" /></div>');
		jQuery('#coupon-product div:odd').attr('class', 'odd');
		jQuery('#coupon-product div:even').attr('class', 'even');
		
		jQuery('input[name=\'product\']').val('');
		
		return false;
	}
});

jQuery('#coupon-product div img').live('click', function() {
	jQuery(this).parent().remove();
	
	jQuery('#coupon-product div:odd').attr('class', 'odd');
	jQuery('#coupon-product div:even').attr('class', 'even');	
});


jQuery('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
jQuery('#date-end').datepicker({dateFormat: 'yy-mm-dd'});

<?php if ($coupon_id) { ?>

jQuery('#history .pagination a').live('click', function() {
	//jQuery('#history').load(this.href);	
	return false;
});			

//jQuery('#history').load('index.php?route=sale/coupon/history&coupon_id=<?php echo @$coupon_id; ?>');
<?php } ?>
});
</script> 