<?php
/**
 * Template Name: bbPress - Topic Tags
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

<?php while ( have_posts() ) : the_post(); ?>

        <div id="bbp-topic-tags" class="bbp-topic-tags">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">

                    <?php get_the_content() ? the_content() : _e( '<p>This is a collection of tags that are currently popular on our forums.</p>', 'bbpress' ); ?>

                <div id="bbpress-forums">

                        <?php bbp_breadcrumb(); ?>

                    <div id="bbp-topic-hot-tags">

    <?php wp_tag_cloud( array( 'smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => bbp_get_topic_tag_tax_id() ) ); ?>

                    </div>
                </div>
            </div>
        </div><!-- #bbp-topic-tags -->

<?php endwhile; ?>

<?php do_action( 'bbp_after_main_content' ); ?>

</div><!-- #content -->
<?php
if ( of_get_option( 'forum_sidebar', '0' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>
