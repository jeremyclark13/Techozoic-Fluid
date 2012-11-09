<?php
get_header();
$tech_sidebar = get_post_meta( $post->ID, "Sidebar_value", $single = true );
if ( empty( $tech_sidebar ) ) {
    $tech_sidebar = "unset";
}
if ( (of_get_option( 'single_sidebar', '0' ) == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on" ) {
    tech_show_sidebar( "l" );
}
?>
<div id="content" class="<?php echo ( (of_get_option( 'single_sidebar', '0' ) == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on" ) ? "narrow" : "wide"; ?>column">
    <?php if ( get_the_title() ) {
        ?>		<h1 class="post_title">
        <?php the_title(); ?>		
        </h1>
        <?php
    }
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <div <?php post_class( 'post clear' ); ?> id="post-<?php the_ID(); ?>">
                <div class="singlepost entry">
                    <?php
                    if ( function_exists( 'the_post_thumbnail' ) )
                        the_post_thumbnail();
                    the_content( '<p class="serif">' . __( 'Read the rest of this page', 'techozoic' ) . '&raquo;</p>' );
                    wp_link_pages( '<p><strong>' . __( 'Pages:', 'techozoic' ) . '</strong> ', '</p>', 'number' );
                    ?>
                </div>
            </div>
            <?php
        } //End While Loop
    } //End If have_posts
    edit_post_link( __( 'Edit this page.', 'techozoic' ), '<p>', '</p>' );
    ?>
    <br />
    <?php comments_template();
    ?>	</div>
<?php
if ( (of_get_option( 'single_sidebar', '0' ) == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>