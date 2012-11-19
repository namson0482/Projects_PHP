<div class="wrap">
	<h2>Options List</h2>
	<div style="padding:5px">
		<?php foreach($classes as $class => $classText):?>
			<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/options/edit', array('class' => $class))?>">Add <?php echo $classText;?> Option</a>
			&nbsp;&nbsp;
		<?php endforeach;?>
	</div>
	<div>
	<?php if(!empty($options)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<th width="30">
					ID
				</th>
				<th>
					Name
				</th>
				
				<th>
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
				<?php foreach($options as $option) : ?>
					<tr>
						<td>
							#<?php echo $option->ID?>
						</td>
						<td>
							<b><?php echo $option->name?></b>
						</td>
						<td>
							<b><?php echo $option->group_name ?></b>
						</td>
						<td>
							<?php echo $classes[$option->class]?>
						</td>
						<td>
							<?php impresscart_option::factory($option->class)->displayAdminMetaInList($option);?>
						</td>
						<td>
							<a href="<?php echo $framework->buildURL('/admin/options/edit', array('ID' => $option->ID)) ?>">Edit</a>
							&nbsp;<a onclick="return confirm('Are you sure you want to delete this row?')" href="<?php echo $framework->buildURL('/admin/options/delete', array('ID' => $option->ID)) ?>">Delete</a>
						</td>
					</tr>
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
		No Options
	<?php endif;?>
	</div>
</div>