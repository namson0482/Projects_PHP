<table id="post_discounts" class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>Points needed to buy this products</b></td>
			<td><input type="text" name="productpoints[point]" value="<?php echo @$postmeta['point']?>" /></td>
		</tr>
		<tr>
			<th colspan="2"><b>Reward Points</b></th>
		</tr>
		<?php foreach( $groups as $key => $group) : ?>
			<tr>
				<td><?php echo $group;?></td>
				<td><input type="text" name="productpoints[reward][<?php echo $key?>]" value="<?php echo @$postmeta['reward'][$key]; ?>" /></td>
			</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</table>