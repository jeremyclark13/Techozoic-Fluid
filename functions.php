<?php
	load_theme_textdomain( 'techozoic', TEMPLATEPATH.'/languages' );
	$locale = get_locale();
	$locale_file = TEMPLATEPATH."/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
	$upload_path = get_option('upload_path');
	if ( ! defined( 'WP_CONTENT_URL' ) )
    		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if ( ! defined( 'WP_CONTENT_DIR' ) )
    		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	define ('WP_UPLOAD_PATH', ABSPATH . $upload_path );
	if(is_admin()) {
		if ( $_GET['page'] == "techozoic_main_admin"  || $_GET['page'] == "techozoic_header_admin" || $_GET['page'] == "techozoic_style_admin" || $_GET['page'] == "techozoic_export_admin" ){
			$dir = WP_CONTENT_DIR. "/techozoic";
			if (!is_writable($dir)) {
				function techozoic_error_message() {
					$dir = WP_CONTENT_DIR. "/techozoic";
					$message = "<div class=\"updated fade\">". __("Please make sure <strong>${dir}</strong> exists and is writable.",'techozoic'). "</div>";
					echo $message;
				}	
				add_action( 'admin_notices','techozoic_error_message'); 
			}
		}
		include_once (TEMPLATEPATH . "/options/option-array.php");
		include_once(TEMPLATEPATH . '/options/main.php');
	}
	// Include other custom functions files
	include(TEMPLATEPATH.'/functions/tech-widget.php');
	include(TEMPLATEPATH.'/functions/tech-comments-functions.php');
	global $tech;
	$tech = get_option('techozoic_options');
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$version = $theme_data['Version'];
	
/**************************************
	Techozoic Automatic Feed Link Checking
	Since 1.8.8
***************************************/	
function tech_feed_link(){
	global $wp_version;
	$default_feed_link = '<link rel="alternate" type="application/rss+xml" title="'. get_bloginfo('name'). ' RSS Feed" href="'. get_bloginfo('rss2_url') .'" />';
	if($wp_version < 3){ 
		if(function_exists(automatic_feed_links)){
			$output .= automatic_feed_links();
		} else {
			$output .= $default_feed_link;
		}
	}
	echo $output;
}

