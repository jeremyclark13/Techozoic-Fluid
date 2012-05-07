<?php

/**
 * bbPress User Profile Edit
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php get_header(); 
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("l");} 
?>
	<div id="content" class="<?php if (of_get_option('forum_sidebar','0') == "1" ) { echo "narrow"; }else {echo "wide";}?>column">

                <div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
                        <div class="entry-content">

                                <?php bbp_get_template_part( 'bbpress/content', 'single-user-edit'   ); ?>

                        </div><!-- .entry-content -->
                </div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

        </div><!-- #content -->
<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>