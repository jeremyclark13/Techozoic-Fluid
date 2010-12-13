<?php get_header();
get_tech_options();
global $tech;
if ($tech['single_sidebar'] == "Yes") { tech_show_sidebar("l");} ?>

<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">
				
<?php 
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
	
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'techozoic' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
			<div class="entry text">
	
<?php 
		if ( wp_attachment_is_image() ) { ?>
			<div id="main_image">
				<a href="<?php echo wp_get_attachment_url($post->ID);?>" title="<?php _e('View Full Size','techozoic');?>">
				<?php echo wp_get_attachment_image( $post->ID, array( $content_width, 9999 ) ); ?>
				<span class="pic_info">
<?php		
					$metadata = wp_get_attachment_metadata();
					$date_format = get_option('date_format');
					$camera = $metadata['image_meta']; ?>
					<strong><?php _e('Image Information','techozoic');?></strong>
					<br />
<?php			printf(__('Size: %1$s &times; %2s','techozoic'), $metadata['width'], $metadata['height'] );
					echo " <br />";
					if ($camera['camera'] != ""){
						 printf(__('Camera: %s','techozoic'), $camera['camera'] );
						echo " <br />";
					}
					if ($camera['created_timestamp'] != 0){
						printf(__('Taken: %s','techozoic'), date($date_format ,$camera['created_timestamp'] ) ); 
						echo " <br />";
					}
					if ($camera['aperture'] != 0){
						 printf(__('Aperture: %s','techozoic'), $camera['aperture'] );
						echo " <br />";
					}
					if ($camera['iso'] != 0){
						 printf(__('ISO: %s','techozoic'), $camera['iso'] );
						echo " <br />";
					}
					if ($camera['shutter_speed'] != 0){
						 printf(__('Shutter Speed: %s','techozoic'), $camera['shutter_speed'] ); 
						echo " <br />"; 
					}
?>
					<strong><?php _e('Click for original image','techozoic');?></strong>
				</span>
				</a>
			</div><!--#main_image-->
<?php
		}	 
		
		the_content('<p class="serif">'.__('Read the rest of this entry' ,'techozoic').'&raquo;</p>'); 
		
		if ( wp_attachment_is_image() ) {
	        $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
			foreach ( $attachments as $k => $attachment ) {
					if ( $attachment->ID == $post->ID )
	                        break;
	        }
	        $k++;
	        // If there is more than 1 image attachment in a gallery
	        if ( count( $attachments ) > 1 ) {
	                if ( isset( $attachments[ $k ] ) ) {
	                        $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
							$next_attachment_image = wp_get_attachment_image ( $attachments[ $k ]->ID , array( 100, 9999));
	                }
					if ( isset( $attachments[ $k - 2] ) ){
							$prev_attachment_url = get_attachment_link( $attachments[ $k - 2 ]->ID );
							$prev_attachment_image = wp_get_attachment_image ( $attachments[ $k - 2 ]->ID , array( 100, 9999));
					}
	        } 
	?>			
			<div id="pic-navigation" >
<?php 		
			if(isset($prev_attachment_url)){
				echo '<div class="pic-previous"><a href="' . $prev_attachment_url . '" title="' . __('Previous Image','techozoic') . '">' . $prev_attachment_image . '</a></div>';
			}
			if(isset($next_attachment_url)){
				echo '<div class="pic-next"><a href="' . $next_attachment_url . '" title="' . __('Next Image','techozoic') . '">' . $next_attachment_image . '</a></div>';
			}
?>
			</div><!--#pic-navigation-->
<?php
		} else { ?>
			<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
<?php 
		} 
		wp_link_pages('<p><strong>'.__('Pages' ,'techozoic').':</strong>', '</p>', 'number'); ?>
		<div style="clear:both;margin-bottom:10px"></div>	
		<p class="postmetadata alt">
		<small>
<?php 
		printf(__('This entry was posted on %1$s at %2$s and is filed under %3$s. You can follow any responses to this entry through the %4$s feed.','techozoic'), get_the_time($date_format), get_the_time(), get_the_category_list(', '), "<a href=\"".get_post_comments_feed_link()."\">".__('RSS 2.0','techozoic')."</a>"); 			
 		if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Both Comments and Pings are open 
			printf(__('You can %1$s or %2$s from your own site.','techozoic'),'<a href="#respond">'. __('leave a response','techozoic').'</a>', '<a href="'. get_trackback_url() .'" rel="trackback">'. __('trackback','techozoic').'</a>');
 		} elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Only Pings are Open 
			printf(__('Responses are currently closed, but you can %s from your site.','techozoic'),'<a href="'. get_trackback_url().'" rel="trackback">'.__('trackback','techozoic').'</a>');
 		} elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Comments are open, Pings are not 
			_e('You can skip to the end and leave a response. Pinging is currently not allowed.','techozoic');
		} elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Neither Comments, nor Pings are open 
			_e('Both comments and pings are currently closed.','techozoic');			
		} 
		edit_post_link('&nbsp;'.__('  Edit this entry.','techozoic'),'',''); 
?>
		</small>
		</p>
	
			</div><!--.entrytext-->
		</div><!--#post-???-->
		
<?php 
		comments_template(); 
	
		} //Endwhile
	} else {
?>
		<p><?php _e('Sorry, no attachments matched your criteria.' ,'techozoic')?></p>
	
<?php 
	}//End if 
?>
</div><!--#content-->

<?php 
if ($tech['single_sidebar'] == "Yes" ) { tech_show_sidebar("r"); }
get_footer(); ?>