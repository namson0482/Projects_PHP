<table class="form">
  <tr>
    <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
    <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
    <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><?php echo $entry_company; ?></td>
    <td><input type="text" name="company" value="<?php echo $company; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
    <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><?php echo $entry_address_2; ?></td>
    <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_city; ?></td>
    <td><input type="text" name="city" value="<?php echo $city; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
    <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" class="large-field" /></td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_country; ?></td>
    <td>
    <select name="country_id" class="large-field" onchange="changeCountry();">
    <option value=""><?php echo $text_select; ?></option>
    <?php foreach ($countries as $country) { 
    	$country = (array)$country;    	
    	?>
    <?php if ($country['country_id'] == $country_id) { ?>
    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
      
      </td>
  </tr>
  <tr>
    <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
    <td><select name="zone_id" class="large-field">
      </select></td>
  </tr>
</table>
<br />
<div>
	<input type="hidden" name="action" value="framework" />
	<input type="hidden" name="fwurl" value="/checkout/guestshipping/validateShippingAddress" />	
</div>
<div class="buttons">
  <div class="right"><a id="button-guest-shipping" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>
<script type="text/javascript">
<!--
function changeCountry()
{
	var data = {
		action: 'framework',
		fwurl: '/checkout/address/zone',
		country_id : jQuery('select[name=\'country_id\']').val()
	};
	var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
	jQuery('#shipping-address select[name=\'zone_id\']').load(url,data);
}
var data = {
	action: 'framework',
	fwurl: '/checkout/address/zone',
	country_id : '<?php echo $country_id;?>',
	zone_id : '<?php echo $zone_id;?>',
};
var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
jQuery('#shipping-address select[name=\'zone_id\']').load(url,data);
//--></script>
<script type="text/javascript"><!--
/* jQuery('.fancybox').fancybox({
	width: 560,
	height: 560,
	autoDimensions: false
}); */
//--></script>  