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
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      
      
      
     <div class="wrap">
      <table class="wp-list-table widefat fixed pages" cellspacing="0">
        <thead>
          <tr>
            <th ><?php echo $column_name; ?></th>
            <th ><?php echo $column_code; ?></th>
            <th ><?php echo $column_orders; ?></th>
            <th ><?php echo $column_total; ?></th>
            <th ><?php echo $column_action; ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (@$coupons) { ?>
          <?php foreach ($coupons as $coupon) { ?>
          <tr>
            <td ><?php echo $coupon['name']; ?></td>
            <td ><?php echo $coupon['code']; ?></td>
            <td ><?php echo $coupon['orders']; ?></td>
            <td ><?php echo $coupon['total']; ?></td>
            <td ><?php foreach ($coupon['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>            
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td style="text-align: center;" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
        	 <tr>
            <th ><?php echo $column_name; ?></th>
            <th ><?php echo $column_code; ?></th>
            <th ><?php echo $column_orders; ?></th>
            <th ><?php echo $column_total; ?></th>
            <th ><?php echo $column_action; ?></th>
          </tr>
        </tfoot>
      </table>
       </div>
      <div class="pagination"><?php echo @$pagination; ?></div>
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

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	jQuery('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 