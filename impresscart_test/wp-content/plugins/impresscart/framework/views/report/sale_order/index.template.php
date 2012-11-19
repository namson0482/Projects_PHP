<?php 
	echo Goscom::generateHeader($pages);
?>
    <div class="content">
    	<br>
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_group; ?>
            <select name="filter_group">
              <?php foreach ($groups as $groups) { ?>
              <?php if ($groups['value'] == $filter_group) { ?>
              <option value="<?php echo $groups['value']; ?>" selected="selected"><?php echo $groups['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><?php echo $entry_status; ?>
            <select name="filter_order_status_id">
              <option value="100"><?php echo $text_all_status; ?></option>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      
      <div class="wrap">
      <table class="wp-list-table widefat fixed pages" cellspacing="0">
        <thead>
          <tr>
            <th ><?php echo $column_date_start; ?></th>
            <th ><?php echo $column_date_end; ?></th>
            <th ><?php echo $column_orders; ?></th>
            <th ><?php echo $column_products; ?></th>
            <th ><?php echo $column_tax; ?></th>
            <th ><?php echo $column_total; ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
            <td ><?php echo $order['date_start']; ?></td>
            <td ><?php echo $order['date_end']; ?></td>
            <td ><?php echo $order['orders']; ?></td>
            <td ><?php echo $order['products']; ?></td>
            <td ><?php echo $order['tax']; ?></td>
            <td ><?php echo $order['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="6" style="text-align: center;"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
			<tr>
				<th ><?php echo $column_date_start; ?></th>
	            <th ><?php echo $column_date_end; ?></th>
	            <th ><?php echo $column_orders; ?></th>
	            <th ><?php echo $column_products; ?></th>
	            <th ><?php echo $column_tax; ?></th>
	            <th ><?php echo $column_total; ?></th>
			</tr>
		</tfoot>
      </table>
      <div class="pagination">
		<?php echo @$pagination; ?>
	  </div>
      
      </div>
      
      
    </div>
  
<script type="text/javascript"><!--
function filter() {
	url = '<?php echo $url; ?>';
	
	var filter_date_start = jQuery('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = jQuery('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_group = jQuery('select[name=\'filter_group\']').attr('value');
	
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}
	
	var filter_order_status_id = jQuery('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	jQuery('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 