<?php
    /*
     * Template Name: Page Left Menu
     */
?>
<?php get_header(); ?>
<?php
$mail         = noo_umbra_get_option('noo_header_topbar_mail', '') ;
$phone        = noo_umbra_get_option('noo_header_topbar_phone', '') ;
$search       = noo_umbra_get_option('noo_header_nav_icon_search', true) ;
$wishlist     = noo_umbra_get_option('noo_header_nav_icon_wishlist', true) ;

?>
    <div class="page_leftmenu_fullwidth" role="main">

        <div class="noopage-leftsidebar">

            <div class="noo-navbar-wrapper">
                <div class="navbar-logo">
                    <?php noo_umbra_the_custom_logo(); ?>
                      <button data-target=".nav-collapse" class="btn-navbar noo_icon_menu icon_menu" type="button">
                      </button>
                </div> <!-- / .nav-header -->
                <div class="navbar-entry-meta">
                    <ul class="meta-info">

                        <?php if( isset($mail) && !empty($mail) ): ?>
                        <li>
                            <span><?php echo esc_html__('M','noo-umbra'); ?></span>
                            <a href="mailto:<?php echo esc_attr($mail); ?>"><?php echo esc_attr($mail); ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if( isset($phone) && !empty($phone) ): ?>
                        <li>
                            <span><?php echo esc_html__('T','noo-umbra'); ?></span>
                            <a href="tel:<?php echo esc_attr(str_replace(' ','',$phone)); ?>"><?php echo esc_attr($phone); ?></a>
                        </li>
                        <?php endif; ?>

                    </ul>
                    <ul class="meta-icon">
                        <?php if( isset($search) && $search == true ): ?>
                            <li>
                                <a class="noo-search icon_search" href="#"></a>
                            </li>
                        <?php endif; ?>

                        <?php if( isset($wishlist) && $wishlist == true ): ?>
                            <li>
                                <a class="noo-wishlist icon_heart_alt" href="<?php echo esc_url(get_page_link( get_option('yith_wcwl_wishlist_page_id') )); ?>"></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <nav class="noo-main-menu">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav-collapse navbar-nav',
                        'fallback_cb'    => 'noo_umbra_notice_set_menu',
                        'walker'         => new Noo_Umbra_Megamenu_Walker
                    ) );
                    ?>
                </nav>
            </div>

            <div class="left-footer">
                <?php
                    $noo_bottom_bar_content = noo_umbra_get_option( 'noo_bottom_bar_content', '' );
                    echo noo_umbra_html_content_filter($noo_bottom_bar_content);
                ?>
            </div>

            <div class="search-header">
                <div class="remove-form"></div>
                <div class="noo-container">
                    <?php noo_umbra_get_from_product(); ?>
                </div>
            </div>

        </div><!--end .noopage-leftsidebar-->

        <div class="noopage-rightcontent">
            <!-- Begin The loop -->
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
            <!-- End The loop -->
        </div>
    </div> <!-- /.main -->
<?php get_footer(); ?>
