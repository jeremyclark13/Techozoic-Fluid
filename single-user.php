<?php
/**
 * User Profile
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

    <div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
        <div class="entry-content">

    <?php bbp_get_template_part( 'content', 'single-user' ); ?>

        </div><!-- .entry-content -->
    </div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

<?php do_action( 'bbp_after_main_content' ); ?>

</div><!-- #content -->

<?php
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
