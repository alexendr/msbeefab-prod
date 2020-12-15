<?php
    if( !function_exists('noo_shortcode_product_simple_slider') ){

        function noo_shortcode_product_simple_slider($atts){
            extract(shortcode_atts(array(
                'cat'            =>  '',
                'auto_slider'    =>  'false',
                'columns'        =>  '3',
                'orderby'        =>  'latest',
                'posts_per_page' =>  8
            ),$atts));
            ob_start();
            $order = 'DESC';
            switch ($orderby) {

                case 'latest':
                    $orderby = 'date';
                    break;

                case 'oldest':
                    $orderby = 'date';
                    $order = 'ASC';
                    break;

                case 'alphabet':
                    $orderby = 'title';
                    $order = 'ASC';
                    break;

                case 'ralphabet':
                    $orderby = 'title';
                    break;

                default:
                    $orderby = 'date';
                    break;
            }
            $args = array(
                'post_type'         =>  'product',
                'orderby'           =>   $orderby,
                'order'             =>   $order,
                'posts_per_page'    =>   $posts_per_page
            );


            if( isset($cat) && $cat != 'all' && !empty($cat) ){
                $new_id = explode(',',$cat);
                $new_cat = array();
                foreach($new_id as $id){
                    $new_cat[] = intval($id);
                }
                $args['tax_query'][] = array(
                    'taxonomy'  =>  'product_cat',
                    'field'     =>  'term_id',
                    'terms'     =>   $new_cat
                );
            }
            wp_enqueue_script('carousel');
            ?>
            <div class="noo-simple-product-wrap">
                <ul class="noo-simple-product-slider">
                   <?php
                     $query = new WP_Query( $args );
                    if( $query->have_posts() ):
                        while( $query->have_posts() ):
                        $query->the_post();
                            global $product;
                   ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" class="hover-device">
                                <div class="noo-simple-slider-item">
                                    <?php the_post_thumbnail('noo-thumbnail-product') ?>
                                    <div class="noo-simple-content">
                                        <h3><?php the_title(); ?></h3>
                                        <?php if ( $price_html = $product->get_price_html() ) : ?>
                                            <span class="price"><?php echo $price_html; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php
                        endwhile;
                    endif; wp_reset_postdata();
                   ?>
                </ul>
            </div>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.noo-simple-product-slider').owlCarousel({
                        items : <?php echo esc_attr($columns) ?>,
                        itemsDesktop : [1199,<?php echo esc_attr($columns) ?>],
                        itemsDesktopSmall : [979,3],
                        itemsTablet: [768, 2],
                        slideSpeed:500,
                        paginationSpeed:800,
                        rewindSpeed:1000,
//                        autoHeight: true,
                        addClassActive: true,
                        autoPlay: <?php echo esc_attr($auto_slider) ?>,
                        loop:true,
                        pagination: false
                    });
                });
            </script>
            <?php
            $slider = ob_get_contents();
            ob_end_clean();
            return $slider;
        }
        add_shortcode('product_simple_slider','noo_shortcode_product_simple_slider');

    }