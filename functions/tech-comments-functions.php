<?php
/**
 * Theme Comment Functions
 *
 * Holds functions and filters for displaying comments
 *
 * @package      Techozoic Fluid
 * @author       Jeremy Clark <jeremy@clark-technet.com>
 * @copyright    Copyright (c) 2011, Jeremy Clark
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
 *
 */

/**
 * Techozoic comment count
 *
 * Filter that displays correct comment count.
 * http://www.wpbeginner.com/wp-tutorials/display-the-most-accurate-comment-count-in-wordpress/
 * 
 * 
 * @param   string  $count filter variable
 * @return  string  $count correct comment count   
 *
 * @access    private
 * @since     1.9.3
 */
add_filter( 'get_comments_number', 'tech_comment_count', 0 );

function tech_comment_count( $count ) {
    if ( !is_admin() ) {
        global $id;
        $comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
        return count( $comments_by_type['comment'] );
    } else {
        return $count;
    }
}

/**
 * Techozoic additional comment management links
 *
 * Displays additional links for managing comments right in comment loop.
 * yoast.com for inspiration
 * 
 * @param string $id Comment id
 * @param string $post_name post_name to form redirect link
 *
 * @access    private
 * @since     2.0.1
 */

function delete_comment_link( $id, $post_name ) {
    if ( current_user_can( 'edit_posts' ) ) {
        echo ' | <a href="' . admin_url( "comment.php?action=cdc&amp;c=$id&redirect_to=/" . $post_name . "/" ) . '">' . __( 'Delete', 'techozoic' ) . '</a> ';
        echo '| <a href="' . admin_url( "comment.php?action=cdc&amp;dt=spam&amp;c=$id&amp;redirect_to=/" . $post_name . "/" ) . '">' . __( 'Spam', 'techozoic' ) . '</a>';
    }
}

/**
 * Techozoic comment callback
 *
 * Callback for displaying comments
 * 
 * @param   object  $comment  comment object from callback
 * @param   array   $args   args from callback
 * @param   string  $depth  comment nesting depth from callback.
 *
 * @access    private
 */

function techozoic_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class="avatar_cont"><?php echo get_avatar( $comment, '50' ); ?></div>
            <?php printf( __( 'Comment by %s', 'techozoic' ), '<em>' . get_comment_author_link() . '</em>' ); ?>:
            <?php if ( $comment->comment_approved == '0' ) { ?>				
                <em><?php _e( 'Your comment is awaiting moderation.', 'techozoic' ) ?></em>
            <?php } ?>
            <br />
            <small class="commentmetadata">
                <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date( 'l, F jS Y' ) ?> at <?php comment_time() ?></a>&nbsp;|&nbsp;<?php edit_comment_link( __( 'Edit', 'techozoic' ), '', '' );
        if ( $post->post_type == 'post' ) {
            delete_comment_link( $comment->comment_ID, $post->post_name );
        }
            ?>
            </small>

            <?php comment_text(); ?>
            <div class="reply">
                <?php echo comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
            </div>
        </div>
        <?php
}

// End function techozoic_comment

/**
 * Techozoic ping/trackback callback
 *
 * Callback for displaying ping/trackbacks
 * 
 * @param   object  $comment  comment object from callback
 * @param   array   $args   args from callback
 * @param   string  $depth  comment nesting depth from callback.
 *
 * @access    private
 */

function techozoic_ping( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"><?php printf( __( 'Ping from %s', 'techozoic' ), get_comment_author_link() ); ?>
    </li>
    <?php
}
// End function techozoic_ping

/**
 * Techozoic gravatar 
 *
 * Template tag for use in comment callback to display avatar with author link 
 * if link was left. 
 *
 * @access    public
 */

function techozoic_gravatar() {
        echo '<div class="avatar_cont">';
        global $comment;
        if ( !empty( $comment->comment_author_url ) ) {
            // Did they leave a link 
            ?>
        <a rel="external nofollow" href="<?php comment_author_url(); ?>" title="<?php comment_author(); ?> ">
                <?php echo get_avatar( $comment, '50' ); ?>
        </a>
            <?php
        } else {
            echo get_avatar( $comment, '50' );
        }
        ?>	      		
        </div>
        <?php
}

//End techozoic_gravatar

/**
 * Techozoic comment reply enqueue
 *
 * function enqueuing comment reply script, to be added to header if needed.
 * 
 *
 * @access    private
 * @since     2.0.1
 */

add_action( 'wp_enqueue_scripts', 'techozoic_enqueue_comment_reply' );

function techozoic_enqueue_comment_reply() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

/**
 * Techozoic Home Page Comment Preview
 *
 * Comment preview section on home page.  Pull comment excerpt for approved comments
 * displays in an unordered list at bottom of each post. 
 * 
 * @param   string $ID  id of current post to pull comments for
 *
 * @access    public
 * @since     1.8.7
 */

function tech_comment_preview( $ID ) {
    global $comment;
    $tech_comment_num = of_get_option( 'comment_preview_num', '3' );
    $output = "";
    $comment_array = get_comments( array( 'post_id' => $ID, 'number' => $tech_comment_num, 'type' => 'comment', 'status' => 'approve' ) );
    if ( $comment_array ) {
        $output .= '<ul class="comment-preview">';
        foreach ( $comment_array as $comment ) {

            $output .= '<li class="comments-link">';
            $output .= '<div class="comment-author">';
            $output .= '<a href="' . get_comment_link() . '" title="' . $comment->comment_author . __( ' posted on ', 'techozoic' ) . get_comment_date() . '">';
            $output .= $comment->comment_author . __( ' posted on ', 'techozoic' ) . get_comment_date();
            $output .= '</a>';
            $output .= '</div>';
            $output .= '<div class="comment-text">';
            $output .= get_comment_excerpt( $comment->comment_ID );
            $output .= '</div>';
            $output .= '</li>';
        }
        $output .= '</ul>';
    }
    print $output;
}