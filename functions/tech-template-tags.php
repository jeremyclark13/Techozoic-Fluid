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
 * @since        1.0
 *
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