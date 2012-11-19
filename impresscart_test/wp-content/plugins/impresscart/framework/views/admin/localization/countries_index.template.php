<div class="impresscart_header">
	<h1 class="theme-title">
	<?php echo __('Countries');?>
	</h1>
</div>

<?php 
	echo Goscom::generateMenu($pages, 2);
?>

<div class="wrap">
	<h2>
		<a class="add-new-h2"
			href="<?php echo $framework->buildURL('/admin/localization/countries_edit')?>">Add
			Country</a>
	</h2>
	<div>
	<?php if(!empty($countries)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th width="30">ID</th>
					<th>Name</th>
					<th width="100">ISO2</th>
					<th>ISO3</th>
					<th>Status</th>
					<th width="100">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($countries as $country) : ?>
				<tr>
					<td>#<?php echo $country->country_id; ?>
					</td>
					<td><b><?php echo $country->name?> </b>
					</td>
					<td><?php echo $country->iso_code_2?>
					</td>
					<td><?php echo $country->iso_code_3?>
					</td>
					<td><?php echo $country->status ? 'Enabled' : 'Disabled'?>
					</td>
					<td><a
						href="<?php echo $framework->buildURL('/admin/localization/countries_edit', array('ID' => $country->country_id)) ?>">Edit</a>
						&nbsp;<a
						onclick="return confirm('Are you sure you want to delete this row?')"
						href="<?php echo $framework->buildURL('/admin/localization/countries_delete', array('ID' => $country->country_id)) ?>">Delete</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>ISO2</th>
					<th>ISO3</th>
					<th>Status</th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>

		<?php $this->paginate->render('/admin/localization/countries_index')?>
		<?php else :?>
		No Country
		<?php endif;?>
	</div>
</div>
