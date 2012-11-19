<?php if(!empty($attributes)) : ?>
	<script language="javascript">
		jQuery(function(){
			jQuery('#productgeneralattributes_metabox_wrap').delegate('.showhide', 'click', function(){
				var next = jQuery(this).closest('tr').next();
				if(next.is(':visible')){
					next.hide();
				} else {
					next.show();
				}
			});
			jQuery('.date_attribute').datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
		<script>
           jQuery.noConflict();
			jQuery(function($){ 
				$('a.imcart_tooltip').aToolTip({
		    		clickIt: true,
		    		tipContent: 'Hello I am aToolTip with content from the "tipContent" param'
				});
				$("li a.removetooltip").bind('click', function() {
					$(this).parents('body').find('#aToolTip').css("display", "none");
				});
				$("h3.group_option a.removetooltip").bind('click', function() {
					$(this).parents('body').find('#aToolTip').css("display", "none");
				});		
			});(jQuery);
		
        </script>

	<table id="productgeneralattributes_metabox_wrap" class="widefat" border="0">
	<?php foreach($attributes as $group) : ?>
		<?php $option = @$group['group']?>
		<?php if(!empty($option->ID)) : ?>
		<tr>
			<td>
				<p><a class="add-new-h2 showhide" href="#randomize"><b><?php echo $option->name?></b></a></p>
			</td>
		</tr>
		<?php endif;?>
		<tr style="<?php echo !empty($option->ID) ? 'display:none' : ''?>">
			<td>
				<table class="wp-list-table widefat fixed pages" cellspacing="0">
					<thead>
						<tr>
							<th width="200">Attribute</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($group['attributes'] as $option) : ?>
						<tr>
							<td><?php echo $option->name?></td>
							<td>
								<?php impresscart_attribute::factory($option->class)->displayPostMetaInMetaBox($postmeta, $option);?><a class="imcart_tooltip" title="<?php echo $option->description?>"></a>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<th>Attribute</th>
							<th>Value</th>
						</tr>
					</tfoot>
				</table>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php else:?>
	No attributes defined.
<?php endif;?>