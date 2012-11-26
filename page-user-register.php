<?php
/**
 * Template Name: bbPress - User Register
 *
 * @package bbPress
 * @subpackage Theme
 */
// No logged in users
bbp_logged_in_redirect();

// Begin Template
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

<?php while ( have_posts() ) : the_post(); ?>

        <div id="bbp-register" class="bbp-register">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">

                    <?php the_content(); ?>

                <div id="bbpress-forums">

    <?php bbp_breadcrumb(); ?>

    <?php bbp_get_template_part( 'form', 'user-register' ); ?>

                </div>
            </div>
        </div><!-- #bbp-register -->

<?php endwhile; ?>

<?php do_action( 'bbp_after_main_content' ); ?>

</div><!-- #content -->
<?php
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
