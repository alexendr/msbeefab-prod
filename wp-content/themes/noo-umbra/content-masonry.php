<div class="noo-blog-inner">
    <a href="<?php the_permalink() ?>" class="blog-thumbnail">
        <?php the_post_thumbnail('large'); ?>
        <i class="fa fa-link post-type-icon"></i>
    </a>
    <div class="noo-blog-content">
        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
        <span class="noo-blog-meta">
            <?php
            printf('<span class="author vcard"><i class="icon_pencil-edit"></i><a class="url fn n" href="%1$s">%2$s</a></span>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                get_the_author()
            );
            if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                echo '<span class="comments-link"><i class="icon_comment_alt"></i>';
                comments_popup_link(esc_html__('0', 'noo-umbra'), esc_html__('1', 'noo-umbra'), esc_html__('%', 'noo-umbra'));
                echo '</span>';
            }
            ?>
        </span>
        <div class="noo-excerpt">
            <p><?php
                $excerpt = get_the_excerpt();
                $limit_excerpt = !isset( $limit_excerpt ) ? 15 : $limit_excerpt;
                $trim_ex = wp_trim_words($excerpt, esc_attr($limit_excerpt), '...');
                echo esc_html($trim_ex);
                ?></p>
            <a class="custom_link" href="<?php the_permalink() ?>"><?php echo esc_html__('Read more','noo-umbra'); ?><i class="fa fa-angle-right"></i></a>
        </div>
    </div>
</div>