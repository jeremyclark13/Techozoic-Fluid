<?php
/**
 * Theme Functions
 *
 * Holds functions used in various areas of theme.
 *
 * @package      Techozoic Fluid
 * @author       Jeremy Clark <jeremy@clark-technet.com>
 * @copyright    Copyright (c) 2011, Jeremy Clark
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
 *
 */

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */

if ( !function_exists( 'optionsframework_init' ) ) {
    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
    require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

require_once dirname( __FILE__ ) . '/options.php';

include(get_template_directory() . '/functions/tech-meta-box.php');
// Loads custom meta boxes on single post and page edit screen

include(get_template_directory() . '/functions/tech-twitter.php');
// Loads functions for pulling twitter feeds

include(get_template_directory() . '/functions/tech-template-tags.php');
// Loads template tags

if ( !isset( $content_width ) ) {
    $content_width = tech_content_width();
}

add_action( 'after_setup_theme', 'techozoic_setup' );

/**
 * Techozoic Theme setup
 *
 * Setup theme translation, theme features, menus, and custom header
 * 
 *
 * @access    private
 * @since     2.0
 */

function techozoic_setup() {
    global $content_width, $wp_version;
    load_theme_textdomain( 'techozoic', get_template_directory() . '/languages' );
    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";
    if ( is_readable( $locale_file ) )
        require_once($locale_file);
    // Include other custom functions files
    include(get_template_directory() . '/functions/tech-widget.php');
    include(get_template_directory() . '/functions/tech-comments-functions.php');
    include(get_template_directory() . '/functions/tech-css.php');
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'single-post-thumbnail', $content_width, 9999 );
    //WP 2.9 Post Thumbnail Support
    add_theme_support( 'automatic-feed-links' );
    //WP Auto Feed Links
    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'status' ) );
    //WP Post Format
    add_theme_support( 'bbpress' );
    //bbPress Support
    add_theme_support ( 'infinite-scroll', array(
        'container' => 'content',
        'footer' => 'page',
        'footer_widgets' => 'tech_footer',
    ));
    register_nav_menus( array(
        'primary' => __( 'Header Navigation', 'techozoic' ),
        'sidebar' => __( 'Sidebar Navigation', 'techozoic' ),
        'footer' => __( 'Footer Navigation', 'techozoic' ),
    ) );
    //WP Navigation Menu
    if ( version_compare( $wp_version, '3.4', '>=' ) ) {
        add_theme_support( 'custom-header', array(
            // Header image default
            'default-image' => get_template_directory_uri() . '/images/headers/Grunge.jpg',
            // Header text display default
            'header-text' => false,
            // Header text color default
            'default-text-color' => '000',
            // Header image width (in pixels)
            'width' => of_get_option( 'header_width', '1000' ),
            'flex-width' => true,
            // Header image height (in pixels)
            'height' => of_get_option( 'header_height', '200' ),
            'flex-height' => true,
            // Header image random rotation default
            'random-default' => true,
            // Template header style callback
            'wp-head-callback' => 'techozoic_header_style',
            // Admin header style callback
            'admin-head-callback' => 'techozoic_admin_header_style',
            // Admin preview style callback
            'admin-preview-callback' => 'techozoic_admin_header_image'
        ) );
    } else {
        add_theme_support( 'custom-header', array( 'random-default' => true ) );
        //WP Custom Header - random roation by default
        define( 'HEADER_TEXTCOLOR', '' );
        define( 'HEADER_IMAGE', '' );
        define( 'HEADER_IMAGE_HEIGHT', of_get_option( 'header_height', '200' ) );
        define( 'HEADER_IMAGE_WIDTH', of_get_option( 'header_width', '1000' ) );
        define( 'NO_HEADER_TEXT', true );
        add_custom_image_header( 'techozoic_header_style', 'techozoic_admin_header_style', 'techozoic_admin_header_image' );
    }
    register_default_headers( array(
        'grunge' => array(
            'url' => '%s/images/headers/Grunge.jpg',
            'thumbnail_url' => '%s/images/headers/Grunge-thumbnail.jpg',
            'description' => __( 'Grunge', 'techozoic' )
        ),
        'landscape' => array(
            'url' => '%s/images/headers/Landscape.jpg',
            'thumbnail_url' => '%s/images/headers/Landscape-thumbnail.jpg',
            'description' => __( 'Landscape', 'techozoic' )
        ),
        'random_lines_1' => array(
            'url' => '%s/images/headers/Random_Lines_1.jpg',
            'thumbnail_url' => '%s/images/headers/Random_Lines_1-thumbnail.jpg',
            'description' => __( 'Random Lines 1', 'techozoic' )
        ),
        'random_lines_2' => array(
            'url' => '%s/images/headers/Random_Lines_2.jpg',
            'thumbnail_url' => '%s/images/headers/Random_Lines_2-thumbnail.jpg',
            'description' => __( 'Random Lines 2', 'techozoic' )
        ),
        'technology' => array(
            'url' => '%s/images/headers/Technology.jpg',
            'thumbnail_url' => '%s/images/headers/Technology-thumbnail.jpg',
            'description' => __( 'Technology', 'techozoic' )
        ),
    ) );
}

