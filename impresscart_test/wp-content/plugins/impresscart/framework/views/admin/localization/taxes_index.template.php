<?php 
	echo Goscom::generateHeader($pages);
?>
<div class="wrap">
	<h2>
		<a class="add-new-h2"
			href="<?php echo $framework->buildURL('/admin/localization/taxes_edit')?>">Add
			Tax Class</a>
	</h2>
	<div>
	<?php if(!empty($taxes)) : ?>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th width="30">ID</th>
					<th>Title</th>
					<th>Description</th>
					<th width="100">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($taxes as $tax) : ?>
				<tr>
					<td>#<?php echo $tax->tax_class_id?>
					</td>
					<td><b><?php echo $tax->title?> </b>
					</td>
					<td><?php echo $tax->description?>
					</td>
					<td><a
						href="<?php echo $framework->buildURL('/admin/localization/taxes_edit', array('ID' => $tax->tax_class_id)) ?>">Edit</a>
						&nbsp;<a
						onclick="return confirm('Are you sure you want to delete this row?')"
						href="<?php echo $framework->buildURL('/admin/localization/taxes_delete', array('ID' => $tax->tax_class_id)) ?>">Delete</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Descrition</th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
		<?php else :?>
		No Tax Class
		<?php endif;?>
	</div>
</div>
