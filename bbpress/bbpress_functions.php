<?php

/**
 * Functions of bbPress's Twenty Ten theme
 *
 * @package bbPress
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Enqueue theme CSS
add_action( 'bbp_enqueue_scripts', 'tech_bbp_enqueue_styles' );

// Enqueue theme JS
add_action( 'bbp_enqueue_scripts', 'tech_bbp_enqueue_scripts' );

// Enqueue theme script localization
add_filter( 'bbp_enqueue_scripts', 'tech_bbp_localize_topic_script' );

// Output some extra JS in the <head>
add_action( 'bbp_head', 'tech_bbp_head_scripts' );

// Handles the ajax favorite/unfavorite
add_action( 'wp_ajax_dim-favorite', 'tech_bbp_ajax_favorite' );

// Handles the ajax subscribe/unsubscribe
add_action( 'wp_ajax_dim-subscription', 'tech_bbp_ajax_subscription' );
	
/**
* Load the theme CSS
*
* @since bbPress (r2652)
*
* @uses wp_enqueue_style() To enqueue the styles
*/

function tech_bbp_enqueue_styles() {
    // bbPress Version
    $version = '20110921';
    
    // Right to left
    if ( is_rtl() ) {
        // bbPress specific
        wp_enqueue_style( 'bbpress', get_stylesheet_directory_uri() . '/css/bbpress-rtl.css', 'twentyten-rtl', $version, 'screen' );

    // Left to right
    } else {

        // bbPress specific
        wp_enqueue_style( 'bbpress', get_stylesheet_directory_uri() . '/css/bbpress.css', 'twentyten', $version, 'screen' );
    }
}

/**
* Enqueue the required Javascript files
*
* @since bbPress (r2652)
*
* @uses bbp_is_single_topic() To check if it's the topic page
* @uses get_stylesheet_directory_uri() To get the stylesheet directory uri
* @uses bbp_is_single_user_edit() To check if it's the profile edit page
* @uses wp_enqueue_script() To enqueue the scripts
*/

function tech_bbp_enqueue_scripts() {

    // bbPress Version
    $version = '20110921';
    
    if ( bbp_is_single_topic() )
            wp_enqueue_script( 'bbp_topic', get_stylesheet_directory_uri() . '/js/topic.js', array( 'wp-lists' ), $version );

    if ( bbp_is_single_user_edit() )
            wp_enqueue_script( 'user-profile' );
}
	
/**
* Put some scripts in the header, like AJAX url for wp-lists
*
* @since bbPress (r2652)
*
* @uses bbp_is_single_topic() To check if it's the topic page
* @uses admin_url() To get the admin url
* @uses bbp_is_single_user_edit() To check if it's the profile edit page
*/
function tech_bbp_head_scripts() {
    if ( bbp_is_single_topic() ) { ?>

    <script type='text/javascript'>
            /* <![CDATA[ */
            var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            /* ]]> */
    </script>

    <?php } elseif ( bbp_is_single_user_edit() ) { ?>

    <script type="text/javascript" charset="utf-8">
            if ( window.location.hash == '#password' ) {
                    document.getElementById('pass1').focus();
            }
    </script>

    <?php
    }
}

/**
* Load localizations for topic script
*
* These localizations require information that may not be loaded even by init.
*
* @since bbPress (r2652)
*
* @uses bbp_is_single_topic() To check if it's the topic page
* @uses is_user_logged_in() To check if user is logged in
* @uses bbp_get_current_user_id() To get the current user id
* @uses bbp_get_topic_id() To get the topic id
* @uses bbp_get_favorites_permalink() To get the favorites permalink
* @uses bbp_is_user_favorite() To check if the topic is in user's favorites
* @uses bbp_is_subscriptions_active() To check if the subscriptions are active
* @uses bbp_is_user_subscribed() To check if the user is subscribed to topic
* @uses bbp_get_topic_permalink() To get the topic permalink
* @uses wp_localize_script() To localize the script
*/

