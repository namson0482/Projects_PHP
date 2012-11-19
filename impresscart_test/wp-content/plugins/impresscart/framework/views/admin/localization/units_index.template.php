<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="wrap">
	<h2>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/localization/units_edit')?>"><?php echo __('Add Unit', 'impressthemes'); ?></a>
	</h2>
	<div>
	<?php if(!empty($list)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th>
						ID
					</th>
					<th>
						<?php echo __('Title', 'impressthemes');?>
					</th>
					<th>
						<?php echo __('Unit', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Value', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Type', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Edit/Delete','impressthemes')?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $row) : ?>
					<tr>
						<td>
							#<?php echo $row->unit_id?>
						</td>
						<td>
							<b><?php echo $row->title?></b>
						</td>
						<td>
							<?php echo $row->unit?>
						</td>
						<td>
							<?php echo $row->value?>
						</td>
						<td>
							<?php echo $row->type;?>
						</td>
						<td>
							<a href="<?php echo $framework->buildURL('/admin/localization/units_edit', array('ID' => $row->unit_id)) ?>">Edit</a>
							&nbsp;<a onclick="return confirm('Are you sure you want to delete this row?')" href="<?php echo $framework->buildURL('/admin/localization/units_delete', array('ID' => $row->unit_id)) ?>">Delete</a>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th>
						ID
					</th>
					<th>
						<?php echo __('Title', 'impressthemes');?>
					</th>
					<th>
						<?php echo __('Unit', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Value', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Type', 'impressthemes'); ?>
					</th>
					<th>
						<?php echo __('Edit/Delete','impressthemes')?>
					</th>
				</tr>
			</tfoot>
		</table>
	<?php else :?>
		<?php echo __('There is no measurement unit.');?>
	<?php endif;?>
	</div>
</div>