<?php
$search   = noo_umbra_get_option('noo_header_nav_icon_search', true) ;
$wishlist = noo_umbra_get_option('noo_header_nav_icon_wishlist', true) ;
$cart     = noo_umbra_get_option('noo_header_nav_icon_cart', true) ;

//---------------------------------------------------------------------
$topbar       = noo_umbra_get_option('noo_header_topbar', true) ;
$mail         = noo_umbra_get_option('noo_header_topbar_mail', '') ;
$phone        = noo_umbra_get_option('noo_header_topbar_phone', '') ;
$top_wishlist = noo_umbra_get_option('noo_header_topbar_wishlist', true) ;
$my_account   = noo_umbra_get_option('noo_header_topbar_my_account', true) ;
$checkout       = noo_umbra_get_option('noo_header_topbar_checkout', true) ;
?>
<?php if( $topbar == true ): ?>
    <div class="noo-topbar">
        <div class="noo-container">
            <ul class="pull-left noo-topbar-left">
                <?php if( isset($mail) && !empty($mail) ): ?>
                    <li>
                        <a href="mailto:<?php echo esc_attr($mail); ?>"><i class="fa fa-envelope"></i><?php echo esc_html($mail); ?></a>
                    </li>
                <?php endif; ?>

                <?php if( isset($phone) && !empty($phone) ): ?>
                    <li>
                        <a href="tel:<?php echo esc_attr(str_replace(' ','',$phone)); ?>"><i class="fa fa-phone"></i><?php echo esc_html($phone); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="pull-right noo-topbar-right">

                <?php if( isset($top_wishlist) && $top_wishlist == true ): ?>
                    <li>
                        <a href="<?php echo esc_url(get_page_link( get_option('yith_wcwl_wishlist_page_id') )); ?>"><?php esc_html_e('My Wishlist','noo-umbra') ?></a>
                    </li>
                <?php endif; ?>

                <?php if( isset($my_account) && $my_account == true ): ?>
                    <li>
                        <a href="<?php echo esc_url(get_page_link( get_option('woocommerce_myaccount_page_id') )); ?>"><?php esc_html_e('My Account','noo-umbra') ?></a>
                    </li>
                <?php endif; ?>

                <?php if( isset($checkout) && $checkout == true ): ?>
                    <li>
                        <a href="<?php echo esc_url(get_page_link( get_option('woocommerce_checkout_page_id') )); ?>"><?php esc_html_e('Checkout','noo-umbra') ?></a>
                    </li>
                <?php endif; ?>

            </ul><!-- .noo-topbar-right -->
        </div><!--end .noo-container-->
    </div><!--end .noo-topbar-->

<?php endif; ?>

<div class="navbar-wrapper">
    <div class="navbar navbar-default" role="navigation">
        <div class="noo-container">

            <div class="noo-navbar-header">
                <?php if( isset($search) && $search == true ): ?>
                    <a class="noo-search" href="#">
                        <i class="icon_search"></i>
                        <?php echo esc_html__('Search','noo-umbra'); ?>
                    </a>
                <?php endif; ?>
                <div class="navbar-logo">
                    <?php noo_umbra_the_custom_logo(); ?>
                </div><!--end .navbar-logo-->
                <ul class="noo-cart-simple">
                    <?php if(function_exists('noo_umbra_minicart') && $cart == true) echo noo_umbra_minicart(); ?>
                </ul>
                <button data-target=".nav-collapse" class="btn-navbar noo_icon_menu icon_menu" type="button">
                </button>

            </div><!--end .noo-navbar-header-->

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
            </nav><!--end .noo-main-menu-->

        </div><!--end .noo-container-->
    </div><!--end .navbar-default-->
</div><!--end .navbar-wrapper-->
