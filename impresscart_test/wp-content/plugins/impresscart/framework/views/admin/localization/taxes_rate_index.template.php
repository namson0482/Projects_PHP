<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo __('Tax Rates');?>
	</h1>
</div>
<?php 
	echo Goscom::generateMenu($pages, 2);
?>
<div class="wrap">
	<h2>
		<a class="add-new-h2"
			href="<?php echo $framework->buildURL('/admin/localization/taxes_rate_edit')?>">Add
			Tax Rate</a>
	</h2>
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
</div>
