<?php
get_header();
$tech_ii = 1;
$tech_i = 0;
$tech_head_ad_code = of_get_option( 'header_ad_code', '' );
if ( !empty( $tech_head_ad_code ) ) {
    ?>
    <div class="aligncenter">
        <?php
        $tech_header_ad_code = stripslashes( of_get_option( 'header_ad_code', '' ) );
        echo do_shortcode( $tech_header_ad_code );
        ?>
    </div>
    <?php
    $tech_ii++;
}
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "l" );
?>

<div id="content" class="<?php echo ( of_get_option( 'home_sidebar', '1' ) != "1" || of_get_option( 'sidebar_pos', '3-col' ) == '1-col' ) ? "wide" : "narrow"; ?>column">
    <?php tech_nav_links(); ?>
    <?php
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
    <?php } ?>
    <?php tech_nav_links(); ?>
</div>
<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "r" );
get_footer();
?>