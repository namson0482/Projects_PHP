<?php

    # init widgets
    add_action('widgets_init', 'impresscart_featured_register_widget');

    class impresscart_featured_widget extends WP_Widget
    {
        function impresscart_featured_widget()
        {
            $widget_ops = array(
            'classname' =>  'impresscart_featured_widget',
            'description' =>  'Display cart widget.'
            );
            $this->WP_Widget( 'impresscart_featured_widget', 'Impress Cart Featured Products',
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
            $orderby             = 'name';
            $show_count         = 1; // 1 for yes, 0 for no
            $pad_counts         = 0; // 1 for yes, 0 for no
            $hierarchical         = true; // 1 for yes, 0 for no
            $taxonomy             = 'product_cat';
            $title                 = '';
            $hideempty            = 0;
            $tag_ID            = 5;
            $args = array(
            'orderby'         => $orderby,
            'show_count'         => $show_count,
            'pad_counts'         => $pad_counts,
            'hierarchical'     => $hierarchical,
            'taxonomy'         => $taxonomy,
            'title_li'         => $title,
            'hide_empty'         => $hideempty,
            'tag_ID'         => $tag_ID,
            'post_type'         => 'product',
            );
            echo "<div id='impresscart_featured'>";
			echo "<h1 class='ititle' style='font-size:20px;font-weight:bold;color:#EF4B23;'>Featured Products</h1>";
            echo "<ul>";
            $posts_array = get_posts( $args ); 
$currency_service = impresscart_framework::service('currency');

            foreach($posts_array as $item){
                global $post;
                $productModel = impresscart_framework::model('catalog/product');
                $product = $productModel->getProduct($item->ID);
                $brand= $productModel->getBrand($item->ID);
                $price = $productModel->getPrice($item->ID);
                $price= impresscart_framework::service('currency')->format($price);
                $post_thumbnail=  get_the_post_thumbnail($item->ID,'thumbnail');
                $link =get_post_permalink($item->ID);
                $featured =$product->STATUS;
                if($featured=="Enabled"){

                ?>
               <li class="item" id="<?php echo 'li'.$item->ID; ?>"><div class="post-basic-item">
                        <a class="featured-article" href="<?php echo $link; ?>" rel="bookmark"> 
                            <?php echo $post_thumbnail; ?>
                            <p class="entry-title"><?php echo $item->post_title; ?></p>                 

                        </a>
                        <span class="price"><?php
                         echo $price; ?></span>
                       <button class="buy" onclick="addToCart('<?php echo $item->ID; ?>'); return false;">Add to cart</button>
                    </div>
                </li>
                <?php
                    $item=$item;
                    $name =$item->post_title;


                }
            }
            echo "</ul>";
        }
    }

    function impresscart_featured_register_widget()
    {
        register_widget('impresscart_featured_widget');
    }

?>
