<?php
/**
 * Theme Template Tags
 *
 * Holds template tags for use in various templates.
 *
 * @package      Techozoic Fluid
 * @author       Jeremy Clark <jeremy@clark-technet.com>
 * @copyright    Copyright (c) 2011, Jeremy Clark
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        2.1
 *
 */

/**
 * Techozoic footer text function
 *
 * Used to replace shortcodes used in footer_text option with correct values.  
 * add_filter is used to make the Jetpack Infinite Scroll footer use the same text.
 * 
 *
 * @access    public
 * @since     1.8.8
 */

add_filter( 'infinite_scroll_credit', 'tech_footer_text' );

function tech_footer_text() {
    if ( function_exists( 'wp_get_theme' ) ) {
        $theme_data = wp_get_theme( 'techozoic-fluid' );
        $version = $theme_data->Version;
    } else {
        $theme_data = get_theme_data( get_template_directory() . '/style.css' );
        $version = $theme_data['Version'];
    }
    $string = of_get_option( 'footer_text', '%COPYRIGHT% %BLOGNAME% | %THEMENAME% %THEMEVER% by %THEMEAUTHOR%. | %TOP% | %LOGIN% <br /> <small>%MYSQL%</small>' );
    $shortcode = array( '/%BLOGNAME%/i', '/%THEMENAME%/i', '/%THEMEVER%/i', '/%THEMEAUTHOR%/i', '/%TOP%/i', '/%COPYRIGHT%/i', '/%MYSQL%/i', '/%LOGIN%/i' );
    $output = array( get_bloginfo( 'name' ), "Techozoic", $version, '<a href="http://clark-technet.com/"> Jeremy Clark</a>', '<a href="#top">' . __( 'Top', 'techozoic' ) . '</a>', '&copy; ' . date( 'Y' ), sprintf( __( '%1$d mySQL queries in %2$s seconds.', 'techozoic' ), get_num_queries(), timer_stop( 0 ) ),  wp_loginout(get_permalink(), false) );
    return preg_replace( $shortcode, $output, $string );
}

/**
 * Techozoic Social Media Icons Function
 *
 * Echos the social media icon links and images as set in options.
 * 
 * 
 * @param   bool    $home   whether the function called from home page or single page
 *
 * @access    public
 * @since     1.8.8
 */

