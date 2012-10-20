<?php
get_header();
$date_format = get_option( 'date_format' );
if ( of_get_option( 'single_sidebar', '1' ) == "1" )
    tech_show_sidebar( "l" );
?>
<div id="content" class="<?php echo ( of_get_option( 'single_sidebar', '1' ) == "1" ) ? "narrow" : "wide"; ?>column">
    <?php if ( have_posts() ) { ?>
        <h2 class="pagetitle"><?php _e( 'Search Results for ', 'techozoic' ); ?><span class="search-terms">
                <?php
                /* Search Count */
                $allsearch = &new WP_Query( "s=$s&showposts=-1" );
                $key = esc_html( $s );
                $count = $allsearch->post_count;
                echo $key;
                ?>
            </span> &mdash;
            <?php
            echo $count . ' ';
            _e( 'articles', 'techozoic' );
            wp_reset_query();
            ?>
        </h2>
        <div class="navigation">
            <div class="alignleft"><?php posts_nav_link( ' ', ' ', __( '&laquo; Older Entries', 'techozoic' ) ) ?></div>
            <div class="alignright"><?php posts_nav_link( ' ', __( 'Newer Entries &raquo;', 'techozoic' ), ' ' ) ?></div>
        </div>
        <?php
        while ( have_posts() ) {
            the_post();
            $title = get_the_title();
            $excerpt = get_the_excerpt();
            $keys = explode( " ", $s );
            $title = preg_replace( '/(' . implode( '|', $keys ) . ')/iu', '<strong class="search-excerpt">\0</strong>', $title );
            $excerpt = preg_replace( '/(' . implode( '|', $keys ) . ')/iu', '<strong class="search-excerpt">\0</strong>', $excerpt );
            ?>
            <div class="post">
                <h3 id="post-<?php the_ID(); ?>" class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __( 'Permanent Link to %s', 'techozoic' ), get_the_title() ); ?>"><?php echo $title; ?></a></h3>
                <small><?php _e( 'By', 'techozoic' ) ?> <?php the_author() ?>&nbsp;|&nbsp;<?php printf( __( 'Filed in %s', 'techozoic' ), get_the_category_list( ', ' ) ) ?><?php edit_post_link( __( '&nbsp;|&nbsp; Edit.', 'techozoic' ), '', '' ); ?></small>
                <div class="entry">
                    <?php echo $excerpt; ?>
                </div>
            </div>
        <?php } //End While Loop  ?>

        <div class="navigation">
            <div class="alignleft"><?php posts_nav_link( ' ', ' ', __( '&laquo; Older Entries', 'techozoic' ) ) ?></div>
            <div class="alignright"><?php posts_nav_link( ' ', __( 'Newer Entries &raquo;', 'techozoic' ), ' ' ) ?></div>
        </div>
    <?php } else { ?>
        <h2 class="center"><?php _e( 'No posts found. Try a different search?', 'techozoic' ) ?></h2>
    <?php } //End If Loop
    ?>
</div>
<?php
if ( of_get_option( 'single_sidebar', '1' ) == "1" )
    tech_show_sidebar( "r" );
get_footer();
?>
