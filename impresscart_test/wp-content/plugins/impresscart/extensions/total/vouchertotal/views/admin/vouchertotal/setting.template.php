<?php 
include IMPRESSCART_CLASSES . '/impresscart-menu.php';

if ($error_warning) {
	echo "<div class='warning'>".$error_warning."</div>";
}
?>
<div class="content">
	<form action="" method="post" enctype="multipart/form-data" id="form">

		<table style="border-spacing: 0; border-collapse: collapse;"
			class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th colspan="2" class="top-title"
						style="background: #fdfdfd; border: 1px;">
						<h2>
							<?php echo $heading;?>
						</h2>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><input type="button" name="backtolist"
						id="backtolist" class="button" value="Back to list" /> . <input
						type="hidden" id="backaddress" name="backaddress"
						value="<?php echo(get_bloginfo('url') . '/wp-admin/' . 'admin.php?page=total');?>">
					</td>
				</tr>
				<tr>
					<td class='widefat_extend'><?php echo $entry_status; ?>
					</td>
					<td class='widefat_extend'><select name="status">
							<?php if ($voucher_status) { ?>
							<option value="1" selected="selected">
								<?php echo $text_enabled; ?>
							</option>
							<option value="0">
								<?php echo $text_disabled; ?>
							</option>
							<?php } else { ?>
							<option value="1">
								<?php echo $text_enabled; ?>
							</option>
							<option value="0" selected="selected">
								<?php echo $text_disabled; ?>
							</option>
							<?php } ?>
					</select>
					</td>
				</tr>

				<tr>
					<td class='widefat_extend'><?php echo $entry_order; ?>
					</td>

					<td class='widefat_extend'><input type="text" name="order"
						value="<?php echo $voucher_order; ?>" size="1" />
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<div class="buttons">
							<a onclick="jQuery('#form').submit();" class="button"><?php echo $button_save; ?>
							</a><a onclick="location = '<?php echo $cancel; ?>';"
								class="button"><?php echo $button_cancel; ?> </a>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- ************************** -->

	</form>
</div>

<script type="text/javascript"><!--

jQuery('#backtolist').bind('click', function() {
	  //alert('User clicked on "foo."');
	  //window.history.back(-1);
	  window.location.href = jQuery('#backaddress').val();
	  return false;
});

//--></script>