function tech_social_icons( $home = true ) {
    global $post;
    $post_image = "";
    if ( has_post_thumbnail( $post->ID ) ) {
        $post_image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        $post_image = 'media=' . $post_image_array[0] . '&amp;';
    }
    $short_link = home_url() . "/?p=" . $post->ID;
    $home_icons = of_get_option( 'home_social_icons', array( 'delicious' => '1', 'digg' => '1', 'rss' => '1' ) );
    $single_icons = of_get_option( 'single_social_icons', array( 'delicious' => '1', 'digg' => '1', 'rss' => '1' ) );
    $image = get_template_directory_uri() . "/images/icons";
    $link = get_permalink();
    $title = $post->post_title;
    $email_title = preg_replace( '/&/i', 'and', $title );
    $url_title = urlencode( $post->post_title );
    $excerpt = urlencode( wp_trim_excerpt( $post->post_excerpt ) );
    $excerpt_mail = wp_trim_excerpt( $post->post_excerpt );
    $excerpt_mail = preg_replace( "/&#?[a-z0-9]{2,8};/i", "", $excerpt_mail );
    $home_title = urlencode( get_bloginfo( 'name' ) );
    $social_links = array(
        "delicious" => "<a href='http://delicious.com/post?url={$link}&amp;title={$url_title}' title='" . __( 'del.icio.us this!', 'techozoic' ) . "' target='_blank' class='social delicious'></a>",
        "digg" => "<a href='http://digg.com/submit?phase=2&amp;url={$link}&amp;title={$url_title}' title='" . __( 'Digg this!', 'techozoic' ) . "' target='_blank' class='social digg'></a>",
        "email" => "<a href='mailto:?subject={$email_title}&amp;body={$excerpt_mail} {$link}' title='" . __( 'Share this by email.', 'techozoic' ) . "'  class='social email'></a>",
        "facebook" => "<a href='http://www.facebook.com/share.php?u={$link}&amp;t={$url_title}' title='" . __( 'Share on Facebook!', 'techozoic' ) . "' target='_blank' class='social facebook'></a>",
        "linkedin" => "<a href ='http://www.linkedin.com/shareArticle?mini=true&amp;url={$link}&amp;title={$url_title}&amp;summary={$excerpt}&amp;source={$home_title}' title='" . __( 'Share on LinkedIn!', 'techozoic' ) . "' target='_blank' class='social linkedin'></a>",
        "myspace" => "<a href='http://www.myspace.com/Modules/PostTo/Pages/?u={$link}&amp;t={$url_title}' title='" . __( 'Share on Myspace!', 'techozoic' ) . "' target='_blank' class='social myspace'></a>",
        "newsvine" => "<a href='http://www.newsvine.com/_tools/seed&amp;save?u={$link}' title='" . __( 'Share on NewsVine!', 'techozoic' ) . "' target='_blank' class='social newsvine'></a>",
        "stumbleupon" => "<a href='http://www.stumbleupon.com/submit?url={$link}&amp;title={$url_title}' title='" . __( 'Stumble Upon this!', 'techozoic' ) . "' target='_blank' class='social stumble'></a>",
        "twitter" => "<a href='http://twitter.com/home?status=Reading%20{$url_title}%20on%20{$short_link}' title='" . __( 'Tweet this!', 'techozoic' ) . "' target='_blank' class='social twitter'></a>",
        "reddit" => "<a href='http://reddit.com/submit?url={$link}&amp;title={$url_title}' title='" . __( 'Share on Reddit!', 'techozoic' ) . "' target='_blank' class='social reddit'></a>",
        "rss" => "<a href='" . get_post_comments_feed_link() . "' title='" . __( 'Subscribe to Feed', 'techozoic' ) . "' class='social feed'></a>",
        "pintrest" => "<a href='http://pinterest.com/pin/create/button/?url={$link}&amp;{$post_image}description={$excerpt}' class='pin-it-button' count-layout='none'><img src='//assets.pinterest.com/images/PinExt.png' title='Pin It' /></a>",
        "google" => "<g:plusone size='small' annotation='none' expandto='right' href='$link'></g:plusone>" );
    if ( $home == true ) {
        if ( is_array( $home_icons ) ) {
            foreach ( $home_icons as $key => $value ) {
                if ( $value == "1" ) {
                    echo $social_links[$key] . "&nbsp;";
                }
            }
        }
    } else {
        if ( is_array( $single_icons ) ) {
            foreach ( $single_icons as $key => $value ) {
                if ( $value == "1" ) {
                    echo $social_links[$key] . "&nbsp;";
                }
            }
        }
    }
}

/**
 * Techozoic Single Nav Links
 *
 * Echos the single nav links on single pages.
 * 
 *
 *
 * @access    public
 * @since     2.1
 */

function tech_single_nav_links() {
    echo '<div class="navigation clear">';
    if ( is_single() ) {
        if ( get_adjacent_post( false, '', true ) ) {
            echo '<div class="alignleft">';
            previous_post_link( '&laquo; %link' );
            echo '</div>';
        }
        if ( get_adjacent_post( false, '', false ) ) {
            echo '<div class="alignright">';
            next_post_link( '%link &raquo;' );
            echo '</div>';
        }
    }
    echo '</div>';
}

/**
 * Techozoic Nav Links
 *
 * Echos the nav links on archive pages.
 * 
 *
 *
 * @access    public
 * @since     2.1
 */

function tech_nav_links() {
    $prev_link = get_next_posts_link( __( '&laquo; Older Entries', 'techozoic' ) );
    $next_link = get_previous_posts_link( __( 'Newer Entries &raquo;', 'techozoic' ) );
    echo '<div class="navigation clear">';
    if ( $prev_link ) {
        echo '<div class="alignleft">' . $prev_link . '</div>';
    }
    if ( $next_link ) {
        echo '<div class="alignright">' . $next_link . '</div>';
    }
    echo '</div>';
}