/**************************************
	Techozoic Social Media Icons Function
	Since 1.8.8
***************************************/	
	function tech_social_icons($home=true){
		global $tech;
		global $post;
		$home_icons = explode(',' , $tech['home_social_icons']);
		$single_icons = explode(',' , $tech['single_social_icons']);
		$image = get_bloginfo('template_directory')."/images/icons";
		$link = get_permalink();
		$short_link = get_bloginfo('url')."/?p=".$post->ID;
		$title = $post->post_title;
		$url_title = urlencode($post->post_title);
		$social_links = array(
			"Delicious" => "<a href=\"http://delicious.com/post?url={$link}&amp;title={$url_title}\" title=\"". __('del.icio.us this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/delicious_16.png\" alt=\"Delicious This\"></a>",
			"Digg" => "<a href=\"http://digg.com/submit?phase=2&url={$link}&amp;title={$url_title} \" title=\"". __('Digg this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/digg_16.png\" alt=\"Digg This\"></a>",
			"Facebook" => "<a href=\"http://www.facebook.com/share.php?u={$link}&amp;t={$url_title}\" title=\"". __('Share on Facebook!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/facebook_16.png\" alt=\"Share on Facebook\"></a>",
			"MySpace" => "<a href=\"http://www.myspace.com/Modules/PostTo/Pages/?u={$link}&amp;t={$url_title}\" title=\"". __('Share on Myspace!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/myspace_16.png\" alt=\"Share on Myspace\"></a>",
			"StumbleUpon" => "<a href=\"http://www.stumbleupon.com/submit?url={$link}&amp;title={$url_title}\" title=\"". __('Stumble Upon this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/stumbleupon_16.png\" alt=\"Stumble Upon This\"></a>",
			"Twitter" => "<a href=\"http://twitter.com/home?status=Reading%20{$url_title}%20on%20{$short_link}\" title=\"". __('Tweet this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/twitter_16.png\" alt=\"Tweet This\"></a>",
			"RSS Icon" => "<a href=\"".get_post_comments_feed_link()."\" title=\"".__('Subscribe to Feed','techozoic')."\"><img src=\"{$image}/rss_16.png\" alt=\"".__('RSS 2.0','techozoic')."\"></a>");
		if ($home == true){
			foreach ($home_icons as $soc){
				echo $social_links[$soc] ."&nbsp;";
			}
		} else {
			foreach ($single_icons as $soc){
				echo $social_links[$soc] ."&nbsp;";
			}
		}
	}

/**************************************
	Techozoic About Icons Function
	Since 1.8.8
***************************************/
	function tech_about_icons($fb=0,$my=0,$twitter=0){
	global $tech;
	$fb_profile = $tech['facebook_profile'];
	$my_profile = $tech['myspace_profile'];
	$twitter_profile = $tech['twitter_profile'];
	$image = get_bloginfo('template_directory')."/images/icons";
	if ($fb !=0){
		echo "<li><a href=\"{$fb_profile}\" title=\"".__('Follow me on Facebook','techozoic')."\"><img src=\"{$image}/facebook_32.png\"></a></li>";
	}
	if ($my !=0){
		echo "<li><a href=\"{$my_profile}\" title=\"".__('Follow me on Myspace','techozoic')."\"><img src=\"{$image}/myspace_32.png\"></a></li>";
	}	
	if ($twitter !=0){
		echo "<li><a href=\"{$twitter_profile}\" title=\"".__('Follow me on Twitter','techozoic')."\"><img src=\"{$image}/twitter_32.png\"></a></li>";
	}
	}
	
/**************************************
	Techozoic Home Page Comment Preview
	Since 1.8.7
***************************************/	
	function tech_comment_preview($ID,$num){
		global $comment;
		$comment_array = get_comments(array('post_id'=>$ID,'number'=>$num/*,'type'=>'comment','status'='approved'*/));
		if ($comment_array) {
			$output .=	'<ul class="comment-preview">';
			foreach($comment_array as $comment){
				$output .= '<li class="comments-link">';
				$output .= '<div class="comment-author">';
				$output .= '<a href="'. get_comment_link() .'" title="'. $comment->comment_author . __(' posted on ') . get_comment_date() .'">';
				$output .= $comment->comment_author . __(' posted on ') . get_comment_date();
				$output .= '</a>';
				$output .= '</div>';
				$output .= '<div class="comment-text">';
				$output .= get_comment_excerpt($comment->comment_ID);
				$output .= '</div>';
				$output .= '</li>';
			}
			$output .= '</ul>';
		}
		print $output;
	}
	
/**************************************
	Techozoic Custom Activation Message
	Since 1.8.6
***************************************/
	function techozoic_show_notice() { ?>
	        <div id="message" class="updated fade">
	                <p><?php printf( __( 'Theme activated! This theme contains <a href="%s">theme options</a> and <a href="%s">custom sidebar widgets</a>.<br />&nbsp; See <a href="%s">Change Log</a>.', 'techozoic' ), admin_url( 'admin.php?page=techozoic_main_admin' ), admin_url( 'widgets.php' ) , get_bloginfo('template_directory')."/changelog.php\" onclick=\"return changelog('". get_bloginfo('template_directory')."/changelog.php')\"") ?></p>
	        </div>
	        <style type="text/css">#message2, #message0 { display: none; }</style>
	        <?php
	}

/**************************************
	Techozoic Cufon Font Replacement
	Since 1.8.7
***************************************/
	function tech_cufon_script() {
		global $tech;
		$script_dir = get_bloginfo('template_directory').'/js/';
		$tech_adv_font = $tech['cufon_font_list'];
		wp_register_script('cufon', $script_dir .'cufon-yui.js', array('jquery'), '1.0');
		wp_enqueue_script('tech_font', $script_dir .'cufon_fonts/'. $tech_adv_font.'.font.js', array('jquery','cufon'), '1.0');
		wp_enqueue_script('fontscall', $script_dir .'fontscall.js', array('jquery', 'cufon'), '1.0', true);	
	}

	function tech_cufon_options() {
		global $tech;
		if (strstr($tech['cufon_font_headings'], 'Main Blog Title')){
			$list .="#headerimg h1 ,";
		}
		if (strstr($tech['cufon_font_headings'], 'Sidebar Titles')){
			$list .=" .sidebar h2, .sidebar h3, #footer h2 ,";
		}
		if (strstr($tech['cufon_font_headings'], 'Post Titles')){
			$list .=".post_title ,";
		}
		$head .= "<script type='text/javascript'>\n";
		$head .= "Cufon.replace('". $list ."',{hover:true});";
		$head .= "</script>\n";
		print $head;
	}

/**************************************
	Techozoic Cufon Font Replacement
	END
***************************************/	

/**************************************
	Techozoic Custom Meta Box
	Since 1.8.6
***************************************/
	
	$new_meta_boxes =
	array(
	"sidebar" => array(
		"name" => "Sidebar",
		"std" => "",
		"title" => "Disable Sidebar",
		"description" => "Checking the box will disable the sidebar showing on this post/page single view."
		),
	"nav" => array(
		"name" => "Nav",
		"std" => "",
		"title" => "Disable Navigation Menu",
		"description" => "Checking the box will disable the navigation menu on this post/page single view."
		)
	);

	function new_meta_boxes() {
		global $post, $new_meta_boxes;
		foreach($new_meta_boxes as $meta_box) {
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
			if($meta_box_value == "") {
				$meta_box_value = $meta_box['std'];
			}
			$checked = $meta_box_value ? 'checked="checked"' : '';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce('techozoic-nonce').'" />';
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';
			echo'&nbsp;<input type="checkbox" name="'.$meta_box['name'].'_value" value="checked" '.$checked.' /> Disable '.$meta_box['name'].'<br />';
		}
	}
 
	function create_meta_box() {
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'techozoic-meta-boxes', 'Techozoic Options', 'new_meta_boxes', 'post', 'side', 'low' );
			add_meta_box( 'techozoic-meta-boxes', 'Techozoic Options', 'new_meta_boxes', 'page', 'side', 'low' );
		}
	}

	function save_postdata( $post_id ) {
		global $post, $new_meta_boxes;
		foreach($new_meta_boxes as $meta_box) {
			// Verify NONCE
			if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], 'techozoic-nonce' )) {
				return $post_id;
			}
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id )){
					return $post_id;
				}
			} else {
				if ( !current_user_can( 'edit_post', $post_id )){
					return $post_id;
				}
			}
			$data = $_POST[$meta_box['name'].'_value'];
			if(get_post_meta($post_id, $meta_box['name'].'_value') == ""){
				add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
			} elseif ($data != get_post_meta($post_id, $meta_box['name'].'_value', true)){
				update_post_meta($post_id, $meta_box['name'].'_value', $data);
			}elseif($data == ""){
				delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
			}
		}
	}
