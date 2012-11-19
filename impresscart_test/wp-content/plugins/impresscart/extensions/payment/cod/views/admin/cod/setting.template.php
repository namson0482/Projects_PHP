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
	<input name="impresscart[payment_method][cod][name]" size="60" value="<?php echo !isset($setting['name']) ? 'cod' : $setting['name'];?>" />
</div>

<div>
	<label style="v-align: middle;">Total:</label>
	<input name="impresscart[payment_method][cod][total]" value="<?php echo !isset($setting['total']) ? '0.01' : $setting['total'];?>" />
</div>

<div>
	<label>Order status</label>
	<?php echo @$order_statuses; ?>
</div>

<div>
	<label>Geo Zones</label>
	<?php echo $geo_zones; ?>
</div>

<div>
	<label>Sort Order</label>
	<input name="impresscart[payment_method][cod][order]" value="<?php echo !isset($setting['order']) ? '5' : $setting['order'];?>" />
</div>

<div>
	<label>Enabled</label>
	<select name="impresscart[payment_method][cod][enabled]" >
		<option value="yes" <?php if($setting['enabled'] == 'yes') echo 'selected="selected"'; ?>>Yes</option>
		<option value="no" <?php if($setting['enabled'] == 'no') echo 'selected="selected"'; ?>>No</option>
	</select>
</div>

<div><input type="submit" name="save" value="save" /></div>
<input type="hidden" name="impresscart[payment_method][cod][code]" value="cod" />

</form>
</div>