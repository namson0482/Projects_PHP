<div class="wrap">
	<h2>Attributes List</h2>
	<div style="padding:5px">
		<?php foreach($classes as $class => $classText):?>
		<?php if($class != 'group') { ?>
			<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/attributes/edit', array('class' => $class))?>">Add <?php echo $classText;?> <?php echo $class == 'group' ? '' : 'Attribute'?></a>
			&nbsp;&nbsp;
		<?php } else { ?>
			<a class="add-new-h2" href="<?php echo 'edit-tags.php?taxonomy=product_group&post_type=product'; ?>">Add <?php echo $classText;?> <?php echo $class == 'group' ? '' : 'Attribute'?></a>
		<?php } ?>
		<?php endforeach;?>
		
	</div>
	<div>
	<?php if(!empty($attributes)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<th width="30">
					ID
				</th>
				<th>
					Name
				</th>
				<th width="80">
					Group
				</th>
				<th width="100">
					Class
				</th>
				<th>
					Meta
				</th>
				<th width="100">
					&nbsp;
				</th>
			</thead>
			<tbody>
				<?php foreach($attributes as $group) : ?>
					<?php $option = @$group['group']?>
					<?php if(!empty($option->ID)) : ?>
						<tr>
							<td>
								#<?php echo $option->ID?>
							</td>
							<td>
								<b><?php echo $option->group_name?></b>
							</td>
							<td>
								-
							</td>
							<td>
								<?php echo $classes[$option->class]?>
							</td>
							<td>
								<?php impresscart_attribute::factory($option->class)->displayAdminMetaInList($option);?>
							</td>
							<td>
								<a href="<?php echo $framework->buildURL('/admin/attributes/edit', array('ID' => $option->ID)) ?>">Edit</a>
								&nbsp;<a onclick="return confirm('Are you sure you want to delete this row?')" href="<?php echo $framework->buildURL('/admin/attributes/delete', array('ID' => $option->ID)) ?>">Delete</a>
							</td>
						</tr>
					<?php endif;?>
					<?php foreach($group['attributes'] as $option) : ?>
						<tr>
							<td>
								#<?php echo $option->ID?>
							</td>
							<td>
								<?php echo $option->group_id ? '--- ' : ''?><?php echo $option->name?>
							</td>
							<td>
								<?php echo $option->group_id ? $option->group_name : '-'?>
							</td>
							<td>
								<?php echo $classes[$option->class]?>
							</td>
							<td>
								<?php impresscart_attribute::factory($option->class)->displayAdminMetaInList($option);?>
							</td>
							<td>
								<a href="<?php echo $framework->buildURL('/admin/attributes/edit', array('ID' => $option->ID)) ?>">Edit</a>
								&nbsp;<a onclick="return confirm('Are you sure you want to delete this row?')" href="<?php echo $framework->buildURL('/admin/attributes/delete', array('ID' => $option->ID)) ?>">Delete</a>
							</td>
						</tr>
					<?php endforeach;?>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<th>
					ID
				</th>
				<th>
					Name
				</th>
				<th>
					Group
				</th>
				<th>
					Class
				</th>
				<th>
					Meta
				</th>
				<th>
					&nbsp;
				</th>
			</tfoot>
		</table>
	<?php else :?>
		No Attributes
	<?php endif;?>
	</div>
</div>