<?php
	load_theme_textdomain( 'techozoic', TEMPLATEPATH.'/languages');
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
		if (isset($_GET['page'])) {
			if ( $_GET['page'] == "techozoic_main_admin"  || $_GET['page'] == "techozoic_header_admin" || $_GET['page'] == "techozoic_style_admin" || $_GET['page'] == "techozoic_export_admin" ){
				$dir = TEMPLATEPATH . "/uploads";
				if (!is_writable($dir)) {
					function techozoic_error_message() {
						$dir = TEMPLATEPATH . "/uploads";
						$message = "<div class=\"updated fade\">". __("Please make sure <strong>${dir}</strong> exists and is writable.",'techozoic'). "</div>";
						echo $message;
					}	
					add_action( 'admin_notices','techozoic_error_message'); 
				}
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

	if (!isset($content_width)) {
		$content_width = tech_content_width();
	}

/**************************************
	Techozoic Navigation Selection Function
	Since 1.8.8
***************************************/		
	
function tech_nav_select(){
	global $tech;
	switch ($tech['nav_menu_type']){
		case "Two Tier":
			$var = "twotier";
			break;
		case "Standard":
			$var = "standard";
			break;
		case "Dropdown":
			$var = "dropdown";
			break;
		case "WP 3 Menu":
			$var = "wp3";
			break;
		}
	return $var;
}
	
/**************************************
	Techozoic $content_width Function
	Since 1.8.8
***************************************/	
function tech_content_width(){
	global $tech;
	$p_width = $tech['page_width'];
	$c_width = $tech['main_column_width'];
	$page = $tech['page_type'];
	if ($page = "Fixed Width" && $p_width != 0 && $c_width != 0) {
		$c_width = $c_width /100;
		$output = $p_width * $c_width;
	} else {
		$output = 400;
	}
	return $output;
}	
	
/**************************************
	Techozoic Footer Text Function
	Since 1.8.8
***************************************/	
function tech_footer_text(){
	global $tech, $version;
	$string = $tech['footer_text'];
	$shortcode = array('/%BLOGNAME%/i','/%THEMENAME%/i','/%THEMEVER%/i','/%THEMEAUTHOR%/i','/%TOP%/i','/%COPYRIGHT%/i');
	$output = array(get_bloginfo('name'),"Techozoic",$version,'<a href="http://clark-technet.com/"> Jeremy Clark</a>','<a href="#top">'. __('Top' ,'techozoic') .'</a>','&copy '. date('Y'));
	echo preg_replace($shortcode, $output, $string);
}

	
/**************************************
	Techozoic Sidebar Display Function
	Since 1.8.8
***************************************/
function tech_show_sidebar($loc) {
	global $tech;
	switch ($tech['sidebar_pos']) {
		case "Sidebar - Content - Sidebar":
			$left = 1;
			$right = 1;
		break;
		case "Content - Sidebar - Sidebar":
			$left = 0;
			$right = 2;
		break;
		case "Sidebar - Sidebar - Content":
			$left = 2;
			$right = 0;
		break;
		case "Content - Sidebar":
			$left = 0;
			$right = 1;
		break;
		case "Sidebar - Content":
			$left = 1;
			$right = 0;
		break;
	}
	if ($loc == "l" && $left > 0){
		if (function_exists('get_template_part')) {
			get_template_part('sidebar','left');
		} else {
			include (TEMPLATEPATH . "/sidebar-left.php"); 
		}
		if ($left > 1){
			get_sidebar();
		}
	}
	if ($loc == "r" && $right > 0){
		get_sidebar();
		if ($right > 1){
			if (function_exists('get_template_part')) {
				get_template_part('sidebar','left');
			} else {
				include (TEMPLATEPATH . "/sidebar-left.php"); 
			}
		}
	}
}	
	
	
	
/**************************************
	Techozoic Automatic Feed Link Checking
	Since 1.8.8
***************************************/	
function tech_feed_link(){
	global $wp_version;
	$output = "";
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
	if (function_exists('home_url')) {
		$short_link = home_url()."/?p=".$post->ID;
	} else {
		$short_link = get_bloginfo('url')."/?p=".$post->ID;
	}
	$home_icons = explode(',' , $tech['home_social_icons']);
	$single_icons = explode(',' , $tech['single_social_icons']);
	$image = get_bloginfo('template_directory')."/images/icons";
	$link = get_permalink();
	$title = $post->post_title;
	$url_title = urlencode($post->post_title);
	$social_links = array(
		"Delicious" => "<a href=\"http://delicious.com/post?url={$link}&amp;title={$url_title}\" title=\"". __('del.icio.us this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/delicious_16.png\" alt=\"Delicious This\" /></a>",
		"Digg" => "<a href=\"http://digg.com/submit?phase=2&amp;url={$link}&amp;title={$url_title} \" title=\"". __('Digg this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/digg_16.png\" alt=\"Digg This\"/></a>",
		"Facebook" => "<a href=\"http://www.facebook.com/share.php?u={$link}&amp;t={$url_title}\" title=\"". __('Share on Facebook!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/facebook_16.png\" alt=\"Share on Facebook\"/></a>",
		"MySpace" => "<a href=\"http://www.myspace.com/Modules/PostTo/Pages/?u={$link}&amp;t={$url_title}\" title=\"". __('Share on Myspace!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/myspace_16.png\" alt=\"Share on Myspace\"/></a>",
		"StumbleUpon" => "<a href=\"http://www.stumbleupon.com/submit?url={$link}&amp;title={$url_title}\" title=\"". __('Stumble Upon this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/stumbleupon_16.png\" alt=\"Stumble Upon This\"/></a>",
		"Twitter" => "<a href=\"http://twitter.com/home?status=Reading%20{$url_title}%20on%20{$short_link}\" title=\"". __('Tweet this!','techozoic')."\" target=\"_blank\"><img src=\"{$image}/twitter_16.png\" alt=\"Tweet This\"/></a>",
		"RSS Icon" => "<a href=\"".get_post_comments_feed_link()."\" title=\"".__('Subscribe to Feed','techozoic')."\"><img src=\"{$image}/rss_16.png\" alt=\"".__('RSS 2.0','techozoic')."\"/></a>");
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
	$output = "";
	$comment_array = get_comments(array('post_id'=>$ID,'number'=>$num,'type'=>'comment','status'=>'approve'));
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
	$list ="";
	$head = "";
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

$meta_box = array(
    'id' => 'tech-meta-box',
    'title' => 'Techozoic Options',
    'context' => 'side',
    'priority' => 'low',
    'fields' => array(
        array(
            'name' => 'Sidebar',
            'id' => 'Sidebar_value',
            'type' => 'checkbox',
			'title' => 'Disable Sidebar',
			'description' => 'Checking the box will disable the sidebar showing on this post/page single view.'
        ),
		array(
            'name' => 'Nav',
            'id' => 'Nav_value',
            'type' => 'checkbox',
			'title' => 'Disable Navigation Menu',
			'description' => 'Checking the box will disable the navigation menu on this post/page single view.'
        )
    )
);
	

function tech_new_meta_boxes() {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="techozoic_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th><label for="', $field['id'], '">', $field['title'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '
', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '
', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo	'<td>',
				'<tr><td colspan="3">',$field['description'],'</td></tr>',
				'</tr>';
    }
    
    echo '</table>';

}
 
function tech_create_meta_box() {
	global $meta_box;
	add_meta_box($meta_box['id'], $meta_box['title'], 'tech_new_meta_boxes', 'post', $meta_box['context'], $meta_box['priority']);
	add_meta_box($meta_box['id'], $meta_box['title'], 'tech_new_meta_boxes', 'page', $meta_box['context'], $meta_box['priority']);
}

function tech_save_postdata( $post_id ) {
    global $meta_box;
    
    // verify nonce
	if (isset($_POST['techozoic_meta_box_nonce'])){
		if (!wp_verify_nonce($_POST['techozoic_meta_box_nonce'], basename(__FILE__))) {
		   return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		foreach ($meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
/**************************************
	Techozoic Custom Meta Box
	END
***************************************/

function tech_new_var($public_query_vars) {
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
	add_theme_support('menus');
	//WP 3.0 Menus	
	add_theme_support('automatic-feed-links');
	//WP Auto Feed Links
}
if(function_exists('register_nav_menus')) {
	register_nav_menus( array(
		'primary' => __( 'Header Navigation', 'techozoic' ),
		'sidebar' => __( 'Sidebar Navigation', 'techozoic'),
	) );
}
function techozoic_enqueue() {
	wp_enqueue_script('tech_thickbox', get_bloginfo('wpurl') . '/wp-content/themes/techozoic-fluid/js/thickbox.js',array('jquery'),'3.0' );
}

function tech_dashboard_widgets() {
   	global $wp_meta_boxes;
   	wp_add_dashboard_widget('techozoic_dashboard_widget', 'Techozoic Theme Setup', 'techozoic_dashboard_widget');
}

function techozoic_dashboard_widget() { ?>
   	<p><?php _e('Thank you for using the Techozoic Theme.  ' ,'techozoic'); 
		if (current_user_can('install_themes')) { 
			printf(__('Visit the %s to start customizing Techozoic.  ' ,'techozoic'),'<a href="admin.php?page=techozoic_main_admin" title="' . __("options page" ,"techozoic").'">'.__("options page" ,"techozoic").'</a>'); 
			} 
		printf(__('If your having problems or would like to suggest a new feature, please visit the %s.' ,'techozoic'), '<a href="http://clark-technet.com/theme-support/techozoic/" title="' .__('Support Forum' ,'techozoic').'"> '.__('support forum' ,'techozoic').'</a>')?>
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

function tech_first_run_options() {
	global $version;
	$header_folder = TEMPLATEPATH. "/uploads/images/headers";
	$background_folder = TEMPLATEPATH. "/uploads/images/backgrounds";
  	$check = get_option('techozoic_activation_check');
  	if ($check != $version || !file_exists($header_folder) || !file_exists($background_folder)) {
		include(TEMPLATEPATH . '/options/tech-init.php');
		tech_update_options();
		tech_create_folders();
    		// Add marker so it doesn't run in future
  		add_option('techozoic_activation_check', $version);
		update_option('techozoic_activation_check', $version);
  	}
}//End first_run_options

function tech_dropdown_js(){
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
	if (isset($link)) return $link;
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
		if (function_exists('home_url')) {
			$home = home_url();
		} else {
			$home = get_bloginfo('url');
		}
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

function tech_thickbox_image_paths() {
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

if ($tech['thickbox'] =="On"){
	add_action('wp_footer', 'tech_thickbox_image_paths');
	add_filter('the_content', 'tech_thickbox', 65 );
	add_action('wp_print_styles','tech_enque_thickbox');
} // End if thickbox check
	
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ){
        add_action( 'admin_notices', 'techozoic_show_notice' );  // Shows custom theme activation notice with links to option page and changelog
}
if ($tech['nav_menu_type'] == "Dropdown" || $tech['nav_menu_type'] == "WP 3 Menu"){	
	add_action('wp_print_styles','tech_dropdown_js');
}
if ($tech['cufon_font'] == "Enable") {
	add_action('template_redirect', 'tech_cufon_script');  // Calls script to add Cufon font replacement scripts See - http://cufon.shoqolate.com/
	add_action('wp_head', 'tech_cufon_options');
}

add_action('tech_footer', 'tech_footer_text'); 	// Adds custom footer text defined on option page to footer.
add_action('admin_menu', 'tech_create_meta_box');  	// Creates custom meta box for disabling sidebar on page by page basis
add_action('save_post', 'tech_save_postdata');  // Saves meta box data to postmeta table
add_filter('query_vars', 'tech_new_var'); //ADD css query variable for calling dynamic css
add_action('template_redirect', 'techozoic_css_display'); //Outputs dynamic style.php and then exits to stop additional processing
add_action('wp_head', 'tech_feed_link'); //Tests if WP 3.0 automatic_feed_link is available if not echos feed link to wp_head
add_action('wp_head', 'tech_first_run_options'); //Calls tech_init.php which sets up default options in database and creates folder to hold custom images
add_action('admin_head', 'tech_first_run_options'); //Same as above but works for the admin side
add_action('wp_dashboard_setup', 'tech_dashboard_widgets'); //Add Techozoic dashboard widget with info for theme and donate button
?>