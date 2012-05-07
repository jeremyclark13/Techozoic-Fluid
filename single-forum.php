<?php

/**
 * Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php get_header(); 
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("l");} 
?>
	<div id="content" class="<?php if (of_get_option('forum_sidebar','0') == "1" ) { echo "narrow"; }else {echo "wide";}?>column">

            <?php do_action( 'bbp_template_notices' ); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                            <?php if ( bbp_user_can_view_forum() ) : ?>

                                    <div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
                                            <h1 class="entry-title"><?php bbp_forum_title(); ?></h1>
                                            <div class="entry-content">

                                                    <?php bbp_get_template_part( 'bbpress/content', 'single-forum' ); ?>

                                            </div>
                                    </div><!-- #forum-<?php bbp_forum_id(); ?> -->

                            <?php else : // Forum exists, user no access ?>

                                    <?php bbp_get_template_part( 'bbpress/feedback', 'no-access' ); ?>

                            <?php endif; ?>

                    <?php endwhile; ?>

            </div><!-- #content -->
<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>