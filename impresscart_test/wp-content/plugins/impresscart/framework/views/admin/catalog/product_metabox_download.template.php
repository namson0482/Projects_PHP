<div>&nbsp;</div>
<table class="widefat" border="0">
<tr><td>
<table id="post_download_products" class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2">Downloadable files</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($downloads as $download) : ?>
			<tr>
				<td colspan="2"><input style="min-height:inherit;" type="checkbox" name="productdownloads[]"
					value="<?php echo $download->download_id?>"
					<?php echo in_array($download->download_id, (array)$postmeta) ? 'checked="checked"' : '';?> />
				<?php echo $download->name?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</table>
</td></tr>
</table>