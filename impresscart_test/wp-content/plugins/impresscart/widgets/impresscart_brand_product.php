<?php

    # init widgets
    add_action('widgets_init', 'impresscart_brand_register_widget');

    class impresscart_brand_widget extends WP_Widget
    {
        function impresscart_brand_widget()
        {
            $widget_ops = array(
            'classname' =>  'impresscart_brand_widget',
            'description' =>  'Display cart widget.'
            );
            $this->WP_Widget( 'impresscart_brand_widget', 'Impress Cart Featured Brands',
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
        ?>
        <div id="impresscart_featured">
        <style type="text/css">
        .wrap-brand ul li{
            list-style: none;
            float: left;
            margin-right: 70px;
            margin-top: 10px;
        }
                .wrap-brand ul li.first{
                    margin-left: 50px;
                    
                }
                                .wrap-brand ul li.last{
                    margin-right: 0px;
                    
                }
        </style>
            <h1 class="ititle" style="font-size:20px;font-weight:bold;color:#EF4B23;">Featured Brands</h1>
            <div class="wrap-brand" style="width: 945px;position: relative;overflow: hidden; height: 95px; border: 1px solid #ccc;">
                <ul>
                    <li class="first">
                        <?php
                            echo '<img src="' .plugins_url( 'impress-cart_46.jpg' , __FILE__ ). '" >';
                        ?>
                    </li>
                    <li>
                        <?php
                            echo '<img src="' .plugins_url( 'impress-cart_48.jpg' , __FILE__ ). '" >';
                        ?>
                    </li>
                    <li>
                        <?php
                            echo '<img src="' .plugins_url( 'impress-cart_53.jpg' , __FILE__ ). '" >';
                        ?>
                    </li>
                    <li>
                        <?php
                            echo '<img src="' .plugins_url( 'impress-cart_55.jpg' , __FILE__ ). '" >';
                        ?>

                    </li>
                    <li>
                        <?php
                            echo '<img src="' .plugins_url( 'apple.jpg' , __FILE__ ). '" >';
                        ?>

                    </li>
                    <li class="last">
                        <?php
                            echo '<img src="' .plugins_url( 'palm.jpg' , __FILE__ ). '" >';
                        ?>

                    </li>
                </ul>
            </div>
        </div>
        <?php
        }
    }

    function impresscart_brand_register_widget()
    {
        register_widget('impresscart_brand_widget');
    }

?>
