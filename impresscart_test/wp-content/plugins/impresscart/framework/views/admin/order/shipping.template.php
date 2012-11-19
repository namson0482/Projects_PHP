    <table class="form">
          <tr>
            <td><?php echo $text_firstname; ?></td>
            <td><input type="text" name="shipping[firstname]" value="<?php echo @$shipping_firstname; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $text_lastname; ?></td>
            <td><input type="text" name="shipping[lastname]" value="<?php echo @$shipping_lastname; ?>" /></td>
          </tr>
          <?php if (@$shipping_company) { ?>
          <tr>
            <td><?php echo $text_company; ?></td>
            <td><input type="text" name="shipping[company]" value="<?php echo $shipping_company; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_address_1; ?></td>
            <td><input type="text" name="shipping[address_1]" value="<?php echo @$shipping_address_1; ?>" /></td>
          </tr>
          <?php if (@$shipping_address_2) { ?>
          <tr>
            <td><?php echo $text_address_2; ?></td>
            <td><input type="text" name="shipping[address_2]" value="<?php echo $shipping_address_2; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_city; ?></td>
            <td><input type="text" name="shipping[city]" value="<?php echo @$shipping_city; ?>" /></td>
          </tr>
          <?php if (@$shipping_postcode) { ?>
          <tr>
            <td><?php echo $text_postcode; ?></td>
            <td><input type="text" name="shipping[postcode]" value="<?php echo $shipping_postcode; ?>" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_zone; ?></td>
            <td><?php echo @$shipping_zone; ?></td>
          </tr>
          <?php if (@$shipping_zone_code) { ?>
          <tr>
            <td><?php echo $text_zone_code; ?></td>
            <td><?php echo @$shipping_zone_code; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_country; ?></td>
            <td><?php echo @$shipping_country; ?></td>
          </tr>
          <?php if (@$shipping_method) { ?>
          <tr>
            <td><?php echo $text_shipping_method; ?></td>
            <td><?php echo $shipping_method; ?></td>
          </tr>
          <?php } ?>
        </table>