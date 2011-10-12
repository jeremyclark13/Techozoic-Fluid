<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
        $social_media = array('delicious'=>"Delicious",'digg'=>"Digg",'email'=>"Email",'facebook'=>"Facebook",'linkedin'=>"LinkedIn",'myspace'=>"MySpace",'newsvine'=>"NewsVine",'stumbleupon'=>"StumbleUpon",'twitter'=>"Twitter",'reddit'=>"Reddit",'rss'=>"RSS Icon");
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
        $options[] = array(	"name" => __("Layout","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Number of Columns","techozoic"),
                "id" => "column",
                "type" => "select",
                "class"=>"mini",
                "std" => "3",
                "options" => array("3" => "3","2" => "2","1" => "1"));

        $options[] = array(	"name" => __("Column Layout","techozoic"),
                "id" => "sidebar_pos",
                "type" => "images",
                "std" => "3-col",
                "options" => array("3-col" => $imagepath . '3-col.jpg', "3-col-right" => $imagepath . '3-col-right.jpg', "3-col-left" => $imagepath . '3-col-left.jpg',"2-col-right" => $imagepath . '2-col-right.jpg', "2-col-left" => $imagepath . '2-col-left.jpg',"1-col" => $imagepath . '1-col.jpg'));

        $options[] = array(	"name" => __("Fixed or Fluid Width","techozoic"),
                "id" => "page_type",
                "std" => "fluid",
                "type" => "select",
                "class" => "mini",
                "options" => array('fixed' => "Fixed Width", 'fluid' => "Fluid Width"));

        $options[] = array(	"name" => __("Page Width","techozoic"),
                "desc"=> __("Fluid Width - Percentage of Total Screen Size  <br />Fixed Width - Width in number of pixels","techozoic"),
                "id" => "page_width",
                "std" => "90",
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __("Main Column Width","techozoic"),
                "desc"=> __("(Post Content) - Percentage of Page Width"),
                "id" => "main_column_width",
                "std" => "50",
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Left Sidebar Width","techozoic"),
                "desc"=> __("Percentage of Page Width","techozoic"),
                "id" => "l_sidebar_width",
                "std" => "25",
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Right Sidebar Width","techozoic"),
                "desc"=> __("Percentage of Page Width","techozoic"),
                "id" => "r_sidebar_width",
                "std" => "25",
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __("Fav Icon Image","techozoic"),
                "desc" => __("Fav Icon must be an .ico file.  Browse for a new image or chose previously uploaded image.  After choosing press Save to upload.","techozoic"),
                "id" => "favicon_image",
                "type" => "upload");

        $options[] = array(  "name" => __("Display Sidebars on Blog Home Page","techozoic"),
                "id" => "home_sidebar",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(  "name" => __("Display Sidebars on Single Post Pages","techozoic"),
                "id" => "single_sidebar",
                "type" => "checkbox",
                "std" => "0");

        $options[] = array(  "name" => __("SEO Features","techozoic"),
                "desc" => __("Disable this if any SEO plugins are used","techozoic"),
                "id" => "seo",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(  "name" => __("Thickbox on Images","techozoic"),
                "desc" => __("Use Thickbox to automatically overlay images on pages</small>","techozoic"),
                "id" => "thickbox",
                "type" => "checkbox",
                "std" => "0");

        $options[] = array(	"name" => __("Display Search box in header","techozoic"),
                "desc" => __("Set to no if you don't want the search box to show in the header area.  If widgets are assigned to Right Header search box is automatically disabled.","techozoic"),
                "id" => "search_box",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(	"name" => __("Display Blog Title and Tagline in header","techozoic"),
                "desc" => __("Set to no if your custom header image already has your blog title and tagline","techozoic"),
                "id" => "blog_title",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(	"name" => __("Blog Title and Tagline Horizontal Alignment","techozoic"),
                "id" => "blog_title_align",
                "type" => "radio",
                "std" => "left",
                "options" => array('left' => "Left", 'center' => "Center" , 'right' => "Right"));

        $options[] = array( 	"name" => __("Single Page Header Title Text","techozoic"),
                "desc" => __("Show the Post title as the main heading and the the Blog title as the tagline on single pages.   Always Blog Title will only display the Blog Title and Tagline set in the General Options of the Blog.","techozoic"),
                "id" => "blog_title_text",
                "type" => "radio",
                "std" => "single",
                "options" => array('single' => "Single Post Title", 'blog' => "Always Blog Title"));

        $options[] = array( 	"name" => __("Blog Title Box Styling","techozoic"),
                "desc" => __("Styling of box around the Blog Title <br />- On: White rounded box with transparency <br />- Off: Title and tagline text only.","techozoic"),
                "id" => "blog_title_box",
                "type" => "checkbox",
                "std" => "1");
    
        $options[] = array( 	"name" => __("Comment Preview","techozoic"),
                "desc" => __("Enable the comment preview for posts on the home page.","techozoic"),
                "id" => "comment_preview",
                "type" => "checkbox",
                "std" => "1");
    
       $options[] = array(	"name" => __("Comment Preview Number","techozoic"),
                "desc" => __("Number of comments to display in comment preview area." ,"techozoic"),
                "id" => "comment_preview_num",
                "type" => "text",
                "class" => "mini",
                "std" => "3");

        $options[] = array(	"name" => __("Custom Footer Text","techozoic"),
                "desc" => __("Text displayed in footer - HTML allowed. <br />Shortcodes that can be used: <br />%BLOGNAME% -> The blog's title. <br />%THEMENAME% -> Theme name.<br /> %THEMEVER% -> Current Theme Version.<br /> %THEMEAUTHOR% -> Link to Theme Author's website.*<br />%TOP% -> Link to the Top of the page.<br /> %COPYRIGHT% -> Insert copyright info for current year.<br /> %MYSQL% -> MySQL queries and processing time info<br /><br />*It is completely optional, but if you like Techozoic I would appreciate it if you keep the credit link.","techozoic"),
                "id" => "footer_text",
                "std" => "%COPYRIGHT% %BLOGNAME% | %THEMENAME% %THEMEVER% by %THEMEAUTHOR%. | %TOP% <br /> <small>%MYSQL%</small>",
                "type" => "textarea");

        $options[] = array("name" => __("Drop Shadow Boxes","techozoic"),
                "desc" => __("Check the areas where the Drop Shadow Boxes shouldn't be used<br /> - note only visible in Firefox, Chrome, Safari.","techozoic"),
                "id" => "drop_shadow",
                "std" => "",
                "type" => "multicheck",
                "options" => array('header' => "Header Text", 'post' => "Post Boxes", 'image' => "Images"));
        
        $options[] = array(	"name" => __("Page Background Image","techozoic"),
                "desc" => __("Use a tiled image for best results.","techozoic"),
                "id" => "bg_image",
                "std" => array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'),
                "type" => "background");

        $options[] = array(	"name" => __("Content Background Image","techozoic"),
                "desc"=> __("Use a tiled image for best results.","techozoic"),
                "id" => "content_bg_image",
                "std" => array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'),
                "type" => "background");
        
        $options[] = array( 	"name" => __("Posts","techozoic"),
                "type" => "heading");

        $options[] = array("name" => __("Excerpt Location","techozoic"),
                "desc" => __("Check where excerpts should be used instead of full post content.  If an area isn't checked then the full post is displayed.","techozoic"),
                "id" => "excerpt_location",
                "old_id" => "unused before 1.9.3",
                "std" => array("tag" => '1'),
                "type" => "multicheck",
                "options" => array('main' => "Main Page",'cat' => "Category Archive", 'year' =>"Yearly Archive", 'month' => "Monthly Archive", 'tag' => "Tag Archive"));

        $options[] = array("name" => __("Background Color","techozoic"),
                "desc" => __("Check where background color for posts defined on the color tab should be applied.","techozoic"),
                "id" => "post_background_location",
                "std" => array("main" =>"1",'archive'=>'1'),
                "type" => "multicheck",
                "options" => array('main' => "Main Page", 'single' =>"Single Post", 'archive'=>"Archive Pages"));

        $options[] = array("name" => __("Social Media Icons","techozoic"),
                "desc" => __("Check where Social Media Icons will be displayed.","techozoic"),
                "id" => "post_social_media_location",
                "std" => array("main" =>"1",'single'=>'1'),
                "type" => "multicheck",
                "options" => array('main' => "Main Page", 'single' =>"Single Post", 'archive'=>"Archive Pages", 'year' =>"Yearly Archive", 'month' => "Monthly Archive", 'tag' => "Tag Archive"));

        $options[] = array( "name"=>__('CSS','techozoic'),
                "type"=> "heading");
        
        $options[] = array(	"name" => __("Custom CSS","techozoic"),
                "desc" => __("<strong>No HTML allowed</strong> Here you can enter your own CSS.  Please keep in mind proper CSS structure.","techozoic"),
                "id" => "custom_styles",
                "std" => "",
                "type" => "textarea");

        $options[] = array( 	"name" => __("Nav","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Navigation Menu","techozoic"),
                "desc" => __("Enable navigation menu.  If disabled visit the <a href=\"widgets.php\">widgets</a> page to add  the Techozoic Sidebar Navigation widget","techozoic"),
                "id" => "nav_menu",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(	"name" => __("Log In/Out Links","techozoic"),
                "desc" => __("Enable Dashboard and Log in/out links.","techozoic"),
                "id" => "dashboard_link",
                "type" => "checkbox",
                "std" => "1");

        $options[] = array(	"name" => __("Breadcrumbs","techozoic"),
                "desc" => __("Enable Breadcrumb navigation.  Useful with Sidebar Nav Widget.","techozoic"),
                "id" => "breadcrumbs",
                "type" => "checkbox",
                "std" => "0");

        $options[] = array(	"name" => __("Navigation Menu Alignment","techozoic"),
                "id" => "nav_align",
                "type" => "radio",
                "std" => "left",
                "options" => array('left'=>"Left",'center'=>"Center"));

        $options[] = array(	"name" => __("Navigation Button Width","techozoic"),
                "desc" => __("Size of navigation button width in EM.  Set to <strong>0</strong> for variable sized buttons","techozoic"),
                "id" => "nav_button_width",
                "string" => "num",
                "std" => "0",
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Font","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Default Text","techozoic"),
                "id" => "body_font",
                "std" => array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>  __("Main Heading Font","techozoic"),
                "id" => "main_heading_font",
                "std" => array('size'=>"30px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'),
                "type" => "typography");

        $options[] = array("name" => __("Post Heading Font","techozoic"),
                "id" => "post_heading",
                "std" => array('size'=>"20px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>__("Sidebar Heading Font","techozoic"),
                "id" => "side_heading_font",
                "std" => array('size'=>"16px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" =>__("Nav Menu Text Font","techozoic"),
                "id" => "nav_font",
                "std" => array('size'=>"13px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'),
                "type" => "typography");

        $options[] = array("name" => __("Post Text Font","techozoic"),
                "id" => "post_text_font",
                "std" => array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" => __("Metadata Font","techozoic"),
                "id" => "small_font",
                 "std" => array('size'=>"9px",'face'=>'arial','style'=>'','color'=>'#777777'),
                 "type" => "typography");

        $options[] = array("name" => __("Google Font Replacement","techozoic"),
                "desc" =>__("Enable this to use the Google Font API to add new fonts.","techozoic"),
                "id" => "google_font",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array("name" => __("Goolge Fonts","techozoic"),
                "desc" => __("Visit the <a href='http://code.google.com/webfonts' target='_blank'>Google Fonts</a> site to pick the font to use.  After choosing on the font to use, copy the Name of the font here.","techozoic"),
                "id" => "google_font_family",
                "std" => "",
                "type" => "text");

        $options[] = array("name" => __("Goolge Font - Font Decoration","techozoic"),
                "desc" => __("Some Goolge Fonts have additional variants for <strong>Bold</strong> and <em>Italic</em>.  If the font chosen has these variants check the boxes for which decoration to apply to the Google Font.","techozoic"),
                "id" => "google_font_decoration",
                "std" => "",
                "type" => "radio",
                "options" => array("b" =>'Bold','bi' =>'Bold Italic', 'i' => "Italic"));


        $options[] = array("name" => __("Font Replacement","techozoic"),
                "desc"=>__("Check which headings you would like replaced.","techozoic"),
                "id" => "font_headings",
                "std" => "",
                "type" => "multicheck",
                "options" => array('main'=>"Main Blog Title",'sidebar' => "Sidebar Titles", 'post'=>"Post Titles", 'h1' =>"H1 Headings",'h2' => "H2 Headings",'h3' => "H3 Headings",'h4'=>"H4 Headings",'h5'=>"H5 Headings"));

        $options[] = array(	"name" => __("Color","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Prebuilt Color Scheme","techozoic"),
                "desc"=> __("Choose Custom 1 or 2 to specify your own scheme Two Custom options are provided to save two custom color schemes","techozoic"),
                "id" => "color_scheme",
                "old_id" => "tech_color_scheme",
                "type" => "select",
                "std" => "custom_1",
                "options" => array('custom_1' =>"Custom 1",'custom_2' =>"Custom 2", 'blue'=>"Blue", 'khaki'=>"Khaki", 'red'=>"Red", 'grunge'=>"Grunge"));
        
        $options[] = array( "name"=>__("Custom Color Scheme 1", "techozoic"),
                "type" => "info");
        
        $options[] = array(	"name" => __("Body Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_bg_color1",
                "std" => "#A0B3C2",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the body background.","techozoic"),
                "id" => "cust_bg_trans1",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Content Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_content_bg_color1",
                "std" => "#F7F7F7",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the content background.","techozoic"),
                "id" => "cust_content_bg_trans1",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Accent Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_acc_color1",
                "std" => "#A0B3C2",
                "type" => "color");

        $options[] = array( 	"name" => __("Text Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_text_color1",
                "std" => "#2C4353",
                "type" => "color");

        $options[] = array(	"name" => __("Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_color1",
                "std" => "#597EAA",
                "type" => "color");

        $options[] = array(	"name" => __("Link Hover Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_hov_color1",
                "std" => "#114477",
                "type" => "color");

        $options[] = array(	"name" => __("Visited Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_visit_color1",
                "std" => "#2C4353",
                "type" => "color");

        $options[] = array(	"name" => __("Nav Button Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_nav_bg_color1",
                "std" => "#E3E3E3",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the nav button background.","techozoic"),
                "id" => "cust_nav_bg_trans1",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Post Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_post_bg_color1",
                "std" => "#E3E3E3",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the post background.","techozoic"),
                "id" => "cust_post_bg_trans1",
                "std" => "0",
                "type" => "checkbox");
        
        $options[] = array( "name"=>__("Custom Color Scheme 2", "techozoic"),
                "type" => "info");
        
        $options[] = array(	"name" => __("Body Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_bg_color2",
                "std" => "#A0B3C2",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the body background.","techozoic"),
                "id" => "cust_bg_trans2",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Content Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_content_bg_color2",
                "std" => "#F7F7F7",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the content background.","techozoic"),
                "id" => "cust_content_bg_trans2",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Accent Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_acc_color2",
                "std" => "#A0B3C2",
                "type" => "color");

        $options[] = array(	"name" => __("Text Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_text_color2",
                "std" => "#2C4353",
                "type" => "color");

        $options[] = array(	"name" => __("Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_color2",
                "std" => "#597EAA",
                "type" => "color");

        $options[] = array(	"name" => __("Link Hover Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_hov_color2",
                "std" => "#114477",
                "type" => "color");

        $options[] = array(	"name" => __("Visited Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_visit_color2",
                "std" => "#2C4353",
                "type" => "color");

        $options[] = array(	"name" => __("Nav Button Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_nav_bg_color2",
                "std" => "#E3E3E3",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the nav button background.","techozoic"),
                "id" => "cust_nav_bg_trans2",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Post Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_post_bg_color2",
                "std" => "#E3E3E3",
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the post background.","techozoic"),
                "id" => "cust_post_bg_trans2",
                "std" => "0",
                "type" => "checkbox");

        $options[] = array(	"name" => __("Ads","techozoic"),
                "type" => "heading");

        $options[] = array(	 "name" => __("Home Page Ad Code","techozoic"),
                "desc"=>__("This Ad Code will be displayed a total of 3 times. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "ad_code",
                "std" => "",
                "type" => "textarea");

        $options[] = array( 	"name" => __("Number of Posts Between Ad Units","techozoic"),
                "id" => "ad_int",
                "type" => "select",
                "class" => "mini",
                "std" => "3",
                "options" => array('6'=>"6",'5'=> "5",'4'=> "4",'3'=> "3",'2'=> "2",'1'=> "1"));

        $options[] = array(	"name" => __("Home Page Header Ad Code","techozoic"),
                "desc" => __("This Ad Code will be displayed on the home  page below the header and navigation. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "header_ad_code",
                "std" => "",
                "type" => "textarea");

        $options[] = array(	"name" => __("Single Post Ad Code","techozoic"),
                "desc"=> __("This Ad Code will be displayed on the single post page. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "sing_ad_code",
                 "std" => "",
                "type" => "textarea");

        $options[] = array(	"name" => __("Single Post Ad Position","techozoic"),
                "desc" => __("Above or below the post content on single page","techozoic"),
                "id" => "sing_ad_pos",
                "type" => "radio",
                "std" => "above",
                "options" => array('above'=>"Above",'below'=> "Below"));

        $options[] = array( 	"name" => __("Social","techozoic"),
                "type" => "heading");

        $options[] = array("name" => __("Home/Archive Page Social Network Icons","techozoic"),
                "desc" => __("Choose which social network icons you would like displayed below the post on the Home/Archive pages.","techozoic"),
                "id" => "home_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "options" => $social_media);

        $options[] = array("name" => __("Single Page Social Media Icons","techozoic"),
                "desc" => __("Choose which social media icons you would like displayed on the single post page.","techozoic"),
                "id" => "single_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "options" => $social_media);

        $options[] = array(	"name" => __("Facebook Profile","techozoic"),
                "desc"=> __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "facebook_profile",
                "std" => "",
                "type" => "text");

        $options[] = array(	"name" => __("MySpace Profile","techozoic"),
                "desc" => __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "myspace_profile",
                "std" => "",
                "type" => "text");

        $options[] = array(	"name" => __("Twitter Profile","techozoic"),
                "desc" => __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "twitter_profile",
                "std" => "",
                "type" => "text");

        $options[] = array( 	"name" => __("Header","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Header Image Alignment","techozoic"),
                "desc"=> __("Align header to the Left, Right, or Center the image in the Header Container","techozoic"),
                "id" => "header_align",
                "type" => "select",
                "std" => "center",
                "options" => array('left'=>"Left",'right'=>"Right",'center'=>"Center"));

        $options[] = array(	"name" => __("Header Image Vertical Alignment","techozoic"),
                "desc"=> __("Align header to the Left, Right, or Center the image in the Header Container","techozoic"),
                "id" => "header_v_align",
                "type" => "select",
                "std" => "center",
                "options" => array('top'=>"Top",'center'=>"Center",'bottom'=>"Bottom"));

        $options[] = array(	"name" => __("Header Container Height","techozoic"),
                "desc"=> __("Adjust the size of the header image  Default Height: 200px","techozoic"),
                "id" => "header_height",
                "std" => "200",
                "class" => "mini",
                "type" => "text");
        
        $options[] = array(	"name" => __("Header Image Width","techozoic"),
                "desc"=> __("Adjust the size of the header image  Default width: 1000px","techozoic"),
                "id" => "header_width",
                "std" => "1000",
                "class" => "mini",
                "type" => "text");

        return $options;
}