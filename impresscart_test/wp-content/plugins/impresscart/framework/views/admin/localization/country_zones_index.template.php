<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo __('Country Zones');?>
	</h1>
</div>
<?php 
	echo Goscom::generateMenu($pages, 2);
?>
<div class="wrap">
	<h2>
		<a class="add-new-h2"
			href="<?php echo $framework->buildURL('/admin/localization/country_zones_edit')?>">Add
			Zone</a>
	</h2>
	<div>
	<?php if(!empty($country_zones)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th width="30">ID</th>
					<th>Name</th>
					<th width="100">Code</th>
					<th>Country</th>
					<th>Status</th>
					<th width="100">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($country_zones as $zone) : ?>
				<tr>
					<td>#<?php echo $zone->zone_id?>
					</td>
					<td><b><?php echo $zone->name?> </b>
					</td>
					<td><?php echo $zone->code?>
					</td>
					<td><?php echo @$countries[$zone->country_id]->name?>
					</td>
					<td><?php echo $zone->status ? 'Enabled' : 'Disabled'?>
					</td>
					<td><a
						href="<?php echo $framework->buildURL('/admin/localization/country_zones_edit', array('ID' => $zone->zone_id)) ?>">Edit</a>
						&nbsp;<a
						onclick="return confirm('Are you sure you want to delete this row?')"
						href="<?php echo $framework->buildURL('/admin/localization/country_zones_delete', array('ID' => $zone->zone_id)) ?>">Delete</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Code</th>
					<th>Country</th>
					<th>Status</th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
		<?php echo $this->paginate->render('/admin/localization/country_zones_index')?>
		<?php else :?>
		No country zone
		<?php endif;?>
	</div>
</div>
