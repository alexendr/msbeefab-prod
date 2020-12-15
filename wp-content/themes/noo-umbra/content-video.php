<?php
/**
 * Layout video
 *
 * @package     Noo_Umbra
 * @author      KENT <tuanlv@vietbrain.com>
 * @version     1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( is_singular() ) : ?>
        <header class="entry-header">
                
            <h1>
                <?php the_title(); ?>
            </h1>
            <div class="noo-info-meta">
                <?php noo_umbra_meta_info(); ?>
            </div>
            
        </header>
    <?php endif; ?>

    <?php if( noo_umbra_has_featured_content()) : ?>
        <div class="content-featured">
            <?php echo noo_umbra_get_featured_content(); ?>
        </div>
    <?php endif; ?>
    
    <div class="entry-content<?php if( noo_umbra_has_featured_content()) : echo ' is-featured'; endif; ?>">

        <?php if ( is_single() ) : ?>
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
        <?php else : ?>

            <h3 class="noo-title">
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permanent link to: "%s"','noo-umbra' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
            </h3>

            <div class="noo-info-meta">
                <?php noo_umbra_meta_info(); ?>
            </div>

            <?php if(get_the_excerpt()):?>
                
                <p class="noo-excerpt">
                    <?php echo noo_umbra_content_limit( get_the_excerpt(), 190 ); ?>
                </p>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="read-more">
                    <?php echo esc_html__( 'Read more','noo-umbra' ); ?>
                </a>
            <?php endif;?>
        <?php endif; ?>
    </div> 

    <?php if ( is_single() ) : ?>
        
        <footer class="entry-footer">
            <?php noo_umbra_entry_meta(); ?>
        </footer>

    <?php endif; ?>

</article> <!-- /#post- -->