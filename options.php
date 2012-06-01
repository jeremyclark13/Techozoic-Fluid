<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
        if (function_exists('wp_get_theme')){
            $themename = wp_get_theme('techozoic-fluid');
            $themename = $themename->Name;
        } else {
            $themename = get_theme_data(STYLESHEETPATH . '/style.css');
            $themename = $themename['Name'];
        } 
	
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}
/**
 * Addes contextual help to the theme options page.
 */

function admin_screen_help () {
    $screen = get_current_screen();
    $screen->add_help_tab(array(
        'id'        => 'of_options_page_help',
        'title'     =>  __( 'Techozoic Support', 'techozoic' ),
        'content'   => '<p><strong>' . sprintf(__( 'Looking for assistance? Please visit the <a href="%1$s">support forums</a>, refer to the <a href="%2$s">documentation</a>, or the <a href="%3$s">FAQ</a>.' ),'http://clark-technet.com/theme-support/techozoic','http://techozoic.clark-technet.com/documentation/','http://techozoic.clark-technet.com/documentation/faq/') . '</strong></p>'
        ));
} 

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
        $social_media = array('delicious'=>"Delicious",'digg'=>"Digg",'email'=>"Email",'facebook'=>"Facebook",'google' =>"Google +1",'pintrest' =>'Pintrest', 'linkedin'=>"LinkedIn",'myspace'=>"MySpace",'newsvine'=>"NewsVine",'stumbleupon'=>"StumbleUpon",'twitter'=>"Twitter",'reddit'=>"Reddit",'rss'=>"RSS Icon");
        $old_social_media = array("Delicious"=>'delicious',"Digg" =>'digg',"Email"=>'email',"Facebook"=>'facebook',"LinkedIn" => 'linkedin',"MySpace" =>'myspace',"NewsVine"=>'newsvine',"StumbleUpon" =>'stumbleupon',"Twitter"=>'twitter',"Reddit"=>'reddit',"RSS Icon"=>'rss');

	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	//$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
        if ( class_exists( 'bbPress' ) ) { 
            $options_pages['forum'] = 'All bbPress Forum Pages';
        }
	$twitter_feed = tech_twitter_info($user = 'clarktechnet', $count = '5', $type = 'feed');
        $twitter_followers = tech_twitter_info($user = 'clarktechnet', $count = '0', $type = 'followers');
        $news_feed = techozoic_links_box();
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
		
	$options = array();
        
       $options[] = array( "name"=>__('About','techozoic'),
                "type"=> "heading");
       
       $options[] = array( "name" => __('Donate to help further development','techozoic'),
                "type" => "info",
        	"desc" => "<a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2M9KFK4JHR6LW' title='Donate Securely' target='_blank' ><img src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif' /></a>");

        $options[] = array( "name" => __('Twitter','techozoic') . " - " . $twitter_followers,
                "type" => "info",
        	"desc" => "<a href='https://twitter.com/#!/search/realtime/techozoic%20from%3Aclarktechnet' title='Follow Development on Twitter' target='_blank'>Follow Development on Twitter</a> | <a href='https://twitter.com/intent/user?screen_name=clarktechnet' title='Follow Me on Twitter' target='_blank'>Follow Me on Twitter</a>");
    
        $options[] = array( 
                "type" => "info",
        	"desc" => "<strong>" . __('Twitter Feed','techozoic') . "</strong>" . $twitter_feed );
        
        $options[] = array( "name" => __('Techozoic News','techozoic'),
                "type" => "info",
        	"desc" => $news_feed );
    
        $options[] = array("name" => __('Changelog - Version 2.0.8', 'techozoic'),
                "type" => "info",  
                "desc" =>'IE dropdown menu bug fixed.<br />Added option to minify dynamic css.<br />Fixed virus warning for Chrome users.');
        
       $options[] = array("name" => __('Changelog - Version 2.0.6', 'techozoic'),
                "type" => "info",  
                "desc" =>'bbPress support added. (Version 2.0.2)<br />Register sidebars for bbPress pages option.<br />Pintrest Pin it button added.<br />Search bar moved into navigation menu<br />3.4 custom headers added<br /> Bug Fix - Typography size wasn\'t saving correctly due to issue with options framework now fixed.<br /> Bug Fix - Footer editor box rolled back to standard textarea, until framework supports it.<br />');
          
       $options[] = array("name" => __('Changelog - Version 2.0.5', 'techozoic'),
                "type" => "info",  
                "desc" =>'Emergency Bug Fix - Typography options not saving correctly due to issue with options framework now fixed.');
                 
       $options[] = array("name" => __('Changelog - Version 2.0.4', 'techozoic'),
                "type" => "info",  
                "desc" =>'Added two new navigation styles, Ribbon and Square. <br /> Added more color choices for navigation menus. <br /> Added ability to specify two Google Web fonts. <br /> New post author block on single post screens, if user bio is filled out on profile page it is displayed along with gravatar. <br />Romanian Translation Added, Web Geek Science  (<a href="http://webhostinggeeks.com/">Web Hosting Geeks</a>)<br />');
       
       $options[] = array("name" => __('Changelog - Version 2.0.3', 'techozoic'),
                "type" => "info",  
                "desc" =>'Updated Social Media icons to GPL licensed - Elegant Media Icons. <br />Cleaned out old unused images and files.<br />');
       
       
        $options[] = array(	"name" => __('Layout','techozoic'),
                "type" => "heading");

        $options[] = array(	"name" => __('Column Layout','techozoic'),
                "id" => "sidebar_pos",
                "type" => "images",
                "std" => "3-col",
                "old_options" => array("Sidebar - Content - Sidebar" => "3-col", "Content - Sidebar - Sidebar" => "3-col-right","Sidebar - Sidebar - Content" => "3-col-left","Content - Sidebar" => "2-col_right", "Sidebar - Content" => "2-col-left","No Sidebars" => "1-col"),
                "options" => array("3-col" => $imagepath . '3-col.jpg', "3-col-right" => $imagepath . '3-col-right.jpg', "3-col-left" => $imagepath . '3-col-left.jpg',"2-col-right" => $imagepath . '2-col-right.jpg', "2-col-left" => $imagepath . '2-col-left.jpg',"1-col" => $imagepath . '1-col.jpg'));

        $options[] = array(	"name" => __('Fixed or Fluid Width','techozoic'),
                "id" => "page_type",
                "std" => "fluid",
                "type" => "select",
                "class" => "mini",
                "old_options" => array("Fixed Width" => "fixed", "Fluid Width"=> "fluid"),
                "options" => array('fixed' => __('Fixed Width','techozoic'), 'fluid' => __('Fluid Width','techozoic')));

        $options[] = array(	"name" => __('Page Width','techozoic'),
                "desc"=> __('Fluid Width - Percentage of Total Screen Size  <br />Fixed Width - Width in number of pixels','techozoic'),
                "id" => "page_width",
                "std" => "90",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __('Main Column Width','techozoic'),
                "desc"=> __('(Post Content) - Percentage of Page Width','techozoic'),
                "id" => "main_column_width",
                "std" => "50",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __('Left Sidebar Width','techozoic'),
                "desc"=> __('Percentage of Page Width','techozoic'),
                "id" => "l_sidebar_width",
                "std" => "25",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __('Right Sidebar Width','techozoic'),
                "desc"=> __('Percentage of Page Width','techozoic'),
                "id" => "r_sidebar_width",
                "std" => "25",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __('Fav Icon Image','techozoic'),
                "desc" => __('Fav Icon must be an .ico file.  Browse for a new image or chose previously uploaded image.  After choosing press Save to upload.','techozoic'),
                "id" => "favicon_image",
                "type" => "upload");

        $options[] = array(  "name" => __('Display Sidebars on Blog Home Page','techozoic'),
                "id" => "home_sidebar",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(  "name" => __('Display Sidebars on Single Post Pages','techozoic'),
                "id" => "single_sidebar",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "0");
if ( class_exists( 'bbPress' ) ) {        
        $options[] = array(  "name" => __('Display Sidebars on Forum','techozoic'),
                "id" => "forum_sidebar",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "0");        
}
        $options[] = array(  "name" => __('Page Specific Sidebars','techozoic'),
                "desc" => __('Choose which pages to register a sidebar.  After selecting pages, two new sidebars will be avaialbe from the widgets screen.  These sidebars will be used if any widgets are added, otherwise the default sidebars will be used.','techozoic'),
                "id" => "page_sidebar",
                "type" => "multicheck",
                "std" => '',
                "options" => $options_pages);        
        
        $options[] = array(  "name" => __('SEO Features','techozoic'),
                "desc" => __('Disable this if any SEO plugins are used','techozoic'),
                "id" => "seo",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "1");

        $options[] = array(  "name" => __('Thickbox on Images','techozoic'),
                "desc" => __('Use Thickbox to automatically overlay images on pages</small>','techozoic'),
                "id" => "thickbox",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "0");
    
        $options[] = array( 	"name" => __('Comment Preview','techozoic'),
                "desc" => __('Enable the comment preview for posts on the home page.','techozoic'),
                "id" => "comment_preview",
                "type" => "checkbox",
                "old_options" => array("Enable" => "1", "Disable" => "0"),
                "std" => "1");
    
       $options[] = array(	"name" => __('Comment Preview Number','techozoic'),
                "desc" => __('Number of comments to display in comment preview area.' ,'techozoic'),
                "id" => "comment_preview_num",
                "type" => "text",
                "old_options" => '',
                "class" => "mini",
                "std" => "3");

        $options[] = array(	"name" => __('Custom Footer Text','techozoic'),
                "desc" => __('Text displayed in footer - HTML allowed. <br />Shortcodes that can be used: <br />%BLOGNAME% -> The blog\'s title. <br />%THEMENAME% -> Theme name.<br /> %THEMEVER% -> Current Theme Version.<br /> %THEMEAUTHOR% -> Link to Theme Author\'s website.*<br />%TOP% -> Link to the Top of the page.<br /> %COPYRIGHT% -> Insert copyright info for current year.<br /> %MYSQL% -> MySQL queries and processing time info<br /><br />*It is completely optional, but if you like Techozoic I would appreciate it if you keep the credit link.','techozoic'),
                "id" => "footer_text",
                "old_options" => '',
                "std" => "%COPYRIGHT% %BLOGNAME% | %THEMENAME% %THEMEVER% by %THEMEAUTHOR%. | %TOP% <br /> <small>%MYSQL%</small>",
                "type" => "textarea");

        $options[] = array("name" => __('Drop Shadow Boxes','techozoic'),
                "desc" => __('Check the areas where the Drop Shadow Boxes shouldn\'t be used<br /> - note only visible in Firefox, Chrome, Safari.','techozoic'),
                "id" => "drop_shadow",
                "std" => "",
                "type" => "multicheck",
                "old_options" => array("Header Text" => "header", "Post Boxes" => "post", "Images" =>"image"),
                "options" => array('header' => __('Header Text','techozoic'), 'post' => __('Post Boxes','techozoic'), 'image' => __('Images','techozoic'), 'page' =>__('Main Page','techozoic')));
        
        $options[] = array(	"name" => __('Page Background Image','techozoic'),
                "desc" => __('Use a tiled image for best results.','techozoic'),
                "id" => "bg_image",
                "std" => array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'),
                "type" => "background");

        $options[] = array(	"name" => __('Content Background Image','techozoic'),
                "desc"=> __('Use a tiled image for best results.','techozoic'),
                "id" => "content_bg_image",
                "std" => array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'),
                "type" => "background");
        
        $options[] = array( 	"name" => __('Posts','techozoic'),
                "type" => "heading");

        $options[] = array("name" => __('Excerpt Location','techozoic'),
                "desc" => __('Check where excerpts should be used instead of full post content.  If an area isn\'t checked then the full post is displayed.','techozoic'),
                "id" => "excerpt_location",
                "old_id" => "unused before 1.9.3",
                "std" => array("tag" => '1'),
                "type" => "multicheck",
                "old_options" => array("Main Page" => "main", "Category Archive" => "cat", "Yearly Archive" => "year", "Monthly Archive" => "month", "Tag Archive" => "tag"),
                "options" => array('main' => __('Main Page' ,'techozoic') ,'cat' => __('Category Archive','techozoic') , 'year' => __('Yearly Archive' ,'techozoic'), 'month' => __('Monthly Archive','techozoic'), 'tag' => __('Tag Archive','techozoic')));

        $options[] = array( "name" => __('Background Color','techozoic'),
                "desc" => __('Check where background color for posts defined on the color tab should be applied.','techozoic'),
                "id" => "post_background_location",
                "std" => array("main" =>"1",'archive'=>'1'),
                "type" => "multicheck",
                "old_options" => array("Main Page" => "main", "Single Post" => "single", "Archive Pages" => "archive"),
                "options" => array('main' => __('Main Page','techozoic') , 'single' => __('Single Post','techozoic') , 'archive'=> __('Archive Pages','techozoic') ));

        $options[] = array( "name" => __('Social Media Icons','techozoic'),
                "desc" => __('Check where Social Media Icons will be displayed.','techozoic'),
                "id" => "post_social_media_location",
                "std" => array("main" =>"1",'single'=>'1'),
                "type" => "multicheck",
                "old_options" => array("Main Page" => "main", "Category Archive" => "cat", "Yearly Archive" => "year", "Monthly Archive" => "month", "Tag Archive" => "tag"),
                "options" => array('main' => __('Main Page','techozoic') , 'single' => __('Single Post','techozoic') , 'archive'=> __('Category Archive','techozoic') , 'year' => __('Yearly Archive','techozoic') , 'month' => __('Monthly Archive','techozoic') , 'tag' => __('Tag Archive','techozoic')));

        $options[] = array( "name" => __('Nav','techozoic'),
                "type" => "heading");

        $options[] = array(	"name" => __('Navigation Menu','techozoic'),
                "desc" => __('Enable navigation menu.  If disabled visit the <a href=\"widgets.php\">widgets</a> page to add  the Techozoic Sidebar Navigation widget','techozoic'),
                "id" => "nav_menu",
                "type" => "checkbox",
                "std" => "1");
        
        $options[] = array(	"name" => __('Navigation Menu Location','techozoic'),
                "id" => "nav_location",
                "type" => "radio",
                "class" => "hidden",
                "std" => "below",
                "options" => array('below'=> __('Below Header','techozoic') ,'above'=> __('Above Header','techozoic') ));

       $options[] = array(	"name" => __('Navigation Menu Type','techozoic'),
                "id" => "nav_type",
                "type" => "radio",
                "class" => "hidden",
                "std" => "standard",
                "options" => array('standard'=> __('Tabs','techozoic') ,'ribbon'=> __('Ribbon - Can only be left aligned','techozoic') , 'square' => __('Square - Can only be left aligned','techozoic')));
        
        $options[] = array(	"name" => __('Log In/Out Links','techozoic'),
                "desc" => __('Enable Dashboard and Log in/out links.','techozoic'),
                "id" => "dashboard_link",
                "class" => "hidden",
                "type" => "checkbox",
                "old_options" => array("On" => "1","Off" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __('Breadcrumbs','techozoic'),
                "desc" => __('Enable Breadcrumb navigation.  Useful with Sidebar Nav Widget.','techozoic'),
                "id" => "breadcrumbs",
                "class" => "hidden",
                "type" => "checkbox",
                "old_options" => array("On" => "1","Off" => "0"),
                "std" => "0");

        $options[] = array(	"name" => __('Navigation Menu Alignment','techozoic'),
                "id" => "nav_align",
                "type" => "radio",
                "class" => "hidden",
                "std" => "left",
                "old_options" => array("Left" => "left","Center" => "center"),
                "options" => array('left'=> __('Left','techozoic') ,'center'=> __('Center','techozoic') ));

       $options[] = array(	"name" => __('Navigation Button Padding','techozoic'),
                "desc" => __('Margin between naviagation buttons in Pixels.','techozoic'),
                "id" => "nav_button_margin",
                "string" => "num",
                "std" => "3",
                "class" => "mini hidden",
                "type" => "text");
        
        $options[] = array(	"name" => __('Navigation Button Width','techozoic'),
                "desc" => __('Size of navigation button width in Pixels.  Set to <strong>0</strong> for variable sized buttons','techozoic'),
                "id" => "nav_button_width",
                "string" => "num",
                "std" => "0",
                "old_options" => '',
                "class" => "mini hidden",
                "type" => "text");
        
        $options[] = array(	"name" => __('Navigation Sub Menu Width','techozoic'),
                "desc" => __('Size of navigation sub menu width in Pixels.','techozoic'),
                "id" => "nav_menu_width",
                "string" => "num",
                "std" => "250",
                "class" => "mini hidden",
                "type" => "text");        
        
        $options[] = array( 	"name" => __('Font','techozoic'),
                "type" => "heading");

        $options[] = array("name" => __('Google Font Replacement','techozoic'),
                "desc" =>__('Enable this to use the Google Font API to add new fonts.','techozoic'),
                "id" => "google_font",
                "std" => "0",
                "old_options" => array("Enable" => "1","Disable" => "0"),
                "type" => "checkbox");

        $options[] = array("name" => __('Google Font 1','techozoic'),
                "desc" => __('Visit the <a href="http://code.google.com/webfonts" target="_blank">Google Fonts</a> site to pick the font to use.  After choosing on the font to use, copy the Name of the font here.  If font supports additional styling it can be added with a ":" .  Example: Droid Sans:bold,italic','techozoic'),
                "id" => "google_font_family",
                "class" => "hidden",
                "old_options" => '',
                "type" => "text");
        
        $options[] = array("name" => __('Google Font 2','techozoic'),
                "desc" => __('Visit the <a href="http://code.google.com/webfonts" target="_blank">Google Fonts</a> site to pick the font to use.  After choosing on the font to use, copy the Name of the font here.  If font supports additional styling it can be added with a ":" .  Example: Droid Sans:bold,italic','techozoic'),
                "id" => "google_font_family_2",
                "class" => "hidden",
                "type" => "text");       

        $options[] = array(	"name" => __('Default Text','techozoic'),
                "id" => "body_font",
                "std" => array('size'=>"12px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>  __('Main Heading Font','techozoic'),
                "id" => "main_heading_font",
                "std" => array('size'=>"30px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'),
                "type" => "typography");

        $options[] = array("name" => __('Post Heading Font','techozoic'),
                "id" => "post_heading",
                "std" => array('size'=>"20px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>__('Sidebar Heading Font','techozoic'),
                "id" => "side_heading_font",
                "std" => array('size'=>"16px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>__('Nav Menu Text Font','techozoic'),
                "id" => "nav_font",
                "std" => array('size'=>"14px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'),
                "type" => "typography");

        $options[] = array("name" => __('Post Text Font','techozoic'),
                "id" => "post_text_font",
                "std" => array('size'=>"12px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" => __('Metadata Font','techozoic'),
                "id" => "small_font",
                 "std" => array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#777777'),
                 "type" => "typography");

        $options[] = array(	"name" => __('Color','techozoic'),
                "type" => "heading");

        $options[] = array(	"name" => __('Prebuilt Color Scheme','techozoic'),
                "desc"=> __('After choosing color scheme, adjustments can be made below.  Choose custom to create your own.','techozoic'),
                "id" => "color_scheme",
                "type" => "select",
                "class" => "mini",
                "std" => "custom",
                "old_options" => array("Custom 1" => 'custom',"Custom 2" => 'custom', "Blue" => "blue", "Khaki" => "khaki", "Red" =>"red", "Grunge" =>"grunge"),
                "options" => array('custom' => __('Custom','techozoic'), 'blue'=> __('Blue','techozoic') , 'khaki'=>__('Khaki','techozoic'), 'red'=>__('Red','techozoic'), 'grunge'=>__('Grunge','techozoic')));
        
        $options[] = array(	"name" => __('Body Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_bg_color1",
                "old_options" => '',
                "std" => "#A0B3C2",
                 "type" => "color");

        $options[] = array("name" => __('Transparent','techozoic'),
                "desc" => __('Check to not apply any color to the body background.','techozoic'),
                "id" => "cust_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");

        $options[] = array(	"name" => __('Content Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_content_bg_color1",
                "std" => "#F7F7F7",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __('Transparent','techozoic'),
                "desc" => __('Check to not apply any color to the content background.','techozoic'),
                "id" => "cust_content_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");

        $options[] = array(	"name" => __('Accent Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_acc_color1",
                "std" => "#A0B3C2",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __('Link Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_link_color1",
                "std" => "#597EAA",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __('Link Hover Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_link_hov_color1",
                "std" => "#114477",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __('Visited Link Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_link_visit_color1",
                "std" => "#2C4353",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __('Nav Button Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_bg_color1",
                "std" => "#E3E3E3",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __('Transparent','techozoic'),
                "desc" => __('Check to not apply any color to the nav button background.','techozoic'),
                "id" => "cust_nav_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");
        
        $options[] = array(	"name" => __('Nav Button Hover Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_hov_bg_color1",
                "std" => "#EFEFEF",
                "type" => "color");
        
        $options[] = array(	"name" => __('Nav Button Hover Text Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_hov_text_color1",
                "std" => "#A0B3C2",
                "type" => "color");
        
        $options[] = array(	"name" => __('Nav Button Active Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_active_bg_color1",
                "std" => "#A0B3C2",
                "type" => "color");
        
        $options[] = array(	"name" => __('Nav Button Active Text Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_active_text_color1",
                "std" => "#F7F7F7",
                "type" => "color"); 
        
        $options[] = array(	"name" => __('Nav Bar Background Gradient Top','techozoic'),
                "desc" => __('Used when Navigation Menu Type is set to Ribbon or Square.  Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_bg_gradient_top",
                "std" => "#E3E3E3",
                "type" => "color"); 
        
        $options[] = array(	"name" => __('Nav Bar Background Gradient Bottom','techozoic'),
                "desc" => __('Used when Navigation Menu Type is set to Ribbon or Square.  Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_nav_bg_gradient_bot",
                "std" => "#CCCCCC",
                "type" => "color");        

        $options[] = array(	"name" => __('Post Background Color','techozoic'),
                "desc" => __('Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>','techozoic'),
                "id" => "cust_post_bg_color1",
                "std" => "#E3E3E3",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __('Transparent','techozoic'),
                "desc" => __('Check to not apply any color to the post background.','techozoic'),
                "id" => "cust_post_bg_trans1",
                "std" => "0",
                "old_options" => array("On" => '1'),
                "type" => "checkbox");
        
        $options[] = array(	"name" => __('Ads','techozoic'),
                "type" => "heading");

        $options[] = array(	 "name" => __('Home Page Ad Code','techozoic'),
                "desc"=>__('This Ad Code will be displayed a total of 3 times. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>','techozoic'),
                "id" => "ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array( 	"name" => __('Number of Posts Between Ad Units','techozoic'),
                "id" => "ad_int",
                "type" => "select",
                "class" => "mini",
                "std" => "3",
                "old_options" => array('6'=>"6",'5'=> "5",'4'=> "4",'3'=> "3",'2'=> "2",'1'=> "1"),
                "options" => array('6'=>"6",'5'=> "5",'4'=> "4",'3'=> "3",'2'=> "2",'1'=> "1"));

        $options[] = array(	"name" => __('Home Page Header Ad Code','techozoic'),
                "desc" => __('This Ad Code will be displayed on the home  page below the header and navigation. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>','techozoic'),
                "id" => "header_ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array(	"name" => __('Single Post Ad Code','techozoic'),
                "desc"=> __('This Ad Code will be displayed on the single post page. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>','techozoic'),
                "id" => "sing_ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array(	"name" => __('Single Post Ad Position','techozoic'),
                "desc" => __('Above or below the post content on single page','techozoic'),
                "id" => "sing_ad_pos",
                "type" => "radio",
                "std" => "above",
                "old_options" => array("Above" =>"above", "Below"=>"below"),
                "options" => array('above'=> __('Above','techozoic') ,'below'=> __('Below','techozoic') ));

        $options[] = array( 	"name" => __('Social','techozoic'),
                "type" => "heading");

        $options[] = array("name" => __('Home/Archive Page Social Network Icons','techozoic'),
                "desc" => __('Choose which social network icons you would like displayed below the post on the Home/Archive pages.','techozoic'),
                "id" => "home_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "old_options" => $old_social_media,
                "options" => $social_media);

        $options[] = array("name" => __('Single Page Social Media Icons','techozoic'),
                "desc" => __('Choose which social media icons you would like displayed on the single post page.','techozoic'),
                "id" => "single_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "old_options" => $old_social_media,
                "options" => $social_media);

        $options[] = array(	"name" => __('Facebook Profile','techozoic'),
                "desc"=> __('Used for the About widget Must be full link to profile page','techozoic'),
                "id" => "facebook_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");

        $options[] = array(	"name" => __('MySpace Profile','techozoic'),
                "desc" => __('Used for the About widget Must be full link to profile page','techozoic'),
                "id" => "myspace_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");

        $options[] = array(	"name" => __('Twitter Profile','techozoic'),
                "desc" => __('Used for the About widget Must be full link to profile page','techozoic'),
                "id" => "twitter_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");
        
        $options[] = array(	"name" => __('Google Profile','techozoic'),
                "desc" => __('Used for the About widget Must be full link to profile page','techozoic'),
                "id" => "google_profile",
                "std" => "",
                "type" => "text");        

        $options[] = array( 	"name" => __('Header','techozoic'),
                "type" => "heading");

        $options[] = array(	"name" => __('Display Search box in header','techozoic'),
                "desc" => __('Set to no if you don\'t want the search box to show in the header area.  If widgets are assigned to Right Header search box is automatically disabled.','techozoic'),
                "id" => "search_box",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __('Display Blog Title and Tagline in header','techozoic'),
                "desc" => __('Uncheck if your custom header image already has your blog title and tagline.  If header logo is uploaded it will always be used.','techozoic'),
                "id" => "blog_title",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __('Header Logo','techozoic'),
                "desc" => __('Replace Blog Title and Tagline with a custom logo.  Logo is overlayed on header image.  For best results use a logo with a transparent background.  When uploading Alignment options are NOT used from the uploader, alignment is set below.','techozoic'),
                "id" => "header_logo",
                "std" => '',
                "type" => "upload");        
 
       $options[] = array(	"name" => __('Header Logo Top Padding','techozoic'),
                "desc" => __('Number of pixels of top padding that should be added to logo.','techozoic'),
                "id" => "header_logo_top",
                "type" => "text",
                "class" => "mini",
                "std" => "0");        
 
       $options[] = array(	"name" => __('Header Logo Left Padding','techozoic'),
                "desc" => __('Number of pixels of left padding that should be added to logo.','techozoic'),
                "id" => "header_logo_left",
                "type" => "text",
                "class" => "mini",
                "std" => "0");        
       
        $options[] = array(	"name" => __('Blog Title and Tagline / Logo Horizontal Alignment','techozoic'),
                "desc" => __('Horizontal alignment of Blog title and tagline or header logo if used.','techozoic'),
                "id" => "blog_title_align",
                "type" => "radio",
                "std" => "left",
                "old_options" => array("Left" => "left", "Center" => "center", "Right" => "right"),
                "options" => array('left' => __('Left','techozoic'), 'center' => __('Center','techozoic') , 'right' => __('Right','techozoic')));

        $options[] = array( 	"name" => __('Single Page Header Title Text','techozoic'),
                "desc" => __('Show the Post title as the main heading and the the Blog title as the tagline on single pages.   Always Blog Title will only display the Blog Title and Tagline set in the General Options of the Blog.','techozoic'),
                "id" => "blog_title_text",
                "type" => "radio",
                "std" => "blog",
                "old_options" => array("Single Post Title" => "single", "Always Blog Title" => "blog"),
                "options" => array('single' => __('Single Post Title','techozoic'), 'blog' => __('Always Blog Title','techozoic')));

        $options[] = array( 	"name" => __('Blog Title Box Styling','techozoic'),
                "desc" => __('Styling of box around the Blog Title <br />- On: White rounded box with transparency <br />- Off: Title and tagline text only.','techozoic'),
                "id" => "blog_title_box",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "1");        
        
        $options[] = array(	"name" => __('Header Image Alignment','techozoic'),
                "desc"=> __('Align header to the Left, Right, or Center the image in the Header Container','techozoic'),
                "id" => "header_align",
                "type" => "select",
                "std" => "center",
                "old_options" => array("Left" =>"left", "Right"=>"right", "Center"=>"center"),
                "options" => array('left'=> __('Left','techozoic') ,'right'=> __('Right','techozoic') ,'center'=> __('Center','techozoic') ));

        $options[] = array(	"name" => __('Header Image Vertical Alignment','techozoic'),
                "desc"=> __('Align header to the Left, Right, or Center the image in the Header Container','techozoic'),
                "id" => "header_v_align",
                "type" => "select",
                "std" => "center",
                "old_options" => array("Top" =>"top","Center" => "center","Bottom" =>"bottom"),
                "options" => array('top'=> __('Top','techozoic') ,'center'=>__('Center','techozoic'),'bottom'=> __('Bottom','techozoic')));

        $options[] = array(	"name" => __('Header Container Height','techozoic'),
                "desc"=> __('Adjust the size of the header image  Default Height: 200px','techozoic'),
                "id" => "header_height",
                "std" => "200",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");
        
        $options[] = array(	"name" => __('Header Image Width','techozoic'),
                "desc"=> __('Adjust the size of the header image  Default width: 1000px','techozoic'),
                "id" => "header_width",
                "std" => "1000",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");
        
       $options[] = array( "name"=>__('CSS','techozoic'),
                "type"=> "heading");
        
        $options[] = array( "name" => __('Custom CSS','techozoic'),
                "desc" => __('<strong>No HTML allowed</strong> Here you can enter your own CSS.  Please keep in mind proper CSS structure.','techozoic'),
                "id" => "custom_styles",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array( 	"name" => __('Minify Dynamic CSS','techozoic'),
                "desc" => __('Minifies Dynamic CSS before outputing.','techozoic'),
                "id" => "minify",
                "type" => "checkbox",
                "std" => "0");         
        
        $options[] = array( 	"name" => __('Responsive CSS - Beta','techozoic'),
                "desc" => __('Enable responsive CSS.  Allows site customizations to work even on smaller screens.','techozoic'),
                "id" => "mobile_css",
                "type" => "checkbox",
                "std" => "0");           
        
       return $options;
}

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

    var custom = new Array();
        custom['cust_bg_color1']='#A0B3C2';
        custom['cust_content_bg_color1']='#F7F7F7';
        custom['cust_acc_color1']='#A0B3C2';
        custom['cust_link_color1']='#597EAA';
        custom['cust_link_hov_color1']='#114477';
        custom['cust_link_visit_color1']='#2C4353';
        custom['cust_nav_bg_color1']='#E3E3E3';
        custom['cust_nav_hov_bg_color1']='#EFEFEF';
        custom['cust_nav_hov_text_color1']='#A0B3C2';
        custom['cust_nav_active_bg_color1']='#A0B3C2';
        custom['cust_nav_active_text_color1']='#F7F7F7';
        custom['cust_nav_bg_gradient_top']='#E3E3E3';
        custom['cust_nav_bg_gradient_bot']='#CCCCCC';
        custom['cust_post_bg_color1']='#E3E3E3';
    var blue = new Array();
        blue['cust_bg_color1']='#A0B3C2';
        blue['cust_content_bg_color1']='#F7F7F7';
        blue['cust_acc_color1']='#A0B3C2';
        blue['cust_link_color1']='#597EAA';
        blue['cust_link_hov_color1']='#114477';
        blue['cust_link_visit_color1']='#2C4353';
        blue['cust_nav_bg_color1']='#E3E3E3';
        blue['cust_nav_hov_bg_color1']='#EFEFEF';
        blue['cust_nav_hov_text_color1']='#A0B3C2';
        blue['cust_nav_active_bg_color1']='#A0B3C2';
        blue['cust_nav_active_text_color1']='#F7F7F7';
        blue['cust_nav_bg_gradient_top']='#E3E3E3';
        blue['cust_nav_bg_gradient_bot']='#CCCCCC';
        blue['cust_post_bg_color1']='#E3E3E3';
    var khaki = new Array();
        khaki['cust_bg_color1']='#c7c69a';
        khaki['cust_acc_color1']='#c7c69a';
        khaki['cust_link_color1']='#6E0405';
        khaki['cust_link_hov_color1']='#B53839';
        khaki['cust_link_visit_color1']='#2C4353';
        khaki['cust_nav_bg_color1']='#E3E3E3';
        khaki['cust_post_bg_color1']='#E3E3E3';
        khaki['cust_content_bg_color1']='#F7F7F7';
        khaki['cust_nav_hov_bg_color1']='#C7C69A';
        khaki['cust_nav_hov_text_color1']='#f7f7f7';
        khaki['cust_nav_active_bg_color1']='#C7C69A';
        khaki['cust_nav_active_text_color1']='#F7F7F7';
        khaki['cust_nav_bg_gradient_top']='#E3E3E3';
        khaki['cust_nav_bg_gradient_bot']='#CCCCCC';
    var red = new Array();
        red['cust_bg_color1']='#AB2222';
        red['cust_acc_color1']='#AB2222';
        red['cust_link_color1']='#D33535';
        red['cust_link_hov_color1']='#B53839';
        red['cust_link_visit_color1']='#2C4353';
        red['cust_nav_bg_color1']='#E3E3E3';
        red['cust_post_bg_color1']='#E3E3E3';
        red['cust_content_bg_color1']='#F7F7F7';
        red['cust_nav_hov_bg_color1']='#EFEFEF';
        red['cust_nav_hov_text_color1']='#B53839';
        red['cust_nav_active_bg_color1']='#B53839';
        red['cust_nav_active_text_color1']='#F7F7F7';
        red['cust_nav_bg_gradient_top']='#E3E3E3';
        red['cust_nav_bg_gradient_bot']='#CCCCCC';
    var grunge = new Array();
        grunge['cust_bg_color1']='#534E3E';
        grunge['cust_acc_color1']='#534E3E';
        grunge['cust_link_color1']='#78BFBF';
        grunge['cust_link_hov_color1']='#78BFBF';
        grunge['cust_link_visit_color1']='#2C4353';
        grunge['cust_nav_bg_color1']='#E3E3E3';
        grunge['cust_post_bg_color1']='#E3E3E3';
        grunge['cust_content_bg_color1']='#F7F7F7';
        grunge['cust_nav_hov_bg_color1']='#EFEFEF';
        grunge['cust_nav_hov_text_color1']='#534E3E';
        grunge['cust_nav_active_bg_color1']='#534E3E';
        grunge['cust_nav_active_text_color1']='#F7F7F7';
        grunge['cust_nav_bg_gradient_top']='#E3E3E3';
        grunge['cust_nav_bg_gradient_bot']='#CCCCCC';
    // When the select box #base_color_scheme changes
    // it checks which value was selected and calls of_update_color
    $('#color_scheme').change(function() {
        colorscheme = $(this).val();
	if (colorscheme == 'custom') { colorscheme = custom; }
        if (colorscheme == 'blue') { colorscheme = blue; }
        if (colorscheme == 'khaki') { colorscheme = khaki; }
        if (colorscheme == 'red') { colorscheme = red; }
	if (colorscheme == 'grunge') { colorscheme = grunge; }
        for (id in colorscheme) {
            of_update_color(id,colorscheme[id]);
        }
    });
    // This does the heavy lifting of updating all the colorpickers and text
    function of_update_color(id,hex) {
        $('#section-' + id + ' .of-color').css({backgroundColor:hex});
        $('#section-' + id + ' .colorSelector').ColorPickerSetColor(hex);
        $('#section-' + id + ' .colorSelector').children('div').css('backgroundColor', hex);
        $('#section-' + id + ' .of-color').val(hex);
        $('#section-' + id + ' .of-color').animate({backgroundColor:'#ffffff'}, 600);
    }

    $('#nav_menu').click(function() {
        $('#section-nav_location').fadeToggle(400);
        $('#section-nav_type').fadeToggle(400);
        $('#section-dashboard_link').fadeToggle(400);
        $('#section-breadcrumbs').fadeToggle(400);
        $('#section-nav_align').fadeToggle(400);
        $('#section-nav_button_margin').fadeToggle(400);
        $('#section-nav_button_width').fadeToggle(400);
        $('#section-nav_menu_width').fadeToggle(400);
    });
    if ($('#nav_menu:checked').val() !== undefined) {
        $('#section-nav_location').show();
        $('#section-nav_type').show();
        $('#section-dashboard_link').show();
        $('#section-breadcrumbs').show();
        $('#section-nav_align').show();
        $('#section-nav_button_margin').show();
        $('#section-nav_button_width').show();
        $('#section-nav_menu_width').show();
    }
    $('#google_font').click(function() {
        $('#section-google_font_family').fadeToggle(400);
        $('#section-google_font_family_2').fadeToggle(400);
    });
    if ($('#google_font:checked').val() !== undefined) {
        $('#section-google_font_family').show();
        $('#section-google_font_family_2').show();
    }
});
</script>

<?php
}