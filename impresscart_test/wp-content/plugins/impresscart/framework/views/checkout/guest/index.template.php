<div class="left">
  <h2><?php echo $text_your_details; ?></h2>
  <span class="required">*</span> <?php echo $entry_firstname; ?><br />
  <input type="text" name="firstname" value="<?php echo @$firstname; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_lastname; ?><br />
  <input type="text" name="lastname" value="<?php echo @$lastname; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_email; ?><br />
  <input type="text" id="email" name="email" value="<?php echo @$email; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_telephone; ?><br />
  <input type="text" name="telephone" value="<?php echo @$telephone; ?>" class="large-field" />
  <br />
  <br />
  <?php echo $entry_fax; ?><br />
  <input type="text" name="fax" value="<?php echo @$fax; ?>" class="large-field" />
  <br />
  <br />
</div>
<div class="right">
  <h2><?php echo @$text_your_address; ?></h2>
  <?php echo @$entry_company; ?><br />
  <input type="text" name="company" value="<?php echo @$company; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo @$entry_address_1; ?><br />
  <input type="text" name="address_1" value="<?php echo @$address_1; ?>" class="large-field" />
  <br />
  <br />
  <?php echo $entry_address_2; ?><br />
  <input type="text" name="address_2" value="<?php echo @$address_2; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_city; ?><br />
  <input type="text" name="city" value="<?php echo @$city; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_postcode; ?><br />
  <input type="text" name="postcode" value="<?php echo @$postcode; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_country; ?><br />
  
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
  
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_zone; ?><br />
  <select name="zone_id" class="large-field">
  </select>
  <br />
  <br />
  <br />
</div>
<?php if ($shipping_required) { ?>
<div style="clear: both; padding-top: 15px; border-top: 1px solid #DDDDDD;">
  <?php if ($shipping_address) { ?>
  <input type="checkbox" name="shipping_address" value="1" id="shipping" checked="checked" />
  <?php } else { ?>
  <input type="checkbox" name="shipping_address" value="1" id="shipping" />
  <?php } ?>
  <label for="shipping"><?php echo $entry_shipping; ?></label>
  <br />
  <br />
  <br />
</div>
<?php } ?>
<div>
	<input type="hidden" name="action" value="framework" />
	<input type="hidden" name="fwurl" value="/checkout/guest/validatePaymentAddress" />	
</div>
<div class="buttons">
  <div class="right"><a id="button-guest" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>
<script type="text/javascript">
<!--
function changeCountry()
{
	var data = {
		action: 'framework',
		fwurl : '/checkout/address/zone',
		country_id : jQuery('select[name=\'country_id\']').val()
	};
	var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
	
	jQuery('#payment-address select[name=\'zone_id\']').load(url,data);
	
}
var data = {
	action: 'framework',
	fwurl: '/checkout/address/zone',
	country_id : '<?php echo $country_id;?>',
};
var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
jQuery('#payment-address select[name=\'zone_id\']').load(url, data);
//--></script>
<script type="text/javascript"><!--
/* jQuery('.fancybox').fancybox({
	width: 560,
	height: 560,
	autoDimensions: false
}); */
//--></script> 