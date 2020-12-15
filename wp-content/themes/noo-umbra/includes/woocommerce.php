<?php

if ( class_exists( 'woocommerce' ) ) {

	if ( ! function_exists('noo_umbra_wc_related_products_columns') ) {
		function noo_umbra_wc_related_products_columns() {

			return noo_umbra_get_option('noo_woocommerce_product_grid_column', 5);
		}
		add_filter( 'woocommerce_related_products_columns', 'noo_umbra_wc_related_products_columns' );
	}


	add_filter( 'woocommerce_enqueue_styles', 'noo_umbra_dequeue_styles' );
	if ( ! function_exists( 'noo_umbra_dequeue_styles' ) ) {
		function noo_umbra_dequeue_styles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
			return $enqueue_styles;
		}
	}

    // ========= remove action
    remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
    remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);

    if ( ! function_exists( 'noo_umbra_woocommerce_loop_shop_per_page' ) ) {
		// Number of products per page
		function noo_umbra_woocommerce_loop_shop_per_page() {
			return noo_umbra_get_option( 'noo_shop_num', 12 );
		}
	}
	add_filter( 'loop_shop_per_page', 'noo_umbra_woocommerce_loop_shop_per_page' );

	if ( ! function_exists( 'noo_umbra_add_to_cart_fragments' ) ) {
		function noo_umbra_add_to_cart_fragments( $fragments ) {
			$output = noo_umbra_minicart();
			$fragments['.minicart'] = $output;
			$fragments['.mobile-minicart-icon'] = noo_umbra_minicart_mobile();
			return $fragments;
		}
	}
	add_filter( 'woocommerce_add_to_cart_fragments', 'noo_umbra_add_to_cart_fragments' );

	if ( ! function_exists( 'noo_umbra_woocommerce_remove_cart_item' ) ) {
		function noo_umbra_woocommerce_remove_cart_item() {
			global $woocommerce;
			$response = array();
			
			if ( ! isset( $_GET['item'] ) && ! isset( $_GET['_wpnonce'] ) ) {
				exit();
			}
			$woocommerce->cart->set_quantity( $_GET['item'], 0 );
			
			$cart_count = $woocommerce->cart->cart_contents_count;
			$response['count'] = $cart_count != 0 ? $cart_count : "";
			$response['minicart'] = noo_umbra_minicart( true );
			
			// widget cart update
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();
			$response['widget'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';
			
			echo json_encode( $response );
			exit();
		}
	}
	add_action( 'wp_ajax_noo_umbra_woocommerce_remove_cart_item', 'noo_umbra_woocommerce_remove_cart_item' );
	add_action( 'wp_ajax_nopriv_noo_umbra_woocommerce_remove_cart_item', 'noo_umbra_woocommerce_remove_cart_item' );

	if ( ! function_exists( 'noo_umbra_product_items_text' ) ) {
		function noo_umbra_product_items_text( $count ) {
			$product_item_text = "";
			
			if ( $count > 1 ) {
				$product_item_text = str_replace( '%', number_format_i18n( $count ), esc_html__( '% items', 'noo-umbra' ) );
			} elseif ( $count == 0 ) {
				$product_item_text = esc_html__( '0 items', 'noo-umbra' );
			} else {
				$product_item_text = esc_html__( '1 item', 'noo-umbra' );
			}
			
			return $product_item_text;
		}
	}

	if ( ! function_exists( 'noo_umbra_minicart_mobile' ) ) {
		// Mobile icon
		function noo_umbra_minicart_mobile() {
			if( ! noo_umbra_get_option('noo_header_nav_icon_cart', true ) ) {
				return '';
			}

			global $woocommerce;
			
			$cart_output = "";
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = $woocommerce->cart->cart_contents_count;
			$cart_output = '<a href="' . wc_get_cart_url() . '" title="' . esc_html__( 'View Cart', 'noo-umbra' ) .
				 '"  class="mobile-minicart-icon"><i class="fa fa-shopping-cart"></i><span>' . $cart_count . '</span></a>';
			return $cart_output;
		}
	}
	
	if ( ! function_exists( 'noo_umbra_minicart' ) ) {
		// Menu cart
		function noo_umbra_minicart( $content = false ) {
			global $woocommerce;
			
			$cart_output = "";
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = $woocommerce->cart->cart_contents_count;
			$cart_count_text = noo_umbra_product_items_text( $cart_count );
			
			$cart_has_items = '';
			if ( $cart_count != "0" ) {
				$cart_has_items = ' has-items';
			}
			
			$output = '';
			if ( ! $content ) {
				$output .= '<li id="nav-menu-item-cart" class="menu-item noo-menu-item-cart minicart"><a title="' .
					 esc_html__( 'View cart', 'noo-umbra' ) . '" class="cart-button" href="' . wc_get_cart_url() .
					 '">' . '<span class="cart-item' . $cart_has_items . '"><i class="icon_bag_alt"></i>';
	            $output .= "<span class='cart-count'>" . $cart_count . "</span>";
	            $output .= "<span class='cart-name-and-total'>". esc_html__('Cart','noo-umbra') ."(".$cart_count.")".$cart_total."</span>";
				$output .= '</span>';
				$output .= '</a>';
				$output .= '<div class="noo-minicart">';
			}
			if ( $cart_count != "0" ) {
				$output .= '<div class="minicart-header">' . $cart_count_text . ' ' .
					 esc_html__( 'in the shopping cart', 'noo-umbra' ) . '</div>';
				$output .= '<div class="minicart-body">';
				foreach ( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) {
					
					$cart_product = $cart_item['data'];
					$product_title = $cart_product->get_title();
					$product_short_title = ( strlen( $product_title ) > 25 ) ? substr( $product_title, 0, 22 ) . '...' : $product_title;
					
					if ( $cart_product->exists() && $cart_item['quantity'] > 0 ) {
						$output .= '<div class="cart-product clearfix">';
						$output .= '<div class="cart-product-image"><a class="cart-product-img" href="' .
							 get_permalink( $cart_item['product_id'] ) . '">' . $cart_product->get_image() . '</a></div>';
						$output .= '<div class="cart-product-details">';
						$output .= '<div class="cart-product-title"><a href="' . get_permalink( $cart_item['product_id'] ) .
							 '">' .
							 apply_filters( 'woocommerce_cart_widget_product_title', $product_short_title, $cart_product ) .
							 '</a></div>';
						$output .= '<div class="cart-product-price">' . esc_html__( "Price", "noo-umbra" ) . ' ' .
							 wc_price( $cart_product->get_price() ) . '</div>';
						$output .= '<div class="cart-product-quantity">' . esc_html__( 'Quantity', 'noo-umbra' ) . ' ' .
							 $cart_item['quantity'] . '</div>';
						$output .= '</div>';
						$output .= apply_filters( 
							'woocommerce_cart_item_remove_link', 
							sprintf( 
								'<a href="%s" class="remove icon_trash_alt" title="%s"></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ), 
								esc_html__( 'Remove this item', 'noo-umbra' ) ),
							$cart_item_key );
						$output .= '</div>';
					}
				}
				$output .= '</div>';
				$output .= '<div class="minicart-footer">';
				$output .= '<div class="minicart-total">' . esc_html__( 'Cart Subtotal', 'noo-umbra' ) . ' ' . $cart_total .
					 '</div>';
				$output .= '<div class="minicart-actions clearfix">';
				if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
					$cart_url = apply_filters( 'woocommerce_get_cart_url', wc_get_cart_url() );
					$checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() );
					
					$output .= '<a class="button" href="' . esc_url( $cart_url ) . '"><span class="text">' .
						 esc_html__( 'View Cart', 'noo-umbra' ) . '</span></a>';
					$output .= '<a class="checkout-button button" href="' . esc_url( $checkout_url ) .
						 '"><span class="text">' . esc_html__( 'Checkout', 'noo-umbra' ) . '</span></a>';
				} else {
					
					$output .= '<a class="button" href="' . esc_url( $woocommerce->cart->wc_get_cart_url() ) .
						 '"><span class="text">' . esc_html__( 'View Cart', 'noo-umbra' ) . '</span></a>';
					$output .= '<a class="checkout-button button" href="' . esc_url( 
						wc_get_checkout_url() ) . '"><span class="text">' .
						 esc_html__( 'Checkout', 'noo-umbra' ) . '</span></a>';
				}
				$output .= '</div>';
				$output .= '</div>';
			} else {
				$output .= '<div class="minicart-header">' . esc_html__( 'Your shopping bag is empty.', 'noo-umbra' ) . '</div>';
				$shop_page_url = "";
				if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
					$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
				} else {
					$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
				}
				
				$output .= '<div class="minicart-footer">';
				$output .= '<div class="minicart-actions clearfix">';
				$output .= '<a class="button pull-left" href="' . esc_url( $shop_page_url ) . '"><span class="text">' .
					 esc_html__( 'Go to the shop', 'noo-umbra' ) . '</span></a>';
				$output .= '</div>';
				$output .= '</div>';
			}
			
			if ( ! $content ) {
				$output .= '</div>';
				$output .= '</li>';
			}
			
			return $output;
		}
	}

	if ( ! function_exists( 'noo_umbra_navbar_shop_icons' ) ) {
		function noo_umbra_navbar_shop_icons( $items, $args ) {

			if( ! NOO_WOOCOMMERCE_EXIST ) return $items;

			if ( $args->theme_location == 'primary' ) {
	            $minicart = noo_umbra_minicart();
	            $items .= $minicart;
				if( noo_umbra_get_option('noo_header_nav_icon_wishlist', true ) && defined( 'YITH_WCWL' ) ) {
					$wishlist_url = YITH_WCWL()->get_wishlist_url();
					$wishlist = '<li id="nav-menu-item-wishlist" class="menu-item noo-menu-item-wishlist"><a title="' .
					 esc_html__( 'View Wishlist', 'noo-umbra' ) . '" class="wishlist-button" href="' . $wishlist_url .
					 '"><i class="fa fa-heart"></i></a></li>';

					$items .= $wishlist;
				}
			}
			return $items;
		}
	}
	 //add_filter( 'wp_nav_menu_items', 'noo_umbra_navbar_shop_icons', 10, 2 );

	if ( ! function_exists( 'noo_umbra_woocommerce_update_product_image_size' ) ) {
		function noo_umbra_woocommerce_update_product_image_size() {
			$catalog = array( 'width' => '500', 'height' => '700', 'crop' => 1 );
			$single = array( 'width' => '500', 'height' => '700', 'crop' => 1 );
			$thumbnail = array( 'width' => '100', 'height' => '100', 'crop' => 1 );
			update_option( 'shop_catalog_image_size', $catalog );
			update_option( 'shop_single_image_size', $single );
			update_option( 'shop_thumbnail_image_size', $thumbnail );
		}
	}
	
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
		add_action( 'init', 'noo_umbra_woocommerce_update_product_image_size', 1 );
	}
	
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	if ( ! function_exists( 'noo_umbra_woocommerce_shop_columns' ) ) {
		function noo_umbra_woocommerce_shop_columns() {

			if ( is_product() ) {

				return noo_umbra_get_option('noo_woocommerce_product_grid_column', 5);
			}
			return noo_umbra_get_option('noo_shop_grid_column', 3);
		}
	}

	add_filter( 'loop_shop_columns', 'noo_umbra_woocommerce_shop_columns' );
	
	if ( ! function_exists( 'noo_umbra_template_loop_product_get_frist_thumbnail' ) ) {
		function noo_umbra_template_loop_product_get_frist_thumbnail() {
			global $product, $post;
			$image = '';
			if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
				$attachment_ids = $product->get_gallery_image_ids();
				$image_count = 0;
				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {
						if ( noo_umbra_get_post_meta( $attachment_id, '_woocommerce_exclude_image' ) )
							continue;
						
						$image = wp_get_attachment_image( $attachment_id, 'shop_catalog' );
						
						$image_count++;
						if ( $image_count == 1 )
							break;
					}
				}
			} else {
				$attachments = get_posts( 
					array( 
						'post_type' => 'attachment', 
						'numberposts' => - 1, 
						'post_status' => null, 
						'post_parent' => $post->ID, 
						'post__not_in' => array( get_post_thumbnail_id() ), 
						'post_mime_type' => 'image', 
						'orderby' => 'menu_order', 
						'order' => 'ASC' ) );
				$image_count = 0;
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						
						if ( noo_umbra_get_post_meta( $attachment->ID, '_woocommerce_exclude_image' ) == 1 )
							continue;
						
						$image = wp_get_attachment_image( $attachment->ID, 'shop_catalog' );
						
						$image_count++;
						
						if ( $image_count == 1 )
							break;
					}
				}
			}
			return $image;
		}
	}
		
	// Wishlist
	if ( ! function_exists( 'noo_umbra_woocommerce_wishlist_is_active' ) ) {

		/**
		 * Check yith-woocommerce-wishlist plugin is active
		 *
		 * @return boolean .TRUE is active
		 */
		function noo_umbra_woocommerce_wishlist_is_active() {
			$active_plugins = (array) get_option( 'active_plugins', array() );
			
			if ( is_multisite() )
				$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			
			return in_array( 'yith-woocommerce-wishlist/init.php', $active_plugins ) ||
				 array_key_exists( 'yith-woocommerce-wishlist/init.php', $active_plugins );
		}
	}
	if ( ! function_exists( 'noo_umbra_woocommerce_compare_is_active' ) ) {

		/**
		 * Check yith-woocommerce-compare plugin is active
		 *
		 * @return boolean .TRUE is active
		 */
		function noo_umbra_woocommerce_compare_is_active() {
			$active_plugins = (array) get_option( 'active_plugins', array() );
			
			if ( is_multisite() )
				$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			
			return in_array( 'yith-woocommerce-compare/init.php', $active_plugins ) ||
				 array_key_exists( 'yith-woocommerce-compare/init.php', $active_plugins );
		}
	}
	
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash' );
	

	
	// Related products
	add_filter( 'woocommerce_output_related_products_args', 'noo_umbra_woocommerce_output_related_products_args' );

	if ( ! function_exists( 'noo_umbra_woocommerce_output_related_products_args' ) ) {
		function noo_umbra_woocommerce_output_related_products_args() {
			$args = array('posts_per_page' => noo_umbra_get_option('noo_woocommerce_product_related', 5));
			return $args;
		}
	}
	
	// Upsell products
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'noo_umbra_woocommerce_upsell_display', 15 );
	if ( ! function_exists( 'noo_umbra_woocommerce_upsell_display' ) ) {

		function noo_umbra_woocommerce_upsell_display() {
			if ( noo_umbra_get_option( 'noo_shop_layout', 'fullwidth' ) === 'fullwidth' ) {
				woocommerce_upsell_display( - 1, 4 );
			} else {
				woocommerce_upsell_display( - 1, 3 );
			}
		}
	}

    // ==============================================
    //   More code for theme umbra
    // ==============================================

    //remove cart
    // check for empty-cart get param to clear the cart
    add_action( 'init', 'noo_umbra_woocommerce_clear_cart_url' );
    if ( ! function_exists( 'noo_umbra_woocommerce_clear_cart_url' ) ) {
	    function noo_umbra_woocommerce_clear_cart_url() {
	        global $woocommerce;

	        if ( isset( $_GET['empty-cart'] ) ) {
	            $woocommerce->cart->empty_cart();
	        }
	    }
    }

    // woocommerce_share
    add_action('woocommerce_share','noo_umbra_social_share_product');

    // product item
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

    // title product
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

    if( !function_exists('noo_umbra_shop_lop_item_title') ){

        add_action('woocommerce_shop_loop_item_title','noo_umbra_shop_lop_item_title',10);
        function noo_umbra_shop_lop_item_title(){
            $term = get_the_terms(get_the_ID(),'product_cat');
            echo '<h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
            if( isset($term) && !empty($term) && ! is_wp_error( $term )  ){
                echo '<span class="posted_in"><a href="'.esc_url(get_term_link($term[0]->term_id)).'">'.esc_html($term[0]->name).'</a></span>';
            }
        }
    }

    // woocommerce_template_loop_more_meta
    add_action( 'woocommerce_after_shop_loop_item_list', 'noo_umbra_woocommerce_template_loop_more_meta', 10 );
    if ( ! function_exists( 'noo_umbra_woocommerce_template_loop_more_meta' ) ) {
	    function noo_umbra_woocommerce_template_loop_more_meta(){
	        ?>
	            <?php
	            if ( noo_umbra_woocommerce_compare_is_active() ) {
	                new YITH_Woocompare_Frontend();
	                echo do_shortcode( '[yith_compare_button]' );
	            }
	            if ( noo_umbra_woocommerce_wishlist_is_active() ) {
	                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	            }
	            ?>
	        <?php
	    }
    }

    // loop thumbnail list
    add_action( 'woocommerce_before_shop_loop_item_title_list', 'noo_umbra_template_loop_product_thumbnail_list', 10 );
    if ( ! function_exists( 'noo_umbra_template_loop_product_thumbnail_list' ) ) {
	    function noo_umbra_template_loop_product_thumbnail_list() {
	       ?>
	        <div class="noo-product-thumbnail">
	            <?php the_post_thumbnail('noo-thumbnail-product'); ?>
	        </div>
	    <?php
	    }
    }

    // =================================
    // == Product style 2
    // =================================
    // Loop thumbnail product 2
    remove_action( 'woocommerce_before_shop_loop_item_title2', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );

    if ( ! function_exists( 'noo_umbra_template_loop_product_thumbnail' ) ) {
	    function noo_umbra_template_loop_product_thumbnail() {
	        global $product;
	        $attachment_ids = $product->get_gallery_image_ids();
	        ?>
	        <div class="noo-product-thumbnail">
	            <a href="<?php the_permalink() ?>" class="noo-thumbnail-product hover-device">
					<?php if(has_post_thumbnail()): ?>
	                <?php the_post_thumbnail('noo-thumbnail-product');
	                if( isset($attachment_ids) && !empty($attachment_ids) ){
	                    echo wp_get_attachment_image(esc_attr($attachment_ids[0]),'noo-thumbnail-product',false,array('class'=>'second-img'));
	                }
	                ?>
				<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/prduct-no-thumbnail.png" />
				<?php endif; ?>
	            </a>
	            <?php noo_umbra_teamplate_loop_product_action(); ?>
	        </div>
	    <?php
	    }
    }

    if ( ! function_exists( 'noo_umbra_template_loop_product_thumbnail2' ) ) {
	    // Loop thumbnail product 3
	    function noo_umbra_template_loop_product_thumbnail2() {
	        global $product;
	        $attachment_ids = $product->get_gallery_image_ids();

	        ?>
	        <div class="noo-product-thumbnail">
	            <a href="<?php the_permalink() ?>" class="noo-thumbnail-product hover-device">
					<?php if(has_post_thumbnail()): ?>
						<?php
						the_post_thumbnail('noo-thumbnail-sq');
						if( isset($attachment_ids) && !empty($attachment_ids) ){
							echo wp_get_attachment_image(esc_attr($attachment_ids[0]),'noo-thumbnail-sq',false,array('class'=>'second-img'));
						}

						?>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/prduct-no-thumbnail.png" />
					<?php endif; ?>
	            </a>
	            <?php noo_umbra_teamplate_loop_product_action(); ?>
	        </div>
	    <?php
	    }
    }
    if ( ! function_exists( 'noo_umbra_template_loop_product_thumbnail3' ) ) {
	    // Loop thumbnail for featured
	    function noo_umbra_template_loop_product_thumbnail3() {
	        global $product;
	        $attachment_ids = $product->get_gallery_image_ids();

	        ?>
	        <div class="noo-product-thumbnail">
	            <a href="<?php the_permalink() ?>" class="noo-thumbnail-product hover-device">
					<?php if(has_post_thumbnail()): ?>
					<?php
	                the_post_thumbnail('full');
	                if( isset($attachment_ids) && !empty($attachment_ids) ){
	                    echo wp_get_attachment_image(esc_attr($attachment_ids[0]),'full',false,array('class'=>'second-img'));
	                }
	                ?>
					<?php else: ?>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/prduct-no-thumbnail.png" />
					<?php endif; ?>
	            </a>
	            <?php noo_umbra_teamplate_loop_product_action(); ?>
	        </div>
	    <?php
	    }
    }
    if ( ! function_exists( 'noo_umbra_teamplate_loop_product_action' ) ) {
	    function noo_umbra_teamplate_loop_product_action(){
	        ?>
	        <div class="noo-product-meta">
	            <?php
	            if ( noo_umbra_woocommerce_compare_is_active() ) {
	            	$class_compare_plugin = WP_PLUGIN_DIR . '/yith-woocommerce-compare/includes/class.yith-woocompare-frontend.php';
	            	
	            	if ( file_exists( $class_compare_plugin ) ) {
	                	require_once($class_compare_plugin);
	                    new YITH_Woocompare_Frontend();
	                    echo do_shortcode( '[yith_compare_button]' );
	            	}
	            }
	            if ( noo_umbra_woocommerce_wishlist_is_active() ) {
	                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	            }
	            ?>
	            <span data-id="<?php the_ID(); ?>" class="noo-quick-view icon_zoom-in_alt"></span>
	        </div>
	        <?php
	    }
    }

    // Loop after title 2
    add_action( 'woocommerce_after_shop_loop_item_title2', 'woocommerce_template_loop_rating', 10 );
    add_action( 'woocommerce_after_shop_loop_item_title2', 'woocommerce_template_loop_price', 5 );
    // =================================
    // ==  End Product style 2
    // =================================

    // Loop thumbnail
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'noo_umbra_template_loop_product_thumbnail_slider', 10 );
    if ( ! function_exists( 'noo_umbra_template_loop_product_thumbnail_slider' ) ) {
	    function noo_umbra_template_loop_product_thumbnail_slider() {
	        global $product, $post;
	        $noo_style  = noo_umbra_get_option('noo_shop_default_style','one');

	        $attachment_ids = $product->get_gallery_image_ids();
	        $thumb_id       = get_post_thumbnail_id($post->ID);
	        if( isset($attachment_ids) && !empty($attachment_ids) ){
	            if( isset($thumb_id) && !empty($thumb_id) ){
	                array_unshift($attachment_ids,(int)$thumb_id);
	                $new_attchment = $attachment_ids;
	                wp_enqueue_script( 'carousel' );
	            }
	        }
	        ?>
	        <div class="noo-product-thumbnail">
	            <div class="noo-product-meta">
	                <?php
	                    if ( noo_umbra_woocommerce_compare_is_active() ) {
	                    	if( class_exists( 'YITH_Woocompare_Frontend' ) ) {
		                        new YITH_Woocompare_Frontend();
		                        echo do_shortcode( '[yith_compare_button]' );
	                    	}
	                    }
	                    if ( noo_umbra_woocommerce_wishlist_is_active() ) {
	                        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	                    }
	                ?>
	                <span data-id="<?php the_ID(); ?>" class="noo-quick-view icon_zoom-in_alt"></span>
	            </div>
	            <?php if( isset($new_attchment) && !empty($new_attchment) && $noo_style == "one" ):
	                ?>

						<div class="noo-product-slider">
							<?php foreach($new_attchment as $attachment_id): ?>
							<a href="<?php the_permalink() ?>" class="hover-device">
								<?php echo wp_get_attachment_image($attachment_id, array(300, 300) ,false,array('class'=>'product-one-thumb')); ?>
							</a>
							<?php endforeach;  ?>
						</div>

	            <?php else: ?>

				<a href="<?php the_permalink() ?>" class="hover-device">
					<?php if (has_post_thumbnail()): ?>
						<?php the_post_thumbnail(array(300, 300), array('class' => 'product-one-thumb')); ?>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/prduct-no-thumbnail.png"/>
					<?php endif; ?>
				</a>
	            <?php endif; ?>
	        </div>
	    <?php
	    }
    }
    //woocommerce_before_shop_loop
    add_action( 'woocommerce_before_shop_loop', 'noo_umbra_woocommerce_attribute_ordering', 35 );
    if ( ! function_exists( 'noo_umbra_woocommerce_attribute_ordering' ) ) {
	    function noo_umbra_woocommerce_attribute_ordering(){
	            ?>
	            <div class="pull-right noo_woocommerce-catalog">
					<button class="shop-meta-icon icon_menu" type="button">
					</button>

	              <?php
	                $filter_status = noo_umbra_get_option('noo_shop_default_attribute','no');
	                if( $filter_status == 'yes' ){

	                // color
	                $attribute_array      = array();
	                $attribute_taxonomies = wc_get_attribute_taxonomies();

	                if ( $attribute_taxonomies ) {
	                    foreach ( $attribute_taxonomies as $tax ) {
	                        if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
	                            $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
	                        }
	                    }
	                }
	                if( isset($attribute_array) && !empty($attribute_array) ){
	                    foreach($attribute_array as $atts_name){
	                        $term_name =  'pa_'.$atts_name;
	                        $terms = get_terms( $term_name, 'menu_order' );

	                        if ( 0 < count( $terms ) && !is_wp_error($terms) ) {
	                            echo '<form class="pull-left noo-shop-filter" method="get">';
	                            echo '<select class="noo-woo-filter" name="filter_'.esc_attr($atts_name).'">';
	                                echo '<option value="">' .sprintf( esc_html__( 'Filter %s', 'noo-umbra' ), $atts_name ) . '</option>';
	                                foreach ( $terms as $term ) {
	                                    echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( isset( $_GET[ 'filter_' . $atts_name ] ) ? $_GET[ 'filter_' . $atts_name ] : '' , $term->term_id, false ) . '>' . esc_html( $term->name ) . '</option>';
	                                }
	                            echo '</select>';

	                                // Keep query string vars intact
	                                foreach ( $_GET as $key => $val ) {
	                                    if ( 'filter_'.$atts_name === $key || 'submit' === $key ) {
	                                        continue;
	                                    }
	                                    if ( is_array( $val ) ) {
	                                        foreach( $val as $innerVal ) {
	                                            echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
	                                        }
	                                    } else {
	                                        echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
	                                    }
	                                }

	                            echo '</form>';
	                        }
	                    }
	                }
	                wc_enqueue_js( "
	                            jQuery( 'form' ).on( 'change', 'select.noo-woo-filter', function() {
	                                    jQuery( this ).closest( 'form' ).submit();
	                                });

						" );
	                }
	              ?>
	                <form class="pull-left noo-shop-filter" method="get">
	                    <?php
	                    $style_product = noo_umbra_get_option('noo_shop_default_layout','grid');
	                    if( isset($_GET['filter_style']) && $_GET['filter_style'] != ''){
	                        $style_product = $_GET['filter_style'];
	                    }
	                    ?>
	                    <select class="noo-woo-filter" name="filter_style">
	                        <option value="detault">
	                            <?php echo esc_html__('Filter style','noo-umbra'); ?>
	                        </option>
	                        <option value="grid" <?php selected('grid',$style_product); ?>>
	                            <?php echo esc_html__('Grid','noo-umbra'); ?>
	                        </option>
	                        <option value="list" <?php selected('list',$style_product); ?>>
	                            <?php echo esc_html__('List','noo-umbra'); ?>
	                        </option>
	                    </select>
	                    <?php

	                    // Keep query string vars intact
	                    foreach ( $_GET as $key => $val ) {
	                        if ( 'filter_style' === $key || 'submit' === $key ) {
	                            continue;
	                        }
	                        if ( is_array( $val ) ) {
	                            foreach( $val as $innerVal ) {
	                                echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
	                            }
	                        } else {
	                            echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
	                        }
	                    }
	                    ?>
	                </form>

	            </div>
	        <?php

	    }
    }

    // Fiter
    add_action( 'woocommerce_product_query', 'noo_umbra_woocommerce_attribute_filter' );

    if ( ! function_exists( 'noo_umbra_woocommerce_attribute_filter' ) ) {
	    function noo_umbra_woocommerce_attribute_filter($query){
	        $attribute_array      = array();
	        $attribute_taxonomies = wc_get_attribute_taxonomies();

	        if ( $attribute_taxonomies ) {
	            foreach ( $attribute_taxonomies as $tax ) {
	                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
	                    $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
	                }
	            }
	        }
	        $taxquery = array('relation' => 'AND');
	        if( isset($attribute_array) && !empty($attribute_array) ){
	            foreach($attribute_array as $atts_name){
	                if( isset($_GET['filter_'.$atts_name]) && !empty($_GET['filter_'.$atts_name]) ) {
	                    $filer = $_GET['filter_'.$atts_name];
	                    $taxquery[] = array(
	                        'taxonomy' 	=> 'pa_'.$atts_name,
	                        'terms' 	=> $filer,
	                        'field' 	=> 'term_id'
	                    );


	                }
	            }
	            if( isset($taxquery) && !empty($taxquery) ) {
	                $query->set('tax_query', $taxquery);
	            }
	        }

	    }
    }


    // get product
    add_action('wp_ajax_noo_umbra_product_ajax','noo_umbra_product_ajax');
    add_action('wp_ajax_nopriv_noo_umbra_product_ajax','noo_umbra_product_ajax');
    if ( ! function_exists( 'noo_umbra_product_ajax' ) ) {
	    function noo_umbra_product_ajax(){
	        $style   = 'one';
	        $catid   = '';
	        $limit   = 10;
	        $order   = 'DESC';
	        $orderby = 'date';
	        $masonry = 'product_masonry';

	        if( isset($_POST['limit']) && !empty($_POST['limit'])){
	            $limit = $_POST['limit'];
	        }

	        if( isset($_POST['catid']) && !empty($_POST['catid'])){
	            $catid = $_POST['catid'];
	        }

	        if( isset($_POST['style']) && !empty($_POST['style'])){
	            $style = $_POST['style'];
	        }

	        if( isset($_POST['orderby']) && !empty($_POST['orderby'])){
	            $orderby = $_POST['orderby'];
	        }

	        if( isset($_POST['order']) && !empty($_POST['order'])){
	            $order = $_POST['order'];
	        }
	        if( isset($_POST['masonry']) && !empty($_POST['masonry'])){
	            $masonry = $_POST['masonry'];
	        }
	        if( $style == 'three' ){
	            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
	            add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
	        }
	        $args = array(
	            'post_type'         =>  'product',
	            'posts_per_page'    =>   $limit,
	            'orderby'       => $orderby,
	            'order'         =>  $order
	        );

	        if( !empty($catid)){
	            $args['tax_query'][] = array(
	                'taxonomy'  =>  'product_cat',
	                'field'     =>  'term_id',
	                'terms'     =>  $catid
	            );
	        }

	        ?>

	            <?php
	            $query = new WP_Query($args);
	            if( $query->have_posts() ):
	                if ($style == 'one') {
	                    while ($query->have_posts()): $query->the_post();

	                        wc_get_template_part('content', 'product');
	                    endwhile;
	                    wp_reset_postdata();
	                } elseif ( $style == 'two' || $style == 'three' ) {
	                    while ($query->have_posts()): $query->the_post();

	                        // add image size for check style and _featured
	                        $noo_featured = noo_umbra_get_post_meta(get_the_ID(),'_featured');
	                        if( $masonry == 'product_masonry' && $noo_featured == 'yes'){
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
	                            add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
	                        }elseif( $style == 'three'){
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
	                            add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
	                        }elseif( $style == 'two'){
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail3', 10 );
	                            remove_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail2', 10 );
	                            add_action( 'woocommerce_before_shop_loop_item_title2', 'noo_umbra_template_loop_product_thumbnail', 10 );
	                        }

	                        wc_get_template_part('content', 'product2');
	                    endwhile;
	                    wp_reset_postdata();
	                }
	            endif; ?>
	            <?php if( $masonry == 'product_masonry' ): ?>
	                <script>
	                    (function($){
	                        "use strict";
	                        var $container = $('.product_masonry');
	                        $container.isotope('destroy'); //destroying isotope
	                        $container.imagesLoaded(function(){
	                            $container.isotope({
	                                itemSelector : '.noo-product-item',
	                                transitionDuration : '0.8s',
	                                masonry : {
	                                    'gutter' : 0
	                                }
	                            });

	                        });
	                    })(jQuery);

	                </script>
	            <?php endif; ?>
	        <?php
	        exit();
	    }
    }

	// noo umbra quick view
	add_action('wp_ajax_noo_umbra_product_quick_view','noo_umbra_product_quick_view');
	add_action('wp_ajax_nopriv_noo_umbra_product_quick_view','noo_umbra_product_quick_view');
	if(!function_exists('noo_umbra_product_quick_view')) :
		function noo_umbra_product_quick_view(){

			$id = $_POST['p_id'];
			if( !isset($id) && empty($id) ) return;
			$args = array(
				'post_type' =>  'product',
				'p'         =>  $id
			);
			$query = new WP_Query( $args );
			if( $query->have_posts() ):

				remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);
				remove_action('woocommerce_single_product_summary','noo_umbra_link_product',3);
				remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
				while( $query->have_posts() ):
					$query->the_post();
					global $product;
					if( $product->is_type( 'simple' ) ){
						add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
					}
					if( $product->is_type( 'variable' ) ){
						add_action('woocommerce_single_product_summary','noo_umbra_link_product',30);
					}

					?>
					<div class="quick-left">
						<?php
						the_post_thumbnail('full');
						?>
					</div>
					<div class="quick-right">

						<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
						?>
					</div>
					<?php
				endwhile;
			endif; wp_reset_postdata();

			wp_die();
		}
	endif;
	if ( ! function_exists( 'noo_umbra_link_product' ) ) {
		function noo_umbra_link_product(){
			?>
			<a class="noo-quick-link" href="<?php the_permalink() ?>"><?php esc_html_e('Select options','noo-umbra'); ?></a>
			<?php
		}
	}
	if ( ! function_exists( 'noo_umbra_template_noo_single_excerpt' ) ) {
		function noo_umbra_template_noo_single_excerpt(){
			?>
				<div class="description">
					<?php the_excerpt() ?>
				</div>
			<?php
		}
	}
}
if ( ! function_exists( 'noo_umbra_get_from_product' ) ) {
	function noo_umbra_get_from_product() {
		?>
		<form method="GET" class="form-horizontal noo-umbra-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="note-search"><?php echo esc_html__( 'Type and Press Enter to Search', 'noo-umbra' ); ?></label>
			<input type="search" name="s" class="form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Enter keyword to search...', 'noo-umbra' ); ?>" />
			<button type="submit" class="noo-search-submit"><i class="icon_search"></i></button>
			<input type="hidden" name="post_type" value="product">
		</form>
	<?php
	}
}