function tech_bbp_localize_topic_script() {

    // Bail if not viewing a single topic
    if ( !bbp_is_single_topic() )
            return;

    // Bail if user is not logged in
    if ( !is_user_logged_in() )
            return;

    $user_id = bbp_get_current_user_id();

    $localizations = array(
            'currentUserId' => $user_id,
            'topicId'       => bbp_get_topic_id(),
    );

    // Favorites
    if ( bbp_is_favorites_active() ) {
            $localizations['favoritesActive'] = 1;
            $localizations['favoritesLink']   = bbp_get_favorites_permalink( $user_id );
            $localizations['isFav']           = (int) bbp_is_user_favorite( $user_id );
            $localizations['favLinkYes']      = __( 'favorites',                                         'bbpress' );
            $localizations['favLinkNo']       = __( '?',                                                 'bbpress' );
            $localizations['favYes']          = __( 'This topic is one of your %favLinkYes% [%favDel%]', 'bbpress' );
            $localizations['favNo']           = __( '%favAdd% (%favLinkNo%)',                            'bbpress' );
            $localizations['favDel']          = __( '&times;',                                           'bbpress' );
            $localizations['favAdd']          = __( 'Add this topic to your favorites',                  'bbpress' );
    } else {
            $localizations['favoritesActive'] = 0;
    }

    // Subscriptions
    if ( bbp_is_subscriptions_active() ) {
            $localizations['subsActive']   = 1;
            $localizations['isSubscribed'] = (int) bbp_is_user_subscribed( $user_id );
            $localizations['subsSub']      = __( 'Subscribe',   'bbpress' );
            $localizations['subsUns']      = __( 'Unsubscribe', 'bbpress' );
            $localizations['subsLink']     = bbp_get_topic_permalink();
    } else {
            $localizations['subsActive'] = 0;
    }

    wp_localize_script( 'bbp_topic', 'bbpTopicJS', $localizations );
}

/**
* Add or remove a topic from a user's favorites
*
* @since bbPress (r2652)
*
* @uses bbp_get_current_user_id() To get the current user id
* @uses current_user_can() To check if the current user can edit the user
* @uses bbp_get_topic() To get the topic
* @uses check_ajax_referer() To verify the nonce & check the referer
* @uses bbp_is_user_favorite() To check if the topic is user's favorite
* @uses bbp_remove_user_favorite() To remove the topic from user's favorites
* @uses bbp_add_user_favorite() To add the topic from user's favorites
*/
function tech_bbp_ajax_favorite() {
    $user_id = bbp_get_current_user_id();
    $id      = intval( $_POST['id'] );

    if ( !current_user_can( 'edit_user', $user_id ) )
            die( '-1' );

    if ( !$topic = bbp_get_topic( $id ) )
            die( '0' );

    check_ajax_referer( 'toggle-favorite_' . $topic->ID );

    if ( bbp_is_user_favorite( $user_id, $topic->ID ) ) {
            if ( bbp_remove_user_favorite( $user_id, $topic->ID ) ) {
                    die( '1' );
            }
    } else {
            if ( bbp_add_user_favorite( $user_id, $topic->ID ) ) {
                    die( '1' );
            }
    }

    die( '0' ); 
}

/**
* Subscribe/Unsubscribe a user from a topic
*
* @since bbPress (r2668)
*
* @uses bbp_is_subscriptions_active() To check if the subscriptions are active
* @uses bbp_get_current_user_id() To get the current user id
* @uses current_user_can() To check if the current user can edit the user
* @uses bbp_get_topic() To get the topic
* @uses check_ajax_referer() To verify the nonce & check the referer
* @uses bbp_is_user_subscribed() To check if the topic is in user's
*                                 subscriptions
* @uses bbp_remove_user_subscriptions() To remove the topic from user's
*                                        subscriptions
* @uses bbp_add_user_subscriptions() To add the topic from user's subscriptions
*/
function tech_bbp_ajax_subscription() {
    if ( !bbp_is_subscriptions_active() )
            return;

    $user_id = bbp_get_current_user_id();
    $id      = intval( $_POST['id'] );

    if ( !current_user_can( 'edit_user', $user_id ) )
            die( '-1' );

    if ( !$topic = bbp_get_topic( $id ) )
            die( '0' );

    check_ajax_referer( 'toggle-subscription_' . $topic->ID );

    if ( bbp_is_user_subscribed( $user_id, $topic->ID ) ) {
            if ( bbp_remove_user_subscription( $user_id, $topic->ID ) ) {
                    die( '1' );
            }
    } else {
            if ( bbp_add_user_subscription( $user_id, $topic->ID ) ) {
                    die( '1' );
            }
    }

    die( '0' );
}
?>