/**
 * Techozoic header style
 *
 * Custom header frontend style.
 * 
 *
 * @access    private
 * @since     2.0
 */

function techozoic_header_style() {
    ?>
    <style type="text/css">
        #header {
            background-image: url(<?php header_image(); ?>);
        }
    </style>
    <?php
}

/**
 * Techozoic admin header style
 *
 * Custom header admin page style.
 * 
 *
 * @access    private
 * @since     2.0
 */

function techozoic_admin_header_style() {
    ?>
    <style type="text/css">
        #headimg img {
            max-width: 1000px;
            height: auto;
        }
    </style>
    <?php
}

/**
 * Techozoic admin header html
 *
 * Custom admin header html.
 * 
 *
 * @access    private
 * @since     2.0
 */
function techozoic_admin_header_image() {
    ?>
    <div id="headimg">
        <?php
        $header_image = get_header_image();
        if ( !empty( $header_image ) ) :
            ?>
            <img src="<?php echo esc_url( $header_image ); ?>" alt="" />
        <?php endif; ?>
    </div>
    <?php
}


/**
 * Techozoic Theme Logo
 *
 * function for option page hook to output css to head to change icon.
 * 
 *
 * @access    private
 * @since     2.0
 */

add_action( 'admin_head-appearance_page_options-framework', 'techozoic_theme_logo' );
add_action( 'admin_head-appearance_page_options-backup', 'techozoic_theme_logo' );

function techozoic_theme_logo() {
    ?>
    <style type="text/css">
        #icon-themes, #icon-import-export {
            background: url(" <?php echo get_template_directory_uri() ?>/images/techozoic-logo-small.png") no-repeat scroll 2px 0px transparent;
        }
    </style>
    <?php
}

/**
 * Techozoic WP Title
 *
 * Utilizes the `wp_title` filter to add text to the default output
 * 
 * @param string $old_title - default title text
 * @param string $sep - separator character
 * @param string $sep_location - left|right - separator placement in relationship to title
 *
 * @return string - new title text
 */

add_filter( 'wp_title', 'tech_wp_title', 10, 3 );

function tech_wp_title( $old_title, $sep, $sep_location ) {
    global $page, $paged;
    /** Set initial title text */
    $title = get_bloginfo( 'name' );
    /** Add wrapping spaces to separator character */
    $sep = ' ' . $sep . ' ';

    $tech_title_text = $title;
    
    /** Add the blog description (tagline) for the home/front page */
    $site_tagline = get_bloginfo( 'description', 'display' );
    if ( $site_tagline && ( is_home() || is_front_page() ) )
        $tech_title_text = $title . $sep . $site_tagline;

    if ( is_page() || is_single() )
        $tech_title_text = get_the_title() . $sep . $title;

    if ( is_category() ) {
        $tech_title_text = sprintf( __( '%s Archive', 'techozoic' ), single_cat_title( '', false ) ) . $sep . $title;
    } elseif ( is_day() ) {
        $tech_title_text = sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'F jS, Y' ) ) . $sep . $title;
    } elseif ( is_month() ) {
        $tech_title_text = sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'F, Y' ) ) . $sep . $title;
    } elseif ( is_year() ) {
        $tech_title_text = sprintf( __( 'Archive for %s', 'techozoic' ), get_the_time( 'Y' ) ) . $sep . $title;
    } elseif ( is_search() ) {
        $tech_title_text = sprintf( __( 'Search Results for %s', 'techozoic' ), $_GET['s'] ) . $sep . $title;
    } elseif ( is_author() ) {
        $tech_title_text = __( 'Author Archive', 'techozoic' ) . $sep . $title;
    } elseif ( is_tag() ) {
        $tech_title_text = __( 'Tag Archive', 'techozoic' ) . $sep . $title;
    }

    /** Add a page number if necessary */
    if ( $paged >= 2 || $page >= 2 )
        $tech_title_text .= $sep . sprintf( __( 'Page %s', 'techozoic' ), max( $paged, $page ) );

    return $tech_title_text;
}


