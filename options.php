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
	
        $social_media = array('delicious'=>"Delicious",'digg'=>"Digg",'email'=>"Email",'facebook'=>"Facebook",'google' =>"Google +1", 'linkedin'=>"LinkedIn",'myspace'=>"MySpace",'newsvine'=>"NewsVine",'stumbleupon'=>"StumbleUpon",'twitter'=>"Twitter",'reddit'=>"Reddit",'rss'=>"RSS Icon");
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
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
		
	$options = array();
		
        $options[] = array(	"name" => __("Layout","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Column Layout","techozoic"),
                "id" => "sidebar_pos",
                "type" => "images",
                "std" => "3-col",
                "old_options" => array("Sidebar - Content - Sidebar" => "3-col", "Content - Sidebar - Sidebar" => "3-col-right","Sidebar - Sidebar - Content" => "3-col-left","Content - Sidebar" => "2-col_right", "Sidebar - Content" => "2-col-left","No Sidebars" => "1-col"),
                "options" => array("3-col" => $imagepath . '3-col.jpg', "3-col-right" => $imagepath . '3-col-right.jpg', "3-col-left" => $imagepath . '3-col-left.jpg',"2-col-right" => $imagepath . '2-col-right.jpg', "2-col-left" => $imagepath . '2-col-left.jpg',"1-col" => $imagepath . '1-col.jpg'));

        $options[] = array(	"name" => __("Fixed or Fluid Width","techozoic"),
                "id" => "page_type",
                "std" => "fluid",
                "type" => "select",
                "class" => "mini",
                "old_options" => array("Fixed Width" => "fixed", "Fluid Width"=> "fluid"),
                "options" => array('fixed' => __("Fixed Width","techozoic"), 'fluid' => __("Fluid Width","techozoic")));

        $options[] = array(	"name" => __("Page Width","techozoic"),
                "desc"=> __("Fluid Width - Percentage of Total Screen Size  <br />Fixed Width - Width in number of pixels","techozoic"),
                "id" => "page_width",
                "std" => "90",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __("Main Column Width","techozoic"),
                "desc"=> __("(Post Content) - Percentage of Page Width","techozoic"),
                "id" => "main_column_width",
                "std" => "50",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Left Sidebar Width","techozoic"),
                "desc"=> __("Percentage of Page Width","techozoic"),
                "id" => "l_sidebar_width",
                "std" => "25",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Right Sidebar Width","techozoic"),
                "desc"=> __("Percentage of Page Width","techozoic"),
                "id" => "r_sidebar_width",
                "std" => "25",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array(	"name" => __("Fav Icon Image","techozoic"),
                "desc" => __("Fav Icon must be an .ico file.  Browse for a new image or chose previously uploaded image.  After choosing press Save to upload.","techozoic"),
                "id" => "favicon_image",
                "type" => "upload");

        $options[] = array(  "name" => __("Display Sidebars on Blog Home Page","techozoic"),
                "id" => "home_sidebar",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(  "name" => __("Display Sidebars on Single Post Pages","techozoic"),
                "id" => "single_sidebar",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "0");

        $options[] = array(  "name" => __("Page Specific Sidebars","techozoic"),
                "desc" => __("Choose which pages to register a sidebar.","techozoic"),
                "id" => "page_sidebar",
                "type" => "multicheck",
                "std" => '',
                "options" => $options_pages);        
        
        $options[] = array(  "name" => __("SEO Features","techozoic"),
                "desc" => __("Disable this if any SEO plugins are used","techozoic"),
                "id" => "seo",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "1");

        $options[] = array(  "name" => __("Thickbox on Images","techozoic"),
                "desc" => __("Use Thickbox to automatically overlay images on pages</small>","techozoic"),
                "id" => "thickbox",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "0");
    
        $options[] = array( 	"name" => __("Comment Preview","techozoic"),
                "desc" => __("Enable the comment preview for posts on the home page.","techozoic"),
                "id" => "comment_preview",
                "type" => "checkbox",
                "old_options" => array("Enable" => "1", "Disable" => "0"),
                "std" => "1");
    
       $options[] = array(	"name" => __("Comment Preview Number","techozoic"),
                "desc" => __("Number of comments to display in comment preview area." ,"techozoic"),
                "id" => "comment_preview_num",
                "type" => "text",
                "old_options" => '',
                "class" => "mini",
                "std" => "3");

        $options[] = array(	"name" => __("Custom Footer Text","techozoic"),
                "desc" => __("Text displayed in footer - HTML allowed. <br />Shortcodes that can be used: <br />%BLOGNAME% -> The blog's title. <br />%THEMENAME% -> Theme name.<br /> %THEMEVER% -> Current Theme Version.<br /> %THEMEAUTHOR% -> Link to Theme Author's website.*<br />%TOP% -> Link to the Top of the page.<br /> %COPYRIGHT% -> Insert copyright info for current year.<br /> %MYSQL% -> MySQL queries and processing time info<br /><br />*It is completely optional, but if you like Techozoic I would appreciate it if you keep the credit link.","techozoic"),
                "id" => "footer_text",
                "old_options" => '',
                "std" => "%COPYRIGHT% %BLOGNAME% | %THEMENAME% %THEMEVER% by %THEMEAUTHOR%. | %TOP% <br /> <small>%MYSQL%</small>",
                "type" => "textarea");

        $options[] = array("name" => __("Drop Shadow Boxes","techozoic"),
                "desc" => __("Check the areas where the Drop Shadow Boxes shouldn't be used<br /> - note only visible in Firefox, Chrome, Safari.","techozoic"),
                "id" => "drop_shadow",
                "std" => "",
                "type" => "multicheck",
                "old_options" => array("Header Text" => "header", "Post Boxes" => "post", "Images" =>"image"),
                "options" => array('header' => __("Header Text","techozoic"), 'post' => __("Post Boxes","techozoic"), 'image' => __("Images","techozoic"), 'page' =>__("Main Page",'techozoic')));
        
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
                "old_options" => array("Main Page" => "main", "Category Archive" => "cat", "Yearly Archive" => "year", "Monthly Archive" => "month", "Tag Archive" => "tag"),
                "options" => array('main' => __("Main Page" ,"techozoic") ,'cat' => __("Category Archive","techozoic") , 'year' => __("Yearly Archive" ,"techozoic"), 'month' => __("Monthly Archive","techozoic"), 'tag' => __("Tag Archive","techozoic")));

        $options[] = array( "name" => __("Background Color","techozoic"),
                "desc" => __("Check where background color for posts defined on the color tab should be applied.","techozoic"),
                "id" => "post_background_location",
                "std" => array("main" =>"1",'archive'=>'1'),
                "type" => "multicheck",
                "old_options" => array("Main Page" => "main", "Single Post" => "single", "Archive Pages" => "archive"),
                "options" => array('main' => __("Main Page","techozoic") , 'single' => __("Single Post","techozoic") , 'archive'=> __("Archive Pages","techozoic") ));

        $options[] = array( "name" => __("Social Media Icons","techozoic"),
                "desc" => __("Check where Social Media Icons will be displayed.","techozoic"),
                "id" => "post_social_media_location",
                "std" => array("main" =>"1",'single'=>'1'),
                "type" => "multicheck",
                "old_options" => array("Main Page" => "main", "Category Archive" => "cat", "Yearly Archive" => "year", "Monthly Archive" => "month", "Tag Archive" => "tag"),
                "options" => array('main' => __("Main Page","techozoic") , 'single' => __("Single Post","techozoic") , 'archive'=> __("Category Archive","techozoic") , 'year' => __("Yearly Archive","techozoic") , 'month' => __("Monthly Archive","techozoic") , 'tag' => __("Tag Archive","techozoic")));

        $options[] = array( "name" => __("Nav","techozoic"),
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
                "old_options" => array("On" => "1","Off" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __("Breadcrumbs","techozoic"),
                "desc" => __("Enable Breadcrumb navigation.  Useful with Sidebar Nav Widget.","techozoic"),
                "id" => "breadcrumbs",
                "type" => "checkbox",
                "old_options" => array("On" => "1","Off" => "0"),
                "std" => "0");

        $options[] = array(	"name" => __("Navigation Menu Alignment","techozoic"),
                "id" => "nav_align",
                "type" => "radio",
                "std" => "left",
                "old_options" => array("Left" => "left","Center" => "center"),
                "options" => array('left'=> __("Left","techozoic") ,'center'=> __("Center","techozoic") ));

        $options[] = array(	"name" => __("Navigation Button Width","techozoic"),
                "desc" => __("Size of navigation button width in Pixels.  Set to <strong>0</strong> for variable sized buttons","techozoic"),
                "id" => "nav_button_width",
                "string" => "num",
                "std" => "0",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");

        $options[] = array( 	"name" => __("Font","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Default Text","techozoic"),
                "id" => "body_font",
                "std" => array('size'=>"12px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
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
                "std" => array('size'=>"14px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'),
                "type" => "typography");

        $options[] = array("name" => __("Post Text Font","techozoic"),
                "id" => "post_text_font",
                "std" => array('size'=>"12px",'face'=>'arial','style'=>'','color'=>'#2C4353'),
                "type" => "typography");

        $options[] = array("name" => __("Metadata Font","techozoic"),
                "id" => "small_font",
                 "std" => array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#777777'),
                 "type" => "typography");

        $options[] = array("name" => __("Google Font Replacement","techozoic"),
                "desc" =>__("Enable this to use the Google Font API to add new fonts.","techozoic"),
                "id" => "google_font",
                "std" => "0",
                "old_options" => array("Enable" => "1","Disable" => "0"),
                "type" => "checkbox");

        $options[] = array("name" => __("Goolge Fonts","techozoic"),
                "desc" => __("Visit the <a href='http://code.google.com/webfonts' target='_blank'>Google Fonts</a> site to pick the font to use.  After choosing on the font to use, copy the Name of the font here.","techozoic"),
                "id" => "google_font_family",
                "old_options" => '',
                "type" => "text");

        $options[] = array("name" => __("Goolge Font - Font Decoration","techozoic"),
                "desc" => __("Some Goolge Fonts have additional variants for <strong>Bold</strong> and <em>Italic</em>.  If the font chosen has these variants check the boxes for which decoration to apply to the Google Font.","techozoic"),
                "id" => "google_font_decoration",
                "std" => "none",
                "class" => "mini",
                "type" => "select",
                "options" => array("b" => __('Bold',"techozoic") ,'bi' => __('Bold Italic',"techozoic") , 'i' => __("Italic" ,"techozoic") ,"none" => __("Select One","techozoic") ));


        $options[] = array("name" => __("Font Replacement","techozoic"),
                "desc"=>__("Check which headings you would like replaced.","techozoic"),
                "id" => "font_headings",
                "std" => "",
                "type" => "multicheck",
                "old_options" => array("Main Blog Title" => "main","Sidebar Titles" => "sidebar","Post Titles" =>"post","H1 Headings" =>"h1","H2 Headings"  =>"h2","H3 Headings"  =>"h3","H4 Headings"  =>"h4","H5 Headings" =>"h5"),
                "options" => array('main'=>__("Main Blog Title","techozoic") ,'sidebar' => __("Sidebar Titles" ,"techozoic") , 'post'=>__("Post Titles","techozoic"), 'h1' =>__("H1 Headings","techozoic"),'h2' => __("H2 Headings","techozoic"),'h3' => __("H3 Headings" ,"techozoic"),'h4'=> __("H4 Headings","techozoic") ,'h5'=> __("H5 Headings","techozoic")));

        $options[] = array(	"name" => __("Color","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Prebuilt Color Scheme","techozoic"),
                "desc"=> __("Choose Custom to specify your own scheme","techozoic"),
                "id" => "color_scheme",
                "type" => "select",
                "std" => "custom",
                "old_options" => array("Custom 1" => 'custom',"Custom 2" => 'custom', "Blue" => "blue", "Khaki" => "khaki", "Red" =>"red", "Grunge" =>"grunge"),
                "options" => array('custom' => __("Custom","techozoic"), 'blue'=> __("Blue","techozoic") , 'khaki'=>__("Khaki","techozoic"), 'red'=>__("Red","techozoic"), 'grunge'=>__("Grunge","techozoic")));
        
        $options[] = array(	"name" => __("Body Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_bg_color1",
                "old_options" => '',
                "std" => "#A0B3C2",
                 "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the body background.","techozoic"),
                "id" => "cust_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");

        $options[] = array(	"name" => __("Content Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_content_bg_color1",
                "std" => "#F7F7F7",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the content background.","techozoic"),
                "id" => "cust_content_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");

        $options[] = array(	"name" => __("Accent Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_acc_color1",
                "std" => "#A0B3C2",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __("Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_color1",
                "std" => "#597EAA",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __("Link Hover Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_hov_color1",
                "std" => "#114477",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __("Visited Link Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_link_visit_color1",
                "std" => "#2C4353",
                "old_options" => '',
                "type" => "color");

        $options[] = array(	"name" => __("Nav Button Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_nav_bg_color1",
                "std" => "#E3E3E3",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the nav button background.","techozoic"),
                "id" => "cust_nav_bg_trans1",
                "std" => "0",
                "old_options" => array("On" =>"1"),
                "type" => "checkbox");

        $options[] = array(	"name" => __("Post Background Color","techozoic"),
                "desc" => __("Choose or Type a <a href=\"http://www.w3schools.com/HTML/html_colors.asp\" target=\"_blank\">HEX color code</a>","techozoic"),
                "id" => "cust_post_bg_color1",
                "std" => "#E3E3E3",
                "old_options" => '',
                "type" => "color");

        $options[] = array("name" => __("Transparent","techozoic"),
                "desc" => __("Check to not apply any color to the post background.","techozoic"),
                "id" => "cust_post_bg_trans1",
                "std" => "0",
                "old_options" => array("On" => '1'),
                "type" => "checkbox");
        
        $options[] = array(	"name" => __("Ads","techozoic"),
                "type" => "heading");

        $options[] = array(	 "name" => __("Home Page Ad Code","techozoic"),
                "desc"=>__("This Ad Code will be displayed a total of 3 times. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array( 	"name" => __("Number of Posts Between Ad Units","techozoic"),
                "id" => "ad_int",
                "type" => "select",
                "class" => "mini",
                "std" => "3",
                "old_options" => array('6'=>"6",'5'=> "5",'4'=> "4",'3'=> "3",'2'=> "2",'1'=> "1"),
                "options" => array('6'=>"6",'5'=> "5",'4'=> "4",'3'=> "3",'2'=> "2",'1'=> "1"));

        $options[] = array(	"name" => __("Home Page Header Ad Code","techozoic"),
                "desc" => __("This Ad Code will be displayed on the home  page below the header and navigation. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "header_ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array(	"name" => __("Single Post Ad Code","techozoic"),
                "desc"=> __("This Ad Code will be displayed on the single post page. Best ads are banner ads no wider than 500 pixels *Only html and javascript accepted <strong>Shortcodes now accepted</strong>","techozoic"),
                "id" => "sing_ad_code",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        $options[] = array(	"name" => __("Single Post Ad Position","techozoic"),
                "desc" => __("Above or below the post content on single page","techozoic"),
                "id" => "sing_ad_pos",
                "type" => "radio",
                "std" => "above",
                "old_options" => array("Above" =>"above", "Below"=>"below"),
                "options" => array('above'=> __("Above","techozoic") ,'below'=> __("Below","techozoic") ));

        $options[] = array( 	"name" => __("Social","techozoic"),
                "type" => "heading");

        $options[] = array("name" => __("Home/Archive Page Social Network Icons","techozoic"),
                "desc" => __("Choose which social network icons you would like displayed below the post on the Home/Archive pages.","techozoic"),
                "id" => "home_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "old_options" => $old_social_media,
                "options" => $social_media);

        $options[] = array("name" => __("Single Page Social Media Icons","techozoic"),
                "desc" => __("Choose which social media icons you would like displayed on the single post page.","techozoic"),
                "id" => "single_social_icons",
                "std" => array('delicious'=>'1','digg'=>'1','rss'=>'1'),
                "type" => "multicheck",
                "old_options" => $old_social_media,
                "options" => $social_media);

        $options[] = array(	"name" => __("Facebook Profile","techozoic"),
                "desc"=> __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "facebook_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");

        $options[] = array(	"name" => __("MySpace Profile","techozoic"),
                "desc" => __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "myspace_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");

        $options[] = array(	"name" => __("Twitter Profile","techozoic"),
                "desc" => __("Used for the About widget Must be full link to profile page","techozoic"),
                "id" => "twitter_profile",
                "std" => "",
                "old_options" => '',
                "type" => "text");

        $options[] = array( 	"name" => __("Header","techozoic"),
                "type" => "heading");

        $options[] = array(	"name" => __("Display Search box in header","techozoic"),
                "desc" => __("Set to no if you don't want the search box to show in the header area.  If widgets are assigned to Right Header search box is automatically disabled.","techozoic"),
                "id" => "search_box",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __("Display Blog Title and Tagline in header","techozoic"),
                "desc" => __("Uncheck if your custom header image already has your blog title and tagline","techozoic"),
                "id" => "blog_title",
                "type" => "checkbox",
                "old_options" => array("Yes" => "1", "No" => "0"),
                "std" => "1");

        $options[] = array(	"name" => __("Header Logo","techozoic"),
                "desc" => __("Replace Blog Title and Tagline with a custom logo.  Logo is overlayed on header image.  For best results use a logo with a transparent background.","techozoic"),
                "id" => "header_logo",
                "std" => '',
                "type" => "upload");        
 
       $options[] = array(	"name" => __("Header Logo Top Offset","techozoic"),
                "desc" => __("Number of pixels from top of header area logo should be offset." ,"techozoic"),
                "id" => "header_logo_top",
                "type" => "text",
                "class" => "mini",
                "std" => "0");        
 
       $options[] = array(	"name" => __("Header Logo Left Offset","techozoic"),
                "desc" => __("Number of pixels from left of header area logo should be offset." ,"techozoic"),
                "id" => "header_logo_left",
                "type" => "text",
                "class" => "mini",
                "std" => "0");        
       
        $options[] = array(	"name" => __("Blog Title and Tagline Horizontal Alignment","techozoic"),
                "id" => "blog_title_align",
                "type" => "radio",
                "std" => "left",
                "old_options" => array("Left" => "left", "Center" => "center", "Right" => "right"),
                "options" => array('left' => __("Left","techozoic"), 'center' => __("Center","techozoic") , 'right' => __("Right","techozoic")));

        $options[] = array( 	"name" => __("Single Page Header Title Text","techozoic"),
                "desc" => __("Show the Post title as the main heading and the the Blog title as the tagline on single pages.   Always Blog Title will only display the Blog Title and Tagline set in the General Options of the Blog.","techozoic"),
                "id" => "blog_title_text",
                "type" => "radio",
                "std" => "blog",
                "old_options" => array("Single Post Title" => "single", "Always Blog Title" => "blog"),
                "options" => array('single' => __("Single Post Title","techozoic"), 'blog' => __("Always Blog Title","techozoic")));

        $options[] = array( 	"name" => __("Blog Title Box Styling","techozoic"),
                "desc" => __("Styling of box around the Blog Title <br />- On: White rounded box with transparency <br />- Off: Title and tagline text only.","techozoic"),
                "id" => "blog_title_box",
                "type" => "checkbox",
                "old_options" => array("On" => "1", "Off" => "0"),
                "std" => "1");        
        
        $options[] = array(	"name" => __("Header Image Alignment","techozoic"),
                "desc"=> __("Align header to the Left, Right, or Center the image in the Header Container","techozoic"),
                "id" => "header_align",
                "type" => "select",
                "std" => "center",
                "old_options" => array("Left" =>"left", "Right"=>"right", "Center"=>"center"),
                "options" => array('left'=> __("Left","techozoic") ,'right'=> __("Right","techozoic") ,'center'=> __("Center","techozoic") ));

        $options[] = array(	"name" => __("Header Image Vertical Alignment","techozoic"),
                "desc"=> __("Align header to the Left, Right, or Center the image in the Header Container","techozoic"),
                "id" => "header_v_align",
                "type" => "select",
                "std" => "center",
                "old_options" => array("Top" =>"top","Center" => "center","Bottom" =>"bottom"),
                "options" => array('top'=> __("Top","techozoic") ,'center'=>__("Center","techozoic"),'bottom'=> __("Bottom","techozoic")));

        $options[] = array(	"name" => __("Header Container Height","techozoic"),
                "desc"=> __("Adjust the size of the header image  Default Height: 200px","techozoic"),
                "id" => "header_height",
                "std" => "200",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");
        
        $options[] = array(	"name" => __("Header Image Width","techozoic"),
                "desc"=> __("Adjust the size of the header image  Default width: 1000px","techozoic"),
                "id" => "header_width",
                "std" => "1000",
                "old_options" => '',
                "class" => "mini",
                "type" => "text");
        
       $options[] = array( "name"=>__('CSS','techozoic'),
                "type"=> "heading");
        
        $options[] = array( "name" => __("Custom CSS","techozoic"),
                "desc" => __("<strong>No HTML allowed</strong> Here you can enter your own CSS.  Please keep in mind proper CSS structure.","techozoic"),
                "id" => "custom_styles",
                "std" => "",
                "old_options" => '',
                "type" => "textarea");

        return $options;
}