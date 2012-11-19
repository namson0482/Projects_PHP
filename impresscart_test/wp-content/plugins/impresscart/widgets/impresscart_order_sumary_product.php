<?php

# init widgets
add_action('widgets_init', 'impresscart_order_sumary_register_widget');

 class impresscart_order_sumary_widget extends WP_Widget
    {
        function impresscart_order_sumary_widget()
        {
            $widget_ops = array(
            'classname' =>  'impresscart_order_sumary_widget',
            'description' =>  'Display cart widget.'
            );
            $this->WP_Widget( 'impresscart_order_sumary_widget', 'Impress Cart Order Summary',
            $widget_ops );
        }

        function form($instance)
        {

        }

        function update($new_instance, $old_instance)
        {

        }

        function widget($args, $instance)
        {
         	$json = array();
        	$product_model = impresscart_framework::model('catalog/product');
        	$cart = impresscart_framework::service('cart');
         	$currency = impresscart_framework::service('currency');
			$total = $cart->cartTotal();
			$shipping =$cart->getProducts();
			$priceship=0;
			foreach($shipping as $ship){
			    $priceship = $ship["shipping"]+$priceship;
			}
			$totalall=$total+$priceship;
	        $totalall = $currency->format($totalall);
	        $total=$currency->format($total);
	        $priceship=$currency->format($priceship);
?>

<h1 class="order" style="padding-bottom:15px; border-bottom:1px solid #ccc;font-size: 14px; font-weight: bold; font-family: Century Gothic; color: #616163;">Order Summary</h1>
<div class="sumary_content" style="position: relative; overflow: hidden;">
<span class="name" style="display: block;
    float: left;
    font-size: 12px;
    text-align: right;
    width: 80px;">Cart subtotal</span> <span class="price" style="float: left;
    text-align: right;
    width: 80px;"><?php  echo $total;?></span><br>
<span class="name" style="display: block;
    float: left;
    font-size: 12px;
    text-align: right;
    width: 80px;">Shipping</span> <span class="price" style="float: left;
    text-align: right;
    width: 80px;"><?php  echo $priceship;?></span>
</div>
<h3 style="border-bottom: none;border-top: 1px solid #ccc;text-align: right;padding-right:20px;"><strong>Total&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $totalall;?></strong></h3>
<?php

        }
    }

    function impresscart_order_sumary_register_widget()
    {
        register_widget('impresscart_order_sumary_widget');
    }

?>
