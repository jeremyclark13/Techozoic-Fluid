<?php 
	global $tech;
	$tech = get_option('techozoic_options');
	function tech_font($font) {
		switch ($font){
			case "Trebuchet MS":
				$font = '"Trebuchet MS", Helvetica';
			break;
			case "Tahoma":
				$font = $font . ', Geneva';
			break;
			case "Times New Roman":
				$font = '"Times New Roman", Times';
			break;
			case "Lucida Sans Unicode":
				$font = '"Lucida Sans Unicode" , "Lucida Grande"';
			break;
			case "Impact":
				$font = 'Impact, Charcoal';
			break;
		}
		return $font;
	}
	
	function tech_google_font_family($where) {
		global $tech;
		$classes = explode( ',' , $tech['font_headings']);
		if (in_array($where, $classes)){
			return str_replace('+', ' ', $tech['google_font_family']) . ', ';
		}
	}
	
	function tech_color_verify($color){
		if ($color){
			if ($color[0] != '#')
				$color = '#'.$color;
			return $color;
		}
	}
	
	$tech['blog_title_display'] = '';
	$tech['blog_title_cursor'] = '';
	$tech['header_align'] = strtolower($tech['header_align']);
	$tech['header_v_align'] = strtolower($tech['header_v_align']);
	$bg_image_repeat = explode(',', $tech['bg_image_repeat']);
	$tech_bg_repeat = "no-repeat";
	if (in_array("X" , $bg_image_repeat)) {
		$tech_bg_repeat = "repeat-x";
	}
	if (in_array("Y" , $bg_image_repeat)) {
		if ($tech_bg_repeat == "repeat-x"){
			$tech_bg_repeat = "repeat";
		} else {
			$tech_bg_repeat = "repeat-y";
		}
	}
	$content_bg_image_repeat = explode(',', $tech['content_bg_image_repeat']);
	$tech_content_bg_repeat = "no-repeat";
	if (in_array("X" , $content_bg_image_repeat)) {
		$tech_content_bg_repeat = "repeat-x";
	}
	if (in_array("Y" , $content_bg_image_repeat)) {
		if ($tech_content_bg_repeat == "repeat-x"){
			$tech_content_bg_repeat = "repeat";
		} else {
			$tech_content_bg_repeat = "repeat-y";
		}
	}
	
	if ($tech['page_type'] == 'Fixed Width'){$tech['sign'] = 'px';} else {$tech['sign'] = '%';}
	if ($tech['page_width'] == 0 ) { $tech['page_width'] = '95'; $tech['sign'] = '%';}
	if ($tech['page_type'] == 'Fluid Width' && $tech['page_width'] > 101)  $tech['page_width'] = '100';
	if ($tech['blog_title'] == 'No')  $tech['blog_title_display'] = 'display:none';
	if ($tech['blog_title_text'] == 'Single Post Title') $tech['blog_title_cursor'] = 'cursor:default;';
	$tech_blog_title_align_check ="";
	$tech_nav_align_check ="";
	switch ($tech['blog_title_align']){
		case "Left":
			$tech['blog_title_align'] = 'float:left;margin-left:10px';
		break;
		case "Right":
			$tech['blog_title_align'] = 'float:right;margin-right:10px';
		break;
		case "Center":
			$tech['blog_title_align'] = 'float:left;position:relative;left:-50%';
			$tech_blog_title_align_check = "Center";
		break;
	}
	switch ($tech['nav_align']){
		case "Center":
			$tech['nav_align'] = 'float:left;position:relative;left:-50%';
			$tech_nav_align_check = "Center";
		break;
		case "Left":
			$tech['nav_align'] = '';
		break;
	}
	
	$tech['default_font'] = tech_font($tech['default_font']);
	$tech['body_font'] = tech_font($tech['body_font']);
	$tech['nav_font'] = tech_font($tech['nav_font']);
	$tech_blog_title_font = tech_google_font_family('Main Blog Title') .  tech_font($tech['header_font']);
	$tech_h1_font = tech_google_font_family('H1 Headings') . tech_font($tech['header_font']);
	$tech_h2_font = tech_google_font_family('H2 Headings') . tech_font($tech['header_font']);
	$tech_h3_font = tech_google_font_family('H3 Headings') . tech_font($tech['header_font']);
	$tech_h4_font = tech_google_font_family('H4 Headings') . tech_font($tech['header_font']);
	$tech_h5_font = tech_google_font_family('H5 Headings') . tech_font($tech['header_font']);
	$tech_sidebar_font = tech_google_font_family('Sidebar Titles') . tech_font($tech['sidebar_font']);
	$tech_post_title_font = tech_google_font_family('Post Titles') . tech_font($tech['header_font']);
	$cufon_header_size = $tech['main_heading_font_size'] ;
	$cufon_sidebar_size = "1.6";
	$tech_color_scheme = $tech['color_scheme'];
	$tech_default_color = array(
		"Blue" => 	array ('#A0B3C2','#A0B3C2','#597EAA','#114477','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Khaki" => 	array ('#c7c69a','#c7c69a','#6E0405','#B53839','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Red" => 	array ('#AB2222','#AB2222','#D33535','#B53839','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Grunge" => 	array ('#534E3E','#534E3E','#78BFBF','#78BFBF','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7')
	);
        $tech_color_names = array('Blue','Khaki','Red','Grunge');
        if (in_array($tech['color_scheme'], $tech_color_names)){
            $tech_bg_color =            $tech_default_color[$tech_color_scheme][0];
            $tech_acc_color =           $tech_default_color[$tech_color_scheme][1];
            $tech_link_color =          $tech_default_color[$tech_color_scheme][2];
            $tech_link_hov_color = 	$tech_default_color[$tech_color_scheme][3];
            $tech_visit_link_color = 	$tech_default_color[$tech_color_scheme][4];
            $tech_text_color =          $tech_default_color[$tech_color_scheme][5];
            $tech_nav_bg_color = 	$tech_default_color[$tech_color_scheme][6];
            $tech_post_bg_color = 	$tech_default_color[$tech_color_scheme][7];
            $tech_content_bg_color =    $tech_default_color[$tech_color_scheme][8];
        } elseif ($tech['color_scheme'] == 'Custom 1'){
            $tech_bg_color =            tech_color_verify($tech['cust_bg_color1']);
            $tech_bg_trans =            $tech['cust_bg_trans1'];
            $tech_acc_color =           tech_color_verify($tech['cust_acc_color1']);
            $tech_link_color =          tech_color_verify($tech['cust_link_color1']);
            $tech_link_hov_color =      tech_color_verify($tech['cust_link_hov_color1']);
            $tech_visit_link_color =    tech_color_verify($tech['cust_link_visit_color1']);
            $tech_text_color =          tech_color_verify($tech['cust_text_color1']);
            $tech_nav_bg_color =        tech_color_verify($tech['cust_nav_bg_color1']);
            $tech_nav_bg_trans =        $tech['cust_nav_bg_trans1'];
            $tech_post_bg_color =       tech_color_verify($tech['cust_post_bg_color1']);
            $tech_post_bg_trans =       $tech['cust_post_bg_trans1'];
            $tech_content_bg_color =    tech_color_verify($tech['cust_content_bg_color1']);
            $tech_content_bg_trans =    $tech['cust_content_bg_trans1'];
        } else {
            $tech_bg_color =            tech_color_verify($tech['cust_bg_color2']);
            $tech_bg_trans =            $tech['cust_bg_trans2'];
            $tech_acc_color =           tech_color_verify($tech['cust_acc_color2']);
            $tech_link_color =          tech_color_verify($tech['cust_link_color2']);
            $tech_link_hov_color = 	tech_color_verify($tech['cust_link_hov_color2']);
            $tech_visit_link_color = 	tech_color_verify($tech['cust_link_visit_color2']);
            $tech_text_color =          tech_color_verify($tech['cust_text_color2']);
            $tech_nav_bg_color =	tech_color_verify($tech['cust_nav_bg_color2']);
            $tech_nav_bg_trans =        $tech['cust_nav_bg_trans2'];
            $tech_post_bg_color = 	tech_color_verify($tech['cust_post_bg_color2']);
            $tech_post_bg_trans =       $tech['cust_post_bg_trans2'];
            $tech_content_bg_color =    tech_color_verify($tech['cust_content_bg_color2']);
            $tech_content_bg_trans =    $tech['cust_content_bg_trans2'];
        }
        $tech_nav_ul_bg_color = $tech_nav_bg_color;
        if ($tech_bg_trans == 'On') $tech_bg_color = 'transparent';
        if ($tech_nav_bg_trans == 'On') $tech_nav_bg_color = 'transparent';
        if ($tech_post_bg_trans == 'On')  $tech_post_bg_color = 'transparent';
        if ($tech_content_bg_trans == 'On') $tech_content_bg_color = 'transparent';
	$tech_sidebar_h3_font_size = $tech['side_heading_font_size'] - .4;
	$tech_wp_content = WP_CONTENT_URL;
	$header_folder = TEMPLATEPATH. "/uploads/images/headers";
	if (!file_exists($header_folder)){
		$home = get_template_directory_uri();
	} else {
		if ($tech['image_location'] == 'theme') {
			$home = get_template_directory_uri() ."/uploads";
		} else {
			$home = WP_CONTENT_URL . "/techozoic/";
		}
	}
	$tech_drop_shadow_classes = ".noclass";
	if ($tech['drop_shadow']){
		$tech_drop_shadow = explode( ',' , $tech['drop_shadow']);
		$tech_drop_shadow_class_map = array(
		"Header Text" => "#headerimg",
		"Post Boxes" => ".home .narrowcolumn .entry, .home .widecolumn .entry, .top, .archive .entry",
		"Images" => ".entry img, .entrytext img"
		);
		foreach ($tech_drop_shadow as $tds){
			$tech_drop_shadow_classes .= ",". $tech_drop_shadow_class_map[$tds];
		}
	}
	$tech_post_bg_color_classes = ".noclass";
	if ($tech['post_background_location']){
		$tech_post_bg_color_loc = explode( ',' , $tech['post_background_location']);
		$tech_post_bg_color_class_map = array(
		"Main Page" => '.home .narrowcolumn .entry, home .widecolumn .entry, .top', 
		"Single Post" => '.post .singlepost',
		"Archive Pages" => '.archive .narrowcolumn .entry, .archive .widecolumn .entry, .top'
		);
		foreach ($tech_post_bg_color_loc as $tpbc){
			$tech_post_bg_color_classes .= ",". $tech_post_bg_color_class_map[$tpbc];
		}
	}

$css_var =  <<<CSS
/*Techozoic {$tech['ver']}*/

/*Variable Styles*/
#page{ 
background:{$tech_content_bg_color} url({$tech['content_bg_image']}) {$tech_content_bg_repeat} top left;
}
#header{
background-color:{$tech_content_bg_color};
}
body{
font-family:{$tech['default_font']}, Sans-Serif;
font-size: {$tech['body_font_size']}px;
background:{$tech_bg_color} url({$tech['bg_image']}) {$tech_bg_repeat} top left;
}
.techozoic_font_size{
font-size: {$tech['body_font_size']}px;
}
.narrowcolumn .entry,.widecolumn .entry, .top {
font-family:{$tech['body_font']}, Sans-Serif;
}
{$tech_post_bg_color_classes}{
background-color:{$tech_post_bg_color};
border-top:1px {$tech_acc_color} solid;
}
.top{
border:none;
}
h1{
font-family:{$tech_h1_font}, Sans-Serif;
}
h2{
font-family:{$tech_h2_font}, Sans-Serif;
}
h3{
font-family:{$tech_h3_font}, Sans-Serif;
}
h4{
font-family:{$tech_h4_font}, Sans-Serif;
}
h5{
font-family:{$tech_h5_font}, Sans-Serif;
}
.blog_title{
font-family:{$tech_blog_title_font}, Sans-Serif;
}
.post_title{
font-family:{$tech_post_title_font}, Sans-Serif;
}
.sidebar h2, .sidebar h3, #footer h2{
font-family:{$tech_sidebar_font}, Sans-Serif;
}
.blog_title{
font-size: {$tech['main_heading_font_size']}em;
}
.post_title {
font-size: {$tech['post_heading_font_size']}em;
}
.widgettitle {
font-size: {$tech['side_heading_font_size']}em;
margin: 1px 0;
}
.sidebar h3 {
font-size: {$tech_sidebar_h3_font_size}em;
}
#content {
font-size: {$tech['post_text_font_size']}em;
}
acronym,abbr,span.caps,small,.trackback li,#commentform input,#commentform textarea,.sidebar {
font-size: {$tech['small_font_size']}em;
}
.description, ul#nav a, ul#admin a, #dropdown li.current_page_item a:hover, .menu li.current-menu-item a:hover, #dropdown li.current_page_item ul a, .menu li.current-menu-item ul a, ul#nav li.current_page_item a:hover,.blog_title a,.blog_title a:visited, #nav2 a, #nav2 li.current_page_item a:hover,#subnav a, #subnav a:visited, #dropdown a, #navmenu .menu li a, #navmenu .menu li.current-menu-item a{
color: {$tech_acc_color};
}
.author,#searchform #s, #searchsubmit:hover,#catsubmit:hover,#wp-submit:hover,.postform,#TB_ajaxContent {
background-color: {$tech_acc_color} ;
}
ul#nav li,ul#admin li, #nav2 li, ul#dropdown li, #navmenu .menu li{
background-color: {$tech_nav_bg_color};
}
ul#nav li,ul#admin li, #nav2 li, ul#dropdown li a, #navmenu .menu li a{
font-family:{$tech['nav_font']}, Sans-Serif;
font-size:{$tech['nav_text_font_size']}em;
}
#navmenu .menu ul.sub-menu li{
background-color: {$tech_nav_ul_bg_color};
}
CSS;
if($tech_nav_bg_trans != 'On') {
$css_var .=  <<<CSS
ul#nav li.current_page_item,#nav2 li.current_page_item,#nav2 li.current_page_parent,ul#nav2 li.current_page_ancestor,#dropdown li.current_page_item, #navmenu .menu li.current-menu-item {
background-color: {$tech_acc_color} ;
}
ul#nav li:hover,#nav2 li:hover, #nav2 li:active, #dropdown li:hover, #navmenu .menu li:hover {
background:#efefef;
box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
-moz-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
}
ul#nav li.current_page_item a ,#nav2 li.current_page_item a,#nav2 li.current_page_parent a, #nav2 li.current_page_ancestor a,#dropdown li.current_page_item a, #navmenu .menu li.current-menu-item a{
color:#f7f7f7;
}
ul#admin li:hover{
background:#efefef;
box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-moz-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
}
CSS;
}
$css_var .= <<<CSS
.post_date {
background-color:{$tech_acc_color};
}
.tags {
border-bottom:1px {$tech_acc_color} solid;
}
#content,h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5{
color:{$tech_text_color};
}
a,h2 a:hover,h3 a:hover,.commentdiv a, .commentdiv a:visited,#user_login,#user_pass,.postform,.commentdiv span, #sidenav a:visited {
color:{$tech_link_color}; 
text-decoration:none;
}
.date_post,#searchform #s {
color:{$tech_post_bg_color}; 
text-decoration:none;
}
a:hover,.blog_title a:hover {
color:{$tech_link_hov_color}; 
text-decoration:underline;
}
a:visited{
color:{$tech_visit_link_color};
}
ul#nav li.current_page_item a:hover, ul#nav2 li.current_page_item a:hover, ul#nav2 li.current_page_parent a:hover {
color:{$tech_acc_color};
}
#headerimg {
{$tech['blog_title_display']};
{$tech['blog_title_align']};
}
.single .blog_title a:hover {
{$tech['blog_title_cursor']}
text-decoration:none;
}
{$tech_drop_shadow_classes}{
-moz-box-shadow:none !important;
box-shadow:none !important;
-webkit-box-shadow: none !important;
opacity:1 !important;
border: none !important;
}
CSS;
	if ($tech_blog_title_align_check == "Center" && is_active_sidebar( 'left_header' ) ){
$css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:15%;
}
CSS;
	} else if ($tech_blog_title_align_check == "Center" && !is_active_sidebar( 'left_header' ) ){
$css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:50%;
}
CSS;
	}
	if ($tech['column'] == 1) {
		if ($tech['main_column_width'] == 0) 
			$tech['main_column_width'] = 100; 
		$tech['main_column_width'] = $tech['main_column_width'] - 6;
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech['main_column_width']}%;
}
CSS;
	} else if ($tech['column'] == 2) {
		if ($tech['sidebar_pos'] =='Content - Sidebar') {
			if ($tech['main_column_width'] == 0 && $tech['r_sidebar_width'] != 0 ) {
				$tech['main_column_width'] = 97 - $tech['r_sidebar_width'];
			} elseif ($tech['main_column_width'] == 0 ){
				$tech['main_column_width'] = 70;
			}
			if ($tech['r_sidebar_width'] == 0 && $tech['main_column_width'] != 70) {  
				$tech['r_sidebar_width'] = 96 - $tech['main_column_width'];
			} elseif ($tech['r_sidebar_width'] == 0){
				$tech['r_sidebar_width'] = 23;
			}
			$tech['main_column_width'] = $tech['main_column_width'] - 5;
			$tech['r_sidebar_width'] = $tech['r_sidebar_width'] - 3;
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech['main_column_width']}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 1%;
width:{$tech['r_sidebar_width']}%
}
CSS;
		} else { 
			if ($tech['main_column_width'] == 0 && $tech['l_sidebar_width'] != 0 ) {
				$tech['main_column_width'] = 97 - $tech['l_sidebar_width'];
			} elseif ($tech['main_column_width'] == 0){
				$tech['main_column_width'] = 70;
			}
			if ($tech['l_sidebar_width'] == 0 && $tech['main_column_width'] != 70) {  
				$tech['l_sidebar_width'] = 96 - $tech['main_column_width'];
			} elseif ($tech['l_sidebar_width'] == 0){
				$tech['l_sidebar_width'] = 23;
			}
			$tech['main_column_width'] = $tech['main_column_width'] - 5;
			$tech['l_sidebar_width'] = $tech['l_sidebar_width'] - 3;
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 3% 20px 2%;
width:{$tech['main_column_width']}%;
}
#l_sidebar {
float:left;
padding:10px 1% 0 2%;
width:{$tech['l_sidebar_width']}%
}
CSS;
		}
	} else {
		if ($tech['main_column_width'] == 0 && $tech['l_sidebar_width'] != 0 && $tech['r_sidebar_width'] != 0) {
			$tech['main_column_width'] = 96 - ($tech['l_sidebar_width'] + $tech['r_sidebar_width']);
		} elseif ($tech['main_column_width'] == 0) {
			$tech['main_column_width'] = 55;
		}
		if ($tech['l_sidebar_width'] == 0 && $tech['r_sidebar_width'] == 0 && $tech['main_column_width'] != 55) {  
			$tech['l_sidebar_width'] = (98 - $tech['main_column_width']) / 2;
			$tech['r_sidebar_width'] = (98 - $tech['main_column_width']) / 2;
		} elseif ($tech['l_sidebar_width'] == 0 && $tech['r_sidebar_width'] == 0) {
			$tech['l_sidebar_width'] = 22;
			$tech['r_sidebar_width'] = 22;
		} 
		$tech['main_column_width'] = $tech['main_column_width'] - 2;
		$tech['l_sidebar_width'] = $tech['l_sidebar_width'] - 2;
		$tech['r_sidebar_width'] = $tech['r_sidebar_width'] - 2;
		if ($tech['sidebar_pos'] =='Content - Sidebar - Sidebar') {
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']}
}
.narrowcolumn {
float:left;
margin:0 0 0 2%;
padding:0 0 20px 0;
width:{$tech['main_column_width']}%;
}
#l_sidebar {
float:right;
padding:10px 0 0 2%;
width:{$tech['l_sidebar_width']}%
}
#r_sidebar {
float:right;
clear:right;
padding:10px 2% 0 0;
width:{$tech['r_sidebar_width']}%
}
CSS;
		} elseif ($tech['sidebar_pos'] =='Sidebar - Content - Sidebar') { 
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:0 0 20px 0;
width:{$tech['main_column_width']}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 0;
width:{$tech['r_sidebar_width']}%
}
CSS;
$tech['l_sidebar_width'] = $tech['l_sidebar_width'] - 2;
$css_var .= <<<CSS
#l_sidebar {
float:left;
padding:10px 0 0 2%;
width:{$tech['l_sidebar_width']}%
}
CSS;
		} else {
$css_var .= <<<CSS
#page, #header {
width: {$tech['page_width']}{$tech['sign']}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:0 0 20px 0;
width:{$tech['main_column_width']}%;
}
#r_sidebar {
float:left;
padding:10px 2% 0 0;
width:{$tech['r_sidebar_width']}%
}
CSS;
$tech['l_sidebar_width'] = $tech['l_sidebar_width'] - 2;
$css_var .= <<<CSS
#l_sidebar {
float:left;
padding:10px 0 0 2%;
width:{$tech['l_sidebar_width']}%
}
CSS;
		}
	}
