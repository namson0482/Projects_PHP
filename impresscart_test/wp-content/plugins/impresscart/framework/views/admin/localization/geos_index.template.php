<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo __('Geo Zones');?>
	</h1>
</div>
<?php 
	echo Goscom::generateMenu($pages, 2);
?>
<div class="wrap">
	<h2>
		<a class="add-new-h2"
			href="<?php echo $framework->buildURL('/admin/localization/geos_edit')?>">Add
			Geo Zone</a>
	</h2>
	<div>
	<?php if(!empty($geos)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th width="30">ID</th>
					<th>Name</th>
					<th>Description</th>
					<th width="100">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($geos as $geo) : ?>
				<tr>
					<td>#<?php echo $geo->geo_zone_id; ?>
					</td>
					<td><b><?php echo $geo->name; ?> </b>
					</td>
					<td><?php echo $geo->description; ?>
					</td>
					<td><a
						href="<?php echo $framework->buildURL('/admin/localization/geos_edit', array('ID' => $geo->geo_zone_id)) ?>">Edit</a>
						&nbsp;<a
						onclick="return confirm('Are you sure you want to delete this row?')"
						href="<?php echo $framework->buildURL('/admin/localization/geos_delete', array('ID' => $geo->geo_zone_id)) ?>">Delete</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Descrition</th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
		<?php else :?>
		No Geo Zone
		<?php endif;?>
	</div>
</div>
