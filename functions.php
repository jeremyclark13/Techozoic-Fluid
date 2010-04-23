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
		include_once (TEMPLATEPATH . "/options/option-array.php");
		include_once(TEMPLATEPATH . '/options/main.php');
	}
	
	global $tech;
	$tech = get_option('techozoic_options');
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$version = $theme_data['Version'];
	
	if(function_exists('register_sidebar')){
	if (isset($tech['column'])){
		if($tech['column'] > 1) {register_sidebar(array('name'=>__('Right Sidebar','techozoic')));}
		if($tech['column'] == 3) {register_sidebar(array('name'=>__('Left Sidebar','techozoic')));}
	} else {
		register_sidebar(array('name'=>__('Right Sidebar','techozoic')));
		register_sidebar(array('name'=>__('Left Sidebar','techozoic')));

	}// End check if tech column set
	
	register_sidebar(array(
		'name'=>__('Footer - Limit 3 Widgets','techozoic'),
		'before_widget' => '<div class="footercont"><ul><li>',
		'after_widget' => '</li></ul></div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	
	class Techozoic_Nav_Widget extends WP_Widget {

		function Techozoic_Nav_Widget() {
			$widget_ops = array('classname' => 'techozoic_nav', 'description' => __( 'Techozoic Sidebar Navigation Menu - option to add categories to navigation' , 'techozoic') );
			$this->WP_Widget('techozoic_nav', __('Techozoic Navigation' , 'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			global $tech;
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Navigation'  , 'techozoic') : $instance['title']);
			$c = $instance['cats'] ? '1' : '0';
			$p = $instance['pages'] ? '1' : '0';
			$s = $instance['separate'] ? '1' : '0';
			echo $before_widget;
			global $post;
			if ( $title)
			echo $before_title . $title . $after_title
?>			<ul id="sidenav">
<?php			if ($s) { 
				echo '<li class="navhead"><h3>'. __('Pages' ,'techozoic').'</h3></li>';
 			} 
			if ($p) { 
				$home_link = get_option('show_on_front');
				if ($home_link == "posts") {?>
					<li class="<?php if (is_home()) echo'current_page_item' ?>"><a href="<?php bloginfo('url'); ?>" title="<?php _e('Home' ,'techozoic')?>"><?php _e('Home' ,'techozoic')?></a></li>
<?php					} else {};
					if (!$tech['nav_exclude_list']){
						wp_list_pages('title_li=');
					} else {
						$nav_exclude = $tech['nav_exclude_list'];
						wp_list_pages("exclude=".$nav_exclude."&title_li=");
					}
				}
			if ($s) { 
?>				<li class="navhead"><h3><?php _e('Categories' ,'techozoic') ?></h3></li>
<?php				} 
			if ($c) { 
				wp_list_categories('title_li='); 
				}
?>			</ul>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'cats' => 0, 'pages' => 0,'separate' => 0, 'title' => '') );
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cats'] = $new_instance['cats'] ? 1 : 0;
			$instance['pages'] = $new_instance['pages'] ? 1 : 0;
			$instance['separate'] = $new_instance['separate'] ? 1 : 0;

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('cats' => 0, 'pages' => 1,'separate' => 0, 'title' => '') );
			$title = esc_attr( $instance['title'] );
			$cats = $instance['cats'] ? 'checked="checked"' : '';
			$pages = $instance['pages'] ? 'checked="checked"' : '';
			$separate = $instance['separate'] ? 'checked="checked"' : '';
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
			<p>
			<p>
			<input class="checkbox" type="checkbox" <?php echo $pages; ?> id="<?php echo $this->get_field_id('pages'); ?>" name="<?php echo $this->get_field_name('pages'); ?>" /> <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Include Pages in Menu' ,'techozoic')?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $cats; ?> id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" /> <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Include Categories in Menu' ,'techozoic') ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $separate; ?> id="<?php echo $this->get_field_id('separate'); ?>" name="<?php echo $this->get_field_name('separate'); ?>" /> <label for="<?php echo $this->get_field_id('separate'); ?>"><?php _e('Separate Pages and Categories' ,'techozoic')?></label>
			</p>
<?php
		}
	} //End Class Techozoic_Nav_Widget

	class Techozoic_About_Widget extends WP_Widget {

		function Techozoic_About_Widget() {
			$widget_ops = array('classname' => 'techozoic_about', 'description' => __( 'Author information Widget - Enter short blurb about yourself' ,'techozoic') );
			$this->WP_Widget('techozoic_about', __('Techozoic About' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('About Author' ,'techozoic') : $instance['title']);
			$gravatar = $instance['gravatar'] ? '1' : '0';
			$about = $instance['about'];
			if ( !$number = (int) $instance['number'] )
				$number = 50;
			else if ( $number < 25 )
				$number = 25;
			else if ( $number > 100 )
				$number = 100;

			echo $before_widget;
			global $post;
			if ( $title)
			echo $before_title . $title . $after_title;
?>			<span class="alignleft">
<?php			if ($gravatar) { 
				$email = get_bloginfo(admin_email); 
				echo get_avatar( $email, $number ); 
			}
?>			</span><p>
<?php			echo $about;
?>			</p><div style="clear:both"></div>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'about' => '', 'gravatar' => 0, 'title' => '') );
			$instance['about'] = $new_instance['about'];
			$instance['gravatar'] = $new_instance['gravatar'] ? 1 : 0;
			$instance['number'] = (int) $new_instance['number'];
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('about' => '', 'gravatar' => 0) );
			$title = esc_attr( $instance['title'] );
			$about = $instance['about'] ;
			$gravatar = $instance['gravatar'] ? 'checked="checked"' : '';
			$number = isset($instance['number']) ? absint($instance['number']) : 50;
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
			<p>
			<p><label><?php _e('Write About yourself here' ,'techozoic')?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('about'); ?>" name="<?php echo $this->get_field_name('about'); ?>"><?php echo $about; ?></textarea>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $gravatar; ?> id="<?php echo $this->get_field_id('gravatar'); ?>" name="<?php echo $this->get_field_name('gravatar'); ?>" /> <label for="<?php echo $this->get_field_id('gravatar'); ?>"><?php _e('Enable Gravatar' ,'techozoic') ?></label>
			</p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Size of Gravatar' ,'techozoic') ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
			<small><?php _e('Between 25 and 100 Pixels' ,'techozoic') ?></small></p>

<?php
		}
	} //End Class Techozoic_About_Widget

		class Techozoic_Meta_Widget extends WP_Widget {

		function Techozoic_Meta_Widget() {
			$widget_ops = array('classname' => 'techozoic_meta', 'description' => __( 'Meta Information as well as Dashboard and Log In/Out Links' ,'techozoic') );
			$this->WP_Widget('techozoic_meta', __('Techozoic Meta' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? "" : $instance['title']);
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
			else { 
 				echo $before_title . __('Meta','techozoic') . $after_title;		
			}
?>
			<ul><?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional' ,'techozoic') ?>"><?php _e('Valid XHTML' ,'techozoic') ?></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.' ,'techozoic') ?>">WordPress</a></li>
<?php 			wp_meta(); 
?>
			</ul>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '') );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<?php
		}
	} //End Class Techozoic_Meta_Widget

		class Techozoic_RSS_Widget extends WP_Widget {

		function Techozoic_RSS_Widget() {
			$widget_ops = array('classname' => 'techozoic_rss', 'description' => __( 'Link to RSS feed for blog as well as comment RSS feed' ,'techozoic') );
			$this->WP_Widget('techozoic_rss', __('Techozoic RSS' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? "" : $instance['title']);
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
			else { 
				echo $before_title . __('Syndicate','techozoic') . $after_title;	
			}
?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url'); ?>">RSS 2.0</a></li>
<?php 		if (is_home() ) { ?>	
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS 2.0 (<?php _e('Comments' ,'techozoic') ?>)</a></li>
<?php 			}
?>			</ul>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '') );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<?php
		}
	} //End Class Techozoic_RSS_Widget
	
		//Register Widgets for Sidebars
		register_widget('Techozoic_Nav_Widget');
		register_widget('Techozoic_About_Widget');
		register_widget('Techozoic_Meta_Widget');
		register_widget('Techozoic_RSS_Widget');
	} //End if(function_exists('register_sidebar'))
	
	// Techozoic Custom Functions

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
	Techozoic Cufon Font Replacment
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
	Techozoic Cufon Font Replacment
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
	if(function_exists('add_theme_support'))
		add_theme_support( 'post-thumbnails' );
		//WP 2.9 Post Thumbnail Support

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
			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('l, F jS Y') ?> at <?php comment_time() ?></a>&nbsp;|&nbsp;<?php edit_comment_link(__('Edit' ,'techozoic'),'',''); delete_comment_link(get_comment_ID())?></small>

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

function first_run_options() {
	global $version;
  	$check = get_option('techozoic_activation_check');
  	if ($check != $version) {
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
	if ($tech['nav_menu_type'] == "Dropdown"){	
		add_action('wp_print_styles','dropdown_js');
	}
	if ($tech['cufon_font'] == "Enable") {
		add_action('template_redirect', 'tech_cufon_script');  // Calls script to add Cufon font replacement scripts See - http://cufon.shoqolate.com/
		add_action('wp_head', 'tech_cufon_options');
	}
	add_action('admin_menu', 'create_meta_box');  // Creates custom meta box for disabling sidebar on page by page basis
	add_action('save_post', 'save_postdata');  // Saves meta box data to postmeta table
	add_filter('query_vars', 'add_new_var_to_wp');
	add_action('template_redirect', 'techozoic_css_display');
	add_action('wp_head', 'first_run_options');
	add_action('admin_head', 'first_run_options');
	add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
?>
