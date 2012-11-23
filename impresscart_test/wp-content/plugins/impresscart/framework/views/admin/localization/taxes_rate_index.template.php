<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="wrap">

<table style="border-spacing:0;  border-collapse:collapse;" class="wp-list-table widefat fixed pages">
	<thead>
		<tr>
			<th colspan="2" class="top-title" style="background:#fdfdfd; border: 1px;">
					<h2>
						Tax Rates Management
					</h2>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" class="bt-back" style="background:#f2f2f2;">
				<a class="add-new-h2"
				href="<?php echo $framework->buildURL('/admin/localization/taxes_rate_edit')?>">Add
				Tax Rates</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div>
					<?php if(!empty($taxes)) : ?>
					<table class="wp-list-table widefat fixed pages" cellspacing="0">
						<thead>
							<tr>
								<th width="30">ID</th>
								<th>Tax Name</th>
								<th>Tax Rate</th>
								<th>Type</th>
								<th>Geo Zone</th>
								<th width="100">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($taxes as $tax) : ?>
							<tr>
								<td>#<?php echo $tax->tax_rate_id?>
								</td>
								<td><b><?php echo $tax->name?> </b>
								</td>
								<td><?php echo $tax->rate?>
								</td>
								<td><?php echo $tax->type == 'F' ? 'Fixed Amount' : 'Percentage'?>
								</td>
								<td><?php echo $tax->GeoZone_name?>
								</td>
								<td><a
									href="<?php echo $framework->buildURL('/admin/localization/taxes_rate_edit', array('ID' => $tax->tax_rate_id)) ?>">Edit</a>
									&nbsp;<a
									onclick="return confirm('Are you sure you want to delete this row?')"
									href="<?php echo $framework->buildURL('/admin/localization/taxes_rate_delete', array('ID' => $tax->tax_rate_id)) ?>">Delete</a>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Tax Name</th>
								<th>Tax Rate</th>
								<th>Type</th>
								<th>Geo Zone</th>
								<th>&nbsp;</th>
							</tr>
						</tfoot>
					</table>
					<?php else :?>
					No Tax Class
					<?php endif;?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</div>