/**************************************
	Techozoic Custom Meta Box
	END
***************************************/

	function add_new_var_to_wp($public_query_vars) {
		$public_query_vars[] = 'techozoic_css';
		return $public_query_vars;
	}
	function techozoic_css_display(){
		$css = get_query_var('techozoic_css');
		if ($css == 'css'){
			include_once (TEMPLATEPATH . '/style.php');
			exit;
		}
	}
	if(function_exists('add_theme_support')) {
		add_theme_support( 'post-thumbnails' );
		//WP 2.9 Post Thumbnail Support
		add_theme_support('nav-menus');
		//WP 3.0 Menus	
		add_theme_support('automatic-feed-links');
		//WP Auto Feed Links
	}

	function techozoic_enqueue() {
		wp_enqueue_script('tech_thickbox', get_bloginfo('wpurl') . '/wp-content/themes/techozoic-fluid/js/thickbox.js',array('jquery'),'3.0' );
	}

	function my_custom_dashboard_widgets() {
	   	global $wp_meta_boxes;
	   	wp_add_dashboard_widget('techozoic_dashboard_widget', 'Techozoic Theme Setup', 'techozoic_dashboard_widget');
	}

	function techozoic_dashboard_widget() {
?>	   	<p><?php _e('Thank you for using the Techozoic Theme.  ' ,'techozoic'); 
			if (current_user_can('install_themes')) { 
				printf(__('Visit the %s to start customizing Techozoic.  ' ,'techozoic'),'<a href="admin.php?page=techozoic_main_admin" title="' . __("options page" ,"techozoic").'">'.__("options page" ,"techozoic").'</a>'); 
			} printf(__('If your having problems or would like to suggest a new feature, please visit the %s.' ,'techozoic'), '<a href="http://clark-technet.com/theme-support/techozoic/" title="' .__('Support Forum' ,'techozoic').'"> '.__('support forum' ,'techozoic').'</a>')?>
			<br />
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="10999960">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		</p>
<?php
	}

function first_run_options() {
	global $version;
	$header_folder = WP_CONTENT_DIR. "/techozoic/images/headers";
	$background_folder = WP_CONTENT_DIR. "/techozoic/images/backgrounds";
  	$check = get_option('techozoic_activation_check');
  	if ($check != $version || !file_exists($header_folder) || !file_exists($background_folder)) {
		include_once (TEMPLATEPATH . '/options/tech-init.php');
    		// Add marker so it doesn't run in future
  		add_option('techozoic_activation_check', $version);
		update_option('techozoic_activation_check', $version);
  	}
}//End first_run_options

function dropdown_js(){
	wp_enqueue_script('dropdown', get_bloginfo('wpurl') . '/wp-content/themes/techozoic-fluid/js/dropdown.js',array('jquery'),'3.0' );
}//End Dropdown_js

