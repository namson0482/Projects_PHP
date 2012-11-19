<div class="wrap">
	<h2>Downloads
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/catalog/download_edit')?>">Add Download</a>
	</h2>
	<div>
	<?php if(!empty($downloads)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<th width="30">
					ID
				</th>
				<th>
					Name
				</th>
				<th>
					Remaining
				</th>
				<th width="100">
					&nbsp;
				</th>
			</thead>
			<tbody>
				<?php foreach($downloads as $download) : ?>
					<tr>
						<td>
							#<?php echo $download->download_id; ?>
						</td>
						<td>
							<b><?php echo $download->name?></b>
						</td>
						<td>
							<?php echo $download->remaining?>
						</td>
						<td>
							<a href="<?php echo $framework->buildURL('/admin/catalog/download_edit', array('ID' => $download->download_id)) ?>">Edit</a>
							&nbsp;<a onclick="return confirm('Are you sure you want to delete this row?')" href="<?php echo $framework->buildURL('/admin/catalog/download_delete', array('ID' => $download->download_id)) ?>">Delete</a>
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
					Remaining
				</th>
				<th width="100">
					&nbsp;
				</th>
			</tfoot>
		</table>
	<?php else :?>
		No Download
	<?php endif;?>
	</div>
</div>