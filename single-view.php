<?php
/**
 * Single View
 *
 * @package bbPress
 * @subpackage Theme
 */
get_header();
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "l" );
}
?>
<div id="content" class="<?php if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    echo "narrow";
} else {
    echo "wide";
} ?>column">


<?php do_action( 'bbp_before_main_content' ); ?>

<?php do_action( 'bbp_template_notices' ); ?>

    <div id="bbp-view-<?php bbp_view_id(); ?>" class="bbp-view">
        <h1 class="entry-title"><?php bbp_view_title(); ?></h1>
        <div class="entry-content">

    <?php bbp_get_template_part( 'content', 'single-view' ); ?>

        </div>
    </div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

<?php do_action( 'bbp_after_main_content' ); ?>

</div><!-- #content -->
<?php
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
