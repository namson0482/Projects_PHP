<?php if ($addresses) { ?>
<input type="radio" name="<?php echo $type; ?>_address" value="existing" id="<?php echo $type; ?>-address-existing" checked="checked" />
<label for="<?php echo $type; ?>-address-existing"><?php echo $text_address_existing; ?></label>
<div id="<?php echo $type; ?>-existing">
  <select name="address_id" style="width: 100%; margin-bottom: 15px;" size="5">
    <?php foreach ($addresses as $address) { ?>
    <?php if ($address['address_id'] == $address_id) { ?>
    <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['country']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['country']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
</div>
<?php } ?>
<p>
  <input type="radio" name="<?php echo $type; ?>_address" value="new" id="<?php echo $type; ?>-address-new" />
  <label for="<?php echo $type; ?>-address-new"><?php echo $text_address_new; ?></label>
</p>
<div id="<?php echo $type; ?>-new" style="display: none;">
  <table class="form">
    <tr>
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
      <td><input type="text" name="lastname" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_company; ?></td>
      <td><input type="text" name="company" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
      <td><input type="text" name="address_1" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_address_2; ?></td>
      <td><input type="text" name="address_2" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_city; ?></td>
      <td><input type="text" name="city" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_country; ?></td>
      <td><select name="country_id" class="large-field" onchange="changeCountry();">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($countries as $country) { 
          	$country = (array)$country; ?>
          <?php if ($country['country_id'] == $country_id) { ?>
          <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
      <td><select name="zone_id" class="large-field">
        </select></td>
    </tr>
  </table>
</div>
<div>
	<input type="hidden" name="action" value="framework" />
	<input type="hidden" name="fwurl" value="/checkout/address/validatePaymentAddress" />	
</div>
<br />
<div class="buttons">
  <div class="right"><a id="button-address" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>
<script type="text/javascript"><!--

function changeCountry() {
	
	var data = { action : 'framework', fwurl : '/checkout/address/zone', country_id : jQuery('select[name=\'country_id\']').val() }
	jQuery('#<?php echo $type; ?>-address select[name=\'zone_id\']').load(impresscart.ajaxurl, data);
	
}

var data = { action : 'framework', fwurl : '/checkout/address/zone', country_id : '<?php echo $country_id;?>' }
jQuery('#<?php echo $type; ?>-address select[name=\'zone_id\']').load(impresscart.ajaxurl, data);

jQuery('#<?php echo $type; ?>-address input[name=\'<?php echo $type; ?>_address\']').live('change', function() {
	if (this.value == 'new') {
		jQuery('#<?php echo $type; ?>-existing').hide();
		jQuery('#<?php echo $type; ?>-new').show();
	} else {
		jQuery('#<?php echo $type; ?>-existing').show();
		jQuery('#<?php echo $type; ?>-new').hide();
	}
});
//--></script> 