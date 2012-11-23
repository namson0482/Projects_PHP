<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="wrap">

<table style="border-spacing:0;  border-collapse:collapse;" class="wp-list-table widefat fixed pages">
		<thead>
			<tr>
				<th colspan="2" class="top-title" style="background:#fdfdfd; border: 1px;">
						<h2>
							Zone Management
						</h2>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2" class="bt-back" style="background:#f2f2f2;">
					<a class="add-new-h2"
					href="<?php echo $framework->buildURL('/admin/localization/country_zones_edit')?>">Add
					Country Zone</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
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
				</td>
			</tr>
		</tbody>
</table>
			
</div>
