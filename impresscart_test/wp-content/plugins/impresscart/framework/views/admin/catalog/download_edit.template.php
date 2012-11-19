<div class="wrap">
	<h2>
		<?php echo @$download->download_id ? 'Edit Download' : 'Add Download'; ?>
		<a class="add-new-h2" href="<?php echo $framework->buildURL('/admin/catalog/download_index')?>">Back to List</a>
	</h2>
	<?php if(!empty($errors)) : ?>
	<div style="background:yellow;color:red;border-radius:5px;display:block-inline;padding:5px;"><?php echo $errors?></div>
	<?php endif;?>
	<div class="form-wrap">
		<form method="post" enctype="multipart/form-data">
			<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="name">Name</label>
							<input type="text" name="name" value="<?php echo @$download->name?>" size="50"/>
							<p>The name of the download.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="remaining">Total Download Allowed</label>
							<input type="text" name="remaining" value="<?php echo @$download->remaining?>" size="2"/>
							<p>Total Download Allowed for each Purchase.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-field form-required">
							<label for="file">File</label>
							<input type="file" name="file"/> <br/>
							<p>File to download <?php if(!empty($download->filename)) : ?>(current one <?php echo $download->filename?>) <?php endif;?>.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" 	class="button" value="Save Download" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
