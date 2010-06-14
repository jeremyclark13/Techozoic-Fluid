<?php
/******************************************
This File Contains callback functions for comment loops
******************************************/
	global $tech;
	$tech = get_option('techozoic_options');
	 
	 // credit to yoast.com
function delete_comment_link($id,$post_name) {
	  if (current_user_can('edit_post')) {
	    echo ' | <a href="'.admin_url("comment.php?action=cdc&c=$id&redirect_to=/".$post_name."/").'">'. __("Delete" ,'techozoic').'</a> ';
	    echo '| <a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id&redirect_to=/".$post_name."/").'">'.__("Spam" ,'techozoic').'</a>';
	  }
}

	if ( function_exists('wp_list_comments')) {
		// WP 2.7+ Function
		add_filter('get_comments_number', 'comment_count', 0);
		function comment_count( $count ) {
			global $id;
			$get_comments= get_comments('post_id=' . $id);
			$comments_by_type = &separate_comments($get_comments);
			return count($comments_by_type['comment']);
		}
		function techozoic_comment($comment, $args, $depth) {
	       		$GLOBALS['comment'] = $comment;
				global $post;
?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID( ); ?>">
			<div id="comment-<?php comment_ID( ); ?>">
	       		<div class="avatar_cont"><?php echo get_avatar( get_comment_author_email(), '50' ); ?></div>
			<?php printf(__('Comment by %s','techozoic'),'<em>'.get_comment_author_link().'</em>'); ?>:
<?php 			if ($comment->comment_approved == '0') { 
?>				<em><?php _e('Your comment is awaiting moderation.' ,'techozoic') ?></em>
<?php			}
?>
			<br />
			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('l, F jS Y') ?> at <?php comment_time() ?></a>&nbsp;|&nbsp;<?php edit_comment_link(__('Edit' ,'techozoic'),'','');
			if($post->post_type == 'post'){
				delete_comment_link($comment->comment_ID,$post->post_name);
				}
			?>
			</small>

<?php 			comment_text() 
?>
			<div class="reply">
<?php 			echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth']));  
?>
			</div>
			</div>
<?php
		} // End function techozoic_comment

	function techozoic_ping($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"><?php printf(__('Ping from %s' ,'techozoic'),  get_comment_author_link()); ?>
		</li>
<?php 
		} // End function techozoic_ping
	} else {
		//WP 2.6 and lower
		$tech_trackbacks = array();
		$tech_comments = array();

		function split_comments( $source ) {
			if ( $source ) foreach ( $source as $comment ) {
				global $tech_trackbacks;
				global $tech_comments;
				if ( $comment->comment_type == 'trackback' || $comment->comment_type == 'pingback' ) {
					$tech_trackbacks[] = $comment;
		       		} else {
			    		$tech_comments[] = $comment;
	 		       	}
		    	}	
		} // End function split_comments
	} //End if fuction_exists(wp_list_comments)

	function techozoic_gravatar() {
		if (function_exists('get_avatar')) { 
			echo '<div class="avatar_cont">';
			global $comment;
			if (! empty($comment->comment_author_url) ){ 
				// Did they leave a link 
?>	       			<a rel="external nofollow" href="<?php comment_author_url(); ?>" title="<?php comment_author(); ?> ">
<?php				echo get_avatar( get_comment_author_email(), '50' )
?>				</a>
<?php 			} else { 
				 echo get_avatar( get_comment_author_email(), '50' ); 
			}
?>	      		</div>
<?php
		} 
	}//End techozoic_gravatar
?>