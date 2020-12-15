<?php
/**
 * The main template file
 *
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main noo-container">
        <div class="noo-row">
            <div class="<?php noo_umbra_main_class(); ?>">
                <?php if ( have_posts() ) : ?>

                    <?php
                    $is_masonry = is_home() ? ( 'masonry' == get_theme_mod( 'noo_blog_style', 'list') ) : false;
                    if( $is_masonry ) : 
                        wp_enqueue_script('imagesloaded');
                        wp_enqueue_script( 'infinitescroll' );
                        wp_enqueue_script('isotope');

                        $columns = get_theme_mod( 'noo_blog_masonry_column', 3 );
                    ?>
                        <div class="noo-blog-masonry-wraper">
                            <div class="noo-row noo-blog-masonry">
                                <?php
                                // Start the loop.
                                while ( have_posts() ) : the_post(); ?>
                                    <div id="post-<?php the_ID(); ?>" class="noo-blog-masonry-item noo-sm-6 noo-md-<?php echo esc_attr(12 / $columns); ?>">
                                        <?php 
                                        /*
                                         * Include the Masonry template for the content.
                                         */
                                        get_template_part( 'content', 'masonry' );
                                        ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="blog-pagination">
                                <div class="noo-load-image"></div>
                                <?php noo_umbra_pagination_normal(); ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );

                            // End the loop.
                        endwhile;

                        noo_umbra_pagination_normal();

                    endif;

                // If no content, include the "No posts found" template.
                else :
                    get_template_part( 'content', 'none' );
                endif;
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>


    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
