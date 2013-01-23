<?php
get_header();
$date_format = get_option( 'date_format' );
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "l" );
?>

<div id="content" class="<?php echo (of_get_option( 'home_sidebar', '1' ) != "1" || of_get_option( 'sidebar_pos', '3-col' ) == '1-col' ) ? "wide" : "narrow"; ?>column">

    <?php
    if ( have_posts() ) {
        tech_archive_title();
    }
    tech_nav_links();
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            get_template_part( 'content', get_post_format() );
            get_template_part( 'tech', 'ads' );
        } //End While loop
    } else {
        ?>
        <h2 class="center"><?php _e( 'Not Found', 'techozoic' ) ?></h2>
        <p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here', 'techozoic' ) ?>.</p>
    <?php }
    tech_nav_links();
    ?>
</div>
<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>