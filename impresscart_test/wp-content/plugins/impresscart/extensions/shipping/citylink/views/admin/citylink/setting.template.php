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
	<input name="impresscart[shipping_method][citylink][citylink_name]" size="60" value="<?php echo !isset($setting['name']) ? 'Citylink' : $setting['citylink_name'];?>" />
</div>

<div>
	<label style="v-align: middle;">Citylink Rates:</label>
	<textarea name="impresscart[shipping_method][citylink][citylink_rate]" rows="5" cols="40" ><?php echo !isset($setting['citylink_total']) ? '10:11.6,15:14.1,20:16.60,25:19.1,30:21.6,35:24.1,40:26.6,45:29.1,50:31.6,55:34.1,60:36.6,65:39.1,70:41.6,75:44.1,80:46.6,100:56.6,125:69.1,150:81.6,200:106.6' : $setting['citylink_rate'];?></textarea>
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
	<input name="impresscart[shipping_method][citylink][citylink_order]" value="<?php echo !isset($setting['citylink_order']) ? '5' : $setting['citylink_order'];?>" />
</div>

<div>
	<label>Enabled</label>
	<select name="impresscart[shipping_method][citylink][enabled]" >
		<option value="1" <?php if($setting['enabled'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		<option value="0" <?php if($setting['enabled'] == '0') echo 'selected="selected"'; ?>>No</option>
	</select>
</div>

<div><input type="submit" name="save" value="save" /></div>
<input type="hidden" name="impresscart[shipping_method][citylink][code]" value="citylink" />

</form>
</div>