$css_var .= <<<CSS
#navmenu ul#nav,#navmenu ul#nav2,#navmenu ul#dropdown,#navmenu ul.menu{
{$tech['nav_align']};
}
CSS;
	if ($tech['nav_button_width'] != 0) { 
$css_var .= <<<CSS
#navmenu ul#nav li, #navmenu ul#admin li, #nav2 li,#dropdown li, #navmenu .menu li{
width: {$tech['nav_button_width']}em;
} 
CSS;
	}
	if ($tech_nav_align_check == "Center") {
$css_var .= <<<CSS
#navwrap {
float:left;
position:relative;
left:50%;
}
ul#admin{
margin-top:30px !important;
}
ul#subnav{
position:relative;
clear:both;
left:-50%;
}
CSS;
	}
	$tech_hwidget_height = $tech['header_height'] - 40;
	switch ($tech['header']){ 
		case "Defined Here": 
$css_var .= <<<CSS
#header {
background:url({$tech['header_image_url']}) no-repeat {$tech['header_v_align']} {$tech['header_align']} {$tech_content_bg_color};
height: {$tech['header_height']}px;
}
#headerr, #headerl{
height: {$tech['header_height']}px;
}
.hleft, .hright {
height: {$tech_hwidget_height}px;
}
CSS;
		break;
		case "Rotate":
