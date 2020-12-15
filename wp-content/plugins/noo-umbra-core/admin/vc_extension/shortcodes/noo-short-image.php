<?php

if( !function_exists('noo_shortcode_short_image') ){
    function noo_shortcode_short_image($atts){
        extract(shortcode_atts(array(
            'style'     =>  'left',
            'image_id'  =>  '',
            'title'     =>  ''
        ),$atts));
        ob_start();
        ?>
            <div class="noo_short_image <?php echo esc_attr($style); ?>">
                <div class="noo_short_image_first">
                    <?php echo wp_get_attachment_image($image_id,'full'); ?>
                    <h3><?php echo esc_html($title); ?></h3>
                </div>
                <div class="noo_short_image_last">
                    <?php echo wp_get_attachment_image($image_id,'full'); ?>
                </div>
            </div>
        <?php
        $short = ob_get_contents();
        ob_end_clean();
        return $short;
    }
    add_shortcode('noo_short_image','noo_shortcode_short_image');
}