<?php if (!empty($attributes)) : ?>
	<table id="productgeneralattributes_metabox_wrap" border="0" cellspacing="0">
	<?php foreach($attributes as $group) : ?>
		<?php $option = @$group['group']?>
		<?php if(!empty($option->ID)) : ?>
		<tr>
			<td>
				<b><?php echo $option->name?></b>
			</td>
		</tr>
		<?php endif;?>
		<tr style="">
			<td>
				<table class="" cellspacing="0">
					<tbody>
					<?php foreach($group['attributes'] as $option) : ?>
						<?php if(impresscart_attribute::factory($option->class)->hasPostMetaInMetaBox($postmeta, $option)) : ?>
						<tr>
							<td><?php echo $option->name?></td>
							<td>
								<?php impresscart_attribute::factory($option->class)->displayPostMetaInProductDetail($postmeta, $option);?>
							</td>
						</tr>
						<?php endif;?>
					<?php endforeach;?>
					</tbody>
				</table>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php else :?>
	No attribute defined for this product
<?php endif;?>