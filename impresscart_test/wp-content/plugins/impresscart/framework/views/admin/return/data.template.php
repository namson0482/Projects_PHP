  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="content">
      <form action="<?php #echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-return" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_order_id; ?></td>
              <td><input type="text" name="data[order_id]" value="<?php echo $order_id; ?>" readonly="readonly" />
                <?php if ($error_order_id) { ?>
                <span class="error"><?php echo $error_order_id; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_ordered; ?></td>
              <td><input type="text" name="data[date_ordered]" value="<?php echo $date_ordered; ?>" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_customer; ?></td>
              <td><input type="text" name="customer" value="<?php echo $customer; ?>" />
                <input type="hidden" name="data[customer_id]" value="<?php echo $customer_id; ?>" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
              <td><input type="text" name="data[firstname]" value="<?php echo $firstname; ?>" />
                <?php if ($error_firstname) { ?>
                <span class="error"><?php echo $error_firstname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><input type="text" name="data[lastname]" value="<?php echo $lastname; ?>" />
                <?php if ($error_lastname) { ?>
                <span class="error"><?php echo $error_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_email; ?></td>
              <td><input type="text" name="data[email]" value="<?php echo $email; ?>" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
              <td><input type="text" name="data[telephone]" value="<?php echo $telephone; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_return_status; ?></td>
              <td><select name="data[return_status_id]">
                  <?php foreach ($return_statuses as $return_status) { ?>
                  <?php if ($return_status['return_status_id'] == $return_status_id) { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_comment; ?></td>
              <td><textarea name="data[comment]" cols="40" rows="5"><?php echo $comment; ?></textarea></td>
            </tr>
          </table>
        </div>
        
      </form>
    </div>
  </div>
  <script type="text/javascript">
 	 jQuery("input[name='data[date_ordered]']").datepicker();
  </script>