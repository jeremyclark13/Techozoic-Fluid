<?php 	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!','techozoic'));
	if (function_exists('post_password_required')) {
		if ( post_password_required() ) {
		echo '<p class="nocomments">'.__('This post is password protected. Enter the password to view comments.','techozoic').'</p>';
		return;
		}
	} else {
		if (!empty($post->post_password)) { // if there's a password
			if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','techozoic')?></p>
<?php			return;
			}
		}
		/* This variable is for alternating comment background */
		$oddcomment = 'class="alt" ';
	}
	if (function_exists('wp_list_comments')) {
		//WP 2.7 Comment Loop
		if ( have_comments() ) { ?>
			<h3 id="comments"><?php comments_number(__('No Comments &#187;' ,'techozoic'), __('One Comment &#187;' ,'techozoic'),  __ngettext('% Comment &#187;' , '%Comments &#187',get_comments_number(),'techozoic'));?></h3>
			<ol class="commentlist">
<?php 				wp_list_comments('type=comment&callback=techozoic_comment'); ?>
			</ol>
			<ol class="trackback">
<?php 				wp_list_comments('type=pings&callback=techozoic_ping'); ?>
			</ol>
			<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
			</div>
 <?php 		} // this is displayed if there are no comments so far 
			if ('open' == $post->comment_status) {
				// If comments are open, but there are no comments.
			} else { ?><p class="nocomments"><?php _e('Comments are closed.','techozoic')?></p>
<?php	 	}
			
	} else {
		//WP 2.6 and older Comment Loop
 		// Do not delete these lines
		global $tech_comments;
		global $tech_trackbacks;
		split_comments( $comments );
		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
		if ($comments) { ?>
			<h3 id="comments"><?php printf(__('%1$s to %2$s &#8221;','techozoic'),comments_number(__('No Comments &#187;' ,'techozoic'), __('One Comment &#187;' ,'techozoic'),  __ngettext('% Comment &#187;' , '%Comments &#187',get_comments_number(),'techozoic')), get_the_title())?></h3> 
			<ol class="commentlist">
<?php 				foreach ( $tech_comments as $comment ) { ?>
					<li class="<?php echo $oddcomment; ?> <?php if ($comment->user_id == '1') echo 'author'; ?>" id="comment-<?php comment_ID() ?>">
<?php 					techozoic_gravatar(); 
?>
					<?php printf(__('Comment by %s','techozoic'),'<em>'.get_comment_author_link().'</em>:'); ?>
<?php 					if ($comment->comment_approved == '0') { ?>
						<em><?php _e('Your comment is awaiting moderation.','techozoic')?></em>
<?php 					} 
?>
					<br />
					<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('l, F jS Y') ?> @ <?php comment_time() ?></a> <?php edit_comment_link(__('Edit','techozoic'),'',''); ?></small>
<?php 					comment_text() ?>
					</li>
<?php 					/* Changes every other comment to a different class */	
					if ('alt' == $oddcomment) $oddcomment = '';
					else $oddcomment = 'alt';
				} /* end for each comment */ ?>
			</ol>
<?php 			if ( count( $tech_trackbacks ) > 0 ) { ?>
				<h3><?php _e('TrackBacks / PingBacks','techozoic')?></h3>
				<ol class="trackback">
<?php 					foreach ( $tech_trackbacks as $comment ) {
						if ( $comment->comment_type == 'trackback') { 
						$tbtype = 'tb'; 
					} else { 
						$tbtype = 'pb'; 
					} 
?>
					<li class="<?php echo $tbtype; ?>" id="comment-<?php comment_ID() ?>">
<?php 					if ( $tbtype == 'tb') { ?>
						<?php _e('TrackBack','techozoic')?>
<?php 					} else { ?>
						<?php _e('PingBack','techozoic')?>
<?php 					} 
?>					<br />
 					<em><?php comment_author_link() ?></em>
<?php 					if ($comment->comment_approved == '0') { ?>
						<em><?php _e('Your comment is awaiting moderation.','techozoic')?></em>
<?php 					} ?>
					</li>
<?php 					} /* end for each comment */ ?>
				</ol>
<?php 			} 
		} else { // this is displayed if there are no comments so far 
			if ('open' == $post->comment_status) {  ?> 
				<!-- If comments are open, but there are no comments. -->
<?php 			} else { // comments are closed ?>
				<!-- If comments are closed. -->
				<p class="nocomments"><?php _e('Comments are closed.','techozoic')?></p></div>
<?php 			}

			} 

		} // 2.6 and older Comment Loop end 

		if ('open' == $post->comment_status) { ?>
		<div id="respond">
<?php 		if (function_exists('cancel_comment_reply_link')) { 
?>
			<div id="cancel-comment-reply">
			<small><?php cancel_comment_reply_link();?></small>
			</div>
<?php 		} 
?>
<?php 		if (function_exists('comment_form_title')) { 
?>
			<h3><?php comment_form_title(__('Leave a Reply','techozoic'), __('Leave a Reply to %s','techozoic')); ?></h3>
<?php 		} else { 
?>			<h3><?php _e('Leave a Reply','techozoic')?></h3><?php 
		}  
		if ( get_option('comment_registration') && !$user_ID ) {
?>
			<p><?php printf(__('You must be %s to post a comment.','techozoic'), "<a href=\"". get_option('siteurl'). "/wp-login.php?redirect_to=" . get_permalink(). "\">". __('logged in','techozoic'). "</a>")?></p>
			</div>
<?php 		} else { ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php 			if ( $user_ID ) { ?>
				<p><?php printf(__('Logged in as %s','techozoic'), '<a href="' .get_option('siteurl') .'/wp-admin/profile.php">' . $user_identity . '</a>.')?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'techozoic')?>"><?php _e('Logout','techozoic')?> &raquo;</a></p>
<?php 			} else { ?>
				<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><small><?php _e('Name','techozoic')?> <?php if ($req) _e('(required)','techzoic'); ?></small></label></p>
				<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><small><?php _e('Mail (will not be published)','techozoic')?> <?php if ($req) _e('(required)','techzoic');; ?></small></label></p>
				<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><small><?php _e('Website','techozoic')?></small></label></p>

<?php 			}
			if (function_exists('comment_id_fields')) comment_id_fields(); ?>
			<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','techozoic')?>" />
			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
<?php 			do_action('comment_form', $post->ID); ?>
			</form>
			</div>
<?php 		} // If registration required and not logged in 
	} //End if comment open 
?>
