<?php if(!empty($options)) : ?>
	<script language="javascript">
		jQuery(function(){
			jQuery('#productoptions_metabox_wrap').delegate('.showhide', 'click', function(){
				var next = jQuery(this).closest('tr').next();
				if(next.is(':visible')){
					next.hide();
				} else {
					next.show();
				}
			});
		});
	</script>
	<table id="productoptions_metabox_wrap" class="wp-list-table widefat fixed pages" cellspacing="0">
	<?php foreach($options as $option) : ?>
		<tr class="optiongroup<?php echo $option->group; ?>" style="<?php echo !in_array($option->group,$productgroups) ? 'display: none;' : ''; ?>" >
			<td>
				<p>
					<a class="add-new-h2 showhide" href="#randomize">
					<b><?php echo $option->name?></b>
					</a>
					<label><input type="checkbox" onclick="CheckProductOptions(<?php echo $option->ID;?>)" name="productoptions[<?php echo $option->ID?>][used]" <?php echo @$postmeta[$option->ID]['used'] ? 'checked="checked"' : ''?> value="1" /> Use</label>
					<label><input type="checkbox" name="productoptions[<?php echo $option->ID?>][required]" <?php echo @$postmeta[$option->ID]['required'] ? 'checked="checked"' : ''?> value="1"/> Mandatory</label>
				</p>
			</td>
		</tr>
		<tr class="optiongroup<?php echo $option->group; ?>" style="<?php echo !in_array($option->group,$productgroups) ? 'display: none;' : ''; ?>" >
			<td>
				<?php impresscart_option::factory($option->class)->displayPostMetaInMetaBox($postmeta, $option);?>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php else:?>
	No options defined.
<?php endif;?>