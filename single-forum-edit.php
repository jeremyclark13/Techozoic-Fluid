<?php
/**
 * Edit handler for forums
 *
 * @package bbPress
 * @subpackage Theme
 */
get_header();
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "l" );
}
?>

<?php do_action( 'bbp_before_main_content' ); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <div id="bbp-edit-page" class="bbp-edit-page">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-content">

            <?php bbp_get_template_part( 'form', 'forum' ); ?>

        </div>
    </div><!-- #bbp-edit-page -->

<?php endwhile; ?>

<?php do_action( 'bbp_after_main_content' ); ?>

</div><!-- #content -->
<?php
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
