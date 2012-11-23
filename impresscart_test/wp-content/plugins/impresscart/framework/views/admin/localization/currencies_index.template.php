<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="wrap">

	<table style="border-spacing:0;  border-collapse:collapse;" class="wp-list-table widefat fixed pages">
		<thead>
			<tr>
				<th colspan="2" class="top-title" style="background:#fdfdfd; border: 1px;">
						<h2>
							Currency Management
						</h2>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2" class="bt-back" style="background:#f2f2f2;">
					<a class="add-new-h2"
					href="<?php echo $framework->buildURL('/admin/localization/currencies_edit')?>">Add Currency</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
					<?php if(!empty($list)) : ?>
						<table class="wp-list-table widefat fixed pages" cellspacing="0">
							<thead>
								<tr>
									<th>ID</th>
									<th><?php echo __('Title', 'impressthemes');?>
									</th>
									<th><?php echo __('Code', 'impressthemes'); ?>
									</th>
									<th><?php echo __('Value', 'impressthemes'); ?>
									</th>
									<th><?php echo __('Status', 'impressthemes'); ?>
									</th>
									<th><?php echo __('Last modified', 'impressthemes'); ?>
									</th>
									<th><?php echo __('Edit/Delete','impressthemes')?>
									</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($list as $row) : ?>
								<tr>
									<td>#<?php echo $row->currency_id?>
									</td>
									<td><b><?php echo $row->title?> </b>
									</td>
									<td><?php echo $row->code?>
									</td>
									<td><?php echo $row->value?>
									</td>
				
									<td><?php echo $row->status == '1' ? 'Enabled' : 'Disabled';?>
									</td>
				
									<td><?php echo $row->date_modified;?>
									</td>
				
									<td><a
										href="<?php echo $framework->buildURL('/admin/localization/currencies_edit', array('ID' => $row->currency_id)) ?>">Edit</a>
										&nbsp;<a
										onclick="return confirm('Are you sure you want to delete this row?')"
										href="<?php echo $framework->buildURL('/admin/localization/currencies_delete', array('ID' => $row->currency_id)) ?>">Delete</a>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
							<tfoot>
								<tr>
									<th>ID</th>
									<th><?php echo __('Title', 'impressthemes');?>
									</th>
									<th><?php echo __('Unit', 'impressthemes'); ?>
									</th>
									<th><?php echo __('Code', 'impressthemes'); ?>
									</th>
				
									<th><?php echo __('Status', 'impressthemes'); ?>
									</th>
				
									<th><?php echo __('Last modified', 'impressthemes'); ?>
									</th>
				
									<th><?php echo __('Edit/Delete','impressthemes')?>
									</th>
								</tr>
							</tfoot>
						</table>
						<?php else :?>
						<?php echo __('There is no currency.');?>
						<?php endif;?>
					</div>
				</td>
			</tr>
		</tbody>
</table>


					
</div>