$css_var .= <<<CSS
#header {
background:url({$home}/rotate.php) no-repeat {$tech['header_v_align']} {$tech['header_align']} {$tech_content_bg_color};
height: {$tech['header_height']}px;

}#headerr, #headerl{
height: {$tech['header_height']}px;
}
.hleft, .hright {
height: {$tech_hwidget_height}px;
}
CSS;
		break;
		case "Landscape":
$css_var .= <<<CSS
#header {
background:url({$home}/images/headers/{$tech['header']}.jpg) no-repeat {$tech['header_v_align']} {$tech['header_align']} {$tech_content_bg_color};
height: 170px;
}
#headerr, #headerl{
height: 170px;
}
.hleft, .hright {
height: 110px;
}
CSS;
		break;
		case "none":
$css_var .= <<<CSS
#header, #headerr, #headerl {
height: {$tech['header_height']}px;
}
.hleft, .hright {
height: {$tech_hwidget_height}px;
}
CSS;
		break;
		default:
$css_var .= <<<CSS
#header {
background:url({$home}/images/headers/{$tech['header']}.jpg) no-repeat {$tech['header_v_align']} {$tech['header_align']} {$tech_content_bg_color};
height: {$tech['header_height']}px;
}
#headerr, #headerl{
height: {$tech['header_height']}px;
}
.hleft, .hright {
height: {$tech_hwidget_height}px;
}
CSS;
		break;
	}
	
