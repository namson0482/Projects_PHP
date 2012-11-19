<div class="impresscart_header">
<h1 class="theme-title"><?php echo $heading;?></h1>
</div>

<div class="message"><?php echo @$message;?></div>
<br/><br/>
<?php 
echo Goscom::generateMenu($pages);
?>
<div>
<form action="" method="post">

<div>
	<label>Title</label>
	<input name="impresscart[shipping_method][flatrate][name]" size="60" value="<?php echo !isset($setting['name']) ? 'Flat rate' : $setting['name'];?>" />
</div>

<div>
	<label style="v-align: middle;">Cost:</label>
	<input name="impresscart[shipping_method][flatrate][cost]" value='<?php echo !isset($setting['cost']) ? '5' : $setting['cost'];?>' />
</div>

<div>
	<label>Tax classes</label>
	<?php echo $tax_classes; ?>
</div>

<div>
	<label>Geo Zones</label>
	<?php echo $geo_zones; ?>
</div>

<div>
	<label>Sort Order</label>
	<input name="impresscart[shipping_method][flatrate][order]" value="<?php echo !isset($setting['order']) ? '5' : $setting['order'];?>" />
</div>

<div>
	<label>Enabled</label>
	<select name="impresscart[shipping_method][flatrate][enabled]" >
		<option value="1" <?php if($setting['enabled'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		<option value="0" <?php if($setting['enabled'] == '0') echo 'selected="selected"'; ?>>No</option>
	</select>
</div>

<div><input type="submit" name="save" value="save" /></div>
<input type="hidden" name="impresscart[shipping_method][flatrate][code]" value="flatrate" />

</form>
</div>