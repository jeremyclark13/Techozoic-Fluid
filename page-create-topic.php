<?php

/**
 * Template Name: bbPress - Create Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); 
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("l");} 
?>
	<div id="content" class="<?php if ((of_get_option('single_sidebar','0') == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on") { echo "narrow"; }else {echo "wide";}?>column">

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="bbp-new-topic" class="bbp-new-topic">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-content">

							<?php the_content(); ?>

							<?php bbp_get_template_part( 'bbpress/form', 'topic' ); ?>

						</div>
					</div><!-- #bbp-new-topic -->

				<?php endwhile; ?>

			</div><!-- #content -->

<?php
    if (of_get_option('forum_sidebar','0') == "1" ) { tech_show_sidebar("r"); }
    get_footer();  
?>