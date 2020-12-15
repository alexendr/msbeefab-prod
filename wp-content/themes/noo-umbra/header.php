<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="site" id="noo-site">
        <?php  if( !is_page_template('page-left-menu.php') ): ?>

            <?php  if( is_page_template('page-revolution.php') ):
                $slider = noo_umbra_get_post_meta(get_the_ID(), '_noo_wp_page_slider_rev');
                if( isset($slider) && !empty($slider) ){
                    putRevSlider( $slider );
                }             
            endif; ?>

            <header class="noo-header <?php noo_umbra_header_class(); ?>">
                <?php noo_umbra_get_layout('navbar'); ?>
            </header>

            <?php noo_umbra_get_layout( 'heading' );  ?>

        <?php endif; ?>

