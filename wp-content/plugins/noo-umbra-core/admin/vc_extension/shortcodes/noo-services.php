<?php

if( !function_exists('noo_shortcode_services') ){

    function noo_shortcode_services($atts){
        extract(shortcode_atts(array(
            'style'         =>  'style_center',
            'style_icon'    =>  'font',
            'icon_image'    =>  '',
            'icon'          =>  '',
            'title'         =>  '',
            'description'   =>  ''
        ),$atts));
        ob_start();
        ?>
            <div class="noo-services <?php echo esc_html($style).' '.esc_attr($style_icon); ?>">
                <div class="noo-service-icon">

                <?php
                    if( $style_icon == 'font' ):
                        if( isset($icon) && !empty($icon) ): ?>
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        <?php endif;
                    else:
                        if( isset($icon_image) && !empty($icon_image) ): echo wp_get_attachment_image(esc_attr($icon_image)); endif;
                    endif;
                ?>
                </div>
                <div class="noo-service-content">
                    <?php if( isset($title) && !empty($title) ): ?><h3><?php echo esc_html($title) ?></h3><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description) ?></p><?php endif; ?>
                </div>
            </div>
        <?php
        $services = ob_get_contents();
        ob_end_clean();
        return $services;
    }
    add_shortcode('noo_services','noo_shortcode_services');

}
