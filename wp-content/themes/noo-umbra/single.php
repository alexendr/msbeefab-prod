
<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main noo-container">
        <div class="noo-row">
            <div class="<?php noo_umbra_main_class(); ?>">
                <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content', get_post_format() );  ?>

                        <?php noo_umbra_related_post(); ?>

                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                        // End the loop.
                    endwhile;
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>


    </main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer(); ?>