/**
 * Techozoic Archive title
 *
 * Echos the title base on what archive user is currently browsing.
 * 
 *
 * @access    public
 * @since     2.1
 */

function tech_archive_title() {
    /* If this is a category archive */
    if ( is_category() ) {
        echo '<h2 class="pagetitle"> ' . sprintf( __( '%s Archive', 'techozoic' ), single_cat_title( '', false ) ) . '</h2>';
        /* If this is a daily archive */
    } elseif ( is_day() ) {
        echo '<h2 class="pagetitle"> ' . sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'F jS, Y' ) ) . '</h2>';
        /* If this is a monthly archive */
    } elseif ( is_month() ) {
        echo '<h2 class="pagetitle"> ' . sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'F, Y' ) ) . '</h2>';
        /* If this is a yearly archive */
    } elseif ( is_year() ) {
        echo '<h2 class="pagetitle"> ' . sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'Y' ) ) . '</h2>';
        /* If this is a search */
    } elseif ( is_search() ) {
        echo '<h2 class="pagetitle">' . __( 'Search Results', 'techozoic' ) . '</h2>';
        /* If this is an author archive */
    } elseif ( is_author() ) {
        echo '<h2 class="pagetitle"> ' . __( 'Author Archive', 'techozoic' ) . '</h2>';
        /* If this is a paged archive */
    } elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
        echo '<h2 class="pagetitle"> ' . __( 'Blog Archives', 'techozoic' ) . '</h2>';
    }
}

/**
 * Techozoic breadcrumb navigation
 *
 * Displays breadcrumb navigation if option is set.
 * 
 * @access    public
 */

function tech_breadcrumbs() {
// Thanks to dimox for the code
//http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
    global $tech;
    $delimiter = '&raquo;';
    $name = __( 'Home', 'techozoic' );
    $currentBefore = '<span class="current">';
    $currentAfter = '</span>';

    if ( !is_home() || !is_front_page() || is_paged() ) {

        echo '<div id="crumbs">';

        global $post;
        $home = home_url();
        echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';

        if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category( $thisCat );
            $parentCat = get_category( $thisCat->parent );
            if ( $thisCat->parent != 0 )
                echo(get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' ));
            echo $currentBefore . __( 'Archive for category &#39;', 'techozoic' );
            single_cat_title();
            echo '&#39;' . $currentAfter;
        } elseif ( is_day() ) {
            echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time( 'd' ) . $currentAfter;
        } elseif ( is_month() ) {
            echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time( 'F' ) . $currentAfter;
        } elseif ( is_year() ) {
            echo $currentBefore . get_the_time( 'Y' ) . $currentAfter;
        } elseif ( is_single() && !is_attachment() ) {
            $cat = get_the_category();
            if ( $cat ) {
                $cat = $cat[0];
                echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
            }
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif ( is_page() && !$post->post_parent ) {
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array( );
            while ( $parent_id ) {
                $page = get_page( $parent_id );
                $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            foreach ( $breadcrumbs as $crumb )
                echo $crumb . ' ' . $delimiter . ' ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif ( is_search() ) {
            echo $currentBefore . __( 'Search results for &#39;', 'techozoic' ) . get_search_query() . '&#39;' . $currentAfter;
        } elseif ( is_tag() ) {
            echo $currentBefore . __( 'Posts tagged &#39;', 'techozoic' );
            single_tag_title();
            echo '&#39;' . $currentAfter;
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata( $author );
            echo $currentBefore . __( 'Articles posted by ', 'techozoic' ) . $userdata->display_name . $currentAfter;
        } elseif ( is_404() ) {
            echo $currentBefore . __( 'Error 404', 'techozoic' ) . $currentAfter;
        }

        if ( get_query_var( 'paged' ) ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
                echo ' (';
            echo __( 'Page', 'techozoic' ) . ' ' . get_query_var( 'paged' );
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
                echo ')';
        }

        echo '</div>';
    }
}