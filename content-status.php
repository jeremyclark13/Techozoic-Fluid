<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="avatar"><a href="<?php echo add_query_arg( 'post_format', 'status', get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php _e( 'View all status updates by this author', 'techozoic' ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?></a></div>    
    <div class="entry">
        <?php the_content(); ?>
    </div>
</div>