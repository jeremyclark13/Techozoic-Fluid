<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<?php $attachment_link = wp_get_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = 'smallattachment'; // This lets us style narrow icons specially ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
			<div class="entry text">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

				<?php the_content('<p class="serif">'.__('Read the rest of this entry' ,'techozoic').'&raquo;</p>'); ?>
	
				<?php wp_link_pages('<p><strong>'.__('Pages' ,'techozoic').':</strong>', '</p>', 'number'); ?>
	
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
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no attachments matched your criteria.' ,'techozoic')?></p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>