function tech_nav_link($where){
	global $tech;
	if ($tech['nav_cust_link_display'] == $where) {
		$i = 1;
		while ($i < 6) {
			$link_var = 'nav_link_'.$i;
			$link_var = $tech[$link_var];
			if ($link_var){
				$link_parts = explode("|",$link_var);
				$link .= "<li><a href=\"$link_parts[1]\" title=\"$link_parts[0]\">$link_parts[0]</a></li>";
			}
			$i++;
		}
	return $link;
	}
}

/**************************************
	Techozoic Breadcrumb Navigation
	Since 1.8.5
***************************************/

function tech_breadcrumbs() {
 // Thanks to dimox for the code
 //http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
  global $tech;
  $delimiter = '&raquo;';
  if ($tech['nav_home_text']) { 
	$name = $tech['nav_home_text'] ;
	} else {
	$name =  __('Home' ,'techozoic');
	}
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
  
  if ( !is_home() || !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . __('Archive for category &#39;' ,'techozoic');
      single_cat_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . __('Search results for &#39;' ,'techozoic') . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . __('Posts tagged &#39;' ,'techozoic');
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . __('Articles posted by ' ,'techozoic') . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . __('Error 404' ,'techozoic') . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}
function get_tech_options() {
	$tech = get_option('techozoic_options');
	return $tech;
}
  // credit to yoast.com
  function delete_comment_link($id) {
	  if (current_user_can('edit_post')) {
	    global $post;
	    echo ' | <a href="'.admin_url("comment.php?action=cdc&c=$id&redirect_to=/".$post->post_name."/").'">'. __("Delete" ,'techozoic').'</a> ';
	    echo '| <a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id&redirect_to=/".$post->post_name."/").'">'.__("Spam" ,'techozoic').'</a>';
	  }
	}

	if ($tech['thickbox'] =="On"){
	
		function thickbox_image_paths() {
			$thickbox_path = get_option('siteurl') . '/wp-includes/js/thickbox/';
			echo "<script type=\"text/javascript\">\n";
			echo "	var tb_pathToImage = \"${thickbox_path}loadingAnimation.gif\";\n";
			echo "	var tb_closeImage = \"${thickbox_path}tb-close.png\";\n";
			echo "</script>\n";
		}

		function tech_enque_thickbox() {
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}

		function tech_thickbox($content) {
			global $post;
			$pattern = array( '/<a([^>]*)href=[\'"]([^"\']+).(gif|jpeg|jpg|png)[\'"]([^>]*>)/i', '/<a class="thickbox" rel="%ID%" href="([^"]+)"([^>]*)class=[\'"]([^"\']+)[\'"]([^>]*>)/i' );
			$replacement = array( '<a class="thickbox" rel="%ID%" href="$2.$3"$1$4', '<a class="thickbox" rel="%ID% $3" href="$1"$2$4' );
			$content = preg_replace($pattern, $replacement, $content);
			return str_replace('%ID%', $post->ID, $content);
		}

		add_action('wp_footer', 'thickbox_image_paths');
		add_filter('the_content', 'tech_thickbox', 65 );
		add_action('wp_print_styles','tech_enque_thickbox');
	} // End if thickbox check
	
	if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ){
	        add_action( 'admin_notices', 'techozoic_show_notice' );  // Shows custom theme activation notice with links to option page and changelog
	}
	if ($tech['nav_menu_type'] == "Dropdown" || $tech['nav_menu_type'] == "WP 3 Menu"){	
		add_action('wp_print_styles','dropdown_js');
	}
	if ($tech['cufon_font'] == "Enable") {
		add_action('template_redirect', 'tech_cufon_script');  // Calls script to add Cufon font replacement scripts See - http://cufon.shoqolate.com/
		add_action('wp_head', 'tech_cufon_options');
	}
	add_action('admin_menu', 'create_meta_box');  // Creates custom meta box for disabling sidebar on page by page basis
	add_action('save_post', 'save_postdata');  // Saves meta box data to postmeta table
	add_filter('query_vars', 'add_new_var_to_wp'); //ADD css query variable for calling dynamic css
	add_action('template_redirect', 'techozoic_css_display'); //Outputs dynamic style.php and then exits to stop additional processing
	add_action('wp_head', 'tech_feed_link'); //Tests if WP 3.0 automatic_feed_link is available if not echos feed link to wp_head
	add_action('wp_head', 'first_run_options'); //Calls tech_init.php which sets up default options in database and creates folder to hold custom images
	add_action('admin_head', 'first_run_options'); //Same as above but works for the admin side
	add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets'); //Add Techozoic dashboard widget with info for theme and donate button
?>