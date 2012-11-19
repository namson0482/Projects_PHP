<div class="impresscart_header">
<h1 class="theme-title"><?php echo __('Impress Cart Order Total Detail');?></h1>
</div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <div>
    <div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_sort_order; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($totals) { ?>
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="left"><?php echo $total['title']; ?></td>
            <td class="left">
            <?php if($total['status'] == 'yes') {
            	echo 'Enabled';	
            } else echo 'Disabled'; 
             ?>
            
            </td>
            <td class="right"><?php echo $total['order']; ?></td>
            <td class="right">
              [ <a href="<?php echo $total['action']['href']; ?>"><?php echo $total['action']['text']; ?></a> ]
              </td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>