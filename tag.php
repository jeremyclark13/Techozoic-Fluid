<?php
get_header();
$date_format = get_option( 'date_format' );
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "l" );
?>

<div id="content" class="<?php echo (of_get_option( 'home_sidebar', '1' ) != "1" || of_get_option( 'sidebar_pos', '3-col' ) == '1-col' ) ? "wide" : "narrow"; ?>column">

    <div class="post">	
        <h2 class="center"><?php _e( "Tag Archive", "techozoic" ); ?></h2><br />
        <?php wp_tag_cloud( '' ); ?>
        <?php tech_nav_links(); ?>
        <?php if ( have_posts() ) { ?>

            <?php while ( have_posts() ) {
                the_post(); ?>
                <div class="tagcont">
                    <h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __( 'Permanent Link to %s', 'techozoic' ), get_the_title() ); ?>"><?php the_title(); ?></a></h2>

                    <div class="entry">
                        <?php
                        if ( tech_excerpt( 'tag' ) ) {
                            the_excerpt();
                        } else {
                            the_content( __( 'Read the remainder of this entry &raquo;', 'techozoic' ) );
                        }
                        ?>
                    </div>
                    <?php if ( tech_icons( 'tag' ) ) { ?>	
                        <div class="top">
                            <?php tech_social_icons( $home = true ); ?><a href="#top"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/top.png" border="0" alt="TOP" title="<?php _e( 'To the top', 'techozoic' ) ?>" /></a>
                        </div>
                    <?php } ?>
                </div>
            <?php } // End while have_posts
        } // End if have_posts
        tech_nav_links();
        ?>


    </div>
</div>	
<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
