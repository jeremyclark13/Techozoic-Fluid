<?php

/**
 * Edit handler for topics
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php get_header(); 
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("l");} 
?>
	<div id="content" class="<?php if (of_get_option('forum_sidebar','0') == "1" ) { echo "narrow"; }else {echo "wide";}?>column">
                <?php while ( have_posts() ) : the_post(); ?>

                        <div id="bbp-edit-page" class="bbp-edit-page">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-content">

                                        <?php bbp_get_template_part( 'bbpress/form', 'topic' ); ?>

                                </div>
                        </div><!-- #bbp-edit-page -->

                <?php endwhile; ?>

        </div><!-- #content -->

<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>