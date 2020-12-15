<?php
    if( !function_exists('noo_umbra_testimonial_meta_boxs') ):
        function noo_umbra_testimonial_meta_boxs(){
            // Declare helper object
            $prefix = '_noo_umbra_wp_testimonial';
            $helper = new NOO_Meta_Boxes_Helper($prefix, array(
                'page' => 'testimonial'
            ));
            // Post type: Gallery
            $meta_box = array(
                'id' => "{$prefix}_meta_box_testimonial",
                'title' => esc_html__('Testimonial options', 'noo-umbra'),
                'fields' => array(
                    array(
                        'id' => "{$prefix}_image",
                         'label' => esc_html__( 'Your Image', 'noo-umbra' ),
                        'type' => 'image',
                    ),
                    array(
                        'id' => "{$prefix}_name",
                         'label' => esc_html__( 'Your Name', 'noo-umbra' ),
                        'type' => 'text',
                    ),
                    array(
                        'id' => "{$prefix}_position",
                         'label' => esc_html__( 'Your Position', 'noo-umbra' ),
                        'type' => 'text',
                    ),
                )
            );

            $helper->add_meta_box($meta_box);
        }
        add_action('add_meta_boxes', 'noo_umbra_testimonial_meta_boxs');
    endif;
?>