/**
 * Techozoic mobile css
 *
 * Enqueues mobile css if option is set.  Outputs small menu javascript.
 * Will be incorparated into main style.css in upcoming versions
 * 
 * @access    private
 * @since     2.0.4
 */
if ( of_get_option( 'mobile_css', '0' ) == "1" ) {
    add_action( 'wp_enqueue_scripts', 'tech_enque_mobile' );
    add_action( 'wp_head' , 'tech_small_menu_js');
}

function tech_enque_mobile() {
    $script_dir = get_template_directory_uri() . '/js/';
    wp_register_style( 'tech-mobile', get_template_directory_uri() . '/css/mobile.css', false, 0.1 );
    wp_enqueue_style( 'tech-mobile' );
    wp_enqueue_script( 'jquery' );
    //wp_register_script( 'small-menu', $script_dir . 'small-menu.js', array( 'jquery' ), '1.0' );
    //wp_enqueue_script( 'small-menu' );
}

function tech_small_menu_js(){
    echo '<script type="text/javascript">
        jQuery(document).ready(function($){
	/* toggle nav */
	$("#menu-icon").on("click", function(){
		$(".top-menu").slideToggle();
		$(this).toggleClass("active");
	});

        });
        </script>';
}

/**
 * Techozoic custom menu walker
 *
 * Outputs custom menu class if menu has children.
 * 
 * @access    private
 * @since     2.0
 */

class techozoic_menu_walker extends Walker_Nav_Menu {

    function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $item, $depth, $args ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = $childclass = '';

        if ( $args->has_children ) {
            $childclass = 'has_children';
        }
        $classes = empty( $item->classes ) ? array( ) : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . ' ' . $childclass . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .=!empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .=!empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .=!empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

/**
 * Techozoic change fonts
 *
 * Addes additional fonts to options framework for Google Web Fonts
 * 
 * @access    private
 * @since     2.0.4
 */
add_action( 'admin_init', 'tech_options_change_font', 10, 2 );

function tech_options_change_font() {
    add_filter( 'of_recognized_font_faces', 'tech_change_fonts' );
}

function tech_change_fonts( $fonts ) {
    $google_fonts = array(
        'google1' => 'Google Font 1',
        'google2' => 'Google Font 2'
    );
    return array_merge( $fonts, $google_fonts );
}

/**
 * Techozoic change saniziation
 *
 * Removes standard options page filter and applies custom filter
 * 
 * @access    private
 * @since     2.0
 */

add_action( 'admin_init', 'tech_options_change_santiziation', 10, 2 );

function tech_options_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'tech_sanitize_textarea' );
}

/**
 * Techozoic Sanitize Textarea Filter
 *
 * Used to filter textarea input fields from option page
 * 
 * @param     string    unfiltered text from option page
 * @return    string    filtered text to store in database
 *
 * @access    private
 * @since     2.0
 */

function tech_sanitize_textarea( $input ) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
        "src" => array( ),
        "type" => array( ),
        "allowfullscreen" => array( ),
        "allowscriptaccess" => array( ),
        "height" => array( ),
        "width" => array( )
    );
    $custom_allowedtags["small"] = array( );
    $custom_allowedtags["script"] = array(
        "src" => array( ),
        "type" => array( )
    );
    $custom_allowedtags["iframe"] = array(
        "src" => array( ),
        "height" => array( ),
        "width" => array( ),
        "frameborder" => array( ),
        "allowfullscreen" => array( )
    );

    $custom_allowedtags = array_merge( $custom_allowedtags, $allowedposttags );
    $output = wp_kses( $input, $custom_allowedtags );
    return $output;
}

