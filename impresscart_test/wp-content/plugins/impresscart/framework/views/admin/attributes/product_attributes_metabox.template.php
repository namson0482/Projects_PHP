<?php if(!empty($attributes)) : ?>
	<script language="javascript">
		jQuery(function(){
			jQuery('#productattributes_metabox_wrap').delegate('.showhide', 'click', function(){
				var next = jQuery(this).closest('tr').next();
				if(next.is(':visible')){
					next.hide();
				} else {
					next.show();
				}
			});
		});
                function loadattribute( id ) {
                    //jQuery('.attributegroup' + id).toggle();                    
                    if(jQuery('#group' + id).attr('checked') == 'checked')
                    {
                        jQuery('.optiongroup' + id).show();
                        jQuery('.attributegroup' + id).show();
                        
                    } else {
                        jQuery('.optiongroup' + id).hide();
                        jQuery('.attributegroup' + id).hide();
                        jQuery('.attributegroup' + id + ' input').val('');
                        jQuery('.attributegroup' + id + ' select').val('');
                    }
                }
	</script>
        <ul>
        <?php
            if($groups) { 
	            foreach($groups as $gr) {
	                $checked = in_array($gr->term_id, $productgroups) ? "checked='checked'" : '';
	                echo "<li style='float: left; padding: 5px;'><input type='checkbox' name='product_group[]' id='group".$gr->term_id."' ". $checked ." onclick='loadattribute(" . $gr->term_id . ");' value='". $gr->term_id ."' />" . $gr->name . "</li>";
	            }
            }
        ?>
        </ul>
	<table id="productattributes_metabox_wrap" class="wp-list-table widefat fixed pages" cellspacing="0">
	<?php foreach($attributes as $id => $group) : ?>
		<?php $option = @$group['group']?>
		<?php if(!empty($option->ID)) : ?>
		<tr>
			<td>
				<p><a class="add-new-h2 showhide" href="#randomize"><b><?php echo $option->name?></b></a></p>
			</td>
		</tr>
		<?php endif;?>
		<?php if(!empty($group['attributes'])) : ?>
		<tr style="<?php echo !empty($option->ID) ? 'display:none;' : ''; echo !in_array($id,$productgroups) ? 'display: none;' : ''; ?>" class="attributegroup<?php echo $id; ?>" >
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
								<?php impresscart_attribute::factory($option->class)->displayPostMetaInMetaBox($postmeta, $option);?>
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
		<?php endif;?>
	<?php endforeach;?>
	</table>
<?php else:?>
	No attributes defined.
<?php endif;?>