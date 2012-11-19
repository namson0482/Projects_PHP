<div class="impresscart_header">
<h1 class="theme-title"><?php echo $heading;?></h1>
</div>
<div class="message"><?php echo @$message; ?></div>

<?php 
echo Goscom::generateMenu($pages);
?>

<div class="content">
  <form id="form" enctype="multipart/form-data" method="post" action="">
    <table class="form">
      <tbody>
      	
      	 <tr>
          <td><span class="required">*</span>Title:</td>
          <td><input type="text" name="impresscart[payment_method][paypalstandard][name]" value="<?php echo !isset($setting['name']) ? 'PayPal Standard' : $setting['name'];?>" />
          </td>
        </tr>
      
        <tr>
          <td><span class="required">*</span> E-Mail:</td>
          <td><input type="text" name="impresscart[payment_method][paypalstandard][email]" value="<?php echo !isset($setting['email']) ? 'Email' : $setting['email'];?>" />
          </td>
        </tr>
        <tr>
          <td>Sandbox Mode:</td>
          <td><input name="impresscart[payment_method][paypalstandard][sandbox]" type="radio" value="1" <?php if($setting['sandbox'] == '1') echo 'checked="checked"'; ?>>
            Yes
            <input name="impresscart[payment_method][paypalstandard][sandbox]" type="radio"  value="0" <?php if($setting['sandbox'] != '1') echo 'checked="checked"'; ?>>
            No </td>
        </tr>
        <tr>
          <td>Transaction Method:</td>
          <td><select name="impresscart[payment_method][paypalstandard][method]">
              <option value="0" <?php if($setting['method'] == '0') echo 'selected="selected"'; ?>>Authorization</option>
              <option value="1" <?php if($setting['method'] == '1') echo 'selected="selected"'; ?>>Sale</option>
            </select>
            </td>
        </tr>
        <tr>
          <td>Debug Mode:<br>
            <span class="help">Logs additional information to the system log.</span></td>
          <td>
          <select name="impresscart[payment_method][paypalstandard][mode]">
              <option value="1" <?php if($setting['mode'] == '1') echo 'selected="selected"'; ?>>Enabled</option>
              <option value="0" <?php if($setting['mode'] == '0') echo 'selected="selected"'; ?>>Disabled</option>
            </select></td>
        </tr>
        <tr>
          <td>Total:<br>
            <span class="help">The checkout total the order must reach before this payment method becomes active.</span></td>
          <td><input type="text" value="<?php echo !isset($setting['total']) ? 'Total' : $setting['total'];?>" name="impresscart[payment_method][paypalstandard][total]" />
          </td>
        </tr>
        <tr>
          <td>Canceled Reversal Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][canceled_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['canceled_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Completed Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][completed_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['completed_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Denied Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][denied_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['denied_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Expired Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][expired_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['expired_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Failed Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][failed_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['failed_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Pending Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][pending_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['pending_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Processed Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][processed_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['processed_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Refunded Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][refunded_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['refunded_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Reversed Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][reversed_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['reversed_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Voided Status:</td>
          <td>
          <?php
		  	$order_statuses_html = '<select name="impresscart[payment_method][paypalstandard][voided_status]">';
			foreach ($items as $item) {
				//print_r ($item);
				if($item->order_status_id == $setting['voided_status']){
					$order_statuses_html .= '<option selected="selected" value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				else{
					$order_statuses_html .= '<option value='.$item->order_status_id.'>'.$item->name.'</option>';
				}
				
			}
			$order_statuses_html .= '</select>';
			echo $order_statuses_html;
		  ?></td>
        </tr>
        <tr>
          <td>Geo Zone:</td>
          <td><?php echo $geo_zones; ?></td>
        </tr>
        <tr>
          <td>Status:</td>
          <td><select name="impresscart[payment_method][paypalstandard][enabled]">
              <option value="yes" <?php if($setting['enabled'] == 'yes') echo 'selected="selected"'; ?>>Enabled</option>
              <option value="no" <?php if($setting['enabled'] == 'no') echo 'selected="selected"'; ?>>Disabled</option>
            </select>
            </td>
        </tr>
        <tr>
          <td>Sort Order:</td>
          <td><input type="text" size="1"  name="impresscart[payment_method][paypalstandard][order]" value="<?php echo $setting['order'] ? $setting['order'] : '4'; ?>" /></td>
        </tr>
        
        <tr>
        <td>
        <input type="hidden" name="impresscart[payment_method][paypalstandard][code]" value="paypalstandard" />
        <input type="submit" name="save" value="save" />
</td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
