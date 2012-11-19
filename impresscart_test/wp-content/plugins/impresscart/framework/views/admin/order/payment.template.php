<table class="form">
          <tr>
            <td><?php echo $text_firstname; ?></td>
            <td><input type="text" name="payment_firstname" value="<?php echo @$payment_firstname; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $text_lastname; ?></td>
            <td><input type="text" name="payment_lastname" value="<?php echo @$payment_lastname; ?>" /></td>
          </tr>
          <?php if (@$payment_company) { ?>
          <tr>
            <td><?php echo $text_company; ?></td>
            <td><input type="text" name="payment_company" value="<?php echo @$payment_company; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_address_1; ?></td>
            <td><input type="text" name="payment_address_1" value="<?php echo @$payment_address_1; ?>" /></td>
          </tr>
          <?php if (@$payment_address_2) { ?>
          <tr>
            <td><?php echo $text_address_2; ?></td>
            <td><input type="text" name="payment_address_2" value="<?php echo @$payment_address_2; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_city; ?></td>
            <td><input type="text" name="payment_city" value="<?php echo @$payment_city; ?>" /></td>
          </tr>
          <?php if (@$payment_postcode) { ?>
          <tr>
            <td><?php echo $text_postcode; ?></td>
            <td><input type="text" name="payment_postcode" value="<?php echo @$payment_postcode; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_zone; ?></td>
            <td><?php echo @$payment_zone; ?></td>
          </tr>
          <?php if (@$payment_zone_code) { ?>
          <tr>
            <td><?php echo $text_zone_code; ?></td>
            <td><input type="text" name="payment_zone_code"  value="<?php echo @$payment_zone_code; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_country; ?></td>
            <td><?php echo @$payment_country;?></td>
            
          </tr>
          <tr>
            <td><?php echo $text_payment_method; ?></td>
            <td><?php echo @$payment_method; ?></td>
          </tr>
</table>      