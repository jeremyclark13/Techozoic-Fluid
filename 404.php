<?php
header( "HTTP/1.1 404 Not Found" );
get_header();
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

<div id="content" class="<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" ) {
    echo "narrow";
} else {
    echo "wide";
}
?>column">

    <h2 class="aligncenter"><?php _e( 'Error 404 - Not Found', 'techozoic' ) ?></h2>

    <h3><?php _e( 'Browse Archives', 'techozoic' ) ?></h3>
    <ul>
<?php wp_get_archives( 'type=monthly' ); ?>
    </ul>
</div>

<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "r" );
get_footer();
?>