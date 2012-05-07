<?php

/**
 * bbPress - Topic Archive
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

                <div id="topic-front" class="bbp-topics-front">
                        <h1 class="entry-title"><?php bbp_topic_archive_title(); ?></h1>
                        <div class="entry-content">

                                <?php bbp_get_template_part( 'bbpress/content', 'archive-topic' ); ?>

                        </div>
                </div><!-- #topics-front -->

        </div><!-- #content -->

<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>