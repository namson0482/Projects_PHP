      <div id="tab-history" class="vtabs-content">
        <div id="history">
        <table class="list">
		  <thead>
		    <tr>
		      <td class="left"><b><?php echo $column_date_added; ?></b></td>
		      <td class="left"><b><?php echo $column_comment; ?></b></td>
		      <td class="left"><b><?php echo $column_status; ?></b></td>
		      <td class="left"><b><?php echo $column_notify; ?></b></td>
		    </tr>
		  </thead>
		  <tbody>
		    <?php if ($histories) { ?>
		    <?php foreach ($histories as $history) { ?>
		    <tr>
		      <td class="left"><?php echo $history['date_added']; ?></td>
		      <td class="left"><?php echo $history['comment']; ?></td>
		      <td class="left"><?php echo $history['status']; ?></td>
		      <td class="left"><?php echo $history['notify']; ?></td>
		    </tr>
		    <?php } ?>
		    <?php } else { ?>
		    <tr>
		      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
        
        </div>
        <br/>
        <table class="form">
          <tr>
            <td><?php echo $entry_return_status; ?></td>
            <td><select name="history[return_status_id]">
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
            <td><?php echo $entry_notify; ?></td>
            <td><input type="checkbox" name="history[notify]" value="1" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_comment; ?></td>
            <td><textarea name="history[comment]" cols="40" rows="8" style="width: 99%"></textarea>
             </td>
          </tr>
        </table>
      </div>