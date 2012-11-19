

<div class='content'>
	<table id='transactions' width='100%'>
		<?php 
			echo $table_data_transactions ;
		?>
	</table>
	<input type="button" value="Add" onclick="addTransaction()" />
	<input type="hidden" name='total_rows' value='' />
	<input type="hidden" name='url_value' value='<?php echo admin_url( 'admin-ajax.php', 'relative' )?>' />
</div>



<script type="text/javascript"><!--

jQuery('#notify').hide();

function addTransaction() {

	var rowCount = jQuery('#transactions tr').length;

	var description = '<td><span>Description : </span><input type="text" name="impresscart[credit][description][]" value=""></td>';
	var amount = '<td><span>Amount : </span><input type="text" name="impresscart[credit][amount][]" value="0"></td>';
	
	jQuery("#transactions").append('<tr>' + description + amount + '</tr>');
	
	

	//
	/*
    var description_value = jQuery("input[name$='description']").val();
    var amount_value = jQuery("input[name$='amount']").val();
    var user_id_value = jQuery("#user_id").val();
    var url_value = jQuery("input[name$='url_value']").val();;
    jQuery.ajax({
        url: url_value,
        data: { action : 'framework', fwurl : '/admin/user', user_id : user_id_value, description : description_value, amount : amount_value },
        type: 'post',
        dataType: 'json',
        success: function(json) {   
            if (json['success']) {
            	jQuery('.success').html(json['success']);
                jQuery('#notify').show();
                //jQuery('#basket').submit();
            }
            if( json['fail'] ){
            	jQuery('.success').html(json['fail']);
                jQuery('#notify').show();
            }
        }
    });
    */
}


//--></script>