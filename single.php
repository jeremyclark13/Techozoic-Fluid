<?php get_header();
get_tech_options();
global $tech;
$tech_disable_sidebar = get_post_meta($post->ID, "Sidebar_value", $single = true);
$tech_disable_nav = get_post_meta($post->ID, "Nav_value", $single = true);
if ($tech['single_sidebar'] == "Yes" && $tech_disable_sidebar != "checked") { tech_show_sidebar("l");} ?>
<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes" && $tech_disable_sidebar != "checked") { echo "narrow"; }else {echo "wide";}?>column">
<?php 
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>
		<div style="clear:both"></div>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h1 class="post_title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h1>
		<small><?php printf(__('By %s','techozoic'), get_the_author()); ?>.  <?php printf(__('Filed in %s','techozoic'),get_the_category_list(', ')) ?>&nbsp; | &nbsp;<?php edit_post_link(__('Edit','techozoic'), '', ''); ?>&nbsp;<br /><?php the_tags(); ?></small>
		<div class="toppost">
		<a href="<?php if (function_exists('home_url')) { echo home_url(); } else { bloginfo('url'); } ?>"><img src="<?php bloginfo('template_directory'); ?>/images/icons/home.png" border="0" alt="Home" title="<?php printf(__('Go back to %s','techozoic'), get_bloginfo('name')); ?>" /></a>&nbsp;<?php tech_social_icons($home=false); ?>
		</div>
<?php do_action('tech_before_sing_content');?>	
		<div class="singlepost entry">
<?php 		if(function_exists('the_post_thumbnail')) { the_post_thumbnail(); }?>
<?php 		the_content('<p class="serif">'.__('Read the rest of this entry','techozoic'). '&raquo;</p>'); 
		wp_link_pages(); 
?>
		<p class="postmetadata alt">
		<small>
		<?php printf(__('This entry was posted on %1$s at %2$s and is filed under %3$s. You can follow any responses to this entry through the %4$s feed.','techozoic'), get_the_time('l, F jS, Y'), get_the_time(), get_the_category_list(', '), "<a href=\"".get_post_comments_feed_link()."\">".__('RSS 2.0','techozoic')."</a>"); ?>				
<?php 		if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Both Comments and Pings are open ?>
			<?php printf(__('You can %1$s or %2$s from your own site.','techozoic'),'<a href="#respond">'. __('leave a response','techozoic').'</a>', '<a href="'. get_trackback_url() .'" rel="trackback">'. __('trackback','techozoic').'</a>')?>
<?php 		} elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Only Pings are Open ?>
			<?php printf(__('Responses are currently closed, but you can %s from your site.','techozoic'),'<a href="'. get_trackback_url().'" rel="trackback">'.__('trackback','techozoic').'</a>'); ?>
<?php 		} elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Comments are open, Pings are not ?>
			<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.','techozoic')?>
<?php 		} elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Neither Comments, nor Pings are open ?>
			<?php _e('Both comments and pings are currently closed.','techozoic')?>			
<?php 		} 
		edit_post_link('&nbsp;'.__('  Edit this entry.','techozoic'),'',''); 
?>
		</small>
		</p>
		</div>
<?php do_action('tech_after_sing_content');?>
		</div>
<?php 		comments_template(); 
		} //End While Loop 
} else { 
?>
	<p><?php _e('Sorry, no posts matched your criteria.','techozoic')?></p>
<?php
} //End If loop
?>	</div>
<?php 
if ($tech['single_sidebar'] == "Yes"  && $tech_disable_sidebar != "checked") { tech_show_sidebar("r"); }
get_footer(); ?>