<?php
    if( !function_exists('noo_shortoce_product_sale') ){
        function noo_shortoce_product_sale($atts){
            extract(shortcode_atts(array(
                'title'          =>  '',
                'image'          =>  '',
                'sub_title'      =>  '',
                'description'    =>  '',
                'orderby'        =>  'latest',
                'posts_per_page' =>  8
            ),$atts));
            ob_start(); ?>
            <div class="noo-product-sale-wrap">
                <h3 class="noo-sale-title"><?php echo esc_html($title) ?></h3>
                <?php echo wp_get_attachment_image($image,'full'); ?>
                <h4 class="noo-sale-subtitle"><?php echo esc_html($sub_title) ?></h4>
                <p class="noo-sale-ds"><?php echo esc_html($description) ?></p>
                <?php $order = 'DESC';
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
                if( function_exists('wc_get_product_ids_on_sale') ):
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $args['post__in']	 = array_merge( array( 0 ), $product_ids_on_sale );
                endif;

                $query = new WP_Query( $args );
                if( $query->have_posts() ):
                    echo '<ul class="noo-on-sale">';
                    while( $query->have_posts() ):
                        $query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink() ?>" class="hover-device">
                                <?php the_post_thumbnail(array(150,150)) ?>
                                <h4><?php the_title(); ?></h4>
                            </a>
                        </li>
                    <?php endwhile;    wp_reset_postdata();
                    echo '</ul>';
                endif;
                ?>
                <script>
                    jQuery(document).ready(function(){
                        jQuery('.noo-on-sale').each(function(){
                            jQuery(this).owlCarousel({
                                items : 4,
                                itemsDesktop : [1199,4],
                                itemsDesktopSmall : [979,3],
                                itemsTablet: [768, 3],
                                itemsMobile: [479, 2],
                                slideSpeed:500,
                                paginationSpeed:1000,
                                rewindSpeed:1000,
                                autoHeight: false,
                                ClassActive: true,
                                autoPlay: true,
                                loop:true,
                                pagination: false
                            });
                        });
                    });
                </script>
            </div>
            <?php
            $selling = ob_get_contents();
            ob_end_clean();
            return $selling;
        }
        add_shortcode('noo_shortoce_sale','noo_shortoce_product_sale');
    }