/**
 * Techozoic Exclude aside/status post format from RSS
 *
 * Remove certain post formats from feed query
 * 
 * @param     string  $wp_query  wp_query from hook
 * @return    string  $wp_query  wp_query with post formats removed.
 *
 * @access    public
 * @since     2.0
 */

add_action( 'pre_get_posts', 'tech_exclude_post_formats_from_feeds' );

function tech_exclude_post_formats_from_feeds( &$wp_query ) {

// Only do this for feed queries:
    if ( $wp_query->is_feed() ) {

// Array of post formats to exclude, by slug,
        $post_formats_to_exclude = array(
            'post-format-status',
            'post-format-aside'
        );

// Extra query to hack onto the $wp_query object:
        $extra_tax_query = array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => $post_formats_to_exclude,
            'operator' => 'NOT IN'
        );

        $tax_query = $wp_query->get( 'tax_query' );
        if ( is_array( $tax_query ) ) {
            $tax_query = $tax_query + $extra_tax_query;
        } else {
            $tax_query = array( $extra_tax_query );
        }
        $wp_query->set( 'tax_query', $tax_query );
    }
}

$tech_home_social = of_get_option( 'home_social_icons', array( 'delicious' => '1', 'digg' => '1', 'rss' => '1' ) );
$tech_single_social = of_get_option( 'single_social_icons', array( 'delicious' => '1', 'digg' => '1', 'rss' => '1' ) );

/**
 * Techozoic Google Plus one JS
 *
 * Output javascript need for plus one button.
 * 
 *
 * @access    public
 * @since     2.0
 */
if ( $tech_home_social['google'] == 1 || $tech_single_social['google'] == 1 ) {
    add_action( 'wp_footer', 'tech_plus_one' );
}

