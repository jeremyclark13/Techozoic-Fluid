<?php
// Do not delete these lines
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
    die( __( 'Please do not load this page directly. Thanks!', 'techozoic' ) );
if ( function_exists( 'post_password_required' ) ) {
    if ( post_password_required() ) {
        echo '<p class="nocomments">' . __( 'This post is password protected. Enter the password to view comments.', 'techozoic' ) . '</p>';
        return;
    }
} else {
    if ( !empty( $post->post_password ) ) { // if there's a password
        if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) {  // and it doesn't match the cookie
            ?>
            <p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'techozoic' ) ?></p>
            <?php
            return;
        }
    }
}
/* This variable is for alternating comment background */
$oddcomment = 'class="alt" ';
if ( have_comments() ) {
    ?>
    <h3 id="comments"><?php comments_number( __( 'No Comments', 'techozoic' ), __( 'One Comment', 'techozoic' ), _n( '% Comment', '% Comments', get_comments_number(), 'techozoic' ) ); ?></h3>
    <ol class="commentlist">
        <?php wp_list_comments( 'type=comment&callback=techozoic_comment' ); ?>
    </ol>
    <ol class="trackback">
        <?php wp_list_comments( 'type=pings&callback=techozoic_ping' ); ?>
    </ol>
    <div class="navigation">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>
    <?php
} // this is displayed if there are no comments so far 

if ( 'open' == $post->comment_status ) {
    comment_form( array( 'comment_notes_after' => ' ' ) );
} //End if comment open 
?>