if ($tech['blog_title_box'] == "On") {
$css_var .= <<<CSS
#headerimg {
background-color:#f7f7f7;
-moz-opacity:0.85;
-khtml-opacity:0.85;
opacity:.85;
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.5);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.5);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.5);
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
}
.description {
border-top:1px solid #444444;
}
CSS;
}
$img_path = get_template_directory_uri();
$css_var .= <<<CSS
/*Default Sytle*/
.cufon-loading .blog_title,.cufon-loading .sidebar h2,.cufon-loading h1,.cufon-loading h2,.cufon-loading h3,.cufon-loading h4,.cufon-loading h5,.cufon-loading .sidebar h3,.cufon-loading #footer h2 ,.cufon-loading .post_title {
	visibility: hidden !important;
}
.fontsizeminus{
font-size:8px;
}
.fontreset{
font-size: 12px;
}
.fontsizeplus{
font-size: 18px;
}
#l_sidebar, #content, #r_sidebar { 
padding-top: 30px; 
}
.post_comment_cont{
clear:both;
margin:3px;
padding:5px 0 3px;
}
#crumbs{
font-size:1.2em;
margin: 0px 20px 5px;
}
#crumbs .current{
text-decoration:underline;
}
sub,sup {
font-size:1.1em;
color:#606e79;
}
strong.search-excerpt { 
background: yellow; 
}
.search-terms{
font-style:italic;
}
.squarebox {
width:450px;
background-color:#a4acb3;
border:1px solid #6f7d88;
padding:8px;
}
.squarebox_bright {
width:450px;
background-color:#bec4c8;
border:1px solid #6f7d88;
padding:8px;
}
body {
color:#333;
margin:0;
padding:0;
text-align:center;
}
#page {
border:none;
text-align:left;
min-width:760px;
margin:0 auto 10px;
padding:0;
}
#pagel{
background:transparent url({$img_path}/images/bgl.png) repeat-y left top;
}
#pager {
background:transparent url({$img_path}/images/bgr.png) repeat-y right top;
}
.narrowcolumn .entry,.widecolumn .entry {
line-height:1.3em;
margin-top:4px;
border-bottom-left-radius:5px;
-moz-border-radius-bottomleft:5px;
-webkit-border-bottom-left-radius:5px;
padding:2px 4px 1px;
float:right;
width:100%;
}
.home .narrowcolumn .entry,.home .widecolumn .entry, .archive .entry{
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.page .narrowcolumn .entry,.page .widecolumn .entry{
box-shadow: none !important;
-moz-box-shadow: none !important;
-webkit-box-shadow: none !important;
}
.widecolumn {
line-height:1.6em;
width:80%;
margin:0 auto 0;
padding:20px 0 20px;
}
.narrowcolumn .postmetadata {
text-align:center;
padding-top:5px;
}
.tagcont {
float:left;
width:30%;
margin:2% 1%;
}
.tags {
background-color:#ccc;
text-align:center;
margin:5px auto;
padding:2px;
}
.alt {
background-color:#eee;
border-top:1px solid #ddd;
border-bottom:1px solid #ddd;
margin:0;
padding:10px;
}
#footer {
border:none;
clear:both;
height:auto;
width:100%;
margin:0 0 0 auto;
padding:20px 0 0;
background: transparent url({$img_path}/images/navbarbg.png) repeat-x scroll 0 0;
}
#footermain {
background: transparent url({$img_path}/images/bgbot.png) repeat-x scroll 0 bottom;
}
small {
line-height:1.5em;
padding-left:10px;
}
h1 {
line-height:1.3em;
margin:0;
}
.description {
font-size:1.2em;
text-align:left;
margin:0 15px;
padding:3px;
}
.entry h2 {
line-height: 1.6em
}
.sidebar h2, #footer h2 {
margin:5px 0 0;
padding:0;
}
h3 {
font-size:1.3em;
padding:0;
}
.entry h3 {
line-height: 1.3em;
}
.entry h4 {
font-size: 1.2em;
line-height: 1.2em;
}
.entry h5 {
font-size: 1.1em;
line-height: 1.1em;
}
.entry p a:visited {
text-decoration:underline;
}
ul.comment-preview li {
font-size:.9em;
opacity:.7;
}
ul.comment-preview li:hover{
opacity:1;
}
.commentdiv h2{
color:transparent;
}
.commentdiv {
height:40px;
width:40px;
float:right;
text-align:center;
margin-top:7px;
}
.commentdiv a{
display:block;
padding-top:6px;
width:40px;
height:35px;
font-size:18px;
font-weight:700;
text-decoration:none;
background:url({$img_path}/images/comment2.png) no-repeat top center;
}
.commentdiv span {
font-size:9px;
display:block;
padding-top:6px;
width:40px;
height:35px;
background:url({$img_path}/images/comment2.png) no-repeat top center;
}
.comments-link{
background:transparent url({$img_path}/images/comment.gif) no-repeat scroll left top;
font-size:1.2em;
padding:0 0 0 18px;
}
.comments-link a{
text-decoration:underline;
}
.commentlist cite,.commentlist cite a {
font-weight:700;
font-style:normal;
font-size:1.1em;
}
.commentlist p {
font-weight:400;
line-height:1.5em;
text-transform:none;
margin:10px 5px 10px 0;
}
.author,.bypostauthor {
border-top:1px #000 dotted;
background-color:#ddd;
}
.commentlist ul.children {
padding-left:10px;
}
.commentmetadata {
font-weight:400;
display:block;
margin:0;
}
#respond {
padding-bottom:25px;
}
small,.sidebar ul ul li,.sidebar ul ol li,.nocomments,.postmetadata,blockquote,strike {
color:#777;
}
code {
font:1.1em 'Courier New', Courier, Fixed;
}
pre {
overflow:scroll;
overflow-y:hidden;
}
dd {
margin-left:5px;
font-style:italic;
}
acronym,abbr,span.caps {
letter-spacing:.07em;
cursor:help;
}
#wp-calendar #prev a {
font-size:.9em;
padding-left:10px;
text-align:left;
}
#wp-calendar a {
text-decoration:none;
display:block;
}
#wp-calendar caption {
font-size:1.3em;
text-align:center;
width:100%;
}
#wp-calendar th {
font-style:normal;
text-transform:capitalize;
}
#header {
margin:10px auto 0;
padding:0;
min-width: 760px;
text-align:left;
position:relative;
}
#header_top{
background:transparent url({$img_path}/images/bgtop.png) repeat-x left top;
height: 100%;
}
#headerl{
background:url('{$img_path}/images/bgl.png') repeat-y scroll left top transparent;
width: 100%;
postition:absolute;
left: 0;
top: 0;
}
#headerr{
background:url('{$img_path}/images/bgr.png') repeat-y scroll right top transparent;
width: 100%;
}
.hleft{
float:left;
margin: 5px 3% 5px 10px;
overflow:hidden;
width:20%;
}
.hright{
float:right;
margin: 5px 10px 5px 3%;
overflow: hidden;
width:20%;
}
.hwidget ul {
list-style:none;
padding-left:0;
margin: 2px 3px;
}
.hwidget{
margin: 2px;
padding: 3px;
text-align: left;
}
.navhead h3 {
margin:5px 10px 0;
}
.sidenav .page_item ul, .sidenav ul.children {
display:none;
}
.sidenav .current_page_item ul,.sidenav .current_page_parent ul, .sidenav .current_page_ancestor ul, .sidenav .current-cat ul.children, .sidenav .current-cat-parent ul.children {
display:block !important;
}
.sidenav li.current_page_item a, .sidenav li.current-cat a, .sidenav li.current-menu-item a{
text-decoration: underline;
}
.sidenav li.current_page_item ul a, .sidenav .current-cat ul a{
text-decoration: none;
}
#navmenu {
background:url({$img_path}/images/navbarbg.png) repeat-x;
height:60px;
margin:-30px 0 -20px;
padding: 0 10px;
}
#dropdown, #dropdown ul, .menu, .menu ul {
position:relative; 
z-index:10;
}
#dropdown a, #navmenu .menu a {
display:block; 
padding:3px; 
text-decoration:none;
}
#dropdown li, #navmenu .menu li{
float:left; 
position:relative;
margin-right:2px
}
#dropdown ul ,.menu ul{
position:absolute; 
display:none; 
width:210px; 
left:-1px;
}
#dropdown li ul , #navmenu .menu li ul{ 
width:210px;
padding-left:0;
}
#dropdown li ul a , #navmenu .menu li ul a{
width:202px; 
height:auto; 
float:left;
border:1px solid #D3D3D3;
}
#dropdown li ul li, #navmenu .menu li ul li{
width:210px;
}
#dropdown ul ul,.menu ul ul{
top:auto;
}
#dropdown li ul ul, #navmenu .menu li ul ul{
left:200px; 
margin:0px 0 0 10px;
}
#dropdown li:hover ul ul, #dropdown li:hover ul ul ul, #dropdown li:hover ul ul ul ul, #navmenu .menu li:hover ul ul, #navmenu .menu li:hover ul ul ul, #navmenu .menu li:hover ul ul ul ul {
display:none;
}
#dropdown li:hover ul, #dropdown li li:hover ul, #dropdown li li li:hover ul, #dropdown li li li li:hover ul, #navmenu .menu li:hover ul, #navmenu .menu li li:hover ul, #navmenu .menu li li li:hover ul, #navmenu .menu li li li li:hover ul  {
display:block;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
} 
#nav2 li {
margin-right:25px;
}
#nav2 li, #subnav li {
float:left;
list-style:none;
}
#subnav {
margin:0;
padding-top:5px;
}
#subnav li {
border-right:1px solid #ddd;
padding:0 5px;
font-size:1.1em;
}	
#subnav a, #subnav a:visited {
text-decoration:none;
font-weight:bold;
}
#subnav a:hover, #subnav a:active,#subnav li.current_page_item a,#subnav li.current_page_item a:visited {
text-decoration:underline;
}
#navwrap{
height: 30px;
}
ul#admin {
list-style-type:none;
list-style-image:none;
float:right;
margin:0;
}
ul#nav,#dropdown,#dropdown ul,.menu,.menu ul {
list-style-type:none;
list-style-image:none;
height:30px;
width:100%;
margin:0 auto;
}
ul#nav2{
height:25px;
margin:0 auto;
}
ul#nav, ul#nav2, #dropdown ,.menu{
padding:5px 0 0;
}
#search {
display:block;
float:right;
clear:right;
border-right:none;
font-size:1.3em;
font-weight:bolder;
margin:-80px 10px 0 0;
position: relative;
}
ul#nav li,ul#admin li, #nav2 li {
display:inline;
float:left;
text-align:center;
margin-right:2px;
overflow:hidden;
height:16px;
padding:3px;
}
ul#nav a,ul#admin a, #nav2 a,#nav2 a:visited,#dropdown a,#navmenu .menu a {
text-decoration:none;
font-weight:bolder;
line-height: 16px;
}
ul#nav li, #nav2 li, #dropdown li, #navmenu .menu li{
border-top-right-radius:5px;
border-top-left-radius:5px;
-moz-border-radius-topright:5px;
-moz-border-radius-topleft:5px;
-webkit-border-top-right-radius:5px;
-webkit-border-top-left-radius:5px;
}
#dropdown li ul li,#navmenu .menu li ul li{
border-top-right-radius:0px;
border-top-left-radius:0px;
-moz-border-radius-topright:0px;
-moz-border-radius-topleft:0px;
-webkit-border-top-right-radius:0px;
-webkit-border-top-left-radius:0px;
}
ul#admin li {
border-bottom-right-radius:5px;
border-bottom-left-radius:5px;
-moz-border-radius-bottomright:5px;
-moz-border-radius-bottomleft:5px;
-webkit-border-bottom-right-radius:5px;
-webkit-border-bottom-left-radius:5px;
}
ul#nav li.current_page_item, #dropdown li.current_page_item, #navmenu .menu li.current-menu-item {
border-bottom:1px dotted;
}