function tech_plus_one() {
    echo "<script type=\"text/javascript\">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
      jQuery( document.body ).on( 'post-load', function() {
        if ( typeof gapi !== 'undefined')
            gapi.plusone.go(\"content\");
});; 
    </script>";
}

/**
 * Techozoic Pintrest JS
 *
 * Output javascript needed for pin it button.
 * 
 *
 * @access    public
 * @since     2.0.6
 */
if ( $tech_home_social['pintrest'] == 1 || $tech_single_social['pintrest'] == 1 ) {
    add_action( 'wp_footer', 'tech_pin_it' );
}

function tech_pin_it() {
    echo "<script type='text/javascript' src='//assets.pinterest.com/js/pinit.js'></script>";
}

/**
 * Techozoic Theme Links
 *
 * Used to output links to theme support and rss feed of theme news
 * 
 * @return    string  $output   HTML for theme links box
 *
 * @access    public
 * @since   
 *   1.9.3
 */

function techozoic_links_box() {
// Get RSS Feed(s)
    $feed_address = "http://techozoic.clark-technet.com/category/news/feed";
    $feed_items = 5;
    include_once(ABSPATH . WPINC . '/feed.php');
// Get a SimplePie feed object from the specified feed source.
    $rss = fetch_feed( $feed_address );
    if ( !is_wp_error( $rss ) ) {
// Checks that the object is created correctly 
// Figure out how many total items there are, but limit it to $feed_items. 
        $maxitems = $rss->get_item_quantity( $feed_items );

// Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );
        $output = '<ul>';
        if ( isset( $maxitems ) && $maxitems == 0 ) {
            $output .= '<li>' . __( 'No News.', 'techozoic' ) . '</li>';
        } else {
            // Loop through each feed item and display each item as a hyperlink.
            foreach ( $rss_items as $item ) {
                $output .= "<li><a href='{$item->get_permalink()}' target='_blank' title='{$item->get_title()}'>{$item->get_title()}</a></li>";
            }
            $output.='</ul>';
        }
    }
    $output .= "<strong>" . __( 'Techozoic Links', 'techozoic' ) . "</strong>
	<ul>
		<li><a href='http://clark-technet.com/theme-support/techozoic'>" . __( 'Support Forum', 'techozoic' ) . "</a></li>
                <li><a href='https://github.com/jeremyclark13/Techozoic-Fluid/issues'>" . __( 'Open a Bug Report', 'techozoic' ) . "</a></li>		
                <li><a href='http://techozoic.clark-technet.com/documentation/'>" . __( 'Documentation', 'techozoic' ) . "</a></li>
		<li><a href='http://techozoic.clark-technet.com/documentation/faq/'>" . __( 'FAQ', 'techozoic' ) . "</a></li>  
        </ul>";
    return $output;
}

/**
 * Techozoic All Image Size Links
 *
 * Used to output links to all available images sizes of wp_attachment
 * Code adapted from Justin Tadlock 
 * http://justintadlock.com/archives/2011/01/28/linking-to-all-image-sizes-in-wordpress
 * 
 * @return    string    Joined array of all image size links.
 *
 * @access    public
 * @since     1.9.3
 */

function tech_image_links() {
    if ( !wp_attachment_is_image( get_the_ID() ) ) {
        return;
    }
    $links = array( );
    $sizes = get_intermediate_image_sizes();
    $sizes[] = 'full';
    foreach ( $sizes as $size ) {
        $image = wp_get_attachment_image_src( get_the_ID(), $size );
        if ( !empty( $image ) && ( true == $image[3] || 'full' == $size ) ) {
            $links[] = "<a class='image-size-link' href='{$image[0]}'>{$image[1]} &times; {$image[2]}</a>";
        }
    }
    return join( ' <span class="sep">|</span> ', $links );
}

/**
 * Techozoic excerpt location
 *
 * Used to check whether current page type is in excerpt locations set in options
 * 
 * @param       string  $where  Current page type
 * @return      bool    Return if current page is in excerpt_location array    
 *
 * @access    public
 * @since     1.9.3
 */

function tech_excerpt( $where ) {
    $locs = of_get_option( 'excerpt_location', array( "tag" => '1' ) );
    if ( $locs[$where] == '1' ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Techozoic social icons location
 *
 * Used to check whether current page type is in post social media locations set in options
 * 
 * @param       string  $where  Current page type
 * @return      bool    Return if current page is in post_social_media_location array    
 *
 * @access    public
 * @since     1.9.3
 */

function tech_icons( $where ) {
    $locs = of_get_option( 'post_social_media_location', array( "main" => "1", 'single' => '1' ) );
    if ( $locs[$where] == '1' ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Techozoic excerpt filter
 *
 * Filter that replaces ellipses with proper html ententity and link to single post page
 * 
 * @param       string  $text  exceprt text
 * @return      string    string replaced excerpt text    
 *
 * @access    private
 * @since     1.9.3
 */

add_filter( 'the_excerpt', 'tech_excerpt_filter' ); // Replaces [...] at end of excerpt with link to single post page.

function tech_excerpt_filter( $text ) {
    global $post;
    return str_replace( '[...]', '<a href="' . get_permalink( $post->ID ) . '">' . ' [&hellip; ' . __( 'Read More', 'techozoic' ) . ']' . '</a>', $text );
}

if ( of_get_option( 'google_font', '0' ) == '1' ) {

    /**
     * Techozoic google font 
     *
     * Enqueues google font stylesheet based on google_fonts option
     *    
     *
     * @access    private
     * @since     1.9.3
     */
    add_action( 'wp_enqueue_scripts', 'tech_google_font' );

    function tech_google_font() {
        $font_name1 = of_get_option( 'google_font_family', '' );
        $tech_google_font1 = str_ireplace( ' ', '+', $font_name1 );
        $font_name2 = of_get_option( 'google_font_family_2', '' );
        $tech_google_font2 = str_ireplace( ' ', '+', $font_name2 );
        wp_enqueue_style( 'google_fonts', "http://fonts.googleapis.com/css?family={$tech_google_font1}|{$tech_google_font2}", '', '', 'screen' );
    }

}//End if goolge_font check

/**
 * Techozoic WP menu fallback
 *
 * Callback for use in wp_nav_menu when no menu is assigned.
 *   
 *
 * @access    private
 * @since     1.9.1
 */

function tech_menu_fallback() {
    $output = ' <ul id="dropdown"> ';
    $clean_page_list = wp_list_pages( 'sort_column=menu_order&title_li=&echo=0' );
    $clean_page_list = preg_replace( '/title=\"(.*?)\"/', '', $clean_page_list );
    $output .= $clean_page_list;
    $output .= '</ul>';
    echo $output;
}

/**
 * Techozoic WP menu fallback
 *
 * filter to add css class to wp_list_pages function for styling fallback menu 
 * child menus
 *   
 * @param   array   $css_class  class array from filter
 * @param   int     $page   page id
 * @param   int     $depth  page nested depth
 * @param   array   $args   args from filter
 *
 * @access    private
 * @since     2.1
 */

function tech_add_menu_parent_class( $css_class, $page, $depth, $args )
{
    if ( ! empty( $args['has_children'] ) )
        $css_class[] = 'has_children';
    return $css_class;
}
add_filter( 'page_css_class', 'tech_add_menu_parent_class', 10, 4 );

/**
 * Techozoic Font Resize Script
 *
 * Enqueues and register font resize script used for Techozoic font resize widget.
 *  
 *
 * @access    private
 * @since     1.9.1
 */

if ( is_active_widget( false, false, 'techozoic_font_size' ) ) {
    add_action( 'wp_footer', 'tech_font_size_script' );
}

function tech_font_size_script() {
    $script_dir = get_template_directory_uri() . '/js/';
    wp_register_script( 'font-size', $script_dir . 'font-resize.js', array( 'jquery' ), '1.0' );
    wp_enqueue_script( 'font-size' );
}

/**
 * Techozoic $content_width Function
 *
 * Sets $content_width variable used for image sizes by WordPress based on whether the
 * options are set to fixed or fluid width.  If set to fluid width, set to 500 otherwise
 * width is calculated from fixed widths set.
 * 
 * @return      int     content width   
 *
 * @access    private
 * @since     1.8.8
 */

function tech_content_width() {
    global $tech;
    $p_width = of_get_option( 'page_width', '90' );
    $c_width = of_get_option( 'main_column_width', '50' );
    $page = of_get_option( 'page_type', 'fluid' );
    if ( $page == "fixed" && $p_width != 0 && $c_width != 0 ) {
        $c_width = $c_width / 100;
        $output = $p_width * $c_width;
    } else {
        $output = 500;
    }
    return $output;
}


/**
 * Techozoic Sidebar Display Function
 *
 * Determine which sidebar template should be shown based on options.
 * 
 * 
 * @param   string  $loc  location of current template function called from 
 *
 * @access    public
 * @since     1.8.8
 */

function tech_show_sidebar( $loc ) {
    if ( of_get_option( 'column', '3' ) > 1 ) {
        $left = 0;
        $right = 0;
        switch ( of_get_option( 'sidebar_pos', '3-col' ) ) {
            case "3-col":
                $left = 1;
                $right = 1;
                break;
            case "3-col-right":
                $left = 0;
                $right = 2;
                break;
            case "3-col-left":
                $left = 2;
                $right = 0;
                break;
            case "2-col-right":
                $left = 0;
                $right = 1;
                break;
            case "2-col-left":
                $left = 1;
                $right = 0;
                break;
        }
        if ( $loc == "l" && $left > 0 ) {
            get_template_part( 'sidebar', 'left' );
            if ( $left > 1 ) {
                get_sidebar();
            }
        }
        if ( $loc == "r" && $right > 0 ) {
            get_sidebar();
            if ( $right > 1 ) {
                get_template_part( 'sidebar', 'left' );
            }
        }
    }
}


/**
 * Techozoic About Icons Function
 *
 * Used to display social media profile links for Techozoic About widget.
 * 
 * 
 * @param   int $fb     if facebook profile link is checked
 * @param   int $my     if myspace profile link is checked
 * @param   int $twitter     if twitter profile link is checked  
 * @param   int $google     if google profile link is checked 
 * 
 * @access    public
 * @since     1.8.8
 */

function tech_about_icons( $fb = 0, $my = 0, $twitter = 0, $google = 0 ) {
    $fb_profile = of_get_option( 'facebook_profile', '' );
    $my_profile = of_get_option( 'myspace_profile', '' );
    $twitter_profile = of_get_option( 'twitter_profile', '' );
    $google_profile = of_get_option( 'google_profile', '' );
    $image = get_template_directory_uri() . "/images/icons";
    if ( $fb != 0 ) {
        echo "<li><a href='{$fb_profile}' title='" . __( 'Follow me on Facebook', 'techozoic' ) . "' class='about facebook32'></a></li>";
    }
    if ( $my != 0 ) {
        echo "<li><a href='{$my_profile}' title='" . __( 'Follow me on Myspace', 'techozoic' ) . "' class='about myspace32'></a></li>";
    }
    if ( $twitter != 0 ) {
        echo "<li><a href='{$twitter_profile}' title='" . __( 'Follow me on Twitter', 'techozoic' ) . "' class='about twitter32'></a></li>";
    }
    if ( $google != 0 ) {
        echo "<li><a href='{$google_profile}' title='" . __( 'Follow me on Google+', 'techozoic' ) . "' class='about google32'></a></li>";
    }
}




if ( is_admin() && (isset( $_GET['page'] ) && $_GET['page'] == 'custom-header') && $pagenow == "themes.php" ) {

    /**
     * Techozoic header notice
     *
     * Used to show that header height and width can be set on the options page.
     *     
     *
     * @access    private
     * @since     2.0
     */
    add_action( 'admin_notices', 'techozoic_header_notice' );  // Shows custom theme activation notice with links to option page and changelog

    function techozoic_header_notice() {
        ?>
        <div id="message" class="updated fade">
            <p><?php printf( __( 'Header height and width and aligment can be set on the <a href="%s">theme options</a> page.', 'techozoic' ), admin_url( 'themes.php?page=options-framework' ) ); ?></p>
        </div>
        <?php
    }

}//End if custom header page


if ( of_get_option( 'thickbox', '0' ) == '1' ) {

    /**
     * Techozoic thickbox image paths
     *
     * Fixes paths to loading and close images used with thickbox. 
     * 
     *
     * @access    private
     */
    
    add_action( 'wp_footer', 'tech_thickbox_image_paths' );

    function tech_thickbox_image_paths() {
        $thickbox_path = get_option( 'siteurl' ) . '/wp-includes/js/thickbox/';
        echo "<script type='text/javascript'>\n";
        echo "	var tb_pathToImage = \"${thickbox_path}loadingAnimation.gif\";\n";
        echo "	var tb_closeImage = \"${thickbox_path}tb-close.png\";\n";
        echo "</script>\n";
    }

    /**
     * Techozoic enqueue thickbox
     *
     * Enqueues thickbox script and stylesheet to be added to wp_head
     * 
     *
     * @access    private
     */
    
    add_action( 'wp_enqueue_scripts', 'tech_enque_thickbox' );

    function tech_enque_thickbox() {
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_style( 'thickbox' );
    }

    /**
     * Techozoic thickbox
     *
     * Replaces img links with img links with thickbox class and rel for grouping images
     * based on post id.
     * 
     * @param   string  $content  post content
     * @return  string  string replaced post content   
     *
     * @access    private
     * @since     1.9.3
     */
    
    add_filter( 'the_content', 'tech_thickbox', 65 );

    function tech_thickbox( $content ) {
        global $post;
        $pattern = array( '/<a([^>]*)href=[\'"]([^"\']+).(gif|jpeg|jpg|png)[\'"]([^>]*>)/i', '/<a class="thickbox" rel="%ID%" href="([^"]+)"([^>]*)class=[\'"]([^"\']+)[\'"]([^>]*>)/i' );
        $replacement = array( '<a class="thickbox" rel="%ID%" href="$2.$3"$1$4', '<a class="thickbox" rel="%ID% $3" href="$1"$2$4' );
        $content = preg_replace( $pattern, $replacement, $content );
        return str_replace( '%ID%', $post->ID, $content );
    }

} // End if thickbox check

?>