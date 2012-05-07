<?php

/**
 * Topic Tag Edit
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

                <div id="topic-tag" class="bbp-topic-tag">
                        <h1 class="entry-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>

                        <div class="entry-content">

                                <?php bbp_breadcrumb(); ?>

                                <?php bbp_topic_tag_description(); ?>

                                <?php do_action( 'bbp_template_before_topic_tag_edit' ); ?>

                                <?php bbp_get_template_part( 'bbpress/form', 'topic-tag' ); ?>

                                <?php do_action( 'bbp_template_after_topic_tag_edit' ); ?>

                        </div>
                </div><!-- #topic-tag -->
        </div><!-- #content -->
<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>
