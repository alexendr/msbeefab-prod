<?php

    if( !function_exists('noo_shortcode_testimonial') ){
        function noo_shortcode_testimonial($atts){
            extract(shortcode_atts(array(
                'style'             =>  'default',
                'categories'        =>  '',
                'autoplay'          =>  'true',
                'orderby'           =>  'latest',
                'posts_per_page'    =>  '10',
            ),$atts));
            ob_start();
            wp_enqueue_script('carousel');


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
                'post_type'         =>  'testimonial',
                'orderby'           =>   $orderby,
                'order'             =>   $order,
                'posts_per_page'    =>   $posts_per_page,
            );

            if( $categories != 'all' && !empty($categories)){
                $args['tax_query'][]  = array(
                    'taxonomy'  =>  'testimonial_category',
                    'field'     =>  'term_id',
                    'terms'     =>   array($categories)
                );
            }
            $query = new WP_Query($args) ;
            if( $query->have_posts() ):
            ?>
            <div class="noo_testimonial-wrap">
                <?php   if( $style == 'default' ): ?> <i class="fa fa-quote-left icon-quote-left"></i> <?php  endif; ?>
                <?php if( $style != 'default' ): ?>
                <ul class="noo_testimonial noo-sync2">
                    <?php
                    while( $query->have_posts() ): $query->the_post();
                        $url      = get_post_meta(get_the_ID(),'_noo_umbra_wp_testimonial_image', true);
                        ?>
                        <li>
                            <?php   echo wp_get_attachment_image(esc_attr($url),array(95,95)); ?>
                        </li>
                    <?php
                    endwhile; wp_reset_postdata();

                    ?>
                </ul>
                <?php endif; ?>
                <ul class="noo_testimonial noo-sync1">
                <?php
                    while( $query->have_posts() ): $query->the_post();
                        $url      = get_post_meta(get_the_ID(),'_noo_umbra_wp_testimonial_image', true);
                        $name     = get_post_meta(get_the_ID(),'_noo_umbra_wp_testimonial_name', true);
                        $position = get_post_meta(get_the_ID(),'_noo_umbra_wp_testimonial_position', true);
                ?>
                        <li>
                            <?php   if( $style == 'default' ): echo wp_get_attachment_image(esc_attr($url),array(60,60)); endif; ?>
                            <div class="noo-testimonial-content">
                                <span class="testimonial-author">
                                    <?php echo esc_html($name); ?>
                                    <strong><?php echo esc_html($position); ?></strong>
                                </span>
                                <?php the_content() ?>
                            </div>
                        </li>
                <?php
                    endwhile; wp_reset_postdata();

                ?>
                </ul>
            </div>
                <script>
                    jQuery(document).ready(function(){
                        "use strict";
                        <?php if( $style == 'default' ): ?>
                        jQuery(".noo_testimonial").each(function(){
                            jQuery(this).owlCarousel({
                                autoPlay: <?php echo esc_attr($autoplay) ?>,
                                navigation : true,
                                slideSpeed : 400,
                                pagination: false,
                                paginationSpeed : 400,
                                addClassActive: true,
                                singleItem : true

                            });
                        });
                        <?php else: ?>
                        var sync1 = jQuery(".noo-sync1");
                        var sync2 = jQuery(".noo-sync2");

                        sync1.owlCarousel({
                            singleItem : true,
                            slideSpeed : 400,
                            navigation: false,
                            pagination:false,
                            autoHeight: true,
                            afterAction : syncPosition,
                            responsiveRefreshRate : 200
                        });

                        sync2.owlCarousel({
                            items : 3,
                            itemsDesktop      : [1199,3],
                            itemsDesktopSmall     : [979,3],
                            itemsTablet       : [768,3],
                            itemsMobile       : [479,1],
                            pagination:false,
                            responsiveRefreshRate : 100,
                            afterInit : function(el){
                                el.find(".owl-item").eq(0).addClass("synced");
                            }
                        });

                        function syncPosition(el){
                            var current = this.currentItem;
                            jQuery(".noo-sync2")
                                .find(".owl-item")
                                .removeClass("synced")
                                .eq(current)
                                .addClass("synced")
                            if(jQuery(".noo-sync2").data("owlCarousel") !== undefined){
                                center(current)
                            }

                        }

                        jQuery(".noo-sync2").on("click", ".owl-item", function(e){
                            e.preventDefault();
                            var number = jQuery(this).data("owlItem");

                            sync1.trigger("owl.goTo",number);
                        });

                        function center(number){
                            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

                            var num = number;
                            var found = false;
                            for(var i in sync2visible){
                                if(num === sync2visible[i]){
                                    var found = true;
                                }
                            }

                            if(found===false){
                                if(num>sync2visible[sync2visible.length-1]){
                                    sync2.trigger("owl.goTo", num - sync2visible.length+2)
                                }else{
                                    if(num - 1 === -1){
                                        num = 0;
                                    }
                                    sync2.trigger("owl.goTo", num);
                                }
                            } else if(num === sync2visible[sync2visible.length-1]){
                                sync2.trigger("owl.goTo", sync2visible[1])
                            } else if(num === sync2visible[0]){
                                sync2.trigger("owl.goTo", num-1)
                            }
                        }
                        <?php endif; ?>
                    });
                </script>

        <?php
            endif;
            $testimonial = ob_get_contents();
            ob_end_clean();
            return $testimonial;
        }
        add_shortcode('noo_testimonial','noo_shortcode_testimonial');
    }

?>