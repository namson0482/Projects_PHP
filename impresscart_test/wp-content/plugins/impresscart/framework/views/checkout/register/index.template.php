<div class="left">
  <h2><?php echo $text_your_details; ?></h2>
  <span class="required">*</span> <?php echo $entry_firstname; ?><br />
  <input type="text" name="firstname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_lastname; ?><br />
  <input type="text" name="lastname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_email; ?><br />
  <input type="text" id="email" name="email" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_telephone; ?><br />
  <input type="text" name="telephone" value="" class="large-field" />
  <br />
  <br />
  <?php echo $entry_fax; ?><br />
  <input type="text" name="fax" value="" class="large-field" />
  <br />
  <br />
  <h2><?php echo $text_your_password; ?></h2>
  <span class="required">*</span> <?php echo $entry_password; ?><br />
  <input type="password" name="password" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_confirm; ?> <br />
  <input type="password" name="confirm" value="" class="large-field" />
  <br />
  <br />
  <br />
</div>
<div class="right">
  <h2><?php echo $text_your_address; ?></h2>
  <?php echo $entry_company; ?><br />
  <input type="text" name="company" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_address_1; ?><br />
  <input type="text" name="address_1" value="" class="large-field" />
  <br />
  <br />
  <?php echo $entry_address_2; ?><br />
  <input type="text" name="address_2" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_city; ?><br />
  <input type="text" name="city" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_postcode; ?><br />
  <input type="text" name="postcode" value="" class="large-field" />
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
<div style="clear: both; padding-top: 15px; border-top: 1px solid #EEEEEE;">
  <input type="checkbox" name="newsletter" value="1" id="newsletter" />
  <label for="newsletter"><?php echo $entry_newsletter; ?></label>
  <br />
  <?php if ($shipping_required) { ?>
  <input type="checkbox" name="shipping_address" value="1" id="shipping" checked="checked" />
  <label for="shipping"><?php echo $entry_shipping; ?></label>
  <br />
  <?php } ?>
  <br />
  <br />
</div>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="right"><?php echo $text_agree; ?>
    <input type="checkbox" name="agree" value="1" />
    <a id="button-register" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="right"><a id="button-register" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>
<?php } ?>

<div>
<input type="hidden" name="action" value="framework" />
<input type="hidden" name="fwurl" value="/checkout/register" />
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
	jQuery('#payment-address select[name=\'zone_id\']').load(url,data);
}
var data = {
	action: 'framework',
	fwurl: '/checkout/address/zone',
	country_id : '<?php echo $country_id;?>',
};
var url = "<?php $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; echo admin_url( 'admin-ajax.php', $protocol );?>";
jQuery('#payment-address select[name=\'zone_id\']').load(url,data);
//--></script>
<script type="text/javascript"><!--
/* jQuery('.fancybox').fancybox({
	width: 560,
	height: 560,
	autoDimensions: false
}); */
//--></script> 