.post_title{
letter-spacing:-0.9px;
margin:0;
}
.post {
text-align:justify;
margin:0 0 40px;
float:left;
width:100%;
}
.post small {
padding-top: 4px;
display:block;
}
.post_date {
clear:left;
float:left;
width:40px;
height:40px;
margin:5px 5px 0 0;
background-image: url({$img_path}/images/datebg.png);
}
* html .post_date {
margin:30px 0 0;
}
.date_post {
border-bottom:1px dotted;
clear:left;
float:left;
font-size:16px;
font-weight:800;
text-align:center;
width:40px;
letter-spacing:-1px;
height: 20px;
}
.month_post {
float:left;
clear:left;
width:40px;
font-size:14px;
color:#2C4353;
text-align:center;
padding-bottom:2px;
height: 20px;
}
.heading {
margin-top:20px;
}
.widecolumn .postmetadata {
margin:30px 0;
}
.search .postmetadata {
margin: 5px 0;
}
.narrowcolumn .attachment, .widecolumn .attachment {
text-align:center;
margin:5px 0;
}
.pic_info {
margin:auto;
text-align: left;
}
.pic-previous a{
float:left;
background: url({$img_path}/images/gallery_prev.png) no-repeat scroll left center transparent;
padding-left:40px;
}
.pic-next a{
background: url({$img_path}/images/gallery_next.png) no-repeat scroll right center transparent;
padding-right:40px;
float:right;
}
#pic-navigation{
clear:both;
width: 90%;
margin:auto;
}
#main_image{ 
position:relative
}
#main_image a .pic_info {
display:none;
}
#main_image a:hover .pic_info{
display: block;
padding: 10px 0;
background: #111;
filter:alpha(opacity=75);
opacity:.75;
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)"; /*--IE 8 Transparency--*/
color: #fff;
position: absolute;
padding: 10px;
bottom: 10px;
left: 45%;
border-radius:5px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
}
.postmetadata {
clear:left;
}
p {
margin:5px 5px 1em;
}
#footerdivs {
margin:10px auto 15px;
padding-left:15%;
text-align:left;
}
.footercont {
width:30%;
float:left;
}
.footercont.widgettitle {
margin-top:0;
}
#footer p{
margin:0;
padding:15px 0 20px;
text-align:center;
}
#footer p.credit{
padding:15px 0 10px;
text-align:center;
}
#footer ul,#footer ul li ul li {
list-style-type:none;
list-style-image:none;
padding:0;
margin-left:0;
}
#footer ul.footernav {
margin:-5px 0 0;
padding:0 0 15px;
}
ul.footernav li{
display: inline;
}
h3.comments {
margin:40px auto 20px;
padding:0;
}
.blog_title {
text-align:left;
display:block;
font-weight:700;
text_decoration:none;
}
.blog_title a {
padding:5px;
}
#headerimgwrap {
position: relative;
top: 20%;
}
p img {
max-width:100%;
padding:2px;
}
.wp-caption, .gallery-caption {
background-color:#f7f7f7;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
border:1px solid #444;
text-align:center;
padding:3px;
}
.wp-caption-text {
text-align:center;
line-height:1.1em;
}
.wp-caption img {
box-shadow: none;
-moz-box-shadow: none;
-webkit-box-shadow:none;
}
.aligncenter {
display:block;
margin-left:auto;
margin-right:auto;
text-align:center;
}
.wp-post-image, .alignleft {
float:left;
margin:0 6px;
}
.alignright {
float:right;
margin:0 6px;
}
.avatar {
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.avatar_cont {
float:left;
margin:0 5px 0 0;
}
.entry ol {
margin:0;
padding:0 0 0 35px;
}
.postmetadata ul,.postmetadata li {
display:inline;
list-style-type:none;
list-style-image:none;
}
.sidebar ul li, ul.comment-preview li {
list-style-type:none;
list-style-image:none;
margin-bottom:8px;
}
.sidebar ul p,.sidebar ul select {
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 0 8px;
}
.sidebar ul ul,.sidebar ul ol {
margin:5px 0 0 10px;
}
.sidebar ul ul ul,.sidebar ul ol {
margin:0 0 0 10px;
}
ol li,.sidebar ul ol li {
list-style:decimal outside;
}
.sidebar ul ul li,.sidebar ul ol li {
margin:3px 0 0;
padding:0;
}
.sidebar_icon {
text-align:right;
padding-right:5px;
}
#loginform {
font-size:.9em;
padding:0 3px;
}
#user_login,#user_pass {
width:90px;
background-color: #f7f7f7;
}
input.text {
font-size:1.2em;
}
#searchform {
text-align:left;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 5px 0 0;
}
#searchform #s,#user_login,#user_pass {
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
}
#searchform #s {
width:150px;
margin-bottom:6px;
padding:3px;
}
#searchsubmit,#catsubmit,#wp-submit {
display:inline;
background-color:#EEEDED;
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:1px;
}
#searchsubmit:hover,#catsubmit:hover,#wp-submit:hover {
display:inline;
color:#f7f7f7;
border:1px #ccc solid;
border-left-color:#999;
border-top-color:#999;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:1px;
}
.postform {
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
}
#commentform input {
width:170px;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 5px 1px 0;
padding:2px;
}
#commentform textarea {
width:100%;
border-radius:5px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
padding:2px;
}
#commentform #submit {
float:right;
border:2px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:0;
}
#commentform #submit:hover {
float:right;
border:2px #ccc solid;
border-left-color:#999;
border-top-color:#999;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:0;
}
.commentlist,.trackback {
text-align:justify;
padding:0;
}
.trackback li {
list-style:none;
border-bottom:1px solid #ddd;
margin:2px 0;
padding:2px 10px;
}
.commentlist li {
list-style:none;
margin:15px 0 3px;
padding:5px 10px 3px;
}
#commentform p {
margin:5px 0;
}
.nocomments {
text-align:center;
margin:0;
padding:0;
}
.techozoic_rss,#rss {
background:url({$img_path}/images/syndicatebg.png) no-repeat top center;
}
acronym,abbr {
border-bottom:1px dashed #999;
}
blockquote {
padding-left:20px;
border-left:5px solid #ddd;
margin:15px 30px 0 10px;
}
blockquote cite {
display:block;
margin:5px 0 0;
}
a img {
border:none;
}
.navigation {
display:block;
text-align:center;
margin-top:10px;
margin-bottom:10px;
}
.top {
float:right;
border-bottom-left-radius:3px;
border-bottom-right-radius:3px;
-moz-border-radius-bottomright:3px;
-moz-border-radius-bottomleft:3px;
-webkit-border-bottom-left-radius:3px;
-webkit-border-bottom-right-radius:3px;
box-shadow:2px 2px 4px rgba(0, 0, 0, 0.4);
-moz-box-shadow:2px 2px 4px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
padding:2px 4px;
}
.top img{
opacity:.5;
}
.top img:hover{
opacity: 1;
box-shadow:1px 1px 3px rgba(0, 0, 0, 0.4);
-moz-box-shadow:1px 1px 3px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 1px 1px 3px rgba(0,0,0,0.4);
}
.toppost {
float:right;
margin-top:-15px;
}
#wp-calendar {
empty-cells:show;
width:155px;
margin:10px auto 0;
}
#wp-calendar #next a {
padding-right:10px;
text-align:right;
}
#wp-calendar td {
text-align:center;
padding:3px 0;
}
#wp-calendar td.pad:hover {
background-color:#fff;
}
h1,h2,h3,.commentlist li,.trackback li {
font-weight:700;
}
h1,h1 a,h1 a:hover,h1 a:visited,h2,h2 a,h2 a:hover,h2 a:visited,h3,h3 a,h3 a:hover,h3 a:visited,.sidebar h2,#wp-calendar caption,cite,.blog_title a:visited {
text-decoration:none;
}
.commentlist li.pingback {
display:none;
}
.sidebar form {
margin:0;
}
.entry img,.entrytext img {
border:1px solid #ccc;
padding:4px;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.entry ol li,.sidebar ul,.sidebar ul ol {
margin:0;
padding:0;
}
.sidebar .about_icons li{
display:inline;
margin:3px;
}
.entry form,.center {
text-align:center;
}
.wp-caption img {
box-shadow: none;
-moz-box-shadow: none;
-webkit-box-shadow:none;
}
select {
width:140px;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
}
*html .post_date {background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader( sizingMethod='scale', src='{$img_path}/images/datebg.png');}
*html .commentdiv a{background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader( sizingMethod='scale', src='{$img_path}/images/comment.png');}
/* ThickBox Styles */
#TB_window {font: 12px Arial, Helvetica, sans-serif;color: #333;}#TB_secondLine {font: 10px Arial, Helvetica, sans-serif;color:#666;}#TB_window a:link {color: #666;}#TB_window a:visited {color: #666;}#TB_window a:hover {color: #000;}#TB_window a:active {color: #666;}#TB_window a:focus{color: #666;}#TB_overlay {position: fixed;z-index:100;top: 0px;left: 0px;height:100%;width:100%;}.TB_overlayMacFFBGHack {background: url(macFFBgHack.png) repeat;}.TB_overlayBG {background-color:#000;filter:alpha(opacity=75);-moz-opacity: 0.75;opacity: 0.75;}* html #TB_overlay { position: absolute; height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}#TB_window {position: fixed;background: #ffffff;z-index: 102;color:#000000;display:none;border: 4px solid #525252;text-align:left;top:50%;left:50%;}* html #TB_window { position: absolute;margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');}#TB_window img#TB_Image {display:block;margin: 15px 0 0 15px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;border-top: 1px solid #666;border-left: 1px solid #666;}#TB_caption{height:25px;padding:7px 30px 10px 25px;float:left;}#TB_closeWindow{height:25px;padding:11px 25px 10px 0;float:right;}#TB_closeAjaxWindow{padding:7px 10px 5px 0;margin-bottom:1px;text-align:right;float:right;}#TB_ajaxWindowTitle{float:left;padding:7px 0 5px 10px;margin-bottom:1px;}#TB_title{background-color:#e8e8e8;height:27px;}#TB_ajaxContent{clear:both;padding:2px 15px 15px 15px;overflow:auto;text-align:left;line-height:1.4em;}#TB_ajaxContent.TB_modal{padding:15px;}#TB_ajaxContent p{padding:5px 0px 5px 0px;}#TB_load{position: fixed;display:none;height:13px;width:208px;z-index:103;top: 50%;left: 50%;margin: -6px 0 0 -104px; /* -height/2 0 0 -width/2 */}* html #TB_load {position: absolute;margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');}#TB_HideSelect{z-index:99;position:fixed;top: 0;left: 0;background-color:#fff;border:none;filter:alpha(opacity=0);-moz-opacity: 0;opacity: 0;height:100%;width:100%;}* html #TB_HideSelect {position: absolute; height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}#TB_iframeContent{clear:both;border:none;margin-bottom:-1px;margin-top:1px; _margin-bottom:1px;}
CSS;

/*Custom Styles Defined In Options*/
$css_var .= $tech['custom_styles'];

$tech_style_contents = $css_var;
if ($existing = get_option('tech_styles')){
	update_option('tech_styles',$tech_style_contents);
} else {
	add_option('tech_styles',$tech_style_contents);
}
?>