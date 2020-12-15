<?php

    if( !function_exists('noo_shortcode_custom_link') ){
        function noo_shortcode_custom_link($atts){
             extract(shortcode_atts(array(
                 'style'        =>  'content_top',
                 'image_id'     =>  '',
                 'title'        =>  '',
                 'desc'         =>  '',
                 'custom_link'         =>  ''
             ),$atts));
            ob_start();
            ?>
            <div class="noo_custom_categories <?php echo esc_attr($style); ?>">
                <?php if( $style == 'content_top' ): ?>
                    <div class="custom-content">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($desc); ?></p>
                        <?php
                        if( isset( $custom_link ) && !empty( $custom_link )){
                            $link = vc_build_link( $custom_link );
                            ?>
                            <a href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>><?php echo esc_html($link['title']) ?><i class="fa fa-angle-right"></i></a>
                        <?php } ?>
                    </div>
                <?php endif; ?>
                <div class="custom-thumbnail">
                    <?php if( isset($image_id) && !empty($image_id) ):
                        if( isset( $custom_link ) && !empty( $custom_link )){
                            $link = vc_build_link( $custom_link );
                            ?>
                            <a href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>>
                                <span class="first"></span>
                                <span class="last"></span>
                                <?php echo wp_get_attachment_image($image_id,'full'); ?>
                            </a>
                        <?php }else{
                            ?>
                                <span class="first"></span>
                                <span class="last"></span>
                            <?php
                            echo wp_get_attachment_image($image_id,'full');
                        }
                    endif; ?>
                </div>
                <?php if( $style == 'content_bottom' ): ?>
                    <div class="custom-content">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($desc); ?></p>
                        <?php
                        if( isset( $custom_link ) && !empty( $custom_link )){
                            $link = vc_build_link( $custom_link );
                            ?>
                            <a href="<?php echo esc_url($link['url']) ?>" <?php if( isset($link['target']) && !empty( $link['target'] ) ): ?>target="_blank" <?php endif; ?>><?php echo esc_html($link['title']) ?><i class="fa fa-angle-right"></i></a>
                        <?php } ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php
            $categories = ob_get_contents();
            ob_end_clean();
            return $categories;
        }
        add_shortcode('noo_custom_link','noo_shortcode_custom_link');
    }
