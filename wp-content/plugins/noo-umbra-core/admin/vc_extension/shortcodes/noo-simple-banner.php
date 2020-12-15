<?php
 if( !function_exists('noo_shortcode_simple_banner') ){

     function noo_shortcode_simple_banner($atts){
         extract(shortcode_atts(array(
             'style_banner'      =>  'right',
             'icon_image'        =>  '',
             'title'             =>  '',
             'custom_link'       =>  ''
         ),$atts));

         ob_start(); ?>
            <div class="noo_simple_banner <?php echo esc_attr($style_banner); ?>">
                <?php
                    echo wp_get_attachment_image(esc_attr($icon_image),'full');

                ?>
                <div>
                    <?php if( isset($title) && !empty($title) ): ?><h3><?php echo esc_html($title); ?></h3><?php endif; ?>
                    <?php
                    if( isset( $custom_link ) && !empty( $custom_link )){
                        $link = vc_build_link( $custom_link );
                        ?>
                        <a href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>><span><?php echo esc_html($link['title']) ?></span><i class="fa fa-angle-right"></i></a>
                    <?php
                    }
                    ?>
                </div>
            </div>


         <?php
         $banner = ob_get_contents();
         ob_end_clean();
         return $banner;

     }
     add_shortcode('noo_simple_banner','noo_shortcode_simple_banner');

 }