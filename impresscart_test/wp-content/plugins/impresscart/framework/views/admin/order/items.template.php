
<table id="product" class="list">
	<thead>
		<tr>
			<td class="left"><?php echo $column_product; ?>
			</td>
			<td class="left"><?php echo $column_model; ?>
			</td>
			<td class="right"><?php echo $column_quantity; ?>
			</td>
			<td class="right"><?php echo $column_price; ?>
			</td>
			<td class="right"><?php echo $column_total; ?>
			</td>
		</tr>
	</thead>
	<?php if(isset($products) && count($products)) foreach ($products as $product) { ?>
	<tbody id="product-row<?php echo $product['product_id']; ?>">
		<tr>
			<td class="left"><?php if ($product['product_id']) { ?> <a
				href="<?php echo get_permalink($product['product_id']); ?>"><?php echo $product['name']; ?>
			</a> <?php } else { ?> <?php echo $product['name']; ?> <?php } ?> <?php foreach ($product['option'] as $option) { ?>
				<br /> <?php if ($option['type'] != 'file') { ?> &nbsp;<small> - <?php echo $option['name']; ?>:
				<?php echo $option['value']; ?>
			</small> <?php } else { ?> &nbsp;<small> - <?php echo $option['name']; ?>:
					<a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?>
				</a>
			</small> <?php } ?> <?php } ?>
			</td>
			<td class="left"><?php echo $product['model']; ?>
			</td>
			<td class="right"><?php echo $product['quantity']; ?>
			</td>
			<td class="right"><?php echo $product['price']; ?>
			</td>
			<td class="right"><?php echo $product['total']; ?>
			</td>
		</tr>
	</tbody>
	<?php } ?>
	<?php if(count($totals)) foreach ($totals as $totals) { ?>
	<tbody id="totals">
		<tr>
			<td colspan="4" class="right"><?php echo $totals['title']; ?>:</td>
			<td class="right"><?php echo $totals['text']; ?>
			</td>
		</tr>
	</tbody>
	<?php } ?>
</table>
	<?php if ($downloads) { ?>
<h3>
<?php echo $text_download; ?>
</h3>
<table class="list">
	<thead>
		<tr>
			<td class="left"><b><?php echo $column_download; ?> </b></td>
			<td class="left"><b><?php echo $column_filename; ?> </b></td>
			<td class="right"><b><?php echo $column_remaining; ?> </b></td>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($downloads as $download) { ?>
		<tr>
			<td class="left"><?php echo $download['name']; ?></td>
			<td class="left"><?php echo $download['filename']; ?></td>
			<td class="right"><?php echo $download['remaining']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
	<?php } ?>
</table>
