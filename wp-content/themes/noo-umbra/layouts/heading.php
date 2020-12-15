<?php
$heading_global = noo_umbra_get_option('noo_page_heading','true');
if( is_404()  || $heading_global == false) return;

$heading = noo_umbra_new_heading();

if( $heading['status'] == 'show' ):
    $class_parallax = '';
    if( isset($heading['parallax']) && $heading['parallax'] == true ):
        $class_parallax = 'parallax';
        wp_enqueue_script( 'parallax' );
    endif;
    ?>


    <section class="noo-page-heading <?php echo esc_attr($class_parallax); ?>" style="height: <?php echo esc_attr($heading['height']).'px'; ?>;background-image: url('<?php echo esc_url($heading['img']) ?>')">
        <div class="noo-container">
            <div class="noo-heading-content">

                <?php if( isset($heading['title']) && !empty($heading['title']) ): ?><h1 class="page-title"><?php echo esc_html($heading['title']); ?></h1><?php endif; ?>

                <?php if( isset($heading['sub_title']) && !empty($heading['sub_title']) ): ?><p><?php echo esc_html($heading['sub_title']); ?></h1></p><?php endif; ?>

                <?php if(function_exists('bcn_display') && !is_search()): ?>
                    <div class="noo-page-breadcrumb">
                        <?php bcn_display();  ?>
                    </div>
                <?php endif; ?>

            </div>
        </div><!-- /.container-boxed -->
    </section>

<?php endif